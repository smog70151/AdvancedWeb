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

	//document.getElementById("temp").innerHTML = 'Time : ' +  min + ':' + sec;
}

$(document).ready(function() {
	init();
	loadJSON();
	load();
	createSideBar('pcSideBar');
	createSideBar('appSideBar');
	superviseRWD();
})

// Init ...
var sideBarMenu;
var isAppSideBar = 'false';

function init() {
	sideBarMenu = document.getElementsByClassName('floatMenu')[0];
	sideBarMenu.addEventListener('click', displayAppSidebar);
	sideBarMenu.classList.add('hideSideBar');
}

function displayAppSidebar() {
	if (isAppSideBar === 'false') {
		isAppSideBar = 'true';
	} else {
		isAppSideBar = 'false';
	}
	RWD();
}

function superviseRWD() {
	var RWDCheck = setInterval(RWD, 1000);
}

function RWD() {
	// ADD or REMOVE PC / APP SideBar ...
	if (document.documentElement.clientWidth < 1200) {
		document.getElementById('pcSideBar').classList.add('hideSideBar');
		document.getElementById('pcSideBar').classList.remove('showSideBar');
    sideBarMenu.classList.add('showSideBar');
		sideBarMenu.classList.remove('hideSideBar');
	} else {
		document.getElementById('pcSideBar').classList.remove('hideSideBar');
		document.getElementById('pcSideBar').classList.add('showSideBar');
		document.getElementById('appSideBar').classList.remove('showSideBar');
		document.getElementById('appSideBar').classList.add('hideSideBar');
		sideBarMenu.classList.remove('showSideBar');
		sideBarMenu.classList.add('hideSideBar');
		isAppSideBar = 'false';
	}

	// sideBarMenu click
	if (isAppSideBar === 'true') {
		document.getElementById('appSideBar').classList.add('showSideBar');
		document.getElementById('appSideBar').classList.remove('hideSideBar');
	} else {
		document.getElementById('appSideBar').classList.remove('showSideBar');
		document.getElementById('appSideBar').classList.add('hideSideBar');
	}
}

var cnt = 0;
var idx_cnt = 0;

function load() {
	var videoList = JSON.parse(list);
	for (var video in videoList) {
		var id = videoList[cnt].id;
		$.ajax({
			url: "https://www.googleapis.com/youtube/v3/videos?id=" + id + "&key=" + "AIzaSyCWynnE616F7Mu1YKao68SNhCaT5L5wCu0" + "&fields=items(snippet(title,thumbnails))&part=snippet",
			dataType: "json",
			success: function(data) {
				handleData(data, idx_cnt, videoList[idx_cnt].id);
				idx_cnt++;
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert(textStatus, +' | ' + errorThrown);
			}
		});
		$.ajax({

			url: "https://www.googleapis.com/youtube/v3/videos?id=" + id + "&key=" + "AIzaSyCWynnE616F7Mu1YKao68SNhCaT5L5wCu0" + "&fields=items(contentDetails(duration))&part=contentDetails",

			dataType: "json",
			success: function(data) {
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert(textStatus, +' | ' + errorThrown);
			}
		})
		cnt++;
	}


}

function handleData(data, idx_cnt, id) {
	console.log('in handle data', data, idx_cnt, id);
	var title = data.items[0].snippet.title;
	var img_url = data.items[0].snippet.thumbnails.high.url;
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
	a.setAttribute("href", `video.html?vid=${id}`);
	a.className = cnt;

	img.setAttribute("src", img_url);
	img.setAttribute("style", "width:100%");
	pull_left.innerHTML = "<img src=\"http:\\simpleicon.com/wp-content/uploads/headphone-7.png\" height=\"16px\">5335"
	cap.appendChild(clearfix);
	clearfix.setAttribute("class", "clearfix");
	cap.appendChild(thum_tags);
	thum_tags.setAttribute("class", "thum-tags");
	thum_tags.innerHTML = "<button type=\"button\" class=\"btn btn-success btn-xs\">初級</button>"
	cap.appendChild(like);
	like.classList.add("like");
	like.innerHTML = "<div class=\"text\"><i class=\"fa fa-heart\"></i> 我喜歡</div>"
}

// $('[data-toggle="tooltip"]').tooltip();

var myPCSideBarFormat;
var mySideBarData;
var curSideBar;
var testFile;

function loadJSON() {
	myPCSideBarFormat = JSON.parse(PCSideBarFormat);
	mySideBarData = JSON.parse(dataSideBar);
}

function createSideBar(e) {
	// Create SideBar Element ...
	curSideBar = document.getElementById(e);
	var e1 = document.createElement('div');
	var e2 = document.createElement('div');
	var e3 = document.createElement('div');
	var e4 = document.createElement('div');
	var e5 = document.createElement('div');
	var aSideBar = document.createElement('a');
	var imgSideBar = document.createElement('img');
	var e6 = document.createElement('div');
	var e7 = document.createElement('div');
	var e8 = document.createElement('div');
	var e9 = document.createElement('div');

	// Hide the sidebar
	curSideBar.className = 'hideSideBar';

	// Get the SideBar Formats ...
	e1.className = myPCSideBarFormat[0].el1;
	e2.className = myPCSideBarFormat[0].el2;
	// thumbnail
	e3.className = myPCSideBarFormat[0].el3;
	e3.id = "sidebar";
	// sidebar-title
	e4.className = "sidebar-title";
	e4.innerHTML = "Sidebar Title";
	// sidebar-img
	e5.className = "sidebar-img";
	// aSideBar.setAttribute("href", mySideBarData[0].aSRC);
	imgSideBar.setAttribute("src", mySideBarData[0].imgSRC);
	// caption
	e6.className = "caption";
	e7.className = "clearfix";
	e8.className = "thumbnail-tags";
	e9.className = "clearfix";

	// append
	curSideBar.appendChild(e1);
	e1.appendChild(e2);
	e2.appendChild(e3);
	e3.appendChild(e4);
	e3.appendChild(e5);
	e5.appendChild(aSideBar);
	aSideBar.appendChild(imgSideBar);
	e3.appendChild(e6);
	e6.appendChild(e7);
	e6.appendChild(e8);
	e6.appendChild(e9);
}
