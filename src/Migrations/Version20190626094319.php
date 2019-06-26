<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190626094319 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, commentaire VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE conference (id INT AUTO_INCREMENT NOT NULL, yes_id INT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, date VARCHAR(255) NOT NULL, INDEX IDX_911533C82CB716C7 (yes_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, no_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, INDEX IDX_1483A5E91A65C546 (no_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vote (id INT AUTO_INCREMENT NOT NULL, id_user_id INT NOT NULL, id_conf_id INT NOT NULL, vote VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_5A10856479F37AE5 (id_user_id), UNIQUE INDEX UNIQ_5A108564A142E028 (id_conf_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE conference ADD CONSTRAINT FK_911533C82CB716C7 FOREIGN KEY (yes_id) REFERENCES commentaire (id)');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E91A65C546 FOREIGN KEY (no_id) REFERENCES commentaire (id)');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A10856479F37AE5 FOREIGN KEY (id_user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A108564A142E028 FOREIGN KEY (id_conf_id) REFERENCES conference (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE conference DROP FOREIGN KEY FK_911533C82CB716C7');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E91A65C546');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A108564A142E028');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A10856479F37AE5');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE conference');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE vote');
    }
}
