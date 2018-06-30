var player;
var tag = document.createElement('script');
var firstScriptTag = document.getElementsByTagName('script')[0];
var curTime;
var prev = 0;
var scroll_height = [];
var done = false;
var a;
var vid;




$(document).ready(function() {

	var a = location.search.split("=");
	vid = a[1];

	$.ajax({
		url: "https://www.googleapis.com/youtube/v3/videos?id=" + vid + "&key=" + "AIzaSyCWynnE616F7Mu1YKao68SNhCaT5L5wCu0" + "&fields=items(snippet(title))&part=snippet",
		dataType: "json",
		success: function(data) {
			document.getElementById("bigTitle").innerHTML = data.items[0].snippet.title
		},
		error: function(jqXHR, textStatus, errorThrown) {
			alert(textStatus, +' | ' + errorThrown);
		}
	});

	var vs = JSON.parse(video_sub);
	var numLyrics;

	for (var t = 0; t < vs.length; t++) {
		if (vs[t].id == vid) {
			numLyrics = vs[t].sub;
		}
	}

	// Dynamic load JSON
	var lyricScript = document.getElementById('videoLyrics');
	lyricScript.src = './datas/lyrics/lyrics' + numLyrics +'.json';

	var mydata;

	window.onload = function () {
		mydata = JSON.parse(lyrics);
		//console.log(mydata);

		var tbl = document.createElement('table');
		var tbdy = document.createElement('tbody');

		for (var cap in mydata) {
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
					p.setAttribute('t', mydata[cap].start_time);
					p.setAttribute('d', mydata[cap].d);
					p.innerHTML = mydata[cap].text;
				}
			}
		}
		tbl.appendChild(tbdy);
		document.getElementsByClassName("caption")[0].appendChild(tbl);
		$('.col-md-5 p').click(function(event) {
			player.loadVideoById({
				videoId: vid,
				startSeconds: event.target.attributes[0].value / 1000,
				endSeconds: (parseFloat(event.target.attributes[0].value) + parseFloat(event.target.attributes[1].value)) / 1000
			});
		})
		console.log('create element done');
		init()

	}
	
})

tag.src = "https://www.youtube.com/iframe_api";

firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

function onYouTubeIframeAPIReady() {
	//console.log('youtube ready', vid)
	player = new YT.Player('player', {
		width: '100%',
		videoId: vid,
		events: {
			'onReady': onPlayerReady,
			'onStateChange': onPlayerStateChange
		}
	});

}

function startInterval() {
	checkInt = setInterval(function() {
		curTime = Math.floor(player.getCurrentTime() * 1000);
		for (var i = 0; i + 1 < $('tr p').length; i++) {
			if (curTime < $('tr p')[i + 1].attributes[0].value && curTime >= $('tr p')[i].attributes[0].value) {
				$('.caption').scrollTop(scroll_height[i]);
				console.log(i,scroll_height[i])
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
	//console.log('in init');
	scroll_height[0] = 0;
	scroll_height[1] = 0;
	scroll_height[2] = 0;
	//console.log($('tr p'))
	for (var k = 3; k < $('tr p').length; k++) {
		scroll_height[k] = $('tr p')[k - 3].clientHeight + scroll_height[k - 1] + 10;
		//console.log(k,scroll_height[k])
	}
}

function onPlayerStateChange(event) {}

function stopVideo() {
	player.stopVideo();
}
