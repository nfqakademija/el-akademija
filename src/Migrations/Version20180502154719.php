<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180502154719 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE lecture ADD lector_id INT NOT NULL');
        $this->addSql('ALTER TABLE lecture ADD CONSTRAINT FK_C1677948ADEC45C7 FOREIGN KEY (lector_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_C1677948ADEC45C7 ON lecture (lector_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE lecture DROP FOREIGN KEY FK_C1677948ADEC45C7');
        $this->addSql('DROP INDEX IDX_C1677948ADEC45C7 ON lecture');
        $this->addSql('ALTER TABLE lecture DROP lector_id');
    }
}
