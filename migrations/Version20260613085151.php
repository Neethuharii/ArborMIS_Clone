<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260613085151 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Created a relationship type  master table for managing various relationship';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE IF NOT EXISTS relationship_types (
                  relationship_type_id INT AUTO_INCREMENT NOT NULL, 
                  relationship_type_name VARCHAR(150) NOT NULL,
                  PRIMARY KEY (relationship_type_id)) 
                  DEFAULT CHARACTER SET utf8mb4');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS relationship_types');
    }
}
