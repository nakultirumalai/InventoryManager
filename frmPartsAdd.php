<?php
    print("<div id=\"$frmPartAddName\" style=\"display:$defaultDivStyle\">\n");
    print("<form action=\"$frmAction?AddPart=true\" method=\"post\" enctype = \"multipart/form-data\">\n");

    if (IsSet($frmPartAddTableWidth)) {
      print("<table border=\"$mainTableBorder\" width = \"$frmPartAddTableWidth\" cellspacing=\"10\">\n");
    } else {
      print("<table border=\"$mainTableBorder\" width = \"$masterTableWidth\" cellspacing=\"10\">\n");
    }

    for ($idx = 0; $idx < $frmPartElementCount; $idx++) {
      print("\t<tr>\n");
      print("\t<td>");
      print("$frmPartElementText[$idx]");
      print("\t</td>\n");
      print("\t<td>");
      $fieldName = $frmPartElementNames[$idx];
      $fieldType = $frmPartElementTypes[$idx];
      if (IsSet($_POST[$fieldName])) {
        $fieldValue = $_POST[$fieldName];
      } else {
        $fieldValue = "";
      }
      if ($fieldName == "partDrawingFilePath") {
        writeInputFile($fieldName);
      } else if ($fieldName == "partPreviewImage") {
        writeInputFile($fieldName);
      } else if ($fieldName == "partCustomerName") {
        writeSelectAndAdd($fieldName, $customerNames, 180, "addCustomer", "Add Customer", "javascript:showAddCustomer();");
      } else {
        writeTextBox($fieldName, $fieldValue);
      }
      print("\t</td>");
      
      /* Add the operations list for the first row with
         a column span of size $frmPartElementCount */
      /* A list of operations that have been added for this part */
      if ($idx == 0) {
        print("\t<td>");
        print("Operations added:<br>");
        print("\t</td>");
      }
      if ($idx == 1) {
        print("\t<td valign=\"top\" rowspan=\"$frmPartElementCount\">");
        print("<select id = \"operationList\" size = \"$frmPartElementCount\" style=\"width:250\">\n");
        print("</select>");
	print("<br>");
	writeButton("addOperation", "Create Operation", "javascript:showAddOperation();");
	writeButton("addOperation", "Delete Operation", "javascript:deleteSelectedOperation();");
        print("\t</td>");
      }
      print("\t</tr>\n");
    }
    
    /* A hidden textbox to store the Operations for posting */
    writeTextBox("operationStore", "");
    writeTextBox("customerStore", "");
    writeTextBox("operationDeleteList", "");

    print("</table>\n");
    writeSubmit("addPart", "Add part");
    print("</form>\n");
    print("</div>\n");
?>
