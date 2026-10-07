import { triggerToast } from '../utils';

// Rules Validasi Edit Profile Form
const rules = [
  {
    input: '#name',
    error: '#err-name',
    tests: [
      {
        condition: val => val.length === 0,
        message: 'Nama lengkap tidak boleh kosong.'
      },
      {
        condition: val => val.length < 3,
        message: 'Nama minimal 3 karakter.'
      }
    ]
  },
  {
    input: '#nim',
    error: '#err-nim',
    tests: [
      {
        condition: val => val.length === 0,
        message: 'NIM tidak boleh kosong.'
      },
      {
        condition: val => !/^\d{15}$/.test(val),
        message: 'NIM harus 15 digit angka.'
      }
    ]
  },
  {
    input: '#major',
    error: '#err-major',
    tests: [
      {
        condition: val => val.length === 0,
        message: 'Jurusan tidak boleh kosong.'
      }
    ]
  },
  {
    input: '#email',
    error: '#err-email',
    tests: [
      {
        condition: val => val.length === 0,
        message: 'Email tidak boleh kosong.'
      },
      {
        // Cek apakah input memiliki format email
        condition: val => !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val),
        message: 'Format email tidak valid.'
      },
      {
        condition: val => !val.endsWith('@webmail.umm.ac.id'),
        message: 'Gunakan email UMM (@webmail.umm.ac.id).'
      }
    ]
  },
  {
    input: '#whatsapp_no',
    error: '#err-whatsapp-no',
    tests: [
      {
        condition: val => val.length === 0,
        message: 'Nomor WhatsApp tidak boleh kosong.'
      },
      {
        // Cek format No WA 08xxxxxxxxx
        condition: val => !/^08\d{8,12}$/.test(val),
        message: 'Nomor WhatsApp harus diawali 08 dan berisi angka.'
      }
    ]
  },
];


$(document).ready(function () {
  // ----------------------------------------------------------------
  // Submit handling
  // ----------------------------------------------------------------
  $(document).on('submit', '#form-profile', function (e) {
    e.preventDefault();
    let isValid = true;

    // Reset UI on page load
    $('.input-field').removeClass('error');
    $('[id^="err-"]').hide().text('');

    rules.forEach(rule => {
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
      triggerToast('toast_error', 'Periksa kembali data profil Anda.');
    } else {
      this.submit();
    }
  });
});
