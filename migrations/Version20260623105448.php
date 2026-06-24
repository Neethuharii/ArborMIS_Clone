<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260623105448 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create a behaviour incident table for storing behaviour incidents';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE behaviour_incidents (
            incident_id INT AUTO_INCREMENT NOT NULL, 
            incident_date DATE NOT NULL, 
            incident_time TIME NOT NULL, 
            incident_summary LONGTEXT DEFAULT NULL, 
            behaviour_id INT NOT NULL, 
            assigned_staff_id INT NOT NULL, 
            room_id INT DEFAULT NULL, 
            INDEX IDX_B99368A2F3A0E8C5 (behaviour_id), 
            INDEX IDX_B99368A2704051C4 (assigned_staff_id), 
            INDEX IDX_B99368A254177093 (room_id), 
            PRIMARY KEY (incident_id),
            CONSTRAINT FK_BEHAVIOUR_INCIDENT
                FOREIGN KEY (behaviour_id)
                REFERENCES behaviours(behaviour_id),
            CONSTRAINT FK_ASSIGNED_STAFF
                FOREIGN KEY (assigned_staff_id)
                REFERENCES staffs(staff_id),
            CONSTRAINT FK_INCIDENT_ROOM
                FOREIGN KEY (room_id)
                REFERENCES classrooms(classroom_id)
            ) 
            DEFAULT CHARACTER SET utf8mb4');

        $this->addSql('CREATE TABLE behaviour_incidents_students (
            incident_id INT NOT NULL, 
            student_id INT NOT NULL, 
            INDEX IDX_A010F7AA59E53FB9 (incident_id), 
            INDEX IDX_A010F7AACB944F1A (student_id), 
            PRIMARY KEY (incident_id, student_id),
            CONSTRAINT FK_BEHAVIOUR_INCIDENTS_INCIDENT
                FOREIGN KEY (incident_id)
                REFERENCES behaviour_incidents(incident_id),
            CONSTRAINT FK_BEHAVIOUR_INCIDENT_STUDENT
                FOREIGN KEY (student_id)
                REFERENCES students(student_id)
            ) 
            DEFAULT CHARACTER SET utf8mb4');

        $this->addSql('CREATE TABLE behaviour_incidents_staffs (
            incident_id INT NOT NULL, 
            staff_id INT NOT NULL, 
            INDEX IDX_3E31A7B359E53FB9 (incident_id), 
            INDEX IDX_3E31A7B3D4D57CD (staff_id), 
            PRIMARY KEY (incident_id, staff_id),
            CONSTRAINT FK_INCIDENT_STAFF_INCIDENT
                FOREIGN KEY (incident_id)
                REFERENCES behaviour_incidents (incident_id),
            CONSTRAINT FK_INCIDENT_STAFF_STAFF
                FOREIGN KEY (staff_id)
                REFERENCES staffs (staff_id)
            ) 
            DEFAULT CHARACTER SET utf8mb4');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS behaviour_incidents');
        $this->addSql('DROP TABLE IF EXISTS behaviour_incidents_students');
        $this->addSql('DROP TABLE IF EXISTS behaviour_incidents_staffs');
    }
}
