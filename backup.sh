#!/bin/bash

# Source config.sh
source config.sh

# Directory to save the SQL files
output_dir="/stored-procedures"

# Ensure the output directory exists, create it if it doesn't
mkdir -p "$output_dir"

# Get a list of all stored procedures in the database
procedure_list=$(mysql -u "$username" -p"$password" -D "$database" -e "SELECT name FROM mysql.proc WHERE db = '$database';")

# Loop through each procedure and extract its SQL code
while read -r procedure; do
    # Run MySQL query to get the procedure definition and store it in a variable
    sql_code=$(mysql -u "$username" -p"$password" -D "$database" -e "SHOW CREATE PROCEDURE \`$procedure\`" | awk 'NR > 1 {print}' | tr -d '\r')

    if [ -n "$sql_code" ]; then
        echo "$sql_code" > "$output_dir/$procedure.sql"
        echo "Stored procedure $procedure saved to $output_dir/$procedure.sql"
    else
        echo "Error extracting stored procedure $procedure"
    fi
done <<< "$procedure_list"

# Call the PHP scripts in the Removal subdirectory to modify the SQL files
# This will remove the unneed extra characters in the stored procedures
php ./Removal/parser.php
php ./Removal/lines_and_tabs.php
php ./Removal/ending.php
