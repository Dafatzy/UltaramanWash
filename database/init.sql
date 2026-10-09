CREATE DATABASE IF NOT EXISTS carwash_db;
USE carwash_db;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','cashier','washer') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(30) NOT NULL,
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS vehicles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    plate_number VARCHAR(20) NOT NULL UNIQUE,
    vehicle_type ENUM('Mobil','Motor') NOT NULL,
    brand VARCHAR(60),
    color VARCHAR(40),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    vehicle_type ENUM('Mobil','Motor') NOT NULL,
    price DECIMAL(12,2) NOT NULL,
    duration INT NOT NULL DEFAULT 30,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    invoice_number VARCHAR(30) NOT NULL UNIQUE,
    customer_id INT NOT NULL,
    vehicle_id INT NOT NULL,
    total DECIMAL(12,2) NOT NULL DEFAULT 0,
    status ENUM('waiting','washing','finishing','completed','cancelled') NOT NULL DEFAULT 'waiting',
    payment_status ENUM('unpaid','paid') NOT NULL DEFAULT 'unpaid',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    completed_at DATETIME NULL,
    FOREIGN KEY (customer_id) REFERENCES customers(id),
    FOREIGN KEY (vehicle_id) REFERENCES vehicles(id)
);

CREATE TABLE IF NOT EXISTS transaction_details (
    id INT AUTO_INCREMENT PRIMARY KEY,
    transaction_id INT NOT NULL,
    service_id INT NOT NULL,
    price DECIMAL(12,2) NOT NULL,
    FOREIGN KEY (transaction_id) REFERENCES transactions(id) ON DELETE CASCADE,
    FOREIGN KEY (service_id) REFERENCES services(id)
);

INSERT IGNORE INTO users (id,name,username,password,role) VALUES
(1,'Administrator','admin','admin123','admin'),
(2,'Kasir Demo','kasir','kasir123','cashier'),
(3,'Washer Demo','washer','washer123','washer');

INSERT IGNORE INTO customers (id,name,phone,address) VALUES
(1,'Budi Santoso','081234567890','Medan'),
(2,'Andi Pratama','082345678901','Medan');

INSERT IGNORE INTO vehicles (id,customer_id,plate_number,vehicle_type,brand,color) VALUES
(1,1,'BK 1234 AA','Mobil','Toyota','Hitam'),
(2,2,'BK 5678 BB','Motor','Honda','Merah');

INSERT IGNORE INTO services (id,name,vehicle_type,price,duration,description) VALUES
(1,'Basic Wash','Mobil',25000,30,'Cuci eksterior dan pengeringan'),
(2,'Premium Wash','Mobil',40000,45,'Cuci lengkap dan finishing'),
(3,'Basic Wash','Motor',15000,20,'Cuci motor dan pengeringan'),
(4,'Premium Wash','Motor',25000,30,'Cuci lengkap dan finishing motor');
