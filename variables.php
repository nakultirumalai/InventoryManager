<?php
  /************************************************
      Common Variables
  *************************************************/
  $frmPartAddName="PartAdd";
  $frmToolAddName="ToolAdd";
  $frmOperationTHAddName="OperationTHAdd";
  $frmToolUsageUpdateName="ToolUsageUpdate";
  $frmToolUsageUpdateNewName="ToolUsageUpdateNew";
  $frmHolderAddName="HolderAdd";
  $frmInsertAddName="InsertAdd";
  $frmOperationAddName="OperationAdd";
  $frmMachineAddName="MachineAdd";
  $frmSupplierAddName="SupplierAdd";
  $frmProgramAddName="ProgramAdd";
  $frmCustomerAddName="CustomerAdd";
  $frmResultName = "Result";
  
  $opBeginDelimiter="**OpBeg**";
  $opEndDelimiter="**OpEnd**";
  $toolBeginDelimiter="**ToolBeg**";
  $toolEndDelimiter="**ToolEnd**";
  $progBeginDelimiter="**ProgBeg**";
  $progEndDelimiter="**ProgEnd**";
  $insertBeginDelimiter="**InsBeg**";
  $insertEndDelimiter="**InsEnd**";
  $holderBeginDelimiter = "**HolderBegin**";
  $holderEndDelimiter = "**HolderEnd**";
  $customerBeginDelimiter = "**CustomerBegin**";
  $customerEndDelimiter = "**CustomerEnd**";
  $machineBeginDelimiter = "**MachineBegin**";
  $machineEndDelimiter = "**MachineEnd**";
  $toolHolderBeginDelimiter = "**THBegin**";
  $toolHolderEndDelimiter = "**THEnd**";
  $supplierBeginDelimiter = "**SupplierBegin**";
  $supplierEndDelimiter = "**SupplierEnd**";
  $toolUsageUpdateBeginDelimiter="**ToolUsgUpdBegin**";
  $toolUsageUpdateEndDelimiter="**ToolUsgUpdEnd**";

  $allBeginDelimiters = array($opBeginDelimiter, $toolBeginDelimiter, 
                              $progBeginDelimiter, $insertBeginDelimiter,
                              $holderBeginDelimiter, $customerBeginDelimiter,
			      $toolHolderBeginDelimiter, $machineBeginDelimiter,
			      $supplierBeginDelimiter, $toolUsageUpdateBeginDelimiter);
  $allEndDelimiters = array($opEndDelimiter, $toolEndDelimiter, 
                            $progEndDelimiter, $insertEndDelimiter,
                            $holderEndDelimiter, $customerEndDelimiter,
			    $toolHolderEndDelimiter, $machineEndDelimiter,
			    $supplierEndDelimiter, $toolUsageUpdateEndDelimiter);
  $dataDelimiter = ";";

  $mainTableBorder = 1;

  $loopCount = 0;

  $debugWritingEnabled = true;

  $disableSQLAdd = false;

  $partFilesUploadDir = "/usr/public_html/drawing_files";

  $frmAction = $_SERVER['PHP_SELF'];

  /************************************************
      Variables for addition of parts
  *************************************************/
  /* Variable that adds a unique prefix to the element names in this form */
   $frmPartElementPrefix = "part";

  /* Variable to override the masterTableWidth */
  $frmPartAddTableWidth = 900;

  /* Variable array to store the names of the elements */
  $frmPartElementText = array ('Part Number', 
                               'Part Name', 
                               'Customer Name', 
                               'Drawing file path', 
                               'Material', 
                               'Input Raw Material Size',
			       'Preview image');

  /* Variable array to store the names of the colums in the Database */
  $frmPartElementDBNames = array ('Number', 
                                  'Name', 
                                  'CustomerName', 
                                  'DrawingFilePath', 
                                  'Material', 
                                  'InputRawMaterialSize',
                                  'PreviewImage');

  /* Variable to store the number of items that need to be displayed */
  $frmPartElementCount = count($frmPartElementDBNames);

  /* Variable array to store the names of the elements */
  $itemCount=0;
  while ($itemCount < $frmPartElementCount) {
    $frmPartElementNames[$itemCount] = "$frmPartElementPrefix$frmPartElementDBNames[$itemCount]";
    $frmPartElementTypes[$itemCount] = "text";
    $itemCount++;
  };
  

  /************************************************
      Variables for addition of operations
  *************************************************/
  /* Variable that adds a unique prefix to the element names in this form */
  $frmOperationPrefix = "operation";

  /* Variable to override the masterTableWidth */
  $frmOperationAddTableWidth = 1025;

  /* Variable array to store the names of the elements */
  $frmOperationElementText = array ('Operation name', 
                                    'Machine', 
                                    'Operation description', 
                                    'Operation cutting time', 
                                    'Operation clamping time');

  /* Variable array to store the names of the colums in the Database */
  $frmOperationElementDBNames = array ('Name', 
                                       'Machine', 
                                       'Description', 
                                       'CuttingTime', 
                                       'ClampingTime');

  /* Variable to store the fixed set of valid operation names */
  $frmOperationNameValues = array('Operation 10', 'Operation 20',
                                  'Operation 30', 'Operation 40',
                                  'Operation 50', 'Operation 60',
                                  'Operation 70', 'Operation 80',
                                  'Operation 90', 'Operation 100',
                                  'Operation 110', 'Operation 120');

  /* Variable to store the number of items that need to be displayed */
  $frmOperationElementCount = count($frmOperationElementDBNames);

  /* Variable for row & column widths of the local table */
  $operationTableWidth = 570;
  $operationTableRowWidth = $operationTableWidth;
  $operationTableColWidth = "100%";

  /* Variable array to store the names of the elements */
  $itemCount=0;
  while ($itemCount < $frmOperationElementCount) {
    $frmOperationElementNames[$itemCount] = "$frmOperationPrefix$frmOperationElementDBNames[$itemCount]";
    $frmOperationElementTypes[$itemCount] = "text";
    $itemCount++;
  };


  /************************************************
      Variables for addition of tools
  *************************************************/
  /* Variable that adds a unique prefix to the element names in this form */
    $frmToolElementPrefix = "tool";

  /* Variable to override the masterTableWidth */
    $frmToolAddTableWidth = 750;

  /* Variable array to store the names of the elements */
    $frmToolElementText = array ('Tool part number',
                             'Tool description',
                             'Tool availability',
                             'Tool make',
                             'Tool supplier',
                             'Tool price info',
                             'No. in store',
                             'No. in use',
                             'Tool diameter',
                             'Number of cutting edges',
                             'Tool flute length',
                             'Tool shank diameter',
                             'Tool useful length',
                             'Tool overall length',
                             'Tool coating',
                             'Tool type',
                             'Tool corner radius / angle',
                             'Tool screw part number',
                             'Tool screw part quantity',
                             'Tool wrench part number');

  /* Variable array to store the names of the colums in the Database */
  $frmToolElementDBNames = array ('PartNumber',
  			        'Description',
                                'Availability',
                                'Make',
                                'Supplier',
                                'PriceInfo',
                                'QuantityInStore',
                                'QuantityInUse',
                                'Diameter',
                                'NumCuttingEdges',
                                'FluteLength',
                                'ShankDiameter',
                                'UsefulLength',
				'OverallLength',
                                'Coating',
                                'Type',
                                'CornerRadiusOrAngle',
                                'ScrewPartNumber',
                                'ScrewPartQuantity',
                                'WrenchPartNumber');

  /* Variable to store the number of items that need to be displayed */
  $frmToolElementCount = count($frmToolElementDBNames);

  /* Variable for row & column widths of the local table */
  $toolTableWidth = 570;
  $toolTableRowWidth = $toolTableWidth;
  $toolTableColWidth = "100%";

  /* Variable array to store the names of the elements */
  $itemCount=0;
  while ($itemCount < $frmToolElementCount) {
    $frmToolElementNames[$itemCount] = "$frmToolElementPrefix$frmToolElementDBNames[$itemCount]";
    $frmToolElementTypes[$itemCount] = "text";
    $itemCount++;
  };


  /************************************************
      Variables for addition of inserts
  *************************************************/
  /* Variable that adds a unique prefix to the
     element names in this form */
  $frmInsertElementPrefix = "insert";

  /* Variable to override the masterTableWidth */
  $frmInsertAddTableWidth = 750;

  /* Variable array to store the names of the elements */
  $frmInsertElementText = array ('Part number', 'Description', 'Quantity');

  /* Variable array to store the names of the colums in the Database */
  $frmInsertElementDBNames = array ('PartNumber', 'Description', 'Quantity');

  /* Variable to store the number of items that need to be displayed */
  $frmInsertElementCount = count($frmInsertElementDBNames);

  /* Variable for row & column widths of the local table */
  $insertTableWidth = 570;
  $insertTableRowWidth = $insertTableWidth;
  $insertTableColWidth = "100%";

  /* Variable array to store the names of the elements */
  $itemCount=0;
  while ($itemCount < $frmInsertElementCount) {
    $frmInsertElementNames[$itemCount] = "$frmInsertElementPrefix$frmInsertElementDBNames[$itemCount]";
    $frmInsertElementTypes[$itemCount] = "text";
    $itemCount++;
  };


  /************************************************
      Variables for addition of suppliers
  *************************************************/
  /* Variable that adds a unique prefix to the
     element names in this form */
  $frmSupplierElementPrefix = "supplier";

  /* Variable to override the masterTableWidth */
  $frmSupplierTableWidth = 750;

  /* Variable array to store the names of the elements */
  $frmSupplierElementText = array ('Supplier name', 
                                   'Contact Person',
                                   'Contact address', 
                                   'Supplier phone number', 
                                   'Supplier email ID');

  /* Variable array to store the names of the colums in the Database */
  $frmSupplierElementDBNames = array ('Name', 
                                      'ContactPerson',
                                      'ContactAddress', 
                                      'PhoneNumber', 
                                      'Email');

  /* Variable for row & column widths of the local table */
  $supplierTableWidth = 570;
  $supplierTableRowWidth = $supplierTableWidth;
  $supplierTableColWidth = "100%";

  /* Variable indicating number of elements in the form */
  $frmSupplierElementCount = count($frmSupplierElementDBNames);

  /* Variable array to store the names of the elements */
  $itemCount=0;
  while ($itemCount < $frmSupplierElementCount) {
    $frmSupplierElementNames[$itemCount] = "$frmSupplierElementPrefix$frmSupplierElementDBNames[$itemCount]";
    $frmSupplierElementTypes[$itemCount] = "text";
    $itemCount++;
  };

  /************************************************
      Variables for addition of machines
  *************************************************/
  /* Variable that adds a unique prefix to the
     element names in this form */
  $frmMachineElementPrefix = "machine";

  /* Variable to override the masterTableWidth */
  $frmMachineTableWidth = 400;

  /* Variable indicating number of elements in the form */
  $frmMachineElementCount = 3;

  /* Variable array to store the names of the elements */
  $frmMachineElementText = array ('Machine name', 'Vendor', 'Serial Number');

  /* Variable array to store the names of the colums in the Database */
  $frmMachineElementDBNames = array ('Name', 'Vendor', 'SerialNumber');

  /* Variable for row & column widths of the local table */
  $machineTableWidth = 570;
  $machineTableRowWidth = $machineTableWidth;
  $machineTableColWidth = "100%";

  /* Variable array to store the names of the elements */
  $itemCount=0;
  while ($itemCount < $frmMachineElementCount) {
    $frmMachineElementNames[$itemCount] = "$frmMachineElementPrefix$frmMachineElementDBNames[$itemCount]";
    $frmMachineElementTypes[$itemCount] = "text";
    $itemCount++;
  };

  /************************************************
      Variables for addition of programs
  *************************************************/
  /* Variable that adds a unique prefix to the
     element names in this form */
  $frmProgramElementPrefix = "program";

  /* Variable to override the masterTableWidth */
  $frmProgramTableWidth = 400;

  /* Variable array to store the names of the elements */
  $frmProgramElementText = array ('Program number', 'Program Type', 'Program code');

  /* Variable array to store the names of the colums in the Database */
  $frmProgramElementDBNames = array ('Number', 'Type', 'Code');

  /* Variable indicating number of elements in the form */
  $frmProgramElementCount = count($frmProgramElementDBNames);

  /* Variable for row & column widths of the local table *p/
  $programTableWidth = 570;
  $programTableRowWidth = $programTableWidth;
  $programTableColWidth = "100%";

  /* Variable array to store the names of the elements */
  $itemCount=0;
  while ($itemCount < $frmProgramElementCount) {
    $frmProgramElementNames[$itemCount] = "$frmProgramElementPrefix$frmProgramElementDBNames[$itemCount]";
    $itemCount++;
  };

  /************************************************
      Variables for addition of tools and holders
  *************************************************/
  /* Variable that adds a unique prefix to the
     element names in this form */
  $frmOperationTHElementPrefix = "operationTH";

  /* Variable to override the masterTableWidth */
  $frmOperationTHAddTableWidth = 750;

  /* Variable array to store the names of the elements */
  $frmOperationTHElementText = array ('Holder name', 'Tool Name', 'Tool usage remarks', 
                                      'Operation tool overhang', 'Tool life');

  /* Variable array to store the names of the colums in the Database */
  $frmOperationTHElementDBNames = array ('HolderName', 'ToolName', 'ToolRemark', 'ToolOverHang',
  			                 'ToolLife');			     

  /* Variable to store the number of items that need to be displayed */
  $frmOperationTHElementCount = count($frmOperationTHElementDBNames);

  /* Variable for row & column widths of the local table */
  $operationTHTableWidth = 570;
  $operationTHTableRowWidth = $operationTHTableWidth;
  $operationTHTableColWidth = "100%";

  /* Variable array to store the names of the elements */
  $itemCount=0;
  while ($itemCount < $frmOperationTHElementCount) {
    $frmOperationTHElementNames[$itemCount] = "$frmOperationTHElementPrefix$frmOperationTHElementDBNames[$itemCount]";
    $frmOperationTHElementTypes[$itemCount] = "text";
    $itemCount++;
  };

  /************************************************
      Variables for addition of holders
  *************************************************/
  /* Variable that adds a unique prefix to the
     element names in this form */
  $frmHolderElementPrefix = "holder";

  /* Variable to override the masterTableWidth */
  $frmHolderAddTableWidth = 750;

  /* Variable array to store the names of the elements */
  $frmHolderElementText = array ('Holder name');

  /* Variable array to store the names of the colums in the Database */
  $frmHolderElementDBNames = array ('Name');

  /* Variable to store the number of items that need to be displayed */
  $frmHolderElementCount = count($frmHolderElementDBNames);

  /* Variable for row & column widths of the local table */
  $holderTableWidth = 570;
  $holderTableRowWidth = $holderTableWidth;
  $holderTableColWidth = "100%";

  /* Variable array to store the names of the elements */
  $itemCount=0;
  while ($itemCount < $frmHolderElementCount) {
    $frmHolderElementNames[$itemCount] = "$frmHolderElementPrefix$frmHolderElementDBNames[$itemCount]";
    $frmHolderElementTypes[$itemCount] = "text";
    $itemCount++;
  };

  /*************************************************
      Variables for addition of customers
  *************************************************/
  /* Variable that adds a unique prefix to the
     element names in this form */
  $frmCustomerElementPrefix = "customer";

  /* Variable to override the masterTableWidth */
  $frmCustomerAddTableWidth = 750;

  /* Variable array to store the names of the elements */
  $frmCustomerElementText = array ('Customer name', 'Details');

  /* Variable array to store the names of the colums in the Database */
  $frmCustomerElementDBNames = array ('Name', 'OtherDetails');

  /* Variable to store the number of items that need to be displayed */
  $frmCustomerElementCount = count($frmCustomerElementDBNames);

  /* Variable for row & column widths of the local table */
  $customerTableWidth = 570;
  $customerTableRowWidth = $customerTableWidth;
  $customerTableColWidth = "100%";

  /* Variable array to store the names of the elements */
  $itemCount=0;
  while ($itemCount < $frmCustomerElementCount) {
    $frmCustomerElementNames[$itemCount] = "$frmCustomerElementPrefix$frmCustomerElementDBNames[$itemCount]";
    $frmCustomerElementTypes[$itemCount] = "text";
    $itemCount++;
  };

  /*************************************************
      Variables for updating usage of tools 
  *************************************************/
  $inStoreSuffix = "_inStore";
  $inUseSuffix = "_inUse";

?>
