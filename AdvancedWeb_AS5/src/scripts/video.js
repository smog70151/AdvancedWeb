var player;
var tag = document.createElement('script');
var firstScriptTag = document.getElementsByTagName('script')[0];
var curTime;
var prev = 0;
var scroll_height = [];
var done = false;
var url,
	vid,
	v;


$(document).ready(function() {
	loadlist();
	url = new URL(location.href);
	vid = url.searchParams.get("urlYT");
	vid = new URL(vid);
	v = vid.searchParams.get("v");
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
	$('.col-md-5 .caption').click(function(event) {
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
