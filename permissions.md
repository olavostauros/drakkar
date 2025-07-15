# WordPress Permissions Fix Plan

## Current Issues Analysis

Common WSL/LAMP permission problems in this workspace:

1. **Web server user/group mismatch** - Apache/Nginx running as `www-data` but files owned by WSL user
2. **Incorrect file/directory permissions** - Files should be 644, directories should be 755
3. **wp-content write access** - Plugins, themes, and uploads need write permissions
4. **wp-config.php security** - Should be 600 for database credential protection
5. **WSL ownership issues** - Files may be owned by root or have incorrect group ownership

## Permission Standards

- **Directories**: 755 (rwxr-xr-x)
- **Files**: 644 (rw-r--r--)
- **wp-config.php**: 640 (rw-r-----) - Owner read/write, group read, secure from others
- **wp-content/** and subdirectories: 755 + group write access
- **Owner**: stauros-drakkar (for file management)
- **Group**: www-data (for web server access)

## Quick Fix Script

```bash
#!/bin/bash
# WordPress Permissions Fix Script

echo "Starting WordPress permissions fix..."
cd /home/stauros-drakkar/drakkar

# Validate wordpress directory exists
if [ ! -d "wordpress" ]; then
    echo "Error: wordpress directory not found!"
    exit 1
fi

# Add user to www-data group and set ownership
sudo usermod -a -G www-data stauros-drakkar
sudo chown -R stauros-drakkar:www-data wordpress/

# Set standard permissions
find wordpress/ -type d -exec chmod 755 {} \;
find wordpress/ -type f -exec chmod 644 {} \;

# Secure wp-config.php
[ -f "wordpress/wp-config.php" ] && chmod 640 wordpress/wp-config.php

# Create wp-content structure with write permissions
mkdir -p wordpress/wp-content/{themes,plugins,uploads}
chmod g+w wordpress/wp-content/ wordpress/wp-content/{themes,plugins,uploads}/
chmod g+s wordpress/wp-content/ wordpress/wp-content/{themes,plugins,uploads}/

echo "Permissions fix completed!"
echo "Restart web server: sudo systemctl restart apache2"
```

## Manual Step-by-Step (Alternative)

If you prefer manual execution:

```bash
# 1. Check current setup
cd /home/stauros-drakkar/drakkar
ps aux | grep apache | head -1

# 2. Set ownership and group membership
sudo chown -R stauros-drakkar:www-data wordpress/
sudo usermod -a -G www-data stauros-drakkar

# 3. Apply permissions
find wordpress/ -type d -exec chmod 755 {} \;
find wordpress/ -type f -exec chmod 644 {} \;
chmod 640 wordpress/wp-config.php 2>/dev/null

# 4. Enable wp-content write access
mkdir -p wordpress/wp-content/{themes,plugins,uploads}
chmod g+w wordpress/wp-content/ wordpress/wp-content/{themes,plugins,uploads}/
chmod g+s wordpress/wp-content/ wordpress/wp-content/{themes,plugins,uploads}/
```

## Verification

```bash
# Test ownership and permissions
ls -la wordpress/
ls -la wordpress/wp-content/

# Test web server write access
sudo -u www-data touch wordpress/wp-content/uploads/test.txt
sudo -u www-data rm wordpress/wp-content/uploads/test.txt

# Test user file management
touch wordpress/test-access.txt && rm wordpress/test-access.txt
```

## Web Server Configuration

Ensure your virtual host configuration includes:

```apache
<Directory "/home/stauros-drakkar/drakkar/wordpress">
    AllowOverride All
    Require all granted
</Directory>
```

## Troubleshooting

**WordPress can't write files:**
- Verify web server user: `ps aux | grep apache`
- Check error logs: `/var/log/apache2/error.log`
- Test PHP user: `<?php echo exec('whoami'); ?>`

**File uploads fail:**
- Check PHP settings: `upload_max_filesize` and `post_max_size` in `/etc/php/*/apache2/php.ini`
- Verify uploads directory exists and is writable

## Security Reminders

- Never use 777 permissions
- Keep wp-config.php at 640 permissions
- Monitor permissions regularly
- Always backup before making changes

## Monthly Maintenance

```bash
#!/bin/bash
cd /home/stauros-drakkar/drakkar/wordpress
find . -type f -not -path "./wp-config.php" -exec chmod 644 {} \;
find . -type d -exec chmod 755 {} \;
chmod 640 wp-config.php 2>/dev/null
chmod g+w wp-content/ wp-content/*/
chown -R stauros-drakkar:www-data wp-content/
echo "WordPress permissions maintenance completed"
```
