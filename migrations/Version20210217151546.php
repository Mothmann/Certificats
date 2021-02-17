<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210217151546 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE certificats DROP FOREIGN KEY FK_D5486F1B7B478B1A');
        $this->addSql('DROP INDEX IDX_D5486F1B7B478B1A ON certificats');
        $this->addSql('ALTER TABLE certificats CHANGE categories_id_id categories_id INT NOT NULL');
        $this->addSql('ALTER TABLE certificats ADD CONSTRAINT FK_D5486F1BA21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id)');
        $this->addSql('CREATE INDEX IDX_D5486F1BA21214B7 ON certificats (categories_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE certificats DROP FOREIGN KEY FK_D5486F1BA21214B7');
        $this->addSql('DROP INDEX IDX_D5486F1BA21214B7 ON certificats');
        $this->addSql('ALTER TABLE certificats CHANGE categories_id categories_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE certificats ADD CONSTRAINT FK_D5486F1B7B478B1A FOREIGN KEY (categories_id_id) REFERENCES categories (id)');
        $this->addSql('CREATE INDEX IDX_D5486F1B7B478B1A ON certificats (categories_id_id)');
    }
}
