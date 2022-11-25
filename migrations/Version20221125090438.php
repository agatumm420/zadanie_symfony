<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221125090438 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE promotion');
        $this->addSql('DROP TABLE shop');
        $this->addSql('DROP TABLE shop_category');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE "BINARY")');
        $this->addSql('CREATE TABLE promotion (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, shop_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE "BINARY", teaser CLOB DEFAULT NULL COLLATE "BINARY", text CLOB DEFAULT NULL COLLATE "BINARY", CONSTRAINT FK_C11D7DD14D16C4DD FOREIGN KEY (shop_id) REFERENCES shop (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_C11D7DD14D16C4DD ON promotion (shop_id)');
        $this->addSql('CREATE TABLE shop (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE "BINARY", box VARCHAR(255) NOT NULL COLLATE "BINARY", level SMALLINT DEFAULT NULL)');
        $this->addSql('CREATE TABLE shop_category (shop_id INTEGER NOT NULL, category_id INTEGER NOT NULL, PRIMARY KEY(shop_id, category_id), CONSTRAINT FK_DDF4E3574D16C4DD FOREIGN KEY (shop_id) REFERENCES shop (id) ON UPDATE NO ACTION ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_DDF4E35712469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON UPDATE NO ACTION ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_DDF4E35712469DE2 ON shop_category (category_id)');
        $this->addSql('CREATE INDEX IDX_DDF4E3574D16C4DD ON shop_category (shop_id)');
    }
}
