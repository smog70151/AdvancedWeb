var v;
var before_time;
$(document).ready(function() {
	url = new URL(location.href);
	v = url.searchParams.get("v");
	$.ajax({
		url: "https://www.googleapis.com/youtube/v3/videos?id=" + v + "&key=" + "AIzaSyCWynnE616F7Mu1YKao68SNhCaT5L5wCu0" + "&fields=items(snippet(title))&part=snippet",
		dataType: "json",
		async: false,
		success: function(data) {
			document.getElementById("bigTitle").innerHTML = data.items[0].snippet.title
		},
		error: function(jqXHR, textStatus, errorThrown) {
			alert(textStatus, +' | ' + errorThrown);
		}
	});

	// submit script by Enter key
	var input = document.getElementById("myTextarea");
	input.addEventListener("keyup", function(event) {
		event.preventDefault();
		if (event.keyCode === 13) {
			document.getElementById("submitBtn").click();
		}
	});

})
  
// add the script from the top line-box into the below line-box
function addLine(me){
	return function(me){
		var min = Math.floor(player.getCurrentTime()/60);
		var sec = Math.floor(player.getCurrentTime()%60);
		var x = document.getElementById("myTextarea").value;
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

		lineContainer.appendChild(lineBox);
		if (me.id === "submitBtn"){
			if(lines.length == 0){
				document.getElementsByClassName("line-editor")[0].appendChild(lineContainer);
				lineContainer.appendChild(timeLabel);
			} else {
				let add = false;
				for(var i = 0; i < lines.length; i++){
					var fetch_min = parseInt(lines[i].childNodes[1].childNodes[0].value.split(":")[0]), //start time min
						fetch_sec = parseInt(lines[i].childNodes[1].childNodes[0].value.split(":")[1]); // start time sec
					if(fetch_min == min){
						if(fetch_sec > sec) {
							lines[i].insertAdjacentElement("beforebegin", lineContainer);
							lineContainer.appendChild(timeLabel);
							break;
						} else {
							lines[i].insertAdjacentElement("afterend", lineContainer);
							lineContainer.appendChild(timeLabel);
						}
						add = true;
						//break;
					} else if (fetch_min > min) {
						lines[i].insertAdjacentElement("beforebegin", lineContainer);
						lineContainer.appendChild(timeLabel);
						add = true;
						break;
					}
				}
				if(!add) {
					document.getElementsByClassName("line-editor")[0].appendChild(lineContainer);
					lineContainer.appendChild(timeLabel);
				}
			}
		} else {
			me.parentNode.parentNode.insertAdjacentElement("afterend", lineContainer);
			lineContainer.appendChild(timeLabel);
		}

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

		if(me.id === "add"){
			a = me.parentNode.parentNode.children[1].children[1].value;
			s = a.split(":");
			min = parseInt(s[0]);
			sec = parseInt(s[1]);
			t = min * 60 + sec;
			player.seekTo(t, true);
			if(min < 10) min = "0" + min;
			if(sec < 10) sec = "0" + sec;
			startTime.setAttribute("value", min + ":" + sec);	
			endTime.setAttribute("value", min + ":" + sec);
			console.log(t);
		}
		else{
			console.log("no insert");
			if(min < 10) min = "0" + min;
			if(sec < 10) sec = "0" + sec;
			startTime.setAttribute("value", min + ":" + sec);
			min = Math.floor((player.getCurrentTime()+3)/60);
			sec = Math.floor((player.getCurrentTime()+3)%60);
			if(min < 10) min = "0" + min;
			if(sec < 10) sec = "0" + sec;
			endTime.setAttribute("value", min + ":" + sec);
		}
		lineBox.setAttribute("class", "line-box");
		name.setAttribute("name", "lyric[]");
		addLineBtn.setAttribute("class", "add-line");
		addLineBtn.setAttribute("id", "add");
		addLineBtn.setAttribute("onclick", "addLine_closure(this)");
		addLineBtn.setAttribute("type", "button");
		killLineBtn.setAttribute("class", "kill-line");
		killLineBtn.setAttribute("type", "button");
		plus.setAttribute("class", "fas fa-plus");
		minus.setAttribute("class", "fas fa-times");
		name.innerHTML = x;
		document.getElementById("myTextarea").value = "";
		onclick="addLine_closure()";
	}
}
var addLine_closure = addLine();

// 2. This code loads the IFrame Player API code asynchronously.
var tag = document.createElement('script');

tag.src = "https://www.youtube.com/iframe_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

// 3. This function creates an <iframe> (and YouTube player)
//    after the API code downloads.
var player;
function onYouTubeIframeAPIReady() {
	player = new YT.Player('player', {
		width: '550',
		videoId: v,
		events: {
			'onReady': onPlayerReady,
			'onStateChange': onPlayerStateChange
		},
		playerVars: {rel: 0}
	});
}

var init = false;
// 4. The API will call this function when the video player is ready.
function onPlayerReady(event) {
	//event.target.playVideo();
	init = true;
	player.mute();
	player.seekTo(0, false);
	// event.target.pauseVideo();
	setTimeout(function(){ event.target.pauseVideo(); }, 500);
}

// 5. The API calls this function when the player's state changes.
//    The function indicates that when playing a video (state=1),
//    the player should play for six seconds and then stop.
var done = false;
function onPlayerStateChange(event) {
	if ( init === true ) {
		player.unMute();
		init = false;
	}
	if (event.data == YT.PlayerState.PLAYING && !done) {
		//setTimeout(stopVideo, 6000);
		done = true;
	}
}
function stopVideo() {
	player.stopVideo();
}

$(document).click(function (event) {
	// click line-container -> seek the video to the click position
	if($(event.target.parentNode.parentNode).attr('class')=='line-container'){
		x = $(event.target.parentNode.parentNode.children[1].children[0]).attr('value');
		s = x.split(":");
		min = parseInt(s[0]);
		sec = parseInt(s[1]);
		t = min * 60 + sec;
		player.seekTo(t, true);
	}
	// click add-line -> add a new line-box
	/*else if($(event.target.parentNode).attr('class')=='add-line'){
	  x = $(event.target.parentNode.parentNode.parentNode.children[1].children[0]).attr('value');
	  s = x.split(":");
	  min = parseInt(s[0]);
	  sec = parseInt(s[1]);
	  t = min * 60 + sec;
	  player.seekTo(t, true);
	  before_time = t;
	}*/
	// kill line
	else if($(event.target.parentNode).attr('class')=='kill-line'){
	  $(event.target.parentNode.parentNode.parentNode).remove();
	}
	// back to video page
	else if($(event.target.parentNode.children[0]).attr('class')=='fas fa-reply'){
	  location.href = "/AdvancedWeb-AS4/api/youtubeDL.php?urlYT=https://www.youtube.com/watch?v=" + v;
	}
  });

