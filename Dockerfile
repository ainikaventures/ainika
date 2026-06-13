# ainika.xyz — mostly-static marketing site + a PHP mail() contact form.
# Apache + PHP serving plain HTTP on 0.0.0.0:8080 for Coolify/Traefik
# (the proxy terminates TLS; we never publish a host port).
FROM php:8.3-apache

# Apache: listen on 8080 (host 8000 is reserved by Coolify), honor .htaccess,
# enable the modules .htaccess uses, and log to stdout/stderr (stateless).
RUN set -eux; \
    sed -ri 's/^Listen 80$/Listen 8080/' /etc/apache2/ports.conf; \
    sed -ri 's!<VirtualHost \*:80>!<VirtualHost *:8080>!' /etc/apache2/sites-available/000-default.conf; \
    sed -ri 's!AllowOverride None!AllowOverride All!g' /etc/apache2/apache2.conf; \
    a2enmod rewrite headers expires deflate; \
    { echo 'ErrorLog /dev/stderr'; echo 'CustomLog /dev/stdout combined'; } > /etc/apache2/conf-available/log-stdout.conf; \
    a2enconf log-stdout

# curl for the healthcheck; msmtp gives PHP mail() an SMTP sendmail (the contact
# form). msmtp is configured at runtime from SMTP_* env (see docker-entrypoint.sh);
# with no SMTP_* set the form still renders, it just can't send until creds exist.
RUN set -eux; \
    apt-get update; \
    apt-get install -y --no-install-recommends curl msmtp msmtp-mta ca-certificates; \
    rm -rf /var/lib/apt/lists/*; \
    echo 'sendmail_path = "/usr/bin/msmtp -C /tmp/msmtprc -t"' > /usr/local/etc/php/conf.d/zz-mail.ini

COPY . /var/www/html/
RUN set -eux; \
    rm -f /var/www/html/Dockerfile /var/www/html/.dockerignore /var/www/html/docker-entrypoint.sh /var/www/html/DEPLOY.md; \
    printf 'OK' > /var/www/html/health; \
    chown -R www-data:www-data /var/www/html /var/run/apache2 /var/log/apache2; \
    chmod -R g+rwX /var/run/apache2

COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

USER www-data
EXPOSE 8080
HEALTHCHECK --interval=15s --timeout=5s --start-period=10s --retries=3 \
  CMD curl -fsS http://127.0.0.1:8080/health >/dev/null || exit 1
ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["apache2-foreground"]
