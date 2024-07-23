<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240723094342 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recette DROP dates, CHANGE name name VARCHAR(50) NOT NULL, CHANGE slug slug VARCHAR(50) NOT NULL, CHANGE temps temps INT DEFAULT NULL, CHANGE nmbre_person nmbre_person INT NOT NULL, CHANGE difficulte difficulte INT NOT NULL, CHANGE price price NUMERIC(10, 2) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_49BB6390989D9B62 ON recette (slug)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_49BB6390989D9B62 ON recette');
        $this->addSql('ALTER TABLE recette ADD dates DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE name name VARCHAR(255) NOT NULL, CHANGE slug slug VARCHAR(255) NOT NULL, CHANGE temps temps VARCHAR(255) DEFAULT NULL, CHANGE nmbre_person nmbre_person VARCHAR(255) NOT NULL, CHANGE difficulte difficulte VARCHAR(255) NOT NULL, CHANGE price price DOUBLE PRECISION NOT NULL');
    }
}
