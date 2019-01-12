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
</head>
    <title>Galery</title>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/crude.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<!------ Include the above in your HEAD tag ---------->
</head>
<body>
<div class="container">
    <div id="main_area">
        <h1>Gallery</h1>
        <a href="index.php" class="btn btn-success">Add new images</a>
        <!-- Slider -->
        <div class="row">
            <div class="col-sm-6" id="slider-thumbs">
                <!-- Bottom switcher of slider -->
                <br>
                <ul class="hide-bullets">
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
						$i = 0;
						//var_dump(count($photos));
						foreach ($photos as $photo) {
						
					?>

                    <li class="col-sm-3">
                        <a class="thumbnail" id="carousel-selector-0">
                            <img src="../uploads/<?php echo $photo[2]; ?>">
                        </a>
                    </li>
					<?php $i++;} ?>
                </ul>
            </div>
            <div class="col-sm-6">
                <div class="col-xs-12" id="slider">
                    <!-- Top part of the slider -->
                    <div class="row">
                        <div class="col-sm-12" id="carousel-bounding-box">
                            <div class="carousel slide" id="myCarousel">
                                <!-- Carousel items -->
                                <div class="carousel-inner">
									<div class="item active" data-slide-number="0">
                                        <?php
                                        if (count($photos) != 0) {
                                        ?>
                                            <img src="../uploads/<?php echo $photos[0][2]; ?>" >
                                        <?php }?>
									</div>
								<?php 
									
									
									for ($i = 1; $i < count($photos); $i++ ) {
								?>
                                    <div class="item" data-slide-number="<?php echo $i;?>">
                                        <img src="../uploads/<?php echo $photos[$i][2]; ?>" >
									</div>
									<?php }?>
                                </div>
                                <!-- Carousel nav -->
                                <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                                    <span class="glyphicon glyphicon-chevron-left"></span>
                                </a>
                                <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                                    <span class="glyphicon glyphicon-chevron-right"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/Slider-->
        </div>

    </div>
</div>
</body>
