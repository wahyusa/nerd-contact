# Nerd Contact

Contact farming for nerd 🤓

Add and list people you meet or plan to meet and create your own strategy on how to approach them uniquely based on their interest and zodiac.

But remember to just enjoy your life.

### Troubleshooting

If you encounter issues:

1. **URLs still pointing to localhost**:

    ```bash
    php artisan config:clear
    php artisan ziggy:generate
    # Restart Laravel server
    ```

2. **CORS errors between Laravel and Vite**:

    - The `vite.config.ts` should auto-configure CORS
    - Restart both Laravel and Vite servers

3. **WebSocket connection errors**:
    - Ensure both servers are running
    - Check that Codespace ports 8000 and 5173 are forwardediquely based on their interest and zodiac.

## Codespace Installation (New Instance)

Follow these steps to set up the Laravel 12 development environment in a fresh GitHub Codespace:

### 1. Install PHP 8.3 and Required Extensions

```bash
# Update package list
sudo apt update

# Install PHP 8.3 and essential extensions for Laravel
sudo apt install -y php8.3 php8.3-cli php8.3-fpm php8.3-mysql php8.3-sqlite3 php8.3-xml php8.3-mbstring php8.3-curl php8.3-zip php8.3-gd php8.3-intl php8.3-bcmath php8.3-ctype php8.3-fileinfo php8.3-tokenizer
```

### 2. Configure PHP as Default

```bash
# Add PHP to PATH permanently
echo 'export PATH="/usr/bin:$PATH"' >> ~/.bashrc

# Reload bashrc
source ~/.bashrc

# Verify PHP installation
php --version
```

### 4. Install Composer

```bash
# Download and install Composer
curl -sS https://getcomposer.org/installer | php

# Move to global location
sudo mv composer.phar /usr/local/bin/composer
sudo chmod +x /usr/local/bin/composer

# Verify Composer installation
composer --version
```

### 5. Install Laravel Dependencies

```bash
# Install PHP dependencies
composer install
```

### 6. Configure Environment

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Create SQLite database file
touch database/database.sqlite
```

**Important for GitHub Codespace**: Update your `.env` file to use the correct Codespace URLs:

You can do this automatically with this command:

```bash
# Auto-configure Codespace URLs
sed -i "s|APP_URL=.*|APP_URL=https://${CODESPACE_NAME}-8000.${GITHUB_CODESPACES_PORT_FORWARDING_DOMAIN}|" .env
echo "VITE_DEV_SERVER_URL=https://${CODESPACE_NAME}-5173.${GITHUB_CODESPACES_PORT_FORWARDING_DOMAIN}" >> .env
```

Or manually edit `.env` file and update these values:

```bash
APP_URL=https://YOUR_CODESPACE_NAME-8000.app.github.dev
VITE_DEV_SERVER_URL=https://YOUR_CODESPACE_NAME-5173.app.github.dev
```

For example, if your codespace name is `vigilant-train-vp5j6544jxjfxqxg`:

```bash
APP_URL=https://vigilant-train-vp5j6544jxjfxqxg-8000.app.github.dev
VITE_DEV_SERVER_URL=https://vigilant-train-vp5j6544jxjfxqxg-5173.app.github.dev
```

This ensures Laravel and Vite generate correct URLs for your Codespace environment.

### 7. Setup Database

```bash
# Run database migrations
php artisan migrate

# Seed database with sample data
php artisan db:seed
```

### 8. Install Frontend Dependencies

```bash
# Install Node.js packages
npm install

# Build frontend assets
npm run build
```

### 9. Configure Laravel for Codespace

**Important**: Configure Laravel to work properly with Codespace's proxy system:

```bash
# Clear any existing configuration cache
php artisan config:clear
```

Add proxy trust configuration and URL forcing for Codespace environment. The project is already configured with:

- **Proxy Trust**: `bootstrap/app.php` trusts all proxies for Codespace
- **URL Forcing**: `AppServiceProvider.php` forces correct HTTPS URLs when in Codespace
- **Vite Configuration**: `vite.config.ts` auto-detects Codespace and configures CORS/HMR

### 10. Generate Route Configuration

```bash
# Generate Ziggy routes for frontend
php artisan ziggy:generate
```

### 11. Start Development Servers

```bash
# Start Laravel server (accessible in Codespace)
php artisan serve --host=0.0.0.0 --port=8000
```

Your Laravel 12 application should now be running and accessible at the Codespace URL on port 8000!

### Development Commands

```bash
# For development with hot reloading (run in separate terminal)
npm run dev
# This will start Vite dev server on port 5173
# Codespace will make it available at: https://your-codespace-5173.app.github.dev/

