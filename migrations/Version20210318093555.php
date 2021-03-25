<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210318093555 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE deelnames CHANGE app_users_id user_id INT NOT NULL, ADD PRIMARY KEY (user_id, activiteiten_id)');
        $this->addSql('ALTER TABLE deelnames ADD CONSTRAINT FK_ED2478E7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE deelnames ADD CONSTRAINT FK_ED2478E7808BDE57 FOREIGN KEY (activiteiten_id) REFERENCES activiteiten (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_ED2478E7A76ED395 ON deelnames (user_id)');
        $this->addSql('CREATE INDEX IDX_ED2478E7808BDE57 ON deelnames (activiteiten_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE deelnames DROP FOREIGN KEY FK_ED2478E7A76ED395');
        $this->addSql('ALTER TABLE deelnames DROP FOREIGN KEY FK_ED2478E7808BDE57');
        $this->addSql('DROP INDEX IDX_ED2478E7A76ED395 ON deelnames');
        $this->addSql('DROP INDEX IDX_ED2478E7808BDE57 ON deelnames');
        $this->addSql('ALTER TABLE deelnames DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE deelnames CHANGE user_id app_users_id INT NOT NULL');
    }
}
