<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html ng-app="myApp">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="en">

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-theme.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/styles.css">

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
	<header>
    <nav class="navbar navbar-default">
    <div class="container">
      <div class="navbar-header">
        <a class="navbar-brand" href="#/">Articles</a>
      </div>

      <ul class="nav navbar-nav navbar-right">
        <li><a href="#/"><i class="fa fa-home"></i> Home</a></li>
        <li><a href="#/login"><i class="fa fa-shield"></i> Login</a></li>
        <li><a href="#/register"><i class="fa fa-comment"></i> Register</a></li>
      </ul>
    </div>
    </nav>
	</header>

	<div ng-view></div>

	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/angular.min.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/angular-route.min.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/angular-resource.min.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/angular-cookies.min.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/app.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/controllers.js"></script>
</body>
</html>
