<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190626102117 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE conference DROP FOREIGN KEY FK_911533C82CB716C7');
        $this->addSql('DROP INDEX IDX_911533C82CB716C7 ON conference');
        $this->addSql('ALTER TABLE conference DROP description, CHANGE yes_id commentaire_id INT NOT NULL');
        $this->addSql('ALTER TABLE conference ADD CONSTRAINT FK_911533C8BA9CD190 FOREIGN KEY (commentaire_id) REFERENCES commentaire (id)');
        $this->addSql('CREATE INDEX IDX_911533C8BA9CD190 ON conference (commentaire_id)');
        $this->addSql('ALTER TABLE users CHANGE no_id no_id INT NOT NULL');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A10856479F37AE5');
        $this->addSql('DROP INDEX UNIQ_5A10856479F37AE5 ON vote');
        $this->addSql('ALTER TABLE vote CHANGE id_user_id id_users_id INT NOT NULL');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A108564376858A8 FOREIGN KEY (id_users_id) REFERENCES users (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5A108564376858A8 ON vote (id_users_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, firstname VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, email VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, password VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE conference DROP FOREIGN KEY FK_911533C8BA9CD190');
        $this->addSql('DROP INDEX IDX_911533C8BA9CD190 ON conference');
        $this->addSql('ALTER TABLE conference ADD description VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE commentaire_id yes_id INT NOT NULL');
        $this->addSql('ALTER TABLE conference ADD CONSTRAINT FK_911533C82CB716C7 FOREIGN KEY (yes_id) REFERENCES commentaire (id)');
        $this->addSql('CREATE INDEX IDX_911533C82CB716C7 ON conference (yes_id)');
        $this->addSql('ALTER TABLE users CHANGE no_id no_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A108564376858A8');
        $this->addSql('DROP INDEX UNIQ_5A108564376858A8 ON vote');
        $this->addSql('ALTER TABLE vote CHANGE id_users_id id_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A10856479F37AE5 FOREIGN KEY (id_user_id) REFERENCES users (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5A10856479F37AE5 ON vote (id_user_id)');
    }
}
