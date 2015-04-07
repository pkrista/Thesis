#! /usr/bin/python

# To change this license header, choose License Headers in Project Properties.
# To change this template file, choose Tools | Templates
# and open the template in the editor.

import sys

from pdfminer.pdfparser import PDFParser
from pdfminer.pdfdocument import PDFDocument
from pdfminer.pdfpage import PDFPage
#from pdfminer.pdfpage import PDFTextExtractionNotAllowed
from pdfminer.pdfinterp import PDFResourceManager
from pdfminer.pdfinterp import PDFPageInterpreter
#from pdfminer.pdfdevice import PDFDevice

from pdfminer.pdfinterp import PDFResourceManager, PDFPageInterpreter
from pdfminer.converter import TextConverter
from pdfminer.layout import LAParams
from pdfminer.pdfpage import PDFPage
from cStringIO import StringIO

__author__ = "Krista"
__date__ = "$2015.15.3 23:19:02$"

#print "Hello World"
#print "The passed arguments are ", sys.argv[1]

#Password is empty
password = ''

#this is link to pdf passed from php
path = sys.argv[1]

fp = file(path, 'rb')
    
fp = open(sys.argv[1], 'rb')
    
parser = PDFParser(fp)
    
# Create a PDF document object that stores the document structure
document = PDFDocument(parser, password)
    
# Define parameters to the PDF device objet 
rsrcmgr = PDFResourceManager()
retstr = StringIO()
codec = 'utf-8'
laparams = LAParams()
    
# Create a PDF device object
device = TextConverter(rsrcmgr, retstr, codec=codec, laparams=laparams)
    
# Create a PDF interpreter object
interpreter = PDFPageInterpreter(rsrcmgr, device)
#    password = ""
maxpages = 0
caching = True
pagenos=set()

# Process each page contained in the document
for page in PDFPage.get_pages(fp, pagenos, maxpages=maxpages, password=password,caching=caching, check_extractable=True):
    interpreter.process_page(page)
    data =  retstr.getvalue()
#        layout = device.get_result()
        
fp.close()
device.close()
retstr.close()
    
print data

    


