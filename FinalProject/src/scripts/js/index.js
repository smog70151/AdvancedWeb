var chat_btn = document.getElementById('chatroom');
var downNarrowBtn = document.querySelector('.j-logout');

// Init
window.onload = function() {
	//console.log('Index js onload');
	// document.getElementById('chatroom').style.display = "inline";
	// document.querySelector('.dashboard').style.display = "none";
}

chat_btn.addEventListener('click', function() {

		//console.log("Open Dashboard");
		document.getElementById('chatroom').innerHTML = "<i class=\"fa fa-refresh fa-spin\" style=\"font-size:1rem\"></i> Loading "
		document.querySelector('.dashboard').style.display = "flex";

});

// downNarrowBtn.addEventListener('click', function() {
//
// 		console.log("Close Dashboard !");
// 		document.getElementById('chatroom').style.display = "inline";
// 		document.querySelector('.dashboard').style.display = "none";
//
//
// });
