<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260615054055 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create a master table for storing different qualifications for staff';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE IF NOT EXISTS qualification_type 
        (qualification_id INT AUTO_INCREMENT NOT NULL, 
        qualification_name VARCHAR(255) NOT NULL, 
        PRIMARY KEY (qualification_id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS qualification_type');
    }
}
