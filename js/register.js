
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
    const confirmPasswordInput = document.getElementById('confirmPassword');

    togglePassword.addEventListener('click', function () {
      const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordInput.setAttribute('type', type);
      this.classList.toggle('fa-eye');
      this.classList.toggle('fa-eye-slash');
    });

    toggleConfirmPassword.addEventListener('click', function () {
      const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
      confirmPasswordInput.setAttribute('type', type);
      this.classList.toggle('fa-eye');
      this.classList.toggle('fa-eye-slash');
    });

    // Validate Matching Passwords
    const registrationForm = document.getElementById('registrationForm');
    const passwordError = document.getElementById('passwordError');

    registrationForm.addEventListener('submit', function (event) {
      if (passwordInput.value !== confirmPasswordInput.value) {
        event.preventDefault(); // Prevent form submission
        passwordError.style.display = 'block';
      } else {
        passwordError.style.display = 'none';
      }
    });
    document.getElementById('submit').addEventListener('click', function (event) {
      const username = document.getElementById('username').value.trim();
      const password = document.getElementById('password').value.trim();
      const confirmPassword = document.getElementById('confirmpassword').value.trim();
      const firstName = document.getElementById('first_name').value.trim();
      const lastName = document.getElementById('last_name').value.trim();
  
      if (!username || !password || !confirmPassword || !firstName || !lastName) {
          alert('Please fill out all required fields.');
          event.preventDefault(); // Prevent form submission
          return;
      }
  
      if (password !== confirmPassword) {
          alert('Passwords do not match.');
          event.preventDefault(); // Prevent form submission
      }
  });
  
const contactInput = document.getElementById('contact');
contactInput.addEventListener('input', function () {
    if (!contactInput.value.startsWith('09')) {
        contactInput.value = '09';
    }
});
function changeUnitInput() {
  var unitField = document.getElementById('unit');
  var selectedValue = unitField.value;
  
  if (selectedValue === 'TAXI' || selectedValue === 'MULTICAB') {
      unitField.innerHTML = `
          <option value="TAXI">TAXI</option>
          <option value="MULTICAB">Multicab</option>
      `;
  } else {
      unitField.innerHTML = `
          <option value="">Select a unit type</option>
          <option value="other">Other</option>
      `;
  }
}