<?php
$host = 'localhost';
$user = 'cipher';
$pass = '23xx13xx';
$db   = 'eunoiaverse_db';

// Command to import the SQL file
$command = "mysql -h $host -u $user -p$pass $db < backup.sql";

system($command, $output);

if($output === 0) {
    echo "Database restored successfully!";
} else {
    echo "Restore failed. Check your credentials and file path.";
}
?>