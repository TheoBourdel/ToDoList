<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230524123913 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE composition_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE document_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE group_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE hackathon_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE school_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE year_id_seq CASCADE');
        $this->addSql('ALTER TABLE "group" DROP CONSTRAINT fk_6dc044c587a2e12');
        $this->addSql('ALTER TABLE "group" DROP CONSTRAINT fk_6dc044c5996d90cf');
        $this->addSql('ALTER TABLE hackathon_school DROP CONSTRAINT fk_a0ec53b1996d90cf');
        $this->addSql('ALTER TABLE hackathon_school DROP CONSTRAINT fk_a0ec53b1c32a47ee');
        $this->addSql('ALTER TABLE hackathon DROP CONSTRAINT fk_8b3af64f40c1fea7');
        $this->addSql('ALTER TABLE hackathon DROP CONSTRAINT fk_8b3af64fb03a8386');
        $this->addSql('ALTER TABLE hackathon DROP CONSTRAINT fk_8b3af64f896dbbde');
        $this->addSql('ALTER TABLE document DROP CONSTRAINT fk_d8698a7610b7eb85');
        $this->addSql('ALTER TABLE document DROP CONSTRAINT fk_d8698a76770c2d86');
        $this->addSql('ALTER TABLE hackathon_user DROP CONSTRAINT fk_58930177996d90cf');
        $this->addSql('ALTER TABLE hackathon_user DROP CONSTRAINT fk_58930177a76ed395');
        $this->addSql('DROP TABLE school');
        $this->addSql('DROP TABLE "group"');
        $this->addSql('DROP TABLE hackathon_school');
        $this->addSql('DROP TABLE composition');
        $this->addSql('DROP TABLE hackathon');
        $this->addSql('DROP TABLE year');
        $this->addSql('DROP TABLE document');
        $this->addSql('DROP TABLE hackathon_user');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE composition_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE document_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE group_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE hackathon_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE school_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE year_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE school (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE "group" (id INT NOT NULL, composition_id INT DEFAULT NULL, hackathon_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_6dc044c5996d90cf ON "group" (hackathon_id)');
        $this->addSql('CREATE INDEX idx_6dc044c587a2e12 ON "group" (composition_id)');
        $this->addSql('CREATE TABLE hackathon_school (hackathon_id INT NOT NULL, school_id INT NOT NULL, PRIMARY KEY(hackathon_id, school_id))');
        $this->addSql('CREATE INDEX idx_a0ec53b1c32a47ee ON hackathon_school (school_id)');
        $this->addSql('CREATE INDEX idx_a0ec53b1996d90cf ON hackathon_school (hackathon_id)');
        $this->addSql('CREATE TABLE composition (id INT NOT NULL, nb_dev INT NOT NULL, nb_marketing INT NOT NULL, nb_design INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE hackathon (id INT NOT NULL, year_id INT DEFAULT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, name VARCHAR(50) NOT NULL, start_date DATE NOT NULL, description TEXT DEFAULT NULL, slug VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, "position" INT DEFAULT 0 NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_8b3af64f896dbbde ON hackathon (updated_by_id)');
        $this->addSql('CREATE INDEX idx_8b3af64fb03a8386 ON hackathon (created_by_id)');
        $this->addSql('CREATE INDEX idx_8b3af64f40c1fea7 ON hackathon (year_id)');
        $this->addSql('CREATE TABLE year (id INT NOT NULL, date VARCHAR(20) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE document (id INT NOT NULL, hackathon_owner_id INT DEFAULT NULL, group_owner_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_d8698a76770c2d86 ON document (group_owner_id)');
        $this->addSql('CREATE INDEX idx_d8698a7610b7eb85 ON document (hackathon_owner_id)');
        $this->addSql('CREATE TABLE hackathon_user (hackathon_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(hackathon_id, user_id))');
        $this->addSql('CREATE INDEX idx_58930177a76ed395 ON hackathon_user (user_id)');
        $this->addSql('CREATE INDEX idx_58930177996d90cf ON hackathon_user (hackathon_id)');
        $this->addSql('ALTER TABLE "group" ADD CONSTRAINT fk_6dc044c587a2e12 FOREIGN KEY (composition_id) REFERENCES composition (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "group" ADD CONSTRAINT fk_6dc044c5996d90cf FOREIGN KEY (hackathon_id) REFERENCES hackathon (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE hackathon_school ADD CONSTRAINT fk_a0ec53b1996d90cf FOREIGN KEY (hackathon_id) REFERENCES hackathon (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE hackathon_school ADD CONSTRAINT fk_a0ec53b1c32a47ee FOREIGN KEY (school_id) REFERENCES school (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE hackathon ADD CONSTRAINT fk_8b3af64f40c1fea7 FOREIGN KEY (year_id) REFERENCES year (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE hackathon ADD CONSTRAINT fk_8b3af64fb03a8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE hackathon ADD CONSTRAINT fk_8b3af64f896dbbde FOREIGN KEY (updated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT fk_d8698a7610b7eb85 FOREIGN KEY (hackathon_owner_id) REFERENCES hackathon (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT fk_d8698a76770c2d86 FOREIGN KEY (group_owner_id) REFERENCES "group" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE hackathon_user ADD CONSTRAINT fk_58930177996d90cf FOREIGN KEY (hackathon_id) REFERENCES hackathon (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE hackathon_user ADD CONSTRAINT fk_58930177a76ed395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
