<?php

/**
 * ModelsProfile form base class.
 *
 * @package    test
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id$
 */
class BaseModelsProfileForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'firstName' => new sfWidgetFormInputText(array()),
      'lastName'  => new sfWidgetFormInputText(array()),
      'userId'    => new sfWidgetFormDoctrineChoice($this->em, array('model' => 'Models\User', 'add_empty' => true)),
      'id'        => new sfWidgetFormInputHidden(array()),
    ));

    $this->setValidators(array(
      'firstName' => new sfValidatorString(array('max_length' => 255)),
      'lastName'  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'userId'    => new sfValidatorDoctrineChoice($this->em, array('model' => 'Models\User', 'required' => false)),
      'id'        => new sfValidatorDoctrineChoice($this->em, array('model' => 'Models\Profile', 'column' => '', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('models_profile[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Models\Profile';
  }

}
