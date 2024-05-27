#!/bin/bash

set -Eeo pipefail

# Load optional value (id_rsa) or use path given
eval `ssh-agent -s`
KEY_NAME=${1:-~/.ssh/id_rsa}

# Get keys into host
ssh-add "$KEY_NAME"

# Copy .env.example to .env if it is not present
if [ ! -f ".env" ]; then
   cp .env. .env
   echo "Copied .env.example to .env"
fi

docker-compose up --build -d
# Install composer and run 'composer install'
docker exec -it erev_code composer install

# Build Databases
docker exec -i marines_mariadb106 mysql -uroot -proot --execute="CREATE DATABASE IF NOT EXISTS erev"

# Setup assets
docker exec -it erev_code yarn install
docker exec -it erev_code yarn run build

# Execute commands to setup laravel
docker exec -it erev_code php artisan key:generate
docker exec -it erev_code php artisan migrate:fresh --seed
