#!/bin/bash
cp -av ./src/ ./build/docker/public/
cd build/docker
docker compose -p orders-man-php -f ./docker-compose.yml up -d
rm -r ./public
