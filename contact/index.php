<?php require_once "../partials/header.php"; ?>

<div class="contact-section">
    <div class="container">
        <h2>Contact Us</h2>
        <p>For further inquiries, feel free to reach out to us. We're here to help!</p>

        <form action="#" class="contact-form">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" placeholder="Enter your full name" required>
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" placeholder="Enter your email address" required>
            </div>
            <div class="form-group">
                <label for="message">Message</label>
                <textarea id="message" name="message" placeholder="Write your message" rows="5" required></textarea>
            </div>
            <button type="submit" class="submit-btn">Send Message</button>
        </form>
    </div>
</div>

<?php require_once "../partials/footer.php"; ?>
