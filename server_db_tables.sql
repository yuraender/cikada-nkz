
-- Таблицы MySQL на сервере

CREATE TABLE User
(
    id          INT UNSIGNED NOT NULL AUTO_INCREMENT,
    lname       VARCHAR(50) NOT NULL,
    fname       VARCHAR(50) NOT NULL,
    patronym    VARCHAR(50) NOT NULL,
    sex         INT UNSIGNED NOT NULL,
    status      INT UNSIGNED NOT NULL,
    psw_hash    BINARY(60) NOT NULL,
    created_at  TIMESTAMP DEFAULT NOW(),
    PRIMARY KEY ( id )
) CHARACTER SET utf8;

CREATE TABLE Task (
  id int(10) unsigned NOT NULL AUTO_INCREMENT,
  title varchar(50) NOT NULL,
  PRIMARY KEY (id)
) CHARACTER SET utf8;


CREATE TABLE OnSite
(
    u_id    INT UNSIGNED NOT NULL,
    token   INT UNSIGNED NOT NULL,
    FOREIGN KEY (u_id) REFERENCES User(id)
) CHARACTER SET utf8;


CREATE TABLE Journal
(
    id          INT UNSIGNED NOT NULL AUTO_INCREMENT,
    prt_id      INT UNSIGNED NOT NULL,
    mgr_id      INT UNSIGNED NOT NULL,
    tsk_id      INT UNSIGNED NOT NULL,
    score       INT UNSIGNED NOT NULL,

    FOREIGN KEY (prt_id) REFERENCES User(id),
    FOREIGN KEY (mgr_id) REFERENCES User(id),
    FOREIGN KEY (tsk_id) REFERENCES Task(id),
    PRIMARY KEY ( id )
) CHARACTER SET utf8;

CREATE TABLE School
(
    id          INT UNSIGNED NOT NULL AUTO_INCREMENT,
    town        VARCHAR(50),
    name        VARCHAR(50),

    PRIMARY KEY ( id )
) CHARACTER SET utf8;

CREATE TABLE PersonalData
(
    u_id        INT UNSIGNED NOT NULL,
    bday        DATE,
    school_id   INT UNSIGNED,
    grade       VARCHAR(20),
    oblast      VARCHAR(50),
    locality    VARCHAR(50),
    street      VARCHAR(50),
    home        VARCHAR(20),
    apartment   VARCHAR(20),
    email       VARCHAR(50),
    phone       VARCHAR(20),
    phoneParent VARCHAR(20),
    nameParent  VARCHAR(100),
    teacherIKT      VARCHAR(100),
    classTeacher    VARCHAR(100),
    PRIMARY KEY ( u_id ),
    FOREIGN KEY (u_id) REFERENCES User(id),
    FOREIGN KEY (school_id) REFERENCES School(id)
) CHARACTER SET utf8;

ALTER TABLE PersonalData
ADD programming_languages VARCHAR(100);

ALTER TABLE PersonalData
ADD var_part INT UNSIGNED;

CREATE TABLE Scan
(
    id          INT UNSIGNED NOT NULL AUTO_INCREMENT,
    u_id        INT UNSIGNED NOT NULL,
    application VARCHAR(100),
    agreement   VARCHAR(100),
    send_date   TIMESTAMP DEFAULT NOW(),
    status      INT UNSIGNED,
    comment     VARCHAR(100),
    PRIMARY KEY ( id ),
    FOREIGN KEY (u_id) REFERENCES User(id)
) CHARACTER SET utf8;


CREATE TABLE AllowCheck
(
    id          INT UNSIGNED NOT NULL AUTO_INCREMENT,
    teacher_id	INT UNSIGNED NOT NULL,
    task_id		INT UNSIGNED NOT NULL,
    PRIMARY KEY ( id ),
    FOREIGN KEY (teacher_id) REFERENCES User(id),
    FOREIGN KEY (task_id) REFERENCES Task(id)
) CHARACTER SET utf8;

CREATE TABLE Result
(
    id          INT UNSIGNED NOT NULL AUTO_INCREMENT,
    u_id        INT UNSIGNED NOT NULL,
    teacher_id	INT UNSIGNED NOT NULL,
    task_id		INT UNSIGNED NOT NULL,
    check_time  TIMESTAMP DEFAULT NOW(),
    score		INT UNSIGNED,
    PRIMARY KEY ( id ),
    FOREIGN KEY (u_id) REFERENCES User(id),
    FOREIGN KEY (teacher_id) REFERENCES User(id),
    FOREIGN KEY (task_id) REFERENCES Task(id)
) CHARACTER SET utf8;