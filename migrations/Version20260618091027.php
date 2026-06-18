<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260618091027 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Modify attendances table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("
            ALTER TABLE attendances
            CHANGE student_id student_enrollment_id INT NOT NULL,
            ADD created_at DATETIME NOT NULL,
            ADD modified_at DATETIME DEFAULT NULL
        ");

        $this->addSql('CREATE INDEX IDX_9C6B8FD4DAE14AC5 ON attendances (student_enrollment_id)');

        $this->addSql('ALTER TABLE attendances ADD CONSTRAINT FK_9C6B8FD4DAE14AC5 FOREIGN KEY (student_enrollment_id) REFERENCES student_enrollments (student_enrollment_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE attendances DROP FOREIGN KEY FK_9C6B8FD4DAE14AC5');

        $this->addSql('DROP INDEX IDX_9C6B8FD4DAE14AC5 ON attendances');

        $this->addSql("
            ALTER TABLE attendances
            DROP COLUMN created_at,
            DROP COLUMN modified_at,
            CHANGE student_enrollment_id student_id INT NOT NULL
        ");
    }
}
