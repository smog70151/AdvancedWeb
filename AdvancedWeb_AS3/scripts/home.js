function load(){
    var videoList = JSON.parse(list);
    for(var video in videoList){
        var div = document.createElement("div");
        var thum = document.createElement("div");
        var cap = document.createElement("div");
        var pull_left = document.createElement("div");
        var clearfix = document.createElement("div");
        var thum_tags = document.createElement("div");
        var like = document.createElement("div");
        var a = document.createElement("a");
        var tooltip = document.createElement("a");
        document.getElementsByClassName("video-list")[0].appendChild(div);
        div.setAttribute("class", "col-md-3 col-sm-6");
        div.appendChild(thum);
        thum.setAttribute("class", "thumbnail");
        thum.appendChild(a);
        thum.appendChild(cap);
        cap.setAttribute("class", "caption");
        cap.appendChild(tooltip);
        tooltip.setAttribute("data-toggle", "tooltip");
        tooltip.setAttribute("title", "Bebe Rexha - Meant to Be (feat. Florida Georgia Line) [Official Music Video]");
        tooltip.innerHTML = "Bebe Rexha - Meant to Be (feat. Florida Georgia Line) [Official Music Video]";
        cap.appendChild(pull_left);
        pull_left.setAttribute("class", "pull-left");
        pull_left.innerHTML = "<img src=\"http:\\simpleicon.com/wp-content/uploads/headphone-7.png\" height=\"16px\">5335"
        cap.appendChild(clearfix);
        clearfix.setAttribute("calss", "clearfix");
        cap.appendChild(thum_tags);
        thum_tags.setAttribute("calss", "thum-tags");
        thum_tags.innerHTML = "<button type=\"button\" class=\"btn btn-success btn-xs\">初級</button>"
        cap.appendChild(like);
        like.setAttribute("calss", "like");
        like.innerHTML = "<div class=\"text\"><i class=\"fa fa-heart\"></i> 我喜歡</div>"
    }

}
