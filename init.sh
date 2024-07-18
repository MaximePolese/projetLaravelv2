#!/bin/bash

# Attendre que MySQL soit prêt
until mysqladmin ping -hmysql -uroot -ptest --silent; do
  echo "Waiting for MySQL to be up..."
  sleep 2
done

# Exécuter les commandes SQL et imprimer les résultats
mysql -uroot -ptest <<EOF | tee /docker-entrypoint-initdb.d/init.log
$(cat /docker-entrypoint-initdb.d/init.sql)
EOF
