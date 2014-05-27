<?php 
    // var_dump($partners);
?>
<div class="discounts form">
<h1>Chiết khấu</h1>
<table>
    <thead>
        <tr>
            <!-- th><?php // echo $this->Form->checkbox('all', array('name' => 'CheckAll',  'id' => 'CheckAll')); ?></th -->
            <th><?php echo $this->Paginator->sort('id', 'ID');?>  </th>
            <th><?php echo $this->Paginator->sort('ngaytt', 'Ngày thanh toán');?>  </th>
            <th><?php echo $this->Paginator->sort('hanmuc', 'Hạn mức');?></th>
            <th><?php echo $this->Paginator->sort('hanmucvtt', 'Hạn mức VTT');?></th>
            <th><?php echo $this->Paginator->sort('mgc','Megacard');?></th>
            <th><?php echo $this->Paginator->sort('vnp','Vinaphone');?></th>
            <th><?php echo $this->Paginator->sort('vms','VMS');?></th>
            <th><?php echo $this->Paginator->sort('vcoin','VCOIN');?></th>
            <th><?php echo $this->Paginator->sort('fpt','FPT');?></th>
            <th><?php echo $this->Paginator->sort('oncash','ONCASH');?></th>
            <th><?php echo $this->Paginator->sort('vtt','VTT');?></th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>                       
        <?php $count=0; ?>
        <?php foreach($discounts as $discount): ?>                
        <?php $count ++;?>
        <?php if($count % 2): echo '<tr>'; else: echo '<tr class="zebra">' ?>
        <?php endif; ?>
            <!-- td><?php // echo $this->Form->checkbox('Partner.id.'.$partner['Partner']['id']); ?></td -->
            <td><?php echo $this->Html->link( $discount['Discount']['id']  ,   array('action'=>'edit', $discount['Discount']['id']),array('escape' => false) );?></td>
            <td><?php echo $this->Html->link( $discount['Discount']['ngaytt']  ,   array('action'=>'edit', $discount['Discount']['id']),array('escape' => false) );?></td>
            <td style="text-align: center;"><?php echo $discount['Discount']['hanmuc']; ?></td>
            <td style="text-align: center;"><?php echo $discount['Discount']['hanmucvtt']; ?></td>
            <td style="text-align: center;"><?php echo $discount['Discount']['mgc']; ?></td>
            <td style="text-align: center;"><?php echo $discount['Discount']['vnp']; ?></td>
            <td style="text-align: center;"><?php echo $discount['Discount']['vms']; ?></td>
            <td style="text-align: center;"><?php echo $discount['Discount']['vcoin']; ?></td>
            <td style="text-align: center;"><?php echo $discount['Discount']['fpt']; ?></td>
            <td style="text-align: center;"><?php echo $discount['Discount']['oncash']; ?></td>
            <td style="text-align: center;"><?php echo $discount['Discount']['vtt']; ?></td>
            <td >
            <?php echo $this->Html->link(    "Edit",   array('action'=>'edit', $discount['Discount']['id']) ); ?> | 
            <?php echo $this->Form->postLink("Delete", array('action'=>'delete', $discount['Discount']['id']), array('confirm'=>'Are you sure?'));?>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php unset($chietkhau); ?>
    </tbody>
</table>
<?php echo $this->Paginator->prev('<< ' . __('previous ', true), array(), null, array('class'=>'disabled'));?>
<?php echo $this->Paginator->numbers(array(   'class' => 'numbers'     ));?>
<?php echo $this->Paginator->next(__(' next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
</div>                
<?php echo $this->Html->link( "Add A New Discount",   array('controller'=>'discounts','action'=>'add'),array('escape' => false) ); ?>
<br/>


<?php //var_dump($this->Session->read('Auth.User.username')); ?>