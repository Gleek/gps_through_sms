from bs4 import BeautifulSoup
from urllib2 import urlopen

import _mysql,MySQLdb

html = urlopen("http://www.justdial.com/Delhi-NCR/fabric-%3Cnear%3E-lagpat-nagar").read()
soup = BeautifulSoup(html, "lxml")
market="lajpat"

val = soup.findAll("section", "jbc")

add=[]
for a in val:
    str1= a.find('p')
    v=str(str1).split('|')
    abc = str(v[0])
    abc=abc.replace("<p>"," ")
    abc=abc.replace("\t"," ")
    add.append(abc)


val =soup.findAll("span","jcn")

name =[]
for a in val:

    str1= a.find('a').string
    name.append(str1)

count =0
for i in name :
    print i , add[count]
    connection = MySQLdb.connect('makemylibrary.co.in', 'thinkdif', 'kgggdkp1992', 'thinkdif_peerhack')
    x = connection.cursor()
    try:
        q= "INSERT INTO `market`(`market`, `keyword`, `text`) VALUES ('"+str(market)+"','fabric','"+str(i)+str(add[count])+"')"
        print q
        x.execute(q)
        connection.commit()
    except Exception as e :
        print e
        connection.rollback()
    connection.close()
    count =count +1

