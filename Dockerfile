# syntax = docker/dockerfile:experimental

ARG PHP_VERSION=8.2
ARG NODE_VERSION=18
FROM fideloper/fly-laravel:latest

LABEL fly_launch_runtime="laravel"

COPY . /var/www/html

# Ensure composer dependencies are installed without swoole
RUN composer install --no-dev --optimize-autoloader \
    && mkdir -p storage/logs \
    && php artisan optimize:clear \
    && chown -R www-data:www-data /var/www/html \
    && echo "MAILTO=\"\"\n* * * * * www-data /usr/bin/php /var/www/html/artisan schedule:run" > /etc/cron.d/laravel \
    && cp .fly/entrypoint.sh /entrypoint \
    && chmod +x /entrypoint

# Trust proxies configuration
RUN if php artisan --version | grep -q "Laravel Framework 1[1-9]"; then \
    sed -i='' '/->withMiddleware(function (Middleware \$middleware) {/a\
    \$middleware->trustProxies(at: "*");\
    ' bootstrap/app.php; \
    else \
    sed -i 's/protected \$proxies/protected \$proxies = "*"/g' app/Http/Middleware/TrustProxies.php; \
    fi

# Check for Octane and adjust configurations
RUN if grep -Fq "laravel/octane" /var/www/html/composer.json; then \
    rm -rf /etc/supervisor/conf.d/fpm.conf; \
    rm /etc/nginx/sites-enabled/default; \
    ln -sf /etc/nginx/sites-available/default-octane /etc/nginx/sites-enabled/default; \
    fi

# FROM node:${NODE_VERSION} as node_modules_go_brrr
FROM node:18


RUN mkdir /app
WORKDIR /app
COPY . .
COPY --from=base /var/www/html/vendor /app/vendor

RUN if [ -f "vite.config.js" ]; then \
    ASSET_CMD="build"; \
    else \
    ASSET_CMD="production"; \
    fi; \
    if [ -f "yarn.lock" ]; then \
    yarn install --frozen-lockfile; \
    yarn $ASSET_CMD; \
    elif [ -f "pnpm-lock.yaml" ]; then \
    corepack enable && corepack prepare pnpm@latest-8 --activate; \
    pnpm install --frozen-lockfile; \
    pnpm run $ASSET_CMD; \
    elif [ -f "package-lock.json" ]; then \
    npm ci --no-audit; \
    npm run $ASSET_CMD; \
    else \
    npm install; \
    npm run $ASSET_CMD; \
    fi;

FROM base

COPY --from=node_modules_go_brrr /app/public /var/www/html/public-npm
RUN rsync -ar /var/www/html/public-npm/ /var/www/html/public/ \
    && rm -rf /var/www/html/public-npm \
    && chown -R www-data:www-data /var/www/html/public

EXPOSE 8080

ENTRYPOINT ["/entrypoint"]
