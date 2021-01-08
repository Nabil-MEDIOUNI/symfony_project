<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210102121446 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE voiture (id INT AUTO_INCREMENT NOT NULL, matricule VARCHAR(20) NOT NULL, marque VARCHAR(15) NOT NULL, couleur VARCHAR(30) NOT NULL, carburant VARCHAR(20) NOT NULL, nbr_place INT NOT NULL, description VARCHAR(300) NOT NULL, disponibilite TINYINT(1) NOT NULL, datemiseencirculation DATE NOT NULL, id_agence INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE voiture');
    }
}
