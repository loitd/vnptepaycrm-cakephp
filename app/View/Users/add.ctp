<div class="users form">
	<?php echo $this->Form->create('User');?>
		<fieldset>
			<legend><?php echo __('Add new user');?></legend>
			<?php echo $this->Form->input('username') ;?>
			<?php echo $this->Form->input('password') ;?>
			<?php echo $this->Form->input('password_confirm', array('label'=>'Confirm Password', 'type'=>'password')) ;?>
			<?php echo $this->Form->input('email') ;?>
			<?php echo $this->Form->input('status', array('options'=>array('1'=>'Active', '0'=>'In-active'))) ;?>
			<?php echo $this->Form->input('role', array('options'=>array('hethong'=>'He Thong', 'kinhdoanh'=>'Kinh Doanh', 'khaithac'=>'Khai Thac', 'ketoan'=>'Ke Toan'))) ;?>
			<?php echo $this->Form->submit('Add user', array('class'=>'form-submit')) ;?>
		</fieldset>
	<?php echo $this->Form->end(); ?>
</div>
