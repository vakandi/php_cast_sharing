#!/bin/bash
ip="$(ifconfig | grep -A2 wlan0 | tail -n 2|awk '{print $2}' | head -n 1)"
#ip="192.168.100.2"
port="80"


api_android="k-ee5dfbaf1714"
api_ios="xxxx"

link="http://$ip:$port"
datee=$(date "+%Y_%m_%d_%H:%M")

echo -e "\033[1;34m Do you want to use this folder below as the shared folder ?\033[0m"
echo -e "\033[1;33m /home/$USER/Videos  ?\033[0m"
echo -e "\033[1;36m Type 'y' or 'n' and press ENTER\033[0m"
read automatic_folder
if [ "$automatic_folder" == "y" ]; then
        rm -rf server/public
        ln -s /home/$USER/Videos server/public
        echo -e "\033[1;34m The folders links has been made\033[0m"
elif [ "$automatic_folder" == "n" ]; then
        echo -e "\033[1;34m Enter the path folder you want to share and type ENTER\n\033[0m"
        read choice
        if [ -z $choice ]; then
                echo -e "Choice empty.. re-run the script"
                exit
        else
                rm -rf server/public
                ln -s $choice server/public
        fi
fi

echo "Notifications sending"
#Android Push notfications 
curl http://xdroid.net/api/message\?k\=$api_android\&t\=MOVIE+PHP+SERVER+READY\&c\=$datee+$link\&u\=$link 

#iOS Push notfications 
#curl https://api.simplepush.io/send -d '{"key":"'"$api_ios"'", "msg":"'"LOGOUT_$host"'"}'

echo "\nNotifications sent\n"

echo "\n"
echo "Starting php server on :\nIP : [ $ip ] \nPORT : [ $port ]"
php -S $ip:$port -t server

