var player;
var tag = document.createElement('script');
var firstScriptTag = document.getElementsByTagName('script')[0];
var curTime;
var prev = 0;
var scroll_height = [];
var done = false;
var pID = [];
var url,
	vid,
	v;


$(document).ready(function () {
	loadlist();
	url = new URL(location.href);
	vid = url.searchParams.get("urlYT");
	vid = new URL(vid);
	v = vid.searchParams.get("v");
	$.ajax({
		url: "https://www.googleapis.com/youtube/v3/videos?id=" + v + "&key=" + "AIzaSyCWynnE616F7Mu1YKao68SNhCaT5L5wCu0" + "&fields=items(snippet(title))&part=snippet",
		dataType: "json",
		async: false,
		success: function (data) {
			document.getElementById("bigTitle").innerHTML = data.items[0].snippet.title
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert("Fail to get title");
		}
	});

	$.ajax({
		url: "/AdvancedWeb-Heroku/api/getPID.php",
		dataType: "json",
		async: false,
		success: function (data) {
			for (var i = 0; i < 10; i = i + 1) {
				pID[i] = data[i].pID;
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert("Fail to getPID");
		}
	})
	loadPlaylistVideo();

	$.ajax({
		url: "/AdvancedWeb-Heroku/api/lyricJSON.php?v=" + v,
		dataType: "json",
		async: false,
		success: function (data) {
			var tbl = document.createElement('table');
			var tbdy = document.createElement('tbody');

			for (var cap in data) {
				var tr = document.createElement('tr');
				tbdy.appendChild(tr)
				for (var i = 0; i < 2; i++) {
					var td = document.createElement('td');
					tr.appendChild(td);
					if (i == 0) {
						var ico = document.createElement('i');
						td.appendChild(ico);
						ico.setAttribute('class', 'fa fa-play-circle')
					} else {
						var p = document.createElement('p');
						td.appendChild(p);
						p.setAttribute('t', data[cap].start);
						p.setAttribute('d', data[cap].dur);
						p.innerHTML = data[cap].lyric;
					}
				}
			}
			tbl.appendChild(tbdy);
			document.getElementsByClassName("caption")[0].appendChild(tbl);
			$('.col-md-5 p').click(function (event) {
				player.loadVideoById({
					videoId: v,
					startSeconds: event.target.attributes[0].value / 1000,
					endSeconds: (parseFloat(event.target.attributes[0].value) + parseFloat(event.target.attributes[1].value)) / 1000
				});
			})

			init()
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert("This video has no lyrics");
		}
	});
	$('.col-md-5 .caption').click(function (event) {
		player.loadVideoById({
			videoId: v,
			startSeconds: event.target.attributes[0].value,
			endSeconds: (parseFloat(event.target.attributes[0].value) + parseFloat(event.target.attributes[1].value))
		});
	});
})

tag.src = "https://www.youtube.com/iframe_api";

firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

function onYouTubeIframeAPIReady() {
	player = new YT.Player('player', {
		width: '100%',
		videoId: v,
		events: {
			'onReady': onPlayerReady,
			'onStateChange': onPlayerStateChange
		}
	});

}

function startInterval() {
	checkInt = setInterval(function () {
		curTime = Math.floor(player.getCurrentTime() * 1000);
		for (var i = 0; i + 1 < $('tr p').length; i++) {
			if (curTime < $('tr p')[i + 1].attributes[0].value && curTime >= $('tr p')[i].attributes[0].value) {
				$('.caption').scrollTop(scroll_height[i]);
				//console.log(i,scroll_height[i])
				$('tr p')[prev].style.background = 'rgba(255, 255, 255, 0)';
				$('tr p')[i].style.background = 'rgba(30, 30, 30, 0.3)';
				$('tr i')[i].style.color = "green";
				prev = i;
			}
		}
	}, 0.001)

	var Reset = setInterval(init, 200000);
}

function onPlayerReady(event) {

	startInterval()
}

function init() {
	scroll_height[0] = 0;
	scroll_height[1] = 0;
	scroll_height[2] = 0;
	for (var k = 3; k < $('tr p').length; k++) {
		scroll_height[k] = $('tr p')[k - 3].clientHeight + scroll_height[k - 1] + 10;
	}
}

function onPlayerStateChange(event) {}

function stopVideo() {
	player.stopVideo();
}

function loadlist() {
	$.ajax({
		url: "/AdvancedWeb-Heroku/api/getAllList.php",
		dataType: "json",
		success: function (data) {
			for (var i = data.length - 10; i < Object.keys(data).length; i++) {
				addList(data[i].playlistID, i);
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert("Fail to getAllList");
		}
	})
}

var i = 0;

// function addList(playlistID, idx) {
// 	//console.log("id: " + playlistID);
// 	//console.log("idx: " + idx);
// 	$.ajax({
// 		url: "/AdvancedWeb-Heroku/api/playlistsJSON.php?playlistID=" + playlistID + '&pID=' + (idx+1),
// 		dataType: "json",
// 		async: false,
// 		success: function (data) {
// 			document.getElementsByClassName('list')[i].innerHTML = data[0].playlistTitle;
// 			document.getElementsByClassName('list')[i++].setAttribute('href', '/AdvancedWeb-Heroku/api/youtubeDL.php?urlYT=http://www.youtube.com/playlist?list=' + playlistID);
// 		},
// 		error: function (jqXHR, textStatus, errorThrown) {
// 			//alert("Fail to addList");
// 		}
// 	})
// }

function loadPlaylistVideo() {
	url = new URL(location.href);
	video_url = url.searchParams.get("urlYT");
	video_url = new URL(video_url);
	playlistID = video_url.searchParams.get("list");
	//console.log(video_url);
	console.log(playlistID);
	console.log(pID[0]);
	if(playlistID != null){
		$.ajax({
			url: "/AdvancedWeb-Heroku/api/playlistsJSON.php?playlistID=" + playlistID + "&pID=" + parseInt(pID[0]),
			dataType: "json",
			success: function (data) {
				//console.log("success");
				for (var i = 1; i < Object.keys(data).length; i++) {
					//console.log(data[i].videoTitle);
					createList(data[i]);
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				//alert("Fail to load videolist");
			}
		})
	}
}

function createList(data) {
	a = document.createElement("a");
	img = document.createElement("img");
	title = document.createElement("div");
	a.setAttribute("href", "/AdvancedWeb-Heroku/api/youtubeDL.php?urlYT=https://www.youtube.com/watch?v=" + data.videoID + "%26list=" + playlistID);
	img.setAttribute("src", "https://img.youtube.com/vi/" + data.videoID + "/hqdefault.jpg");
	title.innerHTML = data.videoTitle;
	a.appendChild(img);
	a.appendChild(title);
	document.getElementsByClassName("scrollmenu")[0].appendChild(a);
}