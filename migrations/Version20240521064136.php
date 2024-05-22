<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240521064136 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE item_collection ADD category_id INT NOT NULL');
        $this->addSql('ALTER TABLE item_collection ADD CONSTRAINT FK_41FC4D3812469DE2 FOREIGN KEY (category_id) REFERENCES collection_category (id)');
        $this->addSql('CREATE INDEX IDX_41FC4D3812469DE2 ON item_collection (category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE item_collection DROP FOREIGN KEY FK_41FC4D3812469DE2');
        $this->addSql('DROP INDEX IDX_41FC4D3812469DE2 ON item_collection');
        $this->addSql('ALTER TABLE item_collection DROP category_id');
    }
}