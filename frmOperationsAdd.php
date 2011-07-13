<?php
    print("<div id=\"$frmOperationAddName\" style=\"display:$defaultDivStyle\">\n");

    /*
    if (IsSet($frmOperationAddTableWidth)) {
      print("<table border=\"$mainTableBorder\" width = \"$frmOperationAddTableWidth\">\n");
    } else {
      print("<table border=\"$mainTableBorder\" width = \"$masterTableWidth\">\n");
    }
    */
      print("<table border=\"$mainTableBorder\">\n");
    for ($idx = 0; $idx < $frmOperationElementCount; $idx++) {
      print("\t<tr width = \"$operationTableRowWidth\">\n");
      print("\t<td width = \"200\">");
      print("$frmOperationElementText[$idx]");
      print("\t</td>\n");
      print("\t<td width = \"300\">");
      $fieldName = $frmOperationElementNames[$idx];
      $fieldType = $frmOperationElementTypes[$idx];
      $fieldValue = "";
      if ($frmOperationElementDBNames[$idx] == "Name") {
        writeSelect($fieldName, $frmOperationNameValues);
      } else if ($frmOperationElementDBNames[$idx] == "Machine") {
        writeSelectAndAdd($fieldName, $machineNames, 180, "createMachine", "Add Machine", "javascript:showAddMachine();");
      } else {
        writeTextBox($fieldName, $fieldValue);
      }
      /* Add the tools list for the first row with
         a column span of size $frmOperationElementCount */
      /* A list of tools that have been added for this operation */
      print("\t</td>");
      print("\t</tr>\n");
    }

    print("\t<td valign=\"center\">");
    print("Tools and Holders added:<br>");
    print("\t</td>");
    print("\t<td valign=\"center\">");
    writeSelectMultiline("opToolHolderList", 10, 275);
    print("<br>");
    writeButton("createToolHolder", "Add tool-holder", "javascript:showAddToolHolder();");
    print("\t</td>\n");

    print("\t<tr>");
    print("\t<td valign=\"center\">");
    print("Programs added:<br>");
    print("\t</td>");
    print("\t<td valign=\"center\">");
    writeSelectMultiline("opProgramList", 10, 275);
    print("<br>");
    writeButton("createProgram", "Create Program", "javascript:showAddProgram();");
    print("\t</td>");
    print("</tr>");

    print("\t<tr>\n");
    print("\t<td>\n");
    writeButton("addOperation", "Insert Operation", "javascript:addOperationToList();");
    print("\t</td>\n");
    print("\t<td>\n");
    writeButton("addOperation", "Cancel", "javascript:clearForm();showPreviousForm();");
    print("\t</td>\n");
    writeTextBox("programStore", "");
    writeTextBox("toolHolderStore", "");
    writeTextBox("machineStore", "");
    print("\t</td>");
    print("\t<td></td>");
    print("\t</tr>\n");
    
    print("</table>\n");
    print("</div>\n");
?>
