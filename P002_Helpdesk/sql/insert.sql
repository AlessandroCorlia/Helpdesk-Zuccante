DELETE FROM stanza WHERE TRUE;
ALTER TABLE stanza AUTO_INCREMENT = 1;
INSERT INTO stanza (nome, numero, piano, tipo)
VALUES
    ('3IA',7,'terra', 'aula'),
    ('4IA',8, 'terra', 'aula'),
    ('5IA',9 , 'terra', 'aula'),
    ('3IB',10 , 'terra', 'aula'),
    ('4IB',11 , 'terra', 'aula'),
    ('5IB',12 , 'terra', 'aula'),
    ('AULA RELAX',13 , 'terra', 'aula'),
    ('3ID',14 , 'terra', 'aula'),
    ('3IE',15 , 'terra', 'aula'),
    ('LAS',null , 'terra', 'laboratorio'),
    ('LOCALE A.T. LAS',null , 'terra', 'laboratorio'),
    ('LLM', null, 'terra', 'laboratorio'),
    ('LAP2', null, 'terra', 'laboratorio'),
    ('LAM',null , 'terra', 'laboratorio'),
    ('WC', null, 'terra', ''),
    ('WC',null , 'terra', ''),
    ('LASA', null, 'terra', 'laboratorio'),
    ('AULA MAGNA', null, 'terra', 'aula'),
    ('OEN1',41 , 'terra', 'laboratorio'),
    ('PALESTRA', null, 'terra', 'palestra'),
    ('SPOGLIATOIO U', null, 'terra', 'spogliatoio'),
    ('SPOGLIATOIO F',null , 'terra', 'spogliatoio'),
    ('4EA-TA',21 , 'primo', 'aula'),
    ('4TA', 22, 'primo', 'aula'),
    ('5EA-TA',23 , 'primo', 'aula'),
    ('5TA',24 , 'primo', 'aula'),
    ('3EA',25 , 'primo', 'aula'),
    ('4AB',26 , 'primo', 'aula'),
    ('5AB',27 , 'primo', 'aula'),
    ('4IC',28 , 'primo', 'aula'),
    ('3IC',29 , 'primo', 'aula'),
    ('5IC',30 , 'primo', 'aula'),
    ('3AA',31 , 'primo', 'aula'),
    ('4AA',32 , 'primo', 'aula'),
    ('5AA',33 , 'primo', 'aula'),
    ('AULA MUSICA',null , 'primo', 'aula'),
    ('WC',null , 'primo', 'bagno'),
    ('WC',null , 'primo', 'bagno'),
    ('SALA LETTURA',null , 'primo', 'aula'),
    ('DEPOSITO LIBRI',null , 'primo', 'aula'),
    ('AULA INSEGNANTI',null , 'primo', 'aula'),
    ('LAP1',null , 'primo', 'laboratorio'),
    ('LOCALE A.T. LAP1',null , 'primo', 'laboratorio'),
    ('SALA SERVER',null , 'primo', 'ufficio'),
    ('OEN2', null, 'primo', 'laboratorio'),
    ('AULA EMERGENZE',null , 'primo', 'aula'),
    ('WC', null, 'primo', 'bagno'),
    ('WC', null, 'primo', 'bagno'),
    ('BAR',null , 'primo', 'aula'),
    ('UFFICIO TECNICO',43 , 'secondo', 'ufficio'),
    ('PCTO',44 , 'secondo', 'ufficio'),
    ('UFFICIO PERSONALE',45 , 'secondo', 'ufficio'),
    ('SEGRETERIA DIDATTICA', 46, 'secondo', 'ufficio'),
    ('PRESIDENZA', 47, 'secondo', 'ufficio'),
    ('VICE PRESIDENZA',48 , 'secondo', 'ufficio'),
    ('MAGAZZINO', 50, 'secondo', 'aula'),
    ('UFFICIO DSGA',null , 'secondo', 'ufficio'),
    ('LOCALE',null , 'secondo', 'ufficio'),
    ('LEN4', 51, 'secondo', 'laboratorio'),
    ('LOCALE A.T.', 52, 'secondo', 'laboratorio'),
    ('LEN5',53 , 'secondo', 'laboratorio'),
('PROVA', 54, 'secondo', 'laboratorio');


