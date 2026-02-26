<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260226110014 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE audiovisuel (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(70) NOT NULL, description LONGTEXT DEFAULT NULL, realisateur VARCHAR(80) DEFAULT NULL, date_creation DATE DEFAULT NULL, duree INT DEFAULT NULL, affiche VARCHAR(255) DEFAULT NULL, type_audiovisuel_id INT DEFAULT NULL, INDEX IDX_670F0D446200AA03 (type_audiovisuel_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE audiovisuel_genre (id INT AUTO_INCREMENT NOT NULL, audiovisuel_id INT DEFAULT NULL, genre_id INT DEFAULT NULL, INDEX IDX_70CA9E5C34C38397 (audiovisuel_id), INDEX IDX_70CA9E5C4296D31F (genre_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE episode (id INT AUTO_INCREMENT NOT NULL, numero INT NOT NULL, titre VARCHAR(255) NOT NULL, duree INT NOT NULL, saison_id INT DEFAULT NULL, INDEX IDX_DDAA1CDAF965414C (saison_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE genre (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE note (id INT AUTO_INCREMENT NOT NULL, note INT NOT NULL, commentaire LONGTEXT DEFAULT NULL, date_creation DATETIME NOT NULL, audiovisuel_id INT DEFAULT NULL, utilisateur_id INT DEFAULT NULL, INDEX IDX_CFBDFA1434C38397 (audiovisuel_id), INDEX IDX_CFBDFA14FB88E14F (utilisateur_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE saison (id INT AUTO_INCREMENT NOT NULL, numero INT NOT NULL, audiovisuel_id INT DEFAULT NULL, INDEX IDX_C0D0D58634C38397 (audiovisuel_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE type_audiovisuel (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE audiovisuel ADD CONSTRAINT FK_670F0D446200AA03 FOREIGN KEY (type_audiovisuel_id) REFERENCES type_audiovisuel (id)');
        $this->addSql('ALTER TABLE audiovisuel_genre ADD CONSTRAINT FK_70CA9E5C34C38397 FOREIGN KEY (audiovisuel_id) REFERENCES audiovisuel (id)');
        $this->addSql('ALTER TABLE audiovisuel_genre ADD CONSTRAINT FK_70CA9E5C4296D31F FOREIGN KEY (genre_id) REFERENCES genre (id)');
        $this->addSql('ALTER TABLE episode ADD CONSTRAINT FK_DDAA1CDAF965414C FOREIGN KEY (saison_id) REFERENCES saison (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA1434C38397 FOREIGN KEY (audiovisuel_id) REFERENCES audiovisuel (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE saison ADD CONSTRAINT FK_C0D0D58634C38397 FOREIGN KEY (audiovisuel_id) REFERENCES audiovisuel (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE audiovisuel DROP FOREIGN KEY FK_670F0D446200AA03');
        $this->addSql('ALTER TABLE audiovisuel_genre DROP FOREIGN KEY FK_70CA9E5C34C38397');
        $this->addSql('ALTER TABLE audiovisuel_genre DROP FOREIGN KEY FK_70CA9E5C4296D31F');
        $this->addSql('ALTER TABLE episode DROP FOREIGN KEY FK_DDAA1CDAF965414C');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA1434C38397');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14FB88E14F');
        $this->addSql('ALTER TABLE saison DROP FOREIGN KEY FK_C0D0D58634C38397');
        $this->addSql('DROP TABLE audiovisuel');
        $this->addSql('DROP TABLE audiovisuel_genre');
        $this->addSql('DROP TABLE episode');
        $this->addSql('DROP TABLE genre');
        $this->addSql('DROP TABLE note');
        $this->addSql('DROP TABLE saison');
        $this->addSql('DROP TABLE type_audiovisuel');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
