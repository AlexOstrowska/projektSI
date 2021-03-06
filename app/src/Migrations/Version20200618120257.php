<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200618120257 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE answer (id INT AUTO_INCREMENT NOT NULL, question_id INT DEFAULT NULL, text VARCHAR(255) NOT NULL, email VARCHAR(180) NOT NULL, name VARCHAR(64) NOT NULL, favourite INT DEFAULT 0 NOT NULL, INDEX IDX_DADD4A251E27F6BF (question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, title VARCHAR(64) NOT NULL, code VARCHAR(64) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE questions (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, created_at DATETIME NOT NULL, title VARCHAR(255) NOT NULL, text VARCHAR(255) NOT NULL, INDEX IDX_8ADC54D512469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE questions_tag (question_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_143D81931E27F6BF (question_id), INDEX IDX_143D8193BAD26311 (tag_id), PRIMARY KEY(question_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(64) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT UNSIGNED AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX email_idx (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A251E27F6BF FOREIGN KEY (question_id) REFERENCES questions (id)');
        $this->addSql('ALTER TABLE questions ADD CONSTRAINT FK_8ADC54D512469DE2 FOREIGN KEY (category_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE questions_tag ADD CONSTRAINT FK_143D81931E27F6BF FOREIGN KEY (question_id) REFERENCES questions (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE questions_tag ADD CONSTRAINT FK_143D8193BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE questions DROP FOREIGN KEY FK_8ADC54D512469DE2');
        $this->addSql('ALTER TABLE answer DROP FOREIGN KEY FK_DADD4A251E27F6BF');
        $this->addSql('ALTER TABLE questions_tag DROP FOREIGN KEY FK_143D81931E27F6BF');
        $this->addSql('ALTER TABLE questions_tag DROP FOREIGN KEY FK_143D8193BAD26311');
        $this->addSql('DROP TABLE answer');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE questions');
        $this->addSql('DROP TABLE questions_tag');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE users');
    }
}
