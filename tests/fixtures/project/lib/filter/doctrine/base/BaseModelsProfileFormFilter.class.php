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
      'lastName'  => new sfWidgetFormFilterInput(array()),
      'userId'    => new sfWidgetFormDoctrineChoice($this->em, array('model' => 'Models\User', 'add_empty' => true)),
      'userId'    => new sfWidgetFormDoctrineChoice($this->em, array('model' => 'Models\User', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'firstName' => new sfValidatorPass(array('required' => false)),
      'lastName'  => new sfValidatorPass(array('required' => false)),
      'userId'    => new sfValidatorDoctrineChoice($this->em, array('required' => false, 'model' => 'Models\User', 'column' => 'userId')),
      'userId'    => new sfValidatorDoctrineChoice($this->em, array('required' => false, 'model' => 'Models\User', 'column' => 'userId')),
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
      'id'        => 'Number',
      'firstName' => 'Text',
      'lastName'  => 'Text',
      'userId'    => 'ForeignKey',
      'userId'    => 'ForeignKey',
    );
  }
}
