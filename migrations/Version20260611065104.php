<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;


final class Version20260611065104 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create gender master table with id and gender_type columns';
    }

    public function up(Schema $schema): void
    {
       
        $this->addSql('CREATE TABLE IF NOT EXISTS gender (id INT AUTO_INCREMENT NOT NULL, gender_type VARCHAR(150) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
    }

    public function down(Schema $schema): void
    {
     
        $this->addSql('DROP TABLE IF EXISTS gender');
    }
}
