DROP DATABASE IF EXISTS SIR;
CREATE DATABASE SIR character set UTF8 collate utf8_bin;
USE SIR;

-- ROLE
CREATE TABLE tblRole (
    id              int primary key auto_increment,
    name            varchar(50)
) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;

INSERT INTO tblRole (name)
VALUES
    ("Administrator"),
    ("Manager");

CREATE TABLE tblUserState (
    id              int primary key auto_increment,
    state           varchar(50)
) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;

INSERT INTO tblUserState(state)
VALUES
    ("Inactive"),
    ("Active");

CREATE TABLE tblUser (
    id              int primary key auto_increment,
    username        varchar(100),
    email           varchar(100),
    pass            varchar(100),
    imgPath         varchar(255),
    dtCreated       datetime default current_timestamp,
    role            int default 2, -- Default Role is Manager
    state           int default 2, -- Default State is Active
    FOREIGN KEY (role) REFERENCES tblRole(id),
    FOREIGN KEY (state) REFERENCES tblUserState(id)
) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;

-- Insert Admin
INSERT INTO tblUser (username, email, pass, imgPath, role)
VALUES
    ("Vieira", "hugov@ipvc.pt", "81dc9bdb52d04dc20036dbd8313ed055", "me_3.jpg", 1),
    ("Marcelo", "marcelo@ipvc.pt", "81dc9bdb52d04dc20036dbd8313ed055", "98460923.jpg", 2),
    ("Jose", "jose@ipvc.pt", "81dc9bdb52d04dc20036dbd8313ed055", NULL, 2);

CREATE TABLE tblSection (
    id              int primary key auto_increment,
    section         varchar(50),
    icon            varchar(50)
) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;

INSERT INTO tblSection (section, icon)
VALUES
    ("Statistics", "fa-chart-simple"),
    ("Intro", "fa-house-user"),
    ("Users", "fa-user"),
    ("About", "fa-circle-info"),
    ("Messages", "fa-envelope"),
    ("Contacts", "fa-address-book"),
    ("Languages", "fa-language"),
    ("Skills", "fa-pen-ruler"),
    ("Education", "fa-school");

CREATE TABLE tblManagerSectionAccess (
    idManager          int,
    idSection       int,
    primary key (idManager, idSection),
    foreign key (idManager) references tblUser(id),
    foreign key (idSection) references tblSection(id)
) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;

INSERT INTO tblManagerSectionAccess (idManager, idSection)
VALUES
    (2, 4),
    (3, 4);

CREATE TABLE tblHeader (
    title           varchar(70),
    description     varchar(100)
) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;

INSERT INTO tblHeader
VALUES
    ("Hugo Vieira", "Student, Computer Engineering, IPVC-ESTG");

CREATE TABLE tblResume (
    id              int primary key auto_increment,
    paragraph       varchar(255)
) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;

INSERT INTO tblResume (paragraph)
VALUES
    ("My name is Hugo Abel Rodrigues Félix Vieira Vieira. I'm 19 and I'm a student at Computer Engineering at IPVC-ESTG, currently on my 3rd year. I consider myself a proactive hard-working person."),
    ("Passionate about everything in this IT world, I'm focused to present my best solutions to upcoming problems, restless, dissatisfied with passivity, always trying something new."),
    ("I love teamwork projects, cooperating with other coworkers to discuss our opinions, about the best decision to be made in the moment.");

CREATE TABLE tblSkillType (
    id              int primary key auto_increment,
    skillType       varchar(15)
) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;

INSERT INTO tblSkillType (skilLType)
VALUES
    ("Soft Skill"),
    ("Hard Skill");

CREATE TABLE tblSkill (
    id              int primary key auto_increment,
    skill           varchar(70),
    type            int,
    foreign key (type) references tblSkillType(id)
) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;

INSERT INTO tblSkill (skill, type)
VALUES
    ("Hard-working", 1),
    ("Organized", 1),
    ("Creative", 1),
    ("Self-learner", 1),
    ("Proactive", 1),
    ("HTML", 2),
    ("CSS", 2),
    ("JavaScript", 2),
    ("PHP", 2),
    ("SQL", 2),
    ("C", 2),
    ("Java", 2);

CREATE TABLE tblEducation (
    id              int primary key auto_increment,
    schoolFullName  varchar(150),
    schoolAcronym   varchar(20),
    dtStart         int(4),
    dtEnd           int(4),
    level           varchar(20)
) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;

