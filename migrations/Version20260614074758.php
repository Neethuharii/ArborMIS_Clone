<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260614074758 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Created a funding type master table for managing various funding type ';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE IF NOT EXISTS funding_type (
                  funding_type_id INT AUTO_INCREMENT NOT NULL, 
                  funding_type_name VARCHAR(150) NOT NULL, 
                  PRIMARY KEY (funding_type_id)) 
                  DEFAULT CHARACTER SET utf8mb4');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS funding_type');
    }
}
