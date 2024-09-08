<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240830211834 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D120684B9F');
        $this->addSql('DROP INDEX IDX_723705D120684B9F ON transaction');
        $this->addSql('ALTER TABLE transaction ADD id_recepteur_id INT NOT NULL, CHANGE compte_bancaie_id_id id_donneur_id INT NOT NULL');
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
        $this->addSql('ALTER TABLE transaction ADD compte_bancaie_id_id INT NOT NULL, DROP id_donneur_id, DROP id_recepteur_id');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D120684B9F FOREIGN KEY (compte_bancaie_id_id) REFERENCES compte_bancaire (id)');
        $this->addSql('CREATE INDEX IDX_723705D120684B9F ON transaction (compte_bancaie_id_id)');
    }
}
