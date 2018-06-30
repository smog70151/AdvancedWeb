
window.fbAsyncInit = function () {
    FB.init({
        appId: '644740799199571',
        cookie: true,
        xfbml: true,
        version: 'v3.0'
    });

    FB.AppEvents.logPageView();
};

(function (d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {
        return;
    }
    js = d.createElement(s);
    js.id = id;
    js.src = 'https://connect.facebook.net/zh_TW/sdk.js#xfbml=1&version=v3.0&appId=644740799199571&autoLogAppEvents=1';;
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

function myFacebookLogout() {
    FB.getLoginStatus( function (response) {
        FB.logout(function(response) {
            window.localStorage.clear();
            window.sessionStorage.clear();
            window.location.assign('https://140.114.212.79/FinalProject/src/login.html');
         });
         alert('log out successfully');
    });
}


function myFacebookLogin() {
    FB.getLoginStatus(function (response) {
        //如果已經有授權過應用程式
        if (response.authResponse) {
            //呼叫FB.api()取得使用者資料

            FB.api('/me', {
                fields: 'id,name,email,picture'
            }, function (response) {
                //console.log(response);

                var urlIndex = 'https://140.114.212.79/FinalProject/src/booklist.php';

                $.ajax({ url: '../api/createUserData.php',
                    data: {id: response.id, name: response.name, pic_url: response.picture.data.url, email: response.email},
                    type: 'post',
                    async: false,
                    success: function(output) {
                        urlIndex = urlIndex + '?id=' + response.id;
                        //console.log('create user successfully');
                    }
                });
                window.location.assign(urlIndex);
                //這邊就可以判斷取得資料跟網站使用者資料是否一致
            });
            //沒授權過應用程式
        } else {
            //呼叫FB.login()請求使用者授權
            FB.login(function (response) {

                if (response.authResponse) {
                    FB.api('/me', {
                        fields: 'id,name,email,picture'
                    }, function (response) {
                      var urlIndex = 'https://140.114.212.79/FinalProject/src/booklist.php';

                      $.ajax({ url: '../api/createUserData.php',
                          data: {id: response.id, name: response.name, pic_url: response.picture.data.url, email: response.email},
                          type: 'post',
                          async: false,
                          success: function(output) {
                              urlIndex = urlIndex + '?id=' + response.id;
                              //console.log('create user successfully');
                          }
                      });
                      window.location.assign(urlIndex);
                        //這邊就可以判斷取得資料跟網站使用者資料是否一致
                    });
                }
                //FB.login()預設只會回傳基本的授權資料
                //如果想取得額外的授權資料需要另外設定在scope參數裡面
                //可以設定的授權資料可以參考官方文件
            }, {
                scope: 'email'
            });
        }
    });

}
