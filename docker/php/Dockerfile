FROM php:8.5.12-cli-trixie
RUN apt-get update && apt-get install -y --no-install-recommends libpq-dev libzip-dev unzip git \
    && docker-php-ext-install -j"$(nproc)" pdo_pgsql zip \
    && rm -rf /var/lib/apt/lists/*
RUN curl -fsSL -o /usr/local/bin/composer https://getcomposer.org/download/latest-2.x/composer.phar \
    && curl -fsSL https://getcomposer.org/download/latest-2.x/composer.phar.sha256 | sed 's|$|  /usr/local/bin/composer|' | sha256sum -c - \
    && chmod +x /usr/local/bin/composer
WORKDIR /workspace
