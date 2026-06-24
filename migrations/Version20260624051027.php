<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260624051027 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
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
