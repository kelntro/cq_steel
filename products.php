<?php
$title = "";
$sub_title = "";
if (isset($_GET['c']) && isset($_GET['s'])) {
    $cat_qry = $conn->query("SELECT * FROM categories where md5(id) = '{$_GET['c']}'");
    if ($cat_qry->num_rows > 0) {
        $result = $cat_qry->fetch_assoc();
        $title = $result['category'];
        $cat_description = $result['description'];
    }
    $sub_cat_qry = $conn->query("SELECT * FROM sub_categories where md5(id) = '{$_GET['s']}'");
    if ($sub_cat_qry->num_rows > 0) {
        $result = $sub_cat_qry->fetch_assoc();
        $sub_title = $result['sub_category'];
        $sub_cat_description = $result['description'];
    }
} elseif (isset($_GET['c'])) {
    $cat_qry = $conn->query("SELECT * FROM categories where md5(id) = '{$_GET['c']}'");
    if ($cat_qry->num_rows > 0) {
        $result = $cat_qry->fetch_assoc();
        $title = $result['category'];
        $cat_description = $result['description'];
    }
} elseif (isset($_GET['s'])) {
    $sub_cat_qry = $conn->query("SELECT * FROM sub_categories where md5(id) = '{$_GET['s']}'");
    if ($sub_cat_qry->num_rows > 0) {
        $result = $sub_cat_qry->fetch_assoc();
        $sub_title = $result['sub_category'];
        $sub_cat_description = $result['description'];
    }
}
$type = isset($_GET['b']) ? json_decode(urldecode($_GET['b'])) : array();
?>


<!-- shop-area start -->
<section class="shop-area pt-100 pb-100">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <!-- search results -->
                <?php if (isset($_GET['search'])) : ?>
                    <h4 class="text-center py-5"><b>Search Results for '<?php echo $_GET['search'] ?>'</b></h4>
                <?php endif; ?>
                <!-- search results -->
                <!-- tab filter -->
                <div class="row mb-10">
                    <div class="col-xl-7 col-lg-6 col-md-6">
                        <div class="shop-tab f-right">
                            <ul class="nav text-center" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true"><i class="fas fa-list-ul"></i> </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- tab content -->
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="row">
                        <?php 
                            $whereData = "";
                            if(isset($_GET['search']))
                                $whereData = " and (p.name LIKE '%{$_GET['search']}%' or b.name LIKE '%{$_GET['search']}%' or p.specs LIKE '%{$_GET['search']}%')";
                            elseif(isset($_GET['c']) && isset($_GET['s']))
                                $whereData = " and (md5(category_id) = '{$_GET['c']}' and md5(sub_category_id) = '{$_GET['s']}')";
                            elseif(isset($_GET['c']) && !isset($_GET['s']))
                                $whereData = " and md5(category_id) = '{$_GET['c']}' ";
                            elseif(isset($_GET['s']) && !isset($_GET['c']))
                                $whereData = " and md5(sub_category_id) = '{$_GET['s']}' ";
                            $bwhere = "";
                            if(count($type)>0)
                                $bwhere = " and p.brand_id in (".implode(",",$type).") " ;
                            $products = $conn->query("SELECT p.*,b.name as bname, c.category FROM `products` p inner join type b on p.brand_id = b.id inner join categories c on p.category_id = c.id where p.status = 1 {$whereData} {$bwhere} order by rand() ");
                            while($row = $products->fetch_assoc()):
                                $upload_path = base_app.'/uploads/product_'.$row['id'];
                                $img = "";
                                if(is_dir($upload_path)){
                                    $fileO = scandir($upload_path);
                                    if(isset($fileO[2]))
                                        $img = "uploads/product_".$row['id']."/".$fileO[2];
                                    // var_dump($fileO);
                                }
                                foreach($row as $k=> $v){
                                    $row[$k] = trim(stripslashes($v));
                                }
                                $inventory = $conn->query("SELECT distinct(`price`) FROM inventory where product_id = ".$row['id']." order by `price` asc");
                                $inv = array();
                                while($ir = $inventory->fetch_assoc()){
                                    $inv[] = format_num($ir['price']);
                                }
                                $price = '';
                                if(isset($inv[0]))
                                $price .= $inv[0];
                                if(count($inv) > 1){
                                $price .= " ~ ".$inv[count($inv) - 1];

                                }
                        ?>
                            <div class="col-lg-4 col-md-6">                               
                                <div class="product-wrapper mb-50">
                                    <div class="product-img mb-25">
                                        <a href="#">
                                            <img src="<?php echo validate_image($img) ?>" alt="..." />
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
                        <?php 
                            if($products->num_rows <= 0){
                                echo "<h4 class='text-center'><b>No Product Listed.</b></h4>";
                            }
                        ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- shop-area end -->



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
            location.href = "./?p=products<?= isset($_GET['c']) ? "&c=" . $_GET['c'] : "" ?>";
        else
            location.href = "./?p=products<?= isset($_GET['c']) ? "&c=" . $_GET['c'] : "" ?>&b=" + encodeURI(_b);
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