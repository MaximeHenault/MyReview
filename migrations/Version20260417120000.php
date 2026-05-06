<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Platforms\AbstractMySQLPlatform;
use Doctrine\DBAL\Platforms\PostgreSQLPlatform;
use Doctrine\Migrations\AbstractMigration;

final class Version20260417120000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Allow half-star values in note.note (double precision)';
    }

    public function up(Schema $schema): void
    {
        $platform = $this->connection->getDatabasePlatform();

        if ($platform instanceof PostgreSQLPlatform) {
            $this->addSql('ALTER TABLE note ALTER COLUMN note TYPE DOUBLE PRECISION USING note::double precision');
            return;
        }

        if ($platform instanceof AbstractMySQLPlatform) {
            $this->addSql('ALTER TABLE note MODIFY note DOUBLE NOT NULL');
            return;
        }

        $this->abortIf(true, sprintf('Unsupported database platform: %s', get_debug_type($platform)));
    }

    public function down(Schema $schema): void
    {
        $platform = $this->connection->getDatabasePlatform();

        if ($platform instanceof PostgreSQLPlatform) {
            $this->addSql('ALTER TABLE note ALTER COLUMN note TYPE INT USING ROUND(note)');
            return;
        }

        if ($platform instanceof AbstractMySQLPlatform) {
            $this->addSql('ALTER TABLE note MODIFY note INT NOT NULL');
            return;
        }

        $this->abortIf(true, sprintf('Unsupported database platform: %s', get_debug_type($platform)));
    }
}
