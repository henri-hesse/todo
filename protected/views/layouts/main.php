<!DOCTYPE html>
<html lang="en" ng-app>
<head>
	<meta charset="utf-8" />
	<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.0.2/angular.min.js"></script>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
	<div id="page">
		<?php echo $content; ?>
	</div>
</body>
</html>