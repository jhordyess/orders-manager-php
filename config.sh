#!/bin/bash
project_name=${PWD##*/}
full_path=$(eval "realpath .")
sudo a2enmod rewrite
sudo a2enmod actions
# Configurar vhost
sudo rm -f /etc/apache2/sites-available/${project_name}-vhost.conf
sudo touch /etc/apache2/sites-available/${project_name}-vhost.conf
sudo printf "<VirtualHost *:80>
  ServerAlias *
  DocumentRoot ${full_path}/src
  CustomLog \${APACHE_LOG_DIR}/access.log combined
  ErrorLog \${APACHE_LOG_DIR}/error.log
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