function setupRoleToggle() {
  const roleInputs = document.querySelectorAll('input[name="role"]');
  const studentDocuments = document.getElementById('student-documents');

  if (!roleInputs || !studentDocuments) return;

  roleInputs.forEach(input => {
    input.addEventListener('change', function () {
      if (this.value === 'student') {
        studentDocuments.style.display = 'block';
      } else {
        studentDocuments.style.display = 'none';
      }
    });
  });

  // Initialize the visibility based on the pre-selected role
  const selectedRole = document.querySelector('input[name="role"]:checked');
  if (selectedRole && selectedRole.value === 'student') {
    studentDocuments.style.display = 'block';
  }
}
