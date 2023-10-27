<?php

// Set the directory path
$dir_path = '../stored-procedures';
$databasename = '<your-database-name>';

// Open the directory
if ($handle = opendir($dir_path)) {
    // Loop through all the files in the directory
    while (false !== ($file = readdir($handle))) {
        // Check if the file is a regular file
        if (is_file($dir_path . '/' . $file)) {
            // Get the name of the stored procedure from the file name
            $procedure_name = basename($file, '.sql');

            // Read the contents of the file
            $file_contents = file_get_contents($dir_path . '/' . $file);

            // Add delimiter to the start and end of the file
            $result = 'USE `' . $databasename . '`;
            DROP procedure IF EXISTS `' . $procedure_name . '`;
            
            DELIMITER $$
            USE `' . $databasename . '` $$ ' . $file_contents . '$$

            DELIMITER ;';

            // Rewrite the file with the modified content
            file_put_contents($dir_path . '/' . $file, $result);
        }
    }

    // Close the directory handle
    closedir($handle);
}
