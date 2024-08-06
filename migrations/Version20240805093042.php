<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240805093042 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE assignement (id INT AUTO_INCREMENT NOT NULL, task_id INT DEFAULT NULL, employee_id INT DEFAULT NULL, INDEX IDX_E752B36A8DB60186 (task_id), INDEX IDX_E752B36A8C03F15C (employee_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, company VARCHAR(255) NOT NULL, phone_number VARCHAR(15) NOT NULL, mail VARCHAR(255) NOT NULL, adress LONGTEXT NOT NULL, zipcode VARCHAR(11) NOT NULL, city VARCHAR(50) NOT NULL, siren VARCHAR(255) NOT NULL, siret VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE job (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, hour_rate DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participate (id INT AUTO_INCREMENT NOT NULL, job_id INT NOT NULL, project_id INT NOT NULL, employee_id INT NOT NULL, INDEX IDX_D02B138BE04EA9 (job_id), INDEX IDX_D02B138166D1F9C (project_id), INDEX IDX_D02B1388C03F15C (employee_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, manages_id INT NOT NULL, state_of_project_id INT NOT NULL, client_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, start_date DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', end_date DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', INDEX IDX_2FB3D0EEC0825306 (manages_id), INDEX IDX_2FB3D0EECC2FD2E5 (state_of_project_id), INDEX IDX_2FB3D0EE19EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE state_of_project (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE state_of_task (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE task (id INT AUTO_INCREMENT NOT NULL, type_of_task_id INT DEFAULT NULL, state_of_task_id INT DEFAULT NULL, project_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, start_date DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', end_date DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', duration_real DOUBLE PRECISION NOT NULL, start_date_forecast DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', end_date_forecast DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', duration_forecast DOUBLE PRECISION NOT NULL, INDEX IDX_527EDB256DC02612 (type_of_task_id), INDEX IDX_527EDB2535542187 (state_of_task_id), INDEX IDX_527EDB25166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_of_task (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, job_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, phone_number VARCHAR(15) NOT NULL, INDEX IDX_8D93D649BE04EA9 (job_id), UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE assignement ADD CONSTRAINT FK_E752B36A8DB60186 FOREIGN KEY (task_id) REFERENCES task (id)');
        $this->addSql('ALTER TABLE assignement ADD CONSTRAINT FK_E752B36A8C03F15C FOREIGN KEY (employee_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE participate ADD CONSTRAINT FK_D02B138BE04EA9 FOREIGN KEY (job_id) REFERENCES job (id)');
        $this->addSql('ALTER TABLE participate ADD CONSTRAINT FK_D02B138166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE participate ADD CONSTRAINT FK_D02B1388C03F15C FOREIGN KEY (employee_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EEC0825306 FOREIGN KEY (manages_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EECC2FD2E5 FOREIGN KEY (state_of_project_id) REFERENCES state_of_project (id)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB256DC02612 FOREIGN KEY (type_of_task_id) REFERENCES type_of_task (id)');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB2535542187 FOREIGN KEY (state_of_task_id) REFERENCES state_of_task (id)');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D649BE04EA9 FOREIGN KEY (job_id) REFERENCES job (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE assignement DROP FOREIGN KEY FK_E752B36A8DB60186');
        $this->addSql('ALTER TABLE assignement DROP FOREIGN KEY FK_E752B36A8C03F15C');
        $this->addSql('ALTER TABLE participate DROP FOREIGN KEY FK_D02B138BE04EA9');
        $this->addSql('ALTER TABLE participate DROP FOREIGN KEY FK_D02B138166D1F9C');
        $this->addSql('ALTER TABLE participate DROP FOREIGN KEY FK_D02B1388C03F15C');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EEC0825306');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EECC2FD2E5');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EE19EB6921');
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB256DC02612');
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB2535542187');
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB25166D1F9C');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649BE04EA9');
        $this->addSql('DROP TABLE assignement');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE job');
        $this->addSql('DROP TABLE participate');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE state_of_project');
        $this->addSql('DROP TABLE state_of_task');
        $this->addSql('DROP TABLE task');
        $this->addSql('DROP TABLE type_of_task');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
