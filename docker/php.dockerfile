ARG version

FROM wodby/php:${version}

# Download and install Symfony CLI - https://github.com/symfony-cli/symfony-cli/issues/624#issuecomment-2965340302
COPY --from=ghcr.io/symfony-cli/symfony-cli:latest /usr/local/bin/symfony /usr/local/bin/symfony

WORKDIR /var/www/html
COPY . .
RUN composer install

# to avoid dubious ownership issues
RUN git config --global --add safe.directory /var/www/html