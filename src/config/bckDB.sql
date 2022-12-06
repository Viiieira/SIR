DROP DATABASE IF EXISTS sir_backend_db;
CREATE DATABASE sir_backend_db;
USE sir_backend_db;

-- ROLE
CREATE TABLE tblRole (
    id              int primary key auto_increment,
    name            varchar(50)
);

INSERT INTO tblRole (name)
VALUES
    ("Administrator"),
    ("Manager");

CREATE TABLE tblUser (
    id              int primary key auto_increment,
    username        varchar(100),
    email           varchar(100),
    pass            varchar(100),
    imgPath         varchar(255),
    dtCreated       datetime default current_timestamp,
    role            int default 2,
    foreign key (role) references tblRole(id)
);

-- Insert Admin
INSERT INTO tblUser (username, email, pass, imgPath, role)
VALUES
    ("Vieira", "hugov@ipvc.pt", "81dc9bdb52d04dc20036dbd8313ed055", "../images/me_3.jpg", 1);

INSERT INTO tblUser(username, email, pass, imgPath)
VALUES
    ("Manager", "manager@ipvc.pt", "81dc9bdb52d04dc20036dbd8313ed055", "../images/me.jpg");

CREATE TABLE tblSection (
    id              int primary key auto_increment,
    section         varchar(50),
    icon            varchar(50)
);

INSERT INTO tblSection (section, icon)
VALUES
    ("Dashboard", "fa-rectangle-list"),
    ("Users", "fa-user"),
    ("Messages", "fa-envelope"),
    ("Contacts", "fa-address-book"),
    ("Languages", "fa-language"),
    ("Skills", "fa-pen-ruler"),
    ("Education", "fa-school"),
    ("Certifications", "fa-certificate"),
    ("Projects", "fa-folder");

CREATE TABLE tblManagerSectionAccess (
    idManager          int,
    idSection       int,
    primary key (idManager, idSection),
    foreign key (idManager) references tblUser(id),
    foreign key (idSection) references tblSection(id)
);

INSERT INTO tblManagerSectionAccess
VALUES
    (2, 1),
    (2, 3);

CREATE TABLE tblHeader (
    id              int primary key auto_increment,
    title           varchar(70),
    description     varchar(100)
);

CREATE TABLE tblResume (
    id              int primary key auto_increment,
    paragraph       varchar(255)
);

CREATE TABLE tblSkillType (
    id              int primary key auto_increment,
    skillType       varchar(15)
);

INSERT INTO tblSkillType (skilLType)
VALUES
    ("Soft Skill"),
    ("Hard Skill");

CREATE TABLE tblSkill (
    id              int primary key auto_increment,
    skill           varchar(70),
    type            int,
    foreign key (type) references tblSkillType(id)
);

CREATE TABLE tblEducation (
    id              int primary key auto_increment,
    schoolFullName  varchar(150),
    schoolAcronym   varchar(20),
    dtStart         int(4),
    dtEnd           int(4),
    level           varchar(20)
);

CREATE TABLE tblEducationParagraph (
    id              int primary key auto_increment,
    idEducation     int,
    paragraph       varchar(255),
    foreign key (idEducation) references tblEducation(id)
);

CREATE TABLE tblImage (
    id              int primary key auto_increment,
    header          varchar(255),
    aboutMe         varchar(255)
);

CREATE TABLE tblContact (
    id              int primary key auto_increment,
    contact         varchar(50),
    icon            varchar(30)
);

CREATE TABLE tblMessageState (
    id              int primary key auto_increment,
    state           varchar(30)
);

INSERT INTO tblMessageState (state)
VALUES
    ("Not read"),
    ("Read"),
    ("Spam"),
    ("See later");

CREATE TABLE tblMessage (
    id              int primary key auto_increment,
    email           varchar(100),
    message         varchar(255),
    state           int default 1
    idUserReply     id,
    foreign key (idUserReply) references tblUser(id)
); 