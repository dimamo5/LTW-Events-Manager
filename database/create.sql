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
DROP TABLE IF EXISTS EventPhoto;
DROP TABLE IF EXISTS Post;

CREATE TABLE Event(
	idEvent INTEGER PRIMARY KEY,
	nameEvent TEXT NOT NULL,
	creationDate DATE NOT NULL,
	endDate DATE NOT NULL,
	local TEXT NOT NULL,
	public BOOLEAN,
	type TEXT,
	description TEXT,
	hour TEXT,
	idPhoto INTEGER REFERENCES Photo(idPhoto) DEFAULT 1,
	idOwner INTEGER REFERENCES User(idUser)
);

CREATE TABLE UserEvent(
	idEvent INTEGER REFERENCES Event(idEvent) ON DELETE CASCADE,
	idUser INTEGER REFERENCES User(idUser) ON DELETE CASCADE,
	confirm INT DEFAULT 0,
	PRIMARY KEY (idEvent,idUser),
	CHECK(confirm>=-1 AND confirm <=1)
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
	idPost INTEGER REFERENCES Post(idPost) ON DELETE CASCADE,
	idUser INTEGER REFERENCES User(idUser) ON DELETE CASCADE,
	commentText TEXT NOT NULL,
	creationDate DATE DEFAULT (date('now'))
);

CREATE TABLE Photo(
	idPhoto INTEGER PRIMARY KEY,
	path TEXT,
	uploadDate DATE
);

CREATE TABLE EventPhoto(
	idEvent INTEGER REFERENCES Event(idEvent) ON DELETE CASCADE,
	idPhoto INTEGER REFERENCES Photo(idPhoto) ON DELETE CASCADE,
	PRIMARY KEY (idEvent,idPhoto)
);

CREATE TABLE Post(
	idPost INTEGER PRIMARY KEY,
	idEvent INTEGER REFERENCES Event(idEvent) ON DELETE CASCADE,
	idUser INTEGER REFERENCES User(idUser) ON DELETE CASCADE,
	info TEXT
);

CREATE TRIGGER OwnerGoesevent AFTER INSERT ON Event FOR EACH ROW BEGIN
INSERT INTO UserEvent VALUES(NEW.idEvent,NEW.idOwner,1);
END;


INSERT INTO Photo VALUES(1,"static/user/userDefault.png","2015-11-01");
INSERT INTO User VALUES (1,"diogomoura","ce47fa5f3a0a54a65fead7c798669e1ae1b73809d4a1f525eb948afe697b4c00a5c2361afb54cad0e4ffd9c51549eb6d73e4a3e4d594ec80a639365ad8b3e78a","diogomoura13@gmail.com","Diogo","1995-08-05",1);
INSERT INTO User VALUES(2,"sergio","ce47fa5f3a0a54a65fead7c798669e1ae1b73809d4a1f525eb948afe697b4c00a5c2361afb54cad0e4ffd9c51549eb6d73e4a3e4d594ec80a639365ad8b3e78a","sergiomieic@gmail.com","Sergio","1995-05-05",1);

INSERT INTO Event VALUES(1,"PartyTime","2015-12-25","25-12-2015","Republica Nabense",1,"FESTA","Vai ser grande cena bois... Aparecam","10:00",1,1);
INSERT INTO Event VALUES(2,"PartyTime2","2015-12-25","25-12-2015","Republica Nabense",1,"FESTA","Vai ser grande cena bois... Aparecam","10:00",1,1);
INSERT INTO Event VALUES(3,"PartyTime3","2015-12-25","25-12-2015","Republica Nabense",1,"FESTA","Vai ser grande cena bois... Aparecam","10:00",1,1);
INSERT INTO Event VALUES(4,"PartyTime4","2015-12-25","25-12-2015","Republica Nabense",0,"FESTA","Vai ser grande cena bois... Aparecam","10:00",1,2);

INSERT INTO UserEvent VALUES(4,1,0);

INSERT INTO Post(idEvent,idUser,info) VALUES(1,1,"CENAS E TAL E ASSIM ASSIM");
INSERT INTO Post(idEvent,idUser,info)  VALUES(1,2,"CENAS E TAL E ASSIM ASSIM");

INSERT INTO Comment(idPost,idUser,commentText,creationDate) VALUES(1,2,"COISITAS","2015-12-25");
INSERT INTO Comment(idPost,idUser,commentText,creationDate) VALUES(1,1,"COISITAS","2015-11-29");
