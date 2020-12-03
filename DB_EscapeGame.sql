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

DROP TABLE IF EXISTS `tbl_file`;
CREATE TABLE `tbl_file` (
  `id_file` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_file`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `tbl_Puzzle`;
CREATE TABLE tbl_Puzzle(
        puzzle_ID        Int  Auto_increment  NOT NULL ,
        title           Varchar (50) NOT NULL UNIQUE,
        question        Varchar (50) NOT NULL UNIQUE,
        answer          Varchar (50) NOT NULL ,
        puzzle_order     Int NOT NULL UNIQUE,
        game_ID          Int NOT NULL,
        active			boolean default false,
        image		    Varchar (50)
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

DROP procedure IF EXISTS `add_file`;
DELIMITER ;;
CREATE PROCEDURE `add_file` (
    name VARCHAR(255)
)
BEGIN
    insert into tbl_file(name) 
            values (name);
END;;
DELIMITER ;

DROP procedure IF EXISTS `delete_puzzle_by_id`;
DELIMITER ;;
CREATE PROCEDURE `delete_puzzle_by_id`(
	IN puzzle_ID INT
)
BEGIN
DELETE FROM tbl_Puzzle
WHERE puzzle_ID = inPuzzle_ID;
END;;
DELIMITER ;;

DROP procedure IF EXISTS `add_puzzle`;
DELIMITER ;;
CREATE PROCEDURE `add_puzzle`(
        inTitle           nvarchar (50),
        inQuestion        nvarchar (50),
        inAnswer          nvarchar (50) ,
        inPuzzle_order     Int,
        inGame_ID          Int,
        inActive			boolean,
		inImage			nvarchar(50)
)
BEGIN
    
    INSERT INTO tbl_Puzzle(title, question, answer, puzzle_order, game_ID, active, image)
			VALUES(inTitle, inQuestion, inAnswer, inPuzzle_order, inGame_ID, inActive, inImage);
END;;
DELIMITER ;;

DROP procedure IF EXISTS `modify_puzzle`;
DELIMITER ;;
CREATE PROCEDURE `modify_puzzle`(
		inPuzzle_ID		 Int,
        inTitle           nvarchar (50),
        inQuestion        nvarchar (50),
        inAnswer          nvarchar (50) ,
        inPuzzle_order     Int,
        inGame_ID          Int,
        inActive			boolean,
		inImage			nvarchar(50)
)
BEGIN
    
    UPDATE tbl_Puzzle
    SET
        title       =   inTitle,
        question    =  	inQuestion,
        answer      = 	inAnswer ,
        puzzle_order = 	inPuzzle_order,
        game_ID     =   inGame_ID ,
        active		=	inActive,
		image		=	inImage
	WHERE
		puzzle_ID	=	 inPuzzle_ID;
END;;
DELIMITER ;;

DROP PROCEDURE IF EXISTS `get_all_puzzle`;
DELIMITER ;;
	CREATE PROCEDURE get_all_puzzle()
    BEGIN
		SELECT puzzle_ID, title, question, answer, puzzle_order, game_ID, active, image FROM tbl_Puzzle;
    END;;
DELIMITER ;


DROP PROCEDURE IF EXISTS `get_puzzle_by_id`;
DELIMITER ;;
	CREATE PROCEDURE get_puzzle_by_id(
			inPuzzle_ID INT
    )
    BEGIN
		SELECT title, question, answer, puzzle_order, game_ID, active, image FROM tbl_Puzzle
        WHERE
			puzzle_ID = inPuzzle_ID;
        
    END;;
DELIMITER ;

 INSERT INTO tbl_Teams(email, name, password, game_master)
			VALUES('email@email.com', 'cote', '123password', false);

insert into tbl_Game(game_ID, start_time) values(1, NOW());
            
insert into tbl_puzzle (puzzle_ID, title, answer, question , puzzle_order, game_ID,image) values (1, 'Skivee', 'Fuscia', 'Claremorris', 1, 1,'image1.jpg');
insert into tbl_puzzle (puzzle_ID, title, answer, question , puzzle_order, game_ID,image) values (2, 'Skibox', 'Aquamarine', 'Hualin', 2, 1,'image2.jpg');
insert into tbl_puzzle (puzzle_ID, title, answer, question , puzzle_order, game_ID,image)  values (3, 'Yoveo', 'Indigo', 'Ourozinho', 3, 1,'image3.jpg');
insert into tbl_puzzle (puzzle_ID, title, answer, question , puzzle_order, game_ID,image) values (4, 'Edgeblab', 'Orange', 'Ruda Śląska', 4, 1,null);
insert into tbl_puzzle (puzzle_ID, title, answer, question , puzzle_order, game_ID,image) values (5, 'Brainbox', 'Yellow', 'Pácora', 5, 1,null);
insert into tbl_puzzle (puzzle_ID, title, answer, question , puzzle_order, game_ID,image) values (6, 'Babbleset', 'Crimson', 'Zhoutou', 6, 1,null);
