<?php

use DoctrineExtensions\ActiveEntity;

abstract class sfDoctrineActiveEntity extends \DoctrineExtensions\ActiveEntity
{
  public function isNew()
  {
    return ! $this->exists();
  }

  public function getPrimaryKey()
  {
    return $this->obtainIdentifier();
  }
}