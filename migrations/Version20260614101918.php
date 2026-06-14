<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260614101918 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Created a guardian table for storing details about guardian';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE IF NOT EXISTS guardian (
                   guardian_id INT AUTO_INCREMENT NOT NULL,
                   first_name VARCHAR(100) NOT NULL,
                   middle_name VARCHAR(100) DEFAULT NULL,
                   last_name VARCHAR(100) NOT NULL,
                   gender_id INT NOT NULL,
                   created_at DATETIME NOT NULL,
                   modified_at DATETIME NOT NULL,
                   deleted_at DATETIME DEFAULT NULL,
                   INDEX IDX_GUARDIAN_GENDER (gender_id),
                   PRIMARY KEY (guardian_id),
                   CONSTRAINT FK_GUARDIAN_GENDER FOREIGN KEY (gender_id)
                   REFERENCES genders (gender_id))
                   DEFAULT CHARACTER SET utf8mb4');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS guardian');
    }
}
