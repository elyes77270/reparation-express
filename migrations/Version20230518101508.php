<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230518101508 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE contact_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE contact (id INT NOT NULL, nom_prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, message TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE composant_telephone DROP CONSTRAINT FK_8A074AE0FE649A29');
        $this->addSql('ALTER TABLE composant_telephone DROP CONSTRAINT FK_8A074AE07F3310E7');
        $this->addSql('ALTER TABLE composant_telephone ADD CONSTRAINT FK_8A074AE0FE649A29 FOREIGN KEY (telephone_id) REFERENCES telephone (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE composant_telephone ADD CONSTRAINT FK_8A074AE07F3310E7 FOREIGN KEY (composant_id) REFERENCES composant (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE contact_id_seq CASCADE');
        $this->addSql('DROP TABLE contact');
        $this->addSql('ALTER TABLE composant_telephone DROP CONSTRAINT fk_8a074ae0fe649a29');
        $this->addSql('ALTER TABLE composant_telephone DROP CONSTRAINT fk_8a074ae07f3310e7');
        $this->addSql('ALTER TABLE composant_telephone ADD CONSTRAINT fk_8a074ae0fe649a29 FOREIGN KEY (telephone_id) REFERENCES telephone (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE composant_telephone ADD CONSTRAINT fk_8a074ae07f3310e7 FOREIGN KEY (composant_id) REFERENCES composant (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
