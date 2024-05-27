#!/bin/bash

# Start Laravel Queue Worker in the background
echo "Starting Laravel Queue Worker..."
php artisan queue:work &

# Capture the PID of Queue Worker
QUEUE_PID=$!

# Start Yarn Development Server in the foreground
echo "Starting Yarn Development Server..."
yarn dev

# After yarn dev stops, kill the Queue Worker
echo "Stopping Laravel Queue Worker..."
kill $QUEUE_PID
