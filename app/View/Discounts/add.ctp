<div class="users form">
	<?php echo $this->Form->create('Discount');?>
		<fieldset>
			<legend><?php echo __('Add a new discount');?></legend>
			<?php echo $this->Form->input('ngaytt', array('label'=>'Ngày thanh toán')) ;?>
			<?php echo $this->Form->input('hanmuc', array('label'=>'Hạn mức')) ;?>
			<?php echo $this->Form->input('hanmucvtt', array('label'=>'Hạn mức VTT')) ;?>
			<?php echo $this->Form->input('mgc') ;?>
			<?php echo $this->Form->input('vnp') ;?>
			<?php echo $this->Form->input('vms') ;?>
			<?php echo $this->Form->input('vcoin') ;?>
			<?php echo $this->Form->input('fpt') ;?>
			<?php echo $this->Form->input('oncash') ;?>
			<?php echo $this->Form->input('vtt') ;?>

			<?php echo $this->Form->submit('Add discount', array('class'=>'form-submit')) ;?>
		</fieldset>
	<?php echo $this->Form->end(); ?>
</div>