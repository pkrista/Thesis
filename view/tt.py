#!/usr/bin/python
import sys
import os
from binascii import b2a_hex
###
### pdf-miner requirements
###
from pdfminer.pdfparser import PDFParser
from pdfminer.pdfdocument import PDFDocument, PDFNoOutlines
from pdfminer.pdfpage import PDFPage
from pdfminer.pdfinterp import PDFResourceManager, PDFPageInterpreter
from pdfminer.converter import PDFPageAggregator
from pdfminer.layout import LAParams
from pdfminer.layout import LTTextBox
from pdfminer.layout import LTTextLine
from pdfminer.layout import LTFigure
from pdfminer.layout import LTChar
from pdfminer.layout import LTImage

from pdfminer.layout import LTCurve
from pdfminer.layout import LTRect
from pdfminer.layout import LTLine


import png

###
### To extract images
###
def write_file (folder, filename, filedata, flags='w'):
    """Write the file data to the folder and filename combination
    (flags: 'w' for write text, 'wb' for write binary, use 'a' instead of 'w' for append)"""
    result = False
    if os.path.isdir(folder):
        try:
            file_obj = open(os.path.join(folder, filename), flags)
            file_obj.write(filedata)
            file_obj.close()
            result = True
        except IOError:
            pass
    return result

def write_png (folder, filename, image, flags='w'):
    result = False
    if os.path.isdir(folder):
        try:
            (width, height) = image.srcsize
            w = png.Writer(width, height)
            file_obj = open(os.path.join(folder, filename), flags)
            image_data = list(image.stream.get_data())
            rgb = [map(ord, image_data[3 * i * width:3 * (i+1) * width]) for i in range(height)]
            w.write(file_obj, rgb)
            file_obj.close()
            result = True
        except IOError:
            pass
    return result

def determine_image_type (stream_first_4_bytes):
    """Find out the image file type based on the magic number comparison of the first 4 (or 2) bytes"""
    file_type = None
    bytes_as_hex = b2a_hex(stream_first_4_bytes)
    if bytes_as_hex.startswith('ffd8'):
        file_type = '.jpeg'
    elif bytes_as_hex == '89504e47':
        file_type = '.png'
    elif bytes_as_hex == '47494638':
        file_type = '.gif'
    elif bytes_as_hex.startswith('424d'):
        file_type = '.bmp'
    return file_type

def save_image (lt_image, page_number, images_folder):
    """Try to save the image data from this LTImage object, and return the file name, if successful"""
    result = None
    if lt_image.stream:
        print lt_image.imagemask
        print ' something '
        file_stream = lt_image.stream.get_rawdata()
        if file_stream:
            file_ext = determine_image_type(file_stream[0:4])
            if file_ext:
                file_name = ''.join([str(page_number), '_', lt_image.name, file_ext])
                if write_file(images_folder, file_name, file_stream, flags='wb'):
                    result = file_name
            else:
                file_name = ''.join([str(page_number), '_', lt_image.name, '.png'])
                if write_png(images_folder, file_name, lt_image, flags='wb'):
                    result = file_name
    return result

def save_lt_images (lt_obj, page_number, images_folder):
    saved_images = []
    if isinstance(lt_obj, LTImage):
        print ' Saving LTImage '
        #writer = ImageWriter(images_folder)
        #saved_file = writer.export_image(lt_obj)
        saved_file = save_image(lt_obj, page_number, images_folder)
        if saved_file:
            print ' ok '
            saved_images.append(os.path.join(images_folder, saved_file))
        else:
            print ' not ok '
    elif isinstance(lt_obj, LTFigure):
        print ' Saving LTFigure '
        for x in lt_obj:
            saved_images.extend(save_lt_images(x, page_number, images_folder))
        print ' Saved LTFigure '
    return saved_images


###
### Extracting Text
###
def to_bytestring (s, enc='utf-8'):
    """Convert the given unicode string to a bytestring, using the standard encoding,
    unless it's already a bytestring"""
    if s:
        if isinstance(s, str):
            return s
        else:
            return s.encode(enc)

