CREATE DATABASE wexark_teste;

USE wexark_teste;

CREATE TABLE cliente (
    id INT AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    telefone CHAR(11) NOT NULL,
    data_nascimento DATE NOT NULL,
    senha CHAR(60) NOT NULL,
    rua_endereco VARCHAR(100) NOT NULL,
    numero_endereco INT NOT NULL,
    complemento_endereco VARCHAR(255) DEFAULT NULL,
    bairro_endereco VARCHAR(50) NOT NULL,
    cep_endereco CHAR(8) NOT NULL,
    status BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP() ON UPDATE NOW(),
    PRIMARY KEY (id)
);

CREATE TABLE tipo_pastel (
    id INT AUTO_INCREMENT,
    descricao VARCHAR(50) NOT NULL,
    PRIMARY KEY (id)
);

INSERT INTO tipo_pastel (descricao) VALUES ('Salgado'), ('Doce');

CREATE TABLE pastel (
    id INT AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    preco DECIMAL(7,2) NOT NULL,
    path_foto VARCHAR(255) NOT NULL,
    id_tipo INT NOT NULL,
    status BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP() ON UPDATE NOW(),
    PRIMARY KEY (id),
    FOREIGN KEY (id_tipo) REFERENCES tipo_pastel(id)
);

CREATE TABLE pedido (
    id INT AUTO_INCREMENT,
    id_cliente INT NOT NULL,
    id_pastel INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP() ON UPDATE NOW(),
    PRIMARY KEY (id),
    FOREIGN KEY (id_cliente) REFERENCES cliente(id),
    FOREIGN KEY (id_pastel) REFERENCES pastel(id)
);


------------------------ 01/06/2021
ALTER TABLE cliente DROP COLUMN status;
ALTER TABLE pastel DROP COLUMN status;

ALTER TABLE cliente ADD COLUMN deleted_at DATETIME DEFAULT NULL AFTER cep_endereco;
ALTER TABLE pastel ADD COLUMN deleted_at DATETIME DEFAULT NULL AFTER id_tipo;
ALTER TABLE pedido ADD COLUMN deleted_at DATETIME DEFAULT NULL AFTER id_pastel;