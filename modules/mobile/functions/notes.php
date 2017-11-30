<?php
require_once("../../../classes/Constants.php");
require_once("../../../classes/DBConnect.php");
require_once("../../manage_notes/classes/Notes.php");
require_once("../../manage_student/classes/Student.php");

$dbconnect=new DBConnect(Constants::SERVER_NAME,
						Constants::DB_USERNAME,
						Constants::DB_PASSWORD,
						Constants::DB_NAME);

// $course_id=1; // To be sent via app
$course_id=$_REQUEST['course_id'];

$notes=new Notes($dbconnect->getInstance());

$getNotes=$notes->getNotes($course_id);

$json=array();
$notes_array=array();
$final=array();

if($getNotes!=null)
{
	$final['status']="success";

	while($row=$getNotes->fetch_assoc())
	{
		$notes_array['name']=$row['name'];
		$notes_array['title']=$row['title'];
		$notes_array['file']=$row['file'];
		$notes_array['size']=formatSizeUnits(filesize("../../manage_notes/function/".$row['file']));
		$notes_array['type']=pathinfo("../../manage_notes/function/".$row['file'],PATHINFO_EXTENSION);

		if ($notes_array['type']==="pdf") {
			# code...
			$notes_array['pages']=pageCountPDF("../../manage_notes/function/".$row['file']);
		}elseif ($notes_array['type']==="docx" || $notes_array['type']==="doc") {
			# code...
			$notes_array['pages']=pageCountDOCX("../../manage_notes/function/".$row['file']);
		}elseif ($notes_array['type']==="pptx") {
			# code...
			$notes_array['pages']=pageCountPPTX("../../manage_notes/function/".$row['file']);
		}else{
			$notes_array['pages']="error";
		}

		$json[]=$notes_array;
	}

	$final['notes']=$json;
}
else
{
	$final['status']="fail";
}

function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
}

function pageCountDOCX($file) {
    $pageCount = 0;

    $zip = new ZipArchive();

    if($zip->open($file) === true) {
        if(($index = $zip->locateName('docProps/app.xml')) !== false)  {
            $data = $zip->getFromIndex($index);
            $zip->close();
            $xml = new SimpleXMLElement($data);
            $pageCount = $xml->Pages;
        }
        $zip->close();
    }

    return $pageCount;
}

function pageCountPPTX($file) {
    $pageCount = 0;

    $zip = new ZipArchive();

    if($zip->open($file) === true) {
        if(($index = $zip->locateName('docProps/app.xml')) !== false)  {
            $data = $zip->getFromIndex($index);
            $zip->close();
            $xml = new SimpleXMLElement($data);
            // print_r($xml);
            $pageCount = $xml->Slides;
        }
        $zip->close();
    }

    return $pageCount;
}

function pageCountPDF($filepath){
    $fp = @fopen(preg_replace("/\[(.*?)\]/i", "",$filepath),"r");
    $max=0;
    while(!feof($fp)) {
            $line = fgets($fp,255);
            if (preg_match('/\/Count [0-9]+/', $line, $matches)){
                    preg_match('/[0-9]+/',$matches[0], $matches2);
                    if ($max<$matches2[0]) $max=$matches2[0];
            }
    }
    fclose($fp);
    if($max==0){
        $im = new imagick($filepath);
        $max=$im->getNumberImages();
    }

    return $max;
}

header("Content-Type: application/json");
echo "[".json_encode($final)."]";
?>