DELETE FROM dispositivo;
ALTER TABLE dispositivo AUTO_INCREMENT = 1;
INSERT INTO dispositivo(nome, id_stanza)
VALUES
    ('LAP1-WS01', 42),
    ('LAP1-WS02', 42),
    ('LAP1-WS03', 42),
    ('LAP1-WS04', 42),
    ('LAP1-WS05', 42),
    ('LAP1-WS06', 42),
    ('LAP1-WS07', 42),
    ('LAP1-WS08', 42),
    ('LAP1-WS09', 42),
    ('LAP1-WS10', 42),
    ('LAP1-WS11', 42),
    ('LAP1-WS12', 42),
    ('LAP1-WS13', 42),
    ('LAP1-WS14', 42),
    ('LAP1-WS15', 42),
    ('LAP1-WS16', 42),
    ('LAP1-WS17', 42),
    ('LAP1-WS18', 42),
    ('LAP1-WS19', 42),
    ('LAP1-WS20', 42),
    ('LAP1-WS21', 42),
    ('LAP1-WS22', 42),
    ('LAP1-WS23', 42),
    ('LAP1-WS24', 42),
    ('LAP1-WS25', 42),
    ('LAP1-WS26', 42),
    ('LAP1-WS27', 42),
    ('LAP1-WS28', 42),
    ('LAP1-WS29', 42),
    ('LAP1-WS30', 42),
    ('LAP1-WS31', 42),
    ('LAP2-WS01', 13),
    ('LAP2-WS02', 13),
    ('LAP2-WS03', 13),
    ('LAP2-WS04', 13),
    ('LAP2-WS05', 13),
    ('LAP2-WS06', 13),
    ('LAP2-WS07', 13),
    ('LAP2-WS08', 13),
    ('LAP2-WS09', 13),
    ('LAP2-WS10', 13),
    ('LAP2-WS11', 13),
    ('LAP2-WS12', 13),
    ('LAP2-WS13', 13),
    ('LAP2-WS14', 13),
    ('LAP2-WS15', 13),
    ('LAP2-WS16', 13),
    ('LAP2-WS17', 13),
    ('LAP2-WS18', 13),
    ('LAP2-WS19', 13),
    ('LAP2-WS20', 13),
    ('LAP2-WS21', 13),
    ('LAP2-WS22', 13),
    ('LAP2-WS23', 13),
    ('LAP2-WS24', 13),
    ('LAP2-WS25', 13),
    ('LAP2-WS26', 13),
    ('LAP2-WS27', 13),
    ('LAP2-WS28', 13),
    ('LAP2-WS29', 13),
    ('LAP2-WS30', 13),
    ('LLM-WS01', 12),
    ('LLM-WS02', 12),
    ('LLM-WS03', 12),
    ('LLM-WS04', 12),
    ('LLM-WS05', 12),
    ('LLM-WS06', 12),
    ('LLM-WS07', 12),
    ('LLM-WS08', 12),
    ('LLM-WS09', 12),
    ('LLM-WS10', 12),
    ('LLM-WS11', 12),
    ('LLM-WS12', 12),
    ('LLM-WS13', 12),
    ('LLM-WS14', 12),
    ('LLM-WS15', 12),
    ('LLM-WS16', 12),
    ('LLM-WS17', 12),
    ('LLM-WS18', 12),
    ('LLM-WS19', 12),
    ('LLM-WS20', 12),
    ('LLM-WS21', 12),
    ('LLM-WS22', 12),
    ('LLM-WS23', 12),
    ('LLM-WS24', 12),
    ('LLM-WS25', 12),
    ('LLM-WS26', 12),
    ('LLM-WS27', 12),
    ('LLM-WS28', 12),
    ('CAT01', 12),
    ('WS01', 1),
    ('WS01', 2),
    ('WS01', 3),
    ('WS01', 4),
    ('WS01', 5),
    ('WS01', 6),
    ('WS01', 7),
    ('WS01', 8),
    ('WS01', 9),
    ('WS01', 23),
    ('WS01', 24),
    ('WS01', 25),
    ('WS01', 26),
    ('WS01', 27),
    ('WS01', 28),
    ('WS01', 29),
    ('WS01', 30),
    ('WS01', 31),
    ('WS01', 32),
    ('WS01', 33),
    ('WS01', 34),
    ('WS01', 35);







DELETE FROM UTENTE WHERE id= 6;
SELECT MAX(id) FROM utente;
ALTER TABLE utente AUTO_INCREMENT = 5;

INSERT INTO utente(nome, cognome, email, ruolo, piano, sospensione, ban, fine_sospensione)
VALUES
    ('Fiorenzo', 'D Onofrio', 'fiorenzo.donofrio@itiszuccante.edu.it', 'tecnico', 'primo', 'false', 'false', null),
    ('Alessandro', 'Corliano', 'alessandro.corliano@itiszuccante.edu.it', 'utente', null, 'false', 'false', null),
    ('Massimo', 'Ballin', 'massimo.ballin@itiszuccante.edu.it', 'tecnico', 'terra', 'false', 'false', null),
    ('Gianluca', 'Masetti', 'gianluca.masetti@itiszuccante.edu.it', 'tecnico', 'secondo', 'false', 'false', null),
    ('Matteo', 'Baldan', 'matteo.baldan@itiszuccante.edu.it','tecnico','terra','false','false',null);

DELETE FROM segnalazione WHERE TRUE;
ALTER TABLE segnalazione AUTO_INCREMENT = 1;
DELETE FROM alert WHERE id_dispositivo = 93;



