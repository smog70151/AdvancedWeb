$(document).ready(function () {

    id = location.href.split("id=")[1];

    if ( localStorage.getItem('user') ) {
      id = JSON.parse(localStorage.getItem('user')).facebook_id;
    }

    $.ajax({
        url: "/FinalProject/api/getUserData.php?id=" + id,
        dataType: "json",
        async: false,
        success: function (data) {
            document.getElementById("userName").innerHTML = data[0].name;
            img = document.getElementById("userPhoto");
            img.setAttribute("src", data[0].pic);
            img.style.display = "flex";
            img.style.border = "0 5";
            //console.log(data[0].pic);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert(textStatus, +' | ' + errorThrown);
        }
    });
    
    var personalPage = document.getElementById("personal");
    personalPage.href = "/FinalProject/src/personal.php?id=" + id;
    var sellPage = document.getElementById("sell");
    sellPage.href = "/FinalProject/src/form/form.php?id=" + id;
    // var sellTag = document.getElementById('sell');
    
    // sellTag.href = "/FinalProject/src/form/form.php?id=" + id;

});
