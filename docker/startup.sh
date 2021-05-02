#!/bin/bash
#
ssh-agent > ~/sshAgent.txt; source ~/sshAgent.txt; ssh-add /app/.id_rsa
cd /app; php /composer.phar update; php artisan serve
#
#
