<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240724082635 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recette ADD personnes INT DEFAULT NULL, ADD difficulty INT DEFAULT NULL, ADD favorite TINYINT(1) DEFAULT NULL, ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', DROP nmbre_person, DROP difficulte, DROP create_at, DROP update_at, CHANGE name name VARCHAR(255) NOT NULL, CHANGE slug slug VARCHAR(255) NOT NULL, CHANGE description description LONGTEXT DEFAULT NULL, CHANGE price price DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recette ADD nmbre_person INT NOT NULL, ADD difficulte INT NOT NULL, ADD update_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', DROP personnes, DROP difficulty, DROP favorite, DROP updated_at, CHANGE name name VARCHAR(50) NOT NULL, CHANGE slug slug VARCHAR(50) NOT NULL, CHANGE description description VARCHAR(255) NOT NULL, CHANGE price price DOUBLE PRECISION NOT NULL, CHANGE created_at create_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }
}
