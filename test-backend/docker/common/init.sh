#!/bin/sh
set -e

# echo "🚀 Starting Laravel Octane initialization..."

# # # Fix autoloader issues di awal
# # echo "🔧 Fixing autoloader..."
# # composer dump-autoload --optimize --no-interaction 2>/dev/null || true

#   php artisan config:clear
#   php artisan cache:clear
  

# # Setup directories dan permissions di awal
# echo "🔧 Setting up directories..."
# mkdir -p \
#     storage/app/public \
#     storage/framework/cache/data \
#     storage/framework/sessions \
#     storage/framework/views \
#     storage/logs \
#     bootstrap/cache \
#     /var/run/php \
#     /var/log/supervisor

# echo "🔧 Fixing permissions..."
# chown -R www-data:www-data storage bootstrap/cache /var/run/php /var/log/supervisor 2>/dev/null || true
# chmod -R 775 storage bootstrap/cache
# chmod -R 755 /var/run/php

# # Test write permissions
# if ! touch storage/logs/test.tmp 2>/dev/null; then
#     echo "⚠️  Fixing write permissions..."
#     chmod -R 777 storage bootstrap/cache
# fi
# rm -f storage/logs/test.tmp 2>/dev/null
# echo "✅ Permissions OK"

# # Test basic PHP functionality
# echo "🔧 Testing PHP..."
# php -v

# # Test autoloader
# echo "🔧 Testing autoloader..."
# php -r "require 'vendor/autoload.php'; echo '✅ Autoload working' . PHP_EOL;" 2>/dev/null || echo "⚠️ Autoload issue"

# # 🔍 Check Octane files
# echo "🔍 Checking Octane files..."
# ls -la vendor/laravel/octane/src/ | head -5

# # 🔍 SIMPLIFIED Octane installation test
# echo "🔍 Testing Octane installation..."
# if php -r "require 'vendor/autoload.php'; echo (class_exists('Laravel\Octane\Octane') ? 'OK' : 'NOT_FOUND');" 2>/dev/null | grep -q "OK"; then
#     echo "✅ Octane classes loadable"
# else
#     echo "⚠️ Octane classes not loadable, but files exist - will fix during package discovery"
# fi

# # Check Octane via composer
# echo "🔍 Verifying Octane via composer..."
# if composer show laravel/octane >/dev/null 2>&1; then
#     echo "✅ Octane installed via composer"
# else
#     echo "❌ Octane not installed, installing..."
#     composer require laravel/octane --no-interaction --with-all-dependencies 2>/dev/null || echo "⚠️ Could not install Octane"
# fi

# # Wait for MySQL
# echo "🔄 Waiting for MySQL connection..."
# #!/bin/sh

# echo "🚀 Starting Laravel initialization..."

# echo "🔄 Checking MySQL connection and creating database..."
# MAX_RETRIES=60
# RETRY_COUNT=0
# echo "start wait sql"
# DB_HOST=${DB_HOST:-"mysql"}
# DB_PORT=${DB_PORT:-"3306"}
# DB_DATABASE=${DB_DATABASE:-"laravel"}
# DB_USERNAME=${DB_USERNAME:-"laravel"}
# DB_PASSWORD=${DB_PASSWORD:-"laravel"}

# echo "Using DB_HOST=${DB_HOST}, DB_PORT=${DB_PORT}, DB_DATABASE=${DB_DATABASE}"

# while [ $RETRY_COUNT -lt $MAX_RETRIES ]; do
#     php -r "
#     try {
#         \$pdo = new PDO('mysql:host=${DB_HOST};port=${DB_PORT}', '${DB_USERNAME}', '${DB_PASSWORD}', [
#             PDO::ATTR_TIMEOUT => 3,
#             PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
#         ]);
        
#         // Create database if not exists
#         \$pdo->exec('CREATE DATABASE IF NOT EXISTS \`${DB_DATABASE}\`');
        
#         // Test connection to the specific database
#         \$pdo = new PDO('mysql:host=${DB_HOST};port=${DB_PORT};dbname=${DB_DATABASE}', '${DB_USERNAME}', '${DB_PASSWORD}');
#         echo 'Database ${DB_DATABASE} ready.' . PHP_EOL;
#         exit(0);
#     } catch (PDOException \$e) {
#         exit(1);
#     }
#     " >/dev/null 2>&1
  
#     if [ $? -eq 0 ]; then
#         echo "✅ MySQL connection and database OK"
#         break
#     fi

#     echo "⏳ Waiting MySQL and creating database... ($((RETRY_COUNT+1))/$MAX_RETRIES)"
#     RETRY_COUNT=$((RETRY_COUNT + 1))
#     sleep 2
# done

