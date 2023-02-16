window.onload = function() {
    var button = document.getElementById("search");

    button.addEventListener('click', SaveMe);
    var btn = document.getElementById("allbtn");

    btn.addEventListener('click', Allrecipe);
    function SaveMe(e) {
        e.preventDefault();
        var request = new XMLHttpRequest();
        var val = document.getElementById("rname").value;
        var url = "http://localhost/comp3161-project/recipe.php?rname=" + val;
        request.onreadystatechange = function() {
            if (request.readyState == XMLHttpRequest.DONE) {
                if (request.status == 200) {
                    var resp = request.responseText;
                    var msg = document.getElementById("result");
                    msg.innerHTML = resp;
                    console.log(resp);
                } else {
                    console.log("Something went wrong with request");
                }
            }
        };
        request.open("GET", url, true);
        request.send();
    }
    function Allrecipe(e) {
        e.preventDefault();
        var request = new XMLHttpRequest();
        var val = document.getElementById("rname").value;
        var url = "http://localhost/comp3161-project/recipe.php?all=all" + val;
        request.onreadystatechange = function() {
            if (request.readyState == XMLHttpRequest.DONE) {
                if (request.status == 200) {
                    var resp = request.responseText;
                    var msg = document.getElementById("result");
                    msg.innerHTML = resp;
                    console.log(resp);
                } else {
                    console.log("Something went wrong with request");
                }
            }
        };
        request.open("GET", url, true);
        request.send();
    }
}