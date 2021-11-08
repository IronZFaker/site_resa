CREATE TABLE place (
	idPlace INTEGER PRIMARY KEY,
	idConcert INTEGER,
    numSiege INTEGER
);

CREATE TABLE siege (
	numSiege INTEGER PRIMARY KEY,
	idZone INTEGER,
    FOREIGN KEY (numSiege) REFERENCES place(numSiege),
    FOREIGN KEY (idZone) REFERENCES zone(idZone)
);

CREATE TABLE panier (
	idClient INTEGER PRIMARY KEY,
    timeExp TIMESTAMP,
	idPlace INTEGER,
    FOREIGN KEY (idPlace) REFERENCES place(idPlace)
);

CREATE TABLE tarif (
	idZone INTEGER PRIMARY KEY,
	tarif INTEGER
);