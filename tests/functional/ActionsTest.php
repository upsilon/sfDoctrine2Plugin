<?php

$app = 'frontend';
$fixtures = true;
require_once(dirname(__FILE__).'/../bootstrap/functional.php');

$b = new sfTestFunctional(new sfBrowser());
$b->setTester('doctrine', 'sfTesterDoctrine');

$b->
  get('/users')->
  click('Jonathan Wage (jwage)')->
  click('Save', array('username' => 'jonwage', 'password' => 'newpassword'))->
  with('doctrine')->begin()->
    check($em, 'Models\User', array('username' => 'jonwage', 'password' => md5('newpassword')))->
  end()
;