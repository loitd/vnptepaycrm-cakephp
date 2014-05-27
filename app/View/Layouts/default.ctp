<?php
/**
 *
 *
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 */

$cakeDescription = __d('cake_dev', 'VNPTEPAY Charging CRM');
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $this->fetch('title'); ?>
	</title>
	<?php
		// echo $this->Html->meta('icon');

		echo $this->Html->css('cake.generic');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
	<div id="container">
		<div id="header">
			<h1><?php echo $this->Html->link($cakeDescription, 'http://vnptepay.com.vn'); ?></h1>
			<legend><?php echo "<b>Username</b>: ". $this->Session->read('Auth.User.username') . "/ <b>Role</b>: " . $this->Session->read('Auth.User.role'); ?>
			<?php echo " | " . $this->Html->link( "Jobs",   	array('controller'=>'jobs','action'=>'index') ); ?>
			<?php echo " | " . $this->Html->link( "User",   	array('controller'=>'users','action'=>'index') ); ?>
			<?php echo " | " . $this->Html->link( "Partner",   	array('controller'=>'partners','action'=>'index') ); ?>
			<?php echo " | " . $this->Html->link( "Discount",   array('controller'=>'discounts','action'=>'index') ); ?>
			<?php echo " | " . $this->Html->link( "Templates", 	array('controller'=>'templates','action'=>'index') ); ?>
			<?php echo " | " . $this->Html->link( "Logout",   	array('controller'=>'users','action'=>'logout') ); ?>
			</legend>
		</div>
		<div id="content">

			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer">
			<?php echo $this->Html->link(
					$this->Html->image('cake.power.gif', array('alt' => $cakeDescription, 'border' => '0')),
					'http://www.vnptepay.com.vn/',
					array('target' => '_blank', 'escape' => false)
				);
			?>
		</div>
	</div>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
