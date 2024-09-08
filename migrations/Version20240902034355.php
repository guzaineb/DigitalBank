<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240902034355 extends AbstractMigration
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
        $this->addSql('ALTER TABLE transaction CHANGE id_donneur id_donneur INT NOT NULL, CHANGE id_recepteur id_recepteur INT NOT NULL');
        $this->addSql('DROP INDEX id_donneur ON transaction');
        $this->addSql('CREATE INDEX IDX_723705D19A0E7E03 ON transaction (id_donneur)');
        $this->addSql('DROP INDEX fk_id_recepteur ON transaction');
        $this->addSql('CREATE INDEX IDX_723705D17DD566F8 ON transaction (id_recepteur)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT fk_id_donneur FOREIGN KEY (id_donneur) REFERENCES compte_bancaire (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT fk_id_recepteur FOREIGN KEY (id_recepteur) REFERENCES compte_bancaire (id)');
        $this->addSql('ALTER TABLE user CHANGE numtelephone numtelephone VARCHAR(8) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D19A0E7E03');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D17DD566F8');
        $this->addSql('ALTER TABLE transaction CHANGE id_donneur id_donneur INT DEFAULT NULL, CHANGE id_recepteur id_recepteur INT DEFAULT NULL');
        $this->addSql('DROP INDEX idx_723705d19a0e7e03 ON transaction');
        $this->addSql('CREATE INDEX id_donneur ON transaction (id_donneur)');
        $this->addSql('DROP INDEX idx_723705d17dd566f8 ON transaction');
        $this->addSql('CREATE INDEX fk_id_recepteur ON transaction (id_recepteur)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D19A0E7E03 FOREIGN KEY (id_donneur) REFERENCES compte_bancaire (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D17DD566F8 FOREIGN KEY (id_recepteur) REFERENCES compte_bancaire (id)');
        $this->addSql('ALTER TABLE user CHANGE numtelephone numtelephone VARCHAR(15) NOT NULL');
    }
}
