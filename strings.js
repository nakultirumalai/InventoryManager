function strpos (haystack, needle, offset) {
    var i = (haystack + '').indexOf(needle, (offset || 0));
    return i === -1 ? false : i;
}

function strtok (str, tokens) {
    this.php_js = this.php_js || {};
    if (tokens === undefined) {
        tokens = str;
        str = this.php_js.strtokleftOver;
    }    if (str.length === 0) {
        return false;
    }
    if (tokens.indexOf(str.charAt(0)) !== -1) {
        return this.strtok(str.substr(1), tokens);    }
    for (var i = 0; i < str.length; i++) {
        if (tokens.indexOf(str.charAt(i)) !== -1) {
            break;
        }    }
    this.php_js.strtokleftOver = str.substr(i + 1);
    return str.substring(0, i);
}

