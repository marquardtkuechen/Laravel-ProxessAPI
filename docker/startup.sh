#!/bin/bash
#
ssh-agent > ~/sshAgent.txt; source ~/sshAgent.txt; ssh-add /app/.id_rsa
cd /app;
php /composer.phar update;
touch /app/database/database.sqlite;
php artisan migrate;
php artisan l5-swagger:generate
php artisan serve
#
#
