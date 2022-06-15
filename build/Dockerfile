FROM php:7-apache
ARG TEX_PATH=/opt/tinytex
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
CMD [ "apache2-foreground" ]