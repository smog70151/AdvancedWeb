<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/AdvancedWeb-AS4/src/styles/addText.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.12/css/all.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title>addText</title>
</head>

<body>
    <div class="container editor-container">
        <form id="alterForm" action="../api/updateLyrics_v2.php" method="post">
            <div class="col-md-12 btn-bar">
                <h3 class="pull-left" id="bigTitle">Video title</h3>
                <button type="submit" class="btn btn-dark pull-right">
                    <i class="far fa-save"></i>
                </button>
                <button type="button" class="btn btn-dark pull-right">
                    <i class="fas fa-reply"></i>
                </button>
            </div>
            <div class="col-md-12 timetext">
                <div class="col-md-12">
                    <select class="" name="" onchange="change(this)">
                        <option value="編輯字幕">編輯字幕</option>
                        <option value="上傳字幕檔">上傳字幕檔</option>
                    </select>
                </div>
                <form action="../api/uploadSrt.php" method="post">
                    <div class="upload col-md-12">
                        <input type="hidden" name="id" value="<?php echo $_GET['v'] ?>" >
                        <input id="uploadFile" type="file" name="upload-file" value="上傳檔案">
                        <input id="upload" type="submit" value="上傳檔案" />
                    </div>
                </form>
                <!-- <form method="post" action="upload.php" enctype="multipart/form-data">
                    選擇檔案：<input id="file" name="file" type="file" />
                    <br />
                    <input type="submit" value="上傳檔案" />
                </form> -->
                <div class="col-md-5 caption-area">
                    <div class="new-line-box">
                        <textarea autofocus name="name" id="myTextarea" placeholder="請在這裡輸入字幕，然後按Enter鍵"></textarea>
                        <button type="button" id="submitBtn" name="button" onclick="addLine_closure(this)">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>

                    <div class="line-editor">
                    </div>
                </div>

                <div class="col-md-7">
                    <div id="player"></div>
                </div>
            </div>
        </form>
    </div>
    <!-- <script type="text/javascript" src="/AdvancedWeb-AS4/src/scripts/addLyric.js"></script> -->
    <script type="text/javascript" src="/AdvancedWeb-AS4/src/scripts/addText.js"></script>
    <script type="text/javascript" src="/AdvancedWeb-AS4/src/scripts/loadLyric.js"></script>
    <script type="text/javascript" src="/AdvancedWeb-AS4/src/scripts/updateSRT.js"></script>
</body>

</html>
