<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260611124139 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE attendances (attendance_id INT AUTO_INCREMENT NOT NULL, student_id INT NOT NULL, attendance_date DATE NOT NULL, session VARCHAR(2) NOT NULL, late_minutes INT DEFAULT NULL, note LONGTEXT DEFAULT NULL, marked_by_staff_id INT NOT NULL, marked_at DATETIME NOT NULL, attendance_code_id INT NOT NULL, INDEX IDX_9C6B8FD4201D1015 (attendance_code_id), PRIMARY KEY (attendance_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE attendances ADD CONSTRAINT FK_9C6B8FD4201D1015 FOREIGN KEY (attendance_code_id) REFERENCES attendance_codes (attendance_code_id)');
        $this->addSql('DROP INDEX UNIQ_CODE ON attendance_codes');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE attendances DROP FOREIGN KEY FK_9C6B8FD4201D1015');
        $this->addSql('DROP TABLE attendances');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CODE ON attendance_codes (code)');
    }
}
