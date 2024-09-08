<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240827171752 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE compte_bancaire CHANGE numero_compte numero_compte VARCHAR(255) NOT NULL, CHANGE cratted_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE solde DROP FOREIGN KEY FK_669183671AF1D6B2');
        $this->addSql('DROP INDEX UNIQ_669183671AF1D6B2 ON solde');
        $this->addSql('ALTER TABLE solde CHANGE compte_bancaire_id_id compte_bancaire_id INT NOT NULL');
        $this->addSql('ALTER TABLE solde ADD CONSTRAINT FK_66918367AF1E371E FOREIGN KEY (compte_bancaire_id) REFERENCES compte_bancaire (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_66918367AF1E371E ON solde (compte_bancaire_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE compte_bancaire CHANGE numero_compte numero_compte DOUBLE PRECISION NOT NULL, CHANGE created_at cratted_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE solde DROP FOREIGN KEY FK_66918367AF1E371E');
        $this->addSql('DROP INDEX UNIQ_66918367AF1E371E ON solde');
        $this->addSql('ALTER TABLE solde CHANGE compte_bancaire_id compte_bancaire_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE solde ADD CONSTRAINT FK_669183671AF1D6B2 FOREIGN KEY (compte_bancaire_id_id) REFERENCES compte_bancaire (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_669183671AF1D6B2 ON solde (compte_bancaire_id_id)');
    }
}
