<?php

namespace Models;

use DoctrineExtensions\ActiveEntity;

class Group extends ActiveEntity
{
  protected $id;
  protected $name;
  protected $users;
}