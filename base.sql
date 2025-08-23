CREATE DATABASE  volumenDeHierro;

USE volumenDeHierro;

CREATE TABLE Clientes (
    id_cliente INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    fecha_nacimiento DATE,
    sexo ENUM('M', 'F', 'Otro'),
    telefono VARCHAR(15),
    email VARCHAR(100) UNIQUE,
    fecha_registro DATE DEFAULT (CURRENT_DATE), 
    estado BOOLEAN DEFAULT TRUE
);

CREATE TABLE Membresias (
    id_membresia INT PRIMARY KEY AUTO_INCREMENT,
    tipo VARCHAR(50) NOT NULL, 
    descripcion TEXT,
    precio DECIMAL(10, 2) NOT NULL,
    duracion_dias INT NOT NULL 
);

CREATE TABLE Clientes_Membresias (
    id_cliente_membresia INT PRIMARY KEY AUTO_INCREMENT,
    id_cliente INT,
    id_membresia INT,
    fecha_inicio DATE NOT NULL,
    fecha_fin DATE NOT NULL,
    estado ENUM('Activa', 'Vencida', 'Suspendida') DEFAULT 'Activa',

    FOREIGN KEY (id_cliente) REFERENCES Clientes(id_cliente) ON DELETE CASCADE,
    FOREIGN KEY (id_membresia) REFERENCES Membresias(id_membresia) ON DELETE SET NULL
);

CREATE TABLE Empleados (
    id_empleado INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    puesto VARCHAR(50),
    telefono VARCHAR(15),
    email VARCHAR(100) UNIQUE,
    fecha_contratacion DATE,
    salario DECIMAL(10, 2)
);

CREATE TABLE Entrenadores (
    id_entrenador INT PRIMARY KEY,
    especialidad VARCHAR(100),

    FOREIGN KEY (id_entrenador) REFERENCES Empleados(id_empleado) ON DELETE CASCADE
);

CREATE TABLE Clases (
    id_clase INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL, 
    descripcion TEXT,
    cupo_maximo INT,
    horario TIME,
    dias_semana VARCHAR(50) 
);

CREATE TABLE Clases_Entrenadores (
    id_clase_entrenador INT PRIMARY KEY AUTO_INCREMENT,
    id_clase INT,
    id_entrenador INT,

    FOREIGN KEY (id_clase) REFERENCES Clases(id_clase) ON DELETE CASCADE,
    FOREIGN KEY (id_entrenador) REFERENCES Entrenadores(id_entrenador) ON DELETE CASCADE
);

CREATE TABLE Inscripciones_Clases (
    id_inscripcion INT PRIMARY KEY AUTO_INCREMENT,
    id_cliente INT,
    id_clase INT,
    fecha_inscripcion DATE DEFAULT (CURRENT_DATE), 

    FOREIGN KEY (id_cliente) REFERENCES Clientes(id_cliente) ON DELETE CASCADE,
    FOREIGN KEY (id_clase) REFERENCES Clases(id_clase) ON DELETE CASCADE
);

CREATE TABLE Pagos (
    id_pago INT PRIMARY KEY AUTO_INCREMENT,
    id_cliente INT,
    fecha_pago DATE DEFAULT (CURRENT_DATE), 
    monto DECIMAL(10, 2) NOT NULL,
    metodo_pago ENUM('Efectivo', 'Tarjeta', 'Transferencia'),
    descripcion TEXT,

    FOREIGN KEY (id_cliente) REFERENCES Clientes(id_cliente) ON DELETE SET NULL
);