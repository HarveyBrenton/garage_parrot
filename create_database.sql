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
);

-- Table Reviews
CREATE TABLE Reviews (
  id INT PRIMARY KEY AUTO_INCREMENT,
  rating INT,
  comment TEXT,
  reviewer_name VARCHAR(255),
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
