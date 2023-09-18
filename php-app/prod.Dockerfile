# Dockerfile for testing purposes, maybe need some changes to be used in a real production environment
# Image: PHP 7.4 with Apache HTTP, MySQLi, and TinyTeX
# All sources were reviewed on September 14, 2023

FROM php:7-apache

# Define arguments for TinyTeX installation
ARG TEX_PATH=/opt/tinytex
ENV PHP_APP_SRC=/var/www/html

# Copy the VirtualHost configuration
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

# Add ServerName to Apache configuration in order to avoid warnings, see https://ratfactor.com/apache-fqdn for a detailed explanation
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Copy the app source code
COPY src /var/www/html/

# Update and install dependencies
RUN apt-get update --no-install-recommends && \
  apt-get install -y wget && \
  # Install PHP extension for MySQLiZ
  docker-php-ext-install mysqli

# Install TinyTeX
# Source: https://yihui.org/tinytex/#installation
RUN wget -qO- "https://yihui.org/tinytex/install-bin-unix.sh" | sh && \
  ~/bin/tlmgr install multirow varwidth standalone && \
  # Move TinyTeX to a global path and add it to the PATH
  mv -T ~/.TinyTeX ${TEX_PATH} && \
  ${TEX_PATH}/bin/*/tlmgr path add && \
  ln -s ${TEX_PATH}/bin/x86_64-linux/pdflatex /usr/local/bin/pdflatex

# Start Apache HTTP server in the foreground
CMD [ "apache2-foreground" ]