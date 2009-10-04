<h1><?php echo $user->username ?></h1>

<form action="<?php echo url_for('@edit_user?id='.$user->id) ?>" method="post">
  <?php echo get_partial('users/form', array('user' => $user)) ?>
</form>