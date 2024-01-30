#NEED TO CONVERT TO PHP FOR EFFICENCY, diff versions for newuser vs login

#Imports 
import sys 

#Functions
def checkUser(usr,num):
    #Function to check the username against various forms
    #Params
    #   usr: String for username
    #   num: int
    #Return: Boolean 
    tmp = False
    if(num ==1):
        #Check against MySQL
        if(len(usr) <= 50 and len(usr) > 0):
            tmp = True
    else:
        print("Bad number")
    return tmp

def checkEmail(email,num):
    #Function to check the username against various forms
    #Params
    #   usr: String for email
    #   num: int
    #Return: Boolean 
    tmp = False
    if(num == 2):
        #Check against MySQL
        if(len(email) <= 255 and len(email) > 0):
            tmp = True
    else:
        print("Bad num")
    return tmp
    
def checkPass(passW, num):
    
    # Function meant to check password for strength
    # Arguments 
    #   x: String
    #   num: Int (3 = Strength, 4=check)
    #Return: Boolean
    tmp = False
    #Code
    if(num == 3):
        if(len(passW) >= 10):
            specChar = "!@#$%^&*()-+_=,<>?/"
            chkS=chkL=chkN = False
            for let in passW:
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
                tmp = True
                return tmp
    elif(num == 4):
        # MySQL Check here
        return tmp
    else:
        print("Bad num")
        return tmp
    
    return tmp
    
def getFunc():
    text = sys.argv[1] #Text that is going to be check
    x = int(sys.argv[2]) #Indicates what function to check agaisnt
    tmp = False
    if(x ==1):
        tmp = checkUser(text,x)
    elif(x ==2):
        tmp = checkEmail(text,x)
    elif(x ==3 or x==4):
        tmp = checkPass(text,x)
    else:
        print("Bad Input")
    return tmp

print(getFunc())
