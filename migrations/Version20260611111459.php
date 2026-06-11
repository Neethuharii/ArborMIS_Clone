<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
final class Version20260611111459 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create religions master table with religion_id and gender_type columns';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE genders');
        $this->addSql('ALTER TABLE religions MODIFY religion_id INT NOT NULL');
        $this->addSql('ALTER TABLE religions CHANGE religion_id id INT AUTO_INCREMENT NOT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE genders (gender_id INT AUTO_INCREMENT NOT NULL, gender_type VARCHAR(150) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, PRIMARY KEY (gender_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE religions MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE religions CHANGE id religion_id INT AUTO_INCREMENT NOT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (religion_id)');
    }
}
