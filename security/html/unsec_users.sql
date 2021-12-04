create table users
(
    id         int auto_increment
        primary key,
    login      text                 not null,
    password   text                 not null,
    balance    int        default 0 null,
    bonus_used tinyint(1) default 0 null,
    photo      text                 null
)
    collate = utf8_bin;

INSERT INTO unsec.users (id, login, password, balance, bonus_used, photo) VALUES (1, 'admin', '1079321097:3124ad15e1929e7a8edec1648d0d1204', 0, 1, null);


