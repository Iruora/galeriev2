
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Galery</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="css/crude.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>
	
<body>
  <?php
//include the S3 class              
if (!class_exists('S3'))require_once('S3.php');
 
//AWS access info
if (!defined('awsAccessKey')) define('awsAccessKey', 'AKIAJZS6DLUHFMG6LY5Q');
if (!defined('awsSecretKey')) define('awsSecretKey', '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');
 
//instantiate the class
$s3 = new S3(awsAccessKey, awsSecretKey);
 
//we'll continue our script from here in step 4!
 
?>
    <div class="container" style="margin-bottom:10%">
      
      <div class="row px-5">
        <?php 
			try
			{
                $param='mysql:host=mydb.c2ewwi1jafca.eu-west-1.rds.amazonaws.com;dbname=galerie';
                $user='root';
                $password='rootroot';
                $bd=new PDO($param,$user,$password);
                $bd->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                $table = 'images';

			}
			catch (Exception $Obj)
			{
				echo " Database error".$Obj->getMessage();
			}
			$sql="select * from images ";
			$res=$bd->query($sql);
			$photos=$res->fetchAll(PDO::FETCH_NUM);
			foreach ($photos as $photo) {
        ?>
            <div class="col-md-6 p-4">
                <img class="img-responsive m-3" style="margin-top:10%" src="../uploads/<?php echo $photo[2]; ?>" />
            </div>
		<?php }; ?>
  </div>
    </div>

</body>
</html>
