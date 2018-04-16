<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180416160920 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE homework_link DROP FOREIGN KEY FK_84AA94A435E32FCD');
        $this->addSql('DROP INDEX IDX_84AA94A435E32FCD ON homework_link');
        $this->addSql('ALTER TABLE homework_link CHANGE lecture_id homework_id INT NOT NULL');
        $this->addSql('ALTER TABLE homework_link ADD CONSTRAINT FK_84AA94A4B203DDE5 FOREIGN KEY (homework_id) REFERENCES homework (id)');
        $this->addSql('CREATE INDEX IDX_84AA94A4B203DDE5 ON homework_link (homework_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE homework_link DROP FOREIGN KEY FK_84AA94A4B203DDE5');
        $this->addSql('DROP INDEX IDX_84AA94A4B203DDE5 ON homework_link');
        $this->addSql('ALTER TABLE homework_link CHANGE homework_id lecture_id INT NOT NULL');
        $this->addSql('ALTER TABLE homework_link ADD CONSTRAINT FK_84AA94A435E32FCD FOREIGN KEY (lecture_id) REFERENCES lecture (id)');
        $this->addSql('CREATE INDEX IDX_84AA94A435E32FCD ON homework_link (lecture_id)');
    }
}
