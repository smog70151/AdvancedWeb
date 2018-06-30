var deptName;
var courseName;
var teacher;
var courseID;
var sellerID;
var note;
var status;
var sellerName;
$(document).ready(function () {

    url = new URL(location.href);
    bookinfo = url.searchParams.get("dept");
    dept = bookinfo.split("?b_id")[0];
    b_id = url.searchParams.get("b_id");
    abbv = dept.split(" - ")[0];
    console.log(dept);
    console.log(abbv);
    console.log(b_id);
    // load Book data
    $.ajax({
        url: "/FinalProject/api/queryBookData.php?b_id=" + b_id,
        dataType: "json",
        async: false,
        success: function (data) {
            var len = Object.keys(data).length;
            sellerID = data[0].seller;
            for(var i = 0; i < len; i++ ){
                //console.log(data[i]);
                if(data[i].b_id == b_id){
                    note = data[i].note;
                    courseID = data[i].courseID;
                    status = data[i].status;
                    console.log("status", status);
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
    });
    
    var sellID = sellerID.toString();
    //console.log(sellID);
    $.ajax({
        url: "/FinalProject/api/queryUserData.php?id=" + sellID,
        dataType: "json",
        async: false,
        success: function (data) {
            //console.log("-------",data);
            sellerName = data["0"].name;
           
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(url);
            alert(textStatus, +' | ' + errorThrown);
        }
    })


    var sellerTag = document.getElementById("seller_name");
    sellerTag.innerHTML = sellerName;

    var buyBtn = document.getElementsByClassName('contact100-form-btn')[0];
    var modifyBtn = document.getElementsByClassName('contact100-form-btn')[1];

    if (sellerID == JSON.parse(localStorage.getItem('user')).facebook_id) {
      buyBtn.style.display = "none";
      modifyBtn.addEventListener('click', function() {
        var src = window.location.href.split('book.php')
        var targetHTML = src[0] + "updateForm.php" + src[1];
        window.location.assign(targetHTML);
      });
    } else {
      modifyBtn.style.display = "none";
    }

    buyBtn.addEventListener('click', function () {

      var params = {tags: ["BooksNTHU"]};
      var sellerPKey;
      var buyerID = JSON.parse(localStorage.getItem('user')).facebook_id;
      var buyerPKey;
      var sellerName;

      document.getElementById('chatroom').style.display = "inline";
      document.getElementById('chatroom').innerHTML = document.getElementById('chatroom').innerHTML = "<i class=\"fa fa-refresh fa-spin\" style=\"font-size:15px\"></i>   Loading";
      QB.users.get(params, function(err, result) {
          if (result) {
              console.log("PROTOTYPE: ",result);
              for(var i = 0; i < result.items.length; i++) {
                if(sellerID == result.items[i].user.facebook_id) {
                  sellerPKey = result.items[i].user.id;
                }
                if(buyerID == result.items[i].user.facebook_id) {
                  buyerPKey = result.items[i].user.id;
                }
              }
          }
          var type = 3;
          var occupants_ids = [];
          occupants_ids[0] = sellerPKey;

          console.log("book params", occupants_ids);
          var params = {
              type: type,
              occupants_ids: occupants_ids.join(','),
              name: JSON.parse(localStorage.getItem('user')).full_name
          };

          console.log("book occu params", params.occupants_ids);
          dialogModule.createDialog(params);
      });


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
    document.getElementsByClassName("note-content")[0].innerHTML = note;
    if(status==1){
        document.getElementById("btntext").innerHTML = "SOLD";
        document.getElementsByClassName("contact100-form-btn")[0].style.background = "#C0C0C0";
        document.getElementById("btntext").disabled = true;
    }
}
