<?php

 $tmpStr;
 
 function getTextOfInterest($dataText, $beginDelim, $endDelim) {
    global $tmpStr;

    if ($dataText == null) {
      $dataText = $tmpStr;
    }

    $beginDelimLength = strlen($beginDelim);
    $beginDelimPos = strpos($dataText, $beginDelim);

    if ($beginDelimPos === false || $beginDelimPos != 0) {
      $textOfInterest = 0;
      return ($textOfInterest);
    }

    $endDelimPos = strpos($dataText, $endDelim);
    if ($endDelimPos === false) {
      $textOfInterest = 0;
      return ($textOfInterest);
    }

    $textOfInterestLength = $endDelimPos - $beginDelimLength;

    $textOfInterest = substr($dataText, $beginDelimLength, $textOfInterestLength);

    $tmpStrStartPos = $endDelimPos + strlen($endDelim);
    /* TO DO: Test for condition where the last text of interest gets generated and 
       return NULL */
    $tmpStrLength = strlen($dataText) - $tmpStrStartPos; 
    $tmpStr = substr($dataText, $tmpStrStartPos, $tmpStrLength);
    return $textOfInterest;
  }

  function getTokens($dataText) {
    global $dataDelimiter;
    global $allBeginDelimiters;
    global $allEndDelimiters;

    if ($dataText == null) {
      die("Data input to generate tokens is NULL in getTokens");
    }
    $beginDelimiterCount = count($allBeginDelimiters);

    $dataTextLength = strlen($dataText);
    $noDelimiter = false;
    $prevStartPos = 0;
    $tokenCount = 0;

    for ($idx = 0; $idx < $dataTextLength; $idx++) {
      /* Obtain the index of the beginning of the first delimiter in $dataText */
      if ((!IsSet($firstBeginDelimiterPos) || ($idx > $firstBeginDelimiterPos)) && !$noDelimiter) {
        if (IsSet($firstBeginDelimiterPos)) {
          /* offset added must be beyond the corresponding end delimiter */
	  if (!IsSet($endDelimiterPos)) {
	    die("Incorrect flow!");
          }
          $offset = $endDelimiterPos + strlen($endDelimiter);
        }
	$prevDelimiterPos = strlen($dataText) - 1;
        for ($curDelimiterIdx = 0; $curDelimiterIdx < $beginDelimiterCount; $curDelimiterIdx++) {
	  if (IsSet($offset)) {
            $curDelimiterPos = strpos($dataText, $allBeginDelimiters[$curDelimiterIdx], $offset);
	    $delim = $allBeginDelimiters[$curDelimiterIdx];
          } else {
            $curDelimiterPos = strpos($dataText, $allBeginDelimiters[$curDelimiterIdx]);
          }
          if ($curDelimiterPos === false) {
            continue;
          }
          $delim = $allBeginDelimiters[$curDelimiterIdx];
          $noDelimiter = false;
          if (IsSet($prevDelimiterPos)) {
            if ($prevDelimiterPos > $curDelimiterPos) {
              $prevDelimiterPos = $curDelimiterPos;
              $firstBeginDelimiter = $allBeginDelimiters[$curDelimiterIdx];
              $firstBeginDelimiterPos = $prevDelimiterPos;
              $firstBeginDelimiterIdx = $curDelimiterIdx;
            }
          } else {
            $prevDelimiterPos = $curDelimiterPos;
            $firstBeginDelimiter = $allBeginDelimiters[$curDelimiterIdx];
            $firstBeginDelimiterPos = $prevDelimiterPos;
            $firstBeginDelimiterIdx = $curDelimiterIdx;
          }
        }
	if (!IsSet($firstBeginDelimiterPos)) {
	  $noDelimiter = true;
        }
      }
      if (IsSet($firstBeginDelimiter) && $idx == $firstBeginDelimiterPos) {
        $endDelimiter = $allEndDelimiters[$firstBeginDelimiterIdx];
        $endDelimiterPos = strpos($dataText, $endDelimiter, $idx);
        if ($endDelimiterPos === false) {
          die('Packed string is corrupt: No end delimiter found for a begin delimiter');
        }
        $tokenTextLength = $endDelimiterPos + strlen($endDelimiter) - $firstBeginDelimiterPos;
        $tokenText = substr($dataText, $firstBeginDelimiterPos, $tokenTextLength);
        $tokens[$tokenCount] = $tokenText;
        $tokenCount++;
        $prevStartPos = $endDelimiterPos + strlen($endDelimiter);
	if ($dataText[$prevStartPos] == $dataDelimiter) {
          $prevStartPos = $prevStartPos + 1;
        }
        $idx = $prevStartPos - 1;
      } else if ($dataText[$idx] == $dataDelimiter) {
        $currentEndPos = $idx;
        $tokenTextLength = $currentEndPos - $prevStartPos;
        $tokenText = substr($dataText, $prevStartPos, $tokenTextLength);
        $tokens[$tokenCount] = $tokenText;
        $tokenCount++;
	$prevStartPos = $idx + 1; 
      }
    }
    return $tokens;
  }

  function getValues($dataText, $beginDelimiter, $endDelimiter) {
    global $allBeginDelimiters;
    global $allEndDelimiters;
    global $loopCount;

    if ($dataText == null) {
      die("Data input to generate tokens is NULL in getValues");
    }
    $beginDelimiterCount = count($allBeginDelimiters);
    
    $textOfInterest = getTextOfInterest($dataText, $beginDelimiter, $endDelimiter);
    $tokensRowNum = 0;
    $loopCount = 0;
    while ($textOfInterest != null) {
      $loopCount = $loopCount + 1;
      if ($loopCount > 10000) {
        die ("Unterminated recursive call triggered!");
      }
      $tokens = getTokens($textOfInterest);
      $textTokens[$tokensRowNum++] = $tokens;
      $textOfInterest = getTextOfInterest(null, $beginDelimiter, $endDelimiter);
    }
    return $textTokens;
  }

  function getBeginDelimiter($dataText) {
    global $allBeginDelimiters;

    $foundDelimiter = "";
    $numBeginDelimiters = count($allBeginDelimiters);
    $hasDelimiter = false;
    for ($curDelimiterIdx = 0; $curDelimiterIdx < $numBeginDelimiters; $curDelimiterIdx++) {
      $beginDelimiter = $allBeginDelimiters[$curDelimiterIdx];
      $hasDelimiter = strpos($dataText, $beginDelimiter);
      if ($hasDelimiter === false) {
        continue;
      }
      if ($hasDelimiter != 0) {
        continue;
      }
      break;
    }
    if (!($hasDelimiter === false)) {
      $foundDelimiter = $beginDelimiter;
    }
    return ($foundDelimiter);
  }

  function sqlAddMachine($machineText) {
    global $machineBeginDelimiter, $machineEndDelimiter;
    $machineValues = getValues($machineText, $machineBeginDelimiter, $machineEndDelimiter);
    $numMachines = count($machineValues);
    for ($idx = 0; $idx < $numMachines; $idx++) {
      $machineName = $machineValues[$idx][0];
      $machineVendor = $machineValues[$idx][1];
      $machineSerialNumber = $machineValues[$idx][2];
      $query = "INSERT INTO MACHINES (Name, Vendor, SerialNumber) VALUES ('$machineName', '$machineVendor', '$machineSerialNumber')";
      $result = sqlQuery($query);
    }
  }

  function sqlAddSupplierFromPost() {
    $supplierName = $_POST['supplierName'];
    $supplierContactPerson = $_POST['supplierContactPerson'];
    $supplierContactAddress = $_POST['supplierContactAddress'];
    $supplierPhoneNumber = $_POST['supplierPhoneNumber'];
    $supplierEmail = $_POST['supplierEmail'];
    $query = "INSERT INTO SUPPLIERS (Name, ContactPerson, ContactAddress, PhoneNumber, Email) VALUES ('$supplierName', '$supplierContactPerson', '$supplierContactAddress', '$supplierPhoneNumber', '$supplierEmail')";
    $result = sqlQuery($query);
  }

  function sqlAddInsert($insertText, $toolId) { 
    global $insertBeginDelimiter;
    global $insertEndDelimiter;
    
    if ($insertText == NULL || $insertText == "") {
      return;
    }
    writeDebugString($insertText);
    $insertRows = getValues($insertText, $insertBeginDelimiter, $insertEndDelimiter);
    $numInsertRows = count($insertRows);

    for ($idx = 0; $idx < $numInsertRows; $idx++) {
      $insertPartNumber = $insertRows[$idx][0];
      $insertPartNumberDBId = sqlGetInsertIdFromDB($insertPartNumber);
      if (!($insertPartNumberDBId === false)) {
        $query = "INSERT INTO TOOL_INSERT_MAPPING (ToolId, InsertId) VALUES ('$toolId', '$insertPartNumberDBId');";
        $result = sqlQuery($query);
        continue;
      } 
      $insertDescription = $insertRows[$idx][2];
      $insertQuantity = $insertRows[$idx][2];
      $query = "INSERT INTO INSERTS (PartNumber, Quantity) VALUES ('$insertPartNumber', '$insertDescription', '$insertQuantity');";
      $result = sqlQuery($query);
    }
  }

  function sqlAddSupplier($supplierText) {
    global $supplierBeginDelimiter, $supplierEndDelimiter;

    if ($supplierText == NULL || $supplierText == "") {
      return;
    }

    $supplierRows = getValues($supplierText, $supplierBeginDelimiter, $supplierEndDelimiter);
    $numSupplierRows = count($supplierRows);

    for ($idx = 0; $idx < $numSupplierRows; $idx++) {
      $supplierName = $supplierRows[$idx][0];
      $supplierDBId = sqlGetInsertIdFromDB($supplierName);
      if (!($supplierDBId === false)) {
        continue;
      }
      $supplierContactPerson = $supplierRows[$idx][1];
      $supplierContactAddress = $supplierRows[$idx][2];
      $supplierPhoneNumber = $supplierRows[$idx][3];
      $supplierEmail = $supplierRows[$idx][4];

      $query = "INSERT INTO SUPPLIERS (Name, ContactPerson, ContactAddress, PhoneNumber, Email) VALUES ('$supplierName', '$supplierContactPerson', '$supplierContactAddress', '$supplierPhoneNumber', '$supplierEmail')";
      $result = sqlQuery($query);
    }
  }

  /*******************************************************************************
   Function to extract the tool values from the tooltext. The tool text can only
   contain 1 tool data. It can contain many inserts' data.
  *******************************************************************************/
  function sqlAddTool($toolText) {
    global $toolBeginDelimiter, $insertBeginDelimiter, $supplierBeginDelimiter;
    
    $toolRows = getValues($toolText, $toolBeginDelimiter, $toolEndDelimiter);
    $numToolRows = count($toolRows);
    $numToolOnlyDataCount = 0;
    $numInserts = 0;
    for ($idx = 0; $idx < $numToolRows; $idx++) {
      $toolValues = $toolRows[$idx];
      $numToolValues = count($toolValues);
      for ($curToolValueIdx = 0; $curToolValueIdx < $numToolValues; $curToolValueIdx++) {
        $toolValue = $toolValues[$curToolValueIdx];
        $beginDelimiter = getBeginDelimiter($toolValue);
        if ($beginDelimiter != "") {
          if ($beginDelimiter == $insertBeginDelimiter) {
	    $insertData[$numInserts++] = $toolValue;
          } else if ($beginDelimiter = $supplierBeginDelimiter) {
            sqlAddSupplier($toolValue);
          }
        } else {
          $toolOnlyData[$numToolOnlyDataCount++] = $toolValue;
        }
      }
    }

    $idx = 0;
    $toolName = $toolOnlyData[$idx++];
    $toolNumAvailable = $toolOnlyData[$idx++];
    $toolPartNumber = $toolOnlyData[$idx++];
    $toolDescription = $toolOnlyData[$idx++];
    $toolLife = $toolOnlyData[$idx++];
    $toolMake = $toolOnlyData[$idx++];
    $toolSupplierName = $toolOnlyData[$idx++];
    $toolPriceInfo = $toolOnlyData[$idx++];
    $toolQuantityInStore = $toolOnlyData[$idx++];
    $toolQuantityInUse = $toolOnlyData[$idx++];
    $toolDiameter = $toolOnlyData[$idx++];
    $toolNumCuttingEdges = $toolOnlyData[$idx++];
    $toolFluteLength = $toolOnlyData[$idx++];
    $toolShankDiameter = $toolOnlyData[$idx++];
    $toolUsefulLength = $toolOnlyData[$idx++];
    $toolOverallLength = $toolOnlyData[$idx++];
    $toolCoating = $toolOnlyData[$idx++];
    $toolType = $toolOnlyData[$idx++];
    $toolCornerRadiusOrAngle = $toolOnlyData[$idx++];
    $toolScrewPartNumber = $toolOnlyData[$idx++];
    $toolScrewPartQuantity = $toolOnlyData[$idx++];
    $toolWrenchPartNumber = $toolOnlyData[$idx++];

    $supplierIdForTool = sqlGetSupplierId($supplierName);
    if ($supplierIdForTool === false) {
      die('Problem with the flow. Supplier not added');
    }

    $query = "INSERT INTO TOOLS (PartNumber, Description, Availability, Make, Supplier, PriceInfo, QuantityInStore, QuantityInUse, Diameter, NumCuttingEdges, FluteLength, ShankDiameter, UsefulLength, OverallLength, Coating, Type, CornerRadiusOrAngle, ScrewPartNumber, ScrewPartQuantity, WrenchPartNumber) VALUES ('$toolPartNumber', '$toolDescription', '$toolAvailability', '$toolMake', '$supplierIdForTool', '$toolPriceInfo', '$toolQuantityInStore', '$toolQuantityInUse', '$toolDiameter', '$toolNumCuttingEdges', '$toolFluteLength', '$toolShankDiameter', '$toolUsefulLength', '$toolOverallLength', '$toolCoatin'. '$toolType', '$toolCornerRadiusOrAngle', '$toolScrewPartNumber', '$toolScrewPartQuantity', '$toolWrenchPartNumber');";

    $result = sqlQuery($query);
    $toolId = sqlGetToolIdFromDB($toolPartNumber);

    if ($toolId === false) {
      die("Inserted tool not found in DB");;
    }

    $numInserts = count($insertData);
    for ($idx = 0; $idx < $numInserts; $idx++) {
      $insertText = $insertData[$idx];
      sqlAddInsert($insertText, $toolId);
    }
  }

  function sqlAddToolFromPost() {
    $toolPartNumber = $_POST['toolPartNumber'];
    $toolDescription = $_POST['toolDescription'];
    $toolAvailability = $_POST['toolAvailability'];
    $toolMake = $_POST['toolMake'];
    $toolSupplier = $_POST['toolSupplier'];
    $toolPriceInfo = $_POST['toolPriceInfo'];
    $toolQuantityInStore = $_POST['toolQuantityInStore'];
    $toolQuantityInUse = $_POST['toolQuantityInUse'];
    $toolDiameter = $_POST['toolDiameter'];
    $toolNumCuttingEdges = $_POST['toolNumCuttingEdges'];
    $toolFluteLength = $_POST['toolFluteLength'];
    $toolShankDiameter = $_POST['toolShankDiameter'];
    $toolUsefulLength = $_POST['toolUsefulLength'];
    $toolOverallLength = $_POST['toolOverallLength'];
    $toolCoating = $_POST['toolCoating'];
    $toolType = $_POST['toolType'];
    $toolCornerRadiusOrAngle = $_POST['toolCornerRadiusOrAngle'];
    $toolScrewPartNumber = $_POST['toolScrewPartNumber'];
    $toolScrewPartNumber = $_POST['toolScrewPartQuantity'];
    $toolWrenchPartNumber = $_POST['toolWrenchPartNumber'];
    $toolNewInserts = $_POST['insertStore'];
    $toolInserts = $_POST['insertsForToolStore'];
    $supplierData = $_POST['supplierStore'];

    sqlAddSupplier($supplierData);
    $toolSupplierId = sqlGetSupplierIdFromDB($toolSupplier);

    $query = "INSERT INTO TOOLS (PartNumber,Description,Availability,Make,Supplier,PriceInfo,QuantityInStore,QuantityInUse,Diameter,NumCuttingEdges,FluteLength,ShankDiameter,UsefulLength,OverallLength,Coating,Type,CornerRadiusOrAngle, ScrewPartNumber, ScrewPartQuantity, WrenchPartNumber) VALUES ('$toolPartNumber','$toolDescription','$toolAvailability','$toolMake','$toolSupplierId','$toolPriceInfo','$toolQuantityInStore','$toolQuantityInUse','$toolDiameter','$toolNumCuttingEdges','$toolFluteLength','$toolShankDiameter','$toolUsefulLength','$toolOverallLength','$toolCoating','$toolType','$toolCornerRadiusOrAngle', '$toolScrewPartNumber', '$toolScrewPartQuantity', '$toolWrenchPartNumber');";

    $result = sqlQuery($query);
    $toolId = sqlGetToolIdFromDB($toolPartNumber);
    writeDebugString("toolId",$toolId); 
    if ($toolId === false) {
      die("Inserted tool not found in DB");;
    }
    writeDebugString("insertStore",$toolInserts); 
    sqlAddInsert($toolNewInserts, $toolId);
    sqlAddInsert($toolInserts, $toolId);
  }

  function sqlUpdateToolUsage() {
    global $toolUsageUpdateBeginDelimiter, $toolUsageUpdateEndDelimiter;

    $updateStore = $_POST['toolUpdateStore'];
    writeDebugString("Update tool usage called", "");
    writeDebugString("From Post", $updateStore);    

    $updatedToolValues = getValues($updateStore, $toolUsageUpdateBeginDelimiter,
    		       	           $toolUsageUpdateEndDelimiter);

    $numUpdatedToolRows = count($updatedToolValues);
    writeDebugString("Number of tools that need update", $numUpdatedToolRows);    

    for ($idx = 0; $idx < $numUpdatedToolRows; $idx++) {
      $autoIdx = 0;
      $updatedToolRow = $updatedToolValues[$idx];
      $updatedToolUsagePartNumber = $updatedToolRow[$autoIdx++];
      $updatedToolInStore = $updatedToolRow[$autoIdx++];
      $updatedToolInUse = $updatedToolRow[$autoIdx++];
      $query = "UPDATE TOOLS SET QuantityInStore='$updatedToolInStore', QuantityInUse='$updatedToolInUse' WHERE PartNumber = '$updatedToolUsagePartNumber';";
      $result = sqlQuery($query);
    }
  }

  function sqlAddCustomers($customerText) {
    global $customerBeginDelimiter, $customerEndDelimiter;
    
    if ($customerText == null or $customerText == "") {
      return;
    }
    
    $customerRows = getValues($customerText, $customerBeginDelimiter,
                               $customerEndDelimiter);
    $numCustomerRows = count($customerRows);
    for ($idx = 0; $idx < $numCustomerRows; $idx++) {
      $customerName = $customerRows[$idx][0];
      $customerOtherDetails = $customerRows[$idx][1];
      
      $query = "INSERT INTO CUSTOMERS (Name, OtherDetails) VALUES ('$customerName', '$customerOtherDetails');";
      $result = sqlQuery($query);
    }
  }

  function sqlAddProgramForOperation($programText, $mainProgramId) {
    global $progBeginDelimiter, $progEndDelimiter;
    
    $programRows = getValues($programText, $progBeginDelimiter, $progEndDelimiter);
    $numProgramRows = count($programRows);
    $numProgramIds = 0;

    for ($idx = 0; $idx < $numProgramRows; $idx++) {
      $programNumber = $programValues[0];
      $programType = $programValues[1];
      $programCode = $programValues[2];
      $query = "INSERT INTO PROGRAMS (ParentProgramID, Number, Type, Code) VALUES ('$mainProgramId', '$programNumber', '$programType', '$programCode');";
      $result = sqlQuery($query);

      $programIds[$numProgramIds] = mysql_insert_id();
    }
    return $programIds;
  }

  function sqlAddHolder($holdersText) {
    global $holderBeginDelimiter, $holderEndDelimiter;
    global $holderNames;

    $holderRows = getValues($holdersText, $holderBeginDelimiter, $holderEndDelimiter);
    $numHolderRows = count($holderRows);
    for ($idx = 0; $idx < $numHolderRows; $idx++) {
      $holderName = $holderRows[$idx][0];
    }
    $query = "INSERT INTO HOLDERS (Name) VALUES ('$holderName');";
    $result = sqlQuery($query);
    return ($holderId);
  }  
 
  function getToolIdsForOperation($toolsText) {
    global $toolBeginDelimiter, $toolEndDelimiter;

    $toolNames = getValues($toolsText, $toolBeginDelimiter, $toolEndDelimiter);
    $toolCount = count($toolNames);
    $toolIdCount = 0;

    for ($idx = 0; $idx < $toolCount; $idx++) {
      $toolNameText = $toolNames[$idx];
      $toolName = strtok($toolNameText, ":");
      $beginPos = strlen($toolName) + 1;
      $endPos = strlen($toolNameText);
      $length = $endPos - $beginPos;
      $toolPartNumber = substr($toolNameText, $beginPos, $length);
      $query = "SELECT ID FROM TOOLS WHERE PartNumber='$toolPartNumber';";
      
      $result = sqlQuery($query);
      $rows = mysql_fetch_assoc($result);
      $toolIds[$toolIdCount++] = $rows['ID'];
    }
    return $toolIds;
  }

  function sqlAddAndGetToolHolderData($toolHolderText) {
    global $toolBeginDelimiter;
    global $holderBeginDelimiter;
    global $toolHolderBeginDelimiter, $toolHolderEndDelimiter;

    $numToolIds = 0;
    $numHolderIds = 0;
    $numToolHolderOnlyData = 0;

    $toolHolderRows = getValues($toolHolderText, $toolHolderBeginDelimiter, $toolHolderEndDelimiter);
    $numToolHolderRows = count($toolHolderRows);
    for ($idx = 0; $idx < $numToolHolderRows; $idx++) {
      $toolHolderValues = $toolHolderRows[$idx];
      $numToolHolderValues = count($toolHolderValues);
      for ($curTHValueIdx = 0; $curTHValueIdx < $numToolHolderValues; $curTHValueIdx++) {
        $toolHolderValue = $toolHolderValues[$curTHValueIdx];
        $beginDelimiter = getBeginDelimiter($toolHolderValue);
        if ($beginDelimiter == $toolBeginDelimiter) {
          sqlAddTool($toolHolderValue);
        } else if ($beginDelimiter == $holderBeginDelimiter) {
          sqlAddHolder($toolHolderValue);
        } else {
          $toolHolderOnlyData[$numToolHolderOnlyData++] = $toolHolderValue;
        }
      }
    }
    return ($toolHolderOnlyData);
  }

  function sqlAddOperation($partOperations, $partID) {
    global $opBeginDelimiter;
    global $opEndDelimiter;
    global $dataDelimiter;
    global $allBeginDelimiters;
    global $toolBeginDelimiter;
    global $progBeginDelimiter;
    global $machineBeginDelimiter;
    global $holderBeginDelimiter;
    global $toolHolderBeginDelimiter;

    if ($partOperations == NULL || $partOperations == "") {
      return;
    }
    
    $operationValues = getValues($partOperations, $opBeginDelimiter, $opEndDelimiter);
    $opOnlyDataCount = 0;
    $holderOnlyDataCount = 0;
    $mainProgramId = 0;
    $numOperationValues = count($operationValues);
    $numToolHolderOnlyData = 0;

    for ($idx = 0; $idx < $numOperationValues; $idx++) {
      $operationTokens = $operationValues[$idx];
      $numOpTokens = count($operationTokens);
      for ($curOpToken = 0; $curOpToken < $numOpTokens; $curOpToken++) {
        $beginDelimiter = getBeginDelimiter($operationTokens[$curOpToken]);
        if ($beginDelimiter != "") {
          if ($beginDelimiter == $progBeginDelimiter) {
            $progId = sqlAddProgramForOperation($operationTokens[$curOpToken], $mainProgramId);
              if ($mainProgramId == 0) {
                $mainProgramId = $progId;
              }
          } else if ($beginDelimiter == $toolHolderBeginDelimiter) {
            $toolHolderOnlyData[$numToolHolderOnlyData++] = sqlAddAndGetToolHolderData($operationTokens[$curOpToken]);
	  } else if ($beginDelimiter == $machineBeginDelimiter) {
	    sqlAddMachine($operationTokens[$curOpToken]);
	  }
        } else {
          $operationOnlyData[$opOnlyDataCount++] = $operationTokens[$curOpToken];
        }
      }
      $operationName = $operationOnlyData[0];
      $operationMachineID = $operationOnlyData[1];
      $operationDescription = $operationOnlyData[2];
      $operationCuttingTime = $operationOnlyData[3];
      $operationClampingTime = $operationOnlyData[4];

      $query = "INSERT INTO OPERATIONS (PartID, Name, Machine, Description, CuttingTime, ClampingTime) VALUES ('$partID', '$operationName', '$operationMachineID', '$operationDescription', '$operationCuttingTime', '$operationClampingTime');";  
      $result = sqlQuery($query);
      $opId = mysql_insert_id();

      if (IsSet($toolHolderOnlyData)) {
        $numToolHolderOnlyData = count($toolHolderOnlyData);
        for ($idx = 0; $idx < $numToolHolderOnlyData; $idx++) {
          $toolHolderData = $toolHolderOnlyData[$idx];
          $toolPartNumber = $toolHolderData[0];
  	  $toolId = sqlGetToolIdFromDB($toolPartNumber);
	  $holderName = $toolHolderData[1];
	  $holderId = sqlGetHolderIdFromDB($holderName);
	  $toolRemarks = $toolHolderData[2];
	  $toolOverHang = $toolHolderData[3];
	  $toolLife = $toolHolderData[4];
          $query = "INSERT INTO OPERATION_TOOL_HOLDER_MAPPING (OperationID, ToolID, HolderID, ToolLife, ToolOverHang, ToolRemark) VALUES ('$opId', '$toolId', '$holderId', '$toolLife', '$toolOverHang', '$toolRemark');";
	  $result = sqlQuery($query);
        }
      }
    }
  }

  function sqlAddPart() {
    global $_POST;
    global $_FILES;
    global $partFilesUploadDir;

    $partNumber = $_POST['partNumber'];
    $partName = $_POST['partName'];
    $partCustomerName = $_POST['partCustomerName'];
    $partDrawingNumber = $_POST['partDrawingNumber'];
    $partMaterialType = $_POST['partMaterialType'];
    $partInputRawMaterialSize = $_POST['partInputRawMaterialSize'];
    $partOperations = $_POST['operationStore'];
    $partCustomers = $_POST['customerStore'];

    if (IsSet($_FILES['partDrawingFilePath'])) {     
      $drawingFileName = $_FILES['partDrawingFilePath']['name'];
      if (IsSet($drawingFileName) && $drawingFileName != "") {
        $partDrawingFileName = $partNumber . "_" . $_FILES['partDrawingFilePath']['name'];
        
        $partDrawingTempName = $_FILES['partDrawingFilePath']['tmp_name'];
        
        $partDrawingFileFullName = $partFilesUploadDir . "/" . $partDrawingFileName;
        

        $result = move_uploaded_file($partDrawingTempName, "$partDrawingFileFullName");
        
        if ($result === false)  {
          echo "Error uploading file";
          exit;
        }
        if(!get_magic_quotes_gpc())
        {
          $fileName = addslashes($fileName);
          $filePath = addslashes($filePath);
        }
      }
    }

    if (IsSet($_FILES['partPreviewImage'])) {     
      $previewImageFileName = $_FILES['partPreviewImage']['name'];
      if (IsSet($previewImageFileName) && $previewImageFileName != "") {
        $partPreviewImageFileName = $partNumber . "_" . $_FILES['partPreviewImage']['name'];
        $partPreviewImageTempName = $_FILES['partPreviewImage']['tmp_name'];
        
        $partPreviewImageFullName = $partFilesUploadDir . "/" . $partPreviewImageFileName;
        

        $result = move_uploaded_file($partPreviewImageTempName, "$partPreviewImageFullName");
        
        if ($result === false)  {
          echo "Error uploading file";
          exit;
        }
        if(!get_magic_quotes_gpc())
        {
          $fileName = addslashes($fileName);
          $filePath = addslashes($filePath);
        }
      } 
    }

    $query = "INSERT INTO PARTS (Number, Name, CustomerName, DrawingFilePath, Material, InputRawMaterialSize, PreviewImage) VALUES ('$partNumber', '$partName', '$partCustomerName', '$partDrawingFileFullName', '$partMaterial', '$partInputRawMaterialSize', '$partPreviewImageFullName');";

    $result = sqlQuery($query);

    $partID = mysql_insert_id();
    sqlAddOperation($partOperations, $partID);
    sqlAddCustomers($partCustomers);
  }
?>
