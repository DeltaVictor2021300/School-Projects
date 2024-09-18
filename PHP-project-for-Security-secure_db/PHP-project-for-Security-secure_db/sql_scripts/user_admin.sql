USE cst8257project;
-- Create a admin user with limited privileges
DROP USER IF EXISTS 'adminUser'@'localhost';
CREATE USER 'adminUser'@'localhost' IDENTIFIED BY 'password';

-- Create an regular user with all privileges
DROP USER IF EXISTS 'userUser'@'localhost';
CREATE USER 'userUser'@'localhost' IDENTIFIED BY 'password';

CREATE VIEW admin_audit_log AS
SELECT log_id, table_name, operation_type, logged_user, timestamp, old_value, new_value
FROM audit_log;
-- View for regular users to see the user table without admin roles
CREATE VIEW user_view AS
SELECT UserId, Name, Phone, Role
FROM user
WHERE Role != 'admin';

GRANT SELECT, INSERT, UPDATE, DELETE ON cst8257project.user TO 'adminUser'@'localhost';
GRANT SELECT ON cst8257project.admin_audit_log TO 'adminUser'@'localhost';
GRANT SELECT ON cst8257project.non_admin_users TO 'userUser'@'localhost';

-- Grant CRUD privileges on all operational tables except specified ones to 'userUser'
GRANT SELECT, INSERT, UPDATE, DELETE ON cst8257project.album TO 'userUser'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON cst8257project.picture TO 'userUser'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON cst8257project.comment TO 'userUser'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON cst8257project.friendship TO 'userUser'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON cst8257project.friendshipstatus TO 'userUser'@'localhost';
