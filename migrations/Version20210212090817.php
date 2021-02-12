<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210212090817 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE etudiant (id INT AUTO_INCREMENT NOT NULL, code_apogee VARCHAR(50) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, cne VARCHAR(255) NOT NULL, cin VARCHAR(255) NOT NULL, date_naissance DATE NOT NULL, ville_naissance VARCHAR(255) NOT NULL, pays_naissance VARCHAR(255) NOT NULL, sexe VARCHAR(255) NOT NULL, addresse VARCHAR(255) NOT NULL, annee_1ere_inscription_universite DATE NOT NULL, annee_1ere_inscription_enseignement_superieur DATE NOT NULL, annee_1ere_inscription_universite_marocaine DATE NOT NULL, code_bac VARCHAR(255) NOT NULL, serie_bac VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE etudiant');
    }
}
