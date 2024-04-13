<style>
    .carousel-item>img {
        object-fit: fill !important;
    }

    #carouselExampleControls .carousel-inner {
        height: 280px !important;
    }
</style>
<?php
$type = isset($_GET['b']) ? json_decode(urldecode($_GET['b'])) : array();
?>
<?php
$title = "All Product Categories";
$sub_title = "";
if (isset($_GET['c']) && isset($_GET['s'])) {
    $cat_qry = $conn->query("SELECT * FROM categories where md5(id) = '{$_GET['c']}'");
    if ($cat_qry->num_rows > 0) {
        $title = $cat_qry->fetch_assoc()['category'];
    }
    $sub_cat_qry = $conn->query("SELECT * FROM sub_categories where md5(id) = '{$_GET['s']}'");
    if ($sub_cat_qry->num_rows > 0) {
        $sub_title = $sub_cat_qry->fetch_assoc()['sub_category'];
    }
} elseif (isset($_GET['c'])) {
    $cat_qry = $conn->query("SELECT * FROM categories where md5(id) = '{$_GET['c']}'");
    if ($cat_qry->num_rows > 0) {
        $title = $cat_qry->fetch_assoc()['category'];
    }
} elseif (isset($_GET['s'])) {
    $sub_cat_qry = $conn->query("SELECT * FROM sub_categories where md5(id) = '{$_GET['s']}'");
    if ($sub_cat_qry->num_rows > 0) {
        $title = $sub_cat_qry->fetch_assoc()['sub_category'];
    }
}
?>
<!-- breadcrumb-area-start -->
<section class="breadcrumb-area" data-background="img/bg/page-title.png">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="breadcrumb-text text-center">
                    <h1>CQ-STEEL TRADING</h1>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- breadcrumb-area-end -->
<!-- shop-area start -->
<section class="shop-area pt-100 pb-100">
    <div class="container">
        <div class="row">
            <div class="col-xl-8 col-lg-8">
                <!-- tab filter -->
                <div class="row mb-10">
                    <div class="col-xl-7 col-lg-6 col-md-6">
                        <div class="shop-tab f-right">
                            <ul class="nav text-center" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true"><i class="fas fa-list-ul"></i> </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- tab content -->
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
                <div class="shop-banner mb-50">
                    <img src="img/bg/roof-bg.png" alt="">
                </div>
                <!-- FILTER -->
                <!-- <div class="basic-pagination basic-pagination-2 text-center mt-20">
                    <ul>
                        <li><a href="#"><i class="fas fa-angle-double-left"></i></a></li>
                        <li class="active"><a href="#">01</a></li>
                        <li><a href="#">02</a></li>
                        <li><a href="#">03</a></li>
                        <li><a href="#"><i class="fas fa-angle-double-right"></i></a></li>
                    </ul>
                </div> -->
                <!-- FILTER END -->
            </div>
            <div class="col-xl-4 col-lg-4">
                <div class="sidebar-box">
                    <!-- SEARCH -->
                    <div class="shop-widget">
                        <h3 class="shop-title">Search by</h3>
                        <form class="shop-search" id="search-form">

                            <input type="search" placeholder="Search" aria-label="Search" name="search"  value="<?php echo isset($_GET['search']) ? $_GET['search'] : "" ?>"  aria-describedby="button-addon2">                
                            <button type="submit" id="button-addon2"><i class="fa fa-search"></i></button>

                        </form>
                    </div>
                    <!-- SEARCH END -->
                    <!-- CATEGORIES -->
                    <div class="shop-widget">
                        <h3 class="shop-title">Categories</h3>
                        <?php
                        $whereData = "";
                        $categories = $conn->query("SELECT * FROM `categories` where status = 1 order by category asc ");
                        while ($row = $categories->fetch_assoc()) :
                            foreach ($row as $k => $v) {
                                $row[$k] = trim(stripslashes($v));
                            }
                            $row['description'] = strip_tags(stripslashes(html_entity_decode($row['description'])));
                        ?>
                            <a href="./?p=products&c=<?php echo md5($row['id']) ?>" class="">
                                <div class="card-body p-4">
                                    <div class="">
                                        <!-- Product name-->
                                        <h5 class="fw-bolder border-bottom border-pink"><?php echo $row['category'] ?></h5>
                                    </div>
                                </div>
                            </a>
                        <?php endwhile; ?>
                    </div>
                    <!-- CATEGORIES END -->
                </div>
            </div>
        </div>
    </div>
</section>
<!-- shop-area end -->


</main>

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
<script>
  $(function(){
    $('#login-btn').click(function(){
      uni_modal("","login.php")
    })
    $('#navbarResponsive').on('show.bs.collapse', function () {
        $('#mainNav').addClass('navbar-shrink')
    })
    $('#navbarResponsive').on('hidden.bs.collapse', function () {
        if($('body').offset.top == 0)
          $('#mainNav').removeClass('navbar-shrink')
    })
  })

  $('#search-form').submit(function(e){
    e.preventDefault()
     var sTxt = $('[name="search"]').val()
     if(sTxt != '')
      location.href = './?p=products&search='+sTxt;
  })
</script>
<script src="js/main.js"></script>