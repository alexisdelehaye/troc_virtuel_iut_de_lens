<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181227175905 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE absences DROP FOREIGN KEY absences_etudiant_idetudiant_foreign');
        $this->addSql('ALTER TABLE decision_semestres DROP FOREIGN KEY decision_semestres_etudiant_idetudiant_foreign');
        $this->addSql('ALTER TABLE decision_u_es DROP FOREIGN KEY decision_u_es_etudiant_idetudiant_foreign');
        $this->addSql('ALTER TABLE diplomes DROP FOREIGN KEY diplomes_etudiant_idetudiant_foreign');
        $this->addSql('ALTER TABLE notes DROP FOREIGN KEY notes_etudiant_idetudiant_foreign');
        $this->addSql('ALTER TABLE photos DROP FOREIGN KEY photos_etudiant_idetudiant_foreign');
        $this->addSql('ALTER TABLE etudiants DROP FOREIGN KEY etudiants_formation_idformation_foreign');
        $this->addSql('ALTER TABLE notes DROP FOREIGN KEY notes_matiere_idmatiere_foreign');
        $this->addSql('ALTER TABLE decision_semestres DROP FOREIGN KEY decision_semestres_semestre_idsemestre_foreign');
        $this->addSql('ALTER TABLE etudiants DROP FOREIGN KEY etudiants_semestre_idsemestre_foreign');
        $this->addSql('ALTER TABLE u_es DROP FOREIGN KEY u_es_semestre_idsemestre_foreign');
        $this->addSql('ALTER TABLE absences DROP FOREIGN KEY absences_ue_idue_foreign');
        $this->addSql('ALTER TABLE decision_u_es DROP FOREIGN KEY decision_u_es_ue_idue_foreign');
        $this->addSql('ALTER TABLE matieres DROP FOREIGN KEY matieres_ue_idue_foreign');
        $this->addSql('DROP TABLE absences');
        $this->addSql('DROP TABLE decision_semestres');
        $this->addSql('DROP TABLE decision_u_es');
        $this->addSql('DROP TABLE diplomes');
        $this->addSql('DROP TABLE etudiants');
        $this->addSql('DROP TABLE formations');
        $this->addSql('DROP TABLE matieres');
        $this->addSql('DROP TABLE migrations');
        $this->addSql('DROP TABLE notes');
        $this->addSql('DROP TABLE password_resets');
        $this->addSql('DROP TABLE photos');
        $this->addSql('DROP TABLE semestres');
        $this->addSql('DROP TABLE type_transaction');
        $this->addSql('DROP TABLE u_es');
        $this->addSql('DROP TABLE users');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE absences (idAbscence INT UNSIGNED AUTO_INCREMENT NOT NULL, heures INT NOT NULL, Etudiant_idEtudiant INT UNSIGNED NOT NULL, UE_idUE INT UNSIGNED NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX absences_ue_idue_foreign (UE_idUE), INDEX absences_etudiant_idetudiant_foreign (Etudiant_idEtudiant), PRIMARY KEY(idAbscence)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE decision_semestres (idDecisionSemestre INT UNSIGNED AUTO_INCREMENT NOT NULL, decision VARCHAR(45) NOT NULL COLLATE utf8mb4_unicode_ci, Etudiant_idEtudiant INT UNSIGNED NOT NULL, Semestre_idSemestre INT UNSIGNED NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX decision_semestres_semestre_idsemestre_foreign (Semestre_idSemestre), INDEX decision_semestres_etudiant_idetudiant_foreign (Etudiant_idEtudiant), PRIMARY KEY(idDecisionSemestre)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE decision_u_es (idDecisionUE INT UNSIGNED AUTO_INCREMENT NOT NULL, decision VARCHAR(45) NOT NULL COLLATE utf8mb4_unicode_ci, Etudiant_idEtudiant INT UNSIGNED NOT NULL, UE_idUE INT UNSIGNED NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX decision_u_es_ue_idue_foreign (UE_idUE), INDEX decision_u_es_etudiant_idetudiant_foreign (Etudiant_idEtudiant), PRIMARY KEY(idDecisionUE)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE diplomes (idDiplome INT UNSIGNED AUTO_INCREMENT NOT NULL, nom VARCHAR(45) NOT NULL COLLATE utf8mb4_unicode_ci, debut DATE NOT NULL, fin DATE NOT NULL, Etudiant_idEtudiant INT UNSIGNED NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX diplomes_etudiant_idetudiant_foreign (Etudiant_idEtudiant), PRIMARY KEY(idDiplome)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE etudiants (idEtudiant INT UNSIGNED AUTO_INCREMENT NOT NULL, nom VARCHAR(45) NOT NULL COLLATE utf8mb4_unicode_ci, prenom VARCHAR(45) NOT NULL COLLATE utf8mb4_unicode_ci, numEtu VARCHAR(45) NOT NULL COLLATE utf8mb4_unicode_ci, groupe VARCHAR(5) NOT NULL COLLATE utf8mb4_unicode_ci, Formation_idFormation INT UNSIGNED NOT NULL, Semestre_idSemestre INT UNSIGNED NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX etudiants_semestre_idsemestre_foreign (Semestre_idSemestre), INDEX etudiants_formation_idformation_foreign (Formation_idFormation), PRIMARY KEY(idEtudiant)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE formations (idFormation INT UNSIGNED AUTO_INCREMENT NOT NULL, nom VARCHAR(45) NOT NULL COLLATE utf8mb4_unicode_ci, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(idFormation)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE matieres (idMatiere INT UNSIGNED AUTO_INCREMENT NOT NULL, nom VARCHAR(150) NOT NULL COLLATE utf8mb4_unicode_ci, ref TEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci, abreviation CHAR(10) NOT NULL COLLATE utf8mb4_unicode_ci, coefficient NUMERIC(8, 2) NOT NULL, UE_idUE INT UNSIGNED NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX matieres_ue_idue_foreign (UE_idUE), PRIMARY KEY(idMatiere)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE migrations (id INT UNSIGNED AUTO_INCREMENT NOT NULL, migration VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, batch INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE notes (idNote INT UNSIGNED AUTO_INCREMENT NOT NULL, note NUMERIC(4, 2) NOT NULL, Etudiant_idEtudiant INT UNSIGNED NOT NULL, Matiere_idMatiere INT UNSIGNED NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX notes_matiere_idmatiere_foreign (Matiere_idMatiere), INDEX notes_etudiant_idetudiant_foreign (Etudiant_idEtudiant), PRIMARY KEY(idNote)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE password_resets (email VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, token VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, created_at DATETIME DEFAULT NULL, INDEX password_resets_email_index (email)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE photos (idPhoto INT UNSIGNED AUTO_INCREMENT NOT NULL, chemin VARCHAR(45) NOT NULL COLLATE utf8mb4_unicode_ci, image VARCHAR(255) NOT NULL, Etudiant_idEtudiant INT UNSIGNED NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX photos_etudiant_idetudiant_foreign (Etudiant_idEtudiant), PRIMARY KEY(idPhoto)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE semestres (idSemestre INT UNSIGNED AUTO_INCREMENT NOT NULL, nom VARCHAR(45) NOT NULL COLLATE utf8mb4_unicode_ci, debut DATE NOT NULL, fin DATE NOT NULL, Formation_idFormation INT UNSIGNED NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(idSemestre)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE type_transaction (id INT AUTO_INCREMENT NOT NULL, nom_transaction VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, date_debut_transaction DATE NOT NULL, date_fin_transaction DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE u_es (idUE INT UNSIGNED AUTO_INCREMENT NOT NULL, nomUE VARCHAR(45) NOT NULL COLLATE utf8mb4_unicode_ci, debut DATE NOT NULL, fin DATE NOT NULL, Semestre_idSemestre INT UNSIGNED NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX u_es_semestre_idsemestre_foreign (Semestre_idSemestre), PRIMARY KEY(idUE)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE users (id INT UNSIGNED AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, email VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, email_verified_at DATETIME DEFAULT NULL, password VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, remember_token VARCHAR(100) DEFAULT NULL COLLATE utf8mb4_unicode_ci, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX users_email_unique (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE absences ADD CONSTRAINT absences_etudiant_idetudiant_foreign FOREIGN KEY (Etudiant_idEtudiant) REFERENCES etudiants (idetudiant) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE absences ADD CONSTRAINT absences_ue_idue_foreign FOREIGN KEY (UE_idUE) REFERENCES u_es (idue) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE decision_semestres ADD CONSTRAINT decision_semestres_etudiant_idetudiant_foreign FOREIGN KEY (Etudiant_idEtudiant) REFERENCES etudiants (idetudiant) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE decision_semestres ADD CONSTRAINT decision_semestres_semestre_idsemestre_foreign FOREIGN KEY (Semestre_idSemestre) REFERENCES semestres (idsemestre) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE decision_u_es ADD CONSTRAINT decision_u_es_etudiant_idetudiant_foreign FOREIGN KEY (Etudiant_idEtudiant) REFERENCES etudiants (idetudiant) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE decision_u_es ADD CONSTRAINT decision_u_es_ue_idue_foreign FOREIGN KEY (UE_idUE) REFERENCES u_es (idue) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE diplomes ADD CONSTRAINT diplomes_etudiant_idetudiant_foreign FOREIGN KEY (Etudiant_idEtudiant) REFERENCES etudiants (idetudiant) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE etudiants ADD CONSTRAINT etudiants_formation_idformation_foreign FOREIGN KEY (Formation_idFormation) REFERENCES formations (idformation) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE etudiants ADD CONSTRAINT etudiants_semestre_idsemestre_foreign FOREIGN KEY (Semestre_idSemestre) REFERENCES semestres (idsemestre) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE matieres ADD CONSTRAINT matieres_ue_idue_foreign FOREIGN KEY (UE_idUE) REFERENCES u_es (idue) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE notes ADD CONSTRAINT notes_etudiant_idetudiant_foreign FOREIGN KEY (Etudiant_idEtudiant) REFERENCES etudiants (idetudiant) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE notes ADD CONSTRAINT notes_matiere_idmatiere_foreign FOREIGN KEY (Matiere_idMatiere) REFERENCES matieres (idmatiere) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE photos ADD CONSTRAINT photos_etudiant_idetudiant_foreign FOREIGN KEY (Etudiant_idEtudiant) REFERENCES etudiants (idetudiant) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE u_es ADD CONSTRAINT u_es_semestre_idsemestre_foreign FOREIGN KEY (Semestre_idSemestre) REFERENCES semestres (idsemestre) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
