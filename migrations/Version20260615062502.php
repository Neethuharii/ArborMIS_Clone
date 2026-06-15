<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;


final class Version20260615062502 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create tables for nationalities';
    }

    public function up(Schema $schema): void
    {
         $this->addSql('CREATE TABLE IF NOT EXISTS nationality 
         (nationality_id INT AUTO_INCREMENT NOT NULL, 
         nationality_status VARCHAR(100) NOT NULL, 
         PRIMARY KEY (nationality_id)) 
         DEFAULT CHARACTER SET utf8');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS nationality');
    }
}
