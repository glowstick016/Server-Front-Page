USE GlowWeb;

CREATE TABLE Users
(
    Usr              varchar(50) NOT NULL,
    EMAIL            varchar(50) NOT NULL,
    Password         varchar(255) NOT NULL,
    Admin            int NOT NULL,
    Rights	     int NOT NULL,
    Phone	     varchar(20),
    Salt	     varchar(25),
    primary key     (Usr)
);

