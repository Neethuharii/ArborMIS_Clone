<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;


final class Version20260610062002 extends AbstractMigration
{ public function getDescription(): string
    {
        return 'Create users table with id, email, and password columns for login';
    }

      public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT NOT NULL,
                email VARCHAR(255) NOT NULL,
                password VARCHAR(150) NOT NULL,
                PRIMARY KEY (id)
            ) DEFAULT CHARACTER SET utf8mb4
        ');

        $this->addSql('DROP TABLE IF EXISTS staff');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS users');

        $this->addSql('
            CREATE TABLE IF NOT EXISTS staff (
                id INT AUTO_INCREMENT NOT NULL,
                staff_email VARCHAR(255) NOT NULL,
                password VARCHAR(150) NOT NULL,
                PRIMARY KEY (id)
            ) DEFAULT CHARACTER SET utf8mb4
        ');
    }
}
