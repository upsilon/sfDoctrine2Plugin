<?php

use DoctrineExtensions\ActiveEntity\ActiveEntity;

abstract class sfDoctrineActiveEntity extends ActiveEntity
{
  public function isNew()
  {
    return ! $this->exists();
  }

  public function getPrimaryKey()
  {
    return $this->obtainIdentifier();
  }

  public function getIdentifier()
  {
    $identifierArray = $this->obtainIdentifier();
    if (count($identifierArray) > 1)
    {
      throw new RuntimeException("Composite keys not supported");
    }
    return current($identifierArray);
  }
}