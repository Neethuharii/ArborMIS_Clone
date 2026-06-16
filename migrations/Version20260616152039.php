<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260616152039 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'created a table for suspension details which will store information about student suspensions and the reasons for those suspensions';
    }

    public function up(Schema $schema): void
    {
        
        $this->addSql('CREATE TABLE suspension_details(
            suspension_detail_id INT AUTO_INCREMENT NOT NULL, 
            suspended_from DATETIME NOT NULL, 
            suspended_until DATETIME NOT NULL, 
            decision_made_time DATETIME NOT NULL, 
            days_lost INT NOT NULL, 
            suspension_notes LONGTEXT DEFAULT NULL, 
            created_at DATETIME NOT NULL, 
            updated_at DATETIME DEFAULT NULL, 
            deleted_at DATETIME DEFAULT NULL, 
            student_id INT NOT NULL, 
            suspension_id INT NOT NULL, 
            INDEX IDX_773A8599CB944F1A (student_id), 
            INDEX IDX_773A85995D5F8F8E (suspension_id), 
            PRIMARY KEY (suspension_detail_id),
            CONSTRAINT FK_SUSPENSION_STUDENT
                FOREIGN KEY (student_id) 
                REFERENCES students(student_id),
            CONSTRAINT FK_SUSPENSION_REASON
                FOREIGN KEY (suspension_id)
                REFERENCES suspension_reasons(suspension_id)
        )     
        DEFAULT CHARACTER SET utf8mb4');
        
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS suspension_details');  
    }
}
