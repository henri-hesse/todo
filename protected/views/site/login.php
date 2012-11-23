<p><em>Todos</em> is a small application for keeping track of tasks that need to be done. Login or register to get started!</p>

<h4>Login</h4>

<?php $form = $this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableAjaxValidation'=>false,
)); ?>
	<?php echo $form->error($loginModel,'username'); ?>
	<?php echo $form->error($loginModel,'password'); ?>

	<?php echo $form->textField($loginModel,'username', array('placeholder'=>'Username')); ?>
	<?php echo $form->passwordField($loginModel,'password', array('placeholder'=>'Password')); ?>


	<input type="submit" value="&raquo;" />

<?php $this->endWidget(); ?>

<h4>Register</h4>

<?php $form = $this->beginWidget('CActiveForm', array(
	'id'=>'register-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->labelEx($registerModel,'username'); ?>
	<?php echo $form->error($registerModel,'username'); ?>
	<?php echo $form->textField($registerModel,'username'); ?>

	<?php echo $form->labelEx($registerModel,'password'); ?>
	<?php echo $form->error($registerModel,'password'); ?>
	<?php echo $form->passwordField($registerModel,'password'); ?>

	<?php echo $form->labelEx($registerModel,'passwordRepeat'); ?>
	<?php echo $form->error($registerModel,'passwordRepeat'); ?>
	<?php echo $form->passwordField($registerModel,'passwordRepeat'); ?>
	
	<br />
	<input type="submit" value="Register" />

<?php $this->endWidget(); ?>