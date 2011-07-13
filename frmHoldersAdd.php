<?php
    print("<div id=\"$frmHolderAddName\" style=\"display:$defaultDivStyle\">\n");

    if (IsSet($frmHolderAddTableWidth)) {
      print("<table border=\"$mainTableBorder\" width = \"$frmHolderAddTableWidth\">\n");
    } else {
      print("<table border=\"$mainTableBorder\" width = \"$masterTableWidth\">\n");
    }

    for ($idx = 0; $idx < $frmHolderElementCount; $idx++) {
      print("\t<tr width = \"$holderTableRowWidth\">\n");
      print("\t<td width = $holderTableColWidth>");
      print("$frmHolderElementText[$idx]");
      print("\t</td>\n");
      print("\t<td width = \"$holderTableColWidth\">");
      $fieldName = $frmHolderElementNames[$idx];
      $fieldType = $frmHolderElementTypes[$idx];
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
    writeButton("insertHolder", "Insert Holder", "javascript:addHolderToList();");

    print("\t</td>");
    print("\t</tr>\n");
    
    print("</table>\n");
    print("</div>\n");
?>
