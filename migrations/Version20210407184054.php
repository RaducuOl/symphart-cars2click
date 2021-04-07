<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210407184054 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE country (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, league_id INT DEFAULT NULL, country_id INT DEFAULT NULL, date VARCHAR(100) DEFAULT NULL, time VARCHAR(100) DEFAULT NULL, timezone VARCHAR(100) DEFAULT NULL, stage VARCHAR(100) DEFAULT NULL, week VARCHAR(100) DEFAULT NULL, status VARCHAR(100) DEFAULT NULL, INDEX IDX_232B318C58AFC4DE (league_id), INDEX IDX_232B318CF92F3E70 (country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE league (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, score VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team_game (team_id INT NOT NULL, game_id INT NOT NULL, INDEX IDX_F2CAC5F7296CD8AE (team_id), INDEX IDX_F2CAC5F7E48FD905 (game_id), PRIMARY KEY(team_id, game_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C58AFC4DE FOREIGN KEY (league_id) REFERENCES league (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE team_game ADD CONSTRAINT FK_F2CAC5F7296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE team_game ADD CONSTRAINT FK_F2CAC5F7E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_team ADD CONSTRAINT FK_2FF5CA33E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE game_team ADD CONSTRAINT FK_2FF5CA33296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE score ADD location VARCHAR(100) DEFAULT NULL, ADD score VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE score ADD CONSTRAINT FK_32993751E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE score ADD CONSTRAINT FK_32993751296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)');
        $this->addSql('CREATE INDEX IDX_32993751E48FD905 ON score (game_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_32993751296CD8AE ON score (team_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318CF92F3E70');
        $this->addSql('ALTER TABLE game_team DROP FOREIGN KEY FK_2FF5CA33E48FD905');
        $this->addSql('ALTER TABLE score DROP FOREIGN KEY FK_32993751E48FD905');
        $this->addSql('ALTER TABLE team_game DROP FOREIGN KEY FK_F2CAC5F7E48FD905');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C58AFC4DE');
        $this->addSql('ALTER TABLE game_team DROP FOREIGN KEY FK_2FF5CA33296CD8AE');
        $this->addSql('ALTER TABLE score DROP FOREIGN KEY FK_32993751296CD8AE');
        $this->addSql('ALTER TABLE team_game DROP FOREIGN KEY FK_F2CAC5F7296CD8AE');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE league');
        $this->addSql('DROP TABLE team');
        $this->addSql('DROP TABLE team_game');
        $this->addSql('DROP INDEX IDX_32993751E48FD905 ON score');
        $this->addSql('DROP INDEX UNIQ_32993751296CD8AE ON score');
        $this->addSql('ALTER TABLE score DROP location, DROP score');
    }
}
