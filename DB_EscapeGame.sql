#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------
DROP DATABASE IF EXISTS `db_travail2`;
CREATE DATABASE  IF NOT EXISTS `db_travail2` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;
USE `db_travail2`;


DROP TABLE IF EXISTS `tbl_Game`;
CREATE TABLE tbl_Game(
        game_ID    Int  Auto_increment  NOT NULL ,
        start_time Time NOT NULL
	,CONSTRAINT tbl_Game_PK PRIMARY KEY (game_ID)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



DROP TABLE IF EXISTS `tbl_Puzzle`;
CREATE TABLE tbl_Puzzle(
        puzzle_ID        Int  Auto_increment  NOT NULL ,
        title           Varchar (50) NOT NULL UNIQUE,
        question        Varchar (50) NOT NULL UNIQUE,
        answer          Varchar (50) NOT NULL ,
        puzzle_order     Int NOT NULL UNIQUE,
        game_ID          Int NOT NULL 
	,CONSTRAINT tbl_Puzzle_PK PRIMARY KEY (puzzle_ID)
	,CONSTRAINT tbl_Puzzle_tbl_Game_FK FOREIGN KEY (game_ID) REFERENCES tbl_Game(game_ID)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `tbl_Teams`;
CREATE TABLE tbl_Teams(
        team_ID          Int  Auto_increment  NOT NULL ,
        name            Varchar (50) NOT NULL UNIQUE,
		current_puzzle_ID Int,
        game_ID          Int,
        email           Varchar (50) NOT NULL UNIQUE,
        password        Varchar (50) NOT NULL ,
        game_master      Bool NOT NULL ,
        last_answer_sent  Time 
	,CONSTRAINT tbl_Teams_PK PRIMARY KEY (team_ID)
	,CONSTRAINT tbl_Teams_tbl_Game_FK FOREIGN KEY (game_ID) REFERENCES tbl_Game(game_ID)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP procedure IF EXISTS `get_team_credentials_from_email`;
DELIMITER ;;
CREATE DEFINER=root@localhost PROCEDURE get_team_credentials_from_email(
    IN in_email varchar(50)
)
BEGIN
    SELECT name,
    email,
    password,
    game_master
  FROM tbl_Teams WHERE email = in_email limit 1;
END;;
DELIMITER ;

DROP procedure IF EXISTS `add_team`;
DELIMITER ;;
CREATE PROCEDURE add_team(
    in_email VARCHAR(50),
    in_name VARCHAR(50),
	in_password VARCHAR(50),
    in_game_master BOOL
)
BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;  
        RESIGNAL;  
    END;
    START TRANSACTION;
    IF(SELECT COUNT(email) FROM tbl_Teams WHERE email = in_email) != 0 THEN
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Email not Unique', MYSQL_ERRNO = 1;
    ELSEIF
	(SELECT COUNT(name) FROM tbl_Teams WHERE name = in_name) != 0 THEN
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Name not Unique', MYSQL_ERRNO = 2;
	END IF;
    
    INSERT INTO tbl_Teams(email, name, password, game_master)
			VALUES(in_email, in_name, in_password, in_game_master);
    COMMIT;
END;;
DELIMITER ;

DROP PROCEDURE IF EXISTS `get_all_teams`;
DELIMITER ;;
	CREATE PROCEDURE get_all_teams()
    BEGIN
		SELECT name, current_puzzle_ID, game_ID, game_master FROM tbl_teams;
    END;;
DELIMITER ;



