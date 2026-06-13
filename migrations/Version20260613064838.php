<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260613064838 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Created a funding type  master table for managing various funding types';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE  IF NOT EXISTS funding_types (
                  funding_type_id INT AUTO_INCREMENT NOT NULL,
                  funding_type_name VARCHAR(255) NOT NULL, 
                  PRIMARY KEY (funding_type_id)) 
                  DEFAULT CHARACTER SET utf8mb4');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS funding_types');
    }
}
