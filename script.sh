php bin/console cache:clear
php bin/console cache:clear --env=prod
php bin/console assets:install
php bin/console assets:install --env=prod
php bin/console assetic:dump
php bin/console assetic:dump --env=prod
chown -R web1:client1 *
