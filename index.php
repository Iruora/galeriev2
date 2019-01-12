<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Add new image to galery</title>
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
		<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</head>


<body>
	<?php
//include the S3 class              
 
//we'll continue our script from here in step 4!
 
?>
<?php
 if(isset($_GET['add'])){if($_GET['add']==0){echo "<div class='alert alert-success alert-dismissible'>
   <a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
   <strong>Success!</strong> Your image has been successfully added !
 </div>";} else  {echo "<div class='alert alert-danger alert-dismissible'>
   <a href='#'' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
   <strong>Echec!</strong> Error while adding your image !
 </div>";}}
  ?>
<br><br>
<div class="container">
    <div class="row">
        <img src="./assets/N.png" alt="logo" width="100" height="100" class="col-md-offset-5">
    </div>
	<div class="row">
		<form action="" method="POST" enctype="multipart/form-data" class="col-sm-4" style="margin-left:30%" >
		<input type="hidden" name="MAX_FILE_SIZE" value="3000000" />
			<div class="form-group" style="padding:10px">

			<input type="file" class="form-control" name="img" required/>
			<div class="modal-footer">
				<input type="submit" class="btn btn-info" name="submit" style="margin-right:32%;padding-left:30px;padding-right:30px;" value="Add"/>
                <a href="test.php" class="btn btn-warning">Go to galery</a>
			</div>
		    </div>
		</form>
	</div>
</div>
<?php
	//include the S3 class             
	try
	{
		$param='mysql:host=mydb.c2ewwi1jafca.eu-west-1.rds.amazonaws.com;dbname=galerie';
		$user='root';
		$password='';
		$bd=new PDO($param,$user,$password);
		$bd->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $table = 'images';
	}
	catch (Exception $Obj)
	{
		echo " Database error".$Obj->getMessage();
	}
    	if(isset($_POST['submit'])){ 
			$nomimg = $_FILES['img']['name'] ;
			$nomimg = str_replace(' ', '', $nomimg);
			$nomimg = str_replace('é', 'e', $nomimg);
			$nomimg = str_replace('è', 'e', $nomimg);
			$nomimg = str_replace('à', 'a', $nomimg);
			$nomimg = str_replace(' ', '', $nomimg);
			$nomimg = str_replace('-', '_', $nomimg);
			$nomimg = str_replace('/', '_', $nomimg);
			$nomimg = str_replace('@', '_', $nomimg);
	    
	    		$tmpfilename = $_FILES['img']['tmp_name'] ;
	                if (!class_exists('S3'))require_once('./S3.php');
 
			//AWS access info
			if (!defined('awsAccessKey')) define('awsAccessKey', 'AKIAJN6T756MUGUJIVHA');
			if (!defined('awsSecretKey')) define('awsSecretKey', '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');
 
			//instantiate the class
			$s3 = new S3(awsAccessKey, awsSecretKey);
	    		//var_dump($s3->putBucket("sourours3", S3::ACL_PUBLIC_READ));
			//move the file
			if ($s3->putObjectFile($tmpfilename, "sourours3", $nomimg, S3::ACL_PUBLIC_READ)) {
				echo "<strong>S3::We successfully uploaded your file.</strong>";
			}else{
				echo "<strong>S3::Something went wrong while uploading your file... sorry.</strong>";
			}
            		////////////////////////////////////////////////////////////
	    		$sql=$bd->prepare("INSERT INTO `images`(`name`, `src`) VALUES (:src,:src)");
	    
			$sql->bindParam('src', $nomimg);
			$res=$sql->execute();
			$dirpath = realpath(dirname(getcwd()));
			$document=$dirpath."/./uploads/".$nomimg;
			$result = move_uploaded_file($_FILES['img']['tmp_name'],$document);
			if ($res){ echo "Success";
				header('location:./index.php?add=0'); }
			else header('location:./index.php?add=1');
	}
?>
</body>
