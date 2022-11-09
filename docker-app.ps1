cp -r ./src/ ./build/docker/public/
docker compose -p orders-man-php -f ./build/docker/docker-compose.yml up -d
rm -r ./build/docker/public
