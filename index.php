<?php
require_once './partials/header.php';
require_once "./includes/config_session.inc.php";
require_once "./includes/views/login_view.inc.php";
require_once "./includes/views/property_view.inc.php";
?>

<main>
  <!-- Beginning Hero section-->
  <section class="hero">
    <div class="hero-content">
      <h1>Your Guide To Safe Student Housing</h1>
      <p>Need help finding the right accommodation? We are ready to guide you toward a place that suits your needs.</p>
    </div>
  </section>
  <!-- End of Hero section-->

  <!-- Beginning of display property section -->
  <header class="search-header">
    <div class="search-filters">
      <select>
        <option value="">propety type</option>
        <option value="apartment">Apartment</option>
        <option value="studio">Studio</option>
        <option value="house">House</option>
      </select>
      <input type="number" placeholder="Max Budget" />
      <input placeholder="check-in" type="date" />
      <button class="search-button">Search</button>
    </div>
  </header>

  <section class="properties-section">
    <div class="properties">

      <?php list_all_properties(); ?>
    </div>
  </section>
  <!-- End of display property section-->

  <!-- Beginning of Booking Process section-->
  <section class="midnight-section">
    <div class="section-header">
      <p>Reservations Process</p>
      <h3>Fast, Intuitive And Absolutely Safe!</h3>
    </div>
    <div class="columns">
      <div class="column">
        <h1>1</h1>
        <h4>Choose a place</h4>
        <p>Explore an extensive range of quality rooms, studios, and apartments. Save the ones you love and book them
          effortlessly.</p>
      </div>
      <div class="column">
        <h1>2</h1>
        <h4>Accepting a reservation</h4>
        <p>Expect to receive the owner's acceptance of your reservation within a few hours. You won’t be left guessing
          or waiting for long.</p>
      </div>
      <div class="column">
        <h1>3</h1>
        <h4>Make Payment</h4>
        <p>Once you get the confirmation, just send the payment, and you're nearly finished!</p>
      </div>
      <div class="column">
        <h1>4</h1>
        <h4>Get your keys!</h4>
        <p>Accommodation secured! Get ready to move and check in on the date you picked.</p>
      </div>
    </div>
  </section>
  <!-- End of Booking section-->

</main>

<?php require_once 'partials/footer.php'; ?>