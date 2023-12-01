<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231201161705 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reparation_soumission (id UUID NOT NULL, email VARCHAR(255) NOT NULL, tel VARCHAR(255) NOT NULL, promo_email BOOLEAN DEFAULT NULL, pub_email BOOLEAN DEFAULT NULL, telephone VARCHAR(255) NOT NULL, composants VARCHAR(255) NOT NULL, total_price DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN reparation_soumission.id IS \'(DC2Type:uuid)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE reparation_soumission');
    }
}
