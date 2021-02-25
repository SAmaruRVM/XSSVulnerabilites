DROP DATABASE IF EXISTS xssTest;
CREATE DATABASE xssTest;
USE xssTest;
-- TABLES CREATION
CREATE TABLE users(
	user_id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL UNIQUE,
    user_username VARCHAR(50) NOT NULL UNIQUE CHECK(CHARACTER_LENGTH(user_username) >= 1),
    user_password VARCHAR(255) NOT NULL CHECK(CHARACTER_LENGTH(user_password) >= 6),
    user_image TEXT NULL DEFAULT 'userPlaceholder.png',
    user_authenticationToken TEXT NULL,
    user_createdDate DATETIME NULL DEFAULT (CURTIME()),
    user_lastLoggedIN DATETIME NULL
);
CREATE TABLE posts(
	post_id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL UNIQUE,
    post_content TEXT NOT NULL CHECK(CHARACTER_LENGTH(post_content) >= 1),
    post_numberOfLikes INT UNSIGNED NULL DEFAULT 0,
    post_createdDate DATETIME NULL DEFAULT (CURTIME()),
    post_userID INT REFERENCES users(user_id)
);
CREATE TABLE likes(
	like_id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL UNIQUE,
	like_userID INT NOT NULL REFERENCES users(user_id),
    like_postID INT NOT NULL REFERENCES posts(post_id)
);
CREATE TABLE comments(
	comment_id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL UNIQUE
);
-- STORED PROCEDURES CREATION
DELIMITER $$
DROP PROCEDURE IF EXISTS sp_getAllUsers$$
DROP PROCEDURE IF EXISTS sp_getUserByID$$
DROP PROCEDURE IF EXISTS sp_insertUser$$
DROP PROCEDURE IF EXISTS sp_getAllPosts$$
DROP PROCEDURE IF EXISTS sp_getPostByID$$
DROP PROCEDURE IF EXISTS sp_insertPost$$
CREATE PROCEDURE sp_getAllUsers()
BEGIN
	SELECT * 
    FROM users;
END$$
CREATE PROCEDURE sp_getUserByID(IN userID INT)
BEGIN
	SELECT * 
    FROM users
    WHERE user_id = userID;
END$$
CREATE PROCEDURE sp_insertUser(IN username TEXT, IN userPassword VARCHAR(255), IN userAuthenticationToken TEXT)
BEGIN
	INSERT INTO users 
    (user_username, 
    user_password,
    user_authenticationToken) 
    VALUES
    (username,
    userPassword,
    userAuthenticationToken);
END$$
CREATE PROCEDURE sp_getAllPosts()
BEGIN
	SELECT p.post_id AS id,
    p.post_content AS content,
    p.post_numberOfLikes AS likes,
    p.post_createdDate AS date,
    u.user_username AS username,
    u.user_image AS userImage,
    p.post_userID as userID
	FROM posts AS p
	INNER JOIN users AS u
	ON p.post_userID = u.user_id
    ORDER BY p.post_createdDate DESC;
END$$
CREATE PROCEDURE sp_getPostByID(IN postID INT)
BEGIN
	SELECT * 
    FROM posts
    WHERE post_id = postID;
END$$
CREATE PROCEDURE sp_insertPost(IN content TEXT, IN userID INT)
BEGIN
	INSERT INTO posts 
    (post_content, 
    post_userID)
    VALUES
    (content,
	userID);
END$$
DELIMITER ;

CALL sp_insertUser('Filipa Pinto', '$2y$10$oW4e1xV.00BimPLqULiLm.fy6E6HKvT8Em/473eGNmuaLfKuImZYK', NULL);
CALL sp_insertUser('André Pereira', '$2y$10$oW4e1xV.00BimPLqULiLm.fy6E6HKvT8Em/473eGNmuaLfKuImZYK', NULL);
CALL sp_insertUser('Inês Carolino', '$2y$10$oW4e1xV.00BimPLqULiLm.fy6E6HKvT8Em/473eGNmuaLfKuImZYK', NULL);
CALL sp_insertUser('Diogo Luís', '$2y$10$oW4e1xV.00BimPLqULiLm.fy6E6HKvT8Em/473eGNmuaLfKuImZYK', NULL);

CALL sp_insertPost('roin metus lectus, malesuada a posuere vel, 
sollicitudin nec lectus. Quisque accumsan lacinia neque, at sodales justo maximus sed. Aenean non tortor ut dolor malesuada mattis. 
Donec non odio facilisis, dignissim nisl at, dignissim ligula.
 Etiam ut dignissim leo, vel ullamcorper massa. 
 Suspendisse a mauris sed lacus porta blandit pretium vitae tellus.
 Nunc condimentum, ligula at fermentum facilisis, erat sem sagittis velit, non posuere purus ligula sit amet nulla.
 Suspendisse bibendum erat eu elit finibus, in volutpat urna volutpat. Vivamus aliquet ornare odio nec consectetur.
 Nam id ipsum eu orci tincidunt imperdiet. 
 Sed interdum condimentum euismod. 
 Nullam quis nisi consequat, laoreet augue a, egestas ipsum. Curabitur blandit mi at gravida aliquet.', 1);
 CALL sp_insertPost('Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
 Vestibulum luctus at felis eu commodo. Nam interdum ultrices nunc, eget tristique arcu elementum eu.
 Etiam vel neque nec nibh placerat lobortis. 
 Donec pretium a nisi sed tempus.
 Sed risus arcu, sodales eget eros sit amet, gravida lacinia massa.
 Nam vitae ligula fringilla, iaculis purus id, pharetra sapien. Suspendisse potenti.
 Proin erat arcu, tempor volutpat elit in, dignissim imperdiet dui.', 2);
  CALL sp_insertPost('Duis in interdum lorem, ac vestibulum erat. Fusce id metus quis orci pulvinar dictum ac eu ante. 
  Aenean porta sapien sit amet tellus laoreet commodo.
  Donec non lacus sem. 
  Nam et turpis eget eros molestie convallis eget rhoncus ligula.
  Integer consequat scelerisque tincidunt.
  Vestibulum non purus feugiat, tristique purus eget, elementum lacus. 
  Aliquam id quam et metus efficitur ultricies. 
  Nam lobortis tempus odio, vitae elementum sapien rhoncus viverra.
  Etiam a felis posuere, ornare libero ac, euismod odio. Vestibulum pharetra dignissim quam.
  Vivamus eu dolor non metus fermentum euismod quis a est. Aliquam ullamcorper arcu est, at luctus est cursus sed.
  Morbi volutpat, magna non vulputate ultrices, nulla erat facilisis velit, non accumsan turpis elit vel eros. In et mauris est.', 3);
  CALL sp_insertPost('Suspendisse eu nunc sed est ullamcorper vehicula in id quam.
  Proin tempus ex eu felis lacinia rutrum. In at nibh orci. 
  Mauris at imperdiet tortor.
  Quisque at sapien vehicula, sollicitudin sem convallis, eleifend tortor. 
  Nulla commodo malesuada tortor vitae interdum. 
  Cras consectetur sapien venenatis sem hendrerit consequat.
  Nullam id purus in risus elementum egestas.
  Proin ultricies tortor dolor, sit amet vulputate tortor tempor sed.', 4);
  
UPDATE posts SET post_numberOfLikes = 9 WHERE post_id = 1;
UPDATE posts SET post_numberOfLikes = 22 WHERE post_id = 2;
UPDATE posts SET post_numberOfLikes = 76 WHERE post_id = 3;
UPDATE posts SET post_numberOfLikes = 7 WHERE post_id = 4;
