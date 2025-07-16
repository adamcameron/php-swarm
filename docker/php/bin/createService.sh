#!/bin/bash

DOCKER_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/../.." && pwd)"

docker secret create mariadb_password "$DOCKER_DIR/mariadb/mariadb_password_file.private"
docker secret create app_secrets "$DOCKER_DIR/php/appEnvVars.private"

docker service create \
    --name php \
    --replicas 3 \
    --publish published=9000,target=9000 \
    --env-file docker/envVars.public \
    --env-file docker/php/envVars.public \
    --env-file docker/php/envVars.prod.public \
    --host host.docker.internal:host-gateway \
    --secret app_secrets \
    --secret mariadb_password \
    adamcameron/php-swarm:latest
