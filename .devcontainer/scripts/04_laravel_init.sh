#!/usr/bin/env bash
set -e

if [ -z "$CODESPACES" ] && [ -z "$CODESPACE_NAME" ]; then
    echo "This script is intended for GitHub Codespaces only."
    exit 1
fi

# Fix Xdebug config to suppress step debug warnings
XDEBUG_INI="/usr/local/etc/php/conf.d/xdebug.ini"
if grep -q "xdebug.mode" "$XDEBUG_INI"; then
    sed -i 's/^xdebug.mode=.*/xdebug.mode=develop,coverage/' "$XDEBUG_INI"
else
    echo "xdebug.mode=develop,coverage" >> "$XDEBUG_INI"
fi
if grep -q "xdebug.start_with_request" "$XDEBUG_INI"; then
    sed -i 's/^xdebug.start_with_request=.*/xdebug.start_with_request=no/' "$XDEBUG_INI"
else
    echo "xdebug.start_with_request=no" >> "$XDEBUG_INI"
fi

echo "Installing composer dependencies..."

composer install

echo "Running composer scripts for Laravel initial setup..."
composer run post-root-package-install
composer run post-create-project-cmd

if [ -f .env ]; then
    echo "Configuring Codespace URLs in .env..."
    sed -i "s|APP_URL=.*|APP_URL=https://${CODESPACE_NAME}-8000.${GITHUB_CODESPACES_PORT_FORWARDING_DOMAIN}|" .env
    if ! grep -q "VITE_DEV_SERVER_URL" .env; then
        echo "VITE_DEV_SERVER_URL=https://${CODESPACE_NAME}-5173.${GITHUB_CODESPACES_PORT_FORWARDING_DOMAIN}" >> .env
    else
        sed -i "s|VITE_DEV_SERVER_URL=.*|VITE_DEV_SERVER_URL=https://${CODESPACE_NAME}-5173.${GITHUB_CODESPACES_PORT_FORWARDING_DOMAIN}|" .env
    fi
else
    echo ".env file not found! Please ensure Laravel project is properly initialized."
    exit 1
fi
