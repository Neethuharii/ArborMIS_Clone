<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260618022252 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Created student_enrollments table with student, academic year and classroom foreign keys';
    }


    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE IF NOT EXISTS student_enrollments (
            student_enrollment_id INT AUTO_INCREMENT NOT NULL,
            student_id INT NOT NULL,
            academic_year_id INT NOT NULL,
            classroom_id INT NOT NULL,
            created_at DATETIME NOT NULL,
            INDEX IDX_STUDENT_ENROLLMENT_STUDENT (student_id),
            INDEX IDX_STUDENT_ENROLLMENT_ACADEMIC_YEAR (academic_year_id),
            INDEX IDX_STUDENT_ENROLLMENT_CLASSROOM (classroom_id),
            PRIMARY KEY(student_enrollment_id),
            CONSTRAINT FK_STUDENT_ENROLLMENT_STUDENT
                FOREIGN KEY (student_id)
                REFERENCES students (student_id),
            CONSTRAINT FK_STUDENT_ENROLLMENT_ACADEMIC_YEAR
                FOREIGN KEY (academic_year_id)
                REFERENCES academicyears (academicyear_id),
            CONSTRAINT FK_STUDENT_ENROLLMENT_CLASSROOM
                FOREIGN KEY (classroom_id)
                REFERENCES classrooms (classroom_id)
        ) DEFAULT CHARACTER SET utf8mb4');
    }


    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS student_enrollments');
    }
}