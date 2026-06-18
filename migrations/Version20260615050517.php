<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;


final class Version20260615050517 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create address table with three fields for address, city, post_code, county, email_address, phone_number';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE IF NOT EXISTS address 
    (
        address_id INT AUTO_INCREMENT NOT NULL, 
        address1 VARCHAR(255) DEFAULT NULL, 
        address2 VARCHAR(255) DEFAULT NULL, 
        address3 VARCHAR(255) DEFAULT NULL, 
        city VARCHAR(255) DEFAULT NULL,
        post_code VARCHAR(20) DEFAULT NULL, 
        county VARCHAR(255) DEFAULT NULL,   
        email_address VARCHAR(255) DEFAULT NULL, 
        phone_number VARCHAR(30) DEFAULT NULL,  
        created_at DATETIME NOT NULL, 
        modified_at DATETIME NOT NULL, 
        deleted_at DATETIME DEFAULT NULL, 
        PRIMARY KEY (address_id)
    ) 
    DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS address');
    }
}
