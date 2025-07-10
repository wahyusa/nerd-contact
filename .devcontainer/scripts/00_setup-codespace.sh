#!/usr/bin/env bash
set -e

SCRIPTS=(
  "01-install-php.sh"
  "02-set-php-default.sh"
  "03-install-composer.sh"
  "04-laravel-init.sh"
  "05-database-setup.sh"
  "06-frontend-setup.sh"
  "07-laravel-codespace-config.sh"
  "08-start-dev.sh"
)

for script in "${SCRIPTS[@]}"; do
  if [[ -x "$script" ]]; then
    echo "========================================"
    echo "Running $script"
    echo "========================================"
    ./"$script"
  else
    echo "Script $script not found or not executable, skipping."
  fi
done
