<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230425081821 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE review (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, rating INTEGER NOT NULL, description VARCHAR(500) NOT NULL, author VARCHAR(100) NOT NULL, email VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL)');
        $this->addSql('ALTER TABLE book ADD COLUMN created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE book ADD COLUMN updated_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE review');
        $this->addSql('CREATE TEMPORARY TABLE __temp__book AS SELECT id, title, description, isbn FROM book');
        $this->addSql('DROP TABLE book');
        $this->addSql('CREATE TABLE book (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(200) NOT NULL, description VARCHAR(255) NOT NULL, isbn VARCHAR(13) NOT NULL)');
        $this->addSql('INSERT INTO book (id, title, description, isbn) SELECT id, title, description, isbn FROM __temp__book');
        $this->addSql('DROP TABLE __temp__book');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CBE5A331CC1CF4E6 ON book (isbn)');
    }
}
