<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251204234924 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE aeroport (id INT AUTO_INCREMENT NOT NULL, code_iata VARCHAR(10) NOT NULL, nom VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, pays VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE avion (id INT AUTO_INCREMENT NOT NULL, modele VARCHAR(255) NOT NULL, capacite INT NOT NULL, disponibilite TINYINT NOT NULL, categorie_id INT DEFAULT NULL, INDEX IDX_234D9D38BCF5E72D (categorie_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE categorie_avion (id INT AUTO_INCREMENT NOT NULL, nom_cat VARCHAR(255) NOT NULL, compagnie VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, telephone VARCHAR(20) DEFAULT NULL, date_inscription DATE NOT NULL, user_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_C7440455A76ED395 (user_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE paiement (id INT AUTO_INCREMENT NOT NULL, montant NUMERIC(10, 3) NOT NULL, method VARCHAR(255) NOT NULL, statut VARCHAR(255) NOT NULL, reservation_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_B1DC7A1EB83297E7 (reservation_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE passager (id INT AUTO_INCREMENT NOT NULL, num_passport VARCHAR(50) NOT NULL, nationalite VARCHAR(255) NOT NULL, date_naissance DATE NOT NULL, besoins_speciaux VARCHAR(255) DEFAULT NULL, poids_bagages NUMERIC(10, 2) NOT NULL, reservation_id INT NOT NULL, INDEX IDX_BFF42EE9B83297E7 (reservation_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, reference VARCHAR(100) NOT NULL, date_res DATETIME NOT NULL, satut VARCHAR(50) NOT NULL, client_id INT DEFAULT NULL, vol_id INT DEFAULT NULL, INDEX IDX_42C8495519EB6921 (client_id), INDEX IDX_42C849559F2BFB7A (vol_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE vol (id INT AUTO_INCREMENT NOT NULL, num_vol VARCHAR(255) NOT NULL, date_depart DATETIME NOT NULL, date_arrive DATETIME NOT NULL, port VARCHAR(255) NOT NULL, escale VARCHAR(255) DEFAULT NULL, places_disponibles INT NOT NULL, depart_id INT DEFAULT NULL, arrivee_id INT DEFAULT NULL, avion_id INT DEFAULT NULL, INDEX IDX_95C97EBAE02FE4B (depart_id), INDEX IDX_95C97EBEAF07E42 (arrivee_id), INDEX IDX_95C97EB80BBB841 (avion_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE avion ADD CONSTRAINT FK_234D9D38BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie_avion (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455A76ED395 FOREIGN KEY (user_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE paiement ADD CONSTRAINT FK_B1DC7A1EB83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id)');
        $this->addSql('ALTER TABLE passager ADD CONSTRAINT FK_BFF42EE9B83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495519EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849559F2BFB7A FOREIGN KEY (vol_id) REFERENCES vol (id)');
        $this->addSql('ALTER TABLE vol ADD CONSTRAINT FK_95C97EBAE02FE4B FOREIGN KEY (depart_id) REFERENCES aeroport (id)');
        $this->addSql('ALTER TABLE vol ADD CONSTRAINT FK_95C97EBEAF07E42 FOREIGN KEY (arrivee_id) REFERENCES aeroport (id)');
        $this->addSql('ALTER TABLE vol ADD CONSTRAINT FK_95C97EB80BBB841 FOREIGN KEY (avion_id) REFERENCES avion (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE avion DROP FOREIGN KEY FK_234D9D38BCF5E72D');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455A76ED395');
        $this->addSql('ALTER TABLE paiement DROP FOREIGN KEY FK_B1DC7A1EB83297E7');
        $this->addSql('ALTER TABLE passager DROP FOREIGN KEY FK_BFF42EE9B83297E7');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495519EB6921');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849559F2BFB7A');
        $this->addSql('ALTER TABLE vol DROP FOREIGN KEY FK_95C97EBAE02FE4B');
        $this->addSql('ALTER TABLE vol DROP FOREIGN KEY FK_95C97EBEAF07E42');
        $this->addSql('ALTER TABLE vol DROP FOREIGN KEY FK_95C97EB80BBB841');
        $this->addSql('DROP TABLE aeroport');
        $this->addSql('DROP TABLE avion');
        $this->addSql('DROP TABLE categorie_avion');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE paiement');
        $this->addSql('DROP TABLE passager');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE vol');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
