<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260611112016 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create countries table with id_country and country_name columns';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE IF NOT EXISTS countries (
                id_country INT AUTO_INCREMENT NOT NULL, 
                country_name VARCHAR(255) NOT NULL, 
                PRIMARY KEY (id_country)
            ) DEFAULT CHARACTER SET utf8mb4
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS countries');
    }
    
}
