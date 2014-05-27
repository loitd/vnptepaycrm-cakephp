<div class="users form">
	<?php // echo $this->Session->flash(); ?>
	<?php echo $this->Form->create('User');?>
		<fieldset>
			<legend><?php echo __('Edit a user');?></legend>
			<?php echo $this->Form->hidden('id', array('value'=>$this->data['User']['id'])) ;?>
			<?php echo $this->Form->input('username', array('readonly'=>'readonly', 'label'=>'Username can not be changed.')) ;?>
			<?php echo $this->Form->input('password_update', array('label'=>'New password (leave empty if you do not want to change)', 'type'=>'password', 'required'=>0)) ;?>
			<?php echo $this->Form->input('password_confirm_update', array('label'=>'Confirm new password', 'type'=>'password', 'required'=>0)) ;?>
			<?php echo $this->Form->input('email') ;?>
			<?php echo $this->Form->input('role', array('options'=>array('hethong'=>'He Thong', 'kinhdoanh'=>'Kinh Doanh', 'khaithac'=>'Khai Thac', 'ketoan'=>'Ke Toan'))) ;?>
			<?php echo $this->Form->input('status', array('options'=>array('0'=>'In-active', '1'=>'Active'))) ;?>
			<?php echo $this->Form->submit('Edit user', array('class'=>'form-submit')) ;?>
		</fieldset>
	<?php echo $this->Form->end(); ?>
</div>

<?php echo $this->Html->link('Add a new user', array('action'=>'add'));?>
