<header>
  <div id="header-sticky" class="header-area box-90">
    <div class="container-fluid">
      <div class="row align-items-center">
        <div class="col-xl-2 col-lg-6 col-md-6 col-7 col-sm-5 d-flex align-items-center pos-relative">
          <div class="logo">
            <a href="./"><img src="<?php echo validate_image($_settings->info('logo')) ?>" width="70" height="70" alt=""></a>
          </div>
        </div>

        <div class="col-xl-8 col-lg-6 col-md-8 col-8 d-none d-xl-block">
          <div class="main-menu text-center">
            <nav id="mobile-menu">
              <!-- Navbar -->
              <ul>
                <li>
                  <a aria-current="page" href="./">Home</a>
                </li>
                <li>
                  <a href="./?p=view_categories">Shop</a>
                </li>
                <li>
                  <a href="./?p=about">About</a>
                </li>
                <li>
                  <a href="./?p=contact">Contact Us</a>
                </li>
              </ul>
            </nav>
          </div>
        </div>

        <div class="">
          <div class="">
            <!-- LOGIN -->
            <div class="d-flex align-items-center">
              <?php if ($_settings->userdata('id') > 0 && $_settings->userdata('login_type') == 2) : ?>
                <a class="text-dark mr-2 nav-link text-white" href="./?p=cart">
                  <i class="bi-cart-fill me-1"></i>
                  Cart
                  <span class="badge bg-dark text-white ms-1 rounded-pill" id="cart-count">
                    <?php
                    $count = $conn->query("SELECT SUM(quantity) as items from `cart` where client_id =" . $_settings->userdata('id'))->fetch_assoc()['items'];
                    echo ($count > 0 ? $count : 0);
                    ?>
                  </span>
                </a>

                <a href="./?p=my_account" class="text-dark  nav-link text-white"><b><i class="far fa-user"></i></b></a>
                <a href="logout.php" class="text-dark  nav-link text-white"><i class="fa fa-sign-out-alt"></i></a>
              <?php else : ?>
                <button class="btn btn-outline-dark ml-2" id="login-btn" type="button">Login</button>
              <?php endif; ?>
            </div>
            <!-- LOGIN -->
          </div>
        </div>

        <div class="col-12 d-xl-none">
          <div class="mobile-menu"></div>
        </div>
      </div>
    </div>
    <!-- SEARCH -->

    <!-- SEARCH -->
  </div>
</header>

<!-- JS here -->
<script src="js/vendor/jquery-1.12.4.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/isotope.pkgd.min.js"></script>
<script src="js/one-page-nav-min.js"></script>
<script src="js/slick.min.js"></script>
<script src="js/jquery.meanmenu.min.js"></script>
<script src="js/ajax-form.js"></script>
<script src="js/wow.min.js"></script>
<script src="js/jquery.scrollUp.min.js"></script>
<script src="js/jquery.final-countdown.min.js"></script>
<script src="js/imagesloaded.pkgd.min.js"></script>
<script src="js/jquery.magnific-popup.min.js"></script>
<script src="js/plugins.js"></script>

<script>
  $(function() {
    $('#login-btn').click(function() {
      uni_modal("", "login.php")
    })
    $('#navbarResponsive').on('show.bs.collapse', function() {
      $('#mainNav').addClass('navbar-shrink')
    })
    $('#navbarResponsive').on('hidden.bs.collapse', function() {
      if ($('body').offset.top == 0)
        $('#mainNav').removeClass('navbar-shrink')
    })
  })

  $('#search-form').submit(function(e) {
    e.preventDefault()
    var sTxt = $('[name="search"]').val()
    if (sTxt != '')
      location.href = './?p=products&search=' + sTxt;
  })
</script>