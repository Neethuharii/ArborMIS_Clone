<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260629084501 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Modified the staff entity to store nationality, country and id card for a staff';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(' ALTER TABLE staffs 
                        ADD nationality_id INT DEFAULT NULL, 
                        ADD country_id INT DEFAULT NULL, 
                        ADD card_id INT DEFAULT NULL,
                        ADD INDEX IDX_STAFF_NATIONALITY (nationality_id),
                        ADD INDEX IDX_STAFF_COUNTRY (country_id),
                        ADD INDEX IDX_STAFF_IDCARD (card_id),
                        ADD CONSTRAINT FK_STAFF_NATIONALITY
                            FOREIGN KEY (nationality_id) REFERENCES nationality (nationality_id),
                        ADD CONSTRAINT FK_STAFF_COUNTRY 
                            FOREIGN KEY (country_id) REFERENCES countries (country_id),
                        ADD CONSTRAINT FK_STAFF_IDCARD 
                            FOREIGN KEY (card_id) REFERENCES cards (card_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE staffs 
                       DROP FOREIGN KEY FK_STAFF_NATIONALITY,
                       DROP FOREIGN KEY FK_STAFF_COUNTRY,
                       DROP FOREIGN KEY FK_STAFF_IDCARD');

        $this->addSql('ALTER TABLE staffs 
                       DROP INDEX IDX_STAFF_NATIONALITY,
                       DROP INDEX IDX_STAFF_COUNTRY,
                       DROP INDEX IDX_STAFF_IDCARD,
                       DROP nationality_id, 
                       DROP country_id, 
                       DROP card_id');
    }
}
