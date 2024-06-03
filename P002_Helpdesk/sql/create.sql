CREATE TABLE utente (
    id int PRIMARY KEY AUTO_INCREMENT,
    nome varchar(255) NOT NULL,
    cognome varchar(255) NOT NULL,
    email varchar(319) NOT NULL,
    ruolo enum('utente', 'tecnico', 'personaleATA', 'amministratore') DEFAULT 'utente',
    piano enum('terra', 'primo', 'secondo'), #piano di lavoro
    sospensione enum('true', 'false') DEFAULT 'false',
    ban enum('true', 'false') DEFAULT 'false',
    fine_sospensione date
);

CREATE TABLE stanza(
    id int PRIMARY KEY AUTO_INCREMENT,
    nome varchar(255) NOT NULL,
    numero int, 
    piano enum('terra', 'primo', 'secondo') NOT NULL,
    tipo enum('aula', 'laboratorio', 'bagno', 'spogliatoio', 'palestra', 'ufficio') NOT NULL
);
CREATE TABLE utente_in_stanza(
    id_utente int,
    id_stanza int,
    PRIMARY KEY (id_utente, id_stanza),
    FOREIGN KEY (id_utente) REFERENCES utente(id),
    FOREIGN KEY (id_stanza) REFERENCES stanza(id)
);

CREATE TABLE dispositivo(
    id int PRIMARY KEY AUTO_INCREMENT,
    nome varchar(255) NOT NULL,
    id_stanza int NOT NULL ,
    FOREIGN KEY (id_stanza) REFERENCES stanza(id) ON DELETE CASCADE
);

CREATE TABLE segnalazione(
    id int PRIMARY KEY AUTO_INCREMENT,
    id_utente int NOT NULL,
    id_stanza int NOT NULL,
    id_dispositivo int,
    data datetime default NOW(),
    tipo enum('pulizia', 'guasto_tecnico', 'guasto_aula') NOT NULL,
    stato enum('eseguita', 'in_attesa', 'fallita') DEFAULT 'in_attesa',
    descrizione TEXT NOT NULL,
    FOREIGN KEY (id_utente) REFERENCES utente(id) ON DELETE CASCADE,
    FOREIGN KEY (id_stanza) REFERENCES stanza(id) ON DELETE CASCADE,
    FOREIGN KEY (id_dispositivo) REFERENCES dispositivo(id) ON DELETE CASCADE #la chiave può essere null se la segnalazione non riguarda un dispositivo
);
CREATE TABLE notifica(
    id int PRIMARY KEY AUTO_INCREMENT,
    id_stanza int not null,
    id_dispositivo int,
    id_segnalazione int not null,
    FOREIGN KEY (id_stanza) REFERENCES stanza(id) ON DELETE CASCADE,
    FOREIGN KEY (id_dispositivo) REFERENCES dispositivo(id) ON DELETE CASCADE,
    FOREIGN KEY (id_segnalazione) REFERENCES segnalazione(id) ON DELETE CASCADE
);
CREATE TABLE utente_notifica(
    id_utente int not null,
    id_notifica int not null,
    PRIMARY KEY (id_utente, id_notifica),
    FOREIGN KEY (id_utente) REFERENCES utente(id) ON DELETE CASCADE,
    FOREIGN KEY (id_notifica) REFERENCES notifica(id) ON DELETE CASCADE
);
CREATE TABLE alert(
    id int PRIMARY KEY AUTO_INCREMENT,
    id_utente int not null,
    id_stanza int not null,
    id_dispositivo int,
    FOREIGN KEY (id_utente) REFERENCES utente(id) ON DELETE CASCADE,
    FOREIGN KEY (id_stanza) REFERENCES stanza(id) ON DELETE CASCADE,
    FOREIGN KEY (id_dispositivo) REFERENCES dispositivo(id) ON DELETE CASCADE
)
