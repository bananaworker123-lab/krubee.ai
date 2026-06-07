#!/bin/bash
# Fix MPM conflict before starting apache
a2dismod mpm_event mpm_worker 2>/dev/null || true
a2enmod mpm_prefork 2>/dev/null || true

# Run original WordPress entrypoint
exec docker-entrypoint.sh apache2-foreground
