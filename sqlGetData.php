<?php
  function sqlGetMachines() {
    $query = "SELECT * FROM MACHINES";
    $result = sqlQuery($query);
    $numRows = mysql_num_rows($result);
    for ($idx = 0; $idx < $numRows; $idx++) {
      $row = mysql_fetch_array($result);
      $machineNames[$idx] = $row[1];
    }
   return $machineNames;
  }

  function sqlGetSuppliers() {
    $query = "SELECT Name FROM SUPPLIERS;";
    $result = sqlQuery($query);
    $numRows = mysql_num_rows($result);
    for ($idx = 0; $idx < $numRows; $idx++) {
      $row = mysql_fetch_array($result);
      $supplierNames[$idx] = $row['Name'];
    }
   return $supplierNames;
  }

  function sqlGetTools() {
    $query = "SELECT PartNumber FROM TOOLS;";
    $result = sqlQuery($query);
    $idx = 0;
    while ($row = mysql_fetch_assoc($result))
    {
      $toolPartNumber = $row['PartNumber'];
      $toolPartNumbers[$idx] = $toolPartNumber;
      $idx++;
    }
    return $toolPartNumbers;
  }

  function sqlGetInserts() {
    $query = "SELECT PartNumber FROM INSERTS;";
    $result = sqlQuery($query);
    $idx = 0;
    while ($row = mysql_fetch_assoc($result))
    {
      $insertPartNumber = $row['PartNumber'];
      $insertPartNumbers[$idx] = $insertPartNumber;
      $idx++;
    }
    return $insertPartNumbers;
  }

  function sqlGetToolTypes() {
    $query = "SELECT * FROM TOOL_TYPES;";
    $result = sqlQuery($query);
    $idx = 0;
    while ($row = mysql_fetch_assoc($result))
    {
      $toolType = $row['Type'];
      writeDebugString($toolType, "");
      $toolTypes[$idx] = $toolType;
      $idx++;
    }
    return $toolTypes;
  }

  function sqlGetHolders() {
    $query = "SELECT Name FROM HOLDERS;";
    $result = sqlQuery($query);
    $idx = 0;
    while ($row = mysql_fetch_assoc($result))
    {
      $holderName = $row['Name'];
      $holderNames[$idx] = $holderName;
      $idx++;
    }
    return $holderNames;
  }

  function sqlGetToolIdFromDB($toolPartNumber) {
    $query = "SELECT * FROM TOOLS WHERE PartNumber = '$toolPartNumber';";
    $result = sqlQuery($query);
    $idx = 0;
    $toolId = false;
    if ($row = mysql_fetch_assoc($result))
    {
      $toolId = $row['ID'];
    } 
    return $toolId;
  }

  function sqlGetInsertIdFromDB($insertPartNumber) {
    $query = "SELECT * FROM INSERTS WHERE PartNumber = '$insertPartNumber';";
    $result = sqlQuery($query);
    $idx = 0;
    $insertId = false;
    if ($row = mysql_fetch_assoc($result))
    {
      $insertId = $row['ID'];
    }
    return $insertId;
  }

  function sqlGetHolderIdFromDB($holderName) {
    $query = "SELECT * FROM HOLDERS WHERE Name = '$holderName';";
    $result = sqlQuery($query);
    $idx = 0;
    $holderId = false;
    if ($row = mysql_fetch_assoc($result))
    {
      $holderId = $row[0];
    }
    return $holderId;
  }

  function sqlGetSupplierIdFromDB($supplierName) {
    $query = "SELECT * FROM SUPPLIERS WHERE Name = '$supplierName';";
    $result = sqlQuery($query);
    $idx = 0;
    $supplierId = false;
    if ($row = mysql_fetch_assoc($result))
    {
      $supplierId = $row['ID'];
    }
    return $supplierId;
  }

  function sqlGetToolsUsageFromDB() {
    $query = "SELECT PartNumber,QuantityInStore, QuantityInUse FROM TOOLS;";
    $result = sqlQuery($query);
    $idx = 0;
    while ($row = mysql_fetch_assoc($result))
    {
      $toolPartNumber = $row['PartNumber'];
      $toolQuantityInStore = $row['QuantityInStore'];
      $toolQuantityInUse = $row['QuantityInUse'];

      $toolRows[$idx][0] = $toolPartNumber;
      $toolRows[$idx][1] = $toolQuantityInStore;
      $toolRows[$idx][2] = $toolQuantityInUse;
      $idx++;
    }
    return $toolRows;
  }

?>
