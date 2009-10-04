<h1>Users</h1>

<?php echo button_to('New User', '@new_user') ?>

<ul>
  <?php foreach ($users as $user): ?>
    <li><?php echo link_to($user->profile->getName().' ('.$user->username.')', '@edit_user?id='.$user->id) ?></li>
  <?php endforeach; ?>
</ul>