<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260709053746 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Adds staff and authenticated_by relationships to qualification checks';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE qualification_checks 
            ADD staff_id INT NOT NULL, 
            ADD authenticated_by_staff_id INT DEFAULT NULL,
            CHANGE authenticated_date authenticated_date DATE DEFAULT NULL'
        );

        $this->addSql('CREATE INDEX IDX_QUAL_CHECK_STAFF ON qualification_checks (staff_id)');
        $this->addSql('CREATE INDEX IDX_QUAL_CHECK_AUTH ON qualification_checks (authenticated_by_staff_id)');

        $this->addSql('ALTER TABLE qualification_checks 
            ADD CONSTRAINT FK_STAFF FOREIGN KEY (staff_id) REFERENCES staffs (staff_id),
            ADD CONSTRAINT FK_AUTHENTICATED_STAFF FOREIGN KEY (authenticated_by_staff_id) REFERENCES staffs (staff_id)'
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE qualification_checks DROP FOREIGN KEY FK_STAFF');
        $this->addSql('ALTER TABLE qualification_checks DROP FOREIGN KEY FK_AUTHENTICATED_STAFF');

        $this->addSql('DROP INDEX IDX_QUAL_CHECK_STAFF ON qualification_checks');
        $this->addSql('DROP INDEX IDX_QUAL_CHECK_AUTH ON qualification_checks');

        $this->addSql('ALTER TABLE qualification_checks 
            DROP staff_id, 
            DROP authenticated_by_staff_id, 
            CHANGE authenticated_date authenticated_date DATE NOT NULL'
        );
    }
}
