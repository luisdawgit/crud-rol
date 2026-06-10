<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260608172129 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE personaje_trasfondo DROP FOREIGN KEY FK_C612C999121EFAFB');
        $this->addSql('ALTER TABLE personaje_trasfondo ADD CONSTRAINT FK_C612C999121EFAFB FOREIGN KEY (personaje_id) REFERENCES personaje (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE personaje_trasfondo DROP FOREIGN KEY FK_C612C999121EFAFB');
        $this->addSql('ALTER TABLE personaje_trasfondo ADD CONSTRAINT FK_C612C999121EFAFB FOREIGN KEY (personaje_id) REFERENCES personaje (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE experiencia_historial DROP FOREIGN KEY FK_FBBE3568121EFAFB');
    }
}
