<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240830222047 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY fk_id_donneur');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY fk_id_recepteur');
        $this->addSql('DROP INDEX id_donneur ON transaction');
        $this->addSql('DROP INDEX fk_id_recepteur ON transaction');
        $this->addSql('ALTER TABLE transaction ADD id_donneur_id INT NOT NULL, ADD id_recepteur_id INT NOT NULL, DROP id_donneur, DROP id_recepteur');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D13203028C FOREIGN KEY (id_donneur_id) REFERENCES compte_bancaire (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D118880D5F FOREIGN KEY (id_recepteur_id) REFERENCES compte_bancaire (id)');
        $this->addSql('CREATE INDEX IDX_723705D13203028C ON transaction (id_donneur_id)');
        $this->addSql('CREATE INDEX IDX_723705D118880D5F ON transaction (id_recepteur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D13203028C');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D118880D5F');
        $this->addSql('DROP INDEX IDX_723705D13203028C ON transaction');
        $this->addSql('DROP INDEX IDX_723705D118880D5F ON transaction');
        $this->addSql('ALTER TABLE transaction ADD id_donneur INT DEFAULT NULL, ADD id_recepteur INT DEFAULT NULL, DROP id_donneur_id, DROP id_recepteur_id');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT fk_id_donneur FOREIGN KEY (id_donneur) REFERENCES compte_bancaire (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT fk_id_recepteur FOREIGN KEY (id_recepteur) REFERENCES compte_bancaire (id)');
        $this->addSql('CREATE INDEX id_donneur ON transaction (id_donneur)');
        $this->addSql('CREATE INDEX fk_id_recepteur ON transaction (id_recepteur)');
    }
}
