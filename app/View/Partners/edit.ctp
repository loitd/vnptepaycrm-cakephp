<?php 
	// var_dump($templatedds);
?>
<div class="partners form">
	<?php // echo $this->Session->flash(); ?>
	<?php echo $this->Form->create('Partner');?>
		<fieldset>
			<legend><?php echo __('Edit a partner');?></legend>
			<?php echo $this->Form->hidden('id', array('value'=>$this->data['Partner']['id'])) ;?>
			<?php echo $this->Form->input('partner_code', array('label'=>'Partner Code')) ;?>
			<?php echo $this->Form->input('saleman_id', array('options'=>$userdds, 'label'=>'Saleman')) ;?>
			<?php // echo $this->Form->input('User.username', array('readonly'=>'readonly', 'label'=>'Saleman')) ;?>
			<?php echo $this->Form->input('status', array('options'=>array('0'=>'In-active', '1'=>'Active'))) ;?>
			<?php echo $this->Form->input('loaiHD') ;?>
			<?php echo $this->Form->input('doitac') ;?>
			<?php echo $this->Form->input('sohd') ;?>
			<?php echo $this->Form->input('ngaykyHD') ;?>
			<?php echo $this->Form->input('ngayGolive') ;?>
			<?php echo $this->Form->input('template_id', array('options'=>$templatedds)) ;?>
			<?php echo $this->Form->input('dieukientt', array('label'=>'Điều kiện thanh toán (ví dụ: 15)')) ;?>
			<?php echo $this->Form->input('ngaydoisoat') ;?>
			<?php echo $this->Form->input('lichthanhtoan') ;?>
			<?php echo $this->Form->input('ngayttdautien') ;?>
			<?php echo $this->Form->input('ngayttcuoicung') ;?>
			<?php echo $this->Form->input('tknganhang') ;?>
			<?php echo $this->Form->input('nguoidoisoat') ;?>
			<?php echo $this->Form->input('emaildoisoat', array('label'=>'Email đối soát (cách nhau bởi dấu '.MYSEPARATOR.')') ) ;?>
			<?php echo $this->Form->input('mobiledoisoat') ;?>
			<?php echo $this->Form->input('diachi') ;?>
			<?php echo $this->Form->input('phutrachKD') ;?>
			<?php echo $this->Form->input('emailKD', array('label'=>'Email kinh doanh (cách nhau bởi dấu '.MYSEPARATOR.')')) ;?>
			<?php echo $this->Form->input('mobileKD') ;?>
			<?php echo $this->Form->input('ngaySNnguoiCS') ;?>
			<?php echo $this->Form->input('ngayKNDN') ;?>
			<?php echo $this->Form->input('nguoiphutrachKT') ;?>
			<?php echo $this->Form->input('emailKT' , array('label'=>'Email kỹ thuật (cách nhau bởi dấu '.MYSEPARATOR.')') ) ;?>
			<?php echo $this->Form->input('mobileKT') ;?>
			<?php echo $this->Form->input('website') ;?>

	
			<?php echo $this->Form->submit('Save', array('class'=>'form-submit')) ;?>
		</fieldset>
	<?php echo $this->Form->end(); ?>
</div>

<?php echo $this->Html->link('Add a new partner', array('action'=>'add'));?>