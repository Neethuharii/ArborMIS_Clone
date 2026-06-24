<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260624051027 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'create a migration to add columns for audit purpose';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE behaviour_incidents 
            ADD created_at DATETIME NOT NULL, 
            ADD modified_at DATETIME DEFAULT NULL, 
            ADD deleted_at DATETIME DEFAULT NULL'
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE behaviour_incidents 
            DROP COLUMN created_at,
            DROP COLUMN modified_at,
            DROP COLUMN deleted_at'
        );
    }
}
