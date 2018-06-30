$('select').change(function () {
  if ($(this).val() === "上傳字幕檔") {
    document.forms.alterForm.action = "../api/uploadSrt.php";
		document.forms.alterForm.enctype = "multipart/form-data";
  }

	if ($(this).val() === "編輯字幕") {
    document.forms.alterForm.action = "../api/updateLyrics_v2.php";
		document.forms.alterForm.enctype = "";
  }
});
