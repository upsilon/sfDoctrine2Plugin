<h1>Create New User</h1>

<form action="<?php echo url_for('@new_user') ?>" method="post">
  <?php echo get_partial('users/form', array('user' => $user)) ?>
</form>