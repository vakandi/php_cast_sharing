# PHP Server Cast Sharing


<img src="/.jpg/3.png" alt="Index Server" title="Index Server">
                                                             
                                                             
#### Installation : 
```
{install php}
apt install php
{create a link between the folder public and your movies folder}
ln -s /home/$USER/Videos server/public
```


<img src="/.jpg/4.png" alt="Index Server" title="Index Server">

#### Usage :

```
chmod +x run.sh
./run.sh
```
- The script will send a notification using the Simple Push Notifications API with a message indicating that the PHP server is ready, along with the server's IP address and port and the direct link to the web page so you can cast directly form your smartphone.
- The PHP server will start on the specified IP address and port.


## Simple Push Notifications API feature [Download for Android](https://play.google.com/store/apps/details?id=net.xdroid.pn&hl=en_US&gl=US&pli=1) and [iOS](https://simplepush.io/)
 Just install the apk on your android, and add your api into to the variable "api" in ```run.sh```


<img src="/.jpg/2.jpg" alt="Index Server" title="Index Server">
<img src="/.jpg/1.jpg" alt="Index Server" title="Index Server">
