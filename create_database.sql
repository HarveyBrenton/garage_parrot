CREATE DATABASE garage_parrot;
-- Table Admin
CREATE TABLE Admin (
  id INT PRIMARY KEY AUTO_INCREMENT,
  first_name VARCHAR(255),
  last_name VARCHAR(255),
  email VARCHAR(255),
  password VARCHAR(255)
);

-- Table Employés
CREATE TABLE Employees (
  id INT PRIMARY KEY AUTO_INCREMENT,
  first_name VARCHAR(255),
  last_name VARCHAR(255),
  email VARCHAR(255),
  password VARCHAR(255),
  admin_id INT,
  FOREIGN KEY (admin_id) REFERENCES Admin(id)
);

-- Table Vehicules
CREATE TABLE vehicles (
  id INT PRIMARY KEY AUTO_INCREMENT,
  title VARCHAR(255),
  price DECIMAL(10, 2),
  year INT,
  mileage INT,
  image VARCHAR(255)
  image1 VARCHAR(255)
  image2 VARCHAR(255)
);

-- Table Reviews
CREATE TABLE Reviews (
  id INT PRIMARY KEY AUTO_INCREMENT,
  rating INT,
  comment TEXT,
  reviewer_name VARCHAR(255),
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
  approved BOOLEAN DEFAULT 0
);

CREATE TABLE opening_hours (
  id INT(11) NOT NULL AUTO_INCREMENT,
  mon_hours VARCHAR(255) DEFAULT NULL,
  tue_hours VARCHAR(255) DEFAULT NULL,
  wed_hours VARCHAR(255) DEFAULT NULL,
  thu_hours VARCHAR(255) DEFAULT NULL,
  fri_hours VARCHAR(255) DEFAULT NULL,
  sat_hours VARCHAR(255) DEFAULT NULL,
  sun_hours VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE services (
  id INT PRIMARY KEY AUTO_INCREMENT,
  title VARCHAR(255) NOT NULL,
  image VARCHAR(255) NOT NULL,
  description TEXT NOT NULL
);

CREATE TABLE users (
  id INT PRIMARY KEY AUTO_INCREMENT,
  first_name VARCHAR(50) NOT NULL,
  last_name VARCHAR(50) NOT NULL,
  email VARCHAR(50) NOT NULL,
  phone VARCHAR(20) NOT NULL,
  message TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

