<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260617063833 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create a master table to store titles';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE IF NOT EXISTS titles 
        (title_id INT AUTO_INCREMENT NOT NULL, 
        title_name VARCHAR(255) NOT NULL, 
        PRIMARY KEY (title_id)
        ) DEFAULT CHARACTER SET utf8');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS titles');
    }
}
