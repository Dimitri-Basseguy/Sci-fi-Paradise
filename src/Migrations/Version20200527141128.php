<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200527141128 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE book ADD cover_id INT DEFAULT NULL, DROP cover');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A331922726E9 FOREIGN KEY (cover_id) REFERENCES cover (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CBE5A331922726E9 ON book (cover_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A331922726E9');
        $this->addSql('DROP INDEX UNIQ_CBE5A331922726E9 ON book');
        $this->addSql('ALTER TABLE book ADD cover VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP cover_id');
    }
}
