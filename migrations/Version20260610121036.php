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
        $this->addSql('
            CREATE TABLE IF NOT EXISTS attendance_codes (
                attendance_code_id INT AUTO_INCREMENT NOT NULL,
                code VARCHAR(20) NOT NULL,
                description VARCHAR(255) NOT NULL,
                category VARCHAR(50) NOT NULL,
                effective_from DATE NOT NULL,
                effective_to DATE DEFAULT NULL,
                PRIMARY KEY (attendance_code_id),
                UNIQUE INDEX UNIQ_CODE (code)
            ) DEFAULT CHARACTER SET utf8mb4
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS attendance_codes');
    }
}

