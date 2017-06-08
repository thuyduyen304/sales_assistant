<?php
/*
 * Template Name: Order Page
 * Description: A Page Template with a darker design.
 */

?>
<!--
<script>
    window.fbAsyncInit = function() {
        FB.init({
            appId      : '270596683413040',
            xfbml      : true,
            version    : 'v2.9'
        });
        FB.AppEvents.logPageView();
    };

    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>-->

<script>
    window.fbAsyncInit = function() {
        FB.init({
            appId      : '270596683413040',
            cookie     : true,
            xfbml      : true,
            version    : 'v2.8'
        });
        FB.AppEvents.logPageView();
    };

    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    function checkLoginState() {
        FB.getLoginStatus(function(response) {
            statusChangeCallback(response);
        });
    }

</script>

<fb:login-button
    scope="public_profile,email"
    onlogin="checkLoginState();">
</fb:login-button>

<!--
<div
    class="fb-like"
    data-share="true"
    data-width="450"
    data-show-faces="true">
</div>
