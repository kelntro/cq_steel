<?php
$products = $conn->query("SELECT p.*,b.name as bname,c.category FROM `products` p inner join type b on p.brand_id = b.id inner join categories c on p.category_id = c.id where md5(p.id) = '{$_GET['id']}' ");
if ($products->num_rows > 0) {
    foreach ($products->fetch_assoc() as $k => $v) {
        $$k = stripslashes($v);
    }
    $upload_path = base_app . '/uploads/product_' . $id;
    $img = "";
    if (is_dir($upload_path)) {
        $fileO = scandir($upload_path);
        if (isset($fileO[2]))
            $img = "uploads/product_" . $id . "/" . $fileO[2];
        // var_dump($fileO);
    }
    $inventory = $conn->query("SELECT * FROM inventory where product_id = " . $id . " order by variant asc");
    $inv = array();
    while ($ir = $inventory->fetch_assoc()) {
        $ir['price'] = format_num($ir['price']);
        $ir['stock'] = $ir['quantity'];
        $sold = $conn->query("SELECT sum(quantity) FROM `order_list` where inventory_id = '{$ir['id']}' and order_id in (SELECT order_id from `sales`)")->fetch_array()[0];
        $sold = $sold > 0 ? $sold : 0;
        $ir['stock'] = $ir['stock'] - $sold;
        $inv[] = $ir;
    }
}

?>
<style>
    .variant-item.active {
        border-color: var(--pink) !important;
    }

    .variant-item {
        cursor: pointer !important;
    }
</style>
<!-- breadcrumb-area-start -->
<section class="breadcrumb-area" data-background="img/bg/page-title.png">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="breadcrumb-text text-center">
                    <h1>Our Shop</h1>
                    <ul class="breadcrumb-menu">
                        <li><a href="index.php">home</a></li>
                        <li><span>shop details</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- breadcrumb-area-end -->
<!-- shop-area start -->
<section class="shop-details-area pt-100 pb-100">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 col-lg-4">
                <div class="product-details-img mb-10">
                    <div class="tab-content" id="myTabContentpro">
                        <div class="tab-pane fade show active" id="home" role="tabpanel">
                            <div class="product-large-img">
                                <img id="display-img" src="<?php echo validate_image($img) ?>" alt="..." />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="shop-thumb-tab mb-30">
                    <ul class="nav" id="myTab2" role="tablist">
                        <li class="nav-item">
                            <?php
                            foreach ($fileO as $k => $img) :
                                if (in_array($img, array('.', '..')))
                                    continue;
                            ?>
                                <a href="javascript:void(0)" class="nav-link active <?php echo $k == 2 ? "active" : '' ?>"><img src="<?php echo validate_image('uploads/product_' . $id . '/' . $img) ?>" id="home-tab" data-toggle="tab" role="tab" aria-selected="true">> </a>
                            <?php endforeach; ?>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-xl-6 col-lg-8">
                <div class="product-details mb-30 pl-30">
                    <h2><?php echo $name ?></h2>
                    <div class="details-price mb-20">
                        <span>₱<?php echo isset($inv[0]['price']) ?  format_num($inv[0]['price']) : "--" ?></span>
                    </div>
                    <div class="product-variant">
                        <div class="product-info-list ">
                            <ul>
                                <li><span>Type:</span><?php echo $bname ?></li>
                                <li><span>Color:</span>
                                    <?php
                                    $active = false;
                                    foreach ($inv as $k => $v) :
                                    ?>
                                        <span class="<?= (!$active) ? "active" : "" ?>" data-key="<?= $k ?>"><?= $v['variant'] ?></span>
                                    <?php
                                        $active = true;
                                    endforeach;
                                    ?>
                                </li>
                                <li><span>Category:</span><?php echo $category ?></li>
                                <li><span>Stock:</span> <span class="in-stock"><?php echo isset($inv[0]['stock']) ? format_num($inv[0]['stock']) : "--" ?></span></li>
                            </ul>
                        </div>

                        <div class="product-action-details">
                            <div class="product-details-action">
                                <form action="" id="add-cart">
                                    <div class="plus-minus">
                                        <input type="hidden" name="price" value="<?php echo isset($inv[0]['price']) ? $inv[0]['price'] : 0 ?>">
                                        <input type="hidden" name="inventory_id" value="<?php echo isset($inv[0]['id']) ? $inv[0]['id'] : '' ?>">
                                        <input class="form-control text-center me-3" id="inputQuantity" type="num" value="1" style="max-width: 3rem" name="quantity" />
                                    </div>
                                    <div class="details-cart mt-40">
                                        <button class="btn theme-btn" type="submit">purchase now</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-50">
            <div class="col-xl-8 col-lg-8">
                <div class="product-review">
                    <ul class="nav review-tab" id="myTabproduct" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab6" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true">Description </a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent2">
                        <div class="tab-pane fade show active" id="home6" role="tabpanel" aria-labelledby="home-tab6">
                            <div class="desc-text">
                                <p class="lead"><?php echo stripslashes(html_entity_decode($specs)) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4">
                <div class="pro-details-banner">
                    <a><img src="img/banner/bg2.png" alt=""></a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- shop-area end -->

