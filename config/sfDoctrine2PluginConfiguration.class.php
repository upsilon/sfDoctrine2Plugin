<?php

/*
 * This file is part of the symfony package.
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 * (c) Jonathan H. Wage <jonwage@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfDoctrine2Plugin configuration class
 *
 * @package    symfony
 * @subpackage doctrine
 * @author     Jonathan H. Wage <jonwage@gmail.com>
 * @version    SVN: $Id: sfDoctrine2PluginConfiguration.class.php 15865 2009-02-28 03:34:26Z Jonathan.Wage $
 */
class sfDoctrine2PluginConfiguration extends sfPluginConfiguration
{
  public function initialize()
  {
	  sfConfig::set('sf_orm', 'doctrine');

    if (!sfConfig::get('sf_admin_module_web_dir'))
    {
      sfConfig::set('sf_admin_module_web_dir', '/sfDoctrine2Plugin');
    }

    require_once __DIR__.'/../lib/vendor/doctrine/Doctrine/Common/IsolatedClassLoader.php';

    $classLoader = new \Doctrine\Common\IsolatedClassLoader('DoctrineExtensions');
    $classLoader->setBasePath(__DIR__.'/../lib/vendor/active_entity');
    $classLoader->register();

    $classLoader = new \Doctrine\Common\IsolatedClassLoader('Doctrine');
    $classLoader->setBasePath(__DIR__.'/../lib/vendor/doctrine');
    $classLoader->register();

    $classLoader = new \Doctrine\Common\IsolatedClassLoader('Models');
    $classLoader->setBasePath(sfConfig::get('sf_lib_dir').'/models');
    $classLoader->register();

    $this->dispatcher->connect('component.method_not_found', array($this, 'componentMethodNotFound'));
  }

  public function componentMethodNotFound(sfEvent $event)
  {
    $actions = $event->getSubject();
    $method = $event['method'];
    $args = $event['arguments'];

    if ($method == 'getEntityManager')
    {
      $databaseManager = $actions->getContext()->getDatabaseManager();
      $names = $databaseManager->getNames();
      if ($args)
      {
        $name = $args[0];
        if (!in_array($name, $names))
        {
          throw new sfException(
            sprintf('Could not get the entity manager for '.
                    'the database connection named: "%s"', $name)
          );
        }
        $database = $databaseManager->getDatabase($args[0]);
      } else {
        $database = $databaseManager->getDatabase(end($names));
      }

      $event->setReturnValue($database->getEntityManager());

      return true;
		}
		else if ($method == 'getEntityManagerFor')
		{
			$databaseManager = $actions->getContext()->getDatabaseManager();
      $names = $databaseManager->getNames();
			foreach ($names as $name)
			{
				$em = $databaseManager->getDatabase($name)->getEntityManager();
				$cmf = $em->getMetadataFactory();
				if ($cmf->hasMetadataFor($args[0]))
				{
					$event->setReturnValue($em);
					return true;
				}
			}
			return false;
    }
		else if ($method == 'getMetadataFor')
		{
			$databaseManager = $actions->getContext()->getDatabaseManager();
      $names = $databaseManager->getNames();
			foreach ($names as $name)
			{
				$em = $databaseManager->getDatabase($name)->getEntityManager();
				$cmf = $em->getMetadataFactory();
				if ($cmf->hasMetadataFor($args[0]))
				{
					$event->setReturnValue($cmf->getMetadataFor($args[0]));
					return true;
				}
			}
			return false;
		}
		else
		{
      return false;
    }
  }
}