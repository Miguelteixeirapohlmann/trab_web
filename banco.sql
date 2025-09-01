CREATE DATABASE IF NOT EXISTS pets_db;
USE pets_db;

-- Tabela de usuários
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL
);

-- Tabela de espécies
CREATE TABLE IF NOT EXISTS especies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    especie VARCHAR(50) NOT NULL UNIQUE
);

-- Tabela de pets
CREATE TABLE IF NOT EXISTS pets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    nascimento DATE NOT NULL,
    especie_id INT NOT NULL,
    prontuario TEXT,
    genero ENUM('macho', 'femea') NOT NULL,
    FOREIGN KEY (especie_id) REFERENCES especies(id)
);

INSERT INTO usuarios (usuario, senha) VALUES ('admin', SHA2('admin123', 256));
-- Novo usuário para o sistema
INSERT INTO usuarios (usuario, senha) VALUES ('user1', SHA2('senha123', 256));
