<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260615103041 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create a students table for storing information about students';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE IF NOT EXISTS students (
                    student_id INT AUTO_INCREMENT NOT NULL,
                    first_name VARCHAR(150) NOT NULL,
                    middle_name VARCHAR(150) DEFAULT NULL,
                    last_name VARCHAR(150) NOT NULL,
                    dob DATE NOT NULL,
                    upn VARCHAR(100) NULL,
                    gender_id INT NOT NULL,
                    ethnicity_id INT  NULL,
                    nationality_id INT  NULL,
                    religion_id INT  NULL,
                    document_id INT  NULL,
                    country_id INT  NULL,
                    address_id INT NOT NULL,
                    card_id INT NULL,
                    created_at DATETIME NOT NULL,
                    modified_at DATETIME NOT NULL,
                    deleted_at DATETIME DEFAULT NULL,
                    PRIMARY KEY (student_id),
                    INDEX IDX_STUDENT_GENDER (gender_id),
                    INDEX IDX_STUDENT_ETHNICITY (ethnicity_id),
                    INDEX IDX_STUDENT_NATIONALITY (nationality_id),
                    INDEX IDX_STUDENT_RELIGION (religion_id),
                    INDEX IDX_STUDENT_DOCUMENT (document_id),
                    INDEX IDX_STUDENT_COUNTRY (country_id),
                    INDEX IDX_STUDENT_ADDRESS (address_id),
                    INDEX IDX_STUDENT_CARD (card_id),
                    CONSTRAINT FK_STUDENT_GENDER 
                        FOREIGN KEY (gender_id) 
                        REFERENCES genders (gender_id),
                    CONSTRAINT FK_STUDENT_ETHNICITY
                        FOREIGN KEY (ethnicity_id) 
                        REFERENCES ethnicities (ethnicity_id),
                    CONSTRAINT FK_STUDENT_NATIONALITY 
                        FOREIGN KEY (nationality_id) 
                        REFERENCES nationality (nationality_id),
                    CONSTRAINT FK_STUDENT_RELIGION 
                        FOREIGN KEY (religion_id) 
                        REFERENCES religions (religion_id),
                    CONSTRAINT FK_STUDENT_DOCUMENT 
                        FOREIGN KEY (document_id) 
                        REFERENCES documents (document_id),
                    CONSTRAINT FK_STUDENT_COUNTRY
                        FOREIGN KEY (country_id) 
                        REFERENCES countries (country_id),
                    CONSTRAINT FK_STUDENT_ADDRESS 
                        FOREIGN KEY (address_id) 
                        REFERENCES address (address_id),
                    CONSTRAINT FK_STUDENT_CARD 
                        FOREIGN KEY (card_id) 
                        REFERENCES cards (card_id))
                    DEFAULT CHARACTER SET utf8mb4');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS students');
    }
}
