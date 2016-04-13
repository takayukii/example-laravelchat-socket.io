(function ($) {

  var $btnSend = $('#btnSend');
  $btnSend.click(function (){

    var $selectTo = $('#selectTo');
    var $textMessage = $('#textMessage');
    var data = {
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
      success: function (message){
        console.log('success', message);
      }
    })

  });

  var $selectTo = $('#selectTo');
  $selectTo.change(function(){
    var userId = $selectTo.val();
    $.ajax({
      type: 'GET',
      url: '/messages/to/' + userId,
      success: function (messages) {
        messages = JSON.parse(messages);
        console.log('success', messages);
        var $ulMessages = $('#ulMessages');
        $ulMessages.empty();
        var elmMessages = messages.map(function (message){
          return '<li>' + message.message + ' by ' + message.from_user.name + ' at ' + message.created_at + '</li>';
        });
        $ulMessages.append(elmMessages);
      }
    })
  });

}(jQuery));
