<?php

/**
 * ModelsUser form.
 *
 * @package    test
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id$
 */
class ModelsUserForm extends BaseModelsUserForm
{
  public function configure()
  {
    $profile = isset($this->object->profile) ? $this->object->profile:new \Models\Profile();
    $this->object->profile = $profile;

    $profileForm = new ModelsProfileForm($this->em, $profile);
    $profileForm->useFields(array('firstName', 'lastName'));
    $this->embedForm('profile', $profileForm);
  }
}
