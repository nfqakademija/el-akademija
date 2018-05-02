<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180502135609 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE homework_grade (id INT AUTO_INCREMENT NOT NULL, homework_link_id INT NOT NULL, user_id INT NOT NULL, grade SMALLINT NOT NULL, comment LONGTEXT NOT NULL, created DATETIME NOT NULL, INDEX IDX_42E90D429B1E35E0 (homework_link_id), INDEX IDX_42E90D42A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE homework_grade ADD CONSTRAINT FK_42E90D429B1E35E0 FOREIGN KEY (homework_link_id) REFERENCES homework_link (id)');
        $this->addSql('ALTER TABLE homework_grade ADD CONSTRAINT FK_42E90D42A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE homework_link DROP grade, DROP comment');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE homework_grade');
        $this->addSql('ALTER TABLE homework_link ADD grade SMALLINT DEFAULT NULL, ADD comment LONGTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci');
    }
}
