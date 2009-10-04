<?php

/**
 * users actions.
 *
 * @package    test
 * @subpackage users
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class usersActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $em = $this->getEntityManager();

    $qb = $em->createQueryBuilder()
      ->select('u', 'p', 'g')
      ->from('Models\User u')
      ->innerJoin('u.profile', 'p')
      ->leftJoin('u.groups', 'g');

    $q = $qb->getQuery();

    $this->users = $q->execute();
  }

  public function executeEdit_user(sfWebRequest $request)
  {
    $em = $this->getEntityManager();

    $id = $request->getParameter('id');
    $qb = $em->createQueryBuilder()
      ->select('u', 'p', 'g')
      ->from('Models\User u')
      ->innerJoin('u.profile', 'p')
      ->leftJoin('u.groups', 'g');

    $q = $qb->getQuery();
    
    $this->user = $q->getSingleResult();

    $this->_processForm($request, $this->user, $em);
  }

  public function executeNew_user(sfWebRequest $request)
  {
    $em = $this->getEntityManager();
    $this->user = new \Models\User();
    $this->_processForm($request, $this->user, $em);
  }

  protected function _processForm(sfWebRequest $request, \Models\User $user, \Doctrine\ORM\EntityManager $em)
  {
    if ($request->isMethod('post'))
    {
      $this->user->username = $request->getParameter('username');

      if ($password = $request->getParameter('password'))
      {
        $this->user->password = $password;
      }

      $this->user->save();

      $this->redirect('@users');
    }
  }
}