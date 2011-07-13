<?php
	
  function writeDebugString($descriptionStr, $valueStr) { 
    global $debugWritingEnabled;
    
    if ($debugWritingEnabled == true) {
      print("<!-- $descriptionStr: $valueStr -->\n");
    }
  }

?>