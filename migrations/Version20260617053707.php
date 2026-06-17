<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260617053707 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Modified address table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE address
                 MODIFY address1 VARCHAR(255) NULL,
                 MODIFY city VARCHAR(255) NULL,
                 MODIFY email_address VARCHAR(255) NULL,
                 MODIFY phone_number VARCHAR(30) NULL;');

       $this->addSql('ALTER TABLE students    
                 MODIFY ethnicity_id INT NULL,
                 MODIFY nationality_id INT NULL,
                 MODIFY religion_id INT NULL,
                 MODIFY document_id INT NULL,
                 MODIFY country_id INT NULL,
                 MODIFY address_id INT NULL,
                 MODIFY upn VARCHAR(100) NULL,
                 MODIFY card_id INT NULL;');
    }

    public function down(Schema $schema): void
    {
         $this->addSql('DROP TABLE IF EXISTS address');
        $this->addSql('DROP TABLE IF EXISTS students');
    }
}
