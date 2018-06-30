/* Youtube */
var tag = document.createElement('script');

tag.src = "https://www.youtube.com/iframe_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

var player;

function onYouTubeIframeAPIReady() {
	player = new YT.Player('player', {
		height: '390',
		width: '640',
		videoId: 'M7lc1UVf-VE',
		events: {
			'onReady': onPlayerReady,
			'onStateChange': onPlayerStateChange
		}
	});
}

// 4. The API will call this function when the video player is ready.
function onPlayerReady(event) {
	// event.target.playVideo();
	getTime();
}

// 5. The API calls this function when the player's state changes.
//    The function indicates that when playing a video (state=1),
//    the player should play for six seconds and then stop.
var done = false;

function onPlayerStateChange(event) {
	if (event.data == YT.PlayerState.PLAYING && !done) {
		setTimeout(stopVideo, 6000);
		done = true;
	}
}

function stopVideo() {
	player.stopVideo();
}

function getTime() {
	var min = Math.floor(player.getDuration() / 60);
	var sec = player.getDuration() % 60 - 1;
	//padLeft
	if (min < 10) {
		min = '0' + min;
	}
}

var pID = [];

$(document).ready(function() {
	$.ajax({
		 url: "/AdvancedWeb-AS4/api/getPID.php",
		 dataType: "json",
		 async:false, 
		 success: function(data) {
			
			for (var i = 0; i < 10; i=i+1) {
				pID[i] = data[i].pID;
			} 
		 },
		 error: function(jqXHR, textStatus, errorThrown) {
			 alert(textStatus, +' | ' + errorThrown);
		 }
	})
	loadlist();
	load();
})

var cnt = 0;
var idx_cnt = 0;
var url, video_url, playlistID;
function load() {
	url = new URL(location.href);
	video_url = url.searchParams.get("urlYT");
	video_url = new URL(video_url);
	playlistID = video_url.searchParams.get("list");
	
	$.ajax ({
		url: "/AdvancedWeb-AS4/api/playlistsJSON.php?playlistID=" + playlistID + "&pID=" + parseInt(pID[0]),
		dataType: "json",
		success: function(data) {
		
			document.getElementById('playlistTitle').innerHTML = data[0].playlistTitle;
			for(var i=1; i<data.length; i++){
				handleData(data, i);
			}
		},
		error: function(jqXHR, textStatus, errorThrown) {
			alert(textStatus, +' | ' + errorThrown);
		}
	})
}

function handleData(data, id) {

	var title = data[id].videoTitle;
	var img_url = "https://img.youtube.com/vi/" + data[id].videoID + "/maxresdefault.jpg";
	var div = document.createElement("div");
	var thum = document.createElement("div");
	var cap = document.createElement("div");
	var pull_left = document.createElement("div");
	var clearfix = document.createElement("div");
	var thum_tags = document.createElement("div");
	var like = document.createElement("div");
	var a = document.createElement("a");
	var tooltip = document.createElement("a");
	var img = document.createElement("img");
	var time = document.createElement("p");

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
	tooltip.innerHTML = title;
	cap.appendChild(pull_left);
	pull_left.setAttribute("class", "pull-left");
	a.appendChild(img);
	a.setAttribute("href", `/AdvancedWeb-AS4/api/youtubeDL.php?urlYT=https://www.youtube.com/watch?v=`+ data[id].videoID);
	a.className = cnt;

	img.setAttribute("src", img_url);
	img.setAttribute("style", "width:100%");
	pull_left.innerHTML = "<img src=\"http://simpleicon.com/wp-content/uploads/headphone-7.png\" height=\"16px\">5330"
	cap.appendChild(clearfix);
	clearfix.setAttribute("class", "clearfix");
	cap.appendChild(thum_tags);
	thum_tags.setAttribute("class", "thum-tags");
	thum_tags.innerHTML = "<button type=\"button\" class=\"btn btn-success btn-xs\">初級</button>"
	cap.appendChild(like);
	like.classList.add("like");
	like.innerHTML = "<div class=\"text\"><i class=\"fa fa-heart\"></i> 我喜歡</div>"
}

function loadlist() {
	$.ajax ({
		url: "/AdvancedWeb-AS4/api/getAllList.php",
		dataType: "json",
		success: function(data) {
			for(var i=data.length-10; i<data.length; i++){
				addList(data[i].playlistID, i);
			}
		},
		error: function(jqXHR, textStatus, errorThrown) {
			alert(textStatus, +' | ' + errorThrown);
		}
	})
}
var i = 0;
function addList(playlistID, idx){
	

	$.ajax ({
		url: "/AdvancedWeb-AS4/api/playlistsJSON.php?playlistID=" + playlistID + '&pID=' + (idx+1),
		dataType: "json",
		async: false,
		success: function(data) {
			document.getElementsByClassName('list')[i].innerHTML = data[0].playlistTitle;
			document.getElementsByClassName('list')[i++].setAttribute('href','/AdvancedWeb-AS4/api/youtubeDL.php?urlYT=http://www.youtube.com/playlist?list=' + playlistID);
		},
		error: function(jqXHR, textStatus, errorThrown) {
			alert(textStatus, +' | ' + errorThrown);
		}
	})
}	



