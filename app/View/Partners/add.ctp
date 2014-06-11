<div class="users form">
	<?php echo $this->Form->create('Partner');?>
		<fieldset>
			<legend><?php echo __('Add new partner');?></legend>
			<?php echo $this->Form->input('partner_code') ;?>
			<?php echo $this->Form->hidden('saleman_id', array('value'=>$this->Session->read('Auth.User.id'))) ;?>
			<?php echo $this->Form->input('status', array('options'=>array('1'=>'Active','0'=>'In-active'))) ;?>
			<?php echo $this->Form->input('loaiHD') ;?>
			<?php echo $this->Form->input('doitac') ;?>
			<?php echo $this->Form->input('sohd') ;?>
			<?php echo $this->Form->input('ngaykyHD') ;?>
			<?php echo $this->Form->input('ngayGolive') ;?>
			<?php echo $this->Form->input('template_id', array('options'=>$templatedds)) ;?>
			<?php echo $this->Form->input('dieukientt') ;?>
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
			<?php echo $this->Form->input('emailKT', array('label'=>'Email kỹ thuật (cách nhau bởi dấu '.MYSEPARATOR.')') ) ;?>
			<?php echo $this->Form->input('mobileKT') ;?>
			<?php echo $this->Form->input('website') ;?>

			<?php echo $this->Form->submit('Add partner', array('class'=>'form-submit')) ;?>
		</fieldset>
	<?php echo $this->Form->end(); ?>
</div>