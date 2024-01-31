#!/bin/bash
if [ "$EUID" -ne 0 ];
  then
      echo "Run as root"
      exit
fi 

echo "Starting Script for Glow's website"
read -p "Do you want to run this? [y/n]" yn

if [ "$yn" == "n" ];
        then
                exit
fi

echo "Installing dependencies"
apt-get -y --ignore-missing install $(< package.list)


# Setup MySQL
