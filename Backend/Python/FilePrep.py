#Libraries
import sys
#Arguments 
#file = open(sys.argv[1], "r")
file = ("80/tcp closed http", "443/tcp closed https")


#Functions
def checkIP(file):
    #Function takes the IPs from the bash file and gives back the required info
    #Parameters:
    #   file: Input file from Bash nmap
    #Return: None
    
    #Code
    with open("test.txt", "w+") as f:
        for line in file:
            tmp=tuple(line.split(" ")[:])
            var1 = tuple(changeName(tmp[0]))
            if(var1[0] == True):
                tmp[2] = var1[1]
            f.write(tmp[2], tmp[1])
            f.write("\n")
        return 

def changeName(name):
    #Function is meant to check name of nmap output and change as needed
    #Parameters:
    #   name: String 
    #Return: Boolean, String
    name = name.split("/")
    ret = False
    tmp = ""
    #Code (Need to add the names for weird dockers)
    if(name[0] == "8989"):
        tmp = "Sonarr"
        ret = True
    elif(name[0] == "7979"):
        tmp = "Radarr"
        ret = True
    elif(name[0] == "8080"):
        tmp = "Radarr"
        ret = True
    elif(name[0] == "9696"):
        tmp = "Prowlerr"
        ret = True
    return ret, tmp
    
print(changeName("8989/tcp"))
