<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200108231227 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE juego ADD jugador2_id INT NULL');
        $this->addSql('ALTER TABLE juego ADD CONSTRAINT FK_F0EC403D2BB4371A FOREIGN KEY (jugador2_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_F0EC403D2BB4371A ON juego (jugador2_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE juego DROP FOREIGN KEY FK_F0EC403D2BB4371A');
        $this->addSql('DROP INDEX IDX_F0EC403D2BB4371A ON juego');
        $this->addSql('ALTER TABLE juego DROP jugador2_id');
    }
}
