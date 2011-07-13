<?php
    print("<div id=\"$frmInsertAddName\" style=\"display:$defaultDivStyle\">\n");

    if (IsSet($frmInsertAddTableWidth)) {
      print("<table border=\"$mainTableBorder\" width = \"$frmInsertAddTableWidth\">\n");
    } else {
      print("<table border=\"$mainTableBorder\" width = \"$masterTableWidth\">\n");
    }

    for ($idx = 0; $idx < $frmInsertElementCount; $idx++) {
      print("\t<tr width = \"$insertTableRowWidth\">\n");
      print("\t<td width = $insertTableColWidth>");
      print("$frmInsertElementText[$idx]");
      print("\t</td>\n");
      print("\t<td width = \"$insertTableColWidth\">");
      $fieldName = $frmInsertElementNames[$idx];
      $fieldType = $frmInsertElementTypes[$idx];
      if (IsSet($_POST[$fieldName])) {
        $fieldValue = $_POST[$fieldName];
      } else {
        $fieldValue = "";
      }
      writeTextBox($fieldName, $fieldValue);
      print("\t</td>");
      print("\t</tr>\n");
    }

    print("\t<tr>\n");
    print("\t<td>");
    writeButton("addInsert", "Add Insert", "javascript:addInsertToSelect();");

    print("\t</td>");
    print("\t</tr>\n");
    
    print("</table>\n");
    print("</div>\n");
?>