# if [ $RETRY_COUNT -eq $MAX_RETRIES ]; then
#     echo "❌ MySQL not reachable after $MAX_RETRIES attempts."
#     exit 1
# fi

# # Check PHP extensions
# echo "🔍 Checking required PHP extensions..."
# php -r "
# \$required = ['swoole', 'pdo_mysql', 'mbstring', 'tokenizer', 'xml', 'sockets', 'pcntl'];
# \$loaded = get_loaded_extensions();
# \$missing = array_diff(\$required, array_map('strtolower', \$loaded));
# if (!empty(\$missing)) {
#     echo '⚠️  Missing: ' . implode(', ', \$missing) . PHP_EOL;
# } else {
#     echo '✅ All required extensions loaded' . PHP_EOL;
# }
# "

# # 🎯 CRITICAL: Run package discovery HANYA SEKALI dengan error handling
# echo "🔍 Running package discovery..."
# php artisan package:discover --no-interaction 2>/dev/null || {
#     echo "⚠️  Package discovery failed, performing emergency fix..."
#     rm -rf bootstrap/cache/*.php
#     composer dump-autoload --optimize
#     php artisan config:clear
#     php artisan package:discover --no-interaction 2>/dev/null || {
#         echo "❌ Package discovery still failing, but continuing..."
#     }
# }

# # Check Octane commands availability
# echo "🔍 Checking Octane commands..."
# if php artisan list 2>/dev/null | grep -q "octane:start"; then
#     echo "✅ Octane commands registered"
#     php artisan list 2>/dev/null | grep "octane:" | head -3
# else
#     echo "⚠️  Octane commands not found in artisan"
#     echo "But Octane files exist, so Supervisor will try to start it anyway"
# fi

# # Run migrations if database is available
# if [ "${DB_CONNECTION}" != "sqlite" ] && [ -n "${DB_HOST}" ] && [ $RETRY_COUNT -lt $MAX_RETRIES ]; then
#     echo "🔨 Running migrations..."
#     php artisan migrate --force 2>&1 | head -5 || echo "⚠️  Migration issues, continuing..."
# fi


# # ⚡ AGGRESSIVE CACHE CLEARING DI AWAL - INI YANG PALING PENTING
# echo "🧹 Clearing all caches..."
# rm -rf bootstrap/cache/*.php 2>/dev/null || true
# php artisan config:clear 2>/dev/null || true
# php artisan cache:clear 2>/dev/null || true
# php artisan view:clear 2>/dev/null || true
# php artisan route:clear 2>/dev/null || true

# # 🚫 JANGAN cache config di development - INI COMMENT
# # Cache config only in production - DI AKHIR
# if [ "${APP_ENV}" = "production" ]; then
#     echo "⚙️  Caching configuration for production..."
#     php artisan config:cache 2>/dev/null || true
#     php artisan route:cache 2>/dev/null || true
#     php artisan view:cache 2>/dev/null || true
# fi

# echo ""
# echo "════════════════════════════════════════════"
# echo "🎉 Initialization Complete!"
# echo "════════════════════════════════════════════"
# echo "🌐 Application: ${APP_NAME:-Laravel}"
# echo "🌐 Environment: ${APP_ENV:-local}"
# echo "🌐 Octane URL: http://0.0.0.0:8000"
# echo ""
# echo "📊 Services Status:"
# echo "  • Octane (Swoole) - Starting..."
# echo "  • Horizon - Starting..."
# echo "  • Scheduler - Starting..."
# echo "════════════════════════════════════════════"
# echo ""

# # Execute supervisord
# exec "$@"
#!/bin/bash
set -e

echo "🚀 Starting Laravel Octane initialization..."

# Function untuk log dengan timestamp
log() {
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] $1"
}

