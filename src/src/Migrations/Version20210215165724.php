<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210215165724 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE restaurant');
        $this->addSql('DROP TABLE shop');
        $this->addSql('ALTER TABLE payment_status DROP INDEX FK_5E38FE8ABC999F9F, ADD UNIQUE INDEX UNIQ_5E38FE8ABC999F9F (rate_id)');
        $this->addSql('ALTER TABLE bussines ADD payment_status_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bussines ADD CONSTRAINT FK_AF99839428DE2F95 FOREIGN KEY (payment_status_id) REFERENCES payment_status (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AF99839428DE2F95 ON bussines (payment_status_id)');
        $this->addSql('ALTER TABLE payment ADD payment_status_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D28DE2F95 FOREIGN KEY (payment_status_id) REFERENCES payment_status (id)');
        $this->addSql('CREATE INDEX IDX_6D28840D28DE2F95 ON payment (payment_status_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE restaurant (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, lat DOUBLE PRECISION DEFAULT NULL, lng DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE shop (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE bussines DROP FOREIGN KEY FK_AF99839428DE2F95');
        $this->addSql('DROP INDEX UNIQ_AF99839428DE2F95 ON bussines');
        $this->addSql('ALTER TABLE bussines DROP payment_status_id');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840D28DE2F95');
        $this->addSql('DROP INDEX IDX_6D28840D28DE2F95 ON payment');
        $this->addSql('ALTER TABLE payment DROP payment_status_id');
        $this->addSql('ALTER TABLE payment_status DROP INDEX UNIQ_5E38FE8ABC999F9F, ADD INDEX FK_5E38FE8ABC999F9F (rate_id)');
    }
}
