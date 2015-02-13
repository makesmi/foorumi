-- Lisää INSERT INTO lauseet tähän tiedostoon
INSERT INTO Kayttaja(tunnus, salasana, rekist_aika) values ('Kepa', 'salainen', '2015-02-04 14:55:02');
INSERT INTO Kayttaja(tunnus, salasana, rekist_aika) values ('Pythagoras', 'supersalainen', '2015-02-10 09:25:34');
INSERT INTO Viestiketju(otsikko, alue) VALUES ('mikä on paras järjestämisalgoritmi?', 0);
INSERT INTO Viesti(sisalto, aika, ketju, kirjoittaja) VALUES ('Hei mikä on teidän mielestä paras järjestämisalgoritmi?', '2015-02-04', 0, 'Kepa');
INSERT INTO Luettu(kayttaja, viesti) VALUES ('Kepa', 0);

