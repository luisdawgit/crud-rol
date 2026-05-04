<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260429184400 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE personaje_atributo (id INT AUTO_INCREMENT NOT NULL, personaje_id INT NOT NULL, atributo_id INT NOT NULL, nivel INT NOT NULL, INDEX IDX_50CF3CB2121EFAFB (personaje_id), INDEX IDX_50CF3CB2A55FF1F3 (atributo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE personaje_atributo ADD CONSTRAINT FK_50CF3CB2121EFAFB FOREIGN KEY (personaje_id) REFERENCES personaje (id)');
        $this->addSql('ALTER TABLE personaje_atributo ADD CONSTRAINT FK_50CF3CB2A55FF1F3 FOREIGN KEY (atributo_id) REFERENCES atributo (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE personaje_atributo DROP FOREIGN KEY FK_50CF3CB2121EFAFB');
        $this->addSql('ALTER TABLE personaje_atributo DROP FOREIGN KEY FK_50CF3CB2A55FF1F3');
        $this->addSql('DROP TABLE personaje_atributo');
        $this->addSql('ALTER TABLE experiencia_historial DROP FOREIGN KEY FK_FBBE3568121EFAFB');
    }
}
