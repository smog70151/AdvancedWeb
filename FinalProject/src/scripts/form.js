var d;
$(document).ready(function () {

    // var dept = document.createElement("option");
    // document.getElementById("Dept").appendChild(dept);
    // dept.innerHTML = " --- ";

    // var course = document.createElement("option");
    // document.getElementById("Course").appendChild(course);
    // course.innerHTML = " --- ";

    // load Department data
    $.ajax({
        url: "/FinalProject/api/queryDeptData.php",
        dataType: "json",
        async: false,
        success: function (data) {
            var len =  Object.keys(data).length;
            for (var i = 104; i < len; i++) {
                for(var j = 0; j < 104; j++){
                    if(data[j].id == data[i].id + 1){
                        ////console.log(data[j]);
                        loadDept(data[j], data[i]);
                        break;
                    }
                }
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert(textStatus, +' | ' + errorThrown);
        }
    })
});

function loadDept(en, tw) {
    dept = document.createElement("option");
    document.getElementById("Dept").appendChild(dept);
    dept.innerHTML = en.abbv + " -- " + tw.dept + " " + en.dept;
    d = en.abbv + " - " + tw.dept;
    dept.setAttribute("value", d);
}

function loadCourse(en, tw, id) {
    course = document.createElement("option");
    document.getElementById("Course").appendChild(course);
    course.innerHTML = tw.name + " " + en.name + " / "+ tw.teacher + " " + en.teacher;
    course.setAttribute("value",id);
}

function changeDept(sel) {
    while (document.getElementById("Course").firstChild) {
        document.getElementById("Course").removeChild(document.getElementById("Course").firstChild);
    }
    var abbv = sel.value.split(" -")[0];

    $.ajax({
        url: "/FinalProject/api/queryCourseData.php?abbv=" + abbv,
        dataType: "json",
        async: false,
        success: function (data) {
            for (var i = 0; i < Object.keys(data).length; i = i + 2) {
                loadCourse(data[i+1], data[i], data[i].id);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            var course = document.createElement("option");
            document.getElementById("Course").appendChild(course);
            course.innerHTML = " --- ";
        }
    })
}

function submit()
{
    var id = JSON.parse(localStorage.getItem('user')).facebook_id;
    //console.log(id);
    // $.ajax({
    //     url: "/FinalProject/api/createBookData.php?id=" + id,
    //     dataType: "json",
    //     async: false,
    //     success: function (data) {
    //         //console.log('submit success');
    //     },
    //     error: function (jqXHR, textStatus, errorThrown) {
    //         //console.log('submit fail');
    //     }
    // })


    // location.href = "/FinalProject/src/booklist.php?id=" + id;
}

// function checkprice(p){
//     if(p.value >=0 && p.value <= Number.POSITIVE_INFINITY){

//     }
//     else{
//         alert("價格需為正整數，且不含其他符號 \n Price should be a positive integer");
//         p.value = "";
//     }
// }
