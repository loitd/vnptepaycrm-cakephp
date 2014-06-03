<?php 
	
?>
<div class="jobs form">
	<?php // echo $this->Session->flash(); ?>
	<?php echo $this->Form->create('Job');?>
		<fieldset>
			<legend><?php echo __('Edit a job');?></legend>
			<?php //var_dump($this->data['Job']);?>
			<?php echo $this->Form->hidden('id', array('value'=>$this->data['Job']['id'])) ;?>
			<!-- We need hidden fields to update the disabled fields -->
			<?php echo $this->Form->hidden('saleman_id', array('value'=>$this->data['Job']['saleman_id'])) ;?>
			<?php echo $this->Form->hidden('status', array('value'=>$this->data['Job']['status'])) ;?>
			<?php echo $this->Form->hidden('type', array('value'=>$this->data['Job']['type'])) ;?>
			<?php echo $this->Form->hidden('created', array('value'=>$this->data['Job']['created'])) ;?>
			<?php echo $this->Form->hidden('modified', array('value'=>$this->data['Job']['modified'])) ;?>
			<?php echo $this->Form->hidden('alert_time', array('value'=>$this->data['Job']['alert_time'])) ;?>
			<!-- now print the normal inputs -->
			<?php echo $this->Form->input('Partner.partner_code', array('readonly'=>'readonly','label'=>'Partner')) ;?>
			<?php 
				echo $this->Form->input('Saleman.username', array('readonly'=>'readonly','label'=>'Saleman')) ;
			?>
			<?php echo $this->Form->input('Tinhcuoc.username', array('readonly'=>'readonly','label'=>'Khai thác')) ;?>
			<?php echo $this->Form->input('Ketoan.username', array('readonly'=>'readonly','label'=>'Kế toán')) ;?>
			
			<?php 
				if($jobstt == '0' && $this->Session->read('Auth.User.role') == 'khaithac' ){
					echo $this->Form->input('notes2', array('label'=>'Tính cước Notes')) ;
				} else {
					echo $this->Form->input('notes2', array('readonly'=>'readonly','label'=>'Tính cước Notes')) ;
				}
			?>
			
			<?php 
				if($jobstt == '1' && $this->Session->read('Auth.User.role') == 'kinhdoanh' && $this->Session->read('Auth.User.id') === $this->data['Job']['saleman_id'] ){
					echo $this->Form->input('notes1', array('label'=>'Saleman Notes')) ;
				} else {
					echo $this->Form->input('notes1', array('readonly'=>'readonly','label'=>'Saleman Notes')) ;
				}
				
			?>
			
			<?php 
				if($jobstt == '2' && $this->Session->read('Auth.User.role') == 'ketoan' ){
					echo $this->Form->input('notes3', array('label'=>'Kế toán Notes')) ;
				} else {
					echo $this->Form->input('notes3', array('readonly'=>'readonly','label'=>'Kế toán Notes')) ;
				}
			?>
			
			<?php echo $this->Form->input('status', array('disabled'=>'disabled',
															'label'=>__('Status'),
															'style'	=> 'color:red',
															'options'=>array('0'=>'Khai thác Process', '1'=>'Kinh doanh Process', '2'=>'Kế toán Process', '3'=>'Đã kết thúc'),
														)) ;?>

			<?php echo $this->Form->input('type', array('disabled'=>'disabled','label'=>'Type', 'options'=>array('0'=>'Định kỳ', '1'=>'Đột xuất'),)) ;?>
			<label><b>Ngày tạo: </b><?php echo $this->data['Job']['created'];?></label>
			<label><b>Ngày chỉnh sửa: </b><?php echo $this->data['Job']['modified'];?></label>
			<label><b>Alert Time: </b><?php echo $this->data['Job']['alert_time'];?></label>
			<?php //echo $this->Form->input('created', array('disabled'=>'disabled','type' => 'text', 'label'=>'TG Tạo')) ;?>
			<?php //echo $this->Form->input('modified', array('disabled'=>'disabled','type' => 'text', 'label'=>'TG Cập nhật')) ;?>
			<?php //echo $this->Form->input('alert_time', array('disabled'=>'disabled','type' => 'text', 'label'=>'TG Alert')) ;?>
			
	
			<?php echo $this->Form->submit('Save', array('class'=>'form-submit')) ;?>
			
			<?php echo " or " . $this->Html->link("Forward >>", array('action'=>'forward', $this->data['Job']['id'])); ?>
		</fieldset>
	<?php echo $this->Form->end(); ?>
</div>

<?php echo $this->Html->link( "Add A New Payment",   array('controller'=>'jobs','action'=>'add'),array('escape' => false) ); ?>