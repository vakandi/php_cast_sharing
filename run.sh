#!/bin/sh
ip="$(ifconfig | grep -A2 wlan0 | tail -n 2|awk '{print $2}' | head -n 1)"
#ip="192.168.100.2"
port="80"
api_android="k-ee5dfbaf1714"
link="http://$ip:$port"
datee=$(date "+%Y_%m_%d_%H:%M")

echo "Notifications sending"
curl http://xdroid.net/api/message\?k\=$api_android\&t\=MOVIE+PHP+SERVER+READY\&c\=$datee+$link\&u\=$link 
echo "\n\n"
echo "Notifications sent"
echo "Starting php server on :\nIP : [ $ip ] \nPORT : [ $port ]"
php -S $ip:$port -t server
