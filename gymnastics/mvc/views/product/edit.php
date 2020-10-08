
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa iniicon-product"></i> <?=$this->lang->line('panel_title')?></h3>
        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li><a href="<?=base_url("product/index")?>"><?=$this->lang->line('menu_product')?></a></li>
            <li class="active"><?=$this->lang->line('menu_edit')?> <?=$this->lang->line('menu_product')?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-10">
                <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                    <div class="form-group <?= form_error('photo') ? 'has-error' : '' ?>" >
                        <label for="photo" class="col-sm-2 control-label">
                            <?= $this->lang->line("product_photo") ?>
                        </label>
                        <div class="col-sm-6">
                            <input type="file" class="form-control" accept="image/png, image/jpeg, image/gif" name="photo" readonly="readonly">
                        </div>
                        <span class="col-sm-4">
                            <?php echo form_error('photo'); ?>
                        </span>
                    </div>
                    
                    <div class="form-group <?=form_error('productname') ? 'has-error' : '' ?>" >
                        <label for="productname" class="col-sm-2 control-label">
                            <?=$this->lang->line("product_product")?> <span class="text-red">*</span>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="productname" name="productname" value="<?=set_value('productname', $product->productname)?>" >
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('productname'); ?>
                        </span>
                    </div>

                    <div class="form-group <?= form_error('productsize') ? 'has-error' : '' ?>" >
                        <label for="productsize" class="col-sm-2 control-label">
                            <?= $this->lang->line("product_size") ?>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="productsize" name="productsize" value="<?= set_value('productsize', $product->productsize) ?>" >
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('productsize'); ?>
                        </span>
                    </div>
                    <div class="form-group <?= form_error('productcolor') ? 'has-error' : '' ?>" >
                        <label for="productcolor" class="col-sm-2 control-label">
                            <?= $this->lang->line("product_color") ?>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="productcolor" name="productcolor" value="<?= set_value('productcolor', $product->productcolor) ?>" >
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('productcolor'); ?>
                        </span>
                    </div>

                    <div class="form-group <?=form_error('productcategoryID') ? 'has-error' : '' ?>" >
                        <label for="productcategoryID" class="col-sm-2 control-label">
                            <?=$this->lang->line("product_category")?> <span class="text-red">*</span>
                        </label>
                        <div class="col-sm-6">
                            <?php
                                $productcategoryArray[0] = $this->lang->line("product_select_category");
                                foreach ($productcategorys as $productcategory) {
                                    $productcategoryArray[$productcategory->productcategoryID] = $productcategory->productcategoryname;
                                }
                                echo form_dropdown("productcategoryID", $productcategoryArray, set_value("productcategoryID", $product->productcategoryID), "id='productcategoryID' class='form-control select2'");
                            ?>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('productcategoryID'); ?>
                        </span>
                    </div>

                    <div class="form-group <?=form_error('productbuyingprice') ? 'has-error' : '' ?>" >
                        <label for="productbuyingprice" class="col-sm-2 control-label">
                            <?=$this->lang->line("product_buyingprice")?> <span class="text-red">*</span>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="productbuyingprice" name="productbuyingprice" value="<?=set_value('productbuyingprice', $product->productbuyingprice)?>"></textarea>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('productbuyingprice'); ?>
                        </span>
                    </div>

                    <div class="form-group <?=form_error('productsellingprice') ? 'has-error' : '' ?>" >
                        <label for="productsellingprice" class="col-sm-2 control-label">
                            <?=$this->lang->line("product_sellingprice")?> <span class="text-red">*</span>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="productsellingprice" name="productsellingprice" value="<?=set_value('productsellingprice', $product->productsellingprice)?>">
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('productsellingprice'); ?>
                        </span>
                    </div>

                    <div class="form-group <?=form_error('productdesc') ? 'has-error' : '' ?>" >
                        <label for="productdesc" class="col-sm-2 control-label">
                            <?=$this->lang->line("product_desc")?>
                        </label>
                        <div class="col-sm-6">
                            <textarea class="form-control" style="resize:none;" id="productdesc" name="productdesc"><?=set_value('productdesc', $product->productdesc)?></textarea>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('productdesc'); ?>
                        </span>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-8">
                            <input type="submit" class="btn btn-success" value="<?=$this->lang->line("update_product")?>" >
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('.select2').select2();
</script>
