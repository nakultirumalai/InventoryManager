<?php
    print("<div id=\"$frmOperationTHAddName\" style=\"display:$defaultDivStyle\">\n");

    if (IsSet($frmOperationTHAddTableWidth)) {
      print("<table border=\"$mainTableBorder\" width = \"$frmOperationTHAddTableWidth\">\n");
    } else {
      print("<table border=\"$mainTableBorder\" width = \"$masterTableWidth\">\n");
    }

    for ($idx = 0; $idx < $frmOperationTHElementCount; $idx++) {
      print("\t<tr width = \"$operationTHTableRowWidth\">\n");
      print("\t<td width = \"200\">");
      print("$frmOperationTHElementText[$idx]");
      print("\t</td>\n");
      print("\t<td width = \"200\">");
      $fieldName = $frmOperationTHElementNames[$idx];
      $fieldType = $frmOperationTHElementTypes[$idx];
      if ($fieldName == "operationTHHolderName") {
        writeSelectAndAdd($fieldName, $holderNames, 180, "addHolder", "Add New Holder", "javascript:showAddHolder();");
      } else if ($fieldName == "operationTHToolName") {
        writeSelectAndAdd($fieldName, $toolNames, 180, "addTool", "Add New Tool", "javascript:showAddToolSkipSubmit();");
      } else{
        writeTextBox($fieldName, $fieldValue);
      }
      print("\t</td>");
      print("\t</tr>\n");
    }

    print("\t<tr>\n");
    print("\t<td>");
    writeButton("insertHolder", "Insert Tool-Holder", "javascript:addNewToolHolderToList();");

    print("<input type=\"text\" id=\"holderStore\">\n</input>\n");
    print("<input type=\"text\" id=\"toolStore\">\n</input>\n");

    print("\t</td>");
    print("\t</tr>\n");
    
    print("</table>\n");
    print("</div>\n");
?>
