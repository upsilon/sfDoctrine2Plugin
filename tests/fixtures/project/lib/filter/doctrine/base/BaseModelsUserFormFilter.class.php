<?php

/**
 * ModelsUser filter form base class.
 *
 * @package    test
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id$
 */
class BaseModelsUserFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'isActive' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'username' => new sfWidgetFormFilterInput(),
      'password' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'isActive' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'username' => new sfValidatorPass(array('required' => false)),
      'password' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('models_user_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Models\User';
  }

  public function getFields()
  {
    return array(
      'isActive' => 'Boolean',
      'username' => 'Text',
      'password' => 'Text',
      'id'       => 'Number',
    );
  }
}
