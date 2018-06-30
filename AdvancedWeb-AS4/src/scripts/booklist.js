function showBook(dept) {

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            //console.log(this.responseText);
            var myNode = document.getElementsByClassName('book_container')[0];
            while (myNode.firstChild) {
                myNode.removeChild(myNode.firstChild);
            }
            myNode.innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "../api/queryBookData0.php?dept=" + dept, true);
    xmlhttp.send();
}
