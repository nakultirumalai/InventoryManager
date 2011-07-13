<?php
    print("<div id=\"$frmProgramAddName\" style=\"display:$defaultDivStyle\">\n");
    if (IsSet($frmProgramAddTableWidth)) {
      print("<table border=\"$mainTableBorder\" width = \"$frmProgramTableWidth\">\n");
    } else {
      print("<table border=\"$mainTableBorder\" width = \"$masterTableWidth\">\n");
    }

    for ($idx = 0; $idx < $frmProgramElementCount; $idx++) {
      print("\t<tr width = \"$programTableRowWidth\">\n");
      print("\t<td width = $programTableColWidth>");
      print("$frmProgramElementText[$idx]");
      print("\t</td>\n");
      print("\t<td width = \"$programTableColWidth\">");
      $fieldName = $frmProgramElementNames[$idx];
      $fieldValue = "";
      if ($fieldName == "programType") {
        print("\t<select id = \"programType\" name = \"programType\" style=\"width:180\">\n");
        print("\t<option selected>Main program</option>");
	print("\t<option>Sub-program</option>");
        print("\t</select>\n");
      } else if ($fieldName == "programCode") {
        writeTextArea($fieldName, $fieldValue, 5, 40);
      } else {
        writeTextBox($fieldName, $fieldValue);
      }
      print("\t</td>");
      print("\t</tr>\n");
    }

    print("\t<tr>\n");
    print("\t<td>");
    writeButton("addProgram", "Add Program", "javascript:addProgramToList();");

    print("\t</td>");
    print("\t</tr>\n");
    
    print("</table>\n");
    print("</div>\n");
?>
