var deptName;
var courseName;
var teacher;
var courseID;
$(document).ready(function () {

    url = new URL(location.href);
    bookinfo = url.searchParams.get("dept");
    dept = bookinfo.split("?b_id")[0];
    b_id = bookinfo.split("b_id=")[1];
    abbv = dept.split(" - ")[0];
    console.log(dept);
    console.log(abbv);
    console.log(b_id);
    // load Book data
    $.ajax({
        url: "/FinalProject/api/queryBookData.php?dept=" + dept,
        dataType: "json",
        async: false,
        success: function (data) {
            var len = Object.keys(data).length;
            for(var i = 0; i < len; i++ ){
                if(data[i].b_id == b_id){
                    courseID = data[i].courseID;
                    $.ajax({
                        url: "/FinalProject/api/queryCourseData.php?abbv=" + abbv,
                        dataType: "json",
                        async: false,
                        success: function (data) {
                            var len = Object.keys(data).length;
                            for(var i = 0; i < len; i++){
                                if(data[i].id == courseID){
                                    deptName = data[i].dept + " " + data[i+1].dept;
                                    courseName = data[i].name + " " + data[i+1].name;
                                    teacher =  data[i].teacher + " " + data[i+1].teacher;
                                }
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            alert(textStatus, +' | ' + errorThrown);
                        }
                    })
                    loadBook(data[i]);
                }
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert(textStatus, +' | ' + errorThrown);
        }
    })
});

function loadBook(data)
{
    document.getElementsByClassName("dept-name")[0].innerHTML = deptName;
    document.getElementsByClassName("course-name")[0].innerHTML = courseName;
    document.getElementsByClassName("teacher")[0].innerHTML = teacher;
    document.getElementsByClassName("book-name")[0].innerHTML = data.name;
    document.getElementsByClassName("date")[0].innerHTML = data.postTime;
    document.getElementsByClassName("price")[0].innerHTML = "$" + data.price;
    document.getElementsByClassName("progress-bar")[0].style.width = data.level * 10 + "%";
    document.getElementsByClassName("progress-bar")[0].innerHTML = data.level * 10 + " %NEW";
    document.getElementsByClassName("img")[0].setAttribute("src", data.imgURL);
    document.getElementsByClassName("otherImg")[0].setAttribute("src", data.imgURL);
    document.getElementsByClassName("otherImg")[1].setAttribute("src", data.imgURL);
    document.getElementsByClassName("otherImg")[2].setAttribute("src", data.imgURL);
    document.getElementsByClassName("otherImg")[3].setAttribute("src", data.imgURL);
    document.getElementsByClassName("otherImg")[4].setAttribute("src", data.imgURL);
}