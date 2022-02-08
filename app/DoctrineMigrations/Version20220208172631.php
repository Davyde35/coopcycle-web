<?php

declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220208172631 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE oauth2_client ADD name VARCHAR(128) DEFAULT NULL');

        $stmt = $this->connection->prepare("SELECT c.identifier, a.name FROM oauth2_client c JOIN api_app a ON c.identifier = a.oauth2_client_id");
        $stmt->execute();

        while ($oauth2Client = $stmt->fetch()) {
            $this->addSql('UPDATE oauth2_client SET name = :name WHERE identifier = :identifier', $oauth2Client);
        }

        $this->addSql('ALTER TABLE oauth2_client ALTER name SET NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE oauth2_client DROP name');
    }
}
