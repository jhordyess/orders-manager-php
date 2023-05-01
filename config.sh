#!/bin/bash

# Get the current project name and full path
project_name=${PWD##*/}
full_path=$(realpath .)

# Enable Apache modules
sudo a2enmod rewrite
sudo a2enmod actions

# Configure vhost
# Remove the old vhost config file
sudo rm -f /etc/apache2/sites-available/${project_name}-vhost.conf
# Create a new vhost config file
sudo touch /etc/apache2/sites-available/${project_name}-vhost.conf

# Write the vhost configuration to the file
sudo printf "<VirtualHost *:80>
  ServerAlias *
  DocumentRoot ${full_path}/src
  CustomLog \${APACHE_LOG_DIR}/access.log combined
  ErrorLog \${APACHE_LOG_DIR}/error.log
  SetEnv DB_HOST ${DB_HOST}
  SetEnv DB_USER ${DB_USER}
  SetEnv DB_PASSWORD ${DB_PASSWORD}
  SetEnv DB_NAME ${DB_NAME}
  <Directory \"${full_path}/src\">
    Options Indexes FollowSymLinks
    AllowOverride All
    Require all granted
  </Directory>
</VirtualHost>" | sudo tee -a /etc/apache2/sites-available/${project_name}-vhost.conf

# Activate the vhost configuration
sudo a2ensite ${project_name}-vhost.conf

# Disable the default configuration
sudo a2dissite 000-default.conf

# Reload the Apache configuration
sudo service apache2 reload

# Start Apache
sudo service apache2 start
