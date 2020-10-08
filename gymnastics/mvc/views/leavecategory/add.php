
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa iniicon-leavecategory"></i> <?=$this->lang->line('panel_title')?></h3>
        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li><a href="<?=base_url("leavecategory/index")?>"><?=$this->lang->line('menu_leavecategory')?></a></li>
            <li class="active"><?=$this->lang->line('menu_add')?> <?=$this->lang->line('menu_leavecategory')?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-10">
                <form class="form-horizontal" role="form" method="post">
                    <?php
                    if(form_error('leavecategory'))
                        echo "<div class='form-group has-error' >";
                    else
                        echo "<div class='form-group' >";
                    ?>
                        <label for="leavecategory" class="col-sm-2 control-label">
                            <?=$this->lang->line("leavecategory_category")?> <span class="text-red">*</span>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="leavecategory" name="leavecategory" value="<?=set_value('leavecategory')?>" >
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('leavecategory'); ?>
                        </span>
                    </div>

                    <?php
                        if(form_error('leavegender'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="leavegender" class="col-sm-2 control-label">
                            <?=$this->lang->line("leavecategory_gender")?> <span class="text-red">*</span>
                        </label>
                        <div class="col-sm-6">
                            <?php
                                $leavegenderArray = array(
                                    0 => $this->lang->line('leavecategory_select_gender'),
                                    1 => $this->lang->line('leavecategory_gender_general'),
                                    2 => $this->lang->line('leavecategory_gender_male'),
                                    3 => $this->lang->line('leavecategory_gender_female')
                                );
                                echo form_dropdown("leavegender", $leavegenderArray, set_value("leavegender"), "id='leavegender' class='form-control select2'");
                            ?>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('leavegender'); ?>
                        </span>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-8">
                            <input type="submit" class="btn btn-success" value="<?=$this->lang->line("add_leavecategory")?>" >
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