<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260614091424 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Created a document table for managing document details';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE IF NOT EXISTS documents (
                  document_id INT AUTO_INCREMENT NOT NULL,
                  document_type_id INT NOT NULL,
                  document_number VARCHAR(100) NOT NULL,
                  issue_date DATE NOT NULL,
                  expiry_date DATE NOT NULL,
                  modified_at DATETIME NOT NULL,
                  deleted_at DATETIME DEFAULT NULL,
                  PRIMARY KEY (document_id),
                  INDEX IDX_DOCUMENT_TYPE (document_type_id),
                  CONSTRAINT FK_DOCUMENT_TYPE
                  FOREIGN KEY (document_type_id)
                  REFERENCES document_types (document_type_id))
                  DEFAULT CHARACTER SET utf8mb4');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS documents');
    }
}
