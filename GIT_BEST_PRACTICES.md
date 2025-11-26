# WordPress Git Version Control Best Practices

A guide for learning and safely sharing WordPress projects across local machines while maintaining security and portability.

---

## Table of Contents

1. [Repository Structure](#repository-structure)
2. [What to Track (Commit)](#what-to-track-commit)
3. [What to Ignore (.gitignore)](#what-to-ignore-gitignore)
4. [Security Best Practices](#security-best-practices)
5. [Local Setup & Database](#local-setup--database)
6. [Workflow for Multiple Local Machines](#workflow-for-multiple-local-machines)
7. [Deployment Checklist](#deployment-checklist)

---

## Repository Structure

Organize your WordPress project clearly:

```
three-hours-office/
├── app/
│   └── public/              # WordPress root (wp-config.php, wp-content, wp-admin, etc.)
├── conf/                    # Configuration for containers (nginx, PHP, MySQL)
├── logs/                    # Log files (ignored)
├── sql/                     # Database backups/schemas (optional tracking)
├── .gitignore              # Ignore rules
├── .env.example            # Template for environment variables
├── GIT_BEST_PRACTICES.md   # This file
└── SETUP.md                # Local setup instructions
```

---

## What to Track (Commit)

### ✅ DO COMMIT

1. **Custom Theme Files** (`app/public/wp-content/themes/tho/`)
   - `style.css`
   - `functions.php`
   - `index.php`
   - Custom JS/CSS files
   - `screenshot.png`
   - Template files (page, single, archive, etc.)

2. **Custom Plugin Code** (`app/public/wp-content/plugins/your-custom-plugins/`)
   - Only your custom, non-third-party plugins
   - Keep each plugin in its own folder

3. **Configuration Files** (non-sensitive)
   - `.htaccess` (if using Apache)
   - `wp-cli.yml` (WP-CLI config)
   - `composer.json` / `composer.lock` (if using Composer for dependencies)

4. **Documentation**
   - `README.md` (project overview)
   - `SETUP.md` (local setup instructions)
   - `.env.example` (template, not actual values)

5. **Build & Development Files**
   - `package.json` / `package-lock.json` (frontend dependencies)
   - Webpack/Vite configs
   - Gulp/Grunt configs

---

## What to Ignore (.gitignore)

### ❌ DO NOT COMMIT

Your `.gitignore` should exclude:

```
# WordPress Core (if committing full WP, you may track it; for learning, ignore)
app/public/wp-admin/
app/public/wp-includes/
app/public/*.php          # wp-config.php, wp-load.php, etc.

# Third-party plugins and themes
app/public/wp-content/plugins/*/  # EXCEPT your custom ones
app/public/wp-content/themes/*/   # EXCEPT your custom theme

# User uploads
app/public/wp-content/uploads/

# Database
sql/local.sql
*.sql
*.sqlite

# Dependencies
**/vendor/
**/node_modules/
/composer.phar

# Environment & Secrets
.env
.env.local
.env.*.local
app/public/wp-config.php

# OS & Editor
.DS_Store
Thumbs.db
.vscode/
.idea/
*.sublime-project

# Logs & Temp
logs/
*.log
.phpunit.result.cache
```

**Current `.gitignore` in your repo already covers most of this!**

---

## Security Best Practices

### 1. Never Commit Secrets

**❌ NEVER commit:**
- `wp-config.php` (contains DB password, auth keys)
- `.env` files with real credentials
- Database dumps with user data

**✅ DO create templates:**

Create `app/public/wp-config-sample.php`:
```php
<?php
/**
 * WordPress Configuration File - TEMPLATE
 * Copy this to wp-config.php and fill in your local values
 */

// ** MySQL settings ** //
define( 'DB_NAME', 'local_db_name' );
define( 'DB_USER', 'local_db_user' );
define( 'DB_PASSWORD', 'local_db_password' );
define( 'DB_HOST', 'localhost' );

// ** Authentication Unique Keys and Salts ** //
// Generate from: https://api.wordpress.org/secret-key/1.1/salt/
define('AUTH_KEY',         'put your unique phrase here');
define('SECURE_AUTH_KEY',  'put your unique phrase here');
define('LOGGED_IN_KEY',    'put your unique phrase here');
define('NONCE_KEY',        'put your unique phrase here');
// ... other constants

// ** WordPress Database Table prefix ** //
$table_prefix = 'wp_';

// ** For local development ** //
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );

// ** Absolute path to the WordPress directory. ** //
if ( ! defined( 'ABSPATH' ) ) {
    define( 'ABSPATH', __DIR__ . '/' );
}
```

### 2. Use `.env.example` for Configuration Template

Create `.env.example` in the repo root:
```env
# Database Configuration
DB_NAME=wordpress_local
DB_USER=root
DB_PASSWORD=
DB_HOST=localhost

# WordPress Debug
WP_DEBUG=true
WP_ENV=local

# Site URLs (change per machine)
WP_HOME=http://three-hours-office.local
WP_SITEURL=http://three-hours-office.local/app/public
```

Then each developer creates their own `.env` (ignored by `.gitignore`).

### 3. Credentials in Comments

Document in `SETUP.md` what credentials are needed, but don't include actual values:
```markdown
## Database Setup

1. Create a database in MySQL named `wordpress_local`
2. Update `wp-config.php` with your local database credentials
3. Ensure MySQL user has full privileges on the database
```

### 4. Git Credentials

Never use git to authenticate—use SSH keys or personal access tokens:
```bash
# Generate SSH key (if you don't have one)
ssh-keygen -t ed25519 -C "your-email@example.com"

# Add to GitHub/GitLab in settings, then clone via SSH
git clone git@github.com:arif362/three-hours-office.git
```

---

## Local Setup & Database

### Database Workflow

**For Sharing Code (Best Practice):**

1. **Export database schema only** (no data):
   ```bash
   mysqldump --no-data -u root -p wordpress_local > sql/schema.sql
   ```
   Commit `sql/schema.sql` to the repo.

2. **Each developer imports the schema**:
   ```bash
   mysql -u root -p wordpress_local < sql/schema.sql
   ```

3. **Each developer populates with test data**:
   - Use WordPress admin to create test posts/pages/users locally
   - OR use a shared anonymized database dump for learning (without real user data)

4. **Document setup in SETUP.md**:
   ```markdown
   ## Initial Setup on New Machine

   1. Clone the repository
   2. Copy `.env.example` to `.env` and update with local values
   3. Copy `app/public/wp-config-sample.php` to `app/public/wp-config.php`
   4. Update database credentials in `wp-config.php`
   5. Create database: `mysql -u root -e "CREATE DATABASE wordpress_local"`
   6. Import schema: `mysql -u root wordpress_local < sql/schema.sql`
   7. Run WordPress setup (visit http://three-hours-office.local/app/public/wp-admin/install.php)
   8. Install composer/npm deps (if applicable)
   9. Activate custom theme and plugins
   ```

---

## Workflow for Multiple Local Machines

### Machine A (Your Main PC)

```bash
# 1. Make changes to your custom theme
# Edit: app/public/wp-content/themes/tho/style.css, functions.php, etc.

# 2. Test locally, then commit
git add app/public/wp-content/themes/tho/
git add app/public/wp-content/plugins/your-custom-plugin/
git commit -m "feat: add custom theme styling and plugin functionality"

# 3. Push to repository
git push origin main
```

### Machine B (Second PC - Your Learning Environment)

```bash
# 1. Clone the repository
git clone https://github.com/arif362/three-hours-office.git
cd three-hours-office

# 2. Set up local environment
cp .env.example .env
# Edit .env with local database credentials

cp app/public/wp-config-sample.php app/public/wp-config.php
# Edit wp-config.php

# 3. Create database and import schema
mysql -u root -e "CREATE DATABASE wordpress_local"
mysql -u root wordpress_local < sql/schema.sql

# 4. Pull latest changes
git pull origin main

# 5. Run WordPress installer (for fresh setup)
# Visit: http://three-hours-office.local/app/public/wp-admin/install.php

# 6. Activate your custom theme
# (via WordPress admin)
```

### Syncing Between Machines

```bash
# On Machine B, pull latest changes
git pull origin main

# Your custom theme and plugins are now updated
# WordPress content (posts, pages) stay local and aren't synced

# If you make changes on Machine B
git add app/public/wp-content/themes/tho/
git commit -m "refactor: improve theme responsiveness"
git push origin main

# Back on Machine A, pull the changes
git pull origin main
```

---

## Deployment Checklist

When you're ready to move code to production or another environment:

### Before Committing

- [ ] Remove debug info: `WP_DEBUG` set to `false` in `wp-config.php`
- [ ] No hardcoded database credentials in code
- [ ] No sensitive API keys in theme/plugin files
- [ ] Test theme and plugins on a fresh WP installation
- [ ] Check for large binary files (images, videos)—use `.gitattributes` if needed

### Pre-Push Checklist

```bash
# Review changes
git status
git diff --cached

# Ensure no sensitive files are staged
grep -r "password" app/public/wp-content/themes/tho/  # Should return nothing

# Check for accidentally committed config files
git ls-files | grep -E "(wp-config|\.env)"  # Should be empty
```

### Git Hooks (Optional)

Create `.git/hooks/pre-commit` to prevent accidental commits:

```bash
#!/bin/bash
# Prevent committing sensitive files

if git diff --cached --name-only | grep -E "wp-config|\.env"; then
    echo "❌ Error: wp-config.php or .env files should not be committed!"
    exit 1
fi
```

Make it executable:
```bash
chmod +x .git/hooks/pre-commit
```

---

## Summary: Your Current Setup

✅ **Already in place:**
- Custom theme tracked: `app/public/wp-content/themes/tho/`
- `.gitignore` created with WordPress ignores
- Theme header info added

✅ **To add for completeness:**
1. Create `app/public/wp-config-sample.php` from `wp-config.php`
2. Create `.env.example` template
3. Create `SETUP.md` with local setup instructions
4. Export and commit `sql/schema.sql` (or `sql/schema-only.sql`)
5. Add theme `screenshot.png` (WordPress requirement)

✅ **Branch strategy (recommended):**
- Use `main` for stable, tested code
- Create feature branches: `git checkout -b feature/add-custom-post-type`
- Use pull requests to review before merging

---

## Quick Reference Commands

```bash
# Clone on new machine
git clone https://github.com/arif362/three-hours-office.git

# Create and switch to feature branch
git checkout -b feature/theme-improvements

# Stage and commit changes
git add app/public/wp-content/themes/tho/
git commit -m "refactor: improve CSS structure"

# Push branch
git push origin feature/theme-improvements

# Sync latest from main
git pull origin main

# Undo last commit (before push)
git reset --soft HEAD~1

# View commit history
git log --oneline --graph --all
```

---

## References

- [WordPress Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/)
- [Git Best Practices](https://git-scm.com/book/en/v2)
- [Environment Variables in WordPress](https://wordpress.org/support/article/editing-wp-config-php/)
- [WP-CLI Documentation](https://developer.wordpress.org/cli/commands/)

---

**Last Updated:** 2025-11-26  
**Status:** Learning & Best Practices Guide
