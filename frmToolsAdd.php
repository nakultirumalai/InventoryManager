<?php
    print("<div id=\"$frmToolAddName\" style=\"display:$defaultDivStyle\">\n");
    print("<form action=\"$frmAction?AddTool=true\" method=\"post\" onSubmit = \"return addToolToFormOrSubmit()\";>\n");

    if (IsSet($frmPartAddTableWidth)) {
      print("<table border=\"$mainTableBorder\" width = \"$frmToolAddTableWidth\">\n");
    } else {
      print("<table border=\"$mainTableBorder\" width = \"$masterTableWidth\">\n");
    }

    for ($idx = 0; $idx < $frmToolElementCount; $idx++) {
      print("\t<tr width = \"$masterTableRowWidth\">\n");
      print("\t<td width = \"$masterTableColWidth\">");
      print("$frmToolElementText[$idx]");
      print("\t</td>\n");
      print("\t<td width = \"$masterTableColWidth\">");
      $fieldName = $frmToolElementNames[$idx];
      $fieldType = $frmToolElementTypes[$idx];
      if ($fieldName == "toolType") {
        writeSelect($fieldName, $toolTypes);
      } else if ($fieldName == "toolSupplier") {
        writeSelectAndAdd($fieldName, $supplierNames, 250, "addSupplier", "Add Supplier", "javascript:showAddSupplierSkipSubmit();");
      } else {
        writeTextBox($fieldName, $fieldValue);
      }

      /* Add the inserts list for the first row with
         a column span of size $frmToolElementCount */
      /* A list of inserts that have been added for this tool */
      if ($idx == 0) {
        print("\t<td>");
        print("Inserts for the part:<br>");
        print("\t</td>");
      }
      if ($idx == 1) {
        print("\t<td valign=\"top\" rowspan=\"$frmToolElementCount\">");
        writeSelectAndAdd("insertSelect", $insertPartNumbers, 250, "createInsert", "Create Insert", "javascript:showAddInsert();");
	writeButton("addInsert", "Add Insert", "javascript:addInsertToList();");
        print("<select id = \"insertList\" size = \"$frmToolElementCount\" style=\"width:250\">\n");
        print("</select>");
        print("<br>");
        print("\t</td>");
      }
      print("\t</td>");
      print("\t</tr>\n");
    } 

    print("\t<tr>\n");
    print("\t<td>");
    writeSubmit("addTool", "Insert Tool");

   /* A hidden textbox to store the tools for posting */
    print("\t<input type = \"hidden\" id = \"insertStore\" name = \"insertStore\" />\n");
    print("\t<input type = \"hidden\" id = \"insertsForToolStore\" name = \"insertsForToolStore\" />\n");
    print("\t<input type = \"hidden\" id = \"supplierStore\" name = \"supplierStore\" />\n");

    print("\t</td>");
    print("\t</tr>\n");

    print("</table>\n");
    print("</form>\n");
    print("</div>\n");
?>
