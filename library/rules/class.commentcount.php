<?php if(!defined('APPLICATION')) exit();

/**
 * This rule awards badges based on a user's comment count
 *
 * @author Zachary Doll
 * @since 1.0
 * @package Yaga
 */
class CommentCount implements YagaRule{

  public function Award($Sender, $User, $Criteria) {
    $Result = FALSE;
    switch($Criteria->Comparison) {
      case 'gt':
        if($User->CountComments > $Criteria->Target) {
          $Result = TRUE;
        }
        break;
      case 'lt':
        if($User->CountComments < $Criteria->Target) {
          $Result = TRUE;
        }
        break;
      default:
      case 'gte':
        if($User->CountComments >= $Criteria->Target) {
          $Result = TRUE;
        }
        break;
    }

    return $Result;
  }

  public function Form($Form) {
    $Comparisons = array(
        'gt' => T('More than:'),
        'lt' => T('Less than:'),
        'gte' => T('More than or:')
    );

    $String = $Form->Label('Yaga.Rules.CommentCount.Criteria.Head', 'CommentCount');
    $String .= $Form->DropDown('Comparison', $Comparisons) . ' ';
    $String .= $Form->Textbox('Target', array('class' => 'SmallInput'));

    return $String;
  }

  public function Validate($Criteria, $Form) {
    $Validation = new Gdn_Validation();
    $Validation->ApplyRules(array(
        array(
          'Name' => 'Target', 'Validation' => array('Required', 'Integer')
        ),
        array(
          'Name' => 'Comparison', 'Validation' => 'Required'
        )
    ));
    $Validation->Validate($Criteria);
    $Form->SetValidationResults($Validation->Results());
  }
  public function Hooks() {
    return array('Gdn_Dispatcher_AppStartup');
  }

  public function Description() {
    $Description = T('Yaga.Rules.CommentCount.Desc');
    return Wrap($Description, 'div', array('class' => 'InfoMessage'));
  }

  public function Name() {
    return T('Yaga.Rules.CommentCount');
  }
  
  public function Interacts() {
    return FALSE;
  }
}
