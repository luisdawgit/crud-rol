<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260401164537 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE clan (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE clan_disciplina (id INT AUTO_INCREMENT NOT NULL, clan_id INT NOT NULL, disciplina_id INT NOT NULL, INDEX IDX_4AA1E506BEAF84C8 (clan_id), INDEX IDX_4AA1E5062A30B056 (disciplina_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE disciplina (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personaje (id INT AUTO_INCREMENT NOT NULL, clan_id INT NOT NULL, usuario_id INT NOT NULL, experiencia INT NOT NULL, nombre VARCHAR(40) NOT NULL, INDEX IDX_53A41088BEAF84C8 (clan_id), INDEX IDX_53A41088DB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personaje_disciplina (id INT AUTO_INCREMENT NOT NULL, disciplina_id INT NOT NULL, personaje_id INT NOT NULL, nivel INT NOT NULL, INDEX IDX_99F5A8A92A30B056 (disciplina_id), INDEX IDX_99F5A8A9121EFAFB (personaje_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usuario (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(50) NOT NULL, password VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE clan_disciplina ADD CONSTRAINT FK_4AA1E506BEAF84C8 FOREIGN KEY (clan_id) REFERENCES clan (id)');
        $this->addSql('ALTER TABLE clan_disciplina ADD CONSTRAINT FK_4AA1E5062A30B056 FOREIGN KEY (disciplina_id) REFERENCES disciplina (id)');
        $this->addSql('ALTER TABLE personaje ADD CONSTRAINT FK_53A41088BEAF84C8 FOREIGN KEY (clan_id) REFERENCES clan (id)');
        $this->addSql('ALTER TABLE personaje ADD CONSTRAINT FK_53A41088DB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE personaje_disciplina ADD CONSTRAINT FK_99F5A8A92A30B056 FOREIGN KEY (disciplina_id) REFERENCES disciplina (id)');
        $this->addSql('ALTER TABLE personaje_disciplina ADD CONSTRAINT FK_99F5A8A9121EFAFB FOREIGN KEY (personaje_id) REFERENCES personaje (id)');
        $this->addSql('DROP TABLE clan_disciplinas');
        $this->addSql('DROP TABLE clanes');
        $this->addSql('DROP TABLE disciplinas');
        $this->addSql('DROP TABLE personaje_disciplinas');
        $this->addSql('DROP TABLE personajes');
        $this->addSql('DROP TABLE usuarios');
        $this->addSql('ALTER TABLE experiencia_historial CHANGE personaje_id personaje_id INT NOT NULL, CHANGE cantidad cantidad INT NOT NULL, CHANGE tipo tipo VARCHAR(10) NOT NULL, CHANGE descripcion descripcion VARCHAR(50) DEFAULT NULL, CHANGE fecha fecha DATETIME NOT NULL');
        $this->addSql('ALTER TABLE experiencia_historial RENAME INDEX personaje_id TO IDX_FBBE3568121EFAFB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE experiencia_historial DROP FOREIGN KEY FK_FBBE3568121EFAFB');
        $this->addSql('CREATE TABLE clan_disciplinas (clan_id INT NOT NULL, disciplina_id INT NOT NULL, INDEX disciplina_id (disciplina_id), PRIMARY KEY(clan_id, disciplina_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('CREATE TABLE clanes (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, UNIQUE INDEX nombre (nombre), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('CREATE TABLE disciplinas (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, UNIQUE INDEX nombre (nombre), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('CREATE TABLE personaje_disciplinas (personaje_id INT NOT NULL, disciplina_id INT NOT NULL, nivel INT DEFAULT 1 NOT NULL, INDEX disciplina_id (disciplina_id), PRIMARY KEY(personaje_id, disciplina_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('CREATE TABLE personajes (id INT AUTO_INCREMENT NOT NULL, usuario_id INT NOT NULL, clan_id INT NOT NULL, nombre VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, experiencia INT DEFAULT 0, INDEX usuario_id (usuario_id), INDEX clan_id (clan_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('CREATE TABLE usuarios (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(15) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, password VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, UNIQUE INDEX username (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('ALTER TABLE clan_disciplina DROP FOREIGN KEY FK_4AA1E506BEAF84C8');
        $this->addSql('ALTER TABLE clan_disciplina DROP FOREIGN KEY FK_4AA1E5062A30B056');
        $this->addSql('ALTER TABLE personaje DROP FOREIGN KEY FK_53A41088BEAF84C8');
        $this->addSql('ALTER TABLE personaje DROP FOREIGN KEY FK_53A41088DB38439E');
        $this->addSql('ALTER TABLE personaje_disciplina DROP FOREIGN KEY FK_99F5A8A92A30B056');
        $this->addSql('ALTER TABLE personaje_disciplina DROP FOREIGN KEY FK_99F5A8A9121EFAFB');
        $this->addSql('DROP TABLE clan');
        $this->addSql('DROP TABLE clan_disciplina');
        $this->addSql('DROP TABLE disciplina');
        $this->addSql('DROP TABLE personaje');
        $this->addSql('DROP TABLE personaje_disciplina');
        $this->addSql('DROP TABLE usuario');
        $this->addSql('ALTER TABLE experiencia_historial CHANGE personaje_id personaje_id INT DEFAULT NULL, CHANGE cantidad cantidad INT DEFAULT NULL, CHANGE fecha fecha DATETIME DEFAULT CURRENT_TIMESTAMP, CHANGE tipo tipo VARCHAR(50) DEFAULT NULL, CHANGE descripcion descripcion VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE experiencia_historial RENAME INDEX idx_fbbe3568121efafb TO personaje_id');
    }
}
