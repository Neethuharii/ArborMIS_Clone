<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260610121036 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create attendance_codes table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("
            CREATE TABLE attendance_codes (
                attendance_code_id INT AUTO_INCREMENT NOT NULL,
                academic_year_id INT NOT NULL,
                code VARCHAR(20) NOT NULL,
                description VARCHAR(255) NOT NULL,
                category VARCHAR(50) NOT NULL,
                is_active TINYINT(1) NOT NULL DEFAULT 1,
                created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)',
                modified_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
                INDEX IDX_ATTENDANCE_CODES_ACADEMIC_YEAR (academic_year_id),
                UNIQUE INDEX UNIQ_ATTENDANCE_CODE_YEAR (academic_year_id, code),
                PRIMARY KEY (attendance_code_id),
                CONSTRAINT FK_ATTENDANCE_CODES_ACADEMIC_YEAR
                    FOREIGN KEY (academic_year_id)
                    REFERENCES academic_years (academicyear_id)
            ) DEFAULT CHARACTER SET utf8mb4
              COLLATE `utf8mb4_unicode_ci`
              ENGINE = InnoDB
        ");
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS attendance_codes');
    }
}