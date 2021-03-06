var srcURL = window.location.href;
var url = new URL(srcURL);

if(url.searchParams.get("dept")){
  DEPT = url.searchParams.get("dept").split('#')[0];
  document.getElementsByClassName("select2-selection__rendered")[0].setAttribute("title", DEPT);
  document.getElementsByClassName("select2-selection__rendered")[0].innerHTML = DEPT;
  console.log(DEPT);
}

function showBook(d) {
  dept = d.value;
    var id = url.searchParams.get("id").split('#')[0];
    if (dept.split(' - ')[0] == "ALL" ) {
      targetURL = srcURL.split('id=')[0] + 'id=' + id + '&curPage=1';
    } else {
      targetURL = srcURL.split('id=')[0] + 'id=' + id + '&curPage=1&dept=' + dept;
    }
    console.log(targetURL);
    window.location.assign(targetURL);
}

document.getElementById("searchInput").addEventListener('keypress', function(e) {
  var key = e.which || e.keyCode;
  if (key === 13) {

    var searchParams = document.getElementById('searchInput').value;
    var srcURL = window.location.href;
    var url = new URL(srcURL);
    var id = url.searchParams.get("id").split('#')[0];
    var dept = url.searchParams.get("dept").split('#')[0];

    if (searchParams != '') {
      targetURL = srcURL.split('id=')[0] + 'id=' + id + '&curPage=1&dept=' + dept + '&search=' + searchParams;
    } else {
      targetURL = srcURL.split('id=')[0] + 'id=' + id + '&curPage=1';
    }
    targetURL = srcURL.split('id=')[0] + 'id=' + id + '&curPage=1&dept=' + dept + '&search=' + searchParams;
    console.log(targetURL);
    // window.location.assign(targetURL);
  }
 });

 document.getElementById("searchBtn").addEventListener('click', function(e) {
   var searchParams = document.getElementById('searchInput').value;
   var srcURL = window.location.href;
   var url = new URL(srcURL);
   var id = url.searchParams.get("id").split('#')[0];
   var dept = url.searchParams.get("dept").split('#')[0];

   if (searchParams != '') {
     targetURL = srcURL.split('id=')[0] + 'id=' + id + '&curPage=1&dept=' + dept + '&search=' + searchParams;
   } else {
     targetURL = srcURL.split('id=')[0] + 'id=' + id + '&curPage=1';
   }
   targetURL = srcURL.split('id=')[0] + 'id=' + id + '&curPage=1&dept=' + dept + '&search=' + searchParams;
 })


var droppanel = document.getElementsByClassName('dropdown-menu')[0];
 $.ajax({
    url: "/FinalProject/api/queryDeptData.php",
    dataType: "json",
    async: false,
    success: function (data) {
        var len =  Object.keys(data).length;
        op = document.createElement("option");
        op.setAttribute("value", "ALL - 所有系所");
        op.innerHTML = "ALL - 所有系所";
        //console.log("ALL - 所有系所");
        document.getElementsByClassName("selection-2")[0].appendChild(op);
        for (var i = 104; i < len; i++) {
          op = document.createElement("option");
          op.setAttribute("value", data[i].abbv + " - " + data[i].dept);
          op.innerHTML = data[i].abbv + " - " + data[i].dept;
          //console.log(data[i].abbv + " - " + data[i].dept);
          document.getElementsByClassName("selection-2")[0].appendChild(op);
       }
    },
    error: function (jqXHR, textStatus, errorThrown) {
        alert(textStatus, +' | ' + errorThrown);
    }
})
