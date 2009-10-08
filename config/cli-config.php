<?php

$configuration = sfProjectConfiguration::getActive();
$databaseManager = new sfDatabaseManager($configuration);
$names = $databaseManager->getNames();
$em = $databaseManager->getDatabase(end($names))->getEntityManager();
$args = array(
  'class-dir' => sfConfig::get('sf_lib_dir').'/entities/Entities'
);