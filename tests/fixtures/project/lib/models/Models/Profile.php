<?php

namespace Models;

use DoctrineExtensions\ActiveEntity;

class Profile extends ActiveEntity
{
  protected $id;
  protected $firstName;
  protected $lastName;
  protected $userId;
  protected $user;

  public function getName()
  {
    return $this->firstName.' '.$this->lastName;
  }
}