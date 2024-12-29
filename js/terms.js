function confirmDelete(termId) {
  if (confirm("Are you sure you want to delete this term?")) {
    window.location.href = "/studentshelter/terms/delete/" + termId;
  }
}