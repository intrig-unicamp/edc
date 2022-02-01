# Machine Learning Assisted Real-time DASH Video QoE Estimation Technique for Encrypted Traffic

Tools required to stream DASH video content

  - Mininet-wifi https://mininet-wifi.github.io/
  - goDASHBED https://github.com/uccmisl/goDASHbed
  - Caddy Web-server https://caddyserver.com/
  - 5G real traces : 5G cases are available in https://github.com/razaulmustafa852/edc/tree/main/5G-Cases. For Mobility, cases name start with : Driving and for Static, cases name start with Static. For example Driving-1.csv, Static-1.csv

# Steps to make a complete setup
 1. Install Mininet. https://mininet-wifi.github.io/get-started/
 2. In the next step, Install goDASHBED. How to install goDASHBED please follow: https://github.com/uccmisl/goDASHbed
 3. Next you need video. You can download videos from http://cs1dev.ucc.ie/misl/4K_non_copyright_dataset/. You will find 2,4,6,8,10 second segment size. You can recursively download file from FTP server on LINUX (Ubuntu 18.04) using command wget -r -np -R "index.html*" http://cs1dev.ucc.ie/misl/4K_non_copyright_dataset/2_sec/x264/bbb/DASH_Files/full/
 4. Once you downlaod the file, move all files to /var/www/html in Ubuntu
 5. Now run https://github.com/razaulmustafa852/edc/blob/main/topology_bash.py with command : sudo python3 topology_bash.py. In this file there many parameters you need to set, please set ABS, Case and Protocol, Server and Mode i,e 5G. However you can also play with 3G and 4G.
 6. In https://github.com/razaulmustafa852/edc/blob/main/topology.py. There are many functions where path is given to store pcaps & goDASHBED logs. Please change all path according to your system.
 7. Each experiment generate 1-pcap and 1-goDASHBED logs. 
 8. To extract QoS features from pcap use script: https://github.com/razaulmustafa852/edc/blob/main/QoS-MHV-2022.ipynb

# Single VM for all these steps
 - https://drive.google.com/file/d/14fyG88dO9LthucnSw19_5QYyijtoFh17/view?usp=sharing
