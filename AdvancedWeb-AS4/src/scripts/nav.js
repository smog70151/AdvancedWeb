$(document).ready(function () {

    id = "1927414140636464";
    $.ajax({
        url: "/FinalProject/api/getUserData.php?id=" + id,
        dataType: "json",
        async: false,
        success: function (data) {
            document.getElementById("userName").innerHTML = data[0].name;
            img = document.getElementById("userPhoto");
            img.setAttribute("src", data[0].pic);   
            console.log(data[0].pic);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert(textStatus, +' | ' + errorThrown);
        }
    })
});