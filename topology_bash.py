import os
import sys
import subprocess
mode=['5g'] #network type '5g','3g','4g'
host=[1] # number of host
algo=['elastic','bba','conventional'] # ABS
net5=['Driving-8', 'Driving-9','Driving-10'] # 5G Cases
prot=['tcp'] # Protocol TCP
sertype=['WSGI']
count = ['1','2','3','4','5'] # Experiments repetition
for curr in count:
    for md in mode:
        if md == '5g':
           for i in net5:
               #for j in doc5:
                   for k in sertype:
                       for l in host:
                           for m in algo:
                                for p in prot:
                                    clear = 'sudo mn -c'
                                    test3 = 'sudo python3 test3.py '+ str(md)+ ' ' + str(i) + ' ' + str(l)+ ' ' + str(m)+ ' ' + str(p)+ ' ' + str(k)+ ' ' + str(curr)
                                    subprocess.run(clear.split(' '))
                                    print(test3)
                                    subprocess.run(test3.split(' '))
        elif md =='4g':
            for i in net4:
               #for j in doc4:
                   for k in sertype:
                       for l in host:
                           for m in algo:
                               for p in prot:
                                    clear = 'sudo mn -c'
                                    test3 = 'sudo python test3.py '+ str(md)+ ' ' + str(i) + ' ' + str(l)+ ' ' + str(m)+ ' ' + str(p)+ ' ' + str(k)+ ' ' + str(curr)
                                    subprocess.run(clear.split(' '))
                                    print(test3)
                                    subprocess.run(test3.split(' '))
        else:
            for i in net3:
               #for j in doc3:
                   for k in sertype:
                       for l in host:
                           for m in algo:
                               for p in prot:
                                    clear = 'sudo mn -c'
                                    test3 = 'sudo python test3.py '+ str(md)+ ' ' + str(i) + ' '  + str(l)+ ' ' + str(m)+ ' ' + str(p)+ ' ' + str(k)+ ' ' + str(curr)
                                    subprocess.run(clear.split(' '))
                                    print(test3)
                                    subprocess.run(test3.split(' '))
