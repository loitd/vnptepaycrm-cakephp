<div class="users form">
	<?php echo $this->Session->flash('Auth'); ?>
	<?php echo $this->Form->create('User');?>
		<fieldset>
			<legend><?php echo __('Please enter your username and password');?></legend>
			<?php echo $this->Form->input('username');?>
			<?php echo $this->Form->input('password');?>
		</fieldset>
	<?php echo $this->Form->end(__('Login')) ;?>
</div>

<?php echo $this->Html->link('Add a new user', array('action'=>'add'));?>
