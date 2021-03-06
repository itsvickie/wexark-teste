CREATE TABLE IF NOT EXISTS cliente (
    id INT AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    telefone CHAR(11) NOT NULL,
    data_nascimento DATE NOT NULL,
    rua_endereco VARCHAR(100) NOT NULL,
    numero_endereco INT NOT NULL,
    complemento_endereco VARCHAR(255) DEFAULT NULL,
    bairro_endereco VARCHAR(50) NOT NULL,
    cep_endereco CHAR(8) NOT NULL,
    deleted_at DATETIME DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP() ON UPDATE NOW(),
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tipo_pastel (
    id INT AUTO_INCREMENT,
    descricao VARCHAR(50) NOT NULL,
    PRIMARY KEY (id)
);

INSERT INTO tipo_pastel (descricao) VALUES ('Salgado'), ('Doce');

CREATE TABLE IF NOT EXISTS pastel (
    id INT AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    preco DECIMAL(7,2) NOT NULL,
    path_foto VARCHAR(255) NOT NULL,
    id_tipo INT NOT NULL,
    deleted_at DATETIME DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP() ON UPDATE NOW(),
    PRIMARY KEY (id),
    FOREIGN KEY (id_tipo) REFERENCES tipo_pastel(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS pedido (
    id INT AUTO_INCREMENT,
    id_cliente INT NOT NULL,
    deleted_at DATETIME DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP() ON UPDATE NOW(),
    PRIMARY KEY (id),
    FOREIGN KEY (id_cliente) REFERENCES cliente(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS pedido_pasteis (
    id INT AUTO_INCREMENT,
    id_pedido INT NOT NULL,
    id_pastel INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (id_pedido) REFERENCES pedido(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_pastel) REFERENCES pastel(id) ON DELETE CASCADE ON UPDATE CASCADE
);