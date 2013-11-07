<?php if(!defined('APPLICATION')) exit();
/* Copyright 2013 Zachary Doll */

// Gnab the rules so we can render the first criteria form by default
$Rules = $this->GetRules();

if(property_exists($this, 'Badge')) {
  echo Wrap(T('Edit Badge'), 'h1');
  $RuleClass = $this->Badge->RuleClass;
}
else {
  echo Wrap(T('Add Badge'), 'h1');
  reset($Rules);
  $RuleClass = key($array);
}

echo $this->Form->Open(array('enctype' => 'multipart/form-data', 'class' => 'Badge'));
echo $this->Form->Errors();
?>
<ul>
  <li>
    <?php
    echo $this->Form->Label('Photo', 'PhotoUpload');
    $Photo = $this->Form->GetValue('Photo');
    if($Photo) {
      echo Img(Gdn_Upload::Url($Photo));
      echo '<br />'.Anchor(T('Delete Photo'), 
        CombinePaths(array('badges/deletephoto', $this->Badge->BadgeID, Gdn::Session()->TransientKey())), 
      'SmallButton Danger PopConfirm');
    }
    echo $this->Form->Input('PhotoUpload', 'file');
    ?>
  </li>
  <li>
    <?php
    echo $this->Form->Label('Name', 'Name');
    echo $this->Form->TextBox('Name');
    ?>
  </li>
  <li>
    <?php
    echo $this->Form->Label('Description', 'Description');
    echo $this->Form->TextBox('Description');
    ?>
  </li>
  <li>
    <?php
    echo $this->Form->Label('Rule', 'RuleClass');
    echo $this->Form->Dropdown('RuleClass', $Rules);
    ?>
  </li>
  <li id="Rule-Criteria">
  <?php
    // Save the Prefix for later
    $Prefix = $this->Form->InputPrefix;
    $this->Form->InputPrefix = $Prefix . '_Rules';
    $Rule = new $RuleClass();
    $Rule->RenderCriteriaInterface($this->Form);
    // Restore the prefix
    $this->Form->InputPrefix = $Prefix;
  ?>
  </li>
  <li>
    <?php
    echo $this->Form->Label('Award Value', 'AwardValue');
    echo $this->Form->TextBox('AwardValue');
    ?>
  </li>
  <li>
    <?php
    echo $this->Form->Label('Active', 'Enabled');
    echo $this->Form->CheckBox('Enabled');
    ?>
  </li>

</ul>
<?php
echo $this->Form->Close('Save');
