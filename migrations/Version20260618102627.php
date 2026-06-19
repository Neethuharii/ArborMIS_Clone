<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260618102627 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Created a table to store holiday information including holiday name and date range';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE IF NOT EXISTS holidays (
                    holiday_id INT AUTO_INCREMENT NOT NULL,
                    holiday_name VARCHAR(100) NOT NULL,
                    from_date DATE NOT NULL,
                    to_date DATE NOT NULL,
                    created_at DATETIME NOT NULL,
                    PRIMARY KEY (holiday_id)
                    ) DEFAULT CHARACTER SET utf8');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS holidays');
    }
}