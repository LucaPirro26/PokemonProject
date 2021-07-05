Pokemon Project with Docker and Symfony 5

Configuration:


1. download Docker from https://www.docker.com/products/docker-desktop


2. Move to the PokemonProject directory and build the docker project with the following command:
	docker-compose up -d --build


3. run the command to launch the mysql container:
docker exec -it mysql8-container bash

after that, type in the console:
   mysql -u root -p

then type: 
   root

let's create the database:
   create database pokemonproject; 

use it: 
   use pokemonproject;


now let's create the tables of the application copying and pasting sql scripts:

CREATE TABLE ability (id INT AUTO_INCREMENT NOT NULL, pokemon_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_35CFEE3C2FE71C3E (pokemon_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;


CREATE TABLE pokemon (id INT AUTO_INCREMENT NOT NULL, team_id INT NOT NULL, name VARCHAR(255) NOT NULL, base_experience INT NOT NULL, INDEX IDX_62DC90F3296CD8AE (team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;


CREATE TABLE team (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;


CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, pokemon_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_8CDE57292FE71C3E (pokemon_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;


ALTER TABLE ability ADD CONSTRAINT FK_35CFEE3C2FE71C3E FOREIGN KEY (pokemon_id) REFERENCES pokemon (id);


ALTER TABLE pokemon ADD CONSTRAINT FK_62DC90F3296CD8AE FOREIGN KEY (team_id) REFERENCES team (id);


ALTER TABLE type ADD CONSTRAINT FK_8CDE57292FE71C3E FOREIGN KEY (pokemon_id) REFERENCES pokemon (id);

4. now you should be able to use the PokemonProject Application opening the browser at:
    http://localhost:8080/team/



