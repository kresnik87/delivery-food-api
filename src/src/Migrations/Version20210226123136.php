<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210226123136 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE rate (id INT AUTO_INCREMENT NOT NULL, price DOUBLE PRECISION DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, max_places INT DEFAULT NULL, days_free INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, bussines_id INT DEFAULT NULL, username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', name VARCHAR(255) DEFAULT NULL, nif VARCHAR(255) DEFAULT NULL, surnames VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, created_date DATETIME DEFAULT NULL, updated_date DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D64992FC23A8 (username_canonical), UNIQUE INDEX UNIQ_8D93D649A0D96FBF (email_canonical), UNIQUE INDEX UNIQ_8D93D649C05FB297 (confirmation_token), UNIQUE INDEX UNIQ_8D93D64952635DB (bussines_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE access_token (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, user_id INT DEFAULT NULL, token VARCHAR(255) NOT NULL, expires_at INT DEFAULT NULL, scope VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_B6A2DD685F37A13B (token), INDEX IDX_B6A2DD6819EB6921 (client_id), INDEX IDX_B6A2DD68A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = MyISAM');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, random_id VARCHAR(255) NOT NULL, redirect_uris LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', secret VARCHAR(255) NOT NULL, allowed_grant_types LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE refresh_token (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, user_id INT DEFAULT NULL, token VARCHAR(255) NOT NULL, expires_at INT DEFAULT NULL, scope VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_C74F21955F37A13B (token), INDEX IDX_C74F219519EB6921 (client_id), INDEX IDX_C74F2195A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plate (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, price DOUBLE PRECISION DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE auth_code (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, user_id INT DEFAULT NULL, token VARCHAR(255) NOT NULL, redirect_uri LONGTEXT NOT NULL, expires_at INT DEFAULT NULL, scope VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_5933D02C5F37A13B (token), INDEX IDX_5933D02C19EB6921 (client_id), INDEX IDX_5933D02CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notification (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, description VARCHAR(2500) DEFAULT NULL, params LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', mails LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', topics LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', types LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', tokens LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', created_date DATETIME DEFAULT NULL, updated_date DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notification_device (notification_id INT NOT NULL, device_id VARCHAR(255) NOT NULL, INDEX IDX_CD8848D3EF1A9D84 (notification_id), INDEX IDX_CD8848D394A4C7D4 (device_id), PRIMARY KEY(notification_id, device_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notification_users (notification_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_D2374010EF1A9D84 (notification_id), INDEX IDX_D2374010A76ED395 (user_id), PRIMARY KEY(notification_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment (id INT AUTO_INCREMENT NOT NULL, payment_status_id INT DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, amount DOUBLE PRECISION DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, created DATE DEFAULT NULL, updated DATE DEFAULT NULL, INDEX IDX_6D28840D28DE2F95 (payment_status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notification_user (id INT AUTO_INCREMENT NOT NULL, notification_id INT DEFAULT NULL, user_id INT DEFAULT NULL, readed TINYINT(1) DEFAULT NULL, deleted TINYINT(1) DEFAULT NULL, created_date DATETIME DEFAULT NULL, updated_date DATETIME DEFAULT NULL, INDEX IDX_35AF9D73EF1A9D84 (notification_id), INDEX IDX_35AF9D73A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE device (uuid VARCHAR(255) NOT NULL, user_id INT DEFAULT NULL, cordova VARCHAR(255) DEFAULT NULL, model VARCHAR(255) DEFAULT NULL, platform VARCHAR(255) DEFAULT NULL, manufacturer VARCHAR(255) DEFAULT NULL, token VARCHAR(255) DEFAULT NULL, lang VARCHAR(255) DEFAULT NULL, version VARCHAR(255) DEFAULT NULL, created_date DATETIME DEFAULT NULL, updated_date DATETIME DEFAULT NULL, INDEX IDX_92FB68EA76ED395 (user_id), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rider (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, surname VARCHAR(255) DEFAULT NULL, dni VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE place (id INT AUTO_INCREMENT NOT NULL, bussines_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, lat VARCHAR(255) DEFAULT NULL, lng VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, discr VARCHAR(255) NOT NULL, INDEX IDX_741D53CD52635DB (bussines_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, status VARCHAR(255) DEFAULT NULL, discount DOUBLE PRECISION DEFAULT NULL, total DOUBLE PRECISION DEFAULT NULL, created DATE DEFAULT NULL, updated DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment_status (id INT AUTO_INCREMENT NOT NULL, rate_id INT DEFAULT NULL, created DATE DEFAULT NULL, updated DATE DEFAULT NULL, next_payment DATE DEFAULT NULL, UNIQUE INDEX UNIQ_5E38FE8ABC999F9F (rate_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE images_place (id INT AUTO_INCREMENT NOT NULL, place_id INT DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, created DATE DEFAULT NULL, updated DATE DEFAULT NULL, INDEX IDX_5925B271DA6A219 (place_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notification_config (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, order_status TINYINT(1) NOT NULL, campaigns TINYINT(1) NOT NULL, offers TINYINT(1) NOT NULL, newsletter TINYINT(1) NOT NULL, created_date DATETIME DEFAULT NULL, updated_date DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_102DD121A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_stock (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, shop_id INT DEFAULT NULL, quantity INT DEFAULT NULL, INDEX IDX_EA6A2D3C4584665A (product_id), INDEX IDX_EA6A2D3C4D16C4DD (shop_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer (id INT AUTO_INCREMENT NOT NULL, created DATE DEFAULT NULL, updated DATE DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, surname VARCHAR(255) DEFAULT NULL, dni VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bussines (id INT AUTO_INCREMENT NOT NULL, payment_status_id INT DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, logo VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_AF99839428DE2F95 (payment_status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, restaurant_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, created DATE DEFAULT NULL, updated DATE DEFAULT NULL, INDEX IDX_7D053A9312469DE2 (category_id), INDEX IDX_7D053A93B1E7706E (restaurant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu_plate (menu_id INT NOT NULL, plate_id INT NOT NULL, INDEX IDX_E032F43CCCD7E912 (menu_id), INDEX IDX_E032F43CDF66E98B (plate_id), PRIMARY KEY(menu_id, plate_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64952635DB FOREIGN KEY (bussines_id) REFERENCES bussines (id)');
        $this->addSql('ALTER TABLE access_token ADD CONSTRAINT FK_B6A2DD6819EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE access_token ADD CONSTRAINT FK_B6A2DD68A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE refresh_token ADD CONSTRAINT FK_C74F219519EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE refresh_token ADD CONSTRAINT FK_C74F2195A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE auth_code ADD CONSTRAINT FK_5933D02C19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE auth_code ADD CONSTRAINT FK_5933D02CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE notification_device ADD CONSTRAINT FK_CD8848D3EF1A9D84 FOREIGN KEY (notification_id) REFERENCES notification (id)');
        $this->addSql('ALTER TABLE notification_device ADD CONSTRAINT FK_CD8848D394A4C7D4 FOREIGN KEY (device_id) REFERENCES device (uuid)');
        $this->addSql('ALTER TABLE notification_users ADD CONSTRAINT FK_D2374010EF1A9D84 FOREIGN KEY (notification_id) REFERENCES notification (id)');
        $this->addSql('ALTER TABLE notification_users ADD CONSTRAINT FK_D2374010A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D28DE2F95 FOREIGN KEY (payment_status_id) REFERENCES payment_status (id)');
        $this->addSql('ALTER TABLE notification_user ADD CONSTRAINT FK_35AF9D73EF1A9D84 FOREIGN KEY (notification_id) REFERENCES notification (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE notification_user ADD CONSTRAINT FK_35AF9D73A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE device ADD CONSTRAINT FK_92FB68EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE place ADD CONSTRAINT FK_741D53CD52635DB FOREIGN KEY (bussines_id) REFERENCES bussines (id)');
        $this->addSql('ALTER TABLE payment_status ADD CONSTRAINT FK_5E38FE8ABC999F9F FOREIGN KEY (rate_id) REFERENCES rate (id)');
        $this->addSql('ALTER TABLE images_place ADD CONSTRAINT FK_5925B271DA6A219 FOREIGN KEY (place_id) REFERENCES place (id)');
        $this->addSql('ALTER TABLE notification_config ADD CONSTRAINT FK_102DD121A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE product_stock ADD CONSTRAINT FK_EA6A2D3C4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE product_stock ADD CONSTRAINT FK_EA6A2D3C4D16C4DD FOREIGN KEY (shop_id) REFERENCES place (id)');
        $this->addSql('ALTER TABLE bussines ADD CONSTRAINT FK_AF99839428DE2F95 FOREIGN KEY (payment_status_id) REFERENCES payment_status (id)');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A9312469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A93B1E7706E FOREIGN KEY (restaurant_id) REFERENCES place (id)');
        $this->addSql('ALTER TABLE menu_plate ADD CONSTRAINT FK_E032F43CCCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_plate ADD CONSTRAINT FK_E032F43CDF66E98B FOREIGN KEY (plate_id) REFERENCES plate (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE payment_status DROP FOREIGN KEY FK_5E38FE8ABC999F9F');
        $this->addSql('ALTER TABLE access_token DROP FOREIGN KEY FK_B6A2DD68A76ED395');
        $this->addSql('ALTER TABLE refresh_token DROP FOREIGN KEY FK_C74F2195A76ED395');
        $this->addSql('ALTER TABLE auth_code DROP FOREIGN KEY FK_5933D02CA76ED395');
        $this->addSql('ALTER TABLE notification_users DROP FOREIGN KEY FK_D2374010A76ED395');
        $this->addSql('ALTER TABLE notification_user DROP FOREIGN KEY FK_35AF9D73A76ED395');
        $this->addSql('ALTER TABLE device DROP FOREIGN KEY FK_92FB68EA76ED395');
        $this->addSql('ALTER TABLE notification_config DROP FOREIGN KEY FK_102DD121A76ED395');
        $this->addSql('ALTER TABLE access_token DROP FOREIGN KEY FK_B6A2DD6819EB6921');
        $this->addSql('ALTER TABLE refresh_token DROP FOREIGN KEY FK_C74F219519EB6921');
        $this->addSql('ALTER TABLE auth_code DROP FOREIGN KEY FK_5933D02C19EB6921');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A9312469DE2');
        $this->addSql('ALTER TABLE menu_plate DROP FOREIGN KEY FK_E032F43CDF66E98B');
        $this->addSql('ALTER TABLE notification_device DROP FOREIGN KEY FK_CD8848D3EF1A9D84');
        $this->addSql('ALTER TABLE notification_users DROP FOREIGN KEY FK_D2374010EF1A9D84');
        $this->addSql('ALTER TABLE notification_user DROP FOREIGN KEY FK_35AF9D73EF1A9D84');
        $this->addSql('ALTER TABLE product_stock DROP FOREIGN KEY FK_EA6A2D3C4584665A');
        $this->addSql('ALTER TABLE notification_device DROP FOREIGN KEY FK_CD8848D394A4C7D4');
        $this->addSql('ALTER TABLE images_place DROP FOREIGN KEY FK_5925B271DA6A219');
        $this->addSql('ALTER TABLE product_stock DROP FOREIGN KEY FK_EA6A2D3C4D16C4DD');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A93B1E7706E');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840D28DE2F95');
        $this->addSql('ALTER TABLE bussines DROP FOREIGN KEY FK_AF99839428DE2F95');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64952635DB');
        $this->addSql('ALTER TABLE place DROP FOREIGN KEY FK_741D53CD52635DB');
        $this->addSql('ALTER TABLE menu_plate DROP FOREIGN KEY FK_E032F43CCCD7E912');
        $this->addSql('DROP TABLE rate');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE access_token');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE refresh_token');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE plate');
        $this->addSql('DROP TABLE auth_code');
        $this->addSql('DROP TABLE notification');
        $this->addSql('DROP TABLE notification_device');
        $this->addSql('DROP TABLE notification_users');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE payment');
        $this->addSql('DROP TABLE notification_user');
        $this->addSql('DROP TABLE device');
        $this->addSql('DROP TABLE rider');
        $this->addSql('DROP TABLE place');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE payment_status');
        $this->addSql('DROP TABLE images_place');
        $this->addSql('DROP TABLE notification_config');
        $this->addSql('DROP TABLE product_stock');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE bussines');
        $this->addSql('DROP TABLE menu');
        $this->addSql('DROP TABLE menu_plate');
    }
}
