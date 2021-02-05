<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210205193538 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contrat CHANGE id_client id_client VARCHAR(255) NOT NULL, CHANGE id_voiture id_voiture VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE facture CHANGE id_client id_client VARCHAR(255) NOT NULL');
        $this->addSql('DROP INDEX UNIQ_E9E2810F5A6F91CE ON voiture');
        $this->addSql('ALTER TABLE voiture CHANGE id_agence id_agence VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E9E2810F12B2DC9C ON voiture (matricule)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contrat CHANGE id_client id_client VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE id_voiture id_voiture INT NOT NULL');
        $this->addSql('ALTER TABLE facture CHANGE id_client id_client VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('DROP INDEX UNIQ_E9E2810F12B2DC9C ON voiture');
        $this->addSql('ALTER TABLE voiture CHANGE id_agence id_agence VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E9E2810F5A6F91CE ON voiture (marque)');
    }
}
