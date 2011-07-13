<?php
    print("<div id=\"$frmCustomerAddName\" style=\"display:$defaultDivStyle\">\n");

    if (IsSet($frmCustomerAddTableWidth)) {
      print("<table border=\"$mainTableBorder\" width = \"$frmCustomerAddTableWidth\">\n");
    } else {
      print("<table border=\"$mainTableBorder\" width = \"$masterTableWidth\">\n");
    }

    for ($idx = 0; $idx < $frmCustomerElementCount; $idx++) {
      print("\t<tr width = \"$customerTableRowWidth\">\n");
      print("\t<td width = $customerTableColWidth>");
      print("$frmCustomerElementText[$idx]");
      print("\t</td>\n");
      print("\t<td width = \"$customerTableColWidth\">");
      $fieldName = $frmCustomerElementNames[$idx];
      $fieldType = $frmCustomerElementTypes[$idx];
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
    writeButton("insertCustomer", "Insert Customer", "javascript:addNewCustomer();");

    print("\t</td>");
    print("\t</tr>\n");
    
    print("</table>\n");
    print("</div>\n");
?>
