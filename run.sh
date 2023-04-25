#!/bin/sh
ip="$(ifconfig | grep -A2 wlan0 | tail -n 2|awk '{print $2}' | head -n 1)"
#ip="192.168.100.2"
port="80"


api_android="k-ee5dfbaf1714"
api_ios="xxxx"

link="http://$ip:$port"
datee=$(date "+%Y_%m_%d_%H:%M")

echo "Notifications sending"


#Android Push notfications 
curl http://xdroid.net/api/message\?k\=$api_android\&t\=MOVIE+PHP+SERVER+READY\&c\=$datee+$link\&u\=$link 

#iOS Push notfications 
#curl https://api.simplepush.io/send -d '{"key":"'"$api_ios"'", "msg":"'"LOGOUT_$host"'"}'

echo "\nNotifications sent\n"

echo "\n"
echo "Starting php server on :\nIP : [ $ip ] \nPORT : [ $port ]"
php -S $ip:$port -t server
