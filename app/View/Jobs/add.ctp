<?php 
	function generateRandomString($length = 6) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, strlen($characters) - 1)];
	    }
	    return $randomString;
	}
?>
<div class="jobs form">
	<?php echo $this->Form->create('Job');?>
		<fieldset>
			<legend><?php echo __('Add new job');?></legend>
			<?php echo $this->Form->input('partner_id', array('options'=>$partnerdds)) ;?>
			<?php echo $this->Form->hidden('saleman_id', array('value'=>$this->Session->read('Auth.User.id'))) ;?>
			<?php echo $this->Form->input('notes1') ;?>
			<?php echo $this->Form->hidden('status', array('value'=>'0')) ;?>
			<?php echo $this->Form->hidden('type', array('value'=>'1')) ;?>
			<?php echo $this->Form->hidden('otp', array('value'=>generateRandomString())) ;?>
			
			<?php echo $this->Form->submit('Add job', array('class'=>'form-submit')) ;?>
		</fieldset>
	<?php echo $this->Form->end(); ?>
</div>