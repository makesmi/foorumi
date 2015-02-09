-- Lisää CREATE TABLE lauseet tähän tiedostoon

CREATE TABLE Kayttaja(
	tunnus varchar(32) PRIMARY KEY,
	salasana varchar(32) NOT NULL,
	yllapitaja boolean DEFAULT FALSE,
	rekist_aika timestamp NOT NULL
);


CREATE TABLE Aihealue(
	id SERIAL PRIMARY KEY,
	nimi varchar(64) NOT NULL,
	selitys varchar(256) NOT NULL
);

CREATE TABLE Viestiketju(
	id SERIAL PRIMARY KEY,
	otsikko varchar(128) NOT NULL,
	alue integer REFERENCES Aihealue(id)
);


CREATE TABLE Viesti(
	id SERIAL PRIMARY KEY,
	sisalto varchar(5000) NOT NULL,
	aika timestamp NOT NULL,
	muokkausaika timestamp DEFAULT NULL,
	ketju integer REFERENCES Viestiketju(id),
	kirjoittaja varchar(32) REFERENCES Kayttaja(tunnus)
);


CREATE TABLE Luettu(
	kayttaja varchar(32) NOT NULL REFERENCES Kayttaja(tunnus),
	viesti INTEGER NOT NULL REFERENCES Viesti(id),
        PRIMARY KEY(kayttaja, viesti)
);
