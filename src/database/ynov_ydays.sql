create table items
(
    id          char(36)     not null
        primary key,
    title       varchar(255) not null,
    description longtext     not null,
    picture     varchar(255) not null,
    category    char(36)     not null,
    created_at  varchar(255) not null,
    updated_at  varchar(255) not null,
    price       varchar(255) not null
);

create table items_cat
(
    id         char(36)     not null
        primary key,
    title      varchar(255) not null,
    created_at varchar(255) not null,
    updated_at varchar(255) not null
);

create table users
(
    id         char(36)                      not null
        primary key,
    first_name varchar(255)                  not null,
    last_name  varchar(255)                  not null,
    email      varchar(255)                  not null,
    password   varchar(255)                  not null,
    zip_code   varchar(255)                  not null,
    city       varchar(255)                  not null,
    country    varchar(255)                  not null,
    address    varchar(255)                  not null,
    roles      varchar(255) default 'membre' not null,
    created_at varchar(255)                  not null,
    updated_at varchar(255)                  not null
);

