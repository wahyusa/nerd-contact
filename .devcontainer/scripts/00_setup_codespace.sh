#!/usr/bin/env bash
set -e

# Get the directory where this script is located
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"

SCRIPTS=(
  "01_install_php.sh"
  "02_set_php_default.sh"
  "03_install_composer.sh"
  "04_laravel_init.sh"
  "05_database_setup.sh"
  "06_frontend_setup.sh"
  "07_laravel_codespace_config.sh"
  "99_start_dev_server.sh"
)

for script in "${SCRIPTS[@]}"; do
  script_path="$SCRIPT_DIR/$script"
  if [[ -x "$script_path" ]]; then
    echo "========================================"
    echo "Running $script"
    echo "========================================"
    "$script_path"
  else
    echo "Script $script not found or not executable, skipping."
  fi
done
