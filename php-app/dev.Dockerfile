# Dockerfile for development purposes in VSCode
# Image: PHP 7.4 with Apache HTTP, MySQLi, and TinyTeX; default user: jhordyess
# All sources were reviewed on September 14, 2023

FROM php:7-apache

# Define arguments for user configuration and TinyTeX installation
ARG USER_NAME=jhordyess
ARG USER_UID=1000
ARG USER_GID=$USER_UID
ARG TEX_PATH=/opt/tinytex

# Copy the VirtualHost configuration
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

# Add ServerName to Apache configuration in order to avoid warnings, see https://ratfactor.com/apache-fqdn for a detailed explanation
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Update and install dependencies
RUN apt-get update --no-install-recommends && \
  apt-get upgrade -y && \
  apt-get autoremove --purge -y && \
  apt-get install -y sudo git wget && \
  # Install Oh My Zsh dependencies
  apt-get install -y zsh && \
  # Install PHP extension for MySQLi
  docker-php-ext-install mysqli

# Add a non-root user and grant sudo privileges
# Source: https://code.visualstudio.com/remote/advancedcontainers/add-nonroot-user#_creating-a-nonroot-user
RUN groupadd --gid $USER_GID $USER_NAME && \
  useradd --uid $USER_UID --gid $USER_GID -m $USER_NAME && \
  echo $USER_NAME ALL=\(root\) NOPASSWD:ALL > /etc/sudoers.d/$USER_NAME && \
  chmod 0440 /etc/sudoers.d/$USER_NAME

# Install TinyTeX
# Source: https://yihui.org/tinytex/#installation
RUN wget -qO- "https://yihui.org/tinytex/install-bin-unix.sh" | sh && \
  # Install LaTeX packages for the app
  ~/bin/tlmgr install multirow varwidth standalone  && \
  # Move TinyTeX to a global path and add it to the PATH
  mv -T ~/.TinyTeX ${TEX_PATH} && \
  ${TEX_PATH}/bin/*/tlmgr path add
ENV PATH="${PATH}:${TEX_PATH}/bin/x86_64-linux"

# Switch to the non-root user
USER ${USER_NAME}

# Install Zsh and plugins
# Source: https://github.com/deluan/zsh-in-docker#examples
RUN sh -c "$(curl -L https://github.com/deluan/zsh-in-docker/releases/download/v1.1.5/zsh-in-docker.sh)" -- \
  -p git \
  -p https://github.com/zsh-users/zsh-syntax-highlighting \
  -p https://github.com/zsh-users/zsh-autosuggestions

# Set the default working directory
WORKDIR /home/${USER_NAME}