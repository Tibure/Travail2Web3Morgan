#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------
DROP DATABASE IF EXISTS `db_travail2`;
CREATE DATABASE  IF NOT EXISTS `db_travail2` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;
USE `db_travail2`;


DROP TABLE IF EXISTS `tbl_Game`;
CREATE TABLE tbl_Game(
        game_ID    Int  Auto_increment  NOT NULL ,
        start_time Time
	,CONSTRAINT tbl_Game_PK PRIMARY KEY (game_ID)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `tbl_file`;
CREATE TABLE `tbl_file` (
  `id_file` int(11) NOT NULL AUTO_INCREMENT,
  `name` nvarchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_file`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `tbl_Puzzle`;
CREATE TABLE tbl_Puzzle(
        puzzle_ID        Int  Auto_increment  NOT NULL ,
        title           nvarchar (50) NOT NULL UNIQUE,
        question        nvarchar (100) NOT NULL UNIQUE,
        answer          nvarchar (50) NOT NULL ,
        hint			nvarchar (50) ,
        puzzle_order     Int NOT NULL UNIQUE,
        game_ID          Int NOT NULL,
        active 			boolean NOT NULL,
        image_id	    INT
	,CONSTRAINT tbl_Puzzle_PK PRIMARY KEY (puzzle_ID)
    ,CONSTRAINT tbl_Puzzle_tbl_file_FK FOREIGN KEY (image_id) REFERENCES tbl_file(id_file)
	,CONSTRAINT tbl_Puzzle_tbl_Game_FK FOREIGN KEY (game_ID) REFERENCES tbl_Game(game_ID)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `tbl_Teams`;
CREATE TABLE tbl_Teams(
        team_ID          Int  Auto_increment  NOT NULL ,
        name            nvarchar (50) NOT NULL UNIQUE,
		current_puzzle_order Int DEFAULT 1,
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
    
    INSERT INTO tbl_Teams(email, puzzle_ID ,name, password, game_master)
			VALUES(in_email, (SELECT puzzle_ID FROM tbl_puzzle WHERE puzzle_order = MIN(puzzle_order)), in_name, in_password, in_game_master);
    COMMIT;
END;;
DELIMITER ;

DROP PROCEDURE IF EXISTS `get_all_teams`;
DELIMITER ;;
	CREATE PROCEDURE get_all_teams()
    BEGIN
		SELECT name, current_puzzle_order, game_ID, game_master FROM tbl_teams;
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
    START TRANSACTION;
    SET max_puzzle_order = (SELECT MAX(puzzle_order)+1 as puzzleordermax  FROM (SELECT  * FROM tbl_Puzzle) AS tempTable);
    SET latest_game_id = (SELECT MAX(game_ID) as gameid FROM (SELECT  * FROM tbl_Puzzle) AS tempTable);
    INSERT INTO tbl_Puzzle(title, question, answer, hint, puzzle_order, game_ID, active, image)
			VALUES(inTitle, inQuestion, inAnswer, inHint, max_puzzle_order , latest_game_id, inActive, inImage);
	COMMIT;
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
		SELECT puzzle_ID, title, question, answer, hint, puzzle_order ,game_ID, active, image_id FROM tbl_Puzzle order by puzzle_order;
    END;;
DELIMITER ;

DROP PROCEDURE IF EXISTS `get_puzzle_by_id`;
DELIMITER ;;
	CREATE PROCEDURE get_puzzle_by_id(
			inPuzzle_ID INT
    )
    BEGIN
		SELECT puzzle_ID, title, question, answer, hint, puzzle_order, game_ID, active, image_id FROM tbl_Puzzle
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
		SELECT id_file, name FROM tbl_file
        WHERE
			id_file = in_id_file;
    END;;
DELIMITER ;;

DROP PROCEDURE IF EXISTS `get_game_start_time`;
DELIMITER ;;
	CREATE PROCEDURE get_game_start_time()
    BEGIN
		SELECT UNIX_TIMESTAMP(start_time) AS start_time FROM tbl_game WHERE game_ID = (SELECT max(game_ID) AS game_ID FROM tbl_game);
    END;;
DELIMITER ;;

DROP PROCEDURE IF EXISTS `start_game`;
DELIMITER ;;
	CREATE PROCEDURE start_game(
		inTime time
    )
    BEGIN
    DECLARE id int;
    SET id = (SELECT max(game_ID) AS game_ID FROM tbl_game);
		UPDATE tbl_game SET start_time = inTime WHERE game_ID = id;
    END;;
DELIMITER ;;


DROP PROCEDURE IF EXISTS `get_puzzle_info`;
DELIMITER ;;
	CREATE PROCEDURE get_puzzle_info(
		in_email nvarchar (50)
    )
    BEGIN
		SELECT title, question, image_id FROM tbl_puzzle WHERE active = true AND puzzle_order = (SELECT current_puzzle_order FROM tbl_teams WHERE email = in_email);
    END;;
DELIMITER ;;

DROP PROCEDURE IF EXISTS `get_answer_from_email`;
DELIMITER ;;
	CREATE PROCEDURE get_answer_from_email(
			in_email nvarchar(50)
    )
    BEGIN
        SELECT answer FROM tbl_puzzle WHERE active = true AND puzzle_order = (SELECT current_puzzle_order FROM tbl_teams WHERE email = in_email);
    END;;
DELIMITER ;;

DROP PROCEDURE IF EXISTS `change_puzzle`;
DELIMITER ;;
	CREATE PROCEDURE change_puzzle(
			in_email nvarchar(50)
    )
    BEGIN
        UPDATE tbl_teams SET current_puzzle_order = current_puzzle_order + 1 WHERE email = in_email;
    END;;
DELIMITER ;;

DROP PROCEDURE IF EXISTS `get_all_hints_available`
DELIMITER ;;
	CREATE PROCEDURE get_all_hints_available(
    current_level int
    )
    BEGIN
		SELECT title, hint, puzzle_order FROM tbl_puzzle WHERE puzzle_order <= current_level ORDER BY puzzle_order;
    END;;
DELIMITER ;;


DROP PROCEDURE IF EXISTS `get_current_level_of_one_team`;
DELIMITER ;;
	CREATE PROCEDURE get_current_level_of_one_team(
		in_email NVARCHAR(50)
    )
    BEGIN
		SELECT current_puzzle_order FROM tbl_teams WHERE email = in_email;
    END;;
DELIMITER ;;

DROP PROCEDURE IF EXISTS `get_current_level_of_teams`;
DELIMITER ;;
	CREATE PROCEDURE get_current_level_of_teams()
    BEGIN
		SELECT team_ID, name, current_puzzle_order FROM tbl_teams WHERE game_master = false;
    END;;
DELIMITER ;;

DROP PROCEDURE IF EXISTS `get_number_puzzle_active`;
DELIMITER ;;
	CREATE PROCEDURE get_number_puzzle_active()
    BEGIN
		SELECT COUNT(puzzle_order) AS total FROM tbl_puzzle WHERE game_ID = (SELECT max(game_ID) AS game_ID FROM tbl_game) AND active = true;
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
	
    IF((SELECT puzzle_ID FROM tbl_puzzle WHERE puzzle_order = new_order) <> id_puzzle OR 0) THEN
		SET old_order = (SELECT puzzle_order FROM tbl_puzzle WHERE puzzle_ID = id_puzzle);
		UPDATE tbl_puzzle SET puzzle_order = (select MAX(puzzle_order)+1 FROM (SELECT * FROM tbl_Puzzle) AS tempTable) WHERE puzzle_order = new_order;
        UPDATE tbl_puzzle SET puzzle_order = new_order WHERE puzzle_ID = id_puzzle;
        UPDATE tbl_puzzle SET puzzle_order = old_order WHERE puzzle_order = (select MAX(puzzle_order) FROM (SELECT * FROM tbl_Puzzle) AS tempTable );
    ELSE
		UPDATE tbl_puzzle SET puzzle_order = new_order WHERE puzzle_ID = id_puzzle;
	END IF;
    COMMIT;
	END;;
DELIMITER ;;

DROP PROCEDURE IF EXISTS `take_out_puzzle_order`
DELIMITER ;;

insert into tbl_file(name) value('image1.jpg');
insert into tbl_file(name) value('image2.jpg');
insert into tbl_file(name) value('image3.jpg');
insert into tbl_file(name) value('ordinateur.jpg');

insert into tbl_Game (game_ID, start_time) values (1, null);
insert into tbl_puzzle (puzzle_ID, title, answer, question , hint, puzzle_order, game_ID, active, image_id) values (1, 'Le chat', '4', 'Combien de patte possède un chat ?','Le double de celui des humains', 1, 1,1,'1');
insert into tbl_puzzle (puzzle_ID, title, answer, question , hint, puzzle_order, game_ID, active, image_id) values (2, 'Le perroquet', '2', 'Combien de patte possède un perroquet ?','La moitié de celle du chat', 2, 1,1,'2');
insert into tbl_puzzle (puzzle_ID, title, answer, question , hint, puzzle_order, game_ID, active, image_id) values (3, 'Les sens', '3', 'Si je suis muet, aveugle et sourd, combien de sens me reste-t-il ?','Muet ne correspond pas à un sens', 3, 1,1,'3');
insert into tbl_puzzle (puzzle_ID, title, answer, question , hint, puzzle_order, game_ID, active, image_id) values (4, 'La vue', 'Le nez', 'Je porte des lunettes mais je ne vois rien, qui suis-je ?','Qu\'est ce qui porte les lunettes sur notre visage', 4, 1,1,'4');

insert into tbl_teams (name,game_ID,email,password,game_master,last_answer_sent) values ('admin',1,'admin@email.com','$2y$10$614glNUoyntsScYHa5Z7pO7pEUmnWLco99YbeAB.cb8KwGQEkzl8.',true,null);
insert into tbl_teams (name,game_ID,email,password,game_master,last_answer_sent) values ('player',1,'player@email.com','$2y$10$c0LyCySiy9CLAZKrbZtbu.xfK76xzJ.tIv7fSJI9FVGmj.UwbdI8q',false,null);
insert into tbl_teams (name,game_ID,email,password,game_master,last_answer_sent) values ('player2',1,'player2@email.com','$2y$10$c0LyCySiy9CLAZKrbZtbu.xfK76xzJ.tIv7fSJI9FVGmj.UwbdI8q',false,null);
