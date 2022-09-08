#!/bin/bash
project_name=${PWD##*/}
full_path=$(realpath .)
sudo a2enmod rewrite
sudo a2enmod actions
# Configurar vhost
sudo rm -f /etc/apache2/sites-available/${project_name}-vhost.conf
sudo touch /etc/apache2/sites-available/${project_name}-vhost.conf
# TODO Use the environment variables declared in the container, and don't redefine it here.
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
# Activar vhost
sudo a2ensite ${project_name}-vhost.conf
# Desabilitar el default
sudo a2dissite 000-default.conf
# Refrescar apache2
sudo service apache2 reload
# Iniciar apache2
sudo service apache2 start
