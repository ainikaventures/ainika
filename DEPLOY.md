# Deploying ainika.xyz on Coolify

Mostly-static marketing site plus a single PHP `mail()` contact form
(`index.php`). Served by Apache + PHP in one container.

- **Build:** `Dockerfile` (php:8.3-apache), no build step.
- **Exposed port:** `8080` (internal; Traefik terminates TLS).
- **Health path:** `GET /health` → `200` (static `OK`).
- **Process:** one web container (`apache2-foreground`). No worker, no DB, no Redis.
- **Persistent paths:** none — fully stateless.
- **Domain:** `ainika.xyz` (+ `www.ainika.xyz`), Cloudflare-proxied with a CF Origin cert.

## Contact form email

`index.php` sends enquiries to `hello@ainika.xyz` via PHP `mail()`. The image
ships `msmtp`; set these env vars in Coolify to enable delivery (otherwise the
form renders but submission shows a send error):

| Var | Example |
|---|---|
| `SMTP_HOST` | `smtp.gmail.com` |
| `SMTP_PORT` | `587` |
| `SMTP_USER` | sending account |
| `SMTP_PASS` | app password / API key |
| `SMTP_FROM` | `noreply@ainika.xyz` |
