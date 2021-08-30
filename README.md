# Webhooks-based Subscription Management

## Requirements
- Docker & docker-compose.
- WSL2 (for Windows).
- CD/DVD driver, or not.

## Setup
- Run `cp .env.example .env` for initial environment setup.
- Install Laravel Sail and other dependencies by running
```
  docker run --rm \
  -u "$(id -u):$(id -g)" \
  -v $(pwd):/opt \
  -w /opt \
  laravelsail/php80-composer:latest \
  composer install --ignore-platform-reqs
  ```
- Start the docker container by running `./vendor/bin/sail up -d`
- Connect to the container with `./vendor/bin/sail shell`
- From inside the container, run `php artisan key:generate`
