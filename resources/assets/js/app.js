import $ from 'jquery';

console.log('test');

const $btnSend = $('#btnSend');
$btnSend.click(() => {

  const $selectTo = $('#selectTo');
  const $textMessage = $('#textMessage');
  const data = {
    'message': $textMessage.val()
  };

  console.log('data', data);

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('#csrfToken').val()
    }
  });
  $.ajax({
    type: 'POST',
    url: '/messages/to/' + $selectTo.val(),
    data: data,
    success: (message) => {
      console.log('success', message);
      $textMessage.val('');
    }
  })

});

const $selectTo = $('#selectTo');
$selectTo.change(() => {
  const userId = $selectTo.val();
  $.ajax({
    type: 'GET',
    url: '/messages/to/' + userId,
    success: (messages) => {
      messages = JSON.parse(messages);
      console.log('success', messages);
      var $ulMessages = $('#ulMessages');
      $ulMessages.empty();
      var elmMessages = messages.map((message) => {
        return `<li>${message.message} by ${message.from_user.name} at ${message.created_at}</li>`;
      });
      $ulMessages.append(elmMessages);
    }
  })
});

const $ulMessages = $('#ulMessages');
const socket = require('socket.io-client')(SOCKETIO_ENDPOINT);
socket.on('chat', (message, fn) => {
  console.log('on chat', message);

  if (+$selectTo.val() === +message.to_user.id || +$selectTo.val() === +message.from_user.id) {
    $ulMessages.prepend(`<li>${message.message} by ${message.from_user.name} at ${message.created_at}</li>`);
  }
});

