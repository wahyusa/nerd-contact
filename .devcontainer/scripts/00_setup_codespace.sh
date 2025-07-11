#!/usr/bin/env bash
set -e

# Get the directory where this script is located
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"

SCRIPTS=(
  "04_laravel_init.sh"
  "05_database_setup.sh"
  "06_frontend_setup.sh"
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
