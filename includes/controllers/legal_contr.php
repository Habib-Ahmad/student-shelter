<?php

function handleLegal()
{
  $legalClauses = [
    "Platform Usage" => "Our platform is intended for students and landlords to connect for the purpose of renting student accommodation. Misuse of the platform is prohibited.",
    "Accuracy of Listings" => "Student Shelters does not guarantee the accuracy or completeness of property information provided by landlords.",
    "No Rental Guarantees" => "We do not guarantee the availability or suitability of any property listed on the platform.",
    "User Responsibilities" => "Users are responsible for ensuring their actions comply with local laws and regulations regarding tenancy agreements.",
    "Privacy and Data Security" => "We strive to protect your personal data but cannot be held liable for breaches beyond our control.",
    "Disputes and Resolutions" => "Any disputes between tenants and landlords must be resolved independently. Student Shelters is not responsible for mediating disputes.",
    "Content Ownership" => "All images and descriptions uploaded by landlords remain their property but must comply with platform guidelines.",
    "External Links Disclaimer" => "We may provide links to third-party websites for your convenience but are not responsible for their content or accuracy.",
    "Limitation of Liability" => "Student Shelters is not liable for any financial losses, damages, or inconveniences arising from the use of this platform.",
    "Changes to Terms" => "We reserve the right to update these terms and conditions at any time without prior notice."
  ];

  require_once 'includes/views/legal_view.php';
}
