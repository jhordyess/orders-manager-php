FROM php:7-apache
ARG USER_NAME=jhordyess
ARG USER_UID=1000
ARG USER_GID=$USER_UID
ARG TEX_PATH=/opt/tinytex
# Update
RUN apt-get update --no-install-recommends \
  && apt-get upgrade -y \
  && apt-get autoremove --purge -y
# Add noon-root user
RUN groupadd --gid $USER_GID $USER_NAME \
  && useradd --uid $USER_UID --gid $USER_GID -m $USER_NAME
RUN apt-get install -y sudo \
  && echo $USER_NAME ALL=\(root\) NOPASSWD:ALL > /etc/sudoers.d/$USER_NAME \
  && chmod 0440 /etc/sudoers.d/$USER_NAME
# Set locale and timezone
ENV DEBIAN_FRONTEND=noninteractive
RUN apt-get install -y locales locales-all tzdata
ENV LC_ALL en_US.UTF-8
ENV LANG en_US.UTF-8
ENV LANGUAGE en_US.en
ENV TZ=America/La_Paz
# Dependences
RUN apt-get install -y git
RUN docker-php-ext-install mysqli
# LaTeX
RUN apt-get install -y wget \
  && wget -qO- "https://yihui.org/tinytex/install-bin-unix.sh" | sh -s - --admin --no-path
RUN ~/bin/tlmgr install multirow varwidth standalone \
  && mkdir ${TEX_PATH} \
  && mv ~/.TinyTeX/* ${TEX_PATH} \
  && ${TEX_PATH}/bin/*/tlmgr path add
RUN ln -s ${TEX_PATH}/bin/x86_64-linux/pdflatex /usr/local/bin/pdflatex
#
USER ${USER_NAME}
RUN echo "alias update='sudo apt-get update --no-install-recommends;sudo apt-get upgrade -y;sudo apt-get autoremove --purge -y'" >> ~/.bashrc
RUN echo "alias nosave='clear;history -c'" >> ~/.bashrc