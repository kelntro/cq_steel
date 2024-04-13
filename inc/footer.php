<script>
  $(document).ready(function() {
    $('#p_use').click(function() {
      uni_modal("Privacy Policy", "policy.php", "mid-large")
    })
    window.viewer_modal = function($src = '') {
      start_loader()
      var t = $src.split('.')
      t = t[1]
      if (t == 'mp4') {
        var view = $("<video src='" + $src + "' controls autoplay></video>")
      } else {
        var view = $("<img src='" + $src + "' />")
      }
      $('#viewer_modal .modal-content video,#viewer_modal .modal-content img').remove()
      $('#viewer_modal .modal-content').append(view)
      $('#viewer_modal').modal({
        show: true,
        backdrop: 'static',
        keyboard: false,
        focus: true
      })
      end_loader()

    }
    window.uni_modal = function($title = '', $url = '', $size = "") {
      start_loader()
      $.ajax({
        url: $url,
        error: err => {
          console.log()
          alert("An error occured")
        },
        success: function(resp) {
          if (resp) {
            $('#uni_modal .modal-title').html($title)
            $('#uni_modal .modal-body').html(resp)
            if ($size != '') {
              $('#uni_modal .modal-dialog').addClass($size + '  modal-dialog-centered')
            } else {
              $('#uni_modal .modal-dialog').removeAttr("class").addClass("modal-dialog modal-md modal-dialog-centered")
            }
            $('#uni_modal').modal({
              show: true,
              backdrop: 'static',
              keyboard: false,
              focus: true
            })
            end_loader()
          }
        }
      })
    }
    window._conf = function($msg = '', $func = '', $params = []) {
      $('#confirm_modal #confirm').attr('onclick', $func + "(" + $params.join(',') + ")")
      $('#confirm_modal .modal-body').html($msg)
      $('#confirm_modal').modal('show')
    }
  })
</script>
        <!-- footer start -->
        <footer>
            <div class="footer-area box-90 pt-100 pb-60">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-3 col-lg-5 col-md-6 ">
                            <div class="footer-widget mb-40">
                                <div class="footer-logo">
                                    <a href="index.html"><img src="img/logo/logo.png" width="70" height="70" alt=""></a>
                                    <p>Elevating Homes, One Roof at a Time: Your Peak Partner in CQ-Steel Trading! 
                                </p>
                                  </div>                               
                                <div class="footer-time d-flex mt-30">
                                    <div class="time-icon">
                                        <img src="img/icon/time.png" alt="">
                                    </div>
                                    <div class="time-text">
                                        <span>Got Questions ? Contact us</span>
                                        <a href="./?p=contact" class="fas fa-phone"> Click here</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-3 d-lg-none d-xl-block">
                            <div class="footer-widget pl-50 mb-40">
                                <h3>Social Media</h3>
                                <ul class="footer-link">
                                    <li><a href="https://www.facebook.com/profile.php?id=100094070539719">Facebook</a></li>
                                    <li><a href="https://twitter.com/">Twitter</a></li>
                                    <li><a href="https://www.instagram.com/"> Instagram</a></li>
                                    <li><a href="https://www.youtube.com/">Youtube</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-3 d-lg-none d-xl-block">
                            <div class="footer-widget pl-30 mb-40">
                                <h3>Location</h3>
                                <ul class="footer-link">
                                    <li><a href="#">Davao</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-3">
                            <div class="footer-widget mb-40">
                                <h3>Others</h3>
                                <ul class="footer-link">
                                    <li><a href="#">Terms & Conditions</a></li>
                                    <li><a href="#"> Privacy Policy</a></li>
                                    <li><a href="./?p=contact">Contact Us</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-5 col-md-6">
                            <div class="footer-widget mb-40">
                                <div class="footer-banner">
                                    <a href="shop.html"><img src="img/banner/logo.png" alt=""></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="copyright-area box-105">
                <div class="container-fluid">
                    <div class="copyright-border pt-30 pb-30">
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6">
                                <div class="copyright text-center text-md-left">
                                    <p>Copyright © 2023 <a><?php echo $_settings->info('short_name') ?></a>. All Rights Reserved</p>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6">
                                <div class="footer-icon text-center text-md-right ">
                                    <a href="https://www.facebook.com/profile.php?id=100094070539719"><i class="fab fa-facebook-f"></i></a>
                                    <a href="#"><i class="fab fa-twitter"></i></a>
                                    <a href="#"><i class="fab fa-instagram"></i></a>
                                    <a href="#"><i class="fab fa-youtube"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- footer end -->


<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="<?php echo base_url ?>plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo base_url ?>plugins/sparklines/sparkline.js"></script>
<!-- Select2 -->
<script src="<?php echo base_url ?>plugins/select2/js/select2.full.min.js"></script>
<!-- JQVMap -->
<script src="<?php echo base_url ?>plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="<?php echo base_url ?>plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo base_url ?>plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?php echo base_url ?>plugins/moment/moment.min.js"></script>
<script src="<?php echo base_url ?>plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo base_url ?>plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="<?php echo base_url ?>plugins/summernote/summernote-bs4.min.js"></script>
<script src="<?php echo base_url ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url ?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url ?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url ?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- overlayScrollbars -->
<!-- <script src="<?php echo base_url ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script> -->
<!-- AdminLTE App -->
<script src="<?php echo base_url ?>dist/js/adminlte.js"></script>
