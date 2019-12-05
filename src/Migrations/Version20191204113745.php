<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191204113745 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE etapes (id INT AUTO_INCREMENT NOT NULL, voyage_id INT NOT NULL, titre VARCHAR(255) DEFAULT NULL, lieu VARCHAR(255) NOT NULL, date DATE NOT NULL, auteur VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_E3443E1768C9E5AF (voyage_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE etapes ADD CONSTRAINT FK_E3443E1768C9E5AF FOREIGN KEY (voyage_id) REFERENCES voyage (id)');
        $this->addSql('ALTER TABLE image ADD etapes_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F4F5CEED2 FOREIGN KEY (etapes_id) REFERENCES etapes (id)');
        $this->addSql('CREATE INDEX IDX_C53D045F4F5CEED2 ON image (etapes_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F4F5CEED2');
        $this->addSql('DROP TABLE etapes');
        $this->addSql('DROP INDEX IDX_C53D045F4F5CEED2 ON image');
        $this->addSql('ALTER TABLE image DROP etapes_id');
    }
}
