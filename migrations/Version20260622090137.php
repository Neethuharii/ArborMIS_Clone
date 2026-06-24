<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260622090137 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add foreign key from classrooms.staff_id to staffs.staff_id and make staff_id nullable in classrooms table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            'ALTER TABLE classrooms
            MODIFY staff_id INT NULL,
            ADD INDEX IDX_95F95DC24D7E4AA2 (staff_id),
            ADD CONSTRAINT FK_95F95DC24D7E4AA2
            FOREIGN KEY (staff_id)
            REFERENCES staffs (staff_id)'
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql(
            'ALTER TABLE classrooms
            DROP FOREIGN KEY FK_95F95DC24D7E4AA2,
            DROP INDEX IDX_95F95DC24D7E4AA2,
            MODIFY staff_id INT NOT NULL'
        );
    }
}