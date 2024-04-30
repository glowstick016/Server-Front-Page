#!/bin/bash
source ./funcs.sh

user=GlowWeb
mysql -e "CREATE DATABASE ${user} /*\!40100 DEFAULT CHARACTER SET utf8 */;"
pass="$(openssl rand -base64 12)"


read -p "Do you want a user account?[y/n] (Defualt is GlowWeb)" yn

if [ "$yn" == "y"]; then

        read -p "Enter the Root Username: " user
        read -p "Do you want a random password [y/n]: " yn

        if [ "$yn" == "y" ];
                then
                        echo "Making random password"
                        #Already have random from start
                        echo $pass
                else
                        read -p "Enter password"
        fi
        else
                echo $pass
fi

#Creating the database
mysql -e "CREATE USER ${user}@localhost IDENTIFIED by '${pass}';"
mysql -e "GRANT ALL PRIVILEGES on ${user}.* to '${user}'@'localhost';"
mysql -e "FLUSH PRIVILEGES;"

#Creating fields
mysql --user=$user --password=$pass < create_db.sql
