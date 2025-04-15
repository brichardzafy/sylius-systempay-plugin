<?php

declare(strict_types=1);

namespace Sylius\SystempayPlugin\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250415172728 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE sylius_systempay_ipn (id INT AUTO_INCREMENT NOT NULL, order_status VARCHAR(30) NOT NULL, shop_id VARCHAR(30) NOT NULL, order_cycle VARCHAR(30) NOT NULL, server_date DATETIME NOT NULL, order_details JSON NOT NULL, customer JSON NOT NULL, transactions JSON NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP TABLE sylius_systempay_ipn
        SQL);
    }
}
