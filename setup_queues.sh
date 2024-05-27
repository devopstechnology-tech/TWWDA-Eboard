#!/bin/bash

# Get the directory of the current script.
DIR=$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)

# Function to start Laravel queue worker
start_queue_worker() {
    echo "Starting Laravel queue worker..."
    php "$DIR/artisan" queue:work --sleep=3 --tries=3 &
    echo "Laravel queue worker started."
}

# Function to start Laravel scheduler
start_scheduler() {
    echo "Starting Laravel scheduler..."
    while true; do
        php "$DIR/artisan" schedule:run >> /dev/null 2>&1
        sleep 60
    done &
    echo "Laravel scheduler started."
}

# Check if any argument is provided
if [ $# -eq 0 ]; then
    echo "Usage: $0 [queue|schedule]"
    exit 1
fi

# Check which service to start
case "$1" in
    queue)
        start_queue_worker
        ;;
    schedule)
        start_scheduler
        ;;
    *)
        echo "Invalid argument. Usage: $0 [queue|schedule]"
        exit 1
        ;;
esac

echo "Service setup completed successfully."
