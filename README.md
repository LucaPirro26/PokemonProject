Pokemon Project with Docker and Symfony 5

Configuration:


1. download Docker from https://www.docker.com/products/docker-desktop

2. Move to the PokemonProject directory and build the docker project with the following command:
docker-compose up -d --build

3. run the command to launch the php container:
docker exec -it php74-container bash

4. let's create database with doctrine:
php bin/console doctrine:database:create

5. let's create migration file for doctrine:
php bin/console make:migration

6. let's create database with all the tables needed:
php bin/console doctrine:migrations:migrate

7. now you should be able to use the PokemonProject Application opening the browser at:
http://localhost:8080/team/