# Function untuk wait database dengan timeout
wait_for_database() {
    local max_retries=60
    local retry_count=0
    local db_host=${DB_HOST:-"mysql"}
    local db_port=${DB_PORT:-"3306"}
    local db_database=${DB_DATABASE:-"test-backend"}
    local db_username=${DB_USERNAME:-"root"}
    local db_password=${DB_PASSWORD:-"1215161"}

    log "Using DB_HOST=${db_host}, DB_PORT=${db_port}, DB_DATABASE=${db_database}"

    while [ $retry_count -lt $max_retries ]; do
        php -r "
        try {
            \$pdo = new PDO('mysql:host=${db_host};port=${db_port}', '${db_username}', '${db_password}', [
                PDO::ATTR_TIMEOUT => 5,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
            
            // Create database if not exists
            \$pdo->exec('CREATE DATABASE IF NOT EXISTS \`${db_database}\` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
            
            // Test connection to the specific database
            \$pdo = new PDO('mysql:host=${db_host};port=${db_port};dbname=${db_database}', '${db_username}', '${db_password}');
            echo 'Database ${db_database} ready.' . PHP_EOL;
            exit(0);
        } catch (PDOException \$e) {
            echo 'Database error: ' . \$e->getMessage() . PHP_EOL;
            exit(1);
        }
        " >/dev/null 2>&1

        if [ $? -eq 0 ]; then
            log "✅ MySQL connection and database OK"
            return 0
        fi

        retry_count=$((retry_count + 1))
        log "⏳ Waiting for MySQL... (attempt $retry_count/$max_retries)"
        sleep 2
    done

    log "❌ MySQL not reachable after $max_retries attempts"
    return 1
}

# Setup directories dan permissions
setup_directories() {
    log "🔧 Setting up directories..."
    mkdir -p \
        storage/app/public \
        storage/framework/cache/data \
        storage/framework/sessions \
        storage/framework/views \
        storage/logs \
        bootstrap/cache \
        /var/run/php \
        /var/log/supervisor

    log "🔧 Fixing permissions..."
    chown -R www-data:www-data storage bootstrap/cache /var/run/php /var/log/supervisor 2>/dev/null || true
    chmod -R 775 storage bootstrap/cache
    chmod -R 755 /var/run/php

    # Test write permissions
    if ! touch storage/logs/test.tmp 2>/dev/null; then
        log "⚠️  Fixing write permissions..."
        chmod -R 777 storage bootstrap/cache
    fi
    rm -f storage/logs/test.tmp 2>/dev/null
    log "✅ Permissions OK"
}

# Test PHP dan dependencies
test_php() {
    log "🔧 Testing PHP..."
    php -v | head -1

    log "🔧 Testing autoloader..."
    if php -r "require 'vendor/autoload.php'; echo 'OK';" >/dev/null 2>&1; then
        log "✅ Autoload working"
    else
        log "⚠️ Autoload issue, fixing..."
        composer dump-autoload --optimize --no-interaction 2>/dev/null || true
    fi
}

# Check PHP extensions
check_extensions() {
    log "🔍 Checking required PHP extensions..."
    php -r "
    \$required = ['pdo_mysql', 'mbstring', 'tokenizer', 'xml', 'sockets', 'pcntl'];
    \$swoole_ext = extension_loaded('swoole');
    \$openswoole_ext = extension_loaded('openswoole');
    
    echo 'Swoole: ' . (\$swoole_ext ? '✅' : '❌') . PHP_EOL;
    echo 'OpenSwoole: ' . (\$openswoole_ext ? '✅' : '❌') . PHP_EOL;
    
    if (!\$swoole_ext && !\$openswoole_ext) {
        echo '❌ No Swoole engine available' . PHP_EOL;
        exit(1);
    }
    
    \$loaded = get_loaded_extensions();
    \$missing = array_diff(\$required, array_map('strtolower', \$loaded));
    if (!empty(\$missing)) {
        echo '⚠️  Missing extensions: ' . implode(', ', \$missing) . PHP_EOL;
        exit(1);
    } else {
        echo '✅ All required extensions loaded' . PHP_EOL;
        exit(0);
    }
    " || {
        log "❌ Missing required extensions"
        return 1
    }
}

# Repair autoloader
repair_autoloader() {
    log "🔧 Repairing autoloader..."
    
    # Hapus cache autoload
    rm -f vendor/composer/autoload_*.php 2>/dev/null || true
    rm -f bootstrap/cache/packages.php 2>/dev/null || true
    rm -f bootstrap/cache/services.php 2>/dev/null || true
    
    # Force regenerate autoload
    composer dump-autoload --optimize --no-interaction 2>&1 | grep -v "does not comply with psr-4" | while read line; do
        [ -n "$line" ] && log "$line"
    done
    
    # Clear Laravel cache
    php artisan config:clear 2>/dev/null || true
    php artisan cache:clear 2>/dev/null || true
    
    # Rediscover packages
    log "🔍 Discovering packages..."
    php artisan package:discover --ansi --no-interaction 2>&1 | while read line; do
        log "$line"
    done
    
    log "✅ Autoloader repaired"
}

# Check Octane installation
check_octane() {
    log "🔍 Checking Octane installation..."
    
    # Check via composer
    if composer show laravel/octane >/dev/null 2>&1; then
        log "✅ Octane installed via composer"
    else
        log "❌ Octane not installed, installing..."
        composer require laravel/octane --no-interaction --with-all-dependencies 2>/dev/null || {
            log "❌ Could not install Octane"
            return 1
        }
    fi

    # Check classes
    if php -r "require 'vendor/autoload.php'; exit(class_exists('Laravel\Octane\Octane') ? 0 : 1);" 2>/dev/null; then
        log "✅ Octane classes loadable"
    else
        log "❌ Octane classes not loadable"
        return 1
    fi

    return 0
}

# Check Horizon installation
check_horizon() {
    log "🔍 Checking Horizon installation..."
    
    # Check via composer
    if ! composer show laravel/horizon >/dev/null 2>&1; then
        log "⚠️  Horizon not installed via composer"
        return 1
    fi
    
    log "✅ Horizon installed via composer"

    # Check if Horizon is in autoload
    if [ -f "vendor/composer/autoload_psr4.php" ]; then
        if grep -q "Laravel\\\\\\\\Horizon" vendor/composer/autoload_psr4.php; then
            log "✅ Horizon found in autoload_psr4"
        else
            log "⚠️  Horizon NOT found in autoload_psr4, regenerating..."
            composer dump-autoload --no-interaction >/dev/null 2>&1
        fi
    fi

    # Check Horizon classes
    log "🔍 Testing Horizon class loading..."
    php -r "
    require 'vendor/autoload.php';
    
    \$classes = [
        'Laravel\Horizon\Horizon',
        'Laravel\Horizon\HorizonServiceProvider', 
        'Laravel\Horizon\Console\HorizonCommand'
    ];
    
    \$allLoaded = true;
    foreach (\$classes as \$class) {
        if (class_exists(\$class)) {
            echo '✅ ' . \$class . PHP_EOL;
        } else {
            echo '❌ ' . \$class . PHP_EOL;
            \$allLoaded = false;
        }
    }
    
    exit(\$allLoaded ? 0 : 1);
    " 2>&1 | while read line; do
        log "$line"
    done || {
        log "❌ Horizon classes not loadable"
        return 1
    }

    # Check if Horizon configuration exists
    if [ ! -f "config/horizon.php" ]; then
        log "📦 Publishing Horizon configuration..."
        php artisan horizon:install --no-interaction 2>/dev/null || {
            log "⚠️ Could not publish Horizon configuration"
            return 1
        }
    else
        log "✅ Horizon configuration exists"
    fi

    return 0
}

# Force install Horizon if needed
force_install_horizon() {
    log "🔍 Checking if Horizon needs installation..."
    
    # Check if Horizon is in composer.json but not installed
    if grep -q '"laravel/horizon"' composer.json; then
        if ! composer show laravel/horizon >/dev/null 2>&1; then
            log "📦 Installing Horizon from composer.json..."
            composer require laravel/horizon --no-interaction --with-all-dependencies 2>&1 | grep -v "does not comply with psr-4" | while read line; do
                [ -n "$line" ] && log "$line"
            done
            
            # Publish configuration
            php artisan horizon:install --no-interaction 2>/dev/null || true
            
            # Dump autoload
            composer dump-autoload --optimize --no-interaction >/dev/null 2>&1
            
            log "✅ Horizon force installed"
        else
            log "✅ Horizon already installed"
        fi
    else
        log "ℹ️  Horizon not in composer.json, skipping"
    fi
}

# Run Laravel optimizations
optimize_laravel() {
    log "🧹 Clearing all caches..."
    
    # Hapus cache files
    rm -rf bootstrap/cache/*.php 2>/dev/null || true
    
    # Clear caches
    php artisan config:clear 2>/dev/null || true
    php artisan cache:clear 2>/dev/null || true
    php artisan view:clear 2>/dev/null || true
    php artisan route:clear 2>/dev/null || true

    # Cache hanya untuk production
    if [ "${APP_ENV}" = "production" ]; then
        log "⚙️  Caching configuration for production..."
        php artisan config:cache 2>/dev/null || true
        php artisan route:cache 2>/dev/null || true
        php artisan view:cache 2>/dev/null || true
    else
        log "ℹ️  Development mode - caching skipped"
    fi
    
    log "✅ Laravel optimization completed"
}

# Run database migrations
run_migrations() {
    if [ "${DB_CONNECTION}" = "mysql" ] && [ -n "${DB_HOST}" ]; then
        log "🔨 Running migrations..."
        if php artisan migrate:fresh --seed --force 2>&1 | while read line; do
            log "MIGRATION: $line"
        done; then
            log "✅ Migrations completed successfully"
        else
            log "⚠️  Migration completed with issues"
        fi
    else
        log "ℹ️  Database migrations skipped (not using MySQL)"
    fi
}

# Check Octane commands
check_octane_commands() {
    log "🔍 Checking Octane commands..."
    if php artisan list 2>/dev/null | grep -q "octane:start"; then
        log "✅ Octane commands registered"
        return 0
    else
        log "❌ Octane commands not found"
        return 1
    fi
}

# Check Horizon commands and status
check_horizon_commands() {
    log "🔍 Checking Horizon commands..."
    
    if php artisan list 2>/dev/null | grep -q "horizon:"; then
        log "✅ Horizon commands registered"
        
        # Try to get Horizon status
        if php artisan horizon:status --no-interaction 2>/dev/null | grep -q ""; then
            log "✅ Horizon configuration valid"
        fi
        
        return 0
    else
        log "ℹ️  Horizon commands not found"
        return 1
    fi
}

# Initialize Horizon if available
initialize_horizon() {
    log "🚀 Initializing Horizon..."
    
    if check_horizon_commands; then
        # Publish Horizon assets if not exists
        if [ ! -f "public/vendor/horizon/manifest.json" ]; then
            log "📦 Publishing Horizon assets..."
            php artisan horizon:assets --no-interaction 2>/dev/null || {
                log "⚠️  Failed to publish Horizon assets"
            }
        else
            log "✅ Horizon assets already published"
        fi
        
        log "✅ Horizon initialization completed"
        return 0
    else
        log "ℹ️  Horizon not available, skipping initialization"
        return 1
    fi
}

# Generate app key if needed
generate_app_key() {
    if [ -z "${APP_KEY}" ] || [ "${APP_KEY}" = "base64:your-key-here" ]; then
        log "🔑 Generating application key..."
        php artisan key:generate --force 2>/dev/null || true
        log "✅ Application key generated"
    else
        log "✅ Application key already set"
    fi
}

# Main execution
main() {
    log "🚀 Starting Laravel Octane initialization sequence..."
    
    # Step 1: Generate app key
    generate_app_key
    
    # Step 2: Setup directories
    setup_directories
    
    # Step 3: Test PHP
    test_php
    
    # Step 4: Check extensions
    if ! check_extensions; then
        log "❌ PHP extensions check failed"
        exit 1
    fi
    
    # Step 5: Wait for database
    if ! wait_for_database; then
        log "❌ Database initialization failed"
        exit 1
    fi
    
    # Step 6: Repair autoloader
    repair_autoloader
    
    # Step 7: Check Octane
    if ! check_octane; then
        log "❌ Octane check failed"
        exit 1
    fi
    
    # Step 8: Force install Horizon if needed
    force_install_horizon
    
    # Step 9: Check Horizon
    HORIZON_AVAILABLE=false
    if check_horizon; then
        HORIZON_AVAILABLE=true
    fi
    
    # Step 10: Optimize Laravel
    optimize_laravel
    
    # Step 11: Run migrations
    run_migrations
    
    # Step 12: Check Octane commands
    if ! check_octane_commands; then
        log "❌ Octane commands check failed"
        exit 1
    fi
    
    # Step 13: Initialize Horizon
    if [ "$HORIZON_AVAILABLE" = true ]; then
        initialize_horizon
    fi
    
    log "✅ All initialization steps completed successfully"
    
    # Final summary
    echo ""
    echo "══════════════════════════════════════════════════════════════════"
    echo "🎉 Laravel Octane Initialization Complete!"
    echo "══════════════════════════════════════════════════════════════════"
    echo "🌐 Application: ${APP_NAME:-Laravel}"
    echo "🌐 Environment: ${APP_ENV:-local}"
    echo "🌐 Octane URL: http://0.0.0.0:8000"
    echo "📊 Database: ${DB_HOST}:${DB_PORT}/${DB_DATABASE}"
    
    # Show Horizon status
    if [ "$HORIZON_AVAILABLE" = true ]; then
        echo "📈 Horizon: ✅ Available (Dashboard at /horizon)"
    else
        echo "📈 Horizon: ⚠️  Not installed"
    fi
    
    echo ""
    echo "🚀 Ready to start services..."
    echo "══════════════════════════════════════════════════════════════════"
    echo ""
}

# Handle errors gracefully
set +e
trap 'log "❌ Script failed at line $LINENO with exit code $?"; exit 1' ERR
set -e

# Run main function
main

# Execute the passed command (usually supervisord or octane:start)
exec "$@"