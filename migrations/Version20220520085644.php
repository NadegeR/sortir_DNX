<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220520085644 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE etat ADD sortie_id INT NOT NULL');
        $this->addSql('ALTER TABLE etat ADD CONSTRAINT FK_55CAF762CC72D953 FOREIGN KEY (sortie_id) REFERENCES sortie (id)');
        $this->addSql('CREATE INDEX IDX_55CAF762CC72D953 ON etat (sortie_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE etat DROP FOREIGN KEY FK_55CAF762CC72D953');
        $this->addSql('DROP INDEX IDX_55CAF762CC72D953 ON etat');
        $this->addSql('ALTER TABLE etat DROP sortie_id');
    }
}
