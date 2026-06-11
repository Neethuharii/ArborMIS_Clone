<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
final class Version20260611102542 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create religions master table with religion_id and religion_name columns';
    }

    public function up(Schema $schema): void
    {  
        $this->addSql('
            CREATE TABLE IF NOT EXISTS religions
                (religion_id INT AUTO_INCREMENT NOT NULL, 
                religion_name VARCHAR(255) NOT NULL,
                PRIMARY KEY (religion_id))
                DEFAULT CHARACTER SET utf8mb4');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS religions');
    }
}
