#!/usr/bin/env python3
# -*- coding:utf-8 -*-

####
# File: get_version.py
# Project: py
#-----
# Created Date: Sunday 25.08.2019, 13:55
# Author: rbald
#-----
# Last Modified: Sunday 25.08.2019, 18:27
#-----
# Copyright (c) 2019 rbald
# This software is published under the MIT license.
# Check http://www.opensource.org/licenses/MIT for further informations
#-----
# Description: Crawls github to get newest version number
# Python Requirements: requests
####
try:
    import re, requests
except:
    print("<div class='output_message error'>Fehlendes Pythonmodul: requests</div>")
    exit()

web_link = "https://raw.githubusercontent.com/Apop85/Lernkarten/master/conf/version.php"

try:
    web_content = requests.get(web_link)
    web_content = web_content.text
    
    version_line=web_content.split('\n')[1]
    version_pattern = re.compile(r'current_version="(.*)"')
    version = version_pattern.findall(version_line)[0]
    print(version, end="")
except:
    print("NC", end="")
