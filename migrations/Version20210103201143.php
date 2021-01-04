<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210103201143 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contrat ADD date_depart DATETIME NOT NULL');
        $this->addSql('ALTER TABLE voiture CHANGE id_agence id_agence INT NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E9E2810F5A6F91CE ON voiture (marque)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contrat DROP date_depart');
        $this->addSql('DROP INDEX UNIQ_E9E2810F5A6F91CE ON voiture');
        $this->addSql('ALTER TABLE voiture CHANGE id_agence id_agence INT DEFAULT NULL');
    }
}
