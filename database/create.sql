.bail ON
.mode columns
.headers on
.nullvalue NULL
PRAGMA foreign_keys = ON;

DROP TABLE IF EXISTS Event;
DROP TABLE IF EXISTS UserEvent;
DROP TABLE IF EXISTS User;
DROP TABLE IF EXISTS Comment;
DROP TABLE IF EXISTS Photo;

CREATE TABLE Event(
	idEvent INTEGER PRIMARY KEY,
	creationDate DATE NOT NULL,
	public BOOLEAN,
	type TEXT,
	description TEXT,
	idPhoto INTEGER REFERENCES Photo(idPhoto)
);

CREATE TABLE UserEvent(
	idEvent INTEGER REFERENCES Event(idEvent),
	idUser INTEGER REFERENCES User(idUser),
	confirm BOOLEAN DEFAULT 0,
	PRIMARY KEY (idEvent,idUser)
);

CREATE TABLE User(
	idUser INTEGER PRIMARY KEY,
	loginId TEXT NOT NULL,
	password TEXT NOT NULL,
	email TEXT NOT NULL,
	name TEXT,
	birthday DATE,
	idPhoto REFERENCES Photo(idPhoto)	
);

CREATE TABLE Comment (
	idComment INTEGER PRIMARY KEY,
	idPost INTEGER REFERENCES Post(idPost),
	idUser INTEGER REFERENCES User(idUser),
	commentText TEXT NOT NULL,
	creationDate DATE NOT NULL
);

CREATE TABLE Photo(
	idPhoto INTEGER PRIMARY KEY,
	path TEXT,
	size INTEGER,
	uploadDate DATE
);

CREATE TABLE EventPhoto(
	idEvent INTEGER REFERENCES Event(idEvent),
	idPhoto INTEGER REFERENCES Photo(idPhoto),
	PRIMARY KEY (idEvent,idPhoto)
);

CREATE TABLE Post(
	idPost INTEGER PRIMARY KEY,
	idEvent INTEGER REFERENCES Event(idEvent),
	idUser INTEGER REFERENCES User(idUser),
	info TEXT
);

INSERT INTO Photo VALUES(1,NULL,NULL,NULL);
INSERT INTO User VALUES (1,"diogomoura","ce47fa5f3a0a54a65fead7c798669e1ae1b73809d4a1f525eb948afe697b4c00a5c2361afb54cad0e4ffd9c51549eb6d73e4a3e4d594ec80a639365ad8b3e78a","diogomoura13@gmail.com","Diogo","1995-08-05",1);
