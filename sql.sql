CREATE DATABASE socialnetwork;

USE socialnetwork;

CREATE TABLE users (
    id INT NOT NULL AUTO_INCREMENT,
    email VARCHAR(50) NOT NULL,
    userpassword VARCHAR(60) NOT NULL,
    username VARCHAR(30) NOT NULL,
    PRIMARY KEY(id),
    UNIQUE(email)
);

CREATE TABLE profiles (
    id INT NOT NULL AUTO_INCREMENT,
    picture VARCHAR(100) NOT NULL DEFAULT 'default.jpg',
    about VARCHAR(150) NOT NULL DEFAULT '',
    birthday VARCHAR(4) NOT NULL DEFAULT '',
    born_in VARCHAR(30) NOT NULL DEFAULT '',
    profession VARCHAR(30) NOT NULL DEFAULT '',
    user_id INT NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY(user_id) REFERENCES users(id)
);

CREATE TABLE posts (
    id INT NOT NULL AUTO_INCREMENT,
    post_text VARCHAR(200) NOT NULL,
    post_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    comments_quantity BIGINT NOT NULL DEFAULT 0,
    likes_quantity BIGINT NOT NULL DEFAULT 0,
    user_id INT NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY(user_id) REFERENCES users(id)
);

CREATE TABLE comments (
    id INT NOT NULL AUTO_INCREMENT,
    comment_text VARCHAR(100) NOT NULL,
    post_id INT NOT NULL,
    user_id INT NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY(post_id) REFERENCES posts(id),
    FOREIGN KEY(user_id) REFERENCES users(id)
);

CREATE TABLE likes (
    id INT NOT NULL AUTO_INCREMENT,    
    user_id INT NOT NULL,
    post_id INT NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY(user_id) REFERENCES users(id),
    FOREIGN KEY(post_id) REFERENCES posts(id)
);

CREATE TABLE invitations (
    id INT NOT NULL AUTO_INCREMENT,
    sent_id INT NOT NULL,
    received_id INT NOT NULL,
    accepted ENUM('YES', 'NO') NOT NULL DEFAULT 'NO',
    PRIMARY KEY(id),
    FOREIGN KEY(sent_id) REFERENCES users(id),
    FOREIGN KEY(received_id) REFERENCES users(id)
);

CREATE TABLE friendships (
    id INT NOT NULL AUTO_INCREMENT,
    user_1 INT NOT NULL,
    user_2 INT NOT NULL,    
    PRIMARY KEY(id),
    FOREIGN KEY(user_1) REFERENCES users(id),
    FOREIGN KEY(user_2) REFERENCES users(id)
);

CREATE TABLE messages (
    id INT NOT NULL AUTO_INCREMENT,
    message_text VARCHAR(100) NOT NULL,
    from_id INT NOT NULL,
    to_id INT NOT NULL,
    message_date TIMESTAMP NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY(from_id) REFERENCES users(id),
    FOREIGN KEY(to_id) REFERENCES users(id)
);

CREATE TABLE games (
    id INT NOT NULL AUTO_INCREMENT,
    gamename VARCHAR(30) NOT NULL,
    PRIMARY KEY(id),
    UNIQUE(gamename)
);

CREATE TABLE records (
    id INT NOT NULL AUTO_INCREMENT,
    score INT NOT NULL,
    game_id INT NOT NULL,
    user_id INT NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY(game_id) REFERENCES games(id),
    FOREIGN KEY(user_id) REFERENCES users(id)
);