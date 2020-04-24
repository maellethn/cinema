<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200423145839 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE acteur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bande_annonce (id INT AUTO_INCREMENT NOT NULL, film_id INT NOT NULL, lien VARCHAR(255) NOT NULL, INDEX IDX_F94979DE567F5183 (film_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, film_id INT NOT NULL, pseudo VARCHAR(255) NOT NULL, date DATETIME NOT NULL, note DOUBLE PRECISION NOT NULL, INDEX IDX_67F068BC567F5183 (film_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE film (id INT AUTO_INCREMENT NOT NULL, realisateur_id INT NOT NULL, titre VARCHAR(255) NOT NULL, affiche VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, duree VARCHAR(255) NOT NULL, date_sortie VARCHAR(255) NOT NULL, etat INT NOT NULL, INDEX IDX_8244BE22F1D8422E (realisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE film_acteur (film_id INT NOT NULL, acteur_id INT NOT NULL, INDEX IDX_8108EE68567F5183 (film_id), INDEX IDX_8108EE68DA6F574A (acteur_id), PRIMARY KEY(film_id, acteur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE film_categorie (film_id INT NOT NULL, categorie_id INT NOT NULL, INDEX IDX_7DB18807567F5183 (film_id), INDEX IDX_7DB18807BCF5E72D (categorie_id), PRIMARY KEY(film_id, categorie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE film_salle (film_id INT NOT NULL, salle_id INT NOT NULL, INDEX IDX_D7FB800C567F5183 (film_id), INDEX IDX_D7FB800CDC304035 (salle_id), PRIMARY KEY(film_id, salle_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photo (id INT AUTO_INCREMENT NOT NULL, film_id INT NOT NULL, lien VARCHAR(255) NOT NULL, INDEX IDX_14B78418567F5183 (film_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE realisateur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE salle (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sceance (id INT AUTO_INCREMENT NOT NULL, salle_id INT NOT NULL, film_id INT NOT NULL, date DATETIME NOT NULL, INDEX IDX_2D854BFEDC304035 (salle_id), INDEX IDX_2D854BFE567F5183 (film_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bande_annonce ADD CONSTRAINT FK_F94979DE567F5183 FOREIGN KEY (film_id) REFERENCES film (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC567F5183 FOREIGN KEY (film_id) REFERENCES film (id)');
        $this->addSql('ALTER TABLE film ADD CONSTRAINT FK_8244BE22F1D8422E FOREIGN KEY (realisateur_id) REFERENCES realisateur (id)');
        $this->addSql('ALTER TABLE film_acteur ADD CONSTRAINT FK_8108EE68567F5183 FOREIGN KEY (film_id) REFERENCES film (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE film_acteur ADD CONSTRAINT FK_8108EE68DA6F574A FOREIGN KEY (acteur_id) REFERENCES acteur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE film_categorie ADD CONSTRAINT FK_7DB18807567F5183 FOREIGN KEY (film_id) REFERENCES film (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE film_categorie ADD CONSTRAINT FK_7DB18807BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE film_salle ADD CONSTRAINT FK_D7FB800C567F5183 FOREIGN KEY (film_id) REFERENCES film (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE film_salle ADD CONSTRAINT FK_D7FB800CDC304035 FOREIGN KEY (salle_id) REFERENCES salle (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B78418567F5183 FOREIGN KEY (film_id) REFERENCES film (id)');
        $this->addSql('ALTER TABLE sceance ADD CONSTRAINT FK_2D854BFEDC304035 FOREIGN KEY (salle_id) REFERENCES salle (id)');
        $this->addSql('ALTER TABLE sceance ADD CONSTRAINT FK_2D854BFE567F5183 FOREIGN KEY (film_id) REFERENCES film (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE film_acteur DROP FOREIGN KEY FK_8108EE68DA6F574A');
        $this->addSql('ALTER TABLE film_categorie DROP FOREIGN KEY FK_7DB18807BCF5E72D');
        $this->addSql('ALTER TABLE bande_annonce DROP FOREIGN KEY FK_F94979DE567F5183');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC567F5183');
        $this->addSql('ALTER TABLE film_acteur DROP FOREIGN KEY FK_8108EE68567F5183');
        $this->addSql('ALTER TABLE film_categorie DROP FOREIGN KEY FK_7DB18807567F5183');
        $this->addSql('ALTER TABLE film_salle DROP FOREIGN KEY FK_D7FB800C567F5183');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B78418567F5183');
        $this->addSql('ALTER TABLE sceance DROP FOREIGN KEY FK_2D854BFE567F5183');
        $this->addSql('ALTER TABLE film DROP FOREIGN KEY FK_8244BE22F1D8422E');
        $this->addSql('ALTER TABLE film_salle DROP FOREIGN KEY FK_D7FB800CDC304035');
        $this->addSql('ALTER TABLE sceance DROP FOREIGN KEY FK_2D854BFEDC304035');
        $this->addSql('DROP TABLE acteur');
        $this->addSql('DROP TABLE bande_annonce');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE film');
        $this->addSql('DROP TABLE film_acteur');
        $this->addSql('DROP TABLE film_categorie');
        $this->addSql('DROP TABLE film_salle');
        $this->addSql('DROP TABLE photo');
        $this->addSql('DROP TABLE realisateur');
        $this->addSql('DROP TABLE salle');
        $this->addSql('DROP TABLE sceance');
    }
}
