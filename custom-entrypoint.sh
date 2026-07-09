#!/bin/bash
set -e

# Dismod and enmod MPM (Fix for Railway Apache MPM crash)
a2dismod mpm_event || true
a2enmod mpm_prefork || true

# Call the original entrypoint
exec docker-entrypoint.sh "$@"
