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
 * Base class for all symfony Doctrine tasks.
 *
 * @package    symfony
 * @subpackage doctrine
 * @author     Jonathan H. Wage <jonwage@gmail.com>
 * @version    SVN: $Id: sfDoctrineBaseTask.class.php 15865 2009-02-28 03:34:26Z Jonathan.Wage $
 */
abstract class sfDoctrineBaseTask extends sfBaseTask
{
  protected function prepareDoctrineCliArguments(array $arguments, array $keys = array())
  {
    $args = array();
    if ($keys)
    {
      foreach ($keys as $key)
      {
        if (isset($arguments[$key]) && $value = $arguments[$key])
        {
          $args[] = '--'.$key.'='.implode(',', (array) $value);
        }
      }
    } else {
      foreach ($arguments as $key => $value)
      {
        if ($value !== null)
        {
          $args[] = '--'.$key.'='.implode(',', (array) $value);
        }
      }
    }
    return $args;
  }

  protected function callDoctrineCli($task, $arguments = array())
  {
    $this->databaseManager = new sfDatabaseManager($this->configuration);
    $em = $this->getEntityManager();
    $args = array(
      './doctrine',
      $task
    );

    $args = array_merge($args, $arguments);
    $args[] = '--config='.__DIR__.'/../../config/cli-config.php';
    $args[] = '--class-dir=' . join(",", $em->getConfiguration()->getMetadataDriverImpl()->getPaths());

    $printer = new sfDoctrineCliPrinter();
    $printer->setFormatter($this->formatter);

    $config = new \Doctrine\Common\Cli\Configuration;
    $config->setAttribute("em", $em);

    $cli = new \Doctrine\Common\Cli\CliController($config);
    $cli->run($args);
  }

  protected function getEntityManager($name = null)
  {
    if (!isset($this->databaseManager))
    {
      throw new sfException('No $databaseManager property found.');
    }

    $names = $this->databaseManager->getNames();

    if ($name !== null)
    {
      if (!in_array($name, $names))
      {
        throw new sfException(
          sprintf('Could not get the entity manager for '.
                  'the database connection named: "%s"', $name)
        );
      }
      $database = $this->databaseManager->getDatabase($name);
    } else {
      $database = $this->databaseManager->getDatabase(end($names));
    }

    return $database->getEntityManager();
  }
}