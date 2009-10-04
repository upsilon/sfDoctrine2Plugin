<?php

/**
 * ModelsUser form base class.
 *
 * @package    test
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id$
 */
class BaseModelsUserForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'isActive' => new sfWidgetFormInputCheckbox(array()),
      'username' => new sfWidgetFormInputText(array()),
      'password' => new sfWidgetFormInputText(array()),
      'id'       => new sfWidgetFormInputHidden(array()),
    ));

    $this->setValidators(array(
      'isActive' => new sfValidatorBoolean(array('required' => false)),
      'username' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'password' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'id'       => new sfValidatorDoctrineChoice($this->em, array('model' => 'Models\User', 'column' => '', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('models_user[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Models\User';
  }

}
