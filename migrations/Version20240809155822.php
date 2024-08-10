<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240809155822 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE compte_bancaire (id INT AUTO_INCREMENT NOT NULL, compte_bancaire VARCHAR(255) NOT NULL, numero_compte DOUBLE PRECISION NOT NULL, cratted_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', user_id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE feedback (id INT AUTO_INCREMENT NOT NULL, user_id_id INT DEFAULT NULL, commantaire LONGTEXT NOT NULL, note INT NOT NULL, INDEX IDX_D22944589D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE historique_transaction (id INT AUTO_INCREMENT NOT NULL, transaction_id_id INT DEFAULT NULL, date_modification DATETIME NOT NULL, datetime DATETIME NOT NULL, INDEX IDX_AB990BB7DE774E17 (transaction_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE solde (id INT AUTO_INCREMENT NOT NULL, compte_bancaire_id_id INT NOT NULL, montant NUMERIC(10, 2) NOT NULL, UNIQUE INDEX UNIQ_669183671AF1D6B2 (compte_bancaire_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transaction (id INT AUTO_INCREMENT NOT NULL, compte_bancaie_id_id INT NOT NULL, montant NUMERIC(10, 2) NOT NULL, description LONGTEXT NOT NULL, date_transaction DATETIME NOT NULL, INDEX IDX_723705D120684B9F (compte_bancaie_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE feedback ADD CONSTRAINT FK_D22944589D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE historique_transaction ADD CONSTRAINT FK_AB990BB7DE774E17 FOREIGN KEY (transaction_id_id) REFERENCES transaction (id)');
        $this->addSql('ALTER TABLE solde ADD CONSTRAINT FK_669183671AF1D6B2 FOREIGN KEY (compte_bancaire_id_id) REFERENCES compte_bancaire (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D120684B9F FOREIGN KEY (compte_bancaie_id_id) REFERENCES compte_bancaire (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE feedback DROP FOREIGN KEY FK_D22944589D86650F');
        $this->addSql('ALTER TABLE historique_transaction DROP FOREIGN KEY FK_AB990BB7DE774E17');
        $this->addSql('ALTER TABLE solde DROP FOREIGN KEY FK_669183671AF1D6B2');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D120684B9F');
        $this->addSql('DROP TABLE compte_bancaire');
        $this->addSql('DROP TABLE feedback');
        $this->addSql('DROP TABLE historique_transaction');
        $this->addSql('DROP TABLE solde');
        $this->addSql('DROP TABLE transaction');
    }
}
