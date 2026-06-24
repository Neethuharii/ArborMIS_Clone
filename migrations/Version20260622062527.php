<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260622062527 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Altered two tables: staffs and current_roles';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE current_roles ADD staff_id INT NOT NULL');
        $this->addSql('CREATE INDEX IDX_STAFF_CURRENTROLE ON current_roles (staff_id)');

        $this->addSql('ALTER TABLE current_roles
            ADD CONSTRAINT FK_STAFF_CURRENTROLE
            FOREIGN KEY (staff_id)
            REFERENCES staffs (staff_id)');

        $this->addSql('ALTER TABLE staffs ADD role_id INT DEFAULT NULL');
        

        $this->addSql('CREATE INDEX IDX_STAFF_ROLE ON staffs (role_id)');

        $this->addSql('ALTER TABLE staffs
            ADD CONSTRAINT FK_STAFF_ROLE
            FOREIGN KEY (role_id)
            REFERENCES current_roles (current_role_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE current_roles DROP FOREIGN KEY FK_STAFF_CURRENTROLE');
        $this->addSql('ALTER TABLE staffs DROP FOREIGN KEY FK_STAFF_ROLE');
        $this->addSql('ALTER TABLE current_roles DROP COLUMN staff_id');
        $this->addSql('DROP INDEX IDX_STAFF_ROLE ON staffs');
        $this->addSql('ALTER TABLE staffs DROP COLUMN role_id');
    }
}
