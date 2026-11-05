 INVENTARIS SEKOLAH
  Database: db_inventory
Sesuai panduan praktikum
 Password seluruh user: 123456
 Hash dibuat dengan password_hash('123456', PASSWORD_DEFAULT)

CREATE DATABASE IF NOT EXISTS db_inventory
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE db_inventory;
Hapus tabel anak terlebih dahulu agar foreign key aman
DROP TABLE IF EXISTS transactions;
DROP TABLE IF EXISTS items;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS users;

1. TABEL USERS

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100),
    role ENUM('admin','staff','manager') NOT NULL DEFAULT 'staff',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
2. TABEL CATEGORIES
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
3. TABEL ITEMS
CREATE TABLE items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(20) NOT NULL UNIQUE,
    name VARCHAR(150) NOT NULL,
    category_id INT NULL,
    quantity INT NOT NULL DEFAULT 0,
    unit VARCHAR(20) NOT NULL DEFAULT 'unit',
    price DECIMAL(15,2) NOT NULL DEFAULT 0,
    entry_date DATE NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_items_category
        FOREIGN KEY (category_id)
        REFERENCES categories(id)
        ON DELETE SET NULL
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

4. TABEL TRANSACTIONS
CREATE TABLE transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    item_id INT NOT NULL,
    user_id INT NOT NULL,
    type ENUM('IN','OUT') NOT NULL,
    quantity INT NOT NULL,
    notes VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_transactions_item
        FOREIGN KEY (item_id)
        REFERENCES items(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_transactions_user
        FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- DATA CONTOH: 3 USERS
-- Password ketiga akun: 123456

INSERT INTO users (username, password, full_name, role) VALUES
('admin', '$2y$10$pugZTeRtfHKALsNHarnYseYJF/Q0dK64aIB6mrQ6h0.EEouMools1', 'Administrator', 'admin'),
('staff', '$2y$10$pugZTeRtfHKALsNHarnYseYJF/Q0dK64aIB6mrQ6h0.EEouMools1', 'Petugas Inventaris', 'staff'),
('manager', '$2y$10$pugZTeRtfHKALsNHarnYseYJF/Q0dK64aIB6mrQ6h0.EEouMools1', 'Manajer Sekolah', 'manager');
-- DATA CONTOH: 4 CATEGORIES
