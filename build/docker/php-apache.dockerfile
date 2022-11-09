FROM php:7-apache
ARG TEX_PATH=/opt/tinytex
ARG DB_HOST
ARG DB_USER
ARG DB_PASSWORD
ARG DB_NAME
RUN chmod -R 755 /var/www/html/
# Dependences
RUN docker-php-ext-install mysqli  
# Copy
COPY ["public/","/var/www/html/"]
# LaTeX
RUN apt-get update --no-install-recommends \
  && apt-get install -y wget \
  && wget -qO- "https://yihui.org/tinytex/install-bin-unix.sh" | sh -s - --admin --no-path
RUN ~/bin/tlmgr install multirow varwidth standalone \
  && mkdir ${TEX_PATH} \
  && mv ~/.TinyTeX/* ${TEX_PATH} \
  && ${TEX_PATH}/bin/*/tlmgr path add
RUN ln -s ${TEX_PATH}/bin/x86_64-linux/pdflatex /usr/local/bin/pdflatex
# TODO Use the environment variables declared in the container, and don't redefine it here.
RUN sed -i "s/<\/VirtualHost>/        SetEnv DB_HOST ${DB_HOST}\n        SetEnv DB_USER ${DB_USER}\n        SetEnv DB_PASSWORD ${DB_PASSWORD}\n        SetEnv DB_NAME ${DB_NAME}\n<\/VirtualHost>/g" /etc/apache2/sites-available/000-default.conf
CMD [ "apache2-foreground" ]