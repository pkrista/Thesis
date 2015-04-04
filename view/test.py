#! /usr/bin/python

# To change this license header, choose License Headers in Project Properties.
# To change this template file, choose Tools | Templates
# and open the template in the editor.

import sys

from pdfminer.pdfparser import PDFParser
from pdfminer.pdfdocument import PDFDocument
from pdfminer.pdfpage import PDFPage
#from pdfminer.pdfpage import PDFTextExtractionNotAllowed
#from pdfminer.pdfdevice import PDFDevice

from pdfminer.pdfinterp import PDFResourceManager, PDFPageInterpreter
from pdfminer.converter import TextConverter
from pdfminer.layout import LAParams
from pdfminer.pdfpage import PDFPage
from cStringIO import StringIO

#from pdfminer.layout import LTTextBox, LTTextLine, LTFigure, LTImage

__author__ = "Krista"
__date__ = "$2015.19.3 23:48:14$"

#Password is empty
password = ''
path = sys.argv[1]

print path

# Open a PDF file.
fp = open(path, 'rb')
# Create a PDF parser object associated with the file object.
parser = PDFParser(fp)
# Create a PDF document object that stores the document structure.
# Supply the password for initialization.
document = PDFDocument(parser, password)
# Check if the document allows text extraction. If not, abort.
if not document.is_extractable:
    raise PDFTextExtractionNotAllowed
# Create a PDF resource manager object that stores shared resources.
rsrcmgr = PDFResourceManager()
retstr = StringIO()
codec = 'ascii'
laparams = LAParams()
# Create a PDF device object.
device = TextConverter(rsrcmgr, retstr, codec=codec, laparams=laparams)
# Create a PDF interpreter object.
interpreter = PDFPageInterpreter(rsrcmgr, device)
# Process each page contained in the document.

devicee = PDFPageAggregator(rsrcmgr, laparams=laparams)

maxpages = 0
caching = True
pagenos=set()

for page in PDFPage.get_pages(fp, pagenos, maxpages=maxpages, password=password,caching=caching, check_extractable=True):
    interpreter.process_page(page)
    data =  retstr.getvalue()
    layout = devicee.get_result()
    
for i, page in enumerate(PDFPage.create_pages(document)):
        interpreter.process_page(page)
        # receive the LTPage object for this page
        layout = device.get_result()
        print ' New Page ' + str(i)

#fp.close()
#device.close()
#retstr.close()
    
print data
print 'yoylo'


