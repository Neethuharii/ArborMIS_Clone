<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260614122021 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Created entity Suspension Reasons for adding various suspension reasons';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            'CREATE TABLE IF NOT EXISTS `suspension_reasons`(
            suspension_id INT AUTO_INCREMENT NOT NULL, 
            suspension_reason VARCHAR(50) NOT NULL, 
            PRIMARY KEY (suspension_id)) 
            DEFAULT CHARACTER SET utf8mb4'
        );    
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS suspension_reasons');
    }
}

