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
	for ($idx = 0; $idx < count($frmToolElementDBNames); $idx++) {
	    print("\t  var $frmToolElementNames[$idx] = document.getElementById('$frmToolElementNames[$idx]');\n");
	}
	for ($idx = 0; $idx < count($frmToolElementDBNames); $idx++) {
	    $value = $valueArray[0][$idx];
	    print("\t  $frmToolElementNames[$idx].value = \"$value\";\n");
	}
  ?>
}

