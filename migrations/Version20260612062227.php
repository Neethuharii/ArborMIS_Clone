<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260612062227 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create classrooms table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE IF NOT EXISTS classrooms (
            classroom_id INT AUTO_INCREMENT NOT NULL,
            class_name VARCHAR(50) NOT NULL,
            staff_id INT NOT NULL,
            academic_year_id INT NOT NULL,
            created_at DATETIME NOT NULL,

            INDEX IDX_CLASSROOM_ACADEMIC_YEAR (academic_year_id),

            PRIMARY KEY (classroom_id),

            CONSTRAINT FK_CLASSROOM_ACADEMIC_YEAR
                FOREIGN KEY (academic_year_id)
                REFERENCES academicyears (academicyear_id)
        ) DEFAULT CHARACTER SET utf8mb4');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS classrooms');
    }
}