CREATE TABLE roles (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    role VARCHAR(20) NOT NULL
);

CREATE TABLE users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(50) NOT NULL,
    role_id INT UNSIGNED NOT NULL,
    FOREIGN KEY (role_id) REFERENCES roles(id)
);

-- ------------------------------------------------

INSERT INTO roles (role) VALUES ("admin"), ("user");
INSERT INTO users (username, email, password, role_id) VALUES ("admin", "admin@admin.com", "1a1dc91c907325c69271ddf0c944bc72", 1); -- password: pass