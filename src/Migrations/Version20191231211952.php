<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191231211952 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tablero (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, grid LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', INDEX IDX_5AF9F559A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tablero ADD CONSTRAINT FK_5AF9F559A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE juego ADD jugador1_id INT NOT NULL');
        $this->addSql('ALTER TABLE juego ADD CONSTRAINT FK_F0EC403D390198F4 FOREIGN KEY (jugador1_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F0EC403D390198F4 ON juego (jugador1_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE tablero');
        $this->addSql('ALTER TABLE juego DROP FOREIGN KEY FK_F0EC403D390198F4');
        $this->addSql('DROP INDEX UNIQ_F0EC403D390198F4 ON juego');
        $this->addSql('ALTER TABLE juego DROP jugador1_id');
    }
}
