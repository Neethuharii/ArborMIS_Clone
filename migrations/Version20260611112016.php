<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260611112016 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create countries table with country_id and country_name columns';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE IF NOT EXISTS countries (
                country_id INT AUTO_INCREMENT NOT NULL, 
                country_name VARCHAR(255) NOT NULL, 
                PRIMARY KEY (country_id)
            ) DEFAULT CHARACTER SET utf8mb4
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS countries');
    }
    
}
