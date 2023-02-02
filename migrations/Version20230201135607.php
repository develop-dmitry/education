<?php

declare(strict_types=1);

namespace Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230201135607 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add operation table';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('operations');

        $table->addColumn('id', 'integer', [
            'autoincrement' => true
        ]);
        $table->addColumn('amount', 'float');
        $table->addColumn('transaction_date', 'date');

        $table->setPrimaryKey(['id']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('operations');
    }
}
