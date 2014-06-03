<?php 
    // var_dump($jobs);
?>
<div class="jobs form">
<h1>Jobs</h1>

<?php echo $this->Form->create(array('type'=>'get'));?>
    <?php echo $this->Form->input('from_date', array('type'=>'date'));?>
    <?php echo $this->Form->input('to_date', array('type'=>'date'));?>
    <?php echo $this->Form->input('partner_code', array('type'=>'text'));?>
    <?php echo $this->Form->submit('Search');?>

<?php echo $this->Form->end();?>

<table>
    <thead>
        <tr>
            <!-- th><?php // echo $this->Form->checkbox('all', array('name' => 'CheckAll',  'id' => 'CheckAll')); ?></th -->
            <th><?php echo $this->Paginator->sort('Partner.partner_code', 'Partner code');?>  </th>
            <th><?php echo $this->Paginator->sort('saleman_id', 'Saleman');?></th>
            <th><?php echo $this->Paginator->sort('tinhcuoc_id', 'Tính cước');?></th>
            <th><?php echo $this->Paginator->sort('ketoan_id','Kế toán');?></th>
            <th><?php echo $this->Paginator->sort('status','Status');?></th>
            <th><?php echo $this->Paginator->sort('created','TG Tạo');?></th>
            <th><?php echo $this->Paginator->sort('modified','TG Chỉnh sửa');?></th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>                       
        <?php $count=0; ?>
        <?php foreach($jobs as $job): ?> 
        
        <!-- check kinhdoanh -->
        <?php 
            $urole = $this->Session->read('Auth.User.role');
            $uname = $this->Session->read('Auth.User.username');
            if($urole !== "kinhdoanh" OR $uname == $job['Saleman']['username']):
        ?>               
            <?php $count ++;?>
            <?php if($count % 2): echo '<tr>'; else: echo '<tr class="zebra">' ?>
            <?php endif; ?>
                <!-- td><?php // echo $this->Form->checkbox('Partner.id.'.$partner['Partner']['id']); ?></td -->
                <td><?php echo $this->Html->link( $job['Partner']['partner_code']  ,   array('action'=>'edit', $job['Job']['id']),array('escape' => false) );?></td>
                <td style="text-align: center;"><?php echo $job['Saleman']['username']; ?></td>
                <td style="text-align: center;"><?php echo $job['Tinhcuoc']['username']; ?></td>
                <td style="text-align: center;"><?php echo $job['Ketoan']['username']; ?></td>
                <td style="text-align: center;">
                    <?php 
                        $x = $job['Job']['status']; 
                        if($x=='0'){echo "Khai thác Process";} 
                        elseif ($x=='1') { echo "Kinh doanh Process"; }
                        elseif ($x=='2') { echo "Kế toán Process"; }
                        elseif ($x=='3') { echo "Đã kết thúc"; }
                        else { echo "Không xác định"; }
                    ?>
                </td>
                <td style="text-align: center;"><?php echo $job['Job']['created']; ?></td>
                <td style="text-align: center;"><?php echo $job['Job']['modified']; ?></td>
                <td >
                <?php echo $this->Html->link(    "Edit",   array('action'=>'edit', $job['Job']['id']) ); ?> | 
                <?php //echo $this->Html->link(    "Make Payment",   array('action'=>'payment', $job['Job']['id']) ); ?>
                </td>
            </tr>
        <?php endif; ?>
        
        <?php endforeach; ?>
        <?php unset($partner); ?>
    </tbody>
</table>
<?php echo $this->Paginator->prev('<< ' . __('previous ', true), array(), null, array('class'=>'disabled'));?>
<?php echo $this->Paginator->numbers(array(   'class' => 'numbers'     ));?>
<?php echo $this->Paginator->next(__(' next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
</div>                

<?php echo $this->Html->link( "Add A New Payment",   array('controller'=>'jobs','action'=>'add'),array('escape' => false) ); ?>
<br/>



<?php //var_dump($this->Session->read('Auth.User.username')); ?>