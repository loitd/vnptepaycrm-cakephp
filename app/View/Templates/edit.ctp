<?php 
	
?>
<div class="discounts form">
	<?php // echo $this->Session->flash(); ?>
	<?php echo $this->Form->create('Template');?>
		<fieldset>
			<legend><?php echo __('Edit a template');?></legend>
			<?php echo $this->Form->hidden('id', array('value'=>$this->data['Template']['id'])) ;?>
			<?php echo $this->Form->input('template_name', array('label'=>'Tên template')) ;?>
			<?php echo $this->Form->input('chietkhau1', array('label'=>'Chiết khấu 1')) ;?>
			<?php echo $this->Form->input('chietkhau2', array('label'=>'Chiết khấu 2')) ;?>
			<?php echo $this->Form->input('chietkhau3') ;?>
			<?php echo $this->Form->input('chietkhau4') ;?>
			<?php echo $this->Form->input('chietkhau5') ;?>
			<?php echo $this->Form->input('chietkhau6') ;?>
			<?php echo $this->Form->input('chietkhau7') ;?>
			<?php echo $this->Form->input('chietkhau8') ;?>
	
			<?php echo $this->Form->submit('Save', array('class'=>'form-submit')) ;?>
		</fieldset>
	<?php echo $this->Form->end(); ?>
</div>

<?php echo $this->Html->link('Add a new template', array('action'=>'add'));?>