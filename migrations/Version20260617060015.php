<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260617060015 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create academicyears table to store academic year information';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE IF NOT EXISTS academicyears (
            academicyear_id INT AUTO_INCREMENT NOT NULL,
            name VARCHAR(25) NOT NULL,
            start_date DATE NOT NULL,
            end_date DATE NOT NULL,
            created_at DATETIME NOT NULL,
            PRIMARY KEY (academicyear_id)
        )
        DEFAULT CHARACTER SET utf8mb4');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS academicyears');
    }
}