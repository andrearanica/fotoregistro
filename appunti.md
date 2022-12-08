# DATABASE
## Introduzione
* DB Relazionale: diviso in unità logiche (tabelle) collegate
* I comandi possono essere scritti sia in maiuscolo che minuscolo 
* I commenti si fanno con i caratteri -- /* */

* Creare DB: CREATE DATABASE name
* Cancellare DB: DROP DATABASE name
* Creare tabella: ` CREATE TABLE name(name type costraint) `
    * I tipi sono INT, DECIMAL, CHAR, VARCHAR, TEXT, DATE, DATETIME, TIMESTAMP
* Cancellare tabella: ` DROP TABLE name `
* Per creare la tabella posso fare ` CREATE TABLE IF NOT EXISTS `

## CONSTRAINT
* Valori aggiuntivi per un valore
    * ` not null ` | Il valore non deve essere vuoto
    * ` PRIMARY KEY(KEY) ` | Chiave primaria
    * ` UNIQUE ` | Campo univoco (non chiave)
    * ` DEFAULT 'value'` | Campo di default
    * ` CHECK (conditions) ` | Controlla che i dati rispettino dei valori
    * ` FOREIGN KEY(KEY) REFERENCES table ` | 

## INSERT E SELECT
* Per inserire un valore: ` INSERT INTO table(fields) VALUES (fields) `
* Per prelevare un record: ` SELECT colon0, colon1 FROM table `
    * Posso specificare condizione: ` WHERE condition `