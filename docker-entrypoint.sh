#!/bin/sh
# Wire PHP mail() to an SMTP relay for the contact form when SMTP_* is provided.
# No SMTP_HOST -> no msmtp config -> mail() fails gracefully (form shows an error).
set -e

if [ -n "${SMTP_HOST:-}" ]; then
  cat > /tmp/msmtprc <<EOF
defaults
auth on
tls on
tls_starttls ${SMTP_STARTTLS:-on}
logfile -
account default
host ${SMTP_HOST}
port ${SMTP_PORT:-587}
from ${SMTP_FROM:-noreply@ainika.xyz}
user ${SMTP_USER:-}
password ${SMTP_PASS:-}
EOF
  chmod 600 /tmp/msmtprc
fi

exec "$@"
