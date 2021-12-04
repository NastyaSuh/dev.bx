create table messages
(
    id   int auto_increment
        primary key,
    uid  int  null,
    text text null
)
    collate = utf8_bin;

INSERT INTO unsec.messages (id, uid, text) VALUES (1, 1, 'Привет, мир!');