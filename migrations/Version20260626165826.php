<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260626165826 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create student_points table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE student_points (
            student_point_id INT AUTO_INCREMENT NOT NULL,
            total_points INT NOT NULL,
            updated_at DATETIME NOT NULL,
            student_id INT NOT NULL,
            UNIQUE INDEX UNIQ_A98C56A9CB944F1A (student_id),
            PRIMARY KEY (student_point_id),
            CONSTRAINT FK_STUDENT_POINTS
                FOREIGN KEY (student_id)
                REFERENCES students (student_id)
        ) DEFAULT CHARACTER SET utf8mb4');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE student_points DROP FOREIGN KEY FK_STUDENT_POINTS');
        $this->addSql('DROP TABLE student_points');
    }
}