<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260619061431 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'add a column for storing the document path for suspension details';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE suspension_details ADD document_path VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE suspension_details DROP document_path');
    }
}