INSERT INTO tblEducation (schoolFullName, schoolAcronym, dtStart, dtEnd, level)
VALUES
    ("Instituto Politécnico de Viana do Castelo - Escola Superior de Gestão e Tecnologia", "IPVC-ESTG", 2020, 2023, "University"),
    ("Escola Secundária de Santa Maria Maior", "ESSMM", 2017, 2020, "High School");

CREATE TABLE tblEducationParagraph (
    id              int primary key auto_increment,
    idEducation     int,
    paragraph       varchar(255),
    foreign key (idEducation) references tblEducation(id)
) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;

INSERT INTO tblEducationParagraph (idEducation, paragraph)
VALUES
    (1, "I entered in Computer Engineering at Instituto Politécnico de Viana do Castelo - Escola Superior de Tecnologia e Gestão in 2020/2021. Studying here at this polytechnic evolved me into a more responsible and hard-worker person."),
    (1, "I expect to finish this degree by 2023."),
    (2, "I entered in IT Systems Management and Programming Technician at Escola Secundária de Santa Maria Maior in 2017/2018. Entering this specialized professional course was my decision into the IT world."),
    (2, "I successfully finished it at 2020, with 18 values out of 20 at my Professional Aptitude Project (PAP) and 20 values rated on my Internship.");

CREATE TABLE tblImage (
    header          varchar(255),
    aboutMe         varchar(255)
) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;

INSERT INTO tblImage
VALUES
    ("me.jpg", "me_3.jpg");

CREATE TABLE tblContactType (
    id              int primary key auto_increment,
    name            varchar(50),
    icon            varchar(50), -- FontAwesome Icon
    typeLink        int -- 1 - Link, 2 - Phone, 3 - E-mail
) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;

INSERT INTO tblContactType (name, icon, typeLink)
VALUES
    ("Facebook", "fa-brands fa-facebook", 1),
    ("Instagram", "fa-brands fa-instagram", 1),
    ("TikTok", "fa-brands fa-tiktok", 1),
    ("Youtube", "fa-brands fa-youtube", 1),
    ("Twitter", "fa-brands fa-twitter", 1),
    ("Pinterest", "fa-brands fa-pinterest", 1),
    ("Snapchat", "fa-brands fa-snapchat", 1),
    ("Github", "fa-brands fa-github", 1),
    ("LinkedIn", "fa-brands fa-linkedin", 1),
    ("Discord", "fa-brands fa-discord", 1),
    ("Phone", "fa-solid fa-phone", 2),
    ("E-mail", "fa-solid fa-envelope", 3);

CREATE TABLE tblContact (
    id              int primary key auto_increment,
    type            int,
    contact         varchar(50),
    displayContact  varchar(50),
    FOREIGN KEY (type) REFERENCES tblContactType(id)
) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;

INSERT INTO tblContact (type, contact, displayContact)
VALUES
    (11, "+351938854803", "+351 938 854 803"),
    (12, "hugov@ipvc.pt", "hugov@ipvc.pt"),
    (9, "https://www.linkedin.com/in/hugovieira0512/", "hugovieira0512"),
    (8, "https://github.com/Viiieira", "Viiieira");

CREATE TABLE tblMessageState (
    id              int primary key auto_increment,
    state           varchar(30)
) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;

INSERT INTO tblMessageState (state)
VALUES
    ("New"),
    ("Replied"),
    ("Spam");

CREATE TABLE tblMessage (
    id              int primary key auto_increment,
    name            varchar(150),
    email           varchar(100),
    message         varchar(255),
    state           int default 1, -- 1 New, 2 Replied, 3 Spam
    idUserReply     int,
    ip              varchar(100),
    dtInserted      datetime default current_timestamp,
    foreign key (idUserReply) references tblUser(id)
) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;

CREATE TABLE tblBlock (
    id              int primary key auto_increment,
    ip              varchar(100)
) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;

CREATE TABLE tblLanguageLevel (
    id              int primary key auto_increment,
    level           varchar(50)
) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;

INSERT INTO tblLanguageLevel (level)
VALUES
    ("Native Language"),
    ("Fluent"),
    ("Conversational"),
    ("Basic"),
    ("Learning");

CREATE TABLE tblLanguage (
    id              int primary key auto_increment,
    name            varchar(50),
    level           int,
    FOREIGN KEY (level) REFERENCES tblLanguageLevel(id)
) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;

INSERT INTO tblLanguage (name, level)
VALUES
    ("Portuguese", 1),
    ("English", 2);