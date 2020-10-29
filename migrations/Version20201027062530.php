<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201027062530 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cote DROP FOREIGN KEY FK_3DD722C97B39D312');
        $this->addSql('DROP INDEX IDX_3DD722C97B39D312 ON cote');
        $this->addSql('ALTER TABLE cote DROP competition_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cote ADD competition_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cote ADD CONSTRAINT FK_3DD722C97B39D312 FOREIGN KEY (competition_id) REFERENCES competition (id)');
        $this->addSql('CREATE INDEX IDX_3DD722C97B39D312 ON cote (competition_id)');
    }
}
