CREATE DATABASE IF NOT EXISTS laravel_master;
USE laravel_master;

CREATE TABLE IF NOT EXISTS users(
    id              int(255) auto_increment not null,
    role            varchar(100),
    name            varchar(100),
    surname         varchar(200),
    nick            varchar(100),
    email           varchar(255),
    password        varchar(255),
    image           varchar(255),
    created_at      datetime,
    updated_at      datetime,
    remeber_token   varchar(255),
    CONSTRAINT   pk_users PRIMARY KEY(id)
)ENGINE=InnoDb;

INSERT INTO users VALUES(null, 'user', 'Cesar', 'despegue', 'elGigante', 'cesar@gmail.com', 'pass', null, CURTIME(), CURTIME(), null);
INSERT INTO users VALUES(null, 'user', 'Yaki', 'Chan', 'Jaky', 'jaky@gmail.com', 'pass2', null, CURTIME(), CURTIME(), null);
INSERT INTO users VALUES(null, 'user', 'Rue', 'Artast', 'Rayaut', 'ray@gmail.com', 'pass3', null, CURTIME(), CURTIME(), null);

CREATE TABLE IF NOT EXISTS images(
    id              int(255) auto_increment not null,
    user_id         int(255),
    image_path      varchar(255),      
    description     varchar(255),
    created_at      datetime,
    updated_at      datetime,
    CONSTRAINT pk_images PRIMARY KEY(id),
    CONSTRAINT fk_images_users FOREIGN KEY(user_id) REFERENCES users(id)
)ENGINE=InnoDb;

INSERT INTO images VALUES(null, 1, 'hola.jpg', 'description 1', CURTIME(), CURTIME()); 
INSERT INTO images VALUES(null, 2, 'foto.jpg', 'description 2', CURTIME(), CURTIME()); 
INSERT INTO images VALUES(null, 3, 'casa.jpg', 'description 3', CURTIME(), CURTIME()); 

CREATE TABLE IF NOT EXISTS coments(
    id              int(255) auto_increment not null,
    user_id         int(255),
    image_id       int(255),      
    content         text,
    created_at      datetime,
    updated_at      datetime,
    CONSTRAINT pk_coments PRIMARY KEY(id),
    CONSTRAINT fk_coments_users FOREIGN KEY(user_id) REFERENCES users(id),
    CONSTRAINT fk_coments_images FOREIGN KEY(image_id) REFERENCES images(id)
)ENGINE=InnoDb;

INSERT INTO coments VALUES(null, 3, '1', 'comentario 1', CURTIME(), CURTIME());
INSERT INTO coments VALUES(null, 1, '3', 'comentario 2', CURTIME(), CURTIME());
INSERT INTO coments VALUES(null, 2, '2', 'comentario 3', CURTIME(), CURTIME()); 
INSERT INTO coments VALUES(null, 3, '2', 'comentario 4', CURTIME(), CURTIME());


CREATE TABLE IF NOT EXISTS likes(
    id              int(255) auto_increment not null,
    user_id         int(255),
    image_id       int(255),      
    created_at      datetime,
    updated_at      datetime,
    CONSTRAINT pk_likes PRIMARY KEY(id),
    CONSTRAINT fk_likes_users FOREIGN KEY(user_id) REFERENCES users(id),
    CONSTRAINT fk_likes_images FOREIGN KEY(image_id) REFERENCES images(id)
)ENGINE=InnoDb;

INSERT INTO likes VALUES(null, 3, '1', CURTIME(), CURTIME());
INSERT INTO likes VALUES(null, 1, '3', CURTIME(), CURTIME());
INSERT INTO likes VALUES(null, 2, '2', CURTIME(), CURTIME());
