CREATE DATABASE vistasoft;

use vistasoft;

CREATE TABLE pessoas(
pessoa_id INT NOT NULL UNIQUE AUTO_INCREMENT PRIMARY KEY,
nome VARCHAR(255) NOT NULL,
email VARCHAR(255) NOT NULL,
telefone VARCHAR(255) NOT NULL
);

CREATE TABLE clientes(
cliente_id INT NOT NULL UNIQUE AUTO_INCREMENT PRIMARY KEY,
pessoa_id INT NOT NULL,
FOREIGN KEY (pessoa_id) REFERENCES pessoas (pessoa_id)
);

CREATE TABLE proprietarios(
proprietario_id INT NOT NULL UNIQUE AUTO_INCREMENT PRIMARY KEY,
pessoa_id INT NOT NULL,
dia_repasse INT,
FOREIGN KEY (pessoa_id) REFERENCES pessoas (pessoa_id)
);

CREATE TABLE enderecos(
endereco_id INT NOT NULL UNIQUE AUTO_INCREMENT PRIMARY KEY,
cep VARCHAR(255) NOT NULL,
logradouro VARCHAR(255),
numero INT,
complemento VARCHAR(255),
bairro VARCHAR(255),
cidade VARCHAR(255),
uf CHAR(2)
);

CREATE TABLE imoveis(
imovel_id INT NOT NULL UNIQUE AUTO_INCREMENT PRIMARY KEY,
endereco_id INT NOT NULL,
proprietario_id INT NOT NULL,
FOREIGN KEY (endereco_id) REFERENCES enderecos (endereco_id)
FOREIGN KEY (proprietario_id) REFERENCES proprietarios (proprietario_id)
);

CREATE TABLE contratos(
contrato_id INT NOT NULL UNIQUE AUTO_INCREMENT PRIMARY KEY,
imovel_id INT NOT NULL,
proprietario_id INT NOT NULL,
cliente_id INT NOT NULL,
data_inicio DATE,
data_fim DATE,
taxa_admin INT,
valor_aluguel DECIMAL(10,2),
valor_condominio DECIMAL(10,2),
valor_iptu DECIMAL(10,2),
FOREIGN KEY (imovel_id) REFERENCES imoveis (imovel_id),
FOREIGN KEY (proprietario_id) REFERENCES proprietarios (proprietario_id),
FOREIGN KEY (cliente_id) REFERENCES clientes (cliente_id)
);

CREATE TABLE mensalidades(
id INT NOT NULL UNIQUE AUTO_INCREMENT PRIMARY KEY,
contrato_id INT NOT NULL,
valor DECIMAL(10,2),
FOREIGN KEY (contrato_id) REFERENCES contratos (contrato_id)
);

CREATE TABLE repasses(
id INT NOT NULL UNIQUE AUTO_INCREMENT PRIMARY KEY,
contrato_id INT NOT NULL,
valor DECIMAL(10,2),
FOREIGN KEY (contrato_id) REFERENCES contratos (contrato_id)
);