<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260614103952 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Created a card table for storing school id card details';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE IF NOT EXISTS cards (
                  card_id INT AUTO_INCREMENT NOT NULL,
                  card_number VARCHAR(150) NOT NULL UNIQUE, 
                  status VARCHAR(100) NOT NULL,
                  issued_at DATETIME NOT NULL, 
                  modified_at DATETIME NOT NULL, 
                  deleted_at DATETIME DEFAULT NULL, 
                  PRIMARY KEY (card_id)) 
                  DEFAULT CHARACTER SET utf8mb4');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS cards');
    }
}
