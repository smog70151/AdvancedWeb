var deptName;
var courseName;
var teacher;
var courseID;
$(document).ready(function () {

    url = new URL(location.href);
    bookinfo = url.searchParams.get("dept");
    dept = bookinfo.split("?b_id")[0];
    b_id = url.searchParams.get("b_id");
    abbv = dept.split(" - ")[0];
    //console.log(dept);
    //console.log(abbv);
    //console.log(b_id);
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
                    editBook(data[i]);
                }
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert(textStatus, +' | ' + errorThrown);
        }
    })
});

function editBook(data)
{
    d_name = document.createElement("input");
    c_name = document.createElement("input");
    b_name = document.createElement("input");
    t_name = document.createElement("input");
    price = document.createElement("input");
    note = document.createElement("textarea");

    var radio = ["1","2","3","4","5","6","7","8","9","10"];
    var level = ["1","2","3","4","5","6","7","8","9","10"];
    for(var i=0; i<10; i++){
        radio[i] = document.createElement("div");
        radio[i].setAttribute("class","radio-selection");

        level[i] = document.createElement("input");
        level[i].setAttribute("type", "radio");
        level[i].setAttribute("name", "level");
        level[i].setAttribute("value", i+1);

        radio[i].innerHTML = i+1;
        radio[i].appendChild(level[i]);
    }

    n = document.createElement("label");
    n.setAttribute("style", "margin-left: 10px");
    n.innerHTML = "new";

    document.getElementsByClassName("dept-name")[0].appendChild(d_name);
    document.getElementsByClassName("course-name")[0].appendChild(c_name);
    document.getElementsByClassName("book-name")[0].appendChild(b_name);
    document.getElementsByClassName("teacher")[0].appendChild(t_name);
    document.getElementsByClassName("price")[0].appendChild(price);
    document.getElementsByClassName("note")[0].appendChild(note);
    for(var i=0; i<10; i++){
        document.getElementsByClassName("new-old")[0].appendChild(radio[i]);
    }
    document.getElementsByClassName("new-old")[0].appendChild(n);

    d_name.setAttribute("class", "wrap-input100");
    c_name.setAttribute("class", "wrap-input100");
    b_name.setAttribute("class", "wrap-input100");
    t_name.setAttribute("class", "wrap-input100");
    note.setAttribute("class", "wrap-input100");


    // load form data
    d_name.setAttribute("value", deptName);
    c_name.setAttribute("value", courseName);
    b_name.setAttribute("value", data.name);
    t_name.setAttribute("value", teacher);
    price.setAttribute("value", data.price);
    note.setAttribute("value", data.note);

    level[data.level-1].setAttribute("checked", "checked");

    // set input name
    d_name.setAttribute("name", "Department");
    c_name.setAttribute("name", "CourseName");
    b_name.setAttribute("name", "BookName");
    price.setAttribute("name", "price");
    note.setAttribute("name", "note");

    document.getElementsByClassName("date")[0].innerHTML = "Update Time : " + data.postTime;
    //document.getElementsByClassName("progress-bar")[0].style.width = data.level * 10 + "%";
   // document.getElementsByClassName("progress-bar")[0].innerHTML = data.level * 10 + " %NEW";
    document.getElementsByClassName("img")[0].setAttribute("src", data.imgURL);
    document.getElementsByClassName("otherImg")[0].setAttribute("src", data.imgURL);
    document.getElementsByClassName("otherImg")[1].setAttribute("src", data.imgURL);
    document.getElementsByClassName("otherImg")[2].setAttribute("src", data.imgURL);
    document.getElementsByClassName("otherImg")[3].setAttribute("src", data.imgURL);
    document.getElementsByClassName("otherImg")[4].setAttribute("src", data.imgURL);
}
