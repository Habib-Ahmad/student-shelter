function confirmDelete(clauseId) {
  if (confirm("Are you sure you want to delete this legal clause?")) {
    window.location.href = "/studentshelter/legal/delete/" + clauseId;
  }
}
