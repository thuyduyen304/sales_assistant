/**
 * Created by DELL on 6/7/2017.
 */
importScripts('https://www.gstatic.com/firebasejs/4.1.1/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/4.1.1/firebase-messaging.js');

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

const messaging = firebase.messaging();