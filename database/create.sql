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
	location TEXT,
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