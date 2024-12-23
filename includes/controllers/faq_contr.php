<?php

function handleFaq()
{
  $faqs = [
    "What is the Student Accommodation Management System by Student Shelters?" => "The Student Accommodation Management System (SAMS) by Student Shelters is a web application designed to help students find, manage, and rent accommodation easily and securely.",
    "Who can use this platform?" => "Our platform is designed for students, property managers, landlords, and educational institutions.",
    "Is it free to use?" => "Creating an account is free for students. Some premium features may have fees.",
    "How do I apply for accommodation?" => "Create a profile, browse properties, and submit an application.",
    "How are rent payments handled?" => "Rent payments can be made through our secure payment gateway.",
    "How is my personal data protected?" => "We prioritize the security of your personal information with strict data protection."
  ];

  require_once 'includes/views/faq_view.php';
}
