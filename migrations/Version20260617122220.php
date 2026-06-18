<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260617122220 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Added a new field profile image in student table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE students
                    ADD profile_image VARCHAR(255) NULL AFTER card_id;');
    }

    public function down(Schema $schema): void
    {
          $this->addSql('DROP TABLE IF EXISTS students');
    }
}
