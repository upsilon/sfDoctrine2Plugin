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
	protected $em;

	public function preExecute()
	{
	  $this->em = $this->getEntityManager();
		parent::preExecute();
	}

  public function executeIndex(sfWebRequest $request)
  {
    $qb = $this->em->createQueryBuilder()
      ->select('u', 'p', 'g')
      ->from('Models\User u')
      ->innerJoin('u.profile', 'p')
      ->leftJoin('u.groups', 'g');

    $q = $qb->getQuery();

    $this->users = $q->execute();
  }

  public function executeEdit_user(sfWebRequest $request)
  {
    $id = $request->getParameter('id');
    $qb = $this->em->createQueryBuilder()
      ->select('u', 'p', 'g')
      ->from('Models\User u')
      ->innerJoin('u.profile', 'p')
      ->leftJoin('u.groups', 'g');

    $q = $qb->getQuery();
    
    $this->user = $q->getSingleResult();

    $this->_processForm($request);
  }

  public function executeNew_user(sfWebRequest $request)
  {
    $this->user = new \Models\User();
    $this->_processForm($request);
  }

  protected function _processForm(sfWebRequest $request)
  {
		$this->form = new ModelsUserForm($this->em, $this->user);
    if ($request->isMethod('post'))
    {
			$this->form->bind($request->getParameter($this->form->getName()));
      $this->form->save();

      $this->redirect('@users');
    }
  }
}