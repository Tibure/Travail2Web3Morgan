#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------

CREATE DATABASE  IF NOT EXISTS 'db_cours18' /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;
USE 'db_cours18';

DROP TABLE IF EXISTS 'tbl_Game';

CREATE TABLE tbl_Game(
        GameID    Int  Auto_increment  NOT NULL ,
        StartTime Time NOT NULL
	,CONSTRAINT tbl_Game_PK PRIMARY KEY (GameID)
)ENGINE=InnoDB;


DROP TABLE IF EXISTS 'tbl_Puzzle';

CREATE TABLE tbl_Puzzle(
        PuzzleID        Int  Auto_increment  NOT NULL ,
        Title           Varchar (50) NOT NULL ,
        Question        Varchar (50) NOT NULL ,
        Answer          Varchar (50) NOT NULL ,
        PuzzleOrder     Int NOT NULL ,
        GameID          Int NOT NULL ,
        GameID_tbl_Game Int
	,CONSTRAINT tbl_Puzzle_PK PRIMARY KEY (PuzzleID)

	,CONSTRAINT tbl_Puzzle_tbl_Game_FK FOREIGN KEY (GameID_tbl_Game) REFERENCES tbl_Game(GameID)
)ENGINE=InnoDB;


DROP TABLE IF EXISTS 'tbl_Teams';

CREATE TABLE tbl_Teams(
        TeamID          Int  Auto_increment  NOT NULL ,
        Name            Varchar (50) NOT NULL ,
        CurrentPuzzleID Int NOT NULL ,
        GameID          Int NOT NULL ,
        GameID_tbl_Game Int
	,CONSTRAINT tbl_Teams_PK PRIMARY KEY (TeamID)

	,CONSTRAINT tbl_Teams_tbl_Game_FK FOREIGN KEY (GameID_tbl_Game) REFERENCES tbl_Game(GameID)
)ENGINE=InnoDB;


DROP TABLE IF EXISTS 'tbl_User';

CREATE TABLE tbl_User(
        UserID           Int  Auto_increment  NOT NULL ,
        FirstName        Varchar (50) NOT NULL ,
        LastName         Varchar (50) NOT NULL ,
        Email            Varchar (50) NOT NULL ,
        Password         Varchar (50) NOT NULL ,
        GameMaster       Bool NOT NULL ,
        TeamID           Int NOT NULL ,
        TeamID_tbl_Teams Int
	,CONSTRAINT tbl_User_PK PRIMARY KEY (UserID)

	,CONSTRAINT tbl_User_tbl_Teams_FK FOREIGN KEY (TeamID_tbl_Teams) REFERENCES tbl_Teams(TeamID)
)ENGINE=InnoDB;

