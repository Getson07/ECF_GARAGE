<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230907184419 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE brand (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car (id INT AUTO_INCREMENT NOT NULL, poster_id INT NOT NULL, model_id INT NOT NULL, name VARCHAR(100) NOT NULL, images LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', price INT NOT NULL, fiscal_power VARCHAR(20) DEFAULT NULL, engine_power VARCHAR(20) NOT NULL, euro_standard VARCHAR(50) DEFAULT NULL, crit_air VARCHAR(10) DEFAULT NULL, combined_consumption VARCHAR(100) DEFAULT NULL, co2_emission VARCHAR(20) DEFAULT NULL, posted_at DATETIME NOT NULL, INDEX IDX_773DE69D5BB66C05 (poster_id), INDEX IDX_773DE69D7975B7E7 (model_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car_caracteristic (id INT AUTO_INCREMENT NOT NULL, related_car_id INT NOT NULL, year_of_launch DATE NOT NULL, origin VARCHAR(50) DEFAULT NULL, technichal_control VARCHAR(100) NOT NULL, first_hand TINYINT(1) NOT NULL, energy VARCHAR(20) NOT NULL, gearbox VARCHAR(100) NOT NULL, color VARCHAR(20) NOT NULL, number_of_doors SMALLINT NOT NULL, number_of_seats SMALLINT NOT NULL, length SMALLINT DEFAULT NULL, trunk_volume INT DEFAULT NULL, UNIQUE INDEX UNIQ_351D30B16F0A8E39 (related_car_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(20) NOT NULL, lastname VARCHAR(20) NOT NULL, email VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, user_id INT DEFAULT NULL, message LONGTEXT NOT NULL, rate SMALLINT DEFAULT NULL, INDEX IDX_9474526C19EB6921 (client_id), INDEX IDX_9474526CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, sender_firstname VARCHAR(20) NOT NULL, sender_lastname VARCHAR(20) NOT NULL, sender_email VARCHAR(100) NOT NULL, subject VARCHAR(255) NOT NULL, message LONGTEXT NOT NULL, INDEX IDX_4C62E63819EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipment_options (id INT AUTO_INCREMENT NOT NULL, related_car_id INT NOT NULL, exterior_and_chassis LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', interior LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', security LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', security_lock VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_A64E35686F0A8E39 (related_car_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE model (id INT AUTO_INCREMENT NOT NULL, brand_id INT NOT NULL, name VARCHAR(100) NOT NULL, INDEX IDX_D79572D944F5D008 (brand_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE opening_hours (id INT AUTO_INCREMENT NOT NULL, scheduler_id INT NOT NULL, day VARCHAR(20) NOT NULL, opening_time TIME NOT NULL, closing_time TIME NOT NULL, start_break_time TIME NOT NULL, end_of_break TIME NOT NULL, INDEX IDX_2640C10BA9D0F7D9 (scheduler_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, poster_id INT NOT NULL, title VARCHAR(100) NOT NULL, description LONGTEXT NOT NULL, image VARCHAR(255) DEFAULT NULL, INDEX IDX_E19D9AD25BB66C05 (poster_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, firstname VARCHAR(20) NOT NULL, lastname VARCHAR(20) NOT NULL, gender VARCHAR(10) NOT NULL, date_of_birth DATE NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D5BB66C05 FOREIGN KEY (poster_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D7975B7E7 FOREIGN KEY (model_id) REFERENCES model (id)');
        $this->addSql('ALTER TABLE car_caracteristic ADD CONSTRAINT FK_351D30B16F0A8E39 FOREIGN KEY (related_car_id) REFERENCES car (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E63819EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE equipment_options ADD CONSTRAINT FK_A64E35686F0A8E39 FOREIGN KEY (related_car_id) REFERENCES car (id)');
        $this->addSql('ALTER TABLE model ADD CONSTRAINT FK_D79572D944F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id)');
        $this->addSql('ALTER TABLE opening_hours ADD CONSTRAINT FK_2640C10BA9D0F7D9 FOREIGN KEY (scheduler_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD25BB66C05 FOREIGN KEY (poster_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D5BB66C05');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D7975B7E7');
        $this->addSql('ALTER TABLE car_caracteristic DROP FOREIGN KEY FK_351D30B16F0A8E39');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C19EB6921');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CA76ED395');
        $this->addSql('ALTER TABLE contact DROP FOREIGN KEY FK_4C62E63819EB6921');
        $this->addSql('ALTER TABLE equipment_options DROP FOREIGN KEY FK_A64E35686F0A8E39');
        $this->addSql('ALTER TABLE model DROP FOREIGN KEY FK_D79572D944F5D008');
        $this->addSql('ALTER TABLE opening_hours DROP FOREIGN KEY FK_2640C10BA9D0F7D9');
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD25BB66C05');
        $this->addSql('DROP TABLE brand');
        $this->addSql('DROP TABLE car');
        $this->addSql('DROP TABLE car_caracteristic');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE equipment_options');
        $this->addSql('DROP TABLE model');
        $this->addSql('DROP TABLE opening_hours');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE user');
    }
}
