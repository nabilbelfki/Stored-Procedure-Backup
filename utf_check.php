<?php

// Set the directory path
$dir_path = '/stored-procedures';

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

            // Check if the file contents contain the string "utf8"
            if (strpos($file_contents, 'utf8') !== false) {
                // Check if the occurrence of "utf8" is part of "CHARACTER SET 'utf8'" or "CHARSET utf8"
                if (stripos($file_contents, "CHARACTER SET 'utf8'") === false && stripos($file_contents, "CHARSET utf8") === false && stripos($file_contents, "USING utf8") === false) {
                    // Echo the name of the stored procedure
                    echo $procedure_name . "\n";
                }
            }
        }
    }

    // Close the directory handle
    closedir($handle);
}
?>
