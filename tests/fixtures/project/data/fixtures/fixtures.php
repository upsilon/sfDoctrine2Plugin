<?php

$em = $this->getEntityManager();

$admin = new \Models\User();
$admin->username = 'admin';
$admin->password = 'changeme';

$jwage = new \Models\User();
$jwage->username = 'jwage';
$jwage->password = 'changeme';

$profile = new \Models\Profile();
$profile->firstName = 'Jonathan';
$profile->lastName = 'Wage';
$jwage->profile = $profile;
$profile->user = $jwage;

$group = new \Models\Group();
$group->name = 'Admin';
$group->addUsers($jwage);
$group->addUsers($admin);