#!/usr/bin/env bash
set -e

if [ -z "$CODESPACES" ] && [ -z "$CODESPACE_NAME" ]; then
    echo "This script is intended for GitHub Codespaces only."
    exit 1
fi

# Option 1: All-in-one via composer
if composer run dev; then
    echo "Development servers started via composer script."
else
    echo "Falling back to manual start."
    echo "Starting Laravel backend..."
    php artisan serve --host=0.0.0.0 --port=8000 &
    echo "Starting Vite frontend..."
    npm run dev
fi

# Make Vite port public in Codespaces (if gh CLI is available)
if command -v gh &> /dev/null && [ -n "$CODESPACES" ]; then
    echo "Setting Codespace port 5173 to public..."
    gh codespace ports visibility 5173:public -c "$CODESPACE_NAME" || true
fi