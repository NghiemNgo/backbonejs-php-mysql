<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>CRUD BackboneJS PHP MySQL</title>

    <!-- Bootstrap -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <style>
        
    *, *:before, *:after {
  -moz-box-sizing: border-box;
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
}

html {
  font-family: Helvetica, Arial, sans-serif;
  font-size: 100%;
  background: #333;
}

#page-wrapper {
  width: 650px;
  background: #FFF;
  padding: 1em;
  margin: 1em auto;
  border-top: 5px solid #69c773;
  box-shadow: 0 2px 10px rgba(0,0,0,0.8);
}

h1 {
	margin-top: 0;
}

#status {
  font-size: 0.9rem;
  margin-bottom: 1rem;
}

.open {
  color: green;
}

.closed {
  color: red;
}


ul {
  list-style: none;
  margin: 0;
  padding: 0;
  font-size: 0.95rem;
}

ul li {
  padding: 0.5rem 0.75rem;
  border-bottom: 1px solid #EEE;
}

ul li:first-child {
  border-top: 1px solid #EEE;
}

ul li span {
  display: inline-block;
  width: 90px;
  font-weight: bold;
  color: #999;
  font-size: 0.7rem;
  text-transform: uppercase;
  letter-spacing: 1px;
}

.sent {
  background-color: #F7F7F7;
}

.received {}

#message-form {
  margin-top: 1.5rem;
}

textarea {
  width: 100%;
  padding: 0.5rem;
  font-size: 1rem;
  border: 1px solid #D9D9D9;
  border-radius: 3px;
  box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.1);
  min-height: 100px;
  margin-bottom: 1rem;
}

button {
  display: inline-block;
  border-radius: 3px;
  border: none;
  font-size: 0.9rem;
  padding: 0.6rem 1em;
  color: white;
  margin: 0 0.25rem;
  text-align: center;
  background: #BABABA;
  border-bottom: 1px solid #999;
}

button[type="submit"] {
  background: #86b32d;
  border-bottom: 1px solid #5d7d1f;
}

button:hover {
  opacity: 0.75;
  cursor: pointer;
}

    </style>
    <script>
        window.onload = function() {

  // Get references to elements on the page.
  var form = document.getElementById('message-form');
  var messageField = document.getElementById('message');
  var messagesList = document.getElementById('messages');
  var socketStatus = document.getElementById('status');
  var closeBtn = document.getElementById('close');

    var WebSocketServer = require('ws').Server;
  // Create a new WebSocket.
  var socket = new WebSocketServer({ port: 8080 });


  // Handle any errors that occur.
  socket.onerror = function(error) {
    console.log('WebSocket Error: ' + error);
  };


  // Show a connected message when the WebSocket is opened.
  socket.onopen = function(event) {
    socketStatus.innerHTML = 'Connected to: ' + event.currentTarget.url;
    socketStatus.className = 'open';
  };


  // Handle messages sent by the server.
  socket.onmessage = function(event) {
    var message = event.data;
    messagesList.innerHTML += '<li class="received"><span>Received:</span>' + message + '</li>';
  };


  // Show a disconnected message when the WebSocket is closed.
  socket.onclose = function(event) {
    socketStatus.innerHTML = 'Disconnected from WebSocket.';
    socketStatus.className = 'closed';
  };


  // Send a message when the form is submitted.
  form.onsubmit = function(e) {
    e.preventDefault();

    // Retrieve the message from the textarea.
    var message = messageField.value;

    // Send the message through the WebSocket.
    socket.send(message);

    // Add the message to the messages list.
    messagesList.innerHTML += '<li class="sent"><span>Sent:</span>' + message + '</li>';

    // Clear out the message field.
    messageField.value = '';

    return false;
  };


  // Close the WebSocket connection when the close button is clicked.
  closeBtn.onclick = function(e) {
    e.preventDefault();

    // Close the WebSocket.
    socket.close();

    return false;
  };

};

    </script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  <div id="page-wrapper">
  <h1>WebSockets Demo</h1>
  
  <div id="status">Connecting...</div>
  
  <ul id="messages"></ul>
  
  <form id="message-form" action="#" method="post">
    <textarea id="message" placeholder="Write your message here..." required></textarea>
    <button type="submit">Send Message</button>
    <button type="button" id="close">Close Connection</button>
  </form>
</div>
  </body>
</html>