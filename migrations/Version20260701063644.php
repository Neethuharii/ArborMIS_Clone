<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260701063644 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Added a new column title';
    }

    public function up(Schema $schema): void
    {
       $this->addSql('ALTER TABLE guardian ADD title VARCHAR(10) DEFAULT NULL AFTER guardian_id');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS guardian');
    }
}
