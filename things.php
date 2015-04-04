<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
    <div>
        <textarea rows="20" cols="100">
        
        <?php
        #one    
        $path = 'uploads/test.pdf';

        $pdf = new pdf( $path );

        $pages = $pdf->get_pages();

        while( list($nr,$page) = each($pages) )
        {
            list($width,$height) = $page->get_dimensions();
            $text = $page->get_text();

            echo "Page $nr is $width x $height and the text is:\n$text\n\n";
        }

        
        #two
        function ExtractTextFromPdf ($pdfdata) {
	if (strlen ($pdfdata) < 1000 && file_exists ($pdfdata)) $pdfdata = file_get_contents ($pdfdata); //get the data from file
	if (!trim ($pdfdata)) echo "Error: there is no PDF data or file to process.";
	$result = ''; //this will store the results
	//Find all the streams in FlateDecode format (not sure what this is), and then loop through each of them
	if (preg_match_all ('/<<[^>]*FlateDecode[^>]*>>\s*stream(.+)endstream/Uis', $pdfdata, $m)) foreach ($m[1] as $chunk) {
		$chunk = gzuncompress (ltrim ($chunk)); //uncompress the data using the PHP gzuncompress function
		//If there are [] in the data, then extract all stuff within (), or just extract () from the data directly
		$a = preg_match_all ('/\[([^\]]+)\]/', $chunk, $m2) ? $m2[1] : array ($chunk); //get all the stuff within []
		foreach ($a as $subchunk) if (preg_match_all ('/\(([^\)]+)\)/', $subchunk, $m3)) $result .= join ('', $m3[1]); //within ()
	}
	else echo "Error: there is no FlateDecode text in this PDF file that I can process.";
	return $result; //return what was found
}

        $ref = ExtractTextFromPdf("uploads/test.pdf");
        echo $ref;
        
//        #third
//        $result = pdf2text ('uploads/test.pdf');
//        
//        echo "<pre>$result</pre>";

        
        
        #fourth
        echo 'fourth';
        

              ?>    
        </textarea> 
    </div>