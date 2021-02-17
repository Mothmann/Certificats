<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210217151221 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE certificats (id INT AUTO_INCREMENT NOT NULL, categories_id_id INT NOT NULL, created_at DATETIME NOT NULL, active SMALLINT NOT NULL, INDEX IDX_D5486F1B7B478B1A (categories_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE certificats_user (certificats_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_26050AB6EC5037BE (certificats_id), INDEX IDX_26050AB6A76ED395 (user_id), PRIMARY KEY(certificats_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE certificats ADD CONSTRAINT FK_D5486F1B7B478B1A FOREIGN KEY (categories_id_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE certificats_user ADD CONSTRAINT FK_26050AB6EC5037BE FOREIGN KEY (certificats_id) REFERENCES certificats (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE certificats_user ADD CONSTRAINT FK_26050AB6A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE certificats_user DROP FOREIGN KEY FK_26050AB6EC5037BE');
        $this->addSql('DROP TABLE certificats');
        $this->addSql('DROP TABLE certificats_user');
    }
}
