<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230526190447 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE email_sender_service_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE email_sender_service (id INT NOT NULL, recipent_id INT DEFAULT NULL, content VARCHAR(255) NOT NULL, object VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B49440D0BF433F1C ON email_sender_service (recipent_id)');
        $this->addSql('ALTER TABLE email_sender_service ADD CONSTRAINT FK_B49440D0BF433F1C FOREIGN KEY (recipent_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE email_sender_service_id_seq CASCADE');
        $this->addSql('ALTER TABLE email_sender_service DROP CONSTRAINT FK_B49440D0BF433F1C');
        $this->addSql('DROP TABLE email_sender_service');
    }
}
