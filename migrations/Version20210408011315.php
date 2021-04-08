<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210408011315 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE game_score (game_id INT NOT NULL, score_id INT NOT NULL, INDEX IDX_AA4EDEE48FD905 (game_id), INDEX IDX_AA4EDE12EB0A51 (score_id), PRIMARY KEY(game_id, score_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE score_game (score_id INT NOT NULL, game_id INT NOT NULL, INDEX IDX_933B0FA12EB0A51 (score_id), INDEX IDX_933B0FAE48FD905 (game_id), PRIMARY KEY(score_id, game_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE game_score ADD CONSTRAINT FK_AA4EDEE48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE game_score ADD CONSTRAINT FK_AA4EDE12EB0A51 FOREIGN KEY (score_id) REFERENCES score (id)');
        $this->addSql('ALTER TABLE score_game ADD CONSTRAINT FK_933B0FA12EB0A51 FOREIGN KEY (score_id) REFERENCES score (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE score_game ADD CONSTRAINT FK_933B0FAE48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE score DROP INDEX UNIQ_32993751296CD8AE, ADD INDEX IDX_32993751296CD8AE (team_id)');
        $this->addSql('ALTER TABLE score DROP FOREIGN KEY FK_32993751E48FD905');
        $this->addSql('DROP INDEX IDX_32993751E48FD905 ON score');
        $this->addSql('ALTER TABLE score DROP game_id, DROP team');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE game_score');
        $this->addSql('DROP TABLE score_game');
        $this->addSql('ALTER TABLE score DROP INDEX IDX_32993751296CD8AE, ADD UNIQUE INDEX UNIQ_32993751296CD8AE (team_id)');
        $this->addSql('ALTER TABLE score ADD game_id INT DEFAULT NULL, ADD team VARCHAR(100) CHARACTER SET latin1 DEFAULT NULL COLLATE `latin1_swedish_ci`');
        $this->addSql('ALTER TABLE score ADD CONSTRAINT FK_32993751E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('CREATE INDEX IDX_32993751E48FD905 ON score (game_id)');
    }
}
