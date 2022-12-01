<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221201073841 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hackathon ADD created_by_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE hackathon ADD updated_by_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE hackathon ALTER name TYPE VARCHAR(50)');
        $this->addSql('ALTER TABLE hackathon ADD CONSTRAINT FK_8B3AF64FB03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE hackathon ADD CONSTRAINT FK_8B3AF64F896DBBDE FOREIGN KEY (updated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_8B3AF64FB03A8386 ON hackathon (created_by_id)');
        $this->addSql('CREATE INDEX IDX_8B3AF64F896DBBDE ON hackathon (updated_by_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE hackathon DROP CONSTRAINT FK_8B3AF64FB03A8386');
        $this->addSql('ALTER TABLE hackathon DROP CONSTRAINT FK_8B3AF64F896DBBDE');
        $this->addSql('DROP INDEX IDX_8B3AF64FB03A8386');
        $this->addSql('DROP INDEX IDX_8B3AF64F896DBBDE');
        $this->addSql('ALTER TABLE hackathon DROP created_by_id');
        $this->addSql('ALTER TABLE hackathon DROP updated_by_id');
        $this->addSql('ALTER TABLE hackathon ALTER name TYPE VARCHAR(255)');
    }
}
