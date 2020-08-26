<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200826163209 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE role_pro_user (role_id INT NOT NULL, pro_user_id INT NOT NULL, INDEX IDX_7760850AD60322AC (role_id), INDEX IDX_7760850A52C7154E (pro_user_id), PRIMARY KEY(role_id, pro_user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE role_pro_user ADD CONSTRAINT FK_7760850AD60322AC FOREIGN KEY (role_id) REFERENCES role (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE role_pro_user ADD CONSTRAINT FK_7760850A52C7154E FOREIGN KEY (pro_user_id) REFERENCES pro_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pro_user DROP profile_picture');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE role_pro_user');
        $this->addSql('ALTER TABLE pro_user ADD profile_picture VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
