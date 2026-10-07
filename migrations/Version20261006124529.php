<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261006124529 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE Category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, slug VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_FF3A7B975E237E06 (name), UNIQUE INDEX UNIQ_FF3A7B97989D9B62 (slug), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE Event (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(100) NOT NULL, slug VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, start_at DATETIME NOT NULL, end_at DATETIME NOT NULL, capacity INT NOT NULL, status VARCHAR(20) NOT NULL, category_id INT NOT NULL, organizer_id INT NOT NULL, UNIQUE INDEX UNIQ_FA6F25A3989D9B62 (slug), INDEX IDX_FA6F25A312469DE2 (category_id), INDEX IDX_FA6F25A3876C4DDA (organizer_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE Registration (id INT AUTO_INCREMENT NOT NULL, status VARCHAR(20) NOT NULL, created_at DATETIME NOT NULL, event_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_7A997C5F71F7E88B (event_id), INDEX IDX_7A997C5FA76ED395 (user_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE Event ADD CONSTRAINT FK_FA6F25A312469DE2 FOREIGN KEY (category_id) REFERENCES Category (id)');
        $this->addSql('ALTER TABLE Event ADD CONSTRAINT FK_FA6F25A3876C4DDA FOREIGN KEY (organizer_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE Registration ADD CONSTRAINT FK_7A997C5F71F7E88B FOREIGN KEY (event_id) REFERENCES Event (id)');
        $this->addSql('ALTER TABLE Registration ADD CONSTRAINT FK_7A997C5FA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE users CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE Event DROP FOREIGN KEY FK_FA6F25A312469DE2');
        $this->addSql('ALTER TABLE Event DROP FOREIGN KEY FK_FA6F25A3876C4DDA');
        $this->addSql('ALTER TABLE Registration DROP FOREIGN KEY FK_7A997C5F71F7E88B');
        $this->addSql('ALTER TABLE Registration DROP FOREIGN KEY FK_7A997C5FA76ED395');
        $this->addSql('DROP TABLE Category');
        $this->addSql('DROP TABLE Event');
        $this->addSql('DROP TABLE Registration');
        $this->addSql('ALTER TABLE users CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_bin`');
    }
}
