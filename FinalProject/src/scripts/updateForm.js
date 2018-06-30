/*
  1. Load Depts and Courses
*/

var d;
var isUpdate = true;
$(document).ready(function () {
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

    filloutForm();

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

    if (isUpdate === false) {
      var abbv = sel;
    } else {
      var abbv = sel.value.split(" -")[0];
    }


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
    location.href = "/FinalProject/src/booklist.php";
}

function filloutForm() {
  url = new URL(location.href);
  b_id = url.searchParams.get("b_id");
  //console.log("This is Book Uni ID : ", b_id);
  var b_info;
  $.ajax({
      url: "/FinalProject/api/queryBookData.php?b_id=" + b_id,
      dataType: "json",
      async: false,
      success: function (data) {
        b_info = data[0];
        //console.log(data);
      }
  })

  var b_abbv = b_info["dept"].slice(' - ')[0];
  var b_name = b_info["name"];
  // 1. Book Name
  document.getElementById('name').value = b_name;

  // 2. Book IMG
  var div = document.getElementsByClassName('dropzone');
  var img = document.createElement('img');
  img.src = b_info["imgURL"];
  div[0].appendChild(img);
  img.setAttribute("class", "bookImg")

  var imgInput = document.getElementById('imgInput');

  imgInput.value = b_info["imgURL"];
  var img_num = div[0].childElementCount - 3;
  if(img_num >= 2) {
    $('.overflow').css("visibility", "visible");
    $('.overflow').text("已上傳" + img_num + "張圖片")
  }

  // 3. Book Dept
  for (var i = 1; i < document.getElementById("Dept").length; i++ ) {
    if (document.getElementById("Dept")[i].value.split(' - ')[0] === b_info['dept'].split(' - ')[0]) {
        document.getElementById("Dept")[i].selected = true;
        break;
    }
  }

  isUpdate = false;
  changeDept(b_info['dept'].split(' - ')[0]);
  isUpdate = true;
  // 4. Book CourseID
  for (var i = 0; i < document.getElementById("Course").length; i++) {
    if (parseInt(document.getElementById("Course")[i].value) === b_info['courseID']) {
        document.getElementById("Course")[i].selected = true;
        break;
    }
  }

  // 5. Book Level
  for (var i = 0; i < document.getElementsByClassName("level").length; i++){
    if (document.getElementsByClassName("level")[i].value == b_info['level']) {
      document.getElementsByClassName("level")[i].checked = true;
      break;
    }
  }

  // 6. Book Price
  document.getElementById('price').value = b_info['price'];

  // 7. Book note
  document.getElementById('note').value = b_info['note'];

  // 8. Book ID
  document.getElementById('b_id').value = b_id;

  // 9. Book Stat
  document.getElementById('b_status').value = 0;

  // 10. User ID
  document.getElementById('u_id').value = JSON.parse(localStorage.getItem('user')).facebook_id;

}