<!-- product-area start -->
<section class="product-area pb-100">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="area-title text-center mb-50">
                    <h2>Related Products</h2>
                    <p>Browse the variety of roof products</p>
                </div>
            </div>
        </div>
        <div class="product-slider-2 owl-carousel">
            <?php
            $products = $conn->query("SELECT p.*,b.name as bname,c.category  FROM `products` p inner join type b on p.brand_id = b.id inner join categories c on p.category_id = c.id where p.status = 1 and (p.category_id = '{$category_id}' or p.brand_id = '{$brand_id}') and p.id !='{$id}' order by rand() limit 4 ");
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
                $rinventory = $conn->query("SELECT distinct(`price`) FROM inventory where product_id = " . $row['id'] . " order by `price` asc");
                $rinv = array();
                while ($ir = $rinventory->fetch_assoc()) {
                    $rinv[] = format_num($ir['price']);
                }
                $price = '';
                if (isset($rinv[0]))
                    $price .= $rinv[0];
                if (count($rinv) > 1) {
                    $price .= " ~ " . $rinv[count($rinv) - 1];
                }
            ?>
                <div class="pro-item">
                    <div class="product-wrapper">
                        <div class="product-img mb-25">
                            <a href="#">
                                <img src="<?php echo validate_image($img) ?>" alt="product" />
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
</section>
<!-- product-area end -->

<script>
    var inv = $.parseJSON('<?php echo json_encode($inv) ?>');
    $(function() {
        $('.view-image').click(function() {
            var _img = $(this).find('img').attr('src');
            $('#display-img').attr('src', _img);
            $('.view-image').removeClass("active")
            $(this).addClass("active")
        })
        $('.variant-item').click(function() {
            var k = $(this).attr('data-key');
            $('.variant-item').removeClass("active")
            $(this).addClass("active")
            if (!!inv[k]) {
                $('#price').text(inv[k].price)
                $('[name="price"]').val(inv[k].price)
                $('#avail').text(inv[k].stock)
                $('[name="inventory_id"]').val(inv[k].id)
            } else {
                alert_toast("An error occured", 'error')
            }

        })

        $('#add-cart').submit(function(e) {
            e.preventDefault();
            if ('<?= $_settings->userdata('id') > 0 || $_settings->userdata('login_type') == 2 ?>' != '1') {
                uni_modal("", "login.php");
                return false;
            }

            // Get the entered quantity
            var quantity = parseInt($('#inputQuantity').val());

            // Check if the entered quantity exceeds available stock
            if (quantity > <?= isset($inv[0]['stock']) ? $inv[0]['stock'] : 0 ?>) {
                alert_toast("Quantity exceeds available stock.", 'error');
                return;
            }

            start_loader();
            $.ajax({
                url: 'classes/Master.php?f=add_to_cart',
                data: $(this).serialize(),
                method: 'POST',
                dataType: "json",
                error: err => {
                    console.log(err);
                    alert_toast("An error occurred", 'error');
                    end_loader();
                },
                success: function(resp) {
                    if (typeof resp == 'object' && resp.status == 'success') {
                        alert_toast("Product added to cart.", 'success');
                        $('#cart-count').text(resp.cart_count);
                    } else {
                        console.log(resp);
                        alert_toast("An error occurred", 'error');
                    }
                    end_loader();
                }
            })
        })
    })
</script>
<script src="js/main.js"></script>