#!/bin/bash

if [ -z $1 ]; then
        echo "No usr given"
else
        if [ -z $2 ]; then
                echo "No email given"
        else
                if [ -z $3 ]; then
                        echo "No password given"
                else
                        if [ -z $4 ]; then
                                mysql GlowWeb -e "insert into Users (Usr,EMAIL,Password,Admin) values ('${1}','${2}','${3}',0);"
                        else
                                mysql GlowWeb -e "insert into Users (Usr,EMAIL,Password,Admin) values ('${1}','${2}','${3}',1)"
                        fi
                fi
        fi
fi
