CREATE TABLE language
(
    ID varchar(2),
    NAME varchar(128),
    PRIMARY KEY(ID)
);

CREATE TABLE movie_title
(
    MOVIE_ID int not null auto_increment,
    LANGUAGE_ID varchar(2),
    TITLE varchar(128),
    PRIMARY KEY (MOVIE_ID),
    FOREIGN KEY FK_MOVIE_LANGUAGE(LANGUAGE_ID)
    REFERENCES language(ID)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT
);

INSERT INTO language(ID, NAME)
VALUES ('ru', 'Русский'),
       ('en', 'Английский'),
       ('de', 'Немецкий'),
       ('fr', 'Французский'),
       ('it', 'Итальянский');

INSERT INTO movie_title(MOVIE_ID, LANGUAGE_ID, TITLE)
SELECT ID, 'ru', TITLE FROM movie;

ALTER TABLE movie DROP TITLE;