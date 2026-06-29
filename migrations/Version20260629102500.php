<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260629102500 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create attendance_registers table';
    }

    public function up(
        Schema $schema
    ): void {

        $this->addSql(
            'CREATE TABLE attendance_registers (
                attendance_register_id INT AUTO_INCREMENT NOT NULL,
                attendance_date DATE NOT NULL,
                session VARCHAR(2) NOT NULL,
                opened_at DATETIME NOT NULL,
                completed_at DATETIME DEFAULT NULL,
                classroom_id INT NOT NULL,
                staff_id INT NOT NULL,
                UNIQUE INDEX UNIQ_REGISTER (
                    classroom_id,
                    attendance_date,
                    session
                ),
                INDEX IDX_740F480C6278D5A8 (
                    classroom_id
                ),
                INDEX IDX_740F480CD4D57CD (
                    staff_id
                ),
                PRIMARY KEY (
                    attendance_register_id
                ),
                CONSTRAINT FK_740F480C6278D5A8
                    FOREIGN KEY (
                        classroom_id
                    )
                    REFERENCES classrooms (
                        classroom_id
                    ),
                CONSTRAINT FK_740F480CD4D57CD
                    FOREIGN KEY (
                        staff_id
                    )
                    REFERENCES staffs (
                        staff_id
                    )
            ) DEFAULT CHARACTER SET utf8mb4'
        );
    }

    public function down(
        Schema $schema
    ): void {

        $this->addSql(
            'DROP TABLE attendance_registers'
        );
    }
}