# Real-Time, Machine Learning Approach to Predict Video-QoE for Encrypted Streaming Traffic in 5G Networks

Tools required to stream DASH video content

  - Mininet-wifi https://mininet-wifi.github.io/
  - goDASHBED https://github.com/uccmisl/goDASHbed
  - Caddy Web-server https://caddyserver.com/
  - 5G real traces : 5G cases are available in https://github.com/razaulmustafa852/edc/tree/main/5G-Cases. For Mobility, cases name start with : Driving and for Static, cases name start with Static. For example Driving-1.csv, Static-1.csv
  - XAMPP https://sourceforge.net/projects/xampp/files/XAMPP%20Linux/1.7/. We need xampp (mysql) to store QoS and QoE features in the database. Why? Because each experiment generate 1-QoE log & 1-QoS features. Therefore, save features in mysql and query features according to requirements.

# Steps to make a complete setup
 1. Install Mininet. https://mininet-wifi.github.io/get-started/
 2. In the next step, Install goDASHBED. How to install goDASHBED please follow: https://github.com/uccmisl/goDASHbed
 3. Next you need video. 
 
## Installation

The topology to re-produce same results is named topo.py and stream.py. You can define your requirements in stream.py. Where you can define number of hosts streaming DASH content, ABS algorithm, Server Type (TCP, QUIC), Web-server type etc.
Each time the experiments will create a directory in working location that contains goDASH logs + pcaps. After that please run single_0.5.py to extract QoS features from pcap for every 0.5s slot.

```sh
$ sudo python3 stream.py
```

