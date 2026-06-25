<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260624112011 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create a migration to store physical intervention methods used by staff during a behaviour incident';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE IF NOT EXISTS intervention_detail (
            intervention_detail_id INT AUTO_INCREMENT NOT NULL, 
            behaviour_incident_id INT NOT NULL, 
            staff_id INT DEFAULT NULL, 
            intervention_id INT DEFAULT NULL, 
            student_id INT DEFAULT NULL, 
            created_at DATETIME NOT NULL, 
            modified_at DATETIME DEFAULT NULL, 
            deleted_at DATETIME DEFAULT NULL, 
            INDEX IDX_C4A65DB6FAD6DB23 (behaviour_incident_id), 
            INDEX IDX_C4A65DB6D4D57CD (staff_id), 
            INDEX IDX_C4A65DB68EAE3863 (intervention_id), 
            INDEX IDX_C4A65DB6CB944F1A (student_id), 
            PRIMARY KEY (intervention_detail_id),
            CONSTRAINT FK_INTERVENTION_DETAIL_INCIDENT
                FOREIGN KEY (behaviour_incident_id)
                REFERENCES behaviour_incidents (incident_id),
            CONSTRAINT FK_INTERVENTION_DETAIL_STAFF
                FOREIGN KEY (staff_id)
                REFERENCES staffs (staff_id),
            CONSTRAINT FK_INTERVENTION_DETAIL_INTERVENTION
                FOREIGN KEY (intervention_id)
                REFERENCES interventions (intervention_id),
            CONSTRAINT FK_INTERVENTION_DETAIL_STUDENT
                FOREIGN KEY (student_id)
                REFERENCES students (student_id)
            ) 
            DEFAULT CHARACTER SET utf8mb4');

    }
    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE intervention_detail');
        
    }
}
