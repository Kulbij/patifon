<?php
/*
Uploadify v2.1.4
Release Date: November 8, 2010

Copyright (c) 2010 Ronnie Garcia, Travis Nickels

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
*/
/*if (!empty($_FILES)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $_REQUEST['folder'] . '/';
	$targetFile =  str_replace('//','/',$targetPath) . $_FILES['Filedata']['name'];
	
	// $fileTypes  = str_replace('*.','',$_REQUEST['fileext']);
	// $fileTypes  = str_replace(';','|',$fileTypes);
	// $typesArray = split('\|',$fileTypes);
	// $fileParts  = pathinfo($_FILES['Filedata']['name']);
	
	// if (in_array($fileParts['extension'],$typesArray)) {
		// Uncomment the following line if you want to make the directory if it doesn't exist
		// mkdir(str_replace('//','/',$targetPath), 0755, true);
		
		move_uploaded_file($tempFile,$targetFile);
		echo str_replace($_SERVER['DOCUMENT_ROOT'],'',$targetFile);
	// } else {
	// 	echo 'Invalid file type.';
	// }
}*/

function generate($tf) {
	 return md5(md5(date("l dS of F Y h:I:s A")).md5($tf));
     
     }
function getExt($name) {
        $p = '';
        $ext = strtolower(substr(strrchr($name,'.'), 1));

    switch (true)
    {
        case in_array($ext, array('jpeg','jpe','jpg')):
        {
            $p = 'jpeg';
            break;
        }
        case ($ext=='gif'):
        {
            $p = 'gif';
            break;
        }
        case ($ext=='png'):
        {
            $p = 'png';
            break;
        }
    }

    return  '.' .$p;
    }
  
if (!empty($_FILES))
{
    
    $tempFile = $_FILES['Filedata']['tmp_name'];

    if (empty($tempFile)) {
        header('Content-Type: text/html; charset=utf-8');
        echo '';
    }
    
    //FOR TEST;
    $for_test_string = (isset($_POST['test_add']) ? $_POST['test_add'] : '');
    if (!empty($for_test_string) && ($pos = strpos($_SERVER['DOCUMENT_ROOT'], $for_test_string)) === false) $_SERVER['DOCUMENT_ROOT'] = $_SERVER['DOCUMENT_ROOT'].$for_test_string;

    $targetPath = $_SERVER['DOCUMENT_ROOT'] . $_REQUEST['folder'] . '/';

    $filename = generate($_FILES['Filedata']['name']).getExt($_FILES['Filedata']['name']);
    $targetFile = str_replace('//','/',$targetPath) . $filename;
    move_uploaded_file($tempFile,$targetFile);
    
    header('Content-Type: text/html; charset=utf-8');

    echo ltrim($_REQUEST['folder'], '/').'/'.$filename;
}