<?php
    print("<div id=\"$frmMachineAddName\" style=\"display:$defaultDivStyle\">\n");
    if (IsSet($frmMachineTableWidth)) {
      print("<table border=\"$mainTableBorder\" width = \"$frmMachineTableWidth\">\n");
    } else {
      print("<table border=\"$mainTableBorder\" width = \"$masterTableWidth\">\n");
    }

    for ($idx = 0; $idx < $frmMachineElementCount; $idx++) {
      print("\t<tr width = \"$machineTableRowWidth\">\n");
      print("\t<td width = $machineTableColWidth>");
      print("$frmMachineElementText[$idx]");
      print("\t</td>\n");
      print("\t<td width = \"$machineTableColWidth\">");
      $fieldName = $frmMachineElementNames[$idx];
      $fieldType = $frmMachineElementTypes[$idx];
      $fieldValue = "";
      writeTextBox($fieldName, $fieldValue); 
      print("\t</td>");
      print("\t</tr>\n");
    }

    print("\t<tr>\n");
    print("\t<td>");
    writeButton("addMachine", "Add Machine", "javascript:addMachineToList();showPreviousForm();");

    print("\t</td>");
    print("\t</tr>\n");
    
    print("</table>\n");
    print("</div>\n");
?>
