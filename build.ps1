cp -r ./src/ ./build/public/
docker compose -p orders-man-php -f ./build/docker-compose.yml up -d
rm -r ./build/public
