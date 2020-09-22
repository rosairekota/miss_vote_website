<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200921163544 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE candidat (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, postnom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, origine VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, photo_name VARCHAR(255) DEFAULT NULL, motdepasse VARCHAR(255) NOT NULL, sexe VARCHAR(255) DEFAULT NULL, date_naissance DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, post_id INT DEFAULT NULL, votant_id INT DEFAULT NULL, candidat_id INT DEFAULT NULL, comment LONGTEXT NOT NULL, INDEX IDX_9474526C4B89032C (post_id), INDEX IDX_9474526CECABD6E4 (votant_id), INDEX IDX_9474526C8D0EB82 (candidat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE competition (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, prix INT NOT NULL, date_competition DATETIME NOT NULL, lieu VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cote (id INT AUTO_INCREMENT NOT NULL, votant_id INT DEFAULT NULL, candidat_id INT DEFAULT NULL, competition_id INT DEFAULT NULL, cote_votant DOUBLE PRECISION DEFAULT NULL, cote_jury DOUBLE PRECISION DEFAULT NULL, montant_paye NUMERIC(10, 0) DEFAULT NULL, INDEX IDX_3DD722C9ECABD6E4 (votant_id), INDEX IDX_3DD722C98D0EB82 (candidat_id), INDEX IDX_3DD722C97B39D312 (competition_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, candidat_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, image_name VARCHAR(255) DEFAULT NULL, content LONGTEXT NOT NULL, create_at DATETIME NOT NULL, posted TINYINT(1) NOT NULL, updated_at DATETIME DEFAULT NULL, category VARCHAR(255) NOT NULL, INDEX IDX_5A8A6C8DA76ED395 (user_id), INDEX IDX_5A8A6C8D8D0EB82 (candidat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE theme (id INT AUTO_INCREMENT NOT NULL, competition_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, exigence LONGTEXT DEFAULT NULL, INDEX IDX_9775E7087B39D312 (competition_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE votant (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, adresse LONGTEXT NOT NULL, telephone VARCHAR(255) NOT NULL, motdepass VARCHAR(255) NOT NULL, photo_name VARCHAR(255) DEFAULT NULL, category VARCHAR(255) DEFAULT NULL, sexe VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C4B89032C FOREIGN KEY (post_id) REFERENCES post (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CECABD6E4 FOREIGN KEY (votant_id) REFERENCES votant (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C8D0EB82 FOREIGN KEY (candidat_id) REFERENCES candidat (id)');
        $this->addSql('ALTER TABLE cote ADD CONSTRAINT FK_3DD722C9ECABD6E4 FOREIGN KEY (votant_id) REFERENCES votant (id)');
        $this->addSql('ALTER TABLE cote ADD CONSTRAINT FK_3DD722C98D0EB82 FOREIGN KEY (candidat_id) REFERENCES candidat (id)');
        $this->addSql('ALTER TABLE cote ADD CONSTRAINT FK_3DD722C97B39D312 FOREIGN KEY (competition_id) REFERENCES competition (id)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D8D0EB82 FOREIGN KEY (candidat_id) REFERENCES candidat (id)');
        $this->addSql('ALTER TABLE theme ADD CONSTRAINT FK_9775E7087B39D312 FOREIGN KEY (competition_id) REFERENCES competition (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C8D0EB82');
        $this->addSql('ALTER TABLE cote DROP FOREIGN KEY FK_3DD722C98D0EB82');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D8D0EB82');
        $this->addSql('ALTER TABLE cote DROP FOREIGN KEY FK_3DD722C97B39D312');
        $this->addSql('ALTER TABLE theme DROP FOREIGN KEY FK_9775E7087B39D312');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C4B89032C');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DA76ED395');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CECABD6E4');
        $this->addSql('ALTER TABLE cote DROP FOREIGN KEY FK_3DD722C9ECABD6E4');
        $this->addSql('DROP TABLE candidat');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE competition');
        $this->addSql('DROP TABLE cote');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE theme');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE votant');
    }
}
