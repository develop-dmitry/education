<?php

declare(strict_types=1);

namespace Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230312113120 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add a log of interaction with the operation table';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('operations_log');

        $table->addColumn('id', 'integer', [
            'autoincrement' => true
        ]);
        $table->addColumn('created_at', 'datetime_immutable', [
            'default' => 'CURRENT_TIMESTAMP'
        ]);
        $table->addColumn('query', 'string');
        $table->addColumn('before_state', 'text', [
            'notnull' => false
        ]);
        $table->addColumn('after_state', 'text', [
            'notnull' => false
        ]);
        $table->addColumn('primary_key', 'integer');

        $table->setPrimaryKey(['id']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('operations_log');
    }
}
