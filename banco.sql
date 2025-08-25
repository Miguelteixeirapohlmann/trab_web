-- Criação do banco de dados
CREATE DATABASE IF NOT EXISTS pets_trab;
USE pets_trab;

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

-- Usuário padrão para login de teste
INSERT INTO usuarios (usuario, senha) VALUES ('admin', SHA2('admin123', 256));