def update_page_text_hash (h, lt_obj, pct=0.2):
    """Use the bbox x0,x1 values within pct% to produce lists of associated text within the hash"""
    x0 = lt_obj.bbox[0]
    x1 = lt_obj.bbox[2]
    key_found = False
    for k, v in h.items():
        hash_x0 = k[0]
        if x0 >= (hash_x0 * (1.0-pct)) and (hash_x0 * (1.0+pct)) >= x0:
            hash_x1 = k[1]
            if x1 >= (hash_x1 * (1.0-pct)) and (hash_x1 * (1.0+pct)) >= x1:
                # the text inside this LT* object was positioned at the same
                # width as a prior series of text, so it belongs together
                key_found = True
                v.append(to_bytestring(lt_obj.get_text()))
                h[k] = v
    if not key_found:
        # the text, based on width, is a new series,
        # so it gets its own series (entry in the hash)
        h[(x0,x1)] = [to_bytestring(lt_obj.get_text())]
    return h

###
### Get information ot of LT objects
###

def parse_lt_objs(layout, page_nr, image_folder, text=[]):
    print ''
    


###
### Main function to get, open and get the each pages layout of the pdf file
###
def main():

    pdf_doc = '../uploads/sessionSimonSays.pdf'
    pdf_pwd = ''
    images_folder='../image/'

    # open the pdf file
    fp = open(pdf_doc, 'rb')
    # create a parser object associated with the file object
    parser = PDFParser(fp)
    # create a PDFDocument object that stores the document structure
    doc = PDFDocument(parser, pdf_pwd)
    # connect the parser and document objects
    parser.set_document(doc)

    rsrcmgr = PDFResourceManager()
    laparams = LAParams()
    device = PDFPageAggregator(rsrcmgr, laparams=laparams)
    interpreter = PDFPageInterpreter(rsrcmgr, device)
    
    text = []
    for i, page in enumerate(PDFPage.create_pages(doc)):
        interpreter.process_page(page)
        print '</br></br>'
        
        # receive the LTPage object for this page
        layout = device.get_result()
        print ' New Page ' + str(i)
        
        text_content = []
        page_text = {}
        
        for lt_obj in layout:
            if isinstance(lt_obj, LTFigure) or isinstance(lt_obj, LTImage):
                print ' LTFigure ' if isinstance(lt_obj, LTFigure) else ' LTImage '
                saved_file = save_lt_images(lt_obj, i, images_folder)
                # an image, so save it to the designated folder, and note its place in the text
    #            saved_file = save_image(lt_obj, page_number, images_folder)
                if saved_file:
                # use html style <img /> tag to mark the position of the image within the text
                    text_content.append('img src="'+str(saved_file)+'" /')

                else:
                    print >> sys.stderr, "error saving image on page", page_number, lt_obj.__repr__
            elif isinstance(lt_obj, LTTextBox):
                # text, so arrange is logically based on its column width
    #            page_text = update_page_text_hash(page_text, lt_obj)
                print ' LTTextBox '
                page_text = update_page_text_hash(page_text, lt_obj)
            elif isinstance(lt_obj, LTLine):
                print ' LTLine '
            elif isinstance(lt_obj, LTTextLine):
                print ' LTTextLine '
            elif isinstance(lt_obj, LTTextLine):
                print ' LTTextLine '
            
            elif isinstance(lt_obj, LTRect):
                print ' LTRect '
            elif isinstance(lt_obj, LTChar):
                print ' LTChar '

            elif isinstance(lt_obj, LTCurve):
                print ' LTCurve '
            
            else:
                print ' else '
                
        
#        print page_text
        
#        print text_content

        for k, v in sorted([(key,value) for (key,value) in page_text.items()]):
            # sort the page_text hash by the keys (x0,x1 values of the bbox),
            # which produces a top-down, left-to-right sequence of related columns
            text_content.append(''.join(v))
    
#        print text_content
        tt = '\n'.join(text_content)
        print text_content
        
    text.append(tt)

try:
    main()
except Exception as e:
    print '</br>'
    print e
    print '</br>'