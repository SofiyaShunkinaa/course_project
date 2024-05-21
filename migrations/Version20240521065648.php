<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240521065648 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE custom_item_attribute ADD item_collection_id INT NOT NULL');
        $this->addSql('ALTER TABLE custom_item_attribute ADD CONSTRAINT FK_DC45CCD1BDE5FE26 FOREIGN KEY (item_collection_id) REFERENCES item_collection (id)');
        $this->addSql('CREATE INDEX IDX_DC45CCD1BDE5FE26 ON custom_item_attribute (item_collection_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE custom_item_attribute DROP FOREIGN KEY FK_DC45CCD1BDE5FE26');
        $this->addSql('DROP INDEX IDX_DC45CCD1BDE5FE26 ON custom_item_attribute');
        $this->addSql('ALTER TABLE custom_item_attribute DROP item_collection_id');
    }
}
