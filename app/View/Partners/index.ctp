<?php 
    // var_dump($partners);
?>
<div class="users form">
<h1>Partners</h1>
<table>
    <thead>
        <tr>
            <!-- th><?php // echo $this->Form->checkbox('all', array('name' => 'CheckAll',  'id' => 'CheckAll')); ?></th -->
            <th><?php echo $this->Paginator->sort('partner_code', 'Partner code');?>  </th>
            <th><?php echo $this->Paginator->sort('username', 'Saleman');?></th>
            <th><?php echo $this->Paginator->sort('sohd', 'Số hợp đồng');?></th>
            <th><?php echo $this->Paginator->sort('ngayGolive','Ngày Golive');?></th>
            <th><?php echo $this->Paginator->sort('template_name','Template');?></th>
            <th><?php echo $this->Paginator->sort('status','Trạng thái');?></th>
            <th><?php echo $this->Paginator->sort('dieukientt','Điều kiện TT');?></th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>                       
        <?php $count=0; ?>
        <?php foreach($partners as $partner): ?>                
        <?php $count ++;?>
        <?php if($count % 2): echo '<tr>'; else: echo '<tr class="zebra">' ?>
        <?php endif; ?>
            <!-- td><?php // echo $this->Form->checkbox('Partner.id.'.$partner['Partner']['id']); ?></td -->
            <td><?php echo $this->Html->link( $partner['Partner']['partner_code']  ,   array('action'=>'edit', $partner['Partner']['id']),array('escape' => false) );?></td>
            <td style="text-align: center;"><?php echo $partner['User']['username']; ?></td>
            <td style="text-align: center;"><?php echo $partner['Partner']['sohd']; ?></td>
            <td style="text-align: center;"><?php echo $partner['Partner']['ngayGolive']; ?></td>
            <td style="text-align: center;"><?php echo $partner['Template']['template_name']; ?></td>
            <td style="text-align: center;"><?php echo ($partner['Partner']['status'] == '1') ? 'active' : 'inactive'; ?></td>
            <td style="text-align: center;"><?php echo $partner['Partner']['dieukientt']; ?></td>
            <td >
            <?php echo $this->Html->link(    "Edit",   array('controller'=>'partners','action'=>'edit', $partner['Partner']['id']) ); ?> | 
            <?php
                if( $partner['Partner']['status'] != 0){ 
                    echo $this->Html->link("Disable", array('action'=>'disable', $partner['Partner']['id']));
                }else{
                    echo $this->Html->link("Enable", array('action'=>'enable', $partner['Partner']['id']));
                }
            ?> | 
            <?php echo $this->Form->postLink("Delete", array('action'=>'delete', $partner['Partner']['id']), array('confirm'=>'Are you sure?'));?>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php unset($partner); ?>
    </tbody>
</table>
<?php echo $this->Paginator->prev('<< ' . __('previous ', true), array(), null, array('class'=>'disabled'));?>
<?php echo $this->Paginator->numbers(array(   'class' => 'numbers'     ));?>
<?php echo $this->Paginator->next(__(' next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
</div>                
<?php echo $this->Html->link( "Add A New Partner",   array('controller'=>'partners','action'=>'add'),array('escape' => false) ); ?>
<br/>


<?php //var_dump($this->Session->read('Auth.User.username')); ?>