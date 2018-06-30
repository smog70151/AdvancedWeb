'use strict';
var isLogin = false;
function Login() {
    this.isLoginPageRendered = false;
    this.isLogin = false;
}

Login.prototype.init = function(){
    var self = this;

    return new Promise(function(resolve, reject) {
        var user = localStorage.getItem('user');
        if(user && !app.user){
            var savedUser = JSON.parse(user);
            app.room = savedUser.tag_list;
            self.login(savedUser)
                .then(function(){
                    resolve(true);
                }).catch(function(error){
                reject(error);
            });
        } else {
            resolve(false);
        }
    });
};

Login.prototype.login = function (user) {
    var self = this;
    return new Promise(function(resolve, reject) {
        if(self.isLoginPageRendered){
            //document.forms.loginForm.login_submit.innerText = 'loading...';
        } else {
            self.renderLoadingPage();
        }
        var params = {tags: ["BooksNTHU"]};
    
        QB.users.get(params, function(err, result) {
            if (result) {
                console.log("PROTOTYPE: ",result);
                app.userData = result;
                console.log("APP USERDATA: ",app.userData);
                //return result;
            }
        });    
        QB.createSession(function(csErr, csRes) {
            var userRequiredParams = {
                'login':user.login,
                'password': user.password
            };
            console.log(userRequiredParams.login, userRequiredParams.password);
            if (csErr) {
                loginError(csErr);
            } else {
                app.token = csRes.token;
                QB.users.get(user.facebook_id, function(err, result) {
                  if (result) {
                    console.log(result);
                  }
                });
                QB.login(userRequiredParams, function(loginErr, loginUser){
                    if(loginErr) {
                        /** Login failed, trying to create account */
                        QB.users.create(user, function (createErr, createUser) {
                            if (createErr) {
                                loginError(createErr);
                            } else {
                                QB.login(userRequiredParams, function (reloginErr, reloginUser) {
                                    if (reloginErr) {
                                        loginError(reloginErr);
                                    } else {
                                        loginSuccess(reloginUser);
                                    }
                                });
                            }
                        });
                    } else {
                        /** Update info */
                        if(loginUser.user_tags !== user.tag_list || loginUser.full_name !== user.full_name) {
                            QB.users.update(loginUser.id, {
                                'full_name': user.full_name,
                                'tag_list': user.tag_list
                            }, function(updateError, updateUser) {
                                if(updateError) {
                                    loginError(updateError);
                                } else {
                                    loginSuccess(updateUser);
                                }
                            });
                        } else {
                            loginSuccess(loginUser);
                        }
                    }
                });
            }
        });

        function loginSuccess(userData){
            app.user = userModule.addToCache(userData);
            app.user.user_tags = userData.user_tags;
            QB.chat.connect({userId: app.user.id, password: user.password}, function(err, roster){
                if (err) {
                    document.querySelector('.j-login__button').innerText = 'Login';
                    console.error(err);
                    reject(err);
                } else {
                    self.isLogin = true;
                    resolve();
                }
            });
        }

        function loginError(error){
            self.renderLoginPage();
            console.error(error);
            alert(error + "\n" + error.detail);
            reject(error);
        }
    });

};

Login.prototype.renderLoginPage = function(){
    helpers.clearView(app.page);

    app.page.innerHTML = helpers.fillTemplate('tpl_login', {
        version: QB.version + ':' + QB.buildNumber
    });
    this.isLoginPageRendered = true;
    this.setListeners();
};

Login.prototype.renderLoadingPage = function(){
    helpers.clearView(app.page);
    app.page.innerHTML = helpers.fillTemplate('tpl_loading');
};

Login.prototype.setListeners = function(){
    var self = this;
        // loginForm = document.forms.loginForm,
        // formInputs = [loginForm.userName, loginForm.userGroup],
        // loginBtn = loginForm.login_submit;

    //loginForm.addEventListener('submit', function(e){
        // e.preventDefault();

        // if(loginForm.hasAttribute('disabled')){
        //     return false;
        // } else {
        //     loginForm.setAttribute('disabled', true);
        // }

        // var userName = loginForm.userName.value.trim(),
        //     userGroup = loginForm.userGroup.value.trim();

    var chat_btn = document.getElementById('chatroom');
    chat_btn.addEventListener('click', function(){

    //     })

        var url = new URL(window.location.href);
        var id = url.searchParams.get("id");
        var temp;

        $.ajax({ url: '../api/getUserData.php',
            data: {id: id},
            type: 'post',
            async: false,
            success: function(output) {
                temp = JSON.parse(output);
                
            }
        });



        var user = {
            //login: helpers.getUui(),
            login: id,
            password: 'webAppPass',
            facebook_id: id,
            full_name: temp[0].name,
            tag_list: 'BooksNTHU'
        };

        localStorage.setItem('user', JSON.stringify(user));
        if(!isLogin){
            document.getElementById('chatroom').innerHTML = "<i class=\"fa fa-refresh fa-spin\" style=\"font-size:15px\"></i>    Loading";
            self.login(user).then(function() {
               
                document.getElementById('chatroom').style.display = "none";
                
                router.navigate('/dashboard');
                isLogin = true;
            }).catch(function(error){
                alert('lOGIN ERROR\n open console to get more info');
                loginBtn.removeAttribute('disabled');
                console.error(error);
                loginForm.login_submit.innerText = 'LOGIN';
            });
        }else{
            document.getElementById('chatroom').style.display = "none";
            document.querySelector('.dashboard').style.display = "flex";
        }
        
    });

    // // add event listeners for each input;
    // _.each(formInputs, function(i){
    //     i.addEventListener('focus', function(e){
    //         var elem = e.currentTarget,
    //             container = elem.parentElement;

    //         if (!container.classList.contains('filled')) {
    //             container.classList.add('filled');
    //         }
    //     });

    //     i.addEventListener('focusout', function(e){
    //         var elem = e.currentTarget,
    //             container = elem.parentElement;

    //         if (!elem.value.length && container.classList.contains('filled')) {
    //             container.classList.remove('filled');
    //         }
    //     });

    //     i.addEventListener('input', function(){
    //         var userName = loginForm.userName.value.trim(),
    //             userGroup = loginForm.userGroup.value.trim();
    //         if(userName.length >=3 && userGroup.length >= 3){
    //             loginBtn.removeAttribute('disabled');
    //         } else {
    //             loginBtn.setAttribute('disabled', true);
    //         }
    //     })
    // });
};

var loginModule = new Login();
