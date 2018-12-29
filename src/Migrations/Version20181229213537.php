<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181229213537 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE categorie (idcategorie INT AUTO_INCREMENT NOT NULL, nomCategorie VARCHAR(45) DEFAULT NULL, descriptionCategorie TEXT DEFAULT NULL, PRIMARY KEY(idcategorie)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE conversation (idconversation INT AUTO_INCREMENT NOT NULL, contenu TEXT DEFAULT NULL, date TEXT DEFAULT NULL, idEnvoyeur INT DEFAULT NULL, idObjetConcerne INT DEFAULT NULL, INDEX idObjetConcerne_idx (idObjetConcerne), INDEX idEnvoyeur_idx (idEnvoyeur), PRIMARY KEY(idconversation)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE demande (idDemande INT AUTO_INCREMENT NOT NULL, nomDemande INT DEFAULT NULL, dateDemande DATE DEFAULT NULL, DemandeSatisfaite TINYINT(1) DEFAULT NULL, idCategorie INT DEFAULT NULL, idTypeTransaction INT DEFAULT NULL, idUser INT DEFAULT NULL, INDEX FK_demande_typetransaction (idTypeTransaction), INDEX FK_demande_user (idUser), INDEX FK_demande_categorie (idCategorie), PRIMARY KEY(idDemande)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (idMessage INT AUTO_INCREMENT NOT NULL, contenu TEXT DEFAULT NULL, Conversation_idConversation INT DEFAULT NULL, User_idUser INT DEFAULT NULL, INDEX fk_Conversation_has_User_User1_idx (User_idUser), INDEX fk_Conversation_has_User_Conversation1_idx (Conversation_idConversation), PRIMARY KEY(idMessage)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE objet (idobjet INT AUTO_INCREMENT NOT NULL, nomObjet VARCHAR(45) DEFAULT NULL, descriptionObjet TEXT DEFAULT NULL, Disponible TINYINT(1) DEFAULT NULL, idCategorie INT DEFAULT NULL, idTransaction INT DEFAULT NULL, idProprietaire INT DEFAULT NULL, INDEX idTransaction_idx (idTransaction), INDEX idUser_idx (idProprietaire), INDEX idCategorie_idx (idCategorie), PRIMARY KEY(idobjet)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photo (idPhoto INT AUTO_INCREMENT NOT NULL, cheminPhoto TEXT DEFAULT NULL, imagePrincipale TINYINT(1) DEFAULT NULL, Objet_idObjet INT DEFAULT NULL, INDEX fk_Photo_Objet1_idx (Objet_idObjet), PRIMARY KEY(idPhoto)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profil (idprofil INT AUTO_INCREMENT NOT NULL, nomprofil VARCHAR(45) DEFAULT NULL, PRIMARY KEY(idprofil)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transaction (idtransaction INT AUTO_INCREMENT NOT NULL, transactionRealisée TINYINT(1) DEFAULT NULL, idObjet INT DEFAULT NULL, idTypeTranasaction INT DEFAULT NULL, idUserDemandeur INT DEFAULT NULL, idUserOffrant INT DEFAULT NULL, INDEX idTypeTransaction_idx (idTypeTranasaction), INDEX idUserDemandeur_idx (idUserDemandeur), INDEX idUserOffrant_idx (idUserOffrant), INDEX idObjet_idx (idObjet), PRIMARY KEY(idtransaction)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE typetransaction (idtypetransaction INT AUTO_INCREMENT NOT NULL, nomTransaction VARCHAR(45) DEFAULT NULL, dateDebutTransaction DATE DEFAULT NULL, dateFinTransaction DATE DEFAULT NULL, PRIMARY KEY(idtypetransaction)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (iduser INT AUTO_INCREMENT NOT NULL, nomUser VARCHAR(45) NOT NULL, prenomPersonne VARCHAR(45) NOT NULL, emailUser VARCHAR(45) NOT NULL, passwordUser LONGTEXT NOT NULL, pseudo VARCHAR(45) DEFAULT NULL, avatar VARCHAR(45) DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', idProfil INT DEFAULT NULL, INDEX idProfil_idx (idProfil), PRIMARY KEY(iduser)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE conversation ADD CONSTRAINT FK_8A8E26E9772196B FOREIGN KEY (idEnvoyeur) REFERENCES user (iduser)');
        $this->addSql('ALTER TABLE conversation ADD CONSTRAINT FK_8A8E26E9AB2B8645 FOREIGN KEY (idObjetConcerne) REFERENCES objet (idobjet)');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A5B597FD62 FOREIGN KEY (idCategorie) REFERENCES categorie (idcategorie)');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A5E339724C FOREIGN KEY (idTypeTransaction) REFERENCES typetransaction (idtypetransaction)');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A5FE6E88D7 FOREIGN KEY (idUser) REFERENCES user (iduser)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F2B91B642 FOREIGN KEY (Conversation_idConversation) REFERENCES conversation (idconversation)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F1DA01C3D FOREIGN KEY (User_idUser) REFERENCES user (iduser)');
        $this->addSql('ALTER TABLE objet ADD CONSTRAINT FK_46CD4C38B597FD62 FOREIGN KEY (idCategorie) REFERENCES categorie (idcategorie)');
        $this->addSql('ALTER TABLE objet ADD CONSTRAINT FK_46CD4C38326AFAA9 FOREIGN KEY (idTransaction) REFERENCES transaction (idtransaction)');
        $this->addSql('ALTER TABLE objet ADD CONSTRAINT FK_46CD4C38377D3D27 FOREIGN KEY (idProprietaire) REFERENCES user (iduser)');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B78418397952EB FOREIGN KEY (Objet_idObjet) REFERENCES objet (idobjet)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D151090F25 FOREIGN KEY (idObjet) REFERENCES objet (idobjet)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1E9B30482 FOREIGN KEY (idTypeTranasaction) REFERENCES typetransaction (idtypetransaction)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1E005D9FE FOREIGN KEY (idUserDemandeur) REFERENCES user (iduser)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D11FF98D8E FOREIGN KEY (idUserOffrant) REFERENCES user (iduser)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64985C71A0D FOREIGN KEY (idProfil) REFERENCES profil (idprofil)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A5B597FD62');
        $this->addSql('ALTER TABLE objet DROP FOREIGN KEY FK_46CD4C38B597FD62');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F2B91B642');
        $this->addSql('ALTER TABLE conversation DROP FOREIGN KEY FK_8A8E26E9AB2B8645');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B78418397952EB');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D151090F25');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64985C71A0D');
        $this->addSql('ALTER TABLE objet DROP FOREIGN KEY FK_46CD4C38326AFAA9');
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A5E339724C');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1E9B30482');
        $this->addSql('ALTER TABLE conversation DROP FOREIGN KEY FK_8A8E26E9772196B');
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A5FE6E88D7');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F1DA01C3D');
        $this->addSql('ALTER TABLE objet DROP FOREIGN KEY FK_46CD4C38377D3D27');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1E005D9FE');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D11FF98D8E');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE conversation');
        $this->addSql('DROP TABLE demande');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE objet');
        $this->addSql('DROP TABLE photo');
        $this->addSql('DROP TABLE profil');
        $this->addSql('DROP TABLE transaction');
        $this->addSql('DROP TABLE typetransaction');
        $this->addSql('DROP TABLE user');
    }
}
