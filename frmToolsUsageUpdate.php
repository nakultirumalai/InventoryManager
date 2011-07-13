<?php
    print("<div id=\"$frmToolUsageUpdateName\" style=\"display:$defaultDivStyle\">\n");
    print("<form action=\"$frmAction?UpdateToolUsage=true\" method=\"post\" onSubmit = \"return updateToolAndSubmit()\";>\n");

    print("<table border=\"0\">\n");
    
    print("<h3>Tools added in the database:</h3>");
    $numTools = count($toolUsageRows);
    writeDebugString($numTools, "");
    print("<tr class = \"first\">\n");
    print("<td class = \"toolUsagePartNumber\">Tool Part Number</td>\n");
    print("<td>Quantity In Store </td>\n");
    print("<td>Quantity In Use </td>\n");
    print("</tr>\n");

    for ($idx = 0; $idx < $numTools; $idx++) {
      $numParams = count($toolUsageRows[$idx]);
      if ($idx % 2 == 0) {
        $class = "even";
      } else {
        $class = "odd";
      }
      print("<tr class = \"$class\">");
      for ($paramIdx = 0; $paramIdx < $numParams; $paramIdx++) {
        if ($paramIdx == 0) {
           print("<td class = \"toolUsagePartNumber\">\n");
        } else {
           print("<td>\n");
        }
        if ($paramIdx == 1) {
	  $name = $toolUsageRows[$idx][0] . $inStoreSuffix;
	  writeTextBox($name, $toolUsageRows[$idx][$paramIdx]);
	} else if ($paramIdx == 2) {
	  $name = $toolUsageRows[$idx][0] . $inUseSuffix;
	  writeTextBox($name, $toolUsageRows[$idx][$paramIdx]);
        } else {
	  print($toolUsageRows[$idx][$paramIdx]);
        }
	print("</td>\n");
      }
      print("</tr>");
      print("\n");
    }
    print("</table>\n");

    print("<p>");
    writeSubmit("updateAll", "Update/Commit changes");
    print("</p>");

    writeHidden("toolUpdateStore", "");
    print("</form>\n");
    print("</div>\n");
?>
