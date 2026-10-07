import { triggerToast } from '../utils';

// Definisi Aturan Validasi
const rules = [
  {
    input: '#email',
    error: '#err-login-email',
    tests: [
      {
        condition: (val) => val.length === 0,
        message: 'UMM Email must not be Empty.'
      },
      {
        condition: (val) => !val.endsWith('@webmail.umm.ac.id'),
        message: 'Use UMM Email (@webmail.umm.ac.id).'
      }
    ]
  },
  {
    input: '#password',
    error: '#err-login-password',
    tests: [
      {
        condition: (val) => val.length === 0,
        message: 'Password must not be Empty.'
      },
      {
        condition: (val) => val.length < 6,
        message: 'Password must be at least 6 characters.'
      }
    ]
  }
];

$(document).ready(function () {
  $(document).on('submit', '#form-login', function (e) {
    e.preventDefault();
    let isValid = true;

    // Reset status error di awal
    $('.input-field').removeClass('error');
    $('[id^="err-"]').hide().text('');

    // Iterasi dan Eksekusi Validasi
    rules.forEach((rule) => {
      const $input = $(rule.input);
      const $error = $(rule.error);
      const value = ($input.val() || '').trim();

      for (const test of rule.tests) {
        // Evaluasi kondisi error
        if (test.condition(value)) {
          $input.addClass('error');
          $error.text(test.message).show();
          isValid = false;
          break;
        }
      }
    });

    if (!isValid) {
      triggerToast('toast_error', 'Please check your login data.');
    } else {
      this.submit();
    }
  });
});