<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260615123654 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create a funding table for store funding allocations for students';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE IF NOT EXISTS fundings (
                    funding_id INT AUTO_INCREMENT NOT NULL,
                    funding_type_id INT NOT NULL,
                    student_id INT NOT NULL,
                    start_date DATETIME NOT NULL,
                    end_date DATETIME DEFAULT NULL,
                    description VARCHAR(255) DEFAULT NULL,
                    created_at DATETIME NOT NULL,
                    modified_at DATETIME NOT NULL,
                    deleted_at DATETIME DEFAULT NULL,
                    INDEX IDX_FUNDING_TYPE (funding_type_id),
                    INDEX IDX_STUDENT (student_id),
                    PRIMARY KEY (funding_id),
                    CONSTRAINT FK_FUNDING_TYPE
                        FOREIGN KEY (funding_type_id)
                        REFERENCES funding_types (funding_type_id),
                    CONSTRAINT FK_STUDENT
                        FOREIGN KEY (student_id)
                        REFERENCES students (student_id))
                    DEFAULT CHARACTER SET utf8mb4');
    }

    public function down(Schema $schema): void
    {  
        $this->addSql('DROP TABLE IF EXISTS fundings');
    }
}
