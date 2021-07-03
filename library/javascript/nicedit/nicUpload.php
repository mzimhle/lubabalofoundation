<?php

/* Add this on all pages on top. */
set_include_path($_SERVER['DOCUMENT_ROOT'].'/'.PATH_SEPARATOR.$_SERVER['DOCUMENT_ROOT'].'/library/classes/');

/* NicEdit - Micro Inline WYSIWYG
 * Copyright 2007-2009 Brian Kirchoff
 *
 * NicEdit is distributed under the terms of the MIT license
 * For more information visit http://nicedit.com/
 * Do not remove this copyright message
 *
 * nicUpload Reciever Script PHP Edition
 * @description: Save images uploaded for a users computer to a directory, and
 * return the URL of the image to the client for use in nicEdit
 * @author: Brian Kirchoff <briankircho@gmail.com>
 * @sponsored by: DotConcepts (http://www.dotconcepts.net)
 * @version: 0.9.0
 */


define('NICUPLOAD_PATH', $_SERVER['DOCUMENT_ROOT'].'/media/upload/'); // Set the path (relative or absolute) to
 // the directory to save image files
                                      
define('NICUPLOAD_URI', 'http://'.$_SERVER['HTTP_HOST'] .'/media/upload');   // Set the URL (relative or absolute) to
// the directory defined above

$nicupload_allowed_extensions = array('jpg','jpeg','png','gif','bmp');

// You should not need to modify below this line

$rfc1867 = function_exists('apc_fetch') && ini_get('apc.rfc1867');

if(!function_exists('json_encode')) {
    die('{"error" : "Image upload host does not have the required dependicies (json_encode/decode)"}');
}

$id = $_POST['APC_UPLOAD_PROGRESS'];
if(empty($id)) {
    $id = $_GET['id'];
}

if($_SERVER['REQUEST_METHOD']=='POST') { // Upload is complete
    if(empty($id) || !is_numeric($id)) {
        nicupload_error('Invalid Upload ID');
    }
    if(!is_dir(NICUPLOAD_PATH) || !is_writable(NICUPLOAD_PATH)) {
        nicupload_error('Upload directory '.NICUPLOAD_PATH.' must exist and have write permissions on the server');
    }
    
    $file = $_FILES['nicImage'];
    $image = $file['tmp_name'];
    
    $max_upload_size = ini_max_upload_size();
    if(!$file) {
        nicupload_error('Must be less than '.bytes_to_readable($max_upload_size));
    }
    
    $ext = strtolower(substr(strrchr($file['name'], '.'), 1));
    @$size = getimagesize($image);
    if(!$size || !in_array($ext, $nicupload_allowed_extensions)) {
        nicupload_error('Invalid image file, must be a valid image less than '.bytes_to_readable($max_upload_size));
    }
    
    /* $filename = $id.'.'.$ext; */
	$filename = md5($id.rand(100000,100000000)).'.'.$ext;
    $path = NICUPLOAD_PATH.'/'.$filename;
    
    if(!move_uploaded_file($image, $path)) {
        nicupload_error('Server error, failed to move file');
    }
    
    if($rfc1867) {
        $status = apc_fetch('upload_'.$id);
    }
    if(!isset($status)) {
        $status = array();
    }
    $status['done'] = 1;
    $status['width'] = $size[0];
    $status['url'] = nicupload_file_uri($filename);
	
    if($rfc1867) {
        apc_store('upload_'.$id, $status);
    }
	
	if((int)$status['width'] == 0) {
		$status['width'] = 150;
	}
	
    nicupload_output($status, $rfc1867);
	
    exit;
}

// UTILITY FUNCTIONS

function nicupload_error($msg) {
    echo nicupload_output(array('error' => $msg)); 

}

function nicupload_output($status, $showLoadingMsg = false) {
    $script = '
        try {
            '.(($_SERVER['REQUEST_METHOD']=='POST') ? 'top.' : '').'nicUploadButton.statusCb('.json_encode($status).');
        } catch(e) { alert(e.message); }
    ';
    
    if($_SERVER['REQUEST_METHOD']=='POST') {
        echo '<script>'.$script.'</script>';
    } else {
        echo $script;
    }
    
    if($_SERVER['REQUEST_METHOD']=='POST' && $showLoadingMsg) {      

echo <<<END
    <html><body>
        <div id="uploadingMessage" style="text-align: center; font-size: 14px;">
            <img src="/images/ajax-loader.gif" style="float: right; margin-right: 40px;" />
            <strong>Uploading...</strong><br />
            Please wait
        </div>
    </body></html>
END;

    }
    
    exit;
}

function nicupload_file_uri($filename) {
    return NICUPLOAD_URI.'/'.$filename;
}

function ini_max_upload_size() {
    $post_size = ini_get('post_max_size');
    $upload_size = ini_get('upload_max_filesize');
    if(!$post_size) $post_size = '8M';
    if(!$upload_size) $upload_size = '2M';
    
    return min( ini_bytes_from_string($post_size), ini_bytes_from_string($upload_size) );
}

function ini_bytes_from_string($val) {
    $val = trim($val);
    $last = strtolower($val[strlen($val)-1]);
    switch($last) {
        // The 'G' modifier is available since PHP 5.1.0
        case 'g':
            $val *= 1024;
        case 'm':
            $val *= 1024;
        case 'k':
            $val *= 1024;
    }
    return $val;
}

function bytes_to_readable( $bytes ) {
    if ($bytes<=0)
        return '0 Byte';
   
    $convention=1000; //[1000->10^x|1024->2^x]
    $s=array('B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB');
    $e=floor(log($bytes,$convention));
    return round($bytes/pow($convention,$e),2).' '.$s[$e];
}

?>
