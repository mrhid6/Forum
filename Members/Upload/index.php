<?php
//define a maxim size for the uploaded images
define ("MAX_SIZE","1"); 
// define the width and height for the thumbnail
// note that theese dimmensions are considered the maximum dimmension and are not fixed, 
// because we have to keep the image ratio intact or it will be deformed
define ("WIDTH","150"); 
define ("HEIGHT","100"); 
include("functions.php");

$userid=$_GET['userid'];

$mainfolder="../".$userid."/";
$thumbs=$mainfolder."thumbs/";

$thumbs_small=$thumbs."small/";
$thumbs_med=$thumbs."med/";
$thumbs_large=$thumbs."large/";

$errors=0;

$kilobyte = 1024;
$megabyte = $kilobyte * 1024;
$gigabyte = $megabyte * 1024;
$terabyte = $gigabyte * 1024;

// checks if the form has been submitted
if(isset($_POST['Submit'])){
	$image=$_FILES['image']['name'];
	
	if($userid!=0){
		if($image){
			
			$filename=stripslashes($_FILES['image']['name']);
			$extension = strtolower(getExtension($filename));
			$size=getimagesize($_FILES['image']['tmp_name']);
			$sizekb=filesize($_FILES['image']['tmp_name']);
			$imagename=time().'.'.$extension;
			$imagepath=$mainfolder.$imagename;
			$thumbname="thumb_".$imagename;
			
			if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png")){
				$errors=1;
				$errors_text="Unknown File Extension";
			}else{
				if ($sizekb > (MAX_SIZE * $megabyte)){
					$errors=1;
					$errors_text="Image Size:".formatbytes($sizekb,"MB")."<br/>Max Size:".formatbytes((MAX_SIZE * $megabyte),"MB")."<br/> You have exceeded the size limit!";
				}else{
					if(!is_dir($mainfolder)){
						$errors=1;
						$errors_text="Folders Could Not Be Located!";
					}else{
						$copied = copy($_FILES['image']['tmp_name'], $imagepath);
						if(!$copied){
							$errors=1;
							$errors_text="Image Could Not Be Copied!";
						}else{
							if(!is_dir($thumbs)){mkdir($thumbs, 0777);}
							
							if(!is_dir($thumbs_small)){mkdir($thumbs_small, 0777);}
							if(!is_dir($thumbs_med)){mkdir($thumbs_med, 0777);}
							if(!is_dir($thumbs_large)){mkdir($thumbs_large, 0777);}
								
							$new_thumb_small=make_thumb($imagepath,$thumbs_small.$thumbname,60,60);
							$new_thumb_med=make_thumb($imagepath,$thumbs_med.$thumbname,120,120);
							$new_thumb_large=make_thumb($imagepath,$thumbs_large.$thumbname,140,140);
							
						}
					}
				}
			}
			
		}else{
			$errors=1;
			$errors_text="No Image Has Been Selected!";
		}
	}else{
		$errors=1;
		$errors_text="Missing UserId Value!";
	}
}

if($errors>0){
	echo"<h3>".ucwords($errors_text)."</h3>";
}

//If no errors registred, print the success message and show the thumbnail image created
if(isset($_POST['Submit']) && !$errors) {
	echo "<h3>Thumbnail created Successfully!</h3>";
	echo 'Small: <img src="'.$thumbs_small.$thumbname.'"/><br/>';
	echo 'Medium: <img src="'.$thumbs_med.$thumbname.'"/><br/>';
	echo 'Large: <img src="'.$thumbs_large.$thumbname.'"/><br/>';
}

?>
<form name="newad" method="post" enctype="multipart/form-data" action="">
<table>
<tr><td><input type="file" name="image" style="border:1px solid #000;"></td></tr>
<tr><td><input name="Submit" type="submit" value="Upload image"></td></tr>
</table>	
</form>