<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250710173520 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Convert product prices from float to integer (cents)';
    }

    public function up(Schema $schema): void
    {
        // Convertir les prix existants de float vers centimes
        $this->addSql('UPDATE product SET price = ROUND(price * 100)');

        // Changer le type de colonne de DOUBLE PRECISION vers INT
        $this->addSql('ALTER TABLE product CHANGE price price INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // Changer le type de colonne de INT vers DOUBLE PRECISION
        $this->addSql('ALTER TABLE product CHANGE price price DOUBLE PRECISION NOT NULL');

        // Convertir les prix de centimes vers float
        $this->addSql('UPDATE product SET price = price / 100');
    }
}
