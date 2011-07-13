<?php
  function writeTextBox($txtName, $txtValue) {
    print("<input type=TEXT ");
    print("id=\"$txtName\" ");
    print("value=\"$txtValue\" ");
    print("name=\"$txtName\" ");
    print("/>\n");
  }
  function writeHidden($txtName, $txtValue) {
    print("<input type = \"hidden\" ");
    print("id = \"$txtName\" ");
    print("name = \"$txtName\" ");
    print("value = \"$txtValue\" ");
    print("/>\n");
  }
  function writeTextArea($txtName, $txtValue, $txtRows, $txtCols) {
    print("<textarea ");
    print("id = \"$txtName\" ");
    print("name = \"$txtName\" ");
    print("rows = \"$txtRows\" ");
    print("cols = \"$txtCols\" ");
    print(">\n");
    print("$txtValue\n");
    print("</textarea>\n");
  }
  function writeRadio($radioName, $radioValue) {
    print("<input type = \"radio\" ");
    print("name = \"$radioName\" ");
    print("value = \"$radioValue\" ");
    print("/>\n");
  }
  function writeCheckBox($chkBoxName, $chkBoxValue, $chkBoxChecked) {
    print("<input type = \"checkbox\" ");
    print("name = \"$chkBoxName\" ");
    print("value = \"$chkBoxValue\" ");
    if ($checkBoxChecked == true) {
      print("checked = \"yes\" ");
    }
    print("/>\n");
  }
  function writeSubmit($submitName, $submitValue) {
    print("<input type = \"submit\" ");
    print("name = \"$submitName\" ");
    print("value = \"$submitValue\" ");
    print("/>\n");
  }
  function writeInputFile($inputFileName, $inputFileValue) {
    print("<input type = \"file\" ");
    print("name = \"$inputFileName\" ");
    print("/>\n");
  }
  function writeButton($buttonName, $buttonValue, $onClickAction) {
    print("<input type = \"button\" ");
    print("name = \"$buttonName\" ");
    print("id = \"$buttonName\" ");
    print("value = \"$buttonValue\" ");
    print("onClick = \"$onClickAction\" ");
    print("/>\n");
  }
  function writeSelect($selectId, $optionNames) {
    print("<select id = \"$selectId\" style=\"width:180\" name = \"$selectId\">\n");
    if (IsSet($optionNames)) {
      $optCount = count($optionNames);
      for($idx=0; $idx < $optCount; $idx++) {
        print("\t<option> $optionNames[$idx] </option>\n");
      }
    }
    print("</select>\n");
  }
  function writeSelectMultiline($selectId, $size, $selectWidth, $optionNames) {
    if (IsSet($selectWidth)) {
      print("<select id = \"$selectId\" size = \"$size\" style=\"width:$selectWidth\" name = \"$selectId\">\n");
    } else {
      print("<select id = \"$selectId\" size = \"$size\" style=\"width:180\" name = \"$selectId\">\n");
    }
    if (IsSet($optionNames)) {
      $optCount = count($optionNames);
      for($idx=0; $idx < $optCount; $idx++) {
        print("\t<option> $optionNames[$idx] </option>\n");
      }
    }
    print("</select>\n");
  }
  function writeSelectAndAdd($selectId, $selectValues, $selectWidth, $addButtonName, $addButtonCaption, $javaScriptButtonAction) {
    print("<p>");
    if (IsSet($selectWidth)) {
      print("<select id = \"$selectId\" style=\"width:$selectWidth\" name = \"$selectId\">\n");
    } else {
      print("<select id = \"$selectId\" style=\"width:180\" name = \"$selectId\">\n");
    }
    $optionCount = count($selectValues);
    for ($idx = 0; $idx < $optionCount; $idx++) {
      print("<option value = \"$selectValues[$idx]\">$selectValues[$idx]</option>\n");
    }
    print("</select>\n");
    writeButton($addButtonName, $addButtonCaption, $javaScriptButtonAction);
    print("</p>");    
  }
?>
