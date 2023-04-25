from flask import Flask, render_template_string
from pyftpdlib import servers
from pyftpdlib.handlers import FTPHandler
import os
import socket
import subprocess

output = subprocess.check_output("ifconfig | grep 'inet ' | grep -Fv 127.0.0.1 | awk '{print $2}' | head -n 2| tail -n 1", shell=True)
output_str = output.decode()


app = Flask(__name__)


IPAddr = output_str.strip()
# Template string for index page
index_template = '''
<!DOCTYPE html>
<html>
<head>
    <title>File List</title>
    <style>
     .result-box {
            margin-top: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
        }
    </style>
    <script>
        function callAPI(apiType, filename) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var resultBox = document.getElementById('result-box');
                    resultBox.textContent = xhr.responseText;
                    resultBox.style.display = 'block';
                }
            };
            xhr.open('GET', '/' + apiType + '/' + filename, true);
            xhr.send();
        }
    </script>
</head>
<body>
    <h1>File List</h1>
    <table>
        <tr>
            <th>Filename</th>
            <th>Size (bytes)</th>
            <th>Links</th>
        </tr>
        {% for file in files %}
        <tr>
            <td>{{ file.filename }}</td>
            <td>{{ file.size }}</td>
            <td>
            <!--
                <button onclick="showLinks('{{ file.filename }}')">Show Links</button>
                -->
                <button onclick="callAPI('ftp', '{{ file.filename }}')">Show FTP Link</button>
                <button onclick="callAPI('http', '{{ file.filename }}')">Show HTML Link</button>


            <!--
                <div id="file-link-box-{{ file.filename }}" class="file-link-box"></div>
            -->
            </td>
        </tr>
        {% endfor %}
    </table>
            <div id="result-box" class="result-box"></div>
</body>
</html>
'''


@app.route('/')
def index():
    # Get list of files in /public folder
    files = []
    for filename in os.listdir('public'):
        file_path = os.path.join('public', filename)
        if os.path.isfile(file_path):
            size = os.path.getsize(file_path)
            files.append({'filename': filename, 'size': size})

    return render_template_string(index_template, files=files)


@app.route('/ftp/<filename>')
def ftp(filename):
    # Generate the FTP link using the IP address
    ftp_link = f'ftp://{IPAddr}:5555/{filename}'
    return ftp_link


@app.route('/http/<filename>')
def http(filename):
    # Generate the HTTP link using the IP address
    http_link = f'http://{IPAddr}:5656/{filename}'
    return http_link


def run_ftp_server():
    handler = FTPHandler
    handler.authorizer = servers.DummyAuthorizer()
    handler.authorizer.add_anonymous('/public', perm='elradfmwMT')
    handler.banner = "FTP Server"
    handler.masquerade_address = IPAddr
    handler.passive_ports = range(60000, 65535)

    server = servers.FTPServer(('0.0.0.0', 5555), handler)
    server.serve_forever()


if __name__ == '__main__':
    app.run(debug=True, port=5656)




