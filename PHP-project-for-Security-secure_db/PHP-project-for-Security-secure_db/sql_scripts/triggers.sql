USE cst8257project;
/*DELIMITER //
CREATE PROCEDURE set_current_user(IN user_id VARCHAR(255))
BEGIN
    SET @current_user_id = user_id;
END //
DELIMITER ;
SHOW PROCEDURE STATUS WHERE Db = 'cst8257project';
SHOW TRIGGERS FROM cst8257project;*/
-- Drop existing triggers if they exist
DROP TRIGGER IF EXISTS after_user_insert;
DROP TRIGGER IF EXISTS after_user_delete;
DROP TRIGGER IF EXISTS after_user_update;
DROP TRIGGER IF EXISTS after_album_insert;
DROP TRIGGER IF EXISTS after_album_update;
DROP TRIGGER IF EXISTS after_album_delete;
DROP TRIGGER IF EXISTS after_picture_insert;
DROP TRIGGER IF EXISTS after_picture_update;
DROP TRIGGER IF EXISTS after_picture_delete;
DROP TRIGGER IF EXISTS after_comment_insert;
DROP TRIGGER IF EXISTS after_comment_update;
DROP TRIGGER IF EXISTS after_comment_delete;
DROP TRIGGER IF EXISTS after_friendship_insert;
DROP TRIGGER IF EXISTS after_friendship_update;
DROP TRIGGER IF EXISTS after_friendship_delete;

DELIMITER //

-- Trigger for INSERT operation on user table
CREATE TRIGGER after_user_insert
AFTER INSERT ON user
FOR EACH ROW
BEGIN
    INSERT INTO audit_log (table_name, operation_type, logged_user, new_value)
    VALUES ('user', 'INSERT', @current_user_id, CONCAT('New value: UserId=', NEW.UserId, ', Name=', NEW.Name, ', Phone=', NEW.Phone, ', Password=', NEW.Password, ', Role=', NEW.Role));
END //

-- Trigger for DELETE operation on user table
CREATE TRIGGER after_user_delete
AFTER DELETE ON user
FOR EACH ROW
BEGIN
    INSERT INTO audit_log (table_name, operation_type, logged_user, old_value)
    VALUES ('user', 'DELETE', @current_user_id, CONCAT('Old value: UserId=', OLD.UserId, ', Name=', OLD.Name, ', Phone=', OLD.Phone, ', Password=', OLD.Password, ', Role=', OLD.Role));
END //

-- Trigger for UPDATE operation on user table
CREATE TRIGGER after_user_update
AFTER UPDATE ON user
FOR EACH ROW
BEGIN
    INSERT INTO audit_log (table_name, operation_type, logged_user, old_value, new_value)
    VALUES ('user', 'UPDATE', @current_user_id, 
    CONCAT('Old value: UserId=', OLD.UserId, ', Name=', OLD.Name, ', Phone=', OLD.Phone, ', Password=', OLD.Password, ', Role=', OLD.Role), 
    CONCAT('New value: UserId=', NEW.UserId, ', Name=', NEW.Name, ', Phone=', NEW.Phone, ', Password=', NEW.Password, ', Role=', NEW.Role));
END //

-- Trigger for INSERT operation on album table
CREATE TRIGGER after_album_insert
AFTER INSERT ON album
FOR EACH ROW
BEGIN
    INSERT INTO audit_log (table_name, operation_type, logged_user, new_value)
    VALUES ('album', 'INSERT', @current_user_id, CONCAT('New value: Album_Id=', NEW.Album_Id, ', Title=', NEW.Title, ', Description=', NEW.Description, ', Owner_Id=', NEW.Owner_Id, ', Accessibility_Code=', NEW.Accessibility_Code));
END //

-- Trigger for UPDATE operation on album table
CREATE TRIGGER after_album_update
AFTER UPDATE ON album
FOR EACH ROW
BEGIN
    INSERT INTO audit_log (table_name, operation_type, logged_user, old_value, new_value)
    VALUES ('album', 'UPDATE', @current_user_id, 
    CONCAT('Old value: Album_Id=', OLD.Album_Id, ', Title=', OLD.Title, ', Description=', OLD.Description, ', Owner_Id=', OLD.Owner_Id, ', Accessibility_Code=', OLD.Accessibility_Code),
    CONCAT('New value: Album_Id=', NEW.Album_Id, ', Title=', NEW.Title, ', Description=', NEW.Description, ', Owner_Id=', NEW.Owner_Id, ', Accessibility_Code=', NEW.Accessibility_Code));
END //

-- Trigger for DELETE operation on album table
CREATE TRIGGER after_album_delete
AFTER DELETE ON album
FOR EACH ROW
BEGIN
    INSERT INTO audit_log (table_name, operation_type, logged_user, old_value)
    VALUES ('album', 'DELETE', @current_user_id, CONCAT('Old value: Album_Id=', OLD.Album_Id, ', Title=', OLD.Title, ', Description=', OLD.Description, ', Owner_Id=', OLD.Owner_Id, ', Accessibility_Code=', OLD.Accessibility_Code));
END //

