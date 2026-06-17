<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260617053707 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Modified address table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE address
                 MODIFY address1 VARCHAR(255) NULL,
                 MODIFY city VARCHAR(255) NULL,
                 MODIFY email_address VARCHAR(255) NULL,
                 MODIFY phone_number VARCHAR(30) NULL;');
    }

    public function down(Schema $schema): void
    {
         $this->addSql('DROP TABLE IF EXISTS address');
    }
}
