USE GlowWeb;

CREATE TABLE Users
(
    Usr              varchar(50) NOT NULL,
    EMAIL            varchar(50) NOT NULL,
    Password         varchar(50) NOT NULL,
    Admin            int NOT NULL,
    Rights           int NOT NULL,
    Salt             VARBINARY(16),
    primary key     (Usr)
);
