let alertTimeout;

function showSuccess(msg) {
  clearTimeout(alertTimeout);
  $('#success-message').text(msg);
  $('#error-alert').hide();
  $('#success-alert').show();
  $('#alert-center-wrapper').removeClass('d-none');

  alertTimeout = setTimeout(() => {
    $('#alert-center-wrapper').addClass('d-none');
  }, 10000);
}

function showError(msg) {
  clearTimeout(alertTimeout);
  $('#error-message').html(msg);
  $('#success-alert').hide();
  $('#error-alert').show();
  $('#alert-center-wrapper').removeClass('d-none');

  alertTimeout = setTimeout(() => {
    $('#alert-center-wrapper').addClass('d-none');
  }, 10000);
}

function attachAlertCloseHandler() {
  const alerts = document.querySelectorAll('#alert-center-wrapper .alert-dismissible');
  alerts.forEach(alertElem => {
    alertElem.addEventListener('closed.bs.alert', () => {
      $('#alert-center-wrapper').addClass('d-none');
    });
  });
}

$(document).ready(function() {
  attachAlertCloseHandler();
});
