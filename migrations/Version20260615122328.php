<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260615122328 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'create migration for both categories and behaviours tables, with a foreign key relationship between the two';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            'CREATE TABLE IF NOT EXISTS `behaviours`(
                behaviour_id INT AUTO_INCREMENT NOT NULL, 
                behaviour_name VARCHAR(150) NOT NULL, 
                category INT NOT NULL, 
                INDEX IDX_A280097364C19C1 (category), 
                PRIMARY KEY (behaviour_id)) 
                DEFAULT CHARACTER SET utf8mb4'
        );
        $this->addSql(
            'CREATE TABLE IF NOT EXISTS `categories`(
                category_id INT AUTO_INCREMENT NOT NULL, 
                category_name VARCHAR(50) NOT NULL, 
                category_points INT NOT NULL, 
                PRIMARY KEY (category_id)) 
                DEFAULT CHARACTER SET utf8mb4'
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS `behaviours`');
        $this->addSql('DROP TABLE IF EXISTS `categories`');
    }
}
