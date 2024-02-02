#!/bin/bash


# Make a password
passwd() {
        local length=${1:-"20"}
        cat /dev/urandom | tr -dc A-Za-z0-9~_- | head -c $length
}
