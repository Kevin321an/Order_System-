<h1>Pizza Orders</h1>
<?= $this->Html->link('Add orders', ['action' => 'add']) ?>
<table>
    <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Address</th>
        <th>Telephone</th>
        <th>Email</th>
        <th>Size</th>
        <th>Crus TYPE</th>
        <th>Topping</th>
    </tr>

    <!-- Here is where we iterate through our $articles query object, printing out article info -->

    <?php foreach ($orders as $orders): ?>
    <tr>
        <td>          
            <?= $this->Html->link($orders->id, ['action' => 'view', $orders->id]) ?>
         </td>
        <td>          
            <?= $this->Html->link($orders->Name, ['action' => 'view', $orders->name]) ?>
         </td>
       
        <td>
            <?= $this->Html->link($orders->Address, ['action' => 'view', $orders->name]) ?>
        </td>
        <td>
            <?= $this->Html->link($orders->Telephone, ['action' => 'view', $orders->name]) ?>
        </td>
        <td>
            <?= $this->Html->link($orders->Email, ['action' => 'view', $orders->name]) ?>
            
        </td>
        <td>
            <?= $this->Html->link($orders->Size, ['action' => 'view', $orders->name]) ?>
           
        </td>
        <td>
            <?= $this->Html->link($orders->CrusType, ['action' => 'view', $orders->name]) ?>
            
        </td>
        <td>
            <?= $this->Html->link($orders->Toping, ['action' => 'view', $orders->name]) ?>
        </td>
        
      
    </tr>
    <?php endforeach; ?>
</table>