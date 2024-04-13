<?php
$type = isset($_GET['b']) ? json_decode(urldecode($_GET['b'])) : array();
?>

<!-- slider-area start -->
<section class="slider-area pos-relative">
    <div class="slider-active">
        <div class="single-slider slide-1-style slide-height d-flex align-items-center" data-background="img/slider/bamboo-sliderr.png">
            <div class="shape-icon bounce-animate">
                <img src="img/slider/shape-icon.png" alt="">
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-7">
                        <div class="slide-content">
                            <h1 data-animation="fadeInUp" data-delay=".5s">CQ-STEEL Trading</h1>
                        </div>
                    </div>
                    <div class="col-xl-5">
                        <div class="slide-shape1" data-animation="bounceInRight" data-delay=".9s"><img src="img/slider/bambooo.png" alt=""></div>
                        <div class="slide-shape2" data-animation="bounceInRight" data-delay="1.2s"><img src="img/slider/bamboo1.png" alt=""></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="single-slider slide-1-style slide-height d-flex align-items-center" data-background="img/slider/gutter-slider.png">
            <div class="shape-icon bounce-animate">
                <img src="img/slider/shape-icon.png" alt="">
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-7">
                        <div class="slide-content">
                            <h1 data-animation="fadeInUp" data-delay=".5s">CQ-STEEL Trading</h1>
                        </div>
                    </div>
                    <div class="col-xl-5">
                        <div class="slide-shape1" data-animation="bounceInRight" data-delay=".9s"><img src="img/slider/gutter.png" alt=""></div>
                        <div class="slide-shape2" data-animation="bounceInRight" data-delay="1.2s"><img src="img/slider/gutter1.png" alt=""></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="single-slider slide-1-style slide-height d-flex align-items-center" data-background="img/slider/ribspan-slider.png">
            <div class="shape-icon bounce-animate">
                <img src="img/slider/shape-icon.png" alt="">
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-7">
                        <div class="slide-content">
                            <h1 data-animation="fadeInUp" data-delay=".5s">CQ-STEEL Trading</h1>
                        </div>
                    </div>
                    <div class="col-xl-5">
                        <div class="slide-shape1" data-animation="bounceInRight" data-delay=".9s"><img src="img/slider/ribspan.png" alt=""></div>
                        <div class="slide-shape2" data-animation="bounceInRight" data-delay="1.2s"><img src="img/slider/ribspan1.png" alt=""></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- slider-area end -->
<main>

    <!-- product-area start -->
    <section class="product-area box-90 pt-70 pb-40">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-5 col-lg-12">
                    <div class="area-title mb-50">
                        <h2>Roof Products</h2>
                        <p>Browse the variety of Roof</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="product-tab-content">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <div class="product-slider owl-carousel">
                                    <?php
                                    $where = "";
                                    if (count($type) > 0)
                                        $where = " and p.brand_id in (" . implode(",", $type) . ") ";
                                    $products = $conn->query("SELECT p.*,b.name as bname,c.category FROM `products` p inner join type b on p.brand_id = b.id inner join categories c on p.category_id = c.id where p.status = 1 {$where} order by rand() ");
                                    while ($row = $products->fetch_assoc()) :
                                        $upload_path = base_app . '/uploads/product_' . $row['id'];
                                        $img = "";
                                        if (is_dir($upload_path)) {
                                            $fileO = scandir($upload_path);
                                            if (isset($fileO[2]))
                                                $img = "uploads/product_" . $row['id'] . "/" . $fileO[2];
                                            // var_dump($fileO);
                                        }
                                        foreach ($row as $k => $v) {
                                            $row[$k] = trim(stripslashes($v));
                                        }
                                        $inventory = $conn->query("SELECT distinct(`price`) FROM inventory where product_id = " . $row['id'] . " order by `price` asc");
                                        $inv = array();
                                        while ($ir = $inventory->fetch_assoc()) {
                                            $inv[] = format_num($ir['price']);
                                        }
                                        $price = '';
                                        if (isset($inv[0]))
                                            $price .= $inv[0];
                                        if (count($inv) > 1) {
                                            $price .= " ~ " . $inv[count($inv) - 1];
                                        }
                                    ?>
                                        <div class="pro-item">
                                            <div class="product-wrapper mb-50">

                                                <div class="product-img mb-25">
                                                    <a href="#">
                                                        <img src="<?php echo validate_image($img) ?>" alt="product">
                                                    </a>
                                                    <div class="product-action text-center">
                                                        <a href=".?p=view_product&id=<?php echo md5($row['id']) ?>" title="Quick View">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="product-content">
                                                    <div class="pro-cat mb-10">
                                                        <a><?php echo $row['bname'] ?></a>
                                                        <a><?php echo $row['category'] ?></a>
                                                    </div>
                                                    <h4>
                                                        <a><?php echo $row['name'] ?></a>
                                                    </h4>
                                                    <div class="product-meta">
                                                        <div class="pro-price">
                                                            <span>₱<?php echo $price ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endwhile; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- product-area end -->

    <section class="instagram-area pos-relative">
        <div class="instagram-active owl-carousel">
            <div class="instagram-item">
                <img src="img/instagram/roof3.jpg" alt="">
            </div>
            <div class="instagram-item">
                <img src="img/instagram/roof2.jpg" alt="">
            </div>
            <div class="instagram-item">
                <img src="img/instagram/roof3.jpg" alt="">
            </div>
            <div class="instagram-item">
                <img src="img/instagram/roof4.jpg" alt="">
            </div>
            <div class="instagram-item">
                <img src="img/instagram/roof5.jpg" alt="">
            </div>
        </div>
        <div class="instagram-btn">
            <a href="https://www.facebook.com/profile.php?id=100094070539719" class="btn white-btn"><i class="fab fa-facebook"></i> <?php echo $_settings->info('short_name') ?></a>
        </div>
    </section>



    <script>
        function _filter() {
            var type = []
            $('.brand-item:checked').each(function() {
                type.push($(this).val())
            })
            _b = JSON.stringify(type)
            var checked = $('.brand-item:checked').length
            var total = $('.brand-item').length
            if (checked == total)
                location.href = "./?";
            else
                location.href = "./?b=" + encodeURI(_b);
        }

        function check_filter() {
            var checked = $('.brand-item:checked').length
            var total = $('.brand-item').length
            if (checked == total) {
                $('#brandAll').attr('checked', true)
            } else {
                $('#brandAll').attr('checked', false)
            }
            if ('<?php echo isset($_GET['b']) ?>' == '')
                $('#brandAll,.brand-item').attr('checked', true)
        }
        $(function() {
            check_filter()
            $('#brandAll').change(function() {
                if ($(this).is(':checked') == true) {
                    $('.brand-item').attr('checked', true)
                } else {
                    $('.brand-item').attr('checked', false)
                }
                _filter()
            })
            $('.brand-item').change(function() {
                _filter()
            })
        })
    </script>
    <script src="js/main.js"></script>