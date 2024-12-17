document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.verify-btn').forEach(button => {
    button.addEventListener('click', () => {
      const studentId = button.dataset.id;

      if (confirm('Are you sure you want to verify this student?')) {
        fetch('../includes/users.inc.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ action: 'verify', id: studentId })
        })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              alert('Student verified successfully!');
              location.reload(); // Refresh the page to reflect changes
            } else {
              alert('Error: ' + data.message);
            }
          });
      }
    });
  });

  document.querySelectorAll('.reject-btn').forEach(button => {
    button.addEventListener('click', () => {
      const studentId = button.dataset.id;
      const reason = prompt('Enter the reason for rejection:');
      if (reason) {
        fetch('../includes/users.inc.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ action: 'reject', id: studentId, reason })
        })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              alert('Student rejected successfully!');
              location.reload(); // Refresh the page to reflect changes
            } else {
              alert('Error: ' + data.message);
            }
          });
      }
    });
  });
});
