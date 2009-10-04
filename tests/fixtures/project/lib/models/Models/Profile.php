<?php

namespace Models;

use DoctrineExtensions\ActiveEntity,
    sfDoctrineActiveEntity;

class Profile extends sfDoctrineActiveEntity
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