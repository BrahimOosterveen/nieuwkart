<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210330102706 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE activiteiten (id INT AUTO_INCREMENT NOT NULL, soort_id INT DEFAULT NULL, datum DATE NOT NULL, tijd TIME NOT NULL, INDEX IDX_1C50895F3DEE50DF (soort_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE soortactiviteiten (id INT AUTO_INCREMENT NOT NULL, naam VARCHAR(255) NOT NULL, min_leeftijd INT NOT NULL, tijdsduur INT NOT NULL, prijs NUMERIC(6, 2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, voorletters VARCHAR(255) DEFAULT NULL, tussenvoegsel VARCHAR(255) DEFAULT NULL, achternaam VARCHAR(255) DEFAULT NULL, adres VARCHAR(255) DEFAULT NULL, postcode VARCHAR(255) DEFAULT NULL, woonplaats VARCHAR(255) DEFAULT NULL, telefoon VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE deelnames (user_id INT NOT NULL, activiteiten_id INT NOT NULL, INDEX IDX_ED2478E7A76ED395 (user_id), INDEX IDX_ED2478E7808BDE57 (activiteiten_id), PRIMARY KEY(user_id, activiteiten_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE activiteiten ADD CONSTRAINT FK_1C50895F3DEE50DF FOREIGN KEY (soort_id) REFERENCES soortactiviteiten (id)');
        $this->addSql('ALTER TABLE deelnames ADD CONSTRAINT FK_ED2478E7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE deelnames ADD CONSTRAINT FK_ED2478E7808BDE57 FOREIGN KEY (activiteiten_id) REFERENCES activiteiten (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE deelnames DROP FOREIGN KEY FK_ED2478E7808BDE57');
        $this->addSql('ALTER TABLE activiteiten DROP FOREIGN KEY FK_1C50895F3DEE50DF');
        $this->addSql('ALTER TABLE deelnames DROP FOREIGN KEY FK_ED2478E7A76ED395');
        $this->addSql('DROP TABLE activiteiten');
        $this->addSql('DROP TABLE soortactiviteiten');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE deelnames');
    }
}
