// document.getElementById("create").style.display = "none";
function changeView(name) {
    alert("external js");
    if (name === 'create') {
        document.getElementById("split").style.display = "none";
        document.getElementById("create").style.display = "block";
    } else {
        document.getElementById("split").style.display = "none";
        document.getElementById("modify").style.display = "block";
        document.getElementById("modify").innerHTML
    }
}

filterSelection = (type) => {
    list = document.getElementsByClassName("card");
    if (type === "all")
        type = "";
    for (var i = 0; i < list.length; i++) {
        if (list[i].className.indexOf(type) > -1) // Found
            list[i].style.display = "block";
        else if (list[i].className.indexOf("head-head") > -1)
            ;
        else
            list[i].style.display = "none";
    }
}

var slider = document.getElementById("price-slider");
var price = document.getElementById("price-shower");

slider.oninput = function () {
    price.innerHTML = "Price: $" + this.value;

    card_list = document.getElementsByClassName("card");
    price_list = document.getElementsByClassName("price-price");

    for (var i = 1; i < card_list.length; i++) {
        var dollar = price_list[i - 1].innerHTML;
        dollar = dollar.split("$")[1];
        dollar = parseInt(dollar);

        if (dollar < this.value) // Found
            card_list[i].style.display = "block";
        else
            card_list[i].style.display = "none";
    }
}