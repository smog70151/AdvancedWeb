var t;
var id;
$(document).ready(function () {
    var url = new URL(window.location.href);
    id = url.searchParams.get("id");

    $.ajax({
        url: "/FinalProject/api/getUserBooks.php?id=" + id,
        dataType: "json",
        async: false,
        success: function (data) {
            len = Object.keys(data).length
            if(len == 0){
                noselling = document.createElement("p");
                noselling.innerHTML = "No book is selling";
                nosold = document.createElement("p");
                nosold.innerHTML = "No book is sold";
                document.getElementsByClassName("selling container")[0].appendChild(noselling);
                document.getElementsByClassName("sold container")[0].appendChild(nosold);
            }

            for(var i=0; i< len; i++){
                abbv = data[i].dept.split("-")[0];
                $.ajax({
                    url: "/FinalProject/api/queryCourseData.php?abbv=" + abbv,
                    dataType: "json",
                    async: false,
                    success: function (data2) {
                        for(var j=0; j< Object.keys(data2).length; j++){
                            if(data[i].courseID === data2[j].id){
                                t = data2[j].teacher;
                                break;
                            }
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert(textStatus, +' | ' + errorThrown);
                    }
                });
                createBook(data[i]);
                //console.log(data[i].name);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert(textStatus, +' | ' + errorThrown);
        }
    });
});

function createBook(data){
    book = document.createElement("div");
    book.setAttribute("class", "book col-sm-6 col-md-3");
    thumbnail = document.createElement("div");
    thumbnail.setAttribute("class", "thumbnail");
    a = document.createElement("a");
    a.setAttribute("href", "/FinalProject/src/form/book.php?dept="+data.dept+"&b_id="+data.id+"&id="+id);
    book_img = document.createElement("div");
    book_img.setAttribute("class", "book_img");
    img = document.createElement("img");
    url = data.imgURL.split(".jpg")[0] + "b.jpg";
    img.setAttribute("src", url);
    book_info = document.createElement("div");
    book_info.setAttribute("class", "book_info caption");
    bookName = document.createElement("div");
    bookName.innerHTML = data.name;
    bookName.className = "name";
    tags_container = document.createElement("div");
    tags_container.setAttribute("class", "tags_container");
    course = document.createElement("div");
    course.setAttribute("class", "tag sub_tag");
    course.innerHTML = data.dept;
    teacher = document.createElement("div");
    teacher.setAttribute("class", "tag pro_tag");
    teacher.innerHTML = t;
    price = document.createElement("div");
    price.setAttribute("class", "price");
    p = document.createElement("p");
    p.innerHTML = "NT$ " + data.price;

    book.appendChild(thumbnail);
    thumbnail.appendChild(a);
    a.appendChild(book_img);
    a.appendChild(book_info);
    book_img.appendChild(img);
    book_info.appendChild(bookName);
    book_info.appendChild(tags_container);
    tags_container.appendChild(course);
    tags_container.appendChild(teacher);
    tags_container.appendChild(price);
    price.appendChild(p);
    if(data.status == 0){
        document.getElementsByClassName("selling container")[0].appendChild(book);
    }
    else{
        document.getElementsByClassName("sold container")[0].appendChild(book);
    }
}
