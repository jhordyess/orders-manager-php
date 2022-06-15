#!/bin/bash
rsync -av ./src/ ./build/public/
cd build
docker-compose -p orders-man -f ./docker-compose.yml up -d
rm -r ./public/*