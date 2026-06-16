<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260615172026 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create a student guardian mapping table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE IF NOT EXISTS student_guardian_relation (
                   relation_id INT AUTO_INCREMENT NOT NULL,
                   relationship_type_id INT NOT NULL,
                   student_id INT NOT NULL,
                   guardian_id INT NOT NULL,
                   primary_relation TINYINT(1) NOT NULL,
                   INDEX IDX_RELATIONSHIP_TYPE (relationship_type_id),
                   INDEX IDX_STUDENT (student_id),
                   INDEX IDX_GUARDIAN (guardian_id),
                   PRIMARY KEY (relation_id),
                   CONSTRAINT FK_RELATIONSHIP_TYPE
                        FOREIGN KEY (relationship_type_id)
                        REFERENCES relationship_types (relationship_type_id),
                   CONSTRAINT FK_STUDENT
                        FOREIGN KEY (student_id)
                        REFERENCES students (student_id),
                   CONSTRAINT FK_GUARDIAN
                        FOREIGN KEY (guardian_id)
                        REFERENCES guardian (guardian_id))
                   DEFAULT CHARACTER SET utf8mb4');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF NOT EXISTS student_guardian_relation');
    }
}
