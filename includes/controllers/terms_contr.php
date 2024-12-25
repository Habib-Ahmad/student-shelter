<?php

function handleTerms()
{
  $termsClauses = [
    "Introduction" => "These Terms govern your access to the Student Accommodation Management System (SAMS) provided by Student Shelters.",
    "User Eligibility" => "Users must be over 18 years or have parental consent.",
    "User Responsibilities" => "Users are responsible for maintaining the confidentiality of their account and password. Additionally, SAMS may only be used for lawful purposes.",
    "Payment Terms" => "Any fees are clearly disclosed. Payments are subject to third-party terms.",
    "Intellectual Property" => "All content on SAMS is the property of Student Shelters.",
    "Termination of Use" => "Student Shelters may suspend or terminate accounts that violate terms.",
    "Limitation of Liability" => "Student Shelters is not liable for any damages resulting from your use of SAMS.",
    "Modification of Terms" => "Student Shelters reserves the right to modify these Terms at any time."
  ];

  require_once 'includes/views/terms_view.php';
}
