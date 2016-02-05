<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html ng-app="myApp">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="en">

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.min.css" media="print">

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
	<header>
    <nav class="navbar navbar-default">
    <div class="container">
      <div class="navbar-header">
        <a class="navbar-brand" href="/">Angular Routing Example</a>
      </div>

      <ul class="nav navbar-nav navbar-right">
        <li><a href="#"><i class="fa fa-home"></i> Home</a></li>
        <li><a href="#about"><i class="fa fa-shield"></i> About</a></li>
        <li><a href="#contact"><i class="fa fa-comment"></i> Contact</a></li>
      </ul>
    </div>
    </nav>
	</header>

	<?php echo $content; ?>

	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/angular.min.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/angular-route.min.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/app.js"></script>
</body>
</html>
