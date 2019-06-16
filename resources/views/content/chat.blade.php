@extends('layouts.app')

@section("css")
<link rel="stylesheet" href="{{ asset('css/content.css') }}" type="text/css" />
@endsection

@section('content')
    
    <div class="message-template">
      <!-- 受信メッセージのテンプレート -->
      <div class="message message--received media float-left">
          <img class="message__img align-self-center" src="{{ Gravatar::src(App\User::find($you)->email, 72) }}" alt="">
        <div class="message__body media-body">
          <div class="message__user-name"></div>
          <div class="message__text"></div>
          <div class="message__info float-right"><span class="message__time"></span></div>
        </div>
      </div><!-- /.message -->

      <!-- 送信メッセージのテンプレート -->
      <div class="message message--sent media float-right">
        <div class="message__profile">
          <img class="align-self-center message__img" src="{{ Gravatar::src(App\User::find($me)->email, 72) }}" alt="">
        </div>
        <div class="message__body media-body">
          <div class="message__user-name"></div>
          <div class="message__text"></div>
          <div class="message__info float-right"><span class="message__time"></span></div>
        </div>
      </div><!-- /.message -->
    </div>
    
    
<div class="container">
    <!-- メッセージ表示部 -->
      <div class="message-list clearfix"></div>
      
      <form class="comment-form mt-5 mb-5" id="submit">
        <div class="input-group">
          <input type="text" class="form-control input-lg comment-form__text" id="comment">
          <div class="input-group-append">
              <button type="submit" class="btn btn-primary comment-form__submit" aria-label="送信">送信</button>
          </div>
        </div><!-- /.input-group -->
    </form><!-- /.comment-form -->
</div>
     
    
@endsection

@section("script")
    <script src="https://www.gstatic.com/firebasejs/5.4.1/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/5.4.1/firebase-auth.js"></script>
    <script src="https://www.gstatic.com/firebasejs/5.4.1/firebase-database.js"></script>
    <script src="https://www.gstatic.com/firebasejs/5.4.1/firebase-storage.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script>
        var myname = "{{ App\User::find($me)->name }}";
        var yourname = "{{ App\User::find($you)->name }}";
        var roomid = "{{ $roomid }}";
        console.log(myname);
        console.log(yourname);
        console.log(roomid);
        
        var config = {
        apiKey: "AIzaSyAshwUY0Z6Z_8Y-IDkBisql32NMSnfAHIE",
        authDomain: "realtime-chat-42052.firebaseapp.com",
        databaseURL: "https://realtime-chat-42052.firebaseio.com",
        storageBucket: "realtime-chat-42052.appspot.com",
      };
     // Initialize Firebase
      firebase.initializeApp(config);
      
/* jshint curly:true, debug:true */
/* globals $, firebase, location, moment */



$(document).ready(function(){
    //firebaseログイン認証機能

    var email = "{{ App\User::find($me)->email }}";
    var pass = "{{ App\User::find($me)->password }}";

    var currentUID = null;
    
    firebase.auth().setPersistence(firebase.auth.Auth.Persistence.SESSION)
            .then(function(){
              console.log("認証状態の永続性をsessionに設定しました")
              
            })
            .catch(function(error){
              console.log("認証状態の永続性設定に失敗しました",error)
            })
    
    firebase.auth().onAuthStateChanged(function(user){
        if(user){
            console.log("状態：ログイン中");
            currentUID = user.uid;
            
            //ログイン状態の時、コメントデータ表示
            var roomsRef = firebase.database().ref("comments/" + roomid);
            
            roomsRef.off("child_added");
            
            //コメントデータ追加時処理
            roomsRef.on("child_added", function(childSnapshot){
                console.log("child_added run");
                console.log(childSnapshot.val());
                console.log(childSnapshot.key);
                addMessage(childSnapshot.key, childSnapshot.val());
            });
                    
        }else{
            console.log("状態：ログアウト");
            currentUID = null;
            
            //ログアウト状態だったらログインor登録
            firebase.auth().signInWithEmailAndPassword(email, pass)
            .then(function(user){
                console.log('ログインしました', user);
            })
            .catch(function(error){
                console.log('ログインエラー', error);
                    
                    firebase.auth().createUserWithEmailAndPassword(email, pass)
                     .then(function(){
                         console.log("ユーザ作成に成功");
                         firebase.auth().signInWithEmailAndPassword(email, pass)
                          .then(function(user){
                              console.log("ログインしました");
                          })
                          .catch(function(error){
                              console.log("ログインエラー", error);
                          })
                     }).catch(function(error){
                         console.error("ユーザ作成に失敗", error);
                     })
            })
            }
    })
    
    /*firebaseログアウト用コード
    firebase.auth().signOut()
        .then(function(){
            console.log("ログアウトしました");
        })
        .catch(function(error){
            console.log("ログインエラー", error);
        })*/
    
    //チャット機能
    $("#submit").submit(function(){
      var comment = $('#comment').val();
      $("#comment").val("");
      
      console.log(comment);
      
      var message = {
                      uid: currentUID,
                      name:myname,
                      text: comment,
                      time: firebase.database.ServerValue.TIMESTAMP,
                     };
                     
      console.log(message);
      
       firebase.database().ref().child("comments/" + roomid).push(message);
      
      return false;
    })
    
    
    
    
    
    // messageを表示する
function addMessage(roomId, message) {
  var divTag = createMessageDiv(roomId, message);
  divTag.appendTo(".message-list");

  // 一番下までスクロール 
  $("html, body").scrollTop($(document).height());
}

// messageの表示用のdiv（jQueryオブジェクト）を作って返す
function createMessageDiv(roomId, message) {
  // HTML内のテンプレートからコピーを作成
  var divTag = null;
  if (message.name === "{{ App\User::find($me)->name }}") { // 送信メッセージ
    divTag = $(".message-template .message--sent").clone();
  } else { // 受信メッセージ
    divTag = $(".message-template .message--received").clone();
  }

    // 投稿者ニックネーム
    divTag.find(".message__user-name").addClass("nickname-" + message.uid).text(message.name);
    
    // 投稿者プロフィール画像
    /*divTag.find(".message__user-image").addClass("profile-image-" + message.uid);
    if (user.profileImageURL) { // プロフィール画像のURLを取得済みの場合
      divTag.find(".message__user-image").attr({
        src: user.profileImageURL,
      });
    }*/
  // メッセージ本文
  divTag.find(".message__text").text(message.text);
  // 投稿日
  divTag.find(".message__time").html(formatDate(new Date(message.time)));

  // id属性をセット
  divTag.attr("id", "message-id-" + message.uid);

  return divTag;
}

// DateオブジェクトをHTMLにフォーマットして返す
function formatDate(date) {
  var m = moment(date);
  return m.format("YYYY/MM/DD") + "&nbsp;&nbsp;" + m.format("HH:mm:ss");
}

})
</script>
@endsection