-- Trigger for INSERT operation on comment table
CREATE TRIGGER after_comment_insert
AFTER INSERT ON comment
FOR EACH ROW
BEGIN
    INSERT INTO audit_log (table_name, operation_type, logged_user, new_value)
    VALUES ('comment', 'INSERT', @current_user_id, CONCAT('New value: Comment_Id=', NEW.Comment_Id, ', Author_Id=', NEW.Author_Id, ', Picture_Id=', NEW.Picture_Id, ', Comment_Text=', NEW.Comment_Text));
END //

-- Trigger for UPDATE operation on comment table
CREATE TRIGGER after_comment_update
AFTER UPDATE ON comment
FOR EACH ROW
BEGIN
    INSERT INTO audit_log (table_name, operation_type, logged_user, old_value, new_value)
    VALUES ('comment', 'UPDATE', @current_user_id, 
    CONCAT('Old value: Comment_Id=', OLD.Comment_Id, ', Author_Id=', OLD.Author_Id, ', Picture_Id=', OLD.Picture_Id, ', Comment_Text=', OLD.Comment_Text),
    CONCAT('New value: Comment_Id=', NEW.Comment_Id, ', Author_Id=', NEW.Author_Id, ', Picture_Id=', NEW.Picture_Id, ', Comment_Text=', NEW.Comment_Text));
END //

-- Trigger for DELETE operation on comment table
CREATE TRIGGER after_comment_delete
AFTER DELETE ON comment
FOR EACH ROW
BEGIN
    INSERT INTO audit_log (table_name, operation_type, logged_user, old_value)
    VALUES ('comment', 'DELETE', @current_user_id, CONCAT('Old value: Comment_Id=', OLD.Comment_Id, ', Author_Id=', OLD.Author_Id, ', Picture_Id=', OLD.Picture_Id, ', Comment_Text=', OLD.Comment_Text));
END //

-- Trigger for INSERT operation on friendship table
CREATE TRIGGER after_friendship_insert
AFTER INSERT ON friendship
FOR EACH ROW
BEGIN
    INSERT INTO audit_log (table_name, operation_type, logged_user, new_value)
    VALUES ('friendship', 'INSERT', @current_user_id, CONCAT('New value: Friend_RequesterId=', NEW.Friend_RequesterId, ', Friend_RequesteeId=', NEW.Friend_RequesteeId, ', Status=', NEW.Status));
END //

-- Trigger for UPDATE operation on friendship table
CREATE TRIGGER after_friendship_update
AFTER UPDATE ON friendship
FOR EACH ROW
BEGIN
    INSERT INTO audit_log (table_name, operation_type, logged_user, old_value, new_value)
    VALUES ('friendship', 'UPDATE', @current_user_id, 
    CONCAT('Old value: Friend_RequesterId=', OLD.Friend_RequesterId, ', Friend_RequesteeId=', OLD.Friend_RequesteeId, ', Status=', OLD.Status),
    CONCAT('New value: Friend_RequesterId=', NEW.Friend_RequesterId, ', Friend_RequesteeId=', NEW.Friend_RequesteeId, ', Status=', NEW.Status));
END //

-- Trigger for DELETE operation on friendship table
CREATE TRIGGER after_friendship_delete
AFTER DELETE ON friendship
FOR EACH ROW
BEGIN
    INSERT INTO audit_log (table_name, operation_type, logged_user, old_value)
    VALUES ('friendship', 'DELETE', @current_user_id, CONCAT('Old value: Friend_RequesterId=', OLD.Friend_RequesterId, ', Friend_RequesteeId=', OLD.Friend_RequesteeId, ', Status=', OLD.Status));
END //

-- Trigger for INSERT operation on picture table
CREATE TRIGGER after_picture_insert
AFTER INSERT ON picture
FOR EACH ROW
BEGIN
    INSERT INTO audit_log (table_name, operation_type, logged_user, new_value)
    VALUES ('picture', 'INSERT', @current_user_id, CONCAT('New value: Picture_Id=', NEW.Picture_Id, ', Album_Id=', NEW.Album_Id, ', File_Name=', NEW.File_Name, ', Title=', NEW.Title, ', Description=', NEW.Description));
END //

-- Trigger for UPDATE operation on picture table
CREATE TRIGGER after_picture_update
AFTER UPDATE ON picture
FOR EACH ROW
BEGIN
    INSERT INTO audit_log (table_name, operation_type, logged_user, old_value, new_value)
    VALUES ('picture', 'UPDATE', @current_user_id, 
    CONCAT('Old value: Picture_Id=', OLD.Picture_Id, ', Album_Id=', OLD.Album_Id, ', File_Name=', OLD.File_Name, ', Title=', OLD.Title, ', Description=', OLD.Description),
    CONCAT('New value: Picture_Id=', NEW.Picture_Id, ', Album_Id=', NEW.Album_Id, ', File_Name=', NEW.File_Name, ', Title=', NEW.Title, ', Description=', NEW.Description));
END //

-- Trigger for DELETE operation on picture table
CREATE TRIGGER after_picture_delete
AFTER DELETE ON picture
FOR EACH ROW
BEGIN
    INSERT INTO audit_log (table_name, operation_type, logged_user, old_value)
    VALUES ('picture', 'DELETE', @current_user_id, CONCAT('Old value: Picture_Id=', OLD.Picture_Id, ', Album_Id=', OLD.Album_Id, ', File_Name=', OLD.File_Name, ', Title=', OLD.Title, ', Description=', OLD.Description));
END //

DELIMITER ;