<?php

$app = 'frontend';
$fixtures = true;
require_once(dirname(__FILE__).'/../bootstrap/functional.php');

$b = new sfTestFunctional(new sfBrowser());
$b->setTester('doctrine', 'sfTesterDoctrine');

$info = array(
	'models_user' => array(
		'isActive' => true,
		'username' => 'jonwage2',
		'password' => 'newpassword'
	)
);

$checkInfo = array(
	'isActive' => true,
	'username' => 'jonwage2',
	'password' => md5('newpassword')
);

$b->
  get('/users')->
  click('Jonathan Wage (jwage)')->
  click('Save', $info)->
	with('form')->begin()->
		hasErrors(false)->
	end()->
  with('doctrine')->begin()->
    check($em, 'Models\User', $checkInfo)->
  end()->
	with('response')->begin()->
		isRedirected(true)->
		followRedirect()->
	end()
;

$info = array(
	'models_user' => array(
		'isActive' => false,
		'username' => 'jwage',
		'password' => 'changeme'
	)
);

$checkInfo = array(
	'isActive' => 0,
	'username' => 'jwage',
	'password' => md5('changeme')
);

$b->
	click('New User')->
	  click('Save', $info)->
		with('form')->begin()->
			hasErrors(false)->
		end()->
	  with('doctrine')->begin()->
	    check($em, 'Models\User', $checkInfo)->
	  end()->
		with('response')->begin()->
			isRedirected(true)->
			followRedirect()->
		end()
	;