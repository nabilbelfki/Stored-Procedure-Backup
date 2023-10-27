#!/bin/bash

# Source config.sh
source config.sh

# Set the directory path
dir_path="/stored-procedures"

# Adds delimiter to execute stored procedure creation
php ./Addition/add_delimiter.php

# Loop through all the files in the directory
for file in "$dir_path"/*.sql; do
    # Check if the file is a regular file
    if [ -f "$file" ]; then
        # Run the MySQL command to create the stored procedure
        if ! mysql -u "$username" -p"$password" "$database" < "$file"; then
            echo "Failed to execute $file"
        fi
    fi
done
