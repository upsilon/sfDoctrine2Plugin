<?php

/**
 * ModelsProfile filter form base class.
 *
 * @package    test
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id$
 */
class BaseModelsProfileFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'firstName' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'lastName'  => new sfWidgetFormFilterInput(),
      'userId'    => new sfWidgetFormDoctrineChoice(array('model' => 'Models\User', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'firstName' => new sfValidatorPass(array('required' => false)),
      'lastName'  => new sfValidatorPass(array('required' => false)),
      'userId'    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'Models\User', 'column' => '')),
    ));

    $this->widgetSchema->setNameFormat('models_profile_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Models\Profile';
  }

  public function getFields()
  {
    return array(
      'firstName' => 'Text',
      'lastName'  => 'Text',
      'userId'    => 'ForeignKey',
      'id'        => 'Number',
    );
  }
}
