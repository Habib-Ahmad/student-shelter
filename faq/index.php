<?php require_once "../partials/header.php"; ?>

<section class="faq-container">
    <h2>Frequently Asked Questions</h2>

    <div class="faq-item">
        <button class="faq-question">What is the Student Accommodation Management System by Student
            Shelters?</button>
        <div class="faq-answer">
            <p>The Student Accommodation Management System (SAMS) by Student Shelters is a web application designed
                to help students find, manage, and rent accommodation easily and securely.</p>
        </div>
    </div>

    <div class="faq-item">
        <button class="faq-question">Who can use this platform?</button>
        <div class="faq-answer">
            <p>Our platform is designed for students, property managers, landlords, and educational institutions.
            </p>
        </div>
    </div>

    <div class="faq-item">
        <button class="faq-question">Is it free to use?</button>
        <div class="faq-answer">
            <p>Creating an account is free for students. Some premium features may have fees.</p>
        </div>
    </div>

    <div class="faq-item">
        <button class="faq-question">How do I apply for accommodation?</button>
        <div class="faq-answer">
            <p>Create a profile, browse properties, and submit an application.</p>
        </div>
    </div>

    <div class="faq-item">
        <button class="faq-question">How are rent payments handled?</button>
        <div class="faq-answer">
            <p>Rent payments can be made through our secure payment gateway.</p>
        </div>
    </div>

    <div class="faq-item">
        <button class="faq-question">How is my personal data protected?</button>
        <div class="faq-answer">
            <p>We prioritize the security of your personal information with strict data protection.</p>
        </div>
    </div>
</section>

<script>
    // Add toggle functionality for FAQ questions
    const faqQuestions = document.querySelectorAll('.faq-question');

    faqQuestions.forEach(question => {
        question.addEventListener('click', () => {
            const item = question.parentElement;

            // Toggle the active class
            item.classList.toggle('active');

            // Close other open items
            document.querySelectorAll('.faq-item').forEach(otherItem => {
                if (otherItem !== item) {
                    otherItem.classList.remove('active');
                }
            });
        });
    });
</script>

<?php require_once "../partials/footer.php"; ?>