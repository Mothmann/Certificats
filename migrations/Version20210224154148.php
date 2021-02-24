<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210224154148 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE module_semestre');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE module_semestre (module_id INT NOT NULL, semestre_id INT NOT NULL, INDEX IDX_15A85C425577AFDB (semestre_id), INDEX IDX_15A85C42AFC2B591 (module_id), PRIMARY KEY(module_id, semestre_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE module_semestre ADD CONSTRAINT FK_15A85C425577AFDB FOREIGN KEY (semestre_id) REFERENCES semestre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE module_semestre ADD CONSTRAINT FK_15A85C42AFC2B591 FOREIGN KEY (module_id) REFERENCES module (id) ON DELETE CASCADE');
    }
}
