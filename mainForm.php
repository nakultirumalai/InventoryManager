<HTML>
<TITLE>Create/Report Resource</TITLE>
<HEAD>

   <?php
      include ('variables.php');
      include ('commonAPIs.php');
      include ('sqlAPI.php');
      include ('phpDebugAPI.php');
      include ('sqlAddData.php');
      include ('sqlGetData.php');
      sqlConnect("root", "root", "PartsDB");

      if (IsSet($_GET['AddMachine']) && $_GET['AddMachine'] == "true") {
        sqlAddMachine();
      } else if (IsSet($_GET['AddSupplier']) && $_GET['AddSupplier'] == "true") {
        sqlAddSupplierFromPost();
      } else if (IsSet($_GET['AddPart']) && $_GET['AddPart'] == "true") {
        sqlAddPart();
      } else if (IsSet($_GET['AddTool']) && $_GET['AddTool'] == "true") {
        sqlAddToolFromPost();
      } else if (IsSet($_GET['UpdateToolUsage']) && $_GET['UpdateToolUsage'] == "true") {
        sqlUpdateToolUsage();
      }

      
      $machineNames = sqlGetMachines();
      $toolPartNumbers = sqlGetTools();
      $insertPartNumbers = sqlGetInserts();
      $toolTypes = sqlGetToolTypes();
      $holderNames = sqlGetHolders();
      $supplierNames = sqlGetSuppliers();
      $toolUsageRows = sqlGetToolsUsageFromDB();
      sqlClose();
   ?>

   <style type="text/css">
    a:link    {
      /* Applies to all unvisited links */
      text-decoration:  none;
      font-weight:      bold;
      background-color: #FF6633;
      color:            white;
    } 
    a:visited {
      /* Applies to all visited links */
      text-decoration:  none;
      font-weight:      bold;
      background-color: #ddd;
      color:            #f0f;
    } 
    a:hover   {
      /* Applies to links under the pointer */
      text-decoration:  none;
      font-weight:      bold;
      background-color: blue;
      color:            #fff;
    } 
    a:active  {
      /* Applies to activated links */
      text-decoration:  underline;
      font-weight:      bold;
      background-color: black;
      color: white;
    } 

    body {
      font-family:"Arial";
    }
    
    tr.odd {
      background-color: #aaaaaa;
    }
    tr.even {
      background-color: #85adff;
    }
    tr.first {
      background-color: #aaaaaa;
      font-weight: bold;
    }
    td.toolUsagePartNumber {
      width: 300;
    }
   </style>
   <!-- Functions for string handling -->
   <script language="javascript" src="strings.js">
   </script>

   <!-- Utility functions -->
   <script language="javascript" src="utils.js">
   </script>

   <!-- Functions for stacking of forms -->
   <script language="javascript">
     var stackCount = 0;
     var stack = new Array();
     function push(entry) {
       stack[stackCount] = entry;
       stackCount++;
     }
     function pop() {
       if (stackCount > 0) {
         stackCount--;
         return stack[stackCount];
       } else 
         return null; 
     }
   </script>

   <!-- Functions for automatic population of forms/variables (debugging) -->
   <script language="javascript">
   var DBToolPartNumbers;
   var DBInsertPartNumbers;
   var DBSupplierNames;
   var DBToolUsageArray;

   function populateToolForm () {
    <?php
     $valueArray[0] = array('Tool123', 'ToolABCD', 'CuttingTool', '4 weeks', 'ToolOneTwoThree',
                            '123Industries', '1200', '100', '20', '1.23', '15', '2.45',
                            '1.45', '2.3', '1', '3.45', 'Titanium', 'Cutting all', '12', 'screw123',
                            '12', 'wrench123');
     $valueArray[1] = array('EMA24120', 'Dia 12, 4lip TI-Phoon Em', '', '3 weeks', 'YG1',
                            'Focus Engineering', '2200', '100', '20', '6x90', '4', '30',
                            '75', '2.35', '1', '3.45', 'TiAl', 'Cutting all', '', '',
                            '', '');
     $valueArray[2] = array('abcd123', 'abcd123', 'abcd123', 'abcd123', 'abcd123', 'abcd123',
                            'abcd123', 'abcd123', 'abcd123', 'abcd123', 'abcd123', 'abcd123', 'abcd123',
                            'abcd123', 'abcd123', 'abcd123', 'abcd123', 'abcd123', 'abcd123', 'abcd123', 'abcd123',
                            'abcd123', 'abcd123');
     for ($idx = 0; $idx < count($frmToolElementDBNames); $idx++) {
       print("\t  var $frmToolElementNames[$idx] = document.getElementById('$frmToolElementNames[$idx]');\n");
     }
     for ($idx = 0; $idx < count($frmToolElementDBNames); $idx++) {
       $value = $valueArray[1][$idx];
       print("\t  $frmToolElementNames[$idx].value = \"$value\";\n");
     }
    ?>
   }
 
   function populateToolsIntoVar() {
     <?php
       $numTools = count($toolPartNumbers);
       print("DBToolPartNumbers = new Array(");
       for ($idx = 0; $idx < $numTools; $idx++) {
         print("'$toolPartNumbers[$idx]'");
         if ($idx != ($numTools - 1)) {
           print(",");
         }
       } 
       print(");\n");
     ?>
   }

   function populateInsertsIntoVar() {
     <?php
       $numInserts = count($insertPartNumbers);
       print("DBInsertPartNumbers = new Array(");
       for ($idx = 0; $idx < $numInserts; $idx++) {
         print("'$insertPartNumbers[$idx]'");
         if ($idx != ($numInserts-1)) {
           print(",");
         }
       } 
       print(");\n");
     ?>
   }

   function populateSuppliersIntoVar() {
     <?php
       $numSuppliers = count($supplierNames);
       print("DBSupplierNames = new Array(");
       for ($idx = 0; $idx < $numSuppliers; $idx++) {
         print("'$supplierNames[$idx]'");
         if ($idx != ($numSuppliers-1)) {
           print(",");
         }
       } 
       print(");\n");
     ?>
   }

   function populateToolUsageIntoVar() {
     <?php
       $numTools = count($toolUsageRows);
       print("\tDBToolUsageArray = new Array();\n");
       for ($idx = 0; $idx < $numTools; $idx++) {
         $toolUsageData = $toolUsageRows[$idx];
         $toolUsageDataCount = count($toolUsageData);
         print("\tDBToolUsageArray[$idx] = new Array(");
         for ($toolUsageDataIdx = 0; $toolUsageDataIdx < $toolUsageDataCount; $toolUsageDataIdx++) {
           print("'$toolUsageData[$toolUsageDataIdx]'");
           if ($toolUsageDataIdx != ($toolUsageDataCount-1)) {
             print(",");
           }
         }
         print(");\n");
       } 
     ?>
   }

   </script>

   <!-- Functions for showing of forms -->
   <script language="javascript">
     var currentForm;
     var toolFormSkipSubmit;
     var supplierFormSkipSubmit;

     function showForm(varForm) {
       hideCurrentForm();
       preProcessFormForDisplay(varForm);
       varForm.style.display = "block";
       if (currentForm != null) {
         push(currentForm);
       }
       currentForm = varForm;
     }

     function showPreviousForm() {
       var previousForm = pop();
       hideCurrentForm();
       if (previousForm.style.display == "none") {
         previousForm.style.display = "block";
         currentForm = previousForm;
       }
       displayResult("Operation Completed Successfully!");
     }

     function getPreviousForm() {
       var previousForm = pop();

       push(previousForm);
       
       return (previousForm);
     }

     function hideAllForms(){
       var arr = document.getElementsByTagName('div');
       for (var i=0; i<arr.length ;i++) {
         arr[i].style.display = 'none';
       }
       var resultFrm = document.getElementById('Result');
       resultFrm.style.display = "block";
     }
     function hideCurrentForm(){
       if (currentForm != null) {
         currentForm.style.display = 'none';
       }
     }
     function preProcessFormForDisplay(varForm) {
       if (varForm.id == <?php print("\"$frmOperationAddName\""); ?>) {
         var partOperationList = document.getElementById('operationList');
         var operationNameList = document.getElementById('operationName');
         var operationListLength = partOperationList.length;
         var operationNameLength = operationNameList.length;

         <?php 
         $operationNameCount = count($frmOperationNameValues);
         print("var originalOperationValues = Array(");
	 for ($idx = 0; $idx < $operationNameCount; $idx++) {
           print("\"$frmOperationNameValues[$idx]\"");
           if ($idx != ($operationNameCount - 1)) {
             print(",");
           }
         }
         print(");");
         ?>

         var idx;
	 operationNameList.options.length = 0;

         var originalOperationsNum = originalOperationValues.length;
         for (idx = 0; idx <  originalOperationsNum; idx++) {
           if (checkIfValueExistsInSelect(partOperationList, originalOperationValues[idx])) {
             continue;
           } else {
             operationNameList.options[operationNameList.options.length] = new Option(originalOperationValues[idx],
                                                                                originalOperationValues[idx]);
           }
         }
       }
       if (varForm.id == <?php print("\"$frmToolAddName\""); ?>) {
         toolSupplier = document.getElementById('toolSupplier');
         insertSelect = document.getElementById('insertSelect');

         if (insertSelect != null) {
           populateSelect(insertSelect, DBInsertPartNumbers);
         } 
         if (toolSupplier != null) {
           populateSelect(toolSupplier, DBSupplierNames);
         }
       } 
       if (varForm.id == <?php print("\"$frmToolUsageUpdateName\""); ?>) {
         var allTextBoxes = varForm.getElementsByTagName("input");
         var varIdx = 0;

         for (var idx = 0; idx < allTextBoxes.length; idx++) {
           if (allTextBoxes[idx].type == "text") {
             if (allTextBoxes[idx].id == DBToolUsageArray[varIdx][0]+<?php print("\"$inStoreSuffix\"");?>) {
               allTextBoxes[idx].value = DBToolUsageArray[varIdx][1];
             } else if (allTextBoxes[idx].id == DBToolUsageArray[varIdx][0]+<?php print("\"$inUseSuffix\"");?>) {
               allTextBoxes[idx].value = DBToolUsageArray[varIdx][2];
               varIdx++;
             }
           }
         }
       }
     }
     function showAddPart() {
       var frmAddPart = document.getElementById(<?php print("\"$frmPartAddName\"");?>);
       showForm(frmAddPart);
     }   
     function showAddCustomer() {
       var frmAddCustomer = document.getElementById(<?php print("\"$frmCustomerAddName\"");?>);
       showForm(frmAddCustomer);
     }   
     function showAddOperation() {
       var frmAddOperation = document.getElementById(<?php print("\"$frmOperationAddName\"");?>);
       showForm(frmAddOperation);
       var machineList = document.getElementById("operationMachine");
       machineList.options.length = 0;
       <?php
        for ($idx=0; $idx < count($machineNames); $idx++) {
 	  print("machineList.options[machineList.options.length] = new Option('$machineNames[$idx]','$machineNames[$idx]');\n");
        }
       ?>
       var opToolHolderList = document.getElementById("opToolHolderList");
       opToolHolderList.options.length = 0;
       var opProgramList = document.getElementById("opProgramList");
       opProgramList.options.length = 0;
     }   
     function showAddProgram() {
       var frmAddProgram = document.getElementById(<?php print("\"$frmProgramAddName\"");?>);
       showForm(frmAddProgram);

       var programNumber = document.getElementById("programNumber");
       var programType = document.getElementById("programType");
       var programCode = document.getElementById("programCode");
	  
       programNumber.value = "";
       programType.options[0].selected = true;
       programCode = "";
     }   
     function showAddTool() {
       var frmAddTool = document.getElementById(<?php print("\"$frmToolAddName\"");?>);
       showForm(frmAddTool);
     }   
     function showAddToolHolder() {
       var frmAddToolHolder = document.getElementById(<?php print("\"$frmOperationTHAddName\"");?>);
       showForm(frmAddToolHolder);
     }   
     function showAddToolSkipSubmit() {
       var frmAddTool = document.getElementById(<?php print("\"$frmToolAddName\"");?>);
       toolFormSkipSubmit = true;
       showForm(frmAddTool);
     }   
     function showAddInsert() {
       var frmAddInsert = document.getElementById(<?php print("\"$frmInsertAddName\"");?>);
       showForm(frmAddInsert);
     }   
     function showAddHolder() {
       var frmAddHolder = document.getElementById(<?php print("\"$frmHolderAddName\"");?>);
       showForm(frmAddHolder);
     }   
     function showAddMachine() {
       var frmAddMachine = document.getElementById(<?php print("\"$frmMachineAddName\"");?>);
       showForm(frmAddMachine);
     }   
     function showAddSupplier() {
       var frmAddSupplier = document.getElementById(<?php print("\"$frmSupplierAddName\"");?>);
       var cancelButtonId = <?php print("\"$frmSupplierAddName\"");?> + "CancelForm";
       var cancelButton = document.getElementById(cancelButtonId);

       supplierFormSkipSubmit = false;
       cancelButton.style.display = "none";
       showForm(frmAddSupplier);
     }
     function showAddSupplierSkipSubmit() {
       var frmAddSupplier = document.getElementById(<?php print("\"$frmSupplierAddName\"");?>);
       var cancelButtonId = <?php print("\"$frmSupplierAddName\"");?> + "CancelForm";
       var cancelButton = document.getElementById(cancelButtonId);

       supplierFormSkipSubmit = true;
       cancelButton.style.display = "block";

       showForm(frmAddSupplier);
     }
     function showUpdateToolUsage() {
       var frmUpdateToolUsage = document.getElementById(<?php print("\"$frmToolUsageUpdateName\"");?>);
       showForm(frmUpdateToolUsage);
     }   

    </script>

   <!-- Functions for clearing of forms -->
   <script language="javascript">
     function clearOperationForm() {
       operationDescription = document.getElementById('operationDescription');
       operationCuttingTime = document.getElementById('operationCuttingTime');
       operationClampingTime = document.getElementById('operationClampingTime');
       operationToolHolderList = document.getElementById('opToolHolderList');
       operationProgramList = document.getElementById('opProgramList');
       operationToolHolderStore = document.getElementById('toolHolderStore');
       operationProgramStore = document.getElementById('programStore');
       
       operationDescription.value = "";
       operationCuttingTime.value = "";
       operationClampingTime.value = "";
       operationToolHolderList.options.length = 0;
       operationProgramList.options.length = 0;
     }
     function clearForm() {
       var clearConfirm;
       clearConfirm = confirm('Are you sure you want to cancel/clear the form?');
       if (!clearConfirm) {
         return;
       }
       if (currentForm.id == <?php print("\"$frmOperationAddName\"");?>) {
         clearOperationForm();
       } else if (currentForm.id == <?php print("\"$frmToolAddName\"");?>) {
         clearToolForm();
       } else if (currentForm.id == <?php print("\"$frmHolderAddName\"");?>) {
         clearHolderForm();
       } else if (currentForm.id == <?php print("\"$frmOperationTHAddName\"");?>) {
         clearToolHolderForm();
       } else if (currentForm.id == <?php print("\"$frmMachineAddName\"");?>) {
         clearMachineForm();
       } else if (currentForm.id == <?php print("\"$frmSupplierAddName\"");?>) {
         clearSupplierForm();
       } else if (currentForm.id == <?php print("\"$frmProgramAddName\"");?>) {
         clearProgramForm();
       } else if (currentForm.id == <?php print("\"$frmCustomerAddName\"");?>) {
         clearCustomerForm();
       }
     }
   </script>

    <!-- Functions for showing of forms -->
    <script language="javascript">
    function displayResult(resultText) {
       var resultTxt = document.getElementById("resultTxt");
       resultTxt.innerHTML = resultText;
    }

    function checkIfValueExistsInArray(thisArray, thisValue) {
      var result = false;
      for (var idx=0; idx<thisArray.length ;idx++) {
        if (thisArray[idx] == thisValue) {
          result = true;
          break;
        }
      }
      return result;
    }

    function checkIfValueExistsInSelect(thisSelect, thisValue) {
      var result = false;
      for (var idx=0; idx<thisSelect.options.length ;idx++) {
        if (thisSelect.options[idx].value == thisValue) {
           result = true;
           break;
         }
       }
       return result;
    }

    function checkToolData(toolPartNumber, toolDescription, toolAvailability,
                           toolMake, toolSupplier, toolPriceInfo,
                           toolQuantityInStore, toolQuantityInUse, toolDiameter,
                           toolNumCuttingEdges, toolFluteLength, toolShankDiameter,
                           toolUsefulLength, toolOverallLength, toolCoating,
                           toolType, toolCornerRadiusOrAngle, toolScrewPartNumber,
                           toolScrewPartQuantity, toolWrenchPartNumber) {
      var result = true;
      var reasonStr;

      if (isEmpty(toolPartNumber)) {
        reasonStr = " part number is empty";
        result = false;
      }
      if (isEmpty(toolDescription)) {
        reasonStr = " description is empty";
        result = false;
      }
      if (result) {
        if (checkIfValueExistsInArray(DBToolPartNumbers,toolPartNumber)) {
          reasonStr = " part number already exists in the database";
          result = false;
        }
      }
      if (result) {
        if (!isEmpty(toolQuantityInStore)) { 
          if (!isInt(toolQuantityInStore)) {
            result = false;
            reasonStr = " quantity bought is not an integer:" + toolQuantityInStore;
          } 
        } 
      }
      if (result) {
        if (!isEmpty(toolQuantityInUse)) {
          if (!isInt(toolQuantityInUse)) {
            result = false;
            reasonStr = " quantity in use is not an integer:" + toolQuantityInUse;
          }
        } 
      }
      if (result) {
        if (!isEmpty(toolDiameter)) {
          if (!isFloat(toolDiameter)) {
            result = false;
            reasonStr = " diameter is not an valid float:" + toolDiameter ;
          }
        } else {
          result = false;
          reasonStr = " diameter is not defined";
        }
      }
      if (result) {
        if (!isEmpty(toolNumCuttingEdges)) {
          if (!isInt(toolNumCuttingEdges)) {
            result = false;
            reasonStr = " number of cutting edges is not an integer:" + toolNumCuttingEdges;
          }
        } 
      }
      if (result) {
        if (!isEmpty(toolShankDiameter)) {
          if (!isFloat(toolShankDiameter)) {
            result = false;
            reasonStr = " shank diameter is not a valid float:" + toolShankDiameter;
          }
        } 
      }
      if (result) {
        if (!isEmpty(toolUsefulLength)) {
          if (!isFloat(toolUsefulLength)) {
            result = false;
            reasonStr = " useful length is not a valid float:" + toolUsefulLength;
          }
        } 
      }
      if (result) {
        if (!isEmpty(toolFluteLength)) {
          if (!isFloat(toolFluteLength)) {
            result = false;
            reasonStr = " flute length is not an valid float:" + toolFluteLength;
          }
        }
      }
      if (result) {
        if (!isEmpty(toolOverallLength)) {
          if (!isFloat(toolOverallLength)) {
            result = false;
            reasonStr = " overall length is not an valid float:" + toolOverallLength;
          }
        }
      }
      if (result) {
        if (!isEmpty(toolCornerRadiusOrAngle)) {
          if(!isFloat(toolCornerRadiusOrAngle)) {
            result = false;
            reasonStr = " corner radius is not an valid float:" + toolCornerRadiusOrAngle;
          }
        }
      }
      if (result) {
        if (!isEmpty(toolScrewPartQuantity)) {
          if (!isInt(toolScrewPartQuantity)) {
            result = false;
            reasonStr = " screw part quantity is not an integer:" + toolScrewPartQuantity;
          }
        }
      }
      if (result == false) {
        alert('Unable to add tool because tool'+ reasonStr);
      } 
      return result;
    }

						    
    function addToolToFormOrSubmit() {
      var toolAddedSuccessfully = true;
      var result = true;

      var toolPartNumber = document.getElementById('toolPartNumber');
      var toolDescription = document.getElementById('toolDescription');
      var toolAvailability = document.getElementById('toolAvailability');
      var toolMake = document.getElementById('toolMake');
      var toolSupplier = document.getElementById('toolSupplier');
      var toolPriceInfo = document.getElementById('toolPriceInfo');
      var toolQuantityInStore = document.getElementById('toolQuantityInStore');
      var toolQuantityInUse = document.getElementById('toolQuantityInUse');
      var toolDiameter = document.getElementById('toolDiameter');
      var toolNumCuttingEdges = document.getElementById('toolNumCuttingEdges');
      var toolFluteLength = document.getElementById('toolFluteLength');
      var toolShankDiameter = document.getElementById('toolShankDiameter');
      var toolUsefulLength = document.getElementById('toolUsefulLength');
      var toolOverallLength = document.getElementById('toolOverallLength');
      var toolCoating = document.getElementById('toolCoating');
      var toolType = document.getElementById('toolType');
      var toolCornerRadiusOrAngle = document.getElementById('toolCornerRadiusOrAngle');
      var toolScrewPartNumber = document.getElementById('toolScrewPartNumber');
      var toolScrewPartQuantity = document.getElementById('toolScrewPartQuantity');
      var toolWrenchPartNumber = document.getElementById('toolWrenchPartNumber');
      
      if (!checkToolData(toolPartNumber.value, toolDescription.value, toolAvailability.value, toolMake.value,
                    toolSupplier.value, toolPriceInfo.value, toolQuantityInStore.value, toolQuantityInUse.value,
                    toolDiameter.value, toolNumCuttingEdges.value, toolFluteLength.value, toolShankDiameter.value,
                    toolUsefulLength.value, toolOverallLength.value, toolCoating.value, toolType.value, 
                    toolCornerRadiusOrAngle.value, toolScrewPartNumber.value, toolScrewPartQuantity.value,
                    toolWrenchPartNumber.value)) {
        result = false;
      }

      if (result && toolFormSkipSubmit) {
        var opTHToolList = document.getElementById('operationTHToolName');
        var toolToBeAdded = toolPartNumber.value;

        var opTHToolList = document.getElementById('operationTHToolName');
        var toolToBeAdded = toolPartNumber.value;
        if (checkIfValueExistsInSelect(opTHToolList, toolToBeAdded)) {
          alert('Tool already added to select');
          toolAddedSuccessfully = false;
        } else {
          opTHToolList.options[opTHToolList.options.length] = new Option(toolPartNumber.value, toolPartNumber.value);
	  var selectedIndex = opTHToolList.options.length - 1;
          opTHToolList.options[selectedIndex].selected = true;
          var toolStore = document.getElementById('toolStore');
          toolStore.value = toolStore.value + <?php print("\"$toolBeginDelimiter\""); ?>;
          <?php
            for ($idx = 0; $idx < count($frmToolElementDBNames); $idx++) {
             print("\t\ttoolStore.value = toolStore.value + $frmToolElementNames[$idx].value + \"$dataDelimiter\"\n");
            }
          ?>
          var insertStore = document.getElementById('insertStore');
          toolStore.value = toolStore.value + insertStore.value + <?php print("\"$dataDelimiter\""); ?>;
	  toolStore.value = toolStore.value + <?php print("\"$toolEndDelimiter\""); ?>;
          showPreviousForm();
        }
        result = false;
      } 
	     
      return (result);
    }

    function updateToolAndSubmit() {
      var result = false;
      var toolNumRows = DBToolUsageArray.length;
      var toolUpdateStore = document.getElementById("toolUpdateStore");
      var toolUsageUpdated = false;

      for (var idx = 0; idx < toolNumRows; idx++) {
        var autoIdx = 0;
        var toolPartNumber = DBToolUsageArray[idx][autoIdx++];
        var toolQuantityInStore = DBToolUsageArray[idx][autoIdx++];
        var toolQuantityInUse = DBToolUsageArray[idx][autoIdx++];
        var toolQuantityInStoreNew = document.getElementById(toolPartNumber+<?php print("\"$inStoreSuffix\"");?>);
        var toolQuantityInUseNew = document.getElementById(toolPartNumber+<?php print("\"$inUseSuffix\"");?>);

        toolUsageUpdated = false;
        if (toolQuantityInStoreNew.value != toolQuantityInStore) {
          result = true;
          toolUsageUpdated = true;
        }
        if (toolQuantityInUseNew.value != toolQuantityInUse) {
          result = true;
          toolUsageUpdated = true;
        }
        if (toolUsageUpdated) {
          toolUpdateStore.value = toolUpdateStore.value + <?php print("\"$toolUsageUpdateBeginDelimiter\""); ?>;
          toolUpdateStore.value = toolUpdateStore.value + toolPartNumber + <?php print("\"$dataDelimiter\"");?>;
          toolUpdateStore.value = toolUpdateStore.value + toolQuantityInStoreNew.value + <?php print("\"$dataDelimiter\"");?>;
          toolUpdateStore.value = toolUpdateStore.value + toolQuantityInUseNew.value + <?php print("\"$dataDelimiter\"");?>;
          toolUpdateStore.value = toolUpdateStore.value + <?php print("\"$toolUsageUpdateEndDelimiter\""); ?>;
        }
      }
      return (result);
    }

    function checkSupplierData(supplierName) {
      var result = true;
      var reasonStr;
      
      if (isEmpty(supplierName)) {
        result = false;
        reasonStr = " name is empty";
      } 
      if (result) {
        if (checkIfValueExistsInArray(DBSupplierNames, supplierName)) {
          result = false;
          reasonStr = " already exists in the database";
        }
      }
      if (result == false) {
        alert('Unable to add supplier because supplier' + reasonStr);
      }
      return (result);
    }

    function addSupplierToFormOrSubmit() {
      var result = true;

      var supplierName = document.getElementById('supplierName');
      if (!checkSupplierData(supplierName.value)) {
        result = false;
      }
      if (result) {
        if (!supplierFormSkipSubmit) {
          result = true;
        } else {
          var supplierList = document.getElementById('toolSupplier');
          var supplierStore = document.getElementById('supplierStore');
          var supplierContactPerson = document.getElementById('supplierContactPerson');
          var supplierContactAddress = document.getElementById('supplierContactAddress');
          var supplierPhoneNumber = document.getElementById('supplierPhoneNumber');
          var supplierEmail = document.getElementById('supplierEmail');

          supplierList.options[supplierList.length] = new Option (supplierName.value, supplierName.value);
	  supplierList.options[supplierList.length - 1].selected = true;

          supplierStore.value = supplierStore.value + <?php print("\"$supplierBeginDelimiter\""); ?>;
          supplierStore.value = supplierStore.value + supplierName.value + <?php print("\"$dataDelimiter\""); ?>;
          supplierStore.value = supplierStore.value + supplierContactPerson.value + <?php print("\"$dataDelimiter\""); ?>;
          supplierStore.value = supplierStore.value + supplierContactAddress.value + <?php print("\"$dataDelimiter\""); ?>;
          supplierStore.value = supplierStore.value + supplierPhoneNumber.value + <?php print("\"$dataDelimiter\""); ?>;
          supplierStore.value = supplierStore.value + supplierEmail.value + <?php print("\"$dataDelimiter\""); ?>;
          supplierStore.value = supplierStore.value + <?php print("\"$supplierEndDelimiter\""); ?>;
          result = false;
          showPreviousForm();
        }
      }
      return (result);
    }

    function addMachineToList() {
      var machineName = document.getElementById('machineName');
      var machineVendor = document.getElementById('machineVendor');
      var machineSerialNumber = document.getElementById('machineSerialNumber');
      var machineSelect = document.getElementById('operationMachine');
      var machineStore = document.getElementById('machineStore');
      var selectedMachineForAdd = machineName.value;
       if (selectedMachineForAdd == "") {
        alert('Empty machine selected');
        return;
      }
      if (!checkIfValueExistsInSelect(machineSelect, selectedMachineForAdd)) {
        machineSelect.options[machineSelect.options.length] = new Option(machineName.value, machineName.value);
      } else {
        alert('Machine already exists in list.');
        return;
      }

      machineStore.value = machineStore.value + <?php print("\"$machineBeginDelimiter\"");?>;
      machineStore.value = machineStore.value + machineName.value + <?php print("\"$dataDelimiter\"");?>;
      machineStore.value = machineStore.value + machineVendor.value + <?php print("\"$dataDelimiter\"");?>;
      machineStore.value = machineStore.value + machineSerialNumber.value + <?php print("\"$dataDelimiter\"");?>;
      machineStore.value = machineStore.value + <?php print("\"$machineEndDelimiter\"");?>;
    }

    function addNewCustomer() {
      var customerSelect = document.getElementById('partCustomerName');
      var customerStore = document.getElementById('customerStore');
      var customerName = document.getElementById('customerName');
      var customerOtherDetails = document.getElementById('customerOtherDetails');
					     
      selectedCustomerForAdd = customerName.value;
      if (!checkIfValueExistsInSelect(customerSelect, selectedCustomerForAdd)) {
        customerSelect.options[customerSelect.options.length] = new Option(customerName.value, customerName.value);
      } else {
        alert('Customer already exists in list.');
        return;
      }

      customerStore.value = customerStore.value + <?php print("\"$customerBeginDelimiter\"");?>;
      customerStore.value = customerStore.value + customerName.value + <?php print("\"$dataDelimiter\"");?>;
      customerStore.value = customerStore.value + customerOtherDetails.value + <?php print("\"$dataDelimiter\"");?>;
      customerStore.value = customerStore.value + <?php print("\"$customerEndDelimiter\"");?>;
      showPreviousForm();
    }

    function addNewToolHolderToList() {
      var holderName = document.getElementById('operationTHHolderName');
      var toolPartNumber = document.getElementById('operationTHToolName');
      var toolRemark = document.getElementById('operationTHToolRemark');
      var toolOverHang = document.getElementById('operationTHToolOverHang');
      var toolLife = document.getElementById('operationTHToolLife');
      var toolStore = document.getElementById('toolStore');
      var holderStore = document.getElementById('holderStore');
      var opToolHolderList = document.getElementById('opToolHolderList');
      var toolHolderStore = document.getElementById('toolHolderStore');

      var opToolHolderName = toolPartNumber.value + ":" + holderName.value + ":" + toolRemark.value;
      if (!checkIfValueExistsInSelect(opToolHolderList, opToolHolderName)) {
        opToolHolderList.options[opToolHolderList.options.length] = new Option(opToolHolderName, opToolHolderName);
      } else {
        alert('Holder already exists in list.');
        return;
      }

      toolHolderStore.value = toolHolderStore.value + <?php print("\"$toolHolderBeginDelimiter\"");?>;
      toolHolderStore.value = toolHolderStore.value + toolPartNumber.value + <?php print("\"$dataDelimiter\"");?>;
      toolHolderStore.value = toolHolderStore.value + holderName.value + <?php print("\"$dataDelimiter\"");?>;
      toolHolderStore.value = toolHolderStore.value + toolRemark.value + <?php print("\"$dataDelimiter\"");?>;
      toolHolderStore.value = toolHolderStore.value + toolOverHang.value + <?php print("\"$dataDelimiter\"");?>;
      toolHolderStore.value = toolHolderStore.value + toolLife.value + <?php print("\"$dataDelimiter\"");?>;
      toolHolderStore.value = toolHolderStore.value + toolStore.value + <?php print("\"$dataDelimiter\"");?>;
      toolHolderStore.value = toolHolderStore.value + holderStore.value + <?php print("\"$dataDelimiter\"");?>;
      toolHolderStore.value = toolHolderStore.value + <?php print("\"$toolHolderEndDelimiter\"");?>;
      alert(toolHolderStore.value);	      
      showPreviousForm();
    }


    function addHolderToList() {
      var holderName = document.getElementById('holderName');
      var holderSelect = document.getElementById('operationTHHolderName');
      var holderStore = document.getElementById('holderStore');
      var selectedHolderForAdd = holderName.value;

      if (!checkIfValueExistsInSelect(holderSelect, selectedHolderForAdd)) {
        holderSelect.options[holderSelect.options.length] = new Option(holderName.value, holderName.value);
        var selectedIndex = holderSelect.options.length - 1;
        holderSelect.options[selectedIndex].selected = true;
      } else {
        alert('Holder already exists in list.');
        return;
      }

      holderStore.value = holderStore.value + <?php print("\"$holderBeginDelimiter\"");?>;
      holderStore.value = holderStore.value + selectedHolderForAdd + <?php print("\"$dataDelimiter\"");?>;
      holderStore.value = holderStore.value + <?php print("\"$holderEndDelimiter\"");?>;
      showPreviousForm();
    }

    function checkProgramData(programNumber, programType, programCode) {
      if (programNumber == "") {
	alert('Program number is required');
      }
    }

    function addProgramToList() {
      var programNumber = document.getElementById('programNumber');
      var programType = document.getElementById('programType');
      var programCode = document.getElementById('programCode');
      var programList = document.getElementById('opProgramList');
      var programStore = document.getElementById('programStore');

      if (!checkProgramData(programNumber.value, programType.value, programCode.value)) {
        return;
      }
      if (!checkIfValueExistsInSelect(programList, programNumber.value)) {
        programList.options[programList.options.length] = new Option(programNumber.value, programNumber.value);
      } else {
        alert('Program already exists in list.');
        return;
      }
      programStore.value = programStore.value + <?php print("\"$progBeginDelimiter\"");?>;
      programStore.value = programStore.value + programNumber.value + <?php print("\"$dataDelimiter\"");?>;
      programStore.value = programStore.value + programType.value + <?php print("\"$dataDelimiter\"");?>;
      programStore.value = programStore.value + programCode.value + <?php print("\"$dataDelimiter\"");?>;
      programStore.value = programStore.value + <?php print("\"$progEndDelimiter\"");?>;
      showPreviousForm();
    }

    function addOperationToList() {
      var operationName = document.getElementById('operationName');
      var operationMachine = document.getElementById('operationMachine');
      var operationDescription = document.getElementById('operationDescription');
      var operationCuttingTime = document.getElementById('operationCuttingTime');
      var operationClampingTime = document.getElementById('operationClampingTime');
      var operationToolHolderList = document.getElementById('opToolHolderList');
      var operationList = document.getElementById('operationList');
      var operationStore = document.getElementById('operationStore');
      var machineStore = document.getElementById('machineStore');
      var programStore = document.getElementById('programStore');
      var toolHolderStore = document.getElementById('toolHolderStore');

      if (!checkIfValueExistsInSelect(operationList, operationName.value)) {
        operationList.options[operationList.options.length] = new Option(operationName.value, operationName.value);
      } else {
        alert('Operation already exists in list.');
        return;
      }

      operationStore.value = operationStore.value + <?php print("\"$opBeginDelimiter\"");?>;
      operationStore.value = operationStore.value + operationName.value + <?php print("\"$dataDelimiter\"");?>;
      operationStore.value = operationStore.value + operationMachine.value + <?php print("\"$dataDelimiter\"");?>;
      operationStore.value = operationStore.value + operationDescription.value + <?php print("\"$dataDelimiter\"");?>;
      operationStore.value = operationStore.value + operationCuttingTime.value + <?php print("\"$dataDelimiter\"");?>;
      operationStore.value = operationStore.value + operationClampingTime.value + <?php print("\"$dataDelimiter\"");?>;
      operationStore.value = operationStore.value + toolHolderStore.value + <?php print("\"$dataDelimiter\"");?>;
      operationStore.value = operationStore.value + programStore.value + <?php print("\"$dataDelimiter\"");?>;
      operationStore.value = operationStore.value + machineStore.value + <?php print("\"$dataDelimiter\"");?>;
      operationStore.value = operationStore.value + <?php print("\"$opEndDelimiter\"");?>;
      showPreviousForm();
    }

    function checkInsertData(insertPartNumber, insertQuantity) {
      var result = true;
      var reasonStr;

      if (isEmpty(insertPartNumber)) {
        reasonStr = " part number is empty";
        result = false;
      }
      if (result) {
        if (checkIfValueExistsInArray(DBInsertPartNumbers,insertPartNumber)) {
          reasonStr = " part number already exists in the database";
          result = false;
        }
      }
      if (result) {
        if (isEmpty(insertQuantity)) { 
          result = false;
          reasonStr = " quantity is unspecified";
        } else if (!isInt(insertQuantity)) {
          result = false;
          reasonStr = " quantity bought is not an integer:" + insertQuantity;
        } 
      }
      if (result == false) {
        alert('Unable to add insert because insert' + reasonStr);
      }
      return (result);
    }	      

    function addInsertToSelect() {
      var insertPartNumber = document.getElementById('insertPartNumber');
      var insertQuantity = document.getElementById('insertQuantity');
      var insertSelect = document.getElementById('insertSelect');
      var insertStore = document.getElementById('insertStore');
	     
      if (!checkInsertData(insertPartNumber.value, insertQuantity.value)) {
        return;
      }

      if (!checkIfValueExistsInSelect(insertSelect, insertPartNumber.value)) {
        insertSelect.options[insertSelect.options.length] = new Option(insertPartNumber.value, insertPartNumber.value);
      } else {
        alert('Insert already exists in select.');
        return;
      }

      insertStore.value = insertStore.value + <?php print("\"$insertBeginDelimiter\"");?>;
      insertStore.value = insertStore.value + insertPartNumber.value + <?php print("\"$dataDelimiter\"");?>;
      insertStore.value = insertStore.value + insertDescription.value + <?php print("\"$dataDelimiter\"");?>;
      insertStore.value = insertStore.value + insertQuantity.value + <?php print("\"$dataDelimiter\"");?>;
      insertStore.value = insertStore.value + <?php print("\"$insertEndDelimiter\"");?>;
      showPreviousForm();
    }

    function addInsertToList() {
      var insertSelect = document.getElementById('insertSelect');
      var insertList = document.getElementById('insertList');
      var insertSelect = document.getElementById('insertSelect');
      var insertsForToolStore = document.getElementById('insertsForToolStore');

      if (!checkIfValueExistsInSelect(insertList, insertSelect.value)) {
        insertList.options[insertList.options.length] = new Option(insertSelect.value, insertSelect.value);
      } else {
        alert('Insert already exists in list.');
        return;
      }

      insertsForToolStore.value = insertsForToolStore.value + <?php print("\"$insertBeginDelimiter\"");?>;
      insertsForToolStore.value = insertsForToolStore.value + insertSelect.value + <?php print("\"$dataDelimiter\"");?>;
      insertsForToolStore.value = insertsForToolStore.value + <?php print("\"$insertEndDelimiter\"");?>;
    }

    </script>
    
    <!-- APIs for deletion of objects from list -->
    <script language = "javascript">  
    function deleteSelectedOperation() {
      var deleteConfirm;
    
      deleteConfirm = confirm('Are you sure you want to delete the selected operation?');
      if (!deleteConfirm) {
        return;
      }
      
      var operationList = document.getElementById('operationList');
      var operationDeleted;
      var deletedOperationName;

      operationDeleted = false;

      var idx;
      for (idx = operationList.length - 1; idx >= 0; idx--) {
        if (operationList.options[idx].selected) {
          deletedOperationName = operationList.options[idx].value;
          operationList.remove(idx);
          operationDeleted = true;
        }
      }
       
      if (operationDeleted == false) {
        return;
      }

      var operationStore = document.getElementById('operationStore');
      var operationsDeleted = document.getElementById('operationDeleteList');
      operationsDeleted.value = operationsDeleted.value + deletedOperationName;
      operationsDeleted.value = operationsDeleted.value + <?php print("\"$dataDelimiter\""); ?>;

      var opText, opBeginDelimiter, opEndDelimiter;
      var opTextSingle, opToken;
      var dataDelimiter;
      var beginDelimiterPos;
      var operationFoundInStore;
              
      opText = operationStore.value;
      opBeginDelimiter = <?php print("\"$opBeginDelimiter\""); ?>;
      opEndDelimiter = <?php print("\"$opEndDelimiter\""); ?>;
      dataDelimiter = <?php print("\"$dataDelimiter\""); ?>;
      beginDelimiterPos = strpos(opText, opBeginDelimiter);

      while (!(beginDelimiterPos === false)) {
        endDelimiterPos = strpos(opText, opEndDelimiter, beginDelimiterPos);

        if (endDelimiterPos === false) {
          alert('Corrupt operation store string!');
          return;
        }

        opTextSingle = opText.substring(beginDelimiterPos + opBeginDelimiter.length, (endDelimiterPos + opEndDelimiter.length));
        opToken = strtok(opTextSingle, dataDelimiter);

        if (opToken == deletedOperationName) {
          alert('Found token equal to deleted operation name');
          operationFoundInStore = true;
          if (beginDelimiterPos == 0) {
            newOpText = opText.substring((endDelimiterPos + opEndDelimiter.length), opText.length - 1);
          } else {
	    newOpText = opText.substring(0, beginDelimiterPos - 1);
	    newOpText = newOpText + opText.substring((endDelimiterPos + opEndDelimiter.length), opText.length);
          }
          break;
        } else {
	  beginDelimiterPos = strpos(opText, opBeginDelimiter, endDelimiterPos + opEndDelimiter.length);
        }
      }
      if (operationFoundInStore) {
        operationStore.value = newOpText;
      }
    }

    function init(frmName) {
      var txts = document.getElementsByTagName('input');
      for (var i=0; i<txts.length; i++) {
        if (txts[i].type=="text" || txts[i].type == "hidden") {
          txts[i].value = "";
        }
      }
      hideAllForms();
      populateToolsIntoVar();
      populateInsertsIntoVar();
      populateSuppliersIntoVar();
      populateToolUsageIntoVar();

      displayResult("Ready");
      if (frmName == "<?php echo $frmMachineAddName?>") {
        displayResult("Operation Completed Successfully!");
        showAddMachine(true);
      } else if (frmName == "<?php echo $frmSupplierAddName?>") {
        displayResult("Operation Completed Successfully!");
        showAddSupplier();
      } else if (frmName == "<?php echo $frmToolAddName?>") {
        displayResult("Tool Added Successfully");
        showAddTool();
      }
    }
  </script>
