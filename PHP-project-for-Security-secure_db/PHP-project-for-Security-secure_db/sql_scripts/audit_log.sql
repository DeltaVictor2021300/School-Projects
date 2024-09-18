USE cst8257project;

-- Create the audit_log table
CREATE TABLE IF NOT EXISTS audit_log (
    log_id INT AUTO_INCREMENT PRIMARY KEY,
    table_name VARCHAR(255),
    operation_type VARCHAR(50),
    logged_user VARCHAR(255),
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    old_value TEXT,
    new_value TEXT
);
