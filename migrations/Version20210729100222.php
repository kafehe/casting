<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210729100222 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE activity (id INT AUTO_INCREMENT NOT NULL, name_activity VARCHAR(100) NOT NULL, member INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE casting (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(100) NOT NULL, description_cast TINYTEXT NOT NULL, object_cast VARCHAR(100) NOT NULL, date_cast DATE NOT NULL, type_cast VARCHAR(100) NOT NULL, location VARCHAR(100) NOT NULL, casting_place VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE casting_document (casting_id INT NOT NULL, document_id INT NOT NULL, INDEX IDX_7F7643B19EB2648F (casting_id), INDEX IDX_7F7643B1C33F7837 (document_id), PRIMARY KEY(casting_id, document_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE document (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name_doc VARCHAR(100) NOT NULL, numero_doc VARCHAR(100) NOT NULL, date_del DATE NOT NULL, date_exp DATE NOT NULL, INDEX IDX_D8698A76A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE file (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, casting_id INT DEFAULT NULL, document_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, link VARCHAR(255) NOT NULL, INDEX IDX_8C9F3610A76ED395 (user_id), INDEX IDX_8C9F36109EB2648F (casting_id), INDEX IDX_8C9F3610C33F7837 (document_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profile (id INT AUTO_INCREMENT NOT NULL, attribute VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profile_skill (profile_id INT NOT NULL, skill_id INT NOT NULL, INDEX IDX_A9E97BA5CCFA12B8 (profile_id), INDEX IDX_A9E97BA55585C142 (skill_id), PRIMARY KEY(profile_id, skill_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE roleplay (id INT AUTO_INCREMENT NOT NULL, casting_id INT DEFAULT NULL, title_role VARCHAR(100) NOT NULL, firstname_role VARCHAR(100) NOT NULL, lastname_role VARCHAR(100) NOT NULL, range_age VARCHAR(100) NOT NULL, description_role TINYTEXT NOT NULL, gender_role VARCHAR(100) NOT NULL, INDEX IDX_A78043329EB2648F (casting_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE roleplay_activity (roleplay_id INT NOT NULL, activity_id INT NOT NULL, INDEX IDX_A96EAAC477426B8F (roleplay_id), INDEX IDX_A96EAAC481C06096 (activity_id), PRIMARY KEY(roleplay_id, activity_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skill (id INT AUTO_INCREMENT NOT NULL, name_skill VARCHAR(100) NOT NULL, rating VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, profile_image_id INT DEFAULT NULL, profile_id INT DEFAULT NULL, manager_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, birth_date DATE NOT NULL, firstname VARCHAR(100) NOT NULL, lastname VARCHAR(100) NOT NULL, phone VARCHAR(100) NOT NULL, adress VARCHAR(255) NOT NULL, nationality VARCHAR(100) NOT NULL, gender VARCHAR(100) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D649C4CF44DC (profile_image_id), UNIQUE INDEX UNIQ_8D93D649CCFA12B8 (profile_id), INDEX IDX_8D93D649783E3463 (manager_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE casting_document ADD CONSTRAINT FK_7F7643B19EB2648F FOREIGN KEY (casting_id) REFERENCES casting (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE casting_document ADD CONSTRAINT FK_7F7643B1C33F7837 FOREIGN KEY (document_id) REFERENCES document (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A76A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE file ADD CONSTRAINT FK_8C9F3610A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE file ADD CONSTRAINT FK_8C9F36109EB2648F FOREIGN KEY (casting_id) REFERENCES casting (id)');
        $this->addSql('ALTER TABLE file ADD CONSTRAINT FK_8C9F3610C33F7837 FOREIGN KEY (document_id) REFERENCES document (id)');
        $this->addSql('ALTER TABLE profile_skill ADD CONSTRAINT FK_A9E97BA5CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE profile_skill ADD CONSTRAINT FK_A9E97BA55585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE roleplay ADD CONSTRAINT FK_A78043329EB2648F FOREIGN KEY (casting_id) REFERENCES casting (id)');
        $this->addSql('ALTER TABLE roleplay_activity ADD CONSTRAINT FK_A96EAAC477426B8F FOREIGN KEY (roleplay_id) REFERENCES roleplay (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE roleplay_activity ADD CONSTRAINT FK_A96EAAC481C06096 FOREIGN KEY (activity_id) REFERENCES activity (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D649C4CF44DC FOREIGN KEY (profile_image_id) REFERENCES file (id)');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D649CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id)');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D649783E3463 FOREIGN KEY (manager_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE roleplay_activity DROP FOREIGN KEY FK_A96EAAC481C06096');
        $this->addSql('ALTER TABLE casting_document DROP FOREIGN KEY FK_7F7643B19EB2648F');
        $this->addSql('ALTER TABLE file DROP FOREIGN KEY FK_8C9F36109EB2648F');
        $this->addSql('ALTER TABLE roleplay DROP FOREIGN KEY FK_A78043329EB2648F');
        $this->addSql('ALTER TABLE casting_document DROP FOREIGN KEY FK_7F7643B1C33F7837');
        $this->addSql('ALTER TABLE file DROP FOREIGN KEY FK_8C9F3610C33F7837');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649C4CF44DC');
        $this->addSql('ALTER TABLE profile_skill DROP FOREIGN KEY FK_A9E97BA5CCFA12B8');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649CCFA12B8');
        $this->addSql('ALTER TABLE roleplay_activity DROP FOREIGN KEY FK_A96EAAC477426B8F');
        $this->addSql('ALTER TABLE profile_skill DROP FOREIGN KEY FK_A9E97BA55585C142');
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A76A76ED395');
        $this->addSql('ALTER TABLE file DROP FOREIGN KEY FK_8C9F3610A76ED395');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649783E3463');
        $this->addSql('DROP TABLE activity');
        $this->addSql('DROP TABLE casting');
        $this->addSql('DROP TABLE casting_document');
        $this->addSql('DROP TABLE document');
        $this->addSql('DROP TABLE file');
        $this->addSql('DROP TABLE profile');
        $this->addSql('DROP TABLE profile_skill');
        $this->addSql('DROP TABLE roleplay');
        $this->addSql('DROP TABLE roleplay_activity');
        $this->addSql('DROP TABLE skill');
        $this->addSql('DROP TABLE `user`');
    }
}
