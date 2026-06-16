<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260615101052 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create a table for qualification checks to store timely information about the qualification checks.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE IF NOT EXISTS qualification_checks (
        qualification_checks_id INT AUTO_INCREMENT NOT NULL,
        clearance_level VARCHAR(255) NOT NULL,
        requested_date DATE NOT NULL,
        returned_date DATE NOT NULL,
        authenticated_date DATE NOT NULL,
        comment LONGTEXT DEFAULT NULL,
        created_at DATETIME NOT NULL,
        modified_at DATETIME NOT NULL,
        deleted_at DATETIME DEFAULT NULL,
        qualification_id INT NOT NULL,
        INDEX IDX_758AA8F41A75EE38 (qualification_id),
        PRIMARY KEY (qualification_checks_id),
        CONSTRAINT FK_QUALIFICATION_TYPE
            FOREIGN KEY (qualification_id)
            REFERENCES qualification_type (qualification_id)
        )DEFAULT CHARACTER SET utf8');
    }
    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS qualification_checks');
    }
}