# Run tests
php artisan test
# or
vendor/bin/pest

# Access Laravel Tinker
php artisan tinker

# Run additional migrations (if needed)
php artisan migrate

# Refresh database with fresh seed data
php artisan migrate:fresh --seed
```

### Pre-Commit Hooks

This project uses [Husky](https://typicode.github.io/husky/) to run pre-commit hooks that ensure code quality before each commit. The hooks mirror the same linting and testing commands used in GitHub Actions.

**What runs before each commit:**

1. **Lint-staged**: Runs formatting and linting only on staged files

    - PHP files: `vendor/bin/pint` (Laravel Pint code formatter)
    - Frontend files: `prettier --write` and `eslint --fix`

2. **Build & Test**: Ensures the build passes and all tests are green
    - `npm run build` (Vite production build)
    - `./vendor/bin/pest --no-coverage` (PHPUnit tests via Pest)

**Manual commands:**

```bash
# Run pre-commit hooks manually
npm run pre-commit

# Run only lint-staged (format/lint staged files)
npx lint-staged

# Run individual linting commands
vendor/bin/pint                # Format PHP files
npm run format                 # Format frontend files
npm run lint                   # Lint frontend files

# Bypass pre-commit hooks (use sparingly)
git commit --no-verify -m "commit message"
```

**Setup (already configured):**

The pre-commit hooks are automatically set up when you run `npm install` due to the `prepare` script in `package.json`. If you need to manually initialize:

```bash
npx husky init
```

### Development Workflow in Codespace

1. **Terminal 1**: Run the Laravel server
    ```bash
    php artisan serve --host=0.0.0.0 --port=8000
    ```
2. **Terminal 2**: Run Vite dev server for hot reloading
    ```bash
    npm run dev
    ```

Your application will be available at:

- **Laravel App**: `https://your-codespace-8000.app.github.dev/`
- **Vite Dev Server**: `https://your-codespace-5173.app.github.dev/` (for assets)

**Note**: The `vite.config.ts` is automatically configured to:

- Detect Codespace environment and use correct URLs
- Handle CORS between Laravel (port 8000) and Vite (port 5173) domains
- Configure HMR for live reloading in Codespace

### Verification

After setup, you should have:

- ✅ PHP 8.3.23 with all required extensions
- ✅ Composer 2.8.9+
- ✅ Laravel 12 framework installed
- ✅ SQLite database with sample data (100 contacts, zodiac signs)
- ✅ Vue.js + Inertia.js frontend built
- ✅ Development server running
- ✅ Correct Codespace URLs configured
- ✅ Proxy trust and URL forcing configured
- ✅ CORS and HMR working properly

### Key Configuration Files

The following files are automatically configured for Codespace:

- **`vite.config.ts`**: Auto-detects Codespace, configures CORS, HMR, and proper URLs
- **`bootstrap/app.php`**: Trusts proxies for correct URL detection
- **`app/Providers/AppServiceProvider.php`**: Forces HTTPS and correct URLs in Codespace

## Usage

**Note**: Replace `localhost` with your actual Codespace URL.

### Basic

https://localhost/api/contacts
https://localhost/api/zodiacs
https://localhost/api/contacts-stats

### Search

https://localhost/api/contacts?search=john
https://localhost/api/contacts?search=doe
https://localhost/api/contacts?search=gmail

### Filter

https://localhost/api/contacts?tag=nerd
https://localhost/api/contacts?tag=friend
https://localhost/api/contacts?zodiac=1
https://localhost/api/contacts?favorites=true

### Pagination

https://localhost/api/contacts?page=2
https://localhost/api/contacts?per_page=5
https://localhost/api/contacts?page=2&per_page=10

### Sorting

https://localhost/api/contacts?sort_by=last_name&sort_order=desc
https://localhost/api/contacts?sort_by=created_at&sort_order=desc
https://localhost/api/contacts?sort_by=email&sort_order=asc

### Combined

https://localhost/api/contacts?search=john&tag=nerd&sort_by=first_name
https://localhost/api/contacts?zodiac=1&per_page=5&sort_order=desc
