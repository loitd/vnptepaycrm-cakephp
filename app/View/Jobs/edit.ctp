<?php 
	//var_dump($this->data);
?>
<div class="jobs form">
	<?php // echo $this->Session->flash(); ?>
	<?php echo $this->Form->create('Job', array('enctype' => 'multipart/form-data'));?>
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
			<?php echo $this->Form->input('Saleman.username', array('readonly'=>'readonly','label'=>'Saleman')) ; ?>
			<?php echo $this->Form->input('Tinhcuoc.username', array('readonly'=>'readonly','label'=>'Khai thác')) ;?>
			<?php echo $this->Form->input('Ketoan.username', array('readonly'=>'readonly','label'=>'Kế toán')) ;?>
			<?php echo $this->Form->input('otp', array('readonly'=>'readonly','label'=>'OTP')) ;?>

			
			<?php 
				
				echo $this->Form->input('AlertOTP.status', array('disabled'=>'disabled','label'=>'Trạng thái gửi OTP', 'options'=>array('99'=>'Khởi tạo', '0'=>'Chưa gửi', '1'=>'Đã gửi'),)) ;

				if($jobstt <= KHT_GUIBANCUNG && $this->Session->read('Auth.User.role') == 'khaithac' ){
					echo $this->Form->input('notes2', array('label'=>'Tính cước Notes')) ;
				
				//new form for email
					echo $this->Form->input('Alert.email_to', array('label'=>'Email nhận (ngăn cách bằng dấu '. MYSEPARATOR .')')) ;
					echo $this->Form->input('Alert.email_cc', array('label'=>'Email cc (ngăn cách bằng dấu '.MYSEPARATOR.')')) ;
					echo $this->Form->input('Alert.email_bcc', array('label'=>'Email bcc (ngăn cách bằng dấu '.MYSEPARATOR.')')) ;
					
					echo $this->Form->input('Alert.email_content', array('label'=>'Nội dung email')) ;
					echo $this->Form->input('email_attach', array('label'=>'File đính kèm', 'type'=>'file')) ;

					if(isset($this->data['Alert']['email_attach'])){
						$filelink = $this->html->url('/', true) . 'files/' . basename($this->data['Alert']['email_attach']);	
					} else {
						$filelink = null;
					}
					
					echo '<a href="' . $filelink . '" >Attached file: ' . $filelink . '</a>';
					
					echo $this->Form->input('Alert.status', array('disabled'=>'disabled','label'=>'Trạng thái gửi mail', 'options'=>array('99'=>'Khởi tạo', '0'=>'Chưa gửi', '1'=>'Đã gửi'),)) ;
				//end new form

				} else {
					echo $this->Form->input('notes2', array('readonly'=>'readonly','label'=>'Tính cước Notes')) ;
					echo $this->Form->input('Alert.email_to', array('readonly'=>'readonly','label'=>'Email nhận (ngăn cách bằng dấu '.MYSEPARATOR.')')) ;
					echo $this->Form->input('Alert.email_cc', array('readonly'=>'readonly','label'=>'Email cc (ngăn cách bằng dấu '.MYSEPARATOR.')')) ;
					echo $this->Form->input('Alert.email_bcc', array('readonly'=>'readonly','label'=>'Email bcc (ngăn cách bằng dấu '.MYSEPARATOR.')')) ;
					
					echo $this->Form->input('Alert.email_content', array('readonly'=>'readonly','label'=>'Nội dung email')) ;
					//echo $this->Form->input('Alert.email_attach', array('label'=>'File đính kèm', 'type'=>'file')) ;
					echo '<a href="' . $this->data['Alert']['email_attach'] . '" >Attached file: ' . $this->data['Alert']['email_attach'] . '</a>';
					echo $this->Form->input('Alert.status', array('disabled'=>'disabled','label'=>'Trạng thái gửi mail', 'options'=>array('99'=>'Khởi tạo', '0'=>'Chưa gửi', '1'=>'Đã gửi'),)) ;
				}
			?>
			
			<?php 
				if($jobstt == KINHDOANH_PROCESS && $this->Session->read('Auth.User.role') == 'kinhdoanh' && $this->Session->read('Auth.User.id') === $this->data['Job']['saleman_id'] ){
					echo $this->Form->input('notes1', array('label'=>'Saleman Notes')) ;
				} else {
					echo $this->Form->input('notes1', array('readonly'=>'readonly','label'=>'Saleman Notes')) ;
				}
				
			?>
			
			<?php 
				if($jobstt == KETOAN_PROCESS && $this->Session->read('Auth.User.role') == 'ketoan' ){
					echo $this->Form->input('notes3', array('label'=>'Kế toán Notes')) ;
				} else {
					echo $this->Form->input('notes3', array('readonly'=>'readonly','label'=>'Kế toán Notes')) ;
				}
			?>
			
			<?php echo $this->Form->input('status', array('disabled'=>'disabled',
															'label'=>__('Status'),
															'style'	=> 'color:red',
															'options'=>array(KHT_YEUCAUDOISOAT	=>'KHT Yêu cầu đối soát', 
																			KHT_GUIDOISOAT		=>'KHT Gửi đối soát', 
																			KHT_XULYSAILECH		=>'KHT Xử lý sai lệch', 
																			KHT_CHOTSOLIEU		=>'KHT Chốt số liệu', 
																			KHT_GUIBANCUNG		=>'KHT Gửi bản cứng', 
																			KINHDOANH_PROCESS	=>'Kinh doanh Process', 
																			KETOAN_PROCESS		=>'Kế toán Process', 
																			DAKETTHUC			=>'Đã kết thúc', ),
														)) ;?>

			<?php echo $this->Form->input('type', array('disabled'=>'disabled','label'=>'Type', 'options'=>array('0'=>'Định kỳ', '1'=>'Đột xuất'),)) ;?>
			<label><b>Ngày tạo: </b><?php echo $this->data['Job']['created'];?></label>
			<label><b>Ngày chỉnh sửa: </b><?php echo $this->data['Job']['modified'];?></label>
			<label><b>Alert Time: </b><?php echo $this->data['Job']['alert_time'];?></label>
			<?php //echo $this->Form->input('created', array('disabled'=>'disabled','type' => 'text', 'label'=>'TG Tạo')) ;?>
			<?php //echo $this->Form->input('modified', array('disabled'=>'disabled','type' => 'text', 'label'=>'TG Cập nhật')) ;?>
			<?php //echo $this->Form->input('alert_time', array('disabled'=>'disabled','type' => 'text', 'label'=>'TG Alert')) ;?>
			
	
			<?php echo $this->Form->submit('Save', array('name'=>'savebtn','class'=>'form-submit')) ;?>
			<?php echo $this->Form->submit('Send Email', array('name'=>'sendbtn','class'=>'form-submit')) ;?>
			
			<?php echo " or " . $this->Html->link("Forward >>", array('action'=>'forward', $this->data['Job']['id'])); ?>
		</fieldset>
	<?php echo $this->Form->end(); ?>
</div>

<?php echo $this->Html->link( "Add A New Payment",   array('controller'=>'jobs','action'=>'add'),array('escape' => false) ); ?>