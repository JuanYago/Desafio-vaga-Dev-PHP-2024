CREATE DATABASE IF NOT EXISTS devs_do_rn;

USE devs_do_rn;

CREATE TABLE valores_anuidades (
    ano INT PRIMARY KEY,
    valor DECIMAL(10, 2) NOT NULL
);

INSERT INTO valores_anuidades (ano, valor) VALUES
(2021, 90.00),
(2022, 100.00),
(2023, 110.00),
(2024, 120.00),
(2025, 130.00);

CREATE TABLE associados (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    cpf VARCHAR(14) NOT NULL,
    data_filiacao DATE NOT NULL,
    pagamento_em_dia BOOLEAN NOT NULL DEFAULT 0
);

CREATE TABLE anuidades_associados (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_associado INT,
    ano INT,
    valor DECIMAL(10, 2),
    pago BOOLEAN NOT NULL DEFAULT 0,
    FOREIGN KEY (id_associado) REFERENCES associados(id),
    FOREIGN KEY (ano) REFERENCES valores_anuidades(ano)
);