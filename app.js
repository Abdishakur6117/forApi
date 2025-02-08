$(document).ready(function () {
  function isValidPhoneNumber(phone) {
    const phoneRegex = /^\+\d{10,15}$/; // Matches numbers starting with "+" and 10-15 digits
    return phoneRegex.test(phone);
  }
  
  $('#sendMessageForm').submit(function (e) {
    e.preventDefault();
  
    const phone = $('#phone').val();
    if (!isValidPhoneNumber(phone)) {
      alert('Please enter a valid phone number in international format (e.g., +252618266117)');
      return;
    }
  
    // Proceed with sending the message
    const formData = {
      token: 'mofcgbsdo4ve3bwh',
      to: phone,
      body: `Hi ${$('#name').val()}, congratulations! You have successfully sent a message via WhatsApp!`,
    };
  
    $.ajax({
      type: 'POST',
      url: 'https://api.ultramsg.com/instance106531/',
      data: formData,
      dataType: 'json',
      success: function (response) {
        if (response.sent) {
          alert('Message sent successfully!');
        } else {
          alert('Failed to send message: ' + (response.message || 'Unknown error.'));
        }
      },
      error: function (xhr, status, error) {
        console.error('Error:', error);
        alert('An error occurred: ' + error);
      },
    });
  });
  
});
