
<h1>Add user or login to existing</h1>
<?= $this->Html->link('Add User', ['action' => 'add']) ?>
<h2>Hello</h2>
<?= $this->Html->link('Login', ['action' => 'login']) ?>

<?php foreach ($users as $user): ?>
        <td>
            <?= $this->Html->link($user, ['action' => 'view']) ?>
        </td>
    <?php endforeach; ?>