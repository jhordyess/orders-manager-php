#!/bin/bash
cp -av ./src/ ./build/public/
cd build
docker compose -p orders-man-php -f ./docker-compose.yml up -d
rm -r ./public
