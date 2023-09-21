<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230916222111 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car CHANGE fiscal_power fiscal_power VARCHAR(255) DEFAULT NULL, CHANGE engine_power engine_power VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE client CHANGE firstname firstname VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE contact CHANGE sender_firstname sender_firstname VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE firstname firstname VARCHAR(100) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car CHANGE fiscal_power fiscal_power VARCHAR(20) DEFAULT NULL, CHANGE engine_power engine_power VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE client CHANGE firstname firstname VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE contact CHANGE sender_firstname sender_firstname VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE firstname firstname VARCHAR(20) NOT NULL');
    }
}
