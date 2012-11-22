<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />

	<script>
		var generic = {
			baseUrl: '<?php echo Yii::app()->baseUrl; ?>',
			
			createUrl: function(controller, action) {
				var url = this.baseUrl+'/index.php';
				
				if( typeof controller!=='undefined' )
					url += '/' + controller;
				
				if( typeof action!=='undefined' )
					url += '/' + action;
				
				return url;
			}
		};
	</script>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
	<div id="page">
		<?php echo $content; ?>
	</div>
</body>
</html>