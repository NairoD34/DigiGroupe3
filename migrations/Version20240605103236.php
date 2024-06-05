<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240605103236 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE assignement_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE client_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE job_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE participate_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE project_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE state_of_project_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE state_of_task_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE task_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE type_of_task_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE assignement (id INT NOT NULL, task_id INT DEFAULT NULL, employee_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E752B36A8DB60186 ON assignement (task_id)');
        $this->addSql('CREATE INDEX IDX_E752B36A8C03F15C ON assignement (employee_id)');
        $this->addSql('CREATE TABLE client (id INT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, company VARCHAR(255) NOT NULL, phone_number VARCHAR(15) NOT NULL, mail VARCHAR(255) NOT NULL, adress TEXT NOT NULL, zipcode VARCHAR(11) NOT NULL, city VARCHAR(50) NOT NULL, siren VARCHAR(255) NOT NULL, siret VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE job (id INT NOT NULL, label VARCHAR(255) NOT NULL, hour_rate DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE participate (id INT NOT NULL, job_id INT NOT NULL, project_id INT NOT NULL, employee_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D02B138BE04EA9 ON participate (job_id)');
        $this->addSql('CREATE INDEX IDX_D02B138166D1F9C ON participate (project_id)');
        $this->addSql('CREATE INDEX IDX_D02B1388C03F15C ON participate (employee_id)');
        $this->addSql('CREATE TABLE project (id INT NOT NULL, manages_id INT NOT NULL, state_of_project_id INT NOT NULL, client_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description TEXT NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2FB3D0EEC0825306 ON project (manages_id)');
        $this->addSql('CREATE INDEX IDX_2FB3D0EECC2FD2E5 ON project (state_of_project_id)');
        $this->addSql('CREATE INDEX IDX_2FB3D0EE19EB6921 ON project (client_id)');
        $this->addSql('COMMENT ON COLUMN project.start_date IS \'(DC2Type:date_immutable)\'');
        $this->addSql('COMMENT ON COLUMN project.end_date IS \'(DC2Type:date_immutable)\'');
        $this->addSql('CREATE TABLE state_of_project (id INT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE state_of_task (id INT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE task (id INT NOT NULL, type_of_task_id INT DEFAULT NULL, state_of_task_id INT DEFAULT NULL, project_id INT NOT NULL, name VARCHAR(255) NOT NULL, description TEXT NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, duration_real DOUBLE PRECISION NOT NULL, start_date_forecast DATE NOT NULL, end_date_forecast DATE NOT NULL, duration_forecast DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_527EDB256DC02612 ON task (type_of_task_id)');
        $this->addSql('CREATE INDEX IDX_527EDB2535542187 ON task (state_of_task_id)');
        $this->addSql('CREATE INDEX IDX_527EDB25166D1F9C ON task (project_id)');
        $this->addSql('COMMENT ON COLUMN task.start_date IS \'(DC2Type:date_immutable)\'');
        $this->addSql('COMMENT ON COLUMN task.end_date IS \'(DC2Type:date_immutable)\'');
        $this->addSql('COMMENT ON COLUMN task.start_date_forecast IS \'(DC2Type:date_immutable)\'');
        $this->addSql('COMMENT ON COLUMN task.end_date_forecast IS \'(DC2Type:date_immutable)\'');
        $this->addSql('CREATE TABLE type_of_task (id INT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, job_id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, phone_number VARCHAR(15) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8D93D649BE04EA9 ON "user" (job_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON "user" (email)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE assignement ADD CONSTRAINT FK_E752B36A8DB60186 FOREIGN KEY (task_id) REFERENCES task (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE assignement ADD CONSTRAINT FK_E752B36A8C03F15C FOREIGN KEY (employee_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE participate ADD CONSTRAINT FK_D02B138BE04EA9 FOREIGN KEY (job_id) REFERENCES job (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE participate ADD CONSTRAINT FK_D02B138166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE participate ADD CONSTRAINT FK_D02B1388C03F15C FOREIGN KEY (employee_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EEC0825306 FOREIGN KEY (manages_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EECC2FD2E5 FOREIGN KEY (state_of_project_id) REFERENCES state_of_project (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE19EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB256DC02612 FOREIGN KEY (type_of_task_id) REFERENCES type_of_task (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB2535542187 FOREIGN KEY (state_of_task_id) REFERENCES state_of_task (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D649BE04EA9 FOREIGN KEY (job_id) REFERENCES job (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE assignement_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE client_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE job_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE participate_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE project_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE state_of_project_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE state_of_task_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE task_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE type_of_task_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('ALTER TABLE assignement DROP CONSTRAINT FK_E752B36A8DB60186');
        $this->addSql('ALTER TABLE assignement DROP CONSTRAINT FK_E752B36A8C03F15C');
        $this->addSql('ALTER TABLE participate DROP CONSTRAINT FK_D02B138BE04EA9');
        $this->addSql('ALTER TABLE participate DROP CONSTRAINT FK_D02B138166D1F9C');
        $this->addSql('ALTER TABLE participate DROP CONSTRAINT FK_D02B1388C03F15C');
        $this->addSql('ALTER TABLE project DROP CONSTRAINT FK_2FB3D0EEC0825306');
        $this->addSql('ALTER TABLE project DROP CONSTRAINT FK_2FB3D0EECC2FD2E5');
        $this->addSql('ALTER TABLE project DROP CONSTRAINT FK_2FB3D0EE19EB6921');
        $this->addSql('ALTER TABLE task DROP CONSTRAINT FK_527EDB256DC02612');
        $this->addSql('ALTER TABLE task DROP CONSTRAINT FK_527EDB2535542187');
        $this->addSql('ALTER TABLE task DROP CONSTRAINT FK_527EDB25166D1F9C');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D649BE04EA9');
        $this->addSql('DROP TABLE assignement');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE job');
        $this->addSql('DROP TABLE participate');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE state_of_project');
        $this->addSql('DROP TABLE state_of_task');
        $this->addSql('DROP TABLE task');
        $this->addSql('DROP TABLE type_of_task');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
