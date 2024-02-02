#!/bin/bash
source ./funcs.sh
read -p "Enter the Root Username: " user
read -p "Do you want a random password [y/n]: " yn

if [ "$yn" == "y" ];
then
        echo "Making random password"
        $pass = passwd
        echo "$pass"
else
        read -p "Enter password"
fi

mysql -e "CREATE DATABASE test;"
mysql -e "CREATE USER '@user'@localhost IDENTIFIED by passwd;"
