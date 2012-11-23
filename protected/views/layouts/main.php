<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	
	<script>
		// General properties & functions.
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
	<title>Todos - Manage your everyday life</title>
</head>

<body>
	<div id="page">
		<?php if( Yii::app()->user->isGuest===false ) { ?>
			<p id="userinfo">
				<?php echo Yii::app()->user->name; ?> - 
				<a href="<?php echo Yii::app()->createUrl('site/logout'); ?>">Logout</a>
			</p>
		<?php } ?>	

		<h1>Todos</h1>
		<?php echo $content; ?>
	</div>
</body>
</html>