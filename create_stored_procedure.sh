#!/bin/bash

# Set the MySQL login credentials
username="your_username"
password="your_password"
database="your_database"

# Set the directory path
dir_path="/stored-procedures"

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
