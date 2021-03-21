CREATE TABLE tarefas{
	code INTEGER AUTOINCREMENT PRIMARY KEY,
	nome VARCHAR(50) NOT NULL,
	classe INTEGER NOT NULL,
	inicio datetime,
	fim datetime,
	FOREIGN KEY classe REFERENCES OTHER_TABLE(classes)
};