</HEAD>

<!--
   File to add/view/report parts, operations, tools, holders, etc.
-->

<?php
  if (IsSet($_GET['AddMachine']) == "true") {
    print("<BODY onload=\"javascript:init('$frmMachineAddName');\">\n");
  } else if (IsSet($_GET['AddSupplier']) == "true") {
    print("<BODY onload=\"javascript:init('$frmSupplierAddName');\">\n");
  } else if (IsSet($_GET['AddTool']) == "true") {
    print("<BODY onload=\"javascript:init('$frmToolAddName');\">\n");
  } else {
    print("<BODY onload=\"javascript:init('NIL');\">\n");
  }
?>
  <table bgcolor="#ABABAB" width="100%">
  <tr>
    <td align="center">
      <H1>Inventory manager<H1>
    </td>
  </tr>
  </table>


  <table>
  <tr>
    <td>
      <a href="javascript:showAddPart();">Add Part</a>
    </td>
    <td>
      <a href="javascript:showViewPart();">View Part</a>
    </td>
    <td>
      <a href="javascript:showAddTool();">Add Tool</a>
    </td> 
    <td>
      <a href="javascript:showUpdateToolUsage();">Update Tool</a>
    </td>
    <td>
      <a href="javascript:showAddSupplier();">Add Supplier</a>
    </td>
  </tr>
  </table>

  <?php
     $defaultDivStyle = "block";
     $masterTableWidth = "500";
     $masterTableRowWidth = "250";
     $masterTableColWidth = "250";

     include('writeObjects.php');
     include('frmPartsAdd.php');
     include('frmOperationsAdd.php');
     include('frmMachinesAdd.php');
     include('frmHoldersAdd.php');
     include('frmToolsHoldersAdd.php');
     include('frmToolsAdd.php');
     include('frmToolsUsageUpdate.php');
     include('frmToolsUsageUpdateNew.php');
     include('frmInsertsAdd.php');
     include('frmSuppliersAdd.php');
     include('frmProgramsAdd.php');     
     include('frmCustomersAdd.php');
     include('frmResult.php');
  ?>
</BODY>
</HTML>
