<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210726172518 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE activity (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE activity_actor (activity_id INT NOT NULL, actor_id INT NOT NULL, INDEX IDX_5A77604A81C06096 (activity_id), INDEX IDX_5A77604A10DAF24A (actor_id), PRIMARY KEY(activity_id, actor_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE casting (id INT AUTO_INCREMENT NOT NULL, recruiter_id INT DEFAULT NULL, INDEX IDX_D11BBA50156BE243 (recruiter_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE file (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, link VARCHAR(255) NOT NULL, INDEX IDX_8C9F3610A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE roleplay (id INT AUTO_INCREMENT NOT NULL, actor_id INT DEFAULT NULL, casting_id INT DEFAULT NULL, INDEX IDX_A780433210DAF24A (actor_id), INDEX IDX_A78043329EB2648F (casting_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE roleplay_activity (roleplay_id INT NOT NULL, activity_id INT NOT NULL, INDEX IDX_A96EAAC477426B8F (roleplay_id), INDEX IDX_A96EAAC481C06096 (activity_id), PRIMARY KEY(roleplay_id, activity_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, profile_image_id INT DEFAULT NULL, agent_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, discr VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D649C4CF44DC (profile_image_id), INDEX IDX_8D93D6493414710B (agent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE activity_actor ADD CONSTRAINT FK_5A77604A81C06096 FOREIGN KEY (activity_id) REFERENCES activity (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE activity_actor ADD CONSTRAINT FK_5A77604A10DAF24A FOREIGN KEY (actor_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE casting ADD CONSTRAINT FK_D11BBA50156BE243 FOREIGN KEY (recruiter_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE file ADD CONSTRAINT FK_8C9F3610A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE roleplay ADD CONSTRAINT FK_A780433210DAF24A FOREIGN KEY (actor_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE roleplay ADD CONSTRAINT FK_A78043329EB2648F FOREIGN KEY (casting_id) REFERENCES casting (id)');
        $this->addSql('ALTER TABLE roleplay_activity ADD CONSTRAINT FK_A96EAAC477426B8F FOREIGN KEY (roleplay_id) REFERENCES roleplay (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE roleplay_activity ADD CONSTRAINT FK_A96EAAC481C06096 FOREIGN KEY (activity_id) REFERENCES activity (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D649C4CF44DC FOREIGN KEY (profile_image_id) REFERENCES file (id)');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D6493414710B FOREIGN KEY (agent_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activity_actor DROP FOREIGN KEY FK_5A77604A81C06096');
        $this->addSql('ALTER TABLE roleplay_activity DROP FOREIGN KEY FK_A96EAAC481C06096');
        $this->addSql('ALTER TABLE roleplay DROP FOREIGN KEY FK_A78043329EB2648F');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649C4CF44DC');
        $this->addSql('ALTER TABLE roleplay_activity DROP FOREIGN KEY FK_A96EAAC477426B8F');
        $this->addSql('ALTER TABLE activity_actor DROP FOREIGN KEY FK_5A77604A10DAF24A');
        $this->addSql('ALTER TABLE casting DROP FOREIGN KEY FK_D11BBA50156BE243');
        $this->addSql('ALTER TABLE file DROP FOREIGN KEY FK_8C9F3610A76ED395');
        $this->addSql('ALTER TABLE roleplay DROP FOREIGN KEY FK_A780433210DAF24A');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D6493414710B');
        $this->addSql('DROP TABLE activity');
        $this->addSql('DROP TABLE activity_actor');
        $this->addSql('DROP TABLE casting');
        $this->addSql('DROP TABLE file');
        $this->addSql('DROP TABLE roleplay');
        $this->addSql('DROP TABLE roleplay_activity');
        $this->addSql('DROP TABLE `user`');
    }
}
