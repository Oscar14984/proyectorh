CREATE TABLE Usuario (
        id_usuario int AUTO_INCREMENT NOT NULL,
        nombre varchar(255) NOT NULL,
        apellido varchar(255) NOT NULL,
        correo varchar(255) NOT NULL,
        numero varchar(255) NOT NULL,
        PRIMARY KEY (id_usuario)
    );

CREATE TABLE Direccion (
    id_direccion int AUTO_INCREMENT NOT NULL,
    id_usuario int NOT NULL,
    calle varchar(255) NOT NULL,
    CP varchar(4) NOT NULL,
    estado varchar(255) NOT NULL,
    pais varchar(255) NOT NULL,
    PRIMARY KEY (id_direccion),
    FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario)
);

CREATE TABLE Documentos (
    id_doc int AUTO_INCREMENT NOT NULL,
    id_usuario int NOT NULL,
    mime varchar(10) NOT NULL,
    file_name varchar(100) NOT NULL,
    content BLOB NOT NULL,
    PRIMARY KEY (id_doc),
    FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario)
);

CREATE TABLE Videos(
        id_video int AUTO_INCREMENT NOT NULL,
        id_usuario int NOT NULL,
        file_name varchar(100) NOT NULL,
        mime varchar(10) NOT NULL,
        content BLOB NOT NULL,
        PRIMARY KEY (id_video),
        FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario)
    );