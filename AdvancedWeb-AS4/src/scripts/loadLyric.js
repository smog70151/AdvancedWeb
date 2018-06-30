$(document).ready(function() {
	url = new URL(location.href);
	v = url.searchParams.get("v");
	//console.log(v);
	$.ajax({
			url: "/AdvancedWeb-AS4/api/getLyricJSON.php?vID=" + v,
			dataType: "json",
			async: false,
			success: function(data) {
				var len =  Object.keys(data).length;
				for(var i=0; i<len ; i++){
					loadLyric(data[i]);
					//console.log(data[i]);
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				//alert(textStatus, +' | ' + errorThrown);
			}
		});
})

function loadLyric(data)
{
	var lines = document.getElementsByClassName("line-container");
	var line_container = document.getElementsByClassName("line-container");
	var lineContainer = document.createElement("div");
	var timeLabel = document.createElement("div");
	var lineBox = document.createElement("div");
	var startTime = document.createElement("input");
	var endTime = document.createElement("input");
	var name = document.createElement("textarea");
	var killLineBtn = document.createElement("button");
	var addLineBtn = document.createElement("button");
	var plus = document.createElement("i");
	var minus = document.createElement("i");

	document.getElementsByClassName("line-editor")[0].appendChild(lineContainer);
	lineContainer.appendChild(lineBox);
	lineContainer.appendChild(timeLabel);
	timeLabel.appendChild(startTime);
	timeLabel.appendChild(endTime);
	lineBox.appendChild(name);
	lineBox.appendChild(addLineBtn);
	lineBox.appendChild(killLineBtn);
	addLineBtn.appendChild(plus);
	killLineBtn.appendChild(minus);

	lineContainer.setAttribute("class", "line-container");
	timeLabel.setAttribute("class", "time-label");
	startTime.setAttribute("class", "time");
	startTime.setAttribute("name", "start_time[]");
	endTime.setAttribute("class", "time");
	endTime.setAttribute("name", "end_time[]");
	startTime.setAttribute("type", "text");
	endTime.setAttribute("type", "text");

	var min = Math.floor(data.start/60);
	var sec = Math.floor(data.start%60);
	if(min < 10) min = "0" + min;
	if(sec < 10) sec = "0" + sec;
	startTime.setAttribute("value", min + ":" + sec);
	min = Math.floor((parseInt(data.start) + parseInt(data.dur))/60);
	sec = Math.floor((parseInt(data.start) + parseInt(data.dur))%60);
	if(min < 10) min = "0" + min;
	if(sec < 10) sec = "0" + sec;

	endTime.setAttribute("value", min + ":" + sec);

	lineBox.setAttribute("class", "line-box");
	name.setAttribute("name", "lyric[]");
	addLineBtn.setAttribute("id", "add");
	addLineBtn.setAttribute("class", "add-line");
	addLineBtn.setAttribute("onclick", "addLine_closure(this)");
	addLineBtn.setAttribute("type", "button");
	killLineBtn.setAttribute("class", "kill-line");
	killLineBtn.setAttribute("type", "button");
	plus.setAttribute("class", "fas fa-plus");
	minus.setAttribute("class", "fas fa-times");
	name.innerHTML = data.lyric;
	document.getElementById("myTextarea").value = "";
	onclick="addLine_closure()";
}

// $(document).click(function (event) {
// 	// click line-container -> seek the video to the click position
// 	//console.log("click");
// 	if($(event.target.parentNode.parentNode).attr('class')=='line-container'){
// 		x = $(event.target.parentNode.parentNode.children[1].children[0]).attr('value');
// 		s = x.split(":");
// 		min = parseInt(s[0]);
// 		sec = parseInt(s[1]);
// 		t = min * 60 + sec;
// 		player.seekTo(t, false);
// 	  }
//   });
