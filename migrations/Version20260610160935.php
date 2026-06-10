<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260610160935 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE personaje_virtud (id INT AUTO_INCREMENT NOT NULL, personaje_id INT NOT NULL, virtud_id INT NOT NULL, nivel INT NOT NULL, INDEX IDX_6FC102BD121EFAFB (personaje_id), INDEX IDX_6FC102BD5D26887D (virtud_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE virtud (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(15) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE personaje_virtud ADD CONSTRAINT FK_6FC102BD121EFAFB FOREIGN KEY (personaje_id) REFERENCES personaje (id)');
        $this->addSql('ALTER TABLE personaje_virtud ADD CONSTRAINT FK_6FC102BD5D26887D FOREIGN KEY (virtud_id) REFERENCES virtud (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE personaje_virtud DROP FOREIGN KEY FK_6FC102BD121EFAFB');
        $this->addSql('ALTER TABLE personaje_virtud DROP FOREIGN KEY FK_6FC102BD5D26887D');
        $this->addSql('DROP TABLE personaje_virtud');
        $this->addSql('DROP TABLE virtud');
        $this->addSql('ALTER TABLE experiencia_historial DROP FOREIGN KEY FK_FBBE3568121EFAFB');
    }
}
