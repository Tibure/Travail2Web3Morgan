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
  `name` nvarchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_file`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `tbl_Puzzle`;
CREATE TABLE tbl_Puzzle(
        puzzle_ID        Int  Auto_increment  NOT NULL ,
        title           nvarchar (50) NOT NULL UNIQUE,
        question        nvarchar (50) NOT NULL UNIQUE,
        answer          nvarchar (50) NOT NULL ,
        hint			nvarchar (50) ,
        puzzle_order     Int NOT NULL UNIQUE,
        game_ID          Int NOT NULL,
        active 			boolean NOT NULL,
        image			nvarchar(50)
	,CONSTRAINT tbl_Puzzle_PK PRIMARY KEY (puzzle_ID)
	,CONSTRAINT tbl_Puzzle_tbl_Game_FK FOREIGN KEY (game_ID) REFERENCES tbl_Game(game_ID)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `tbl_Teams`;
CREATE TABLE tbl_Teams(
        team_ID          Int  Auto_increment  NOT NULL ,
        name            nvarchar (50) NOT NULL UNIQUE,
		current_puzzle_ID Int,
        game_ID          Int,
        email           nvarchar (50) NOT NULL UNIQUE,
        password        nvarchar (100) NOT NULL ,
        game_master      Bool NOT NULL ,
        last_answer_sent  Time 
	,CONSTRAINT tbl_Teams_PK PRIMARY KEY (team_ID)
	,CONSTRAINT tbl_Teams_tbl_Game_FK FOREIGN KEY (game_ID) REFERENCES tbl_Game(game_ID)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP procedure IF EXISTS `get_team_credentials_from_email`;
DELIMITER ;;
CREATE DEFINER=root@localhost PROCEDURE get_team_credentials_from_email(
    IN in_email nvarchar(50)
)
BEGIN
    SELECT name,
    password,
    game_master
  FROM tbl_Teams WHERE email = in_email limit 1;
END;;
DELIMITER ;

DROP procedure IF EXISTS `add_team`;
DELIMITER ;;
CREATE PROCEDURE add_team(
    in_email nvarchar(50),
    in_name nvarchar(50),
	in_password nvarchar(100),
    in_game_master BOOL
)
BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;  
        RESIGNAL;  
    END;
    START TRANSACTION;
    IF((SELECT COUNT(email) FROM tbl_Teams WHERE email = in_email) <> 0) THEN
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
    name nvarchar(255)
)
BEGIN
    insert into tbl_file(name) 
            values (name);
END;;
DELIMITER ;

DROP procedure IF EXISTS `delete_puzzle_by_id`;
DELIMITER ;;
CREATE PROCEDURE `delete_puzzle_by_id`(
	IN inPuzzle_ID INT
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
        inAnswer          nvarchar (50),
        inHint			  nvarchar (50),
        inActive			boolean,
		inImage			nvarchar(50)
)
BEGIN

    DECLARE max_puzzle_order int;
    DECLARE latest_game_id int;
    SET max_puzzle_order = (SELECT MAX(puzzle_order)+1 AS puzzle_order FROM tbl_Puzzle);
    SET latest_game_id = (SELECT MAX(game_ID) as game_ID FROM tbl_Puzzle);
    INSERT INTO tbl_Puzzle(title, question, answer, hint, puzzle_order, game_ID, active, image)
			VALUES(inTitle, inQuestion, inAnswer, inHint, max_puzzle_order , latest_game_id, inActive, inImage);
END;;
DELIMITER ;;

DROP procedure IF EXISTS `modify_puzzle`;
DELIMITER ;;
CREATE PROCEDURE `modify_puzzle`(
		inPuzzle_ID		 Int,
        inTitle           nvarchar (50),
        inQuestion        nvarchar (50),
        inAnswer          nvarchar (50),
        inHint			  nvarchar (50),
        inActive		  boolean,
		inImage			  nvarchar(50)
)
BEGIN
    UPDATE tbl_Puzzle
    SET
        title       =   inTitle,
        question    =  	inQuestion,
        answer      = 	inAnswer ,
        hint		=	inHint ,
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
		SELECT puzzle_ID, title, question, answer, hint, puzzle_order ,game_ID, active, image FROM tbl_Puzzle;
    END;;
DELIMITER ;


DROP PROCEDURE IF EXISTS `get_puzzle_by_id`;
DELIMITER ;;
	CREATE PROCEDURE get_puzzle_by_id(
			inPuzzle_ID INT
    )
    BEGIN
		SELECT puzzle_ID, title, question, answer, hint, puzzle_order, game_ID, active, image FROM tbl_Puzzle
        WHERE
			puzzle_ID = inPuzzle_ID;
        
    END;;
DELIMITER ;;

DROP PROCEDURE IF EXISTS `get_all_files`;
DELIMITER ;;
	CREATE PROCEDURE get_all_files()
    BEGIN
		SELECT id_file,name FROM tbl_file;
    END;;
DELIMITER ;


DROP PROCEDURE IF EXISTS `get_file_by_id`;
DELIMITER ;;
	CREATE PROCEDURE get_file_by_id(
			in_id_file INT
    )
    BEGIN
		SELECT id_file,name FROM tbl_file
        WHERE
			id_file = in_id_file;
    END;;
DELIMITER ;;


DROP PROCEDURE IF EXISTS `modify_puzzle_order`
DELIMITER ;;
	CREATE PROCEDURE modify_puzzle_order(
    id_puzzle INT,
    new_order INT
    )
    BEGIN
	 DECLARE old_order int;
     START TRANSACTION;
	
    IF((SELECT Count(puzzle_order) FROM tbl_puzzle WHERE puzzle_order = new_order) <> 0) THEN
		SET old_order = (SELECT puzzle_order FROM tbl_puzzle WHERE puzzle_ID = id_puzzle);
		UPDATE tbl_puzzle SET puzzle_order = (select MAX(puzzle_order)+1 from tbl_puzzle) WHERE puzzle_order = new_order;
        UPDATE tbl_puzzle SET puzzle_order = new_order WHERE puzzle_ID = id_puzzle;
        UPDATE tbl_puzzle SET puzzle_order = old_order WHERE puzzle_order = (select MAX(puzzle_order) from tbl_puzzle);
    ELSE
		UPDATE tbl_puzzle SET puzzle_order = new_order WHERE puzzle_ID = id_puzzle;
	END IF;
    COMMIT;
	END;;
DELIMITER ;;

DROP PROCEDURE IF EXISTS `take_out_puzzle_order`
DELIMITER ;;

insert into tbl_Game (game_ID, start_time) values (1, now());
insert into tbl_puzzle (puzzle_ID, title, answer, question , hint, puzzle_order, game_ID, active, image) values (1, 'Skivee', 'Fuscia', 'Claremorris','jo', 1, 1,0,'image1.jpg');
insert into tbl_puzzle (puzzle_ID, title, answer, question , hint, puzzle_order, game_ID, active, image) values (2, 'Skibox', 'Aquamarine', 'Hualin','morg', 2, 1,1,'image2.jpg');
insert into tbl_puzzle (puzzle_ID, title, answer, question , puzzle_order, game_ID, active, image) values (3, 'Yoveo', 'Indigo', 'Ourozinho', 3, 1,1,'image3.jpg');
insert into tbl_puzzle (puzzle_ID, title, answer, question , puzzle_order, game_ID, active, image) values (4, 'Edgeblab', 'Orange', 'Ruda Śląska', 4, 1,1,'allo');
insert into tbl_puzzle (puzzle_ID, title, answer, question , puzzle_order, game_ID, active, image) values (5, 'Brainbox', 'Yellow', 'Pácora', 5, 1,1,'allo');
insert into tbl_puzzle (puzzle_ID, title, answer, question , puzzle_order, game_ID, active, image) values (6, 'Babbleset', 'Crimson', 'Zhoutou', 6, 1,1,'allo');

insert into tbl_teams (name,current_puzzle_ID,game_ID,email,password,game_master,last_answer_sent) values ('admin',null,1,'admin@email.com','$2y$10$vqtKQakRpcrHDv9FqMeWVuhiU9w41ASh9gLaxbAEnqLjlPKp7nA/y',true,null);
insert into tbl_teams (name,current_puzzle_ID,game_ID,email,password,game_master,last_answer_sent) values ('player',null,1,'player@email.com','$2y$10$2QQJXXBCie32AQQ8wyh7KuILMMW2wPwOqZFj7RUW5Z/GOA6uH/r9e',false,null);

insert into tbl_file(name) value('image1.jpg');
insert into tbl_file(name) value('image2.jpg');
insert into tbl_file(name) value('image3.jpg');