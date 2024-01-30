#!/bin/bash

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
					tmp=$(nmap -p $port $host | grep open)
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
