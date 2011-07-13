<?php
    print("<div id=\"$frmSupplierAddName\" style=\"display:$defaultDivStyle\">\n");
    print("<form action=\"$frmAction?AddSupplier=true\" method=\"post\" onSubmit=\"return addSupplierToFormOrSubmit();\">\n");

    if (IsSet($frmSupplierAddTableWidth)) {
      print("<table border=\"$mainTableBorder\" width = \"$frmSupplierTableWidth\">\n");
    } else {
      print("<table border=\"$mainTableBorder\" width = \"$masterTableWidth\">\n");
    }

    for ($idx = 0; $idx < $frmSupplierElementCount; $idx++) {
      print("\t<tr width = \"$supplierTableRowWidth\">\n");
      print("\t<td width = $supplierTableColWidth>");
      print("$frmSupplierElementText[$idx]");
      print("\t</td>\n");
      print("\t<td width = \"$supplierTableColWidth\">");
      $fieldName = $frmSupplierElementNames[$idx];
      $fieldType = $frmSupplierElementTypes[$idx];
      $fieldValue = "";
      writeTextBox($fieldName, $fieldValue);
      print("\t</td>");
      print("\t</tr>\n");
    }

    print("\t<tr>\n");
    print("\t<td>");
    writeSubmit("addSupplier", "Add Supplier");

    print("\t</td>");
    print("\t</tr>\n");
    
    print("</table>\n");
    print("</form>\n");
    print("</div>\n");
?>
