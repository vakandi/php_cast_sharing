#!/bin/bash

# Install Python3 and pip3
apt-get update
apt-get install -y python3 python3-pip

# Install Flask and pyftpdlib Python packages
pip3 install flask pyftpdlib

