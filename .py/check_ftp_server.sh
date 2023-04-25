#!/bin/sh

ftp_server="$(ifconfig | grep "inet " | grep -Fv 127.0.0.1 | awk '{print $2}'| head -n 2 |tail -n 1)"
ftp_port="5555"

echo "Checking if FTP server is accessible..."
nc -zv -w 5 $ftp_server $ftp_port > /dev/null 2>&1

# Check exit status of nc command
if [ $? -eq 0 ]; then
    echo "FTP server is accessible on $ftp_server:$ftp_port"
else
    echo "FTP server is not accessible on $ftp_server:$ftp_port"
fi

