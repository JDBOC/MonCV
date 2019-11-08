<?php

  declare(strict_types=1);

  namespace DoctrineMigrations;

  use Doctrine\DBAL\Schema\Schema;
  use Doctrine\Migrations\AbstractMigration;

  /**
   * Auto-generated Migration: Please modify to your needs!
   */
  final class Version20191015112432 extends AbstractMigration
  {
    public function getDescription(): string
    {
      return '';
    }

    public function up(Schema $schema): void
    {
      // this up() migration is auto-generated, please modify it to your needs
      $this->abortIf ( $this->connection->getDatabasePlatform ()->getName () !== 'mysql' , 'Migration can only be executed safely on \'mysql\'.' );

      $this->addSql ( 'CREATE TABLE competences (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, picture VARCHAR(255) DEFAULT NULL, INDEX IDX_DB2077CEA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB' );
      $this->addSql ( 'CREATE TABLE experiences (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, company VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, entree DATETIME NOT NULL, sortie DATETIME DEFAULT NULL, descriptif LONGTEXT DEFAULT NULL, lieu VARCHAR(255) DEFAULT NULL, INDEX IDX_82020E70A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB' );
      $this->addSql ( 'CREATE TABLE coordonates (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, adresse VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, linkdin VARCHAR(255) DEFAULT NULL, github VARCHAR(255) DEFAULT NULL, INDEX IDX_4E4F356BA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB' );
      $this->addSql ( 'CREATE TABLE formations (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, year VARCHAR(255) DEFAULT NULL, lieu VARCHAR(255) DEFAULT NULL, INDEX IDX_40902137A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB' );
      $this->addSql ( 'ALTER TABLE competences ADD CONSTRAINT FK_DB2077CEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)' );
      $this->addSql ( 'ALTER TABLE experiences ADD CONSTRAINT FK_82020E70A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)' );
      $this->addSql ( 'ALTER TABLE coordonates ADD CONSTRAINT FK_4E4F356BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)' );
      $this->addSql ( 'ALTER TABLE formations ADD CONSTRAINT FK_40902137A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)' );
    }

    public function down(Schema $schema): void
    {
      // this down() migration is auto-generated, please modify it to your needs
      $this->abortIf ( $this->connection->getDatabasePlatform ()->getName () !== 'mysql' , 'Migration can only be executed safely on \'mysql\'.' );

      $this->addSql ( 'DROP TABLE competences' );
      $this->addSql ( 'DROP TABLE experiences' );
      $this->addSql ( 'DROP TABLE coordonates' );
      $this->addSql ( 'DROP TABLE formations' );
    }
  }
