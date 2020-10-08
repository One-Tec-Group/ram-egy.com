
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa fa-user"></i> <?=$this->lang->line('panel_title')?></h3>


        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li><a href="<?=base_url("parents/index")?>"><?=$this->lang->line('menu_parents')?></a></li>
            <li class="active"><?=$this->lang->line('menu_edit')?> <?=$this->lang->line('menu_parents')?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-10">

                <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">

                    <h3 style="color: #dd4b39"><?=$this->lang->line("parents_info")?></h3>
                <hr>

                    <?php
                        if(form_error('photo'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="photo" class="col-sm-2 control-label">
                            <?=$this->lang->line("parents_photo")?>
                        </label>
                        <div class="col-sm-6">
                            <div class="input-group image-preview">
                                <input type="text" class="form-control image-preview-filename" disabled="disabled">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default image-preview-clear" style="display:none;">
                                        <span class="fa fa-remove"></span>
                                        <?=$this->lang->line('parents_clear')?>
                                    </button>
                                    <div class="btn btn-success image-preview-input">
                                        <span class="fa fa-repeat"></span>
                                        <span class="image-preview-input-title">
                                        <?=$this->lang->line('parents_file_browse')?></span>
                                        <input type="file" accept="image/png, image/jpeg, image/gif" name="photo"/>
                                    </div>
                                </span>
                            </div>
                        </div>

                        <span class="col-sm-4">
                            <?php echo form_error('photo'); ?>
                        </span>
                    </div>


                    <?php
                        if(form_error('name'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="name_id" class="col-sm-2 control-label">
                            <?=$this->lang->line("parents_guargian_name")?> <span class="text-red">*</span>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="name_id" name="name" value="<?=set_value('name', $parents->name)?>" >
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('name'); ?>
                        </span>
                    </div>

                    <?php
                        if(form_error('father_name'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="father_name" class="col-sm-2 control-label">
                            <?=$this->lang->line("parents_father_name")?> <span class="text-red">*</span>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="father_name" name="father_name" value="<?=set_value('father_name', $parents->father_name)?>" >
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('father_name'); ?>
                        </span>
                    </div>

                    <?php
                        if(form_error('mother_name'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="mother_name" class="col-sm-2 control-label">
                            <?=$this->lang->line("parents_mother_name")?>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="mother_name" name="mother_name" value="<?=set_value('mother_name', $parents->mother_name)?>" >
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('mother_name'); ?>
                        </span>
                    </div>

                    <?php
                        if(form_error('father_profession'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="father_profession" class="col-sm-2 control-label">
                            <?=$this->lang->line("parents_father_profession")?>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="father_profession" name="father_profession" value="<?=set_value('father_profession', $parents->father_profession)?>" >
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('father_profession'); ?>
                        </span>
                    </div>


                 <hr>
                    <h3 style="color: #dd4b39"><?=$this->lang->line("parents_contact")?></h3>
                <hr>

                    <?php
                        if(form_error('email'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="email" class="col-sm-2 control-label">
                            <?=$this->lang->line("parents_email")?>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="email" name="email" value="<?=set_value('email', $parents->email)?>" >
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('email'); ?>
                        </span>
                    </div>

                    <?php
                        if(form_error('phone'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="phone" class="col-sm-2 control-label">
                            <?=$this->lang->line("parents_phone")?>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="phone" name="phone" value="<?=set_value('phone', $parents->phone)?>" >
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('phone'); ?>
                        </span>
                    </div>

                    <?php
                        if(form_error('address'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="address" class="col-sm-2 control-label">
                            <?=$this->lang->line("parents_address")?>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="address" name="address" value="<?=set_value('address', $parents->address)?>" >
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('address'); ?>
                        </span>
                    </div>

                                     <hr>
                    <h3 style="color: #dd4b39"><?=$this->lang->line("parents_account")?></h3>
                <hr>

                    <?php
                        if(form_error('username'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="username" class="col-sm-2 control-label">
                            <?=$this->lang->line("parents_username")?> <span class="text-red">*</span>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="username" name="username" value="<?=set_value('username', $parents->username)?>" >
                        </div>
                         <span class="col-sm-4 control-label">
                            <?php echo form_error('username'); ?>
                        </span>
                    </div>

                    <?php
                        if(form_error('password'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="password" class="col-sm-2 control-label">
                            <?=$this->lang->line("parents_password")?> <span class="text-red">*</span>
                        </label>
                        <div class="col-sm-6">
                            <input type="password" class="form-control" id="password" name="password" value="<?=set_value('password')?>" >
                        </div>
                         <span class="col-sm-4 control-label">
                            <?php echo form_error('password'); ?>
                        </span>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-8">
                            <input type="submit" class="btn btn-success" value="<?=$this->lang->line("update_parents")?>" >
                        </div>
                    </div>

                </form>
            </div> <!-- col-sm-8 -->
        </div><!-- row -->
        <hr/>
<div class="row">
    <div class="text text-center"><h3 style="color: #dd4b39"><?= $this->lang->line('parents_assign_players') ?></h3></div>
    <hr/>
    <div class="col-sm-12">
        <?php if (count($students) > 0) { ?>
            <div id="hide-table">
                <table class="table table-striped table-bordered table-hover dataTable no-footer">
                    <thead>
                        <tr>
                            <th class="col-sm-2"><?= $this->lang->line('parents_child_photo') ?></th>
                            <th class="col-sm-2"><?= $this->lang->line('parents_child_name') ?></th>
                            <th class="col-sm-2"><?= $this->lang->line('parents_child_phone') ?></th>
                            <th class="col-sm-2"><?= $this->lang->line('parents_child_birth') ?></th>
                            <?php if (permissionChecker('student_edit') || permissionChecker('student_delete') || permissionChecker('student_view')) { ?>
                                <th class='actionField' style="width:5%;"><?= $this->lang->line('action') ?></th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $existingStudents = array();
                        if (count($students)) {
                            $i = 1;
                            foreach ($students as $student) {
                                array_push($existingStudents, $student->studentID);
                                ?>
                                <tr>

                                    <td data-title="<?= $this->lang->line('student_photo') ?>">
                                        <?= profileimage($student->photo); ?>
                                    </td>
                                    <td data-title="<?= $this->lang->line('parents_child_name') ?>">
                                        <?php echo $student->name; ?>
                                    </td>
                                    <td data-title="<?= $this->lang->line('student_phone') ?>">
                                        <?php echo $student->phone; ?>
                                    </td>
                                    <td data-title="<?= $this->lang->line('student_email') ?>">
                                        <?php echo $student->dob; ?>
                                    </td>
                                    <?php if (permissionChecker('student_edit') || permissionChecker('student_delete') || permissionChecker('student_view')) { ?>
                                        <td data-title="<?= $this->lang->line('action') ?>">
                                            <a href="<?php echo base_url('parents/remove/' . $student->studentID . "/" . $parents->parentsID); ?>" class="btn btn-danger btn-xs mrg" data-placement="top" data-toggle="tooltip" data-original-title="Remove"><i class="fa fa-trash"></i></a>
                                        </td>
                                    <?php } ?>
                                </tr>
                                <?php
                                $i++;
                            }
                        }
                        ?>
                    </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="7" class="text text-center"><?= $this->lang->line('parents_assign_text') ?></th>
                            </tr>
                            <tr>
                                <th colspan="7">
                                    <form action="<?= base_url('parents/parentAdd') ?>" method="post">
                                        <input type='hidden' name='parentID' value='<?= $parents->parentsID; ?>'/>
                                        <table class="table no-border">
                                            <td align="center"><select class="form-control select2" id="studentID" name="studentID" style="width:30%;" required='required'>
                                                    <option value selected disabled><?= $this->lang->line('parents_select-player') ?></option>
                                                    <?php
                                                    $existingStudent = array();
                                                    foreach ($allStudent as $studentt) {
                                                        if (!in_array($studentt->studentID, $existingStudent)) {
                                                            echo "<option value='" . $studentt->studentID . "'>" . $studentt->name . "</option>";
                                                        }
                                                    }
                                                    ?>
                                                    <input style="margin-left:10px" class="btn btn-warning btn-sm" type="submit" value="<?= $this->lang->line('parents_assign_add') ?>">

                                                    </td>
                                        </table>
                                    </form>
                                </th>
                            </tr>
                        </tfoot>
                </table>
            </div>
        <?php } else { ?>
            <div id="hide-table">
                <table id="example1" class="table table-striped table-bordered table-hover dataTable no-footer">
                    <thead>
                        <tr>
                            <th class="col-sm-2"><?= $this->lang->line('parents_child_photo') ?></th>
                            <th class="col-sm-2"><?= $this->lang->line('parents_child_name') ?></th>
                            <th class="col-sm-2"><?= $this->lang->line('parents_child_phone') ?></th>
                            <th class="col-sm-2"><?= $this->lang->line('parents_child_birth') ?></th>
                            <?php if (permissionChecker('student_edit') || permissionChecker('student_delete') || permissionChecker('student_view')) { ?>
                                <th class='actionField' style="width:5%;"><?= $this->lang->line('action') ?></th>
                            <?php } ?>
                        </tr>
                    </thead>
                        <tfoot>
                            <tr>
                                <th colspan="7" class="text text-center">... Add new player to this parent from here ...</th>
                            </tr>
                            <tr>
                                <th colspan="7">
                                    <form action="<?= base_url('parents/parentAdd') ?>" method="post">
                                        <input type='hidden' name='parentID' value='<?= $parents->parentsID; ?>'/>
                                        <table class="table no-border">
                                            <td><label for="selectStudent" style="margin-right: 10px;">Select Student: </label></td>
                                            <td><select class="form-control select2" id="studentID" name="studentID" style="width:80%;" required='required'>
                                                    <option value selected disabled>SELECT STUDENT</option>
                                                    <?php
                                                    $existingStudent = array();
                                                    foreach ($allStudent as $studentt) {
                                                        if (!in_array($studentt->studentID, $existingStudent)) {
                                                            echo "<option value='" . $studentt->studentID . "'>" . $studentt->name . "</option>";
                                                        }
                                                    }
                                                    ?></td>
                                            <td><input class="btn btn-warning btn-sm" type="submit" value="ADD"></td>
                                        </table>
                                    </form>
                                </th>
                            </tr>
                        </tfoot>
                </table>
            </div>
        <?php } ?>
    </div> <!-- col-sm-12 -->
</div>
    </div><!-- Body -->
</div><!-- /.box -->
<script type="text/javascript">
$('#mother_name').datepicker({endDate: new Date(),startView: 2});

$('#username').keyup(function() {
    $(this).val($(this).val().replace(/\s/g, ''));
});
$(document).on('click', '#close-preview', function(){
    $('.image-preview').popover('hide');
    // Hover befor close the preview
    $('.image-preview').hover(
        function () {
           $('.image-preview').popover('show');
           $('.content').css('padding-bottom', '130px');
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
        $(".image-preview-input-title").text("<?=$this->lang->line('parents_file_browse')?>");
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
            $(".image-preview-input-title").text("<?=$this->lang->line('parents_file_browse')?>");
            $(".image-preview-clear").show();
            $(".image-preview-filename").val(file.name);
            img.attr('src', e.target.result);
            $(".image-preview").attr("data-content",$(img)[0].outerHTML).popover("show");
            $('.content').css('padding-bottom', '130px');
        }
        reader.readAsDataURL(file);
    });
});

</script>
