<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260618084318 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Created a table to store staff information, including personal details, contact information, and employment-related data';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE IF NOT EXISTS staffs (
                    staff_id INT AUTO_INCREMENT NOT NULL,
                    first_name VARCHAR(255) NOT NULL,
                    middle_name VARCHAR(255) DEFAULT NULL,
                    last_name VARCHAR(255) NOT NULL,
                    abbreviation VARCHAR(255) DEFAULT NULL,
                    date_of_birth DATE DEFAULT NULL,
                    date_of_joining DATE DEFAULT NULL,
                    staff_number INT DEFAULT NULL,
                    profile_photo VARCHAR(255) DEFAULT NULL,
                    created_at DATETIME NOT NULL,
                    modified_at DATETIME NOT NULL,
                    deleted_at DATETIME DEFAULT NULL,
                    title_id INT DEFAULT NULL,
                    gender_id INT DEFAULT NULL,
                    address_id INT DEFAULT NULL,
                    ethnicity_id INT DEFAULT NULL,
                    religion_id INT DEFAULT NULL,
                    document_id INT DEFAULT NULL,
                    PRIMARY KEY (staff_id),
                    INDEX IDX_STAFF_TITLE (title_id),
                    INDEX IDX_STAFF_GENDER (gender_id),
                    INDEX IDX_STAFF_ADDRESS (address_id),
                    INDEX IDX_STAFF_ETHNICITY (ethnicity_id),
                    INDEX IDX_STAFF_RELIGION (religion_id),
                    INDEX IDX_STAFF_DOCUMENT (document_id),
                    CONSTRAINT FK_STAFF_TITLE
                        FOREIGN KEY (title_id) REFERENCES titles (title_id),
                    CONSTRAINT FK_STAFF_GENDER
                        FOREIGN KEY (gender_id) REFERENCES genders (gender_id),
                    CONSTRAINT FK_STAFF_ADDRESS
                        FOREIGN KEY (address_id) REFERENCES address (address_id),
                    CONSTRAINT FK_STAFF_ETHNICITY
                        FOREIGN KEY (ethnicity_id) REFERENCES ethnicities (ethnicity_id),
                    CONSTRAINT FK_STAFF_RELIGION
                        FOREIGN KEY (religion_id) REFERENCES religions (religion_id),
                    CONSTRAINT FK_STAFF_DOCUMENT
                        FOREIGN KEY (document_id) REFERENCES documents (document_id)
                    ) DEFAULT CHARACTER SET utf8');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS staffs');
    }
}
