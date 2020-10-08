<link href="<?= base_url('assets/editor.css'); ?>" type="text/css" rel="stylesheet"/>
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa fa-star"></i> <?=$this->lang->line('panel_title')?></h3>


        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li><a href="<?=base_url("section/index")?>"></i><?=$this->lang->line('menu_section')?></a></li>
            <li class="active"><?=$this->lang->line('menu_add')?> <?=$this->lang->line('menu_section')?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-10">
                <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">

<?php
                        if(form_error('photo'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="photo" class="col-sm-2 control-label">
                            <?=$this->lang->line("section_photo")?>
                        </label>
                        <div class="col-sm-6">
                            <div class="input-group image-preview">
                                <input type="text" class="form-control image-preview-filename" style="height: 34px;" disabled="disabled">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default image-preview-clear" style="display:none;">
                                        <span class="fa fa-remove"></span>
                                        <?=$this->lang->line('section_clear')?>
                                    </button>
                                    <div class="btn btn-success image-preview-input">
                                        <span class="fa fa-repeat"></span>
                                        <span class="image-preview-input-title">
                                        <?=$this->lang->line('section_file_browse')?></span>
                                        <input type="file" accept="image/png, image/jpeg, image/gif" name="photo"/>
                                    </div>
                                </span>
                            </div>
                        </div>
            </div>
            
                    <?php
                        if(form_error('section'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="section" class="col-sm-2 control-label">
                            <?=$this->lang->line("section_name")?> <span class="text-red">*</span>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="section" name="section" value="<?=set_value('section')?>" >
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('section'); ?>
                        </span>
                    </div>

                    <?php
                        if(form_error('capacity'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="capacity" class="col-sm-2 control-label">
                            <?=$this->lang->line("section_capacity")?> <span class="text-red">*</span>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="capacity" name="capacity" value="<?=set_value('capacity')?>" >
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('capacity'); ?>
                        </span>
                    </div>

                    <?php
                        if(form_error('classesID'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="classesID" class="col-sm-2 control-label">
                            <?php
                                if($siteinfos->school_type == 'classbase') {
                                    echo $this->lang->line("section_classes"). ' <span class="text-red">*</span>';
                                    $array = array();
                                    $array[0] = $this->lang->line("section_select_class");
                                } else {
                                    $array = array();
                                    $array[0] = $this->lang->line("section_select_department");
                                    echo $this->lang->line("section_department");
                                }
                            ?>
                        </label>
                        <div class="col-sm-6">

                            <?php
                                foreach ($classes as $classa) {
                                    $array[$classa->classesID] = $classa->classes;
                                }
                                echo form_dropdown("classesID", $array, set_value("classesID"), "id='classesID' class='form-control select2'");
                            ?>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('classesID'); ?>
                        </span>
                    </div>

                    <?php
                        if(form_error('firsTeacherID'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="firsTeacherID" class="col-sm-2 control-label">
                            <?=$this->lang->line("section_teacher_name_first")?> <span class="text-red">*</span>
                        </label>
                        <div class="col-sm-6">

                            <?php
                                $array = array();
                                $array[0] = $this->lang->line("section_select_teacher");

                                foreach ($teachers as $teacher) {
                                    $array[$teacher->teacherID] = $teacher->name;
                                }
                                echo form_dropdown("firsTeacherID", $array, set_value("firsTeacherID"), "id='firsTeacherID' class='form-control select2 js-example-basic-multiple'");
                            ?>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('firsTeacherID'); ?>
                        </span>
                    </div>
                    <?php
                        if(form_error('secondTeacherID'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="secondTeacherID" class="col-sm-2 control-label">
                            <?=$this->lang->line("section_teacher_name_second")?>
                        </label>
                        <div class="col-sm-6">

                            <?php
                                $array = array();
                                $array[0] = $this->lang->line("section_select_teacher");

                                foreach ($teachers as $teacher) {
                                    $array[$teacher->teacherID] = $teacher->name;
                                }
                                echo form_dropdown("secondTeacherID", $array, set_value("secondTeacherID"), "id='secondTeacherID' class='form-control select2 js-example-basic-multiple'");
                            ?>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('secondTeacherID'); ?>
                        </span>
                    </div>
                    <?php
                        if(form_error('thirdTeacherID'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="thirdTeacherID" class="col-sm-2 control-label">
                            <?=$this->lang->line("section_teacher_name_third")?>
                        </label>
                        <div class="col-sm-6">

                            <?php
                                $array = array();
                                $array[0] = $this->lang->line("section_select_teacher");

                                foreach ($teachers as $teacher) {
                                    $array[$teacher->teacherID] = $teacher->name;
                                }
                                echo form_dropdown("thirdTeacherID", $array, set_value("thirdTeacherID"), "id='thirdTeacherID' class='form-control select2 js-example-basic-multiple'");
                            ?>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('thirdTeacherID'); ?>
                        </span>
                    </div>
                    <?php
                        if(form_error('goalkeeper_coach'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="goalkeeper_coach" class="col-sm-2 control-label">
                            <?=$this->lang->line("goalkeeper_coach")?>
                        </label>
                        <div class="col-sm-6">

                            <?php
                                $array = array();
                                $array[0] = $this->lang->line("select_goalkeeper_coach");

                                foreach ($teachers as $teacher) {
                                    $array[$teacher->teacherID] = $teacher->name;
                                }
                                echo form_dropdown("goalkeeper_coach", $array, set_value("goalkeeper_coach"), "id='goalkeeper_coach' class='form-control select2 js-example-basic-multiple'");
                            ?>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('goalkeeper_coach'); ?>
                        </span>
                    </div>
                    
                    <?php
                        if(form_error('supervisor'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="supervisor" class="col-sm-2 control-label">
                            <?=$this->lang->line("supervisor")?>
                        </label>
                        <div class="col-sm-6">

                            <?php
                                $array = array();
                                $array[0] = $this->lang->line("select_supervisor");

                                foreach ($supervisors as $supervisor) {
                                    $array[$supervisor->userID] = $supervisor->name;
                                }
                                foreach ($supervisorsT as $supervisort) {
                                    $array[$supervisort->teacherID] = $supervisort->name;
                                }
                                echo form_dropdown("supervisor", $array, set_value("supervisor"), "id='supervisor' class='form-control select2 js-example-basic-multiple'");
                            ?>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('supervisor'); ?>
                        </span>
                    </div>
                    <?php
                        if(form_error('supervisor2'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="supervisor2" class="col-sm-2 control-label">
                            <?=$this->lang->line("supervisor2")?>
                        </label>
                        <div class="col-sm-6">

                            <?php
                                $array = array();
                                $array[0] = $this->lang->line("select_supervisor");

                                foreach ($supervisors as $supervisor) {
                                    $array[$supervisor->userID] = $supervisor->name;
                                }
                                foreach ($supervisorsT as $supervisort) {
                                    $array[$supervisort->teacherID] = $supervisort->name;
                                }
                                echo form_dropdown("supervisor2", $array, set_value("supervisor2"), "id='supervisor2' class='form-control select2 js-example-basic-multiple'");
                            ?>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('supervisor2'); ?>
                        </span>
                    </div>
                    
                    <?php
                        if(form_error('monthlyFees'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="monthlyFees" class="col-sm-2 control-label">
                            <?=$this->lang->line("section_monthly_fees")?> <span class="text-red">*</span>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="monthlyFees" name="monthlyFees" value="<?=set_value('monthlyFees')?>" >
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('monthlyFees'); ?>
                        </span>
                    </div>
                    
                    <?php
                        if(form_error('note'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="note" class="col-sm-2 control-label">
                            <?=$this->lang->line("section_note")?>
                        </label>
                        <div class="col-sm-6">
                            <textarea class="form-control" id="note" name="note"><?=set_value('note')?></textarea>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('note'); ?>
                        </span>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-8">
                            <input type="submit" class="btn btn-success" value="<?=$this->lang->line("add_section")?>" >
                        </div>
                    </div>

                </form>
                <?php if ($siteinfos->note==1) { ?>
                    <div class="callout callout-danger">
                        <p><b>Note:</b> Create a Group and a Coach before creating a new section</p>
                    </div>
                <?php } ?>

            </div>
        </div>
    </div>
</div>
<script src="<?= base_url('assets/editor.js'); ?>"></script>
<script>
$( ".select2" ).select2( { placeholder: "", maximumSelectionSize: 6 } );

    $(document).ready(function() {
        $("#note").Editor();
    });


$(document).on('click', '#close-preview', function(){
    $('.image-preview').popover('hide');
    // Hover befor close the preview
    $('.image-preview').hover(
        function () {
           $('.image-preview').popover('show');
           $('.content').css('padding-bottom', '100px');
        },
         function () {
           $('.image-preview').popover('hide');
           $('.content').css('padding-bottom', '20px');
        }
    );
});

$(function() {
    // Create the close button
    var closebtn = $('<button/>', {
        type:"button",
        text: 'x',
        id: 'close-preview',
        style: 'font-size: initial;',
    });
    closebtn.attr("class","close pull-right");
    // Set the popover default content
    $('.image-preview').popover({
        trigger:'manual',
        html:true,
        title: "<strong>Preview</strong>"+$(closebtn)[0].outerHTML,
        content: "There's no image",
        placement:'bottom'
    });
    // Clear event
    $('.image-preview-clear').click(function(){
        $('.image-preview').attr("data-content","").popover('hide');
        $('.image-preview-filename').val("");
        $('.image-preview-clear').hide();
        $('.image-preview-input input:file').val("");
        $(".image-preview-input-title").text("<?=$this->lang->line('section_file_browse')?>");
    });
    // Create the preview image
    $(".image-preview-input input:file").change(function (){
        var img = $('<img/>', {
            id: 'dynamic',
            width:250,
            height:200,
            overflow:'hidden'
        });
        var file = this.files[0];
        var reader = new FileReader();
        // Set preview image into the popover data-content
        reader.onload = function (e) {
            $(".image-preview-input-title").text("<?=$this->lang->line('section_file_browse')?>");
            $(".image-preview-clear").show();
            $(".image-preview-filename").val(file.name);
            img.attr('src', e.target.result);
            $(".image-preview").attr("data-content",$(img)[0].outerHTML).popover("show");
            $('.content').css('padding-bottom', '100px');
        }
        reader.readAsDataURL(file);
    });
});
</script>
