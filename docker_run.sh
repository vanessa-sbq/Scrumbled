#!/bin/bash

# Stop execution if a step fails
set -e

cd /var/www

ln -sf /proc/$$/fd/1 /var/log/nginx/access.log
ln -sf /proc/$$/fd/2 /var/log/nginx/error.log

env >> /var/www/.env