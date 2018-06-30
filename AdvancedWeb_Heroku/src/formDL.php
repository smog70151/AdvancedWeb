<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title> Youtube DL </title>

    <!-- BS 4 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="./styles/formDL.css">

    <!-- GOOGLE FONT -->
    <link href="https://fonts.googleapis.com/css?family=Gothic+A1" rel="stylesheet">
    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  </head>
  <body>
    <div class="container header">
      <br>
      <br>
      <p class="formText title"> Voicetube ADDER </p>
      <pre class="formText"> ADD voicetube yourself </pre>
      <br>
        <div class="row">
          <div class="col">
            <img id="headerIMG" src="https://i1.wp.com/kayolhope.com/wp-content/uploads/2018/02/elliot-teo-379059-unsplash.jpg?resize=1024%2C683">
          </div>
        </div>
      <br>
      <br>
        <div class="row">
          <div class="col-12 formText">
            <form name="formYT"action="../api/youtubeDL.php" method="get">
              <label for="urlYT"> Youtube Video Link </label>

              <input id="inputURL" type="text" name="urlYT" value="" placeholder="Please Enter Youtube URL" required>
              <button id='button' class="btn btn-outline-danger" type="button" onClick="check()" name="button"> ADD </button>
            </form>
          </div>
        </div>
        <br>
        <br>
    </div>
    <script>

        var downloadButton = document.getElementById("button");
        var baseURL = 'https://www.youtube.com';
        // downloadButton.addEventListener("click", function(){
        //   if (downloadButton.value.indexOf(baseURL) != -1) {
        //     downloadButton.innerHTML = '<i class="fa fa-spinner fa-spin" style="font-size:18px"></i>&nbsp; 正在取得外部資源';
        //   } else {
        //     alert(" Wrong Input Link !");
        //   }
        // });

        function check() {
          if (formYT.urlYT.value.indexOf(baseURL) != -1) {
            downloadButton.innerHTML = '<i class="fa fa-spinner fa-spin" style="font-size:18px"></i>&nbsp; 正在取得外部資源';
            formYT.submit();
          } else {
            alert(" Wrong Input Link !");
          }
        }

    </script>
  </body>
</html>
