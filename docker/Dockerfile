FROM ubuntu:20.04
WORKDIR /app

ENV ACCEPT_EULA=Y

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

COPY startup.sh /

# Install selected extensions and other stuff
RUN apt-get update \
 && apt-get -y --no-install-recommends install apt-utils libxml2-dev gnupg apt-transport-https \
 && apt-get -y install php7.4 php7.4-dev php-pear -y --allow-unauthenticated \
 && apt-get -y install php7.4-mysql php7.4-xml php7.4-ldap php7.4-curl php7.4-mbstring \
 && apt-get -y install php7.4-odbc php7.4-sybase php7.4-interbase php7.4-sqlite3 php7.4-common libopendbx1-mssql \
 && apt-get -y install git unzip screen vim

RUN curl https://packages.microsoft.com/keys/microsoft.asc | apt-key add - \
 && curl https://packages.microsoft.com/config/ubuntu/20.04/prod.list > /etc/apt/sources.list.d/mssql-release.list \
 && apt-get update \
 && ACCEPT_EULA=Y apt-get install -y msodbcsql17 \
 && ACCEPT_EULA=Y apt-get install -y mssql-tools \
 && echo 'export PATH="$PATH:/opt/mssql-tools/bin"' >> /root/.bashrc \
 && export PATH="$PATH:/opt/mssql-tools/bin" \
 && apt-get install -y unixodbc-dev \
 && pecl uninstall -r sqlsrv \
 && pecl uninstall -r pdo_sqlsrv \
 && pecl -d php_suffix=7.4 install sqlsrv \
 && pecl -d php_suffix=7.4 install pdo_sqlsrv \
 && printf "; priority=30\nextension=sqlsrv.so\n" > /etc/php/7.4/mods-available/sqlsrv.ini \
 && printf "; priority=40\nextension=pdo_sqlsrv.so\n" > /etc/php/7.4/mods-available/pdo_sqlsrv.ini \
 && phpenmod -v 7.3 sqlsrv pdo_sqlsrv

RUN curl https://getcomposer.org/download/1.9.2/composer.phar > /composer.phar
RUN mkdir -p /root/.ssh/ \
 && echo "|1|hMzVjv3SglsivU3cloo7UB5Qhms=|IV0biNVhNPNW4I9ymmD5zrs1wao= ecdsa-sha2-nistp256 AAAAE2VjZHNhLXNoYTItbmlzdHAyNTYAAAAIbmlzdHAyNTYAAABBBAkh69n7JU0BIgabrOe5HSOA+K/92Z7MB0hPAEmOIwN6a05ykebXb6SAh8jHsforIdVB6OY/ZtWhc2LlEfxIqsM=" >> /root/.ssh/known_hosts \
 && rm -Rf /app/vendor/

RUN printf "172.16.1.40 ekm.marquardt.netz\n172.16.1.14 srv-ecorotest\n" >> /etc/hosts

CMD /bin/bash /startup.sh
