function isEmpty(thisValue) {
    var emptyMatch="^[\\s]+$";
    var result = false;

    if (thisValue == null) {
	result = true;
    } else if (thisValue == "") {
        result = true;
    } else if (thisValue.match(emptyMatch)) {
        result = true;
    }
    return (result);
}

function isInt(thisValue) {
    var intMatch="^[\\d]+$";
    var result = false;
    
    if (thisValue.match(intMatch)) {
	result = true;
    }
    return (result);
}

function isFloat(thisValue) {
    var floatMatch="^[\\d]*[.]*[\\d]+$";
    var result = false;

    if (thisValue.match(floatMatch)) {
	result = true;
    } 
    return (result);
}

function emptySelect(thisSelect) {
    thisSelect.length = 0;
}

function populateSelect(thisSelect, thisSelectValues) {
    var selectValuesCount;

    emptySelect(thisSelect);    
    selectValuesCount = thisSelectValues.length;

    for (var idx = 0; idx < selectValuesCount; idx++) {
	thisSelect.options[thisSelect.length] = new Option (thisSelectValues[idx], thisSelectValues[idx]);
    }
}

