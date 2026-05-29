-- =============================================
-- ISI STAGE - Base de données XAMPP/MySQL
-- Importez ce fichier dans phpMyAdmin
-- =============================================

CREATE DATABASE IF NOT EXISTS isi_stage CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE isi_stage;

-- Table des admins
CREATE TABLE IF NOT EXISTS admins (
    id       INT AUTO_INCREMENT PRIMARY KEY,
    name     VARCHAR(100) NOT NULL,
    email    VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Insertion d'un admin par défaut (mot de passe: admin123)
INSERT INTO admins (name, email, password) VALUES
('Admin ISI', 'admin@isi.tn', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- Table des étudiants
CREATE TABLE IF NOT EXISTS students (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    nom          VARCHAR(100) NOT NULL,
    prenom       VARCHAR(100) NOT NULL,
    email        VARCHAR(150) NOT NULL UNIQUE,
    password     VARCHAR(255) NOT NULL,
    filiere      VARCHAR(100) DEFAULT NULL,
    competences  TEXT         DEFAULT NULL,
    langues      VARCHAR(255) DEFAULT NULL,
    certificats  VARCHAR(255) DEFAULT NULL,
    points       INT          DEFAULT 0,
    statut       ENUM('en_attente','valide','refuse') DEFAULT 'en_attente',
    created_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table des entreprises
CREATE TABLE IF NOT EXISTS companies (
    id             INT AUTO_INCREMENT PRIMARY KEY,
    nom_entreprise VARCHAR(150) NOT NULL,
    email          VARCHAR(150) NOT NULL UNIQUE,
    password       VARCHAR(255) NOT NULL,
    secteur        VARCHAR(100) DEFAULT NULL,
    ville          VARCHAR(100) DEFAULT NULL,
    description    TEXT         DEFAULT NULL,
    statut         ENUM('en_attente','valide','refuse') DEFAULT 'en_attente',
    created_at     TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table des offres de stage
CREATE TABLE IF NOT EXISTS internships (
    id               INT AUTO_INCREMENT PRIMARY KEY,
    company_id       INT NOT NULL,
    titre            VARCHAR(200) NOT NULL,
    duree            VARCHAR(50)  DEFAULT NULL,
    description      TEXT         DEFAULT NULL,
    localisation     VARCHAR(100) DEFAULT NULL,
    validation_admin TINYINT(1)   DEFAULT 0,
    created_at       TIMESTAMP    DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (company_id) REFERENCES companies(id) ON DELETE CASCADE
);

-- Table des candidatures
CREATE TABLE IF NOT EXISTS applications (
    id             INT AUTO_INCREMENT PRIMARY KEY,
    student_id     INT NOT NULL,
    internship_id  INT NOT NULL,
    motivation     TEXT DEFAULT NULL,
    statut         ENUM('en_attente','acceptee','refusee') DEFAULT 'en_attente',
    created_at     TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_application (student_id, internship_id),
    FOREIGN KEY (student_id)    REFERENCES students(id)    ON DELETE CASCADE,
    FOREIGN KEY (internship_id) REFERENCES internships(id) ON DELETE CASCADE
);

-- Table des réclamations
CREATE TABLE IF NOT EXISTS complaints (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    contenu    TEXT NOT NULL,
    statut     ENUM('ouverte','traitee') DEFAULT 'ouverte',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE
);

-- Table des récompenses
CREATE TABLE IF NOT EXISTS rewards (
    id                    INT AUTO_INCREMENT PRIMARY KEY,
    student_id            INT NOT NULL,
    points                INT          DEFAULT 0,
    badge                 VARCHAR(150) DEFAULT NULL,
    remuneration_symbolique VARCHAR(200) DEFAULT NULL,
    created_at            TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE
);
