<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260612050954 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Created a document type master table for managing various document types';
    }

    public function up(Schema $schema): void
    {    
        $this->addSql('CREATE TABLE IF NOT EXISTS  document_types (
                     document_type_id INT AUTO_INCREMENT NOT NULL,
                     document_type_name VARCHAR(255) NOT NULL, 
                     PRIMARY KEY (document_type_id)) 
                     DEFAULT CHARACTER SET utf8mb4');     
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS  document_types');
    }
}
