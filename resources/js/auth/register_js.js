import { triggerToast } from '../utils';

// Rules Validasi Register Form
const rules = [
  {
    input: '#name',
    error: '#err-name',
    tests: [
      {
        condition: val => val.length === 0,
        message: 'Full Name tidak boleh kosong.'
      },
      {
        condition: val => val.length < 3,
        message: 'Full Name minimal 3 karakter.'
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
        message: 'UMM Email tidak boleh kosong.'
      },
      {
        condition: val => !val.includes('@webmail.umm.ac.id'),
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
        condition: val => !/^08\d{8,12}$/.test(val),
        message: 'WhatsApp harus diawali 08 dan berisi angka.'
      }
    ]
  },
  {
    input: '#password',
    error: '#err-password',
    tests: [
      {
        condition: val => val.length === 0,
        message: 'Password tidak boleh kosong.'
      },
      {
        condition: val => val.length < 6,
        message: 'Password minimal 6 karakter.'
      }
    ]
  },
  {
    input: '#password_confirmation',
    error: '#err-password-conf',
    tests: [
      {
        // `val` = confirm password, 
        // `other` = original password
        condition: (val, other) => val !== other,
        message: 'Konfirmasi password tidak cocok.'
      }
    ]
  }
];

// ------------------------------------------------------------------
// Helper: set / clear error UI
// ------------------------------------------------------------------
function setError($input, $error, msg) {
  if (msg) {
    $input.addClass('error');
    $error.text(msg).show();
  } else {
    $input.removeClass('error');
    $error.text('').hide();
  }
}

// ------------------------------------------------------------------
// Validate a single field using the rule set
// ------------------------------------------------------------------
function validateField($input, $error, extra = null) {
  const val = ($input.val() || '').trim();

  const rule = rules.find(r => r.input === $input.selector);
  if (!rule) return true; // no rule → assume valid

  for (const test of rule.tests) {
    const ok = test.condition.length === 2
      ? test.condition(val, extra)
      : test.condition(val);
    if (!ok) {
      setError($input, $error, test.message);
      return false;
    }
  }
  setError($input, $error, '');
  return true;
}

// ------------------------------------------------------------------
// Document ready – bind events & submit handling
// ------------------------------------------------------------------
$(document).ready(function () {
  // ----------------------------------------------------------------
  // Submit handling
  // ----------------------------------------------------------------
  $('#form-register').on('submit', function (e) {
    e.preventDefault();
    let isValid = true;

    // Reset UI on page load
    $('.input-field').removeClass('error');
    $('[id^="err-"]').hide().text('');

    rules.forEach(rule => {
      const $input = $(rule.input);
      const $error = $(rule.error);
      const extra = rule.input === '#password_confirmation' ? $('#password').val() : null;
      const value = ($input.val() || '').trim();

      for (const test of rule.tests) {
        const catchError = test.condition.length === 2
          ? test.condition(value, extra)
          : test.condition(value);

        if (catchError) {
          $input.addClass('error');
          $error.text(test.message).show();
          isValid = false;
          break;
        }
      }
    });

    if (!isValid) {
      triggerToast('toast_error', 'Periksa kembali data pendaftaran Anda.');
    } else {
      setTimeout(() => this.submit(), 500);
    }
  });

  // ----------------------------------------------------------------
  // Input numeric‑only for NIM & WhatsApp
  // ----------------------------------------------------------------
  $(document).on('input', '#nim, #whatsapp_no', function () {
    this.value = this.value.replace(/[^0-9]/g, '');
  });
});
