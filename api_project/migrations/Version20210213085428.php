<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210213085428 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $table = $schema->getTable('product');
        $table->addColumn('product_id', Types::GUID);
    }

    public function down(Schema $schema): void
    {
    }
}
