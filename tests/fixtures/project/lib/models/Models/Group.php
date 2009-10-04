<?php

namespace Models;

use DoctrineExtensions\ActiveEntity,
    sfDoctrineActiveEntity;

class Group extends sfDoctrineActiveEntity
{
  protected $id;
  protected $name;
  protected $users;
}