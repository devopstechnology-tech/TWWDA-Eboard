#!/bin/bash
DIR=$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)
# php artisan key:generate
# php artisan config:cache
# composer install

if [ -z $SUDO_USER ]; then
    echo "You must have root privilege to do the installation."
    exit 1
fi

echo "Creating crontab job..."
line="* * * * * php ${DIR}/artisan schedule:run >> /dev/null 2>&1"
crontab -l | {
    cat
    echo "$line"
} | crontab -
echo "crontab created"
echo "Successfully installed"
