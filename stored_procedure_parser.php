<?php

// Set the directory path
$dir_path = '/stored-procedures';

// Open the directory
if ($handle = opendir($dir_path)) {
    // Loop through all the files in the directory
    while (false !== ($file = readdir($handle))) {
        // Check if the file is a regular file
        if (is_file($dir_path . '/' . $file)) {
            // Read the contents of the file
            $file_contents = file_get_contents($dir_path . '/' . $file);

            // Search for the text 'CREATE DEFINER='
            $pos = strpos($file_contents, 'CREATE DEFINER=');

            // Check if the text was found
            if ($pos !== false) {
                // Extract everything from that point to the end of the file
                $result = substr($file_contents, $pos);

                // Rewrite the file with the extracted content
                file_put_contents($dir_path . '/' . $file, $result);
            }
        }
    }

    // Close the directory handle
    closedir($handle);
}
