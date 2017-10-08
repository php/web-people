var reEscape = new RegExp('(\\' + ['/', '.', '*', '+', '?', '|', '(', ')', '[', ']', '{', '}', '\\'].join('|\\') + ')', 'g');
var fnFormatSearchResult = function(value, data, currentValue) {
    var pattern = '(' + currentValue.replace(reEscape, '\\$1') + ')';
    var listing = users[value]["name"] + " (" + users[value]["username"] + ")";

    listing = listing.replace(new RegExp(pattern, 'gi'), '<strong>$1<\/strong>');
    return '<img src="http://www.gravatar.com/avatar/' + users[value]["email"] + '.jpg?s=25" /> ' + listing;
};

$('input.search').autocomplete({ 
    minChars:2, 
    maxHeight:400,
    fnFormatResult: fnFormatSearchResult,
    onSelect: function(value, data){ window.location = "/" + users[value]["username"]; },
    lookup: lookup
});

// vim: set expandtab shiftwidth=4 softtabstop=4 tabstop=4 : 
