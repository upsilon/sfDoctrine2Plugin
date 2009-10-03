<?php

$configuration = sfProjectConfiguration::getActive();
$databaseManager = new sfDatabaseManager($configuration);
$em = $databaseManager->getDatabase('doctrine')->getEntityManager();
$args = array(
  'classdir' => sfConfig::get('sf_lib_dir').'/entities/Entities'
);