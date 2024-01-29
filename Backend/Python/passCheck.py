#Libraries
import sys



#Functions
def passCheck(x):
    # Function meant to check password for strength
    # Arguments 
    #   x: String 
    #Return: Boolean
    
    #Arguments
    passW = sys.argv[1]
    
    #Code
    if(len(x) >= 10):
        specChar = "!@#$%^&*()-+_=,<>?/"
        chkS=chkL=chkN = False
        for let in x:
            if(let.isalpha()):
                chkL = True
            elif(let.isdigit()):
                chkN = True
            else:
                for c in specChar:
                    if(let==c):
                        chkS = True
                        break
        if(chkS==chkN==chkL==True):
            return True
    else:
        return False

print(passCheck(passW))
