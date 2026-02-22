#!/bin/bash
set -e

PORT=${PORT:-8080}
sed -i "s/Listen 8080/Listen $PORT/" /etc/apache2/ports.conf
sed -i "s/:8080>/:$PORT>/" /etc/apache2/sites-available/000-default.conf

exec "$@"
