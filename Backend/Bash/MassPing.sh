#!/bin/bash

usage() {
	echo "Usage: $(basename "$0") <argumetnt1> <argument2> ..."
	echo "Meant to run and check a list of IPs and return a file based on admin or not prots (1 == Admin) (2 == normal)"
	echo "Example: $(basename "$0") ip 1"
	exit 1
}


if [ "$#" -lt 2 ]; then
	usage
else
	echo "Getting availability of ip list"	       
	if [ $2 -eq 1 ];
		then
			if [ -f OutA ];
				then
					rm -r OutA
					touch OutA
				else
					touch OutA
			fi
		
			while IFS= read -r line
				do
					host=${line%:*}
					port=${line#*:}
					if nmap -p $port $host | grep open ;
					then
						tmp=$(nmap -p $port $host | grep open | sed 's/ /_/g')
						echo $tmp >> OutA	
					fi
			done <$1

	elif [ $2 -eq 2 ];
		then
			if [ -f OutN ];
				then
					rm -f OutN
					touch OutN
				else
					touch OutN
			fi

			while IFS= read -r line
				do
					host=${line%:*}
					port=${line#*:}
					if nmap -p $port $host | grep open ; 
						then
							tmp=$(nmap -p $port $host | grep open)
							echo $tmp >> OutN
					fi
			done <$1

	else
		echo "No Admin Var"
	fi

fi
