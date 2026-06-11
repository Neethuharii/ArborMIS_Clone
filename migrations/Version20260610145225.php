<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260610145225 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'created a table for physical interventions which will store various intervention methods';
    }
    public function up(Schema $schema): void
    {
        $this->addSql(
            'CREATE TABLE IF NOT EXISTS `interventions`(
            intervention_id INT AUTO_INCREMENT NOT NULL, 
            intervention_method VARCHAR(255) NOT NULL, 
            PRIMARY KEY (intervention_id))
            DEFAULT CHARACTER SET utf8mb4'
        );
    }
    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE interventions');
    }
}

