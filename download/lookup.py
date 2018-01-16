#!/usr/bin/env python3

import sys, threading, time, os, urllib, re, requests
from html.parser import HTMLParser
from urllib import request
from bs4 import BeautifulSoup

# HEADER CONF
headers = {
        'User-Agent': 'Mozilla/5.1 (Macintosh; Intel Mac OS X 10.9; rv:43.0) Gecko/20100101 Firefox/43.0'
      }

# FILE TO WRITE
fileOutput = open('output.html', 'w')

# FILE TO READ
fileInput = open('input.txt', 'r')

# PARSING FUNCTION
def emailLookup(line):
	try:
		domain_zone = re.search(".+\.(\w{2,5})", line)
		domain_name = re.search("([a-z0-9\-]+\.[a-z]{2,6})", line)
		if domain_zone.group(1) == "by":
			r = requests.get("http://cctld.by/check/?domain="+domain_name.group(1), headers = headers)
			data = BeautifulSoup(r.text)
			getSpan = data.find_all('span')
			findEmail = re.compile("<span>(\D+[-a-z0-9]+\@.+?\.\w{2,5})</span>").search(str(getSpan))
		else:
			r = requests.get("http://www.freewhois.us/index.php?query="+domain_name.group(1)+"&submit=Whois", headers = headers)
			data = BeautifulSoup(r.text)
			getAhref = data.find_all('a')
			findEmail = re.compile('([-a-z0-9]+\@.+?\.\w{2,5})').search(str(getAhref))
		fileOutput.write("<li>"+domain_name.group(1)+" ; "+findEmail.group(1)+"</li>")
	except Exception as e:
		print(e)

# BEGIN PARSING (THREADS)
with fileInput as file:
	for line in file:
		t = threading.Thread(target=emailLookup, args=(line,))
		t.start()
		time.sleep(0.3)