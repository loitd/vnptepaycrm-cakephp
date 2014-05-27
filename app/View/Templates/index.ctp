<?php 
    // var_dump($partners);
?>
<div class="templates form">
<h1>Templates</h1>
<table>
    <thead>
        <tr>
            <!-- th><?php // echo $this->Form->checkbox('all', array('name' => 'CheckAll',  'id' => 'CheckAll')); ?></th -->
            <th><?php echo $this->Paginator->sort('id', 'ID');?>  </th>
            <th><?php echo $this->Paginator->sort('template_name', 'Tên template');?>  </th>
            <th><?php echo $this->Paginator->sort('chietkhau1','Chiết khấu 1');?></th>
            <th><?php echo $this->Paginator->sort('chietkhau2','Chiết khấu 2');?></th>
            <th><?php echo $this->Paginator->sort('chietkhau3','Chiết khấu 3');?></th>
            <th><?php echo $this->Paginator->sort('chietkhau4','Chiết khấu 4');?></th>
            <th><?php echo $this->Paginator->sort('chietkhau5','Chiết khấu 5');?></th>
            <th><?php echo $this->Paginator->sort('chietkhau6','Chiết khấu 6');?></th>
            <th><?php echo $this->Paginator->sort('chietkhau7','Chiết khấu 7');?></th>
            <th><?php echo $this->Paginator->sort('chietkhau8','Chiết khấu 8');?></th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>                       
        <?php $count=0; ?>
        <?php foreach($templates as $template): ?>                
        <?php $count ++;?>
        <?php if($count % 2): echo '<tr>'; else: echo '<tr class="zebra">' ?>
        <?php endif; ?>
            <!-- td><?php // echo $this->Form->checkbox('Partner.id.'.$partner['Partner']['id']); ?></td -->
            <td><?php echo $this->Html->link( $template['Template']['id']  ,   array('action'=>'edit', $template['Template']['id']),array('escape' => false) );?></td>
            <td><?php echo $this->Html->link( $template['Template']['template_name']  ,   array('action'=>'edit', $template['Template']['id']),array('escape' => false) );?></td>
            <td style="text-align: center;"><?php echo $template['Template']['chietkhau1']; ?></td>
            <td style="text-align: center;"><?php echo $template['Template']['chietkhau2']; ?></td>
            <td style="text-align: center;"><?php echo $template['Template']['chietkhau3']; ?></td>
            <td style="text-align: center;"><?php echo $template['Template']['chietkhau4']; ?></td>
            <td style="text-align: center;"><?php echo $template['Template']['chietkhau5']; ?></td>
            <td style="text-align: center;"><?php echo $template['Template']['chietkhau6']; ?></td>
            <td style="text-align: center;"><?php echo $template['Template']['chietkhau7']; ?></td>
            <td style="text-align: center;"><?php echo $template['Template']['chietkhau8']; ?></td>
            
            <td >
            <?php echo $this->Html->link(    "Edit",   array('action'=>'edit', $template['Template']['id']) ); ?> | 
            <?php echo $this->Form->postLink("Delete", array('action'=>'delete', $template['Template']['id']), array('confirm'=>'Are you sure?'));?>
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
<?php echo $this->Html->link( "Add A New Template",   array('controller'=>'templates','action'=>'add'),array('escape' => false) ); ?>
<br/>


<?php //var_dump($this->Session->read('Auth.User.username')); ?>