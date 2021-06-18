<!-- File: templates/Articles/add.php -->

<h1>Add Article</h1>
<?php /*echo $this->Form->create($article);
    echo $this->Form->control('title');
    echo $this->Form->control('body', ['rows' => '3']);
    echo $this->Form->button(__('Save Article'));
    echo $this->Form->end();  
    */ ?>
    
    <?= $this->Form->create($article);?>
    <?=  $this->Form->control('category_id');?>
    <?=   $this->Form->control('title');?>
    <?=  $this->Form->control('body', ['rows' => '3']);?>
    <?=  $this->Form->button(__('Save Article'));?>
    <?=  $this->Form->end(); ?>
    