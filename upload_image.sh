#!/bin/bash

# Stop execution if a step fails
set -e

# Replace with your group's image name
IMAGE_NAME=gitlab.up.pt:5050/lbaw/lbaw2425/lbaw24113

composer install
npm install --legacy-peer-deps
npm run production
php artisan config:clear
php artisan clear-compiled
php artisan optimize

docker buildx build --push --platform linux/amd64 -t $IMAGE_NAME .
#docker build -t $IMAGE_NAME .
docker push $IMAGE_NAME