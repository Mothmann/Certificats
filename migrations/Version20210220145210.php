<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210220145210 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE certificats ADD user_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE certificats ADD CONSTRAINT FK_D5486F1B9D86650F FOREIGN KEY (user_id_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_D5486F1B9D86650F ON certificats (user_id_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE certificats DROP FOREIGN KEY FK_D5486F1B9D86650F');
        $this->addSql('DROP INDEX IDX_D5486F1B9D86650F ON certificats');
        $this->addSql('ALTER TABLE certificats DROP user_id_id');
    }
}
