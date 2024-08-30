<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!!
 */
final class Version20240830100108 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project ADD name VARCHAR(200) NOT NULL, ADD location VARCHAR(500) NOT NULL, ADD stage VARCHAR(50) NOT NULL, ADD category VARCHAR(50) NOT NULL, ADD construction_start_date DATE NOT NULL, ADD description LONGTEXT DEFAULT NULL, ADD creator_id VARCHAR(6) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project DROP name, DROP location, DROP stage, DROP category, DROP construction_start_date, DROP description, DROP creator_id');
    }
}
