#!/usr/bin/env bash
set -e

if [ -z "$CODESPACES" ] && [ -z "$CODESPACE_NAME" ]; then
    echo "This script is intended for GitHub Codespaces only."
    exit 1
fi

echo "Installing Node.js dependencies..."
npm install

echo "Building frontend assets..."
npm run build
