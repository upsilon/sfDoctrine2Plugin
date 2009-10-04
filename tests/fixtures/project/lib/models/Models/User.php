<?php

namespace Models;

use DoctrineExtensions\ActiveEntity,
    sfDoctrineActiveEntity;

class User extends sfDoctrineActiveEntity
{
  protected $id;
  protected $isActive;
  protected $username;
  protected $password;
  protected $version;
  protected $profile;
  protected $groups;
  protected $myFriends;
  protected $friendsWithMe;

  public function setPassword($password)
  {
    $this->password = md5($password);
  }

	public function __toString()
	{
		return $this->get('username');
	}
}