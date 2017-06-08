/**
 * Created by DELL on 6/5/2017.
 */
/*
FB.login(function(ra) {
    if (ra.authResponse) {
        FB.api('/me?fields=email,last_name,first_name&access_token='+ra.authResponse.accessToken, function(rb) {});
    }
},{scope: 'email,manage_pages,public_profile,publish_actions,read_page_mailboxes',
    return_scopes: true
});*/

console.log('hello');

// Initialize Firebase
var config = {
    apiKey: "AIzaSyCllUC_WaAvBXaTK5JYqEN3QS0qcQB1ilI",
    authDomain: "sales-assistant-86c56.firebaseapp.com",
    databaseURL: "https://sales-assistant-86c56.firebaseio.com",
    projectId: "sales-assistant-86c56",
    storageBucket: "sales-assistant-86c56.appspot.com",
    messagingSenderId: "512651626548"
};
firebase.initializeApp(config);

// Get the Messaging service for the default app
console.log('register message service');
const fcm = firebase.messaging();
console.log(fcm);
fcm.requestPermission()
    .then(function() {
    console.log('have permission');
    return fcm.getToken();
    })
    .then(function(token) {
        console.log(token)
    })
    .catch(function(err) {
        console.log(err)
    });

fcm.onMessage(function(payload) {
    console.log(payload);
})
/*
var provider = new firebase.auth.FacebookAuthProvider();
provider.addScope('email,manage_pages,public_profile,publish_actions,read_page_mailboxes,read_mailbox');

firebase.auth().signInWithPopup(provider).then(function(result) {
    console.log(result);
    // This gives you a Facebook Access Token. You can use it to access the Facebook API.
    var token = result.credential.accessToken;
    // The signed-in user info.
    var user = result.user;
    // ...
}).catch(function(error) {
    // Handle Errors here.
    var errorCode = error.code;
    var errorMessage = error.message;
    // The email of the user's account used.
    var email = error.email;
    // The firebase.auth.AuthCredential type that was used.
    var credential = error.credential;
    // ...
});

*/


window.fbAsyncInit = function() {
    FB.init({
        appId      : app_info.app_id,
        cookie     : true,
        xfbml      : true,
        version    : 'v2.9'
    });
    FB.AppEvents.logPageView();
    FB.Event.subscribe('auth.authResponseChange', checkLoginState);
    };

(function(d, s, id){
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {return;}
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

firebase.auth().onAuthStateChanged(function(user) {
    if (user) {
        // User is signed in.
    } else {
        // No user is signed in.
    }
});

function checkLoginState(event) {
    /*
    FB.getLoginStatus(function(response) {
        console.log(response);
        statusChangeCallback(response);
    });*/
    console.log(event.authResponse);
    if (event.authResponse) {
        // User is signed-in Facebook.
        var unsubscribe = firebase.auth().onAuthStateChanged(function(firebaseUser) {
            unsubscribe();
            // Check if we are already signed-in Firebase with the correct user.
            if (!isUserEqual(event.authResponse, firebaseUser)) {
                // Build Firebase credential with the Facebook auth token.
                var credential = firebase.auth.FacebookAuthProvider.credential(
                    event.authResponse.accessToken);
                // Sign in with the credential from the Facebook user.
                firebase.auth().signInWithCredential(credential).catch(function(error) {
                    // Handle Errors here.
                    var errorCode = error.code;
                    var errorMessage = error.message;
                    // The email of the user's account used.
                    var email = error.email;
                    // The firebase.auth.AuthCredential type that was used.
                    var credential = error.credential;
                    // ...
                });

            } else {
                // User is already signed-in Firebase with the correct user.
            }
            console.log(firebaseUser);
            statusChangeCallback(event.authResponse);
        });
    } else {
        // User is signed-out of Facebook.
        firebase.auth().signOut().then(function() {
            // Sign-out successful.
        }).catch(function(error) {
            // An error happened.
        });
    }
}

function isUserEqual(facebookAuthResponse, firebaseUser) {
    if (firebaseUser) {
        var providerData = firebaseUser.providerData;
        for (var i = 0; i < providerData.length; i++) {
            if (providerData[i].providerId === firebase.auth.FacebookAuthProvider.PROVIDER_ID &&
                providerData[i].uid === facebookAuthResponse.userID) {
                // We don't need to re-auth the Firebase connection.
                return true;
            }
        }
    }
    return false;
}

function statusChangeCallback(user_auth_info) {
    var access_token = user_auth_info.accessToken;
    FB.api('/me/accounts','get', null, function(response) {
        console.log(response);
        if((response.data.length)>0) {
            response.data.forEach(function(element) {
                getPagePicture(element.id);
                getPageConversations(element.access_token);
            });
        }
        //list all pages here
    });
}

function getPagePicture(page_id) {
    FB.api(
        "/" + page_id + "/picture",
        function (response) {
            if (response && !response.error) {
                /* handle the result */
                console.log('page details');
                console.log(response);
            }
        }
    );
}

function getPageConversations(pageAccessToken) {
    FB.api('/me/conversations', {
        access_token : pageAccessToken
    }, function(response) {
        if(response.data.length > 0 ) {
            response.data.forEach(function(conversation) {
                console.log('getPageConversations');
                console.log(conversation);
                getPageConversation(conversation.id,pageAccessToken)
            });
        }
    });
}

function getPageConversation(conversation_id,pageAccessToken) {
    FB.api(
        "/" + conversation_id + "/messages", {access_token : pageAccessToken},
        function (response) {
            if (response && !response.error) {
                /* handle the result */
                if(response.data.length > 0 ) {
                    console.log('getPageMessages');
                    console.log(response);
                    response.data.forEach(function(message) {
                        getDetailMessage(message.id,pageAccessToken)
                    });
                }
            } else console.log(response);
        }
    );
}

function getDetailMessage(message_id,pageAccessToken) {
    /* make the API call */
    FB.api(
        "/" + message_id,
        {access_token : pageAccessToken,
            fields: 'message,attachments,created_time,to,from,shares{link}'},
        function (response) {
            if (response && !response.error) {
                /* handle the result */
                console.log(response);
            }
        }
    );
}


function sendMessage(conversation_id,pageAccessToken) {
    /* make the API call */
    FB.api(
        "/" + conversation_id + "/messages",
        "POST",
        {
            "message": "This is a test message",
            access_token : pageAccessToken
        },
        function (response) {
            if (response && !response.error) {
                /* handle the result */
            }
        }
    );
}

