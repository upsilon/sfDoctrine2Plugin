<?php

/**
 * ModelsGroup form base class.
 *
 * @package    test
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id$
 */
class BaseModelsGroupForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name' => new sfWidgetFormInputText(array()),
      'id'   => new sfWidgetFormInputHidden(array()),
    ));

    $this->setValidators(array(
      'name' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'id'   => new sfValidatorDoctrineChoice($this->em, array('model' => 'Models\Group', 'column' => '', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('models_group[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Models\Group';
  }

}
