<?php

declare(strict_types=1);

namespace Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230312122736 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add create/delete trigger for operation table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("CREATE OR REPLACE FUNCTION log_insert_operation()
            RETURNS TRIGGER AS
            $$
            BEGIN
                INSERT INTO operations_log
                    (query, before_state, after_state, primary_key) VALUES
                    ('insert', null, (SELECT row_to_json(NEW)), NEW.id);
                RETURN NEW;
            END;
            $$
            LANGUAGE 'plpgsql'");

        $this->addSql("CREATE OR REPLACE FUNCTION log_delete_operation()
                RETURNS TRIGGER AS
            $$
            BEGIN
                INSERT INTO operations_log
                (query, before_state, after_state, primary_key) VALUES
                    ('delete', (SELECT row_to_json(OLD)), null, OLD.id);
                RETURN OLD;
            END;
            $$
                LANGUAGE 'plpgsql'");

        $this->addSql("CREATE OR REPLACE TRIGGER insert_operation
                AFTER INSERT ON operations
                FOR EACH ROW EXECUTE PROCEDURE log_insert_operation()");

        $this->addSql("CREATE OR REPLACE TRIGGER delete_operation
                AFTER DELETE ON operations
                FOR EACH ROW EXECUTE PROCEDURE log_delete_operation()");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DROP TRIGGER delete_operation on operations");
        $this->addSql("DROP TRIGGER insert_operation on operations");
        $this->addSql("DROP FUNCTION log_delete_operation");
        $this->addSql("DROP FUNCTION log_insert_operation");
    }
}
