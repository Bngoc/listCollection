function toggle(source) {
    var i;
    checkboxes = document.getElementsByName('files[]');
    for (i in checkboxes) {
        checkboxes[i].checked = source.checked;
    }
}