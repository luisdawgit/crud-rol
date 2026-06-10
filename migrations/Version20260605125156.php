<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260605125156 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE personaje_trasfondo (id INT AUTO_INCREMENT NOT NULL, personaje_id INT NOT NULL, trasfondo_id INT NOT NULL, nivel INT NOT NULL, INDEX IDX_C612C999121EFAFB (personaje_id), INDEX IDX_C612C999C2AFD668 (trasfondo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trasfondo (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE personaje_trasfondo ADD CONSTRAINT FK_C612C999121EFAFB FOREIGN KEY (personaje_id) REFERENCES personaje (id)');
        $this->addSql('ALTER TABLE personaje_trasfondo ADD CONSTRAINT FK_C612C999C2AFD668 FOREIGN KEY (trasfondo_id) REFERENCES trasfondo (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE personaje_trasfondo DROP FOREIGN KEY FK_C612C999121EFAFB');
        $this->addSql('ALTER TABLE personaje_trasfondo DROP FOREIGN KEY FK_C612C999C2AFD668');
        $this->addSql('DROP TABLE personaje_trasfondo');
        $this->addSql('DROP TABLE trasfondo');
        $this->addSql('ALTER TABLE experiencia_historial DROP FOREIGN KEY FK_FBBE3568121EFAFB');
    }
}
