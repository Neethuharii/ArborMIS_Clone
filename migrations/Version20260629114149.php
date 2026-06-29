<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260629114149 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Change datatype of status column to boolean';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE cards MODIFY status TINYINT(1) NOT NULL DEFAULT 1;');
    }

    public function down(Schema $schema): void
    {    
        $this->addSql('DROP TABLE IF EXISTS cards');
    }
}
