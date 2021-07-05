<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210701170918 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ability (id INT AUTO_INCREMENT NOT NULL, pokemon_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_35CFEE3C2FE71C3E (pokemon_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pokemon (id INT AUTO_INCREMENT NOT NULL, team_id INT NOT NULL, name VARCHAR(255) NOT NULL, base_experience INT NOT NULL, INDEX IDX_62DC90F3296CD8AE (team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, pokemon_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_8CDE57292FE71C3E (pokemon_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ability ADD CONSTRAINT FK_35CFEE3C2FE71C3E FOREIGN KEY (pokemon_id) REFERENCES pokemon (id)');
        $this->addSql('ALTER TABLE pokemon ADD CONSTRAINT FK_62DC90F3296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE type ADD CONSTRAINT FK_8CDE57292FE71C3E FOREIGN KEY (pokemon_id) REFERENCES pokemon (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ability DROP FOREIGN KEY FK_35CFEE3C2FE71C3E');
        $this->addSql('ALTER TABLE type DROP FOREIGN KEY FK_8CDE57292FE71C3E');
        $this->addSql('ALTER TABLE pokemon DROP FOREIGN KEY FK_62DC90F3296CD8AE');
        $this->addSql('DROP TABLE ability');
        $this->addSql('DROP TABLE pokemon');
        $this->addSql('DROP TABLE team');
        $this->addSql('DROP TABLE type');
    }
}
