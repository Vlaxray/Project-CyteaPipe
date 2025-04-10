CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    type ENUM('cigar', 'tobacco', 'tea') NOT NULL,
    name VARCHAR(100) NOT NULL,
    brand VARCHAR(100),
    origin VARCHAR(100),
    strength INT(1), -- 1-5 per sigari/tabacchi
    flavor_profile VARCHAR(255), -- es. "legno, spezie, vaniglia, caffè"
    price DECIMAL(10, 2),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    rating INT(1) NOT NULL, -- 1-5 stelle
    comment TEXT,
    photo_path VARCHAR(255),
    tasted_at DATE,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);