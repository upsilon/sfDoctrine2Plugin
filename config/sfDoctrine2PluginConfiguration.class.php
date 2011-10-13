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


    if (sfConfig::get('sf_web_debug'))
    {
      require_once __DIR__.'/../lib/debug/sfWebDebugPanelDoctrine.class.php';

      $this->dispatcher->connect('debug.web.load_panels', array('sfWebDebugPanelDoctrine', 'listenToAddPanelEvent'));
    }

    require_once __DIR__.'/../lib/vendor/doctrine/lib/Doctrine/ORM/Tools/Setup.php';
    Doctrine\ORM\Tools\Setup::registerAutoloadGit(__DIR__.'/../lib/vendor/doctrine');

    $classLoader = new \Doctrine\Common\ClassLoader('DoctrineExtensions');
    $classLoader->setIncludePath(__DIR__.'/../lib/vendor/active_entity/lib');
    $classLoader->register();

    $this->dispatcher->connect('component.method_not_found', array($this, 'componentMethodNotFound'));
    $this->dispatcher->connect('context.method_not_found', array($this, 'contextMethodNotFound'));
  }

  public function componentMethodNotFound(sfEvent $event)
  {
    $actions = $event->getSubject();
    $method = $event['method'];
    $args = $event['arguments'];

    if ($method == 'getEntityManager' || $method == 'getEntityManagerFor' || $method == 'getMetadataFor')
    {
      array_unshift($args, $actions->getContext());
      $result = call_user_func_array(array(__CLASS__, $method), $args);
      $event->setReturnValue($result);
      return true;
    }

    return false;
  }

  public function contextMethodNotFound(sfEvent $event)
  {
    $context = $event->getSubject();
    $method = $event['method'];
    $args = $event['arguments'];

    if ($method == 'getEntityManager' || $method == 'getEntityManagerFor' || $method == 'getMetadataFor')
    {
      array_unshift($args, $context);
      $result = call_user_func_array(array(__CLASS__, $method), $args);
      $event->setReturnValue($result);
      return true;
    }

    return false;
  }

  static protected function getEntityManager(sfContext $context, $name = null)
  {
    $databaseManager = $context->getDatabaseManager();
    $names = $databaseManager->getNames();
    if ($name)
    {
      if (!in_array($name, $names))
      {
        throw new sfException(
          sprintf('Could not get the entity manager for '.
                  'the database connection named: "%s"', $name)
        );
      }
      $database = $databaseManager->getDatabase($name);
    } else {
      $database = $databaseManager->getDatabase(end($names));
    }

    return $database->getEntityManager();
  }

  static protected function getEntityManagerFor(sfContext $context, $entityName)
  {
    if (is_object($entityName))
    {
      $entityName = get_class($entityName);
    }
    $databaseManager = $context->getDatabaseManager();
    $names = $databaseManager->getNames();
    foreach ($names as $name)
    {
      $em = $databaseManager->getDatabase($name)->getEntityManager();
      $cmf = $em->getMetadataFactory();
      if ($cmf->hasMetadataFor($entityName))
      {
        return $em;
      }
    }

    return null;
  }

  static protected function getMetadataFor(sfContect $context, $entityName)
  {
    if (is_object($entityName))
    {
      $entityName = get_class($entityName);
    }
    $databaseManager = $context->getDatabaseManager();
    $names = $databaseManager->getNames();
    foreach ($names as $name)
    {
      $em = $databaseManager->getDatabase($name)->getEntityManager();
      $cmf = $em->getMetadataFactory();
      if ($cmf->hasMetadataFor($entityName))
      {
        return $cmf->getMetadataFor($entityName);
      }
    }

    return null;
  }
}
