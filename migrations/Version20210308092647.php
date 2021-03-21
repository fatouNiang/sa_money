<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210308092647 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, nom_complet VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, cni VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1A76ED395');
        $this->addSql('DROP INDEX IDX_723705D1A76ED395 ON transaction');
        $this->addSql('ALTER TABLE transaction ADD user_depot_id INT NOT NULL, ADD user_retrait_id INT DEFAULT NULL, ADD client_depot_id INT NOT NULL, ADD client_retrait_id INT NOT NULL, ADD date_depot DATE NOT NULL, ADD date_retrait DATE DEFAULT NULL, ADD frais DOUBLE PRECISION NOT NULL, ADD frais_depot DOUBLE PRECISION NOT NULL, ADD frais_retrait DOUBLE PRECISION NOT NULL, ADD frais_system DOUBLE PRECISION NOT NULL, ADD frais_etat DOUBLE PRECISION NOT NULL, DROP user_id, DROP create_at, DROP type, DROP part_etat, DROP part_ent, DROP part_agence_retrait, CHANGE code code VARCHAR(255) NOT NULL, CHANGE montant montant DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1659D30DE FOREIGN KEY (user_depot_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1D99F8396 FOREIGN KEY (user_retrait_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1ABF6E41B FOREIGN KEY (client_depot_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1EEAC783B FOREIGN KEY (client_retrait_id) REFERENCES client (id)');
        $this->addSql('CREATE INDEX IDX_723705D1659D30DE ON transaction (user_depot_id)');
        $this->addSql('CREATE INDEX IDX_723705D1D99F8396 ON transaction (user_retrait_id)');
        $this->addSql('CREATE INDEX IDX_723705D1ABF6E41B ON transaction (client_depot_id)');
        $this->addSql('CREATE INDEX IDX_723705D1EEAC783B ON transaction (client_retrait_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1ABF6E41B');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1EEAC783B');
        $this->addSql('DROP TABLE client');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1659D30DE');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1D99F8396');
        $this->addSql('DROP INDEX IDX_723705D1659D30DE ON transaction');
        $this->addSql('DROP INDEX IDX_723705D1D99F8396 ON transaction');
        $this->addSql('DROP INDEX IDX_723705D1ABF6E41B ON transaction');
        $this->addSql('DROP INDEX IDX_723705D1EEAC783B ON transaction');
        $this->addSql('ALTER TABLE transaction ADD user_id INT NOT NULL, ADD create_at DATETIME NOT NULL, ADD type VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD part_etat INT NOT NULL, ADD part_ent INT NOT NULL, ADD part_agence_retrait INT NOT NULL, DROP user_depot_id, DROP user_retrait_id, DROP client_depot_id, DROP client_retrait_id, DROP date_depot, DROP date_retrait, DROP frais, DROP frais_depot, DROP frais_retrait, DROP frais_system, DROP frais_etat, CHANGE montant montant INT NOT NULL, CHANGE code code INT NOT NULL');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_723705D1A76ED395 ON transaction (user_id)');
    }
}
