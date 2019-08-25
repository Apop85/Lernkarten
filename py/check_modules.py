#!/usr/bin/env python3
# -*- coding:utf-8 -*-

####
# File: check_modules.py
# Project: py
#-----
# Created Date: Sunday 25.08.2019, 19:07
# Author: rbald
#-----
# Last Modified: Sunday 25.08.2019, 19:17
#-----
# Copyright (c) 2019 rbald
# This software is published under the MIT license.
# Check http://www.opensource.org/licenses/MIT for further informations
#-----
# Description: Check if needed python modules where installed
####

output_array = {"docx": 0, "requests": 0, "hashlib": 0, "os": 0, "sys": 0, "re": 0}

try:
    import docx
    output_array["docx"] = 1
except:
    pass

try:
    import requests 
    output_array["requests"] = 1
except:
    pass

try:
    import hashlib
    output_array["hashlib"] = 1
except:
    pass

try:
    import os
    output_array["os"] = 1
except:
    pass

try:
    import sys
    output_array["sys"] = 1
except:
    pass

try:
    import re
    output_array["re"] = 1
except:
    pass

formated_output = ""
for key in output_array.keys():
    formated_output += str(output_array[key])+"?"

print(formated_output)
