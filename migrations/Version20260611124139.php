<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260611124139 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create attendances table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE IF NOT EXISTS attendances (
                attendance_id INT AUTO_INCREMENT NOT NULL,
                student_id INT NOT NULL,
                attendance_date DATE NOT NULL,
                session VARCHAR(2) NOT NULL,
                attendance_code_id INT NOT NULL,
                late_minutes INT DEFAULT NULL,
                note TEXT DEFAULT NULL,
                marked_by_staff_id INT NOT NULL,
                marked_at DATETIME NOT NULL,
                PRIMARY KEY (attendance_id),
                INDEX IDX_ATTENDANCE_CODE_ID (attendance_code_id),
                CONSTRAINT FK_ATTENDANCE_CODE
                    FOREIGN KEY (attendance_code_id)
                    REFERENCES attendance_codes (attendance_code_id)
            ) DEFAULT CHARACTER SET utf8mb4
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS attendances');
    }
}