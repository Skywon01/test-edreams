<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241209144540 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tache ADD COLUMN date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE tache ADD COLUMN get_created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE tache ADD COLUMN set_created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE tache ADD COLUMN get_updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE tache ADD COLUMN set_updated_at DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__tache AS SELECT id, titre, description, statut FROM tache');
        $this->addSql('DROP TABLE tache');
        $this->addSql('CREATE TABLE tache (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL, statut VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO tache (id, titre, description, statut) SELECT id, titre, description, statut FROM __temp__tache');
        $this->addSql('DROP TABLE __temp__tache');
    }
}
