<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260614130432 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create a ethnicities table with an id to identify each ethnicity uniquely';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE IF NOT EXISTS ethnicities 
        (ethnicity_id INT AUTO_INCREMENT NOT NULL, 
        ethnicity_name VARCHAR(255) NOT NULL, 
        PRIMARY KEY (ethnicity_id)) 
        DEFAULT CHARACTER SET utf8');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS ethnicities');
    }
}
