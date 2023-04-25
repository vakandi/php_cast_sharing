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
- The script will send a notification using the XDroid API with a message indicating that the PHP server is ready, along with the server's IP address and port.
- The PHP server will start on the specified IP address and port.


<img src="/.jpg/2.jpg" alt="Index Server" title="Index Server">
<img src="/.jpg/1.jpg" alt="Index Server" title="Index Server">
