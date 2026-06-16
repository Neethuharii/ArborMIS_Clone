<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260615121850 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create a table for business roles to store different names of roles, and their salaries.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE IF NOT EXISTS businessroles 
        (role_id INT AUTO_INCREMENT NOT NULL, 
        name_of_role VARCHAR(255) NOT NULL, 
        salary DOUBLE PRECISION NOT NULL, 
        PRIMARY KEY (role_id)) 
        DEFAULT CHARACTER SET utf8');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS businessroles');
    }
}
