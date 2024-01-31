#!/bin/bash 

echo "Script meant to add Host:Port to IP list of checks" 

read -p "Enter Hostname:" host 
read -p "Enter Port:" port 
echo $host:$port 
read -p "Is this correct? [y/n]" YN 

if [ "$YN" == "y" ]; 
  then 
    echo $host:$port >> ip 
  else 
    echo "Selectd No. Ending Script" 
fi
