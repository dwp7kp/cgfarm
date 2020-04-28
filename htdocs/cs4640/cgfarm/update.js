DEBUG = 1;

document.getElementById("submit").addEventListener("click", function () {
    // call the function to send asynch request
    if (DEBUG) console.log("called");

    purchase();
});

function purchase() {
    
    if (document.getElementById("save_addr").checked)
        save_address();
    

    xhr = GetXmlHttpObject();
    if (xhr == null) {
        alert("Your browser does not support XMLHTTP!");
        return;
    }
    var backend_url = "update.php" // relative path

    backend_url += "?command=buy";

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) { // 4 means complete
            if (xhr.status === 200) { // OK
                var res = xhr.responseText;
                // What we want to do
                if (DEBUG) console.log("respose: ", res);
                //confirm(res);
            } else {
                // handle error
                console.log("hxr failed");
            }
        } else {
            // not done yet (3 means still doing, 2 request recieved, 1 connection established)
            if (DEBUG) console.log("xhr still in progress", xhr.readyState);
        }
    }

    xhr.open('GET', backend_url, true); // true means it will be async request
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.send(null);

    location.reload();

}

function save_address() {
    var backend_url = "update.php"
    var addr = document.getElementById('address').value;
    if (DEBUG) console.log ("Address", addr);
    backend_url += "?command=save" + "&addr=" + addr;
    
    xhr = GetXmlHttpObject();
    if (xhr == null) {
        alert("Your browser does not support XMLHTTP!");
        return;
    }
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) { // 4 means complete
            if (xhr.status === 200) { // OK
                var res = xhr.responseText;
                // What we want to do
                if (DEBUG) console.log("respose: ", res);
                //confirm(res);
            } else {
                // handle error
                console.log("hxr failed");
            }
        } else {
            // not done yet (3 means still doing, 2 request recieved, 1 connection established)
            if (DEBUG) console.log("xhr still in progress", xhr.readyState);
        }
    }

    xhr.open('GET', backend_url, true); // true means it will be async request
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.send(null);
}

function GetXmlHttpObject() {
    // Create an XMLHttpRequest object

    if (window.XMLHttpRequest) {  // code for IE7+, Firefox, Chrome, Opera, Safari
        return new XMLHttpRequest();
    }
    if (window.ActiveXObject) { // code for IE6, IE5
        return new ActiveXObject("Microsoft.XMLHTTP");
    }
    return null;
}
