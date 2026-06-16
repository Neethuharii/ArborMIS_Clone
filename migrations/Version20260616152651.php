<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;


final class Version20260616152651 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE IF NOT EXISTS current_roles (
        current_role_id INT AUTO_INCREMENT NOT NULL, 
        start_date DATE NOT NULL, 
        end_date DATE DEFAULT NULL, 
        created_at DATETIME NOT NULL, 
        modified_at DATETIME NOT NULL, 
        deleted_at DATETIME DEFAULT NULL, 
        business_role_id INT DEFAULT NULL, 
        INDEX IDX_122059C38B3099E1 (business_role_id), 
        PRIMARY KEY (current_role_id), 
        CONSTRAINT FK_BUSINESS_ROLE 
            FOREIGN KEY (business_role_id) 
            REFERENCES businessroles (role_id)
        ) DEFAULT CHARACTER SET utf8');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS current_roles');
    }
}
