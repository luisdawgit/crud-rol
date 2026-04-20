<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260416184636 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE personaje DROP FOREIGN KEY FK_53A41088DB38439E');
        $this->addSql('ALTER TABLE personaje ADD CONSTRAINT FK_53A41088DB38439E FOREIGN KEY (usuario_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE experiencia_historial DROP FOREIGN KEY FK_FBBE3568121EFAFB');
        $this->addSql('ALTER TABLE personaje DROP FOREIGN KEY FK_53A41088DB38439E');
        $this->addSql('ALTER TABLE personaje ADD CONSTRAINT FK_53A41088DB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
