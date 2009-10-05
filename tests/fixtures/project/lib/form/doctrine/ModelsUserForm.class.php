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
    $profile = $this->object->profile ? $this->object->profile:new \Models\Profile();
    $this->object->profile = $profile;
    $profile->user = $this->object;

    $profileForm = new ModelsProfileForm($this->em, $profile);
    $profileForm->useFields(array('firstName', 'lastName'));
    unset($profileForm['id']);

    $this->embedForm('profile', $profileForm);

    $this->widgetSchema['password'] = new sfWidgetFormInputPassword();
  }
}
