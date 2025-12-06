<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251205122632 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE identity.refresh_tokens ALTER refresh_token TYPE VARCHAR(128)');
        $this->addSql('ALTER TABLE identity.refresh_tokens ALTER refresh_token SET NOT NULL');
        $this->addSql('ALTER TABLE identity.refresh_tokens ALTER username SET NOT NULL');
        $this->addSql('ALTER TABLE identity.refresh_tokens ALTER valid SET NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9CAD7EB3C74F2195 ON identity.refresh_tokens (refresh_token)');
        $this->addSql('ALTER TABLE identity.users ADD name VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX identity.UNIQ_9CAD7EB3C74F2195');
        $this->addSql('ALTER TABLE identity.refresh_tokens ALTER refresh_token TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE identity.refresh_tokens ALTER refresh_token DROP NOT NULL');
        $this->addSql('ALTER TABLE identity.refresh_tokens ALTER username DROP NOT NULL');
        $this->addSql('ALTER TABLE identity.refresh_tokens ALTER valid DROP NOT NULL');
        $this->addSql('ALTER TABLE identity.users DROP name');
    }
}
