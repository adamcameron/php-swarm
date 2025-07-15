# php-swarm
Experimenting with Docker Swarm

## Notes

One must create some files containing env var values that we don't want
in source control due to the sensitive nature of the values.

* `docker/mariadb/mariadb_password_file.private`
* `docker/mariadb/mariadb_root_password_file.private`
* `docker/php/appEnvVars.private`

The MariaDB ones should contain only the password for the DB user the app users;
and the root user used to create the DB, respectively.

`appEnvVars.private` should have a `[name]=[value]` pair for the following env vars:

```bash
APP_SECRET=[the value of the APP_SECRET env var]
```
The value doesn't really matter.


## Building for dev

```bash
# from the root of the project

# only need to do this once or if Dockerfile.base changes
docker build -f docker/php/Dockerfile.base -t adamcameron/php-swarm-base .

docker compose -f docker/docker-compose.yml build
docker compose -f docker/docker-compose.yml up --detach

# verify stability
docker container ls --format "table {{.Names}}\t{{.Status}}"
NAMES     STATUS
nginx     Up 28 minutes (healthy)
php       Up 28 minutes (healthy)
db        Up 28 minutes

docker exec php composer test-all
./composer.json is valid
PHPUnit 12.2.6 by Sebastian Bergmann and contributors.

Runtime:       PHP 8.4.10 with Xdebug 3.4.4
Configuration: /var/www/phpunit.xml.dist

Time: 00:02.270, Memory: 28.00 MB

OK (15 tests, 20 assertions)

Generating code coverage report in HTML format ... done [00:00.006]
```

## Building PHP container for prod

This presupposes appropriate Nginx and DB servers are already running
(the dev containers would be fine).

```bash
# from the root of the project

# only need to do this once or if Dockerfile.base changes
docker build \
  -f docker/php/Dockerfile.base \
  -t adamcameron/php-swarm-base:x.y \ # where x.y is the actual version, e.g. 0.6 \
  -t adamcameron/php-swarm-base:latest \
  .
docker push adamcameron/php-swarm-base:x.y 
docker push adamcameron/php-swarm-base:latest

# this is for the prod container
docker build \
    -f docker/php/Dockerfile.prod \
    -t adamcameron/php-swarm:x.y \ # where x.y is the actual version, e.g. 0.6 \
    -t adamcameron/php-swarm:latest \
    .

docker push adamcameron/php-swarm:x.y
docker push adamcameron/php-swarm:latest
```

## Running the prod container via Docker

```bash
docker run \
    --name php \
    --restart unless-stopped \
    -p 9000:9000 \
    --env-file docker/envVars.public \
    --env-file docker/php/envVars.public \
    --env-file docker/php/envVars.prod.public \
    --env-file docker/envVars.private \
    --env-file docker/php/envVars.private \
    --add-host=host.docker.internal:host-gateway \
    --detach \
    -it \
    adamcameron/php-swarm:latest
    
# verify stability
docker container ls --format "table {{.Names}}\t{{.Status}}" | grep php
php       Up 2 minutes (healthy)

# the tests are deployed in the prod container, so test something else:
curl -s -o /dev/null -w "%{http_code}\n" http://php-swarm.local:8080/
200

docker exec php bin/console about | grep -B 1 -A 2 Kernel
 -------------------- -------------------------------------------
  Kernel
 -------------------- -------------------------------------------
  Type                 App\Kernel
  Environment          prod
  Debug                false
```

## Running the prod container via Docker Swarm

```bash
# only needed once to start-up the swarm
docker swarm init --advertise-addr 127.0.0.1

docker service create \
    --name php \
    --replicas 3 \
    --publish published=9000,target=9000 \
    --env-file docker/envVars.public \
    --env-file docker/php/envVars.public \
    --env-file docker/php/envVars.prod.public \
    --env-file docker/envVars.private \
    --env-file docker/php/envVars.private \
    --host host.docker.internal:host-gateway \
    adamcameron/php-swarm:latest
    
# verify stability
docker container ls --all --format "table {{.Names}}\t{{.Status}}" | grep php
php.1.lkrg5g45mb3njmi180gupyknh    Up About a minute (healthy)
php.2.nrwt1j0zhq0bvl1rybb41nytj    Up About a minute (healthy)
php.3.gag30v8g34xmhsgper83n8u8i    Up About a minute (healthy)

# repeat this curl to verify different pods are being used
curl -s http://php-swarm.local:8080/ | grep "Instance ID"
    Instance ID: 04c8f570e5d4<br>

# use one of the containers to verify the Symfony app is running and in prod mode
docker exec php.1.lkrg5g45mb3njmi180gupyknh  bin/console about | grep -B 1 -A 2 Kernel
 -------------------- -------------------------------------------
  Kernel
 -------------------- -------------------------------------------
  Type                 App\Kernel
  Environment          prod
  Debug                false
```

## Changes

0.1 - Baseline setup copied from php8-on-k8s, with Kubernetes stuff removed and Docker Swarm stuff for dev env added
