<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260520180820 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE personaje_habilidad ADD personaje_id INT NOT NULL, ADD habilidad_id INT NOT NULL');
        $this->addSql('ALTER TABLE personaje_habilidad ADD CONSTRAINT FK_659E9A32121EFAFB FOREIGN KEY (personaje_id) REFERENCES personaje (id)');
        $this->addSql('ALTER TABLE personaje_habilidad ADD CONSTRAINT FK_659E9A32621AA5D6 FOREIGN KEY (habilidad_id) REFERENCES habilidad (id)');
        $this->addSql('CREATE INDEX IDX_659E9A32121EFAFB ON personaje_habilidad (personaje_id)');
        $this->addSql('CREATE INDEX IDX_659E9A32621AA5D6 ON personaje_habilidad (habilidad_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE experiencia_historial DROP FOREIGN KEY FK_FBBE3568121EFAFB');
        $this->addSql('ALTER TABLE personaje_habilidad DROP FOREIGN KEY FK_659E9A32121EFAFB');
        $this->addSql('ALTER TABLE personaje_habilidad DROP FOREIGN KEY FK_659E9A32621AA5D6');
        $this->addSql('DROP INDEX IDX_659E9A32121EFAFB ON personaje_habilidad');
        $this->addSql('DROP INDEX IDX_659E9A32621AA5D6 ON personaje_habilidad');
        $this->addSql('ALTER TABLE personaje_habilidad DROP personaje_id, DROP habilidad_id');
    }
}
