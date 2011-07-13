<?php
    $frmOperationShowName="OperationShow";
    print("<div id=\"$frmOperationAddName\" style=\"display:$defaultDivStyle\">\n");

    /* Variable that adds a unique prefix to the 
       element names in this form */
    $frmElementPrefix = "operation";

    /* Variable indicating number of elements in the form */
    $frmElementCount = 5;

    /* Variable array to store the names of the elements */
    $frmElementText = array ('Operation name', 'Machine ID', 'Operation description', 'Operation cutting time', 'Operation clamping time');

    /* Variable array to store the names of the colums in the Database */
    $frmElementDBNames = array ('Name', 'MachineID', 'Description', 'CuttingTime', 'ClampingTime');

    /* Variable for row & column widths of the local table */
    $operationTableWidth = 570;
    $operationTableRowWidth = $operationTableWidth;
    $operationTableColWidth = "100%";

    /* Variable array to store the names of the elements */
    $itemCount=0;
    while ($itemCount < $frmElementCount) {
      $frmElementNames[$itemCount] = "$frmElementPrefix$frmElementDBNames[$itemCount]";
      $frmElementTypes[$itemCount] = "text";
      $itemCount++;
    };

    print("<table border=\"0.5\" width = \"$operationTableWidth\">\n");
    for ($idx = 0; $idx < $frmElementCount; $idx++) {
      print("\t<tr width = \"$operationTableRowWidth\">\n");
      print("\t<td width = $operationTableColWidth>");
      print("$frmElementText[$idx]");
      print("\t</td>\n");
      print("\t<td width = \"$operationTableColWidth\">");
      $fieldName = $frmElementNames[$idx];
      $fieldType = $frmElementTypes[$idx];
      if (IsSet($_POST[$fieldName])) {
        $fieldValue = $_POST[$fieldName];
      } else {
        $fieldValue = "";
      }
      writeTextBox($fieldName, $fieldValue);
      if ($frmElementDBNames[$idx] == "MachineID") {
        print("\t<td>");
        writeButton("findMachineID","Find machine ID", "javascript:void();");
        print("\t</td>\n");
      }
      print("\t</td>");
      print("\t</tr>\n");
    }

    print("\t<tr>\n");
    print("\t<td>");
    writeButton("addOperation", "Add Operation", "javascript:void();");
    print("\t</td>");
    print("\t<\tr>\n");
    
    print("</table>\n");
    print("</div>\n");
?>
