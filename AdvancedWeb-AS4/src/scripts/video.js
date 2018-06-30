var player;
var tag = document.createElement('script');
var firstScriptTag = document.getElementsByTagName('script')[0];
var curTime;
var prev = 0;
var scroll_height = [];
var done = false;
var url,
	vid,
	v,
	pID = [],
	playlistID;


$(document).ready(function() {

	url = new URL(location.href);
	if(url.searchParams.get("urlYT") !== null){
		v = url.searchParams.get("urlYT");
		console.log("ya");
	} else {
		v = url.searchParams.get("v");
	}
	// get video
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

	// get playlistid
	$.ajax({
		url: "/AdvancedWeb-AS4/api/queryPid.php?vid=" + v,
		dataType: "json",
		async: false,
		success: function(data) {
			playlistID = data[0].playlist_id;
		},
		error: function(jqXHR, textStatus, errorThrown) {
			//alert(textStatus, +' | ' + errorThrown);
		}
	});
	
	// get pID
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

	// get lyric
	$.ajax({
		url: "/AdvancedWeb-AS4/api/lyricJSON.php?v=" + v,
		dataType: "json",
		async: false,
		success: function(data) {
			if(data){
	        var tbl = document.createElement('table');
	        var tbdy = document.createElement('tbody');

	        for (var cap in data) {
	            var tr = document.createElement('tr');
	            tbdy.appendChild(tr);
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
			$('.col-md-5 p').click(function(event) {
				player.loadVideoById({
					videoId: v,
					startSeconds: event.target.attributes[0].value / 1000,
					endSeconds: (parseFloat(event.target.attributes[0].value) + parseFloat(event.target.attributes[1].value)) / 1000
				});
			})

			init()
			}
		},
		error: function(jqXHR, textStatus, errorThrown) {
			alert("This video has no lyrics");

		}
	});

	$('.col-md-5 .caption').click(function(event) {
		player.loadVideoById({
			videoId: v,
			startSeconds: event.target.attributes[0].value,
			endSeconds: (parseFloat(event.target.attributes[0].value) + parseFloat(event.target.attributes[1].value))
		});
	});

	//console.log(playlistID);
	if(playlistID !== undefined){
		loadPlaylistVideo();
	}
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
	checkInt = setInterval(function() {
		curTime = Math.floor(player.getCurrentTime());
		for (var i = 0; i + 1 < $('tr p').length; i++) {
			if (curTime < parseFloat($('tr p')[i + 1].attributes[0].value) && curTime >= parseFloat($('tr p')[i].attributes[0].value)) {
				$('.caption').scrollTop(scroll_height[i]);
				$('tr p')[prev].style.background = 'rgba(255, 255, 255, 0)';
				$('tr p')[i].style.background = 'rgba(30, 30, 30, 0.3)';
				$('tr i')[i].style.color = "green";
				prev = i;
			}
		}
	}, 0.0001)

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

function loadPlaylistVideo() {

	$.ajax({
		url: "/AdvancedWeb-AS4/api/playlistsJSON.php?playlistID=" + playlistID + "&pID=" + parseInt(pID[0]),
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

function createList(data) {
	a = document.createElement("a");
	img = document.createElement("img");
	title = document.createElement("div");
	a.setAttribute("href", "/AdvancedWeb-AS4/src/video.php?v=" + data.videoID);
	img.setAttribute("src", "https://img.youtube.com/vi/" + data.videoID + "/hqdefault.jpg");
	title.innerHTML = data.videoTitle;
	a.appendChild(img);
	a.appendChild(title);
	document.getElementsByClassName("scrollmenu")[0].appendChild(a);
}
