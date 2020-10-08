<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa icon-student"></i> <?= $this->lang->line('panel_title') ?></h3>


        <ol class="breadcrumb">
            <li><a href="<?= base_url("dashboard/index") ?>"><i class="fa fa-laptop"></i> <?= $this->lang->line('menu_dashboard') ?></a></li>
            <li><a href="<?= base_url("student/index") ?>"><?= $this->lang->line('menu_student') ?></a></li>
            <li class="active"><?= $this->lang->line('menu_edit') ?> <?= $this->lang->line('menu_student') ?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-10">

                <h3 style="color: #dd4b39"><?= $this->lang->line("player_info") ?></h3>
                <hr>

                <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">

                    <?php
                    if (form_error('registerNO'))
                        echo "<div class='form-group has-error' >";
                    else
                        echo "<div class='form-group' >";
                    ?>
                    <label for="registerNO" class="col-sm-2 control-label">
                        <?= $this->lang->line("student_registerNO") ?> <span class="text-red">*</span>
                    </label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="registerNO" name="registerNO" value="<?= set_value('registerNO', $student->registerNO) ?>" readonly="readonly">
                    </div>
                    <span class="col-sm-4 control-label">
                        <?php echo form_error('registerNO'); ?>
                    </span>
            </div>

            <?php
            if (form_error('photo'))
                echo "<div class='form-group has-error' >";
            else
                echo "<div class='form-group' >";
            ?>
            <label for="photo" class="col-sm-2 control-label">
                <?= $this->lang->line("student_photo") ?>
            </label>
            <div class="col-sm-6">
                <div class="input-group image-preview">
                    <input type="text" class="form-control image-preview-filename" disabled="disabled">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-default image-preview-clear" style="display:none;">
                            <span class="fa fa-remove"></span>
                            <?= $this->lang->line('student_clear') ?>
                        </button>
                        <div class="btn btn-success image-preview-input">
                            <span class="fa fa-repeat"></span>
                            <span class="image-preview-input-title">
                                <?= $this->lang->line('student_file_browse') ?></span>
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
        if (form_error('name'))
            echo "<div class='form-group has-error' >";
        else
            echo "<div class='form-group' >";
        ?>
        <label for="name_id" class="col-sm-2 control-label">
            <?= $this->lang->line("student_name") ?> <span class="text-red">*</span>
        </label>
        <div class="col-sm-6">
            <input type="text" class="form-control" id="name_id" name="name" value="<?= set_value('name', $student->name) ?>" >
        </div>
        <span class="col-sm-4 control-label">
            <?php echo form_error('name'); ?>
        </span>
    </div>

    <?php
    if (form_error('roll'))
        echo "<div class='form-group has-error' >";
    else
        echo "<div class='form-group' >";
    ?>
    <label for="roll" class="col-sm-2 control-label">
        <?= $this->lang->line("student_roll") ?>
    </label>
    <div class="col-sm-6">
        <input type="text" class="form-control" id="roll" name="roll" value="<?= set_value('roll', $student->roll) ?>" >
    </div>
    <span class="col-sm-4 control-label">
        <?php echo form_error('roll'); ?>
    </span>
</div>

<?php
if (form_error('dob'))
    echo "<div class='form-group has-error' >";
else
    echo "<div class='form-group' >";
?>
<label for="dob" class="col-sm-2 control-label">
    <?= $this->lang->line("student_dob") ?>
</label>
<div class="col-sm-6">
    <?php $dob = '';
    if ($student->dob) {
        $dob = date("d-m-Y", strtotime($student->dob));
    } ?>
    <input type="text" class="form-control" id="dob" name="dob" value="<?= set_value('dob', $dob) ?>" >
</div>
<span class="col-sm-4 control-label">
<?php echo form_error('dob'); ?>
</span>
</div>

<?php
if (form_error('doj'))
    echo "<div class='form-group has-error' >";
else
    echo "<div class='form-group' >";
?>
<label for="doj" class="col-sm-2 control-label">
    <?= $this->lang->line("student_doj") ?>
</label>
<div class="col-sm-6">
    <?php $doj = '';
    if ($student->doj) {
        $doj = date("d-m-Y", strtotime($student->doj));
    } ?>
    <input type="text" class="form-control" id="doj" name="doj" value="<?= set_value('doj', $doj) ?>" >
</div>
<span class="col-sm-4 control-label">
<?php echo form_error('doj'); ?>
</span>
</div>

    <?php
    if (form_error('sex'))
        echo "<div class='form-group has-error' >";
    else
        echo "<div class='form-group' >";
    ?>
<label for="sex" class="col-sm-2 control-label">
<?= $this->lang->line("student_sex") ?>
</label>
<div class="col-sm-6">
<?php
echo form_dropdown("sex", array($this->lang->line('student_sex_male') => $this->lang->line('student_sex_male'), $this->lang->line('student_sex_female') => $this->lang->line('student_sex_female')), set_value("sex", $student->sex), "id='sex' class='form-control'");
?>
</div>
<span class="col-sm-4 control-label">
<?php echo form_error('sex'); ?>
</span>

</div>


    <?php
    if (form_error('religion'))
        echo "<div class='form-group has-error' >";
    else
        echo "<div class='form-group' >";
    ?>
<label for="religion" class="col-sm-2 control-label">
    <?= $this->lang->line("student_religion") ?>
</label>
<div class="col-sm-6">
    <input type="text" class="form-control" id="religion" name="religion" value="<?= set_value('religion', $student->religion) ?>" >
</div>
<span class="col-sm-4 control-label">
<?php echo form_error('religion'); ?>
</span>
</div>

    <?php
    if (form_error('note'))
        echo "<div class='form-group has-error' >";
    else
        echo "<div class='form-group' >";
    ?>
<label for="religion" class="col-sm-2 control-label">
    <?= $this->lang->line("student_note") ?>
</label>
<div class="col-sm-6">
    <textarea type="text" class="form-control" id="note" name="note" value="<?= set_value('note') ?>" ></textarea>
</div>
<span class="col-sm-4 control-label">
<?php echo form_error('note'); ?>
</span>
</div>

<hr>
<h3 style="color: #dd4b39"><?= $this->lang->line("player_contact") ?></h3>
<hr>

    <?php
    if (form_error('email'))
        echo "<div class='form-group has-error' >";
    else
        echo "<div class='form-group' >";
    ?>
<label for="email" class="col-sm-2 control-label">
    <?= $this->lang->line("student_email") ?>
</label>
<div class="col-sm-6">
    <input type="text" class="form-control" id="email" name="email" value="<?= set_value('email', $student->email) ?>" >
</div>
<span class="col-sm-4 control-label">
<?php echo form_error('email'); ?>
</span>
</div>

    <?php
    if (form_error('phone'))
        echo "<div class='form-group has-error' >";
    else
        echo "<div class='form-group' >";
    ?>
<label for="phone" class="col-sm-2 control-label">
    <?= $this->lang->line("student_phone") ?>
</label>
<div class="col-sm-6">
    <input type="text" class="form-control" id="phone" name="phone" value="<?= set_value('phone', $student->phone) ?>" >
</div>
<span class="col-sm-4 control-label">
<?php echo form_error('phone'); ?>
</span>
</div>
    <?php
    if (form_error('phone2'))
        echo "<div class='form-group has-error' >";
    else
        echo "<div class='form-group' >";
    ?>
<label for="phone2" class="col-sm-2 control-label">
    <?= $this->lang->line("student_phone") ?> 2
</label>
<div class="col-sm-6">
    <input type="text" class="form-control" id="phone2" name="phone2" value="<?= set_value('phone2', $student->phone2) ?>" >
</div>
<span class="col-sm-4 control-label">
<?php echo form_error('phone2'); ?>
</span>
</div>

    <?php
    if (form_error('address'))
        echo "<div class='form-group has-error' >";
    else
        echo "<div class='form-group' >";
    ?>
<label for="address" class="col-sm-2 control-label">
    <?= $this->lang->line("student_address") ?>
</label>
<div class="col-sm-6">
    <input type="text" class="form-control" id="address" name="address" value="<?= set_value('address', $student->address) ?>" >
</div>
<span class="col-sm-4 control-label">
<?php echo form_error('address'); ?>
</span>
</div>

    <?php
    if (form_error('state'))
        echo "<div class='form-group has-error' >";
    else
        echo "<div class='form-group' >";
    ?>
<label for="state" class="col-sm-2 control-label">
    <?= $this->lang->line("student_state") ?>
</label>
<div class="col-sm-6">
    <input type="text" class="form-control" id="state" name="state" value="<?= set_value('state', $student->state) ?>" >
</div>
<span class="col-sm-4 control-label">
<?php echo form_error('state'); ?>
</span>
</div>

    <?php
    if (form_error('country'))
        echo "<div class='form-group has-error' >";
    else
        echo "<div class='form-group' >";
    ?>
<label for="country" class="col-sm-2 control-label">
    <?= $this->lang->line("student_country") ?>
</label>
<div class="col-sm-6">
    <?php
    $country['0'] = $this->lang->line('student_select_country');
    foreach ($allcountry as $allcountryKey => $allcountryit) {
        $country[$allcountryKey] = $allcountryit;
    }
    ?>
<?php
echo form_dropdown("country", $country, set_value("country", $student->country), "id='country' class='form-control select2'");
?>
</div>
<span class="col-sm-4 control-label">
<?php echo form_error('country'); ?>
</span>
</div>

<hr>
<h3 style="color: #dd4b39"><?= $this->lang->line("player_skills") ?></h3>
<hr>

<div class="form-group <?= form_error('extraCurricularActivities') ? ' has-error' : '' ?>">
    <label for="extraCurricularActivities" class="col-sm-2 control-label">
        <?= $this->lang->line("student_extracurricularactivities") ?>
    </label>
    <div class="col-sm-6">
        <input type="text" class="form-control" id="extraCurricularActivities" name="extraCurricularActivities" value="<?= set_value('extraCurricularActivities', $student->extracurricularactivities) ?>" >
    </div>
    <span class="col-sm-4 control-label">
        <?php echo form_error('extraCurricularActivities'); ?>
    </span>
</div>

<div class="form-group <?= form_error('remarks') ? ' has-error' : '' ?>">
    <label for="remarks" class="col-sm-2 control-label">
        <?= $this->lang->line("student_remarks") ?>
    </label>
    <div class="col-sm-6">
        <input type="text" class="form-control" id="remarks" name="remarks" value="<?= set_value('remarks', $student->remarks) ?>" >
    </div>
    <span class="col-sm-4 control-label">
<?php echo form_error('remarks'); ?>
    </span>
</div>

<hr>
<h3 style="color: #dd4b39"><?= $this->lang->line("player_data") ?></h3>
<hr>

    <?php
    if (form_error('height'))
        echo "<div class='form-group has-error' >";
    else
        echo "<div class='form-group' >";
    ?>
<label for="height" class="col-sm-2 control-label">
    <?= $this->lang->line("student_height") ?>
</label>
<div class="col-sm-6">
    <input type="text" class="form-control" id="height" name="height" value="<?= set_value('height', $student->height) ?>" >
</div>
<span class="col-sm-4 control-label">
<?php echo form_error('height'); ?>
</span>
</div>
    <?php
    if (form_error('weight'))
        echo "<div class='form-group has-error' >";
    else
        echo "<div class='form-group' >";
    ?>
<label for="weight" class="col-sm-2 control-label">
    <?= $this->lang->line("student_weight") ?>
</label>
<div class="col-sm-6">
    <input type="text" class="form-control" id="weight" name="weight" value="<?= set_value('weight', $student->weight) ?>" >
</div>
<span class="col-sm-4 control-label">
<?php echo form_error('weight'); ?>
</span>
</div>

    <?php
    if (form_error('foot_size'))
        echo "<div class='form-group has-error' >";
    else
        echo "<div class='form-group' >";
    ?>
<label for="foot_size" class="col-sm-2 control-label">
    <?= $this->lang->line("student_foot_size") ?>
</label>
<div class="col-sm-6">
    <input type="text" class="form-control" id="foot_size" name="foot_size" value="<?= set_value('foot_size', $student->foot_size) ?>" >
</div>
<span class="col-sm-4 control-label">
<?php echo form_error('foot_size'); ?>
</span>
</div>
<?php
if (form_error('used_foot'))
    echo "<div class='form-group has-error' >";
else
    echo "<div class='form-group' >";
?>
<label for="used_foot" class="col-sm-2 control-label">
    <?= $this->lang->line("student_used_foot") ?>
</label>
<div class="col-sm-6">
    <input type="radio" name="used_foot" value="left" <?= (($student->used_foot == "left")?"checked":""); ?>> Left
    <input type="radio" name="used_foot" value="right"  <?= (($student->used_foot == "right")?"checked":""); ?>> Right
</div>
<span class="col-sm-4 control-label">
    <?php echo form_error('used_foot'); ?>
</span>
</div>
    <?php
    if (form_error('weakness_points'))
        echo "<div class='form-group has-error' >";
    else
        echo "<div class='form-group' >";
    ?>
<label for="weakness_points" class="col-sm-2 control-label">
    <?= $this->lang->line("student_weakness_points") ?>
</label>
<div class="col-sm-6">
    <textarea class="form-control" id="weakness_points" name="weakness_points"><?= set_value('weakness_points', $student->weaknes_points) ?></textarea>
</div>
<span class="col-sm-4 control-label">
<?php echo form_error('weakness_points'); ?>
</span>
</div>
    <?php
    if (form_error('strength_points'))
        echo "<div class='form-group has-error' >";
    else
        echo "<div class='form-group' >";
    ?>
<label for="strength_points" class="col-sm-2 control-label">
    <?= $this->lang->line("student_strength_points") ?>
</label>
<div class="col-sm-6">
    <textarea class="form-control" id="strength_points" name="strength_points"><?= set_value('strength_points', $student->strength_points) ?></textarea>
</div>
<span class="col-sm-4 control-label">
<?php echo form_error('strength_points'); ?>
</span>
</div>

<hr>
<h3 style="color: #dd4b39"><?= $this->lang->line("player_medicine") ?></h3>
<hr>

    <?php
    if (form_error('previous_injuries'))
        echo "<div class='form-group has-error' >";
    else
        echo "<div class='form-group' >";
    ?>
<label for="previous_injuries" class="col-sm-2 control-label">
<?= $this->lang->line("student_previous_injuries") ?>
</label>
<div class="col-sm-6">
    <div class="input-group" style="width: 100%">
        <span class="input-group-addon"><input type="checkbox" id="previous_injuries_check" onclick="edittextAttr('previous_injuries');"<?= (($student->previous_injuries != '') ? " checked='checked'" : ""); ?>></span>
        <input type="<?= (($student->previous_injuries != '') ? "text" : "hidden"); ?>" class="form-control" id="previous_injuries" name="previous_injuries" value="<?= set_value('previous_injuries', $student->previous_injuries) ?>" >
    </div>
</div>
<span class="col-sm-4 control-label">
<?php echo form_error('previous_injuries'); ?>
</span>
</div>
    <?php
    if (form_error('surgery'))
        echo "<div class='form-group has-error' >";
    else
        echo "<div class='form-group' >";
    ?>
<label for="surgery" class="col-sm-2 control-label">
<?= $this->lang->line("student_surgery") ?>
</label>
<div class="col-sm-6">
    <div class="input-group" style="width: 100%">
        <span class="input-group-addon"><input type="checkbox" id="surgery_check" onclick="edittextAttr('surgery');"<?= (($student->surgery != '') ? " checked='checked'" : ""); ?>></span>
        <input type="<?= (($student->surgery != '') ? "text" : "hidden"); ?>" class="form-control" id="surgery" name="surgery" value="<?= set_value('surgery', $student->surgery) ?>" >
    </div>
</div>
<span class="col-sm-4 control-label">
<?php echo form_error('surgery'); ?>
</span>
</div>
    <?php
    if (form_error('allergy'))
        echo "<div class='form-group has-error' >";
    else
        echo "<div class='form-group' >";
    ?>
<label for="allergy" class="col-sm-2 control-label">
<?= $this->lang->line("student_allergy") ?>
</label>
<div class="col-sm-6">
    <div class="input-group" style="width: 100%">
        <span class="input-group-addon"><input type="checkbox" id="allergy_check" onclick="edittextAttr('allergy');"<?= (($student->allrgy != '') ? " checked='checked'" : ""); ?>></span>
        <input type="<?= (($student->allrgy != '') ? "text" : "hidden"); ?>" class="form-control" id="allergy" name="allergy" value="<?= set_value('allergy', $student->allrgy) ?>" >
    </div>
</div>
<span class="col-sm-4 control-label">
<?php echo form_error('allergy'); ?>
</span>
</div>

    <?php
    if (form_error('asthma'))
        echo "<div class='form-group has-error' >";
    else
        echo "<div class='form-group' >";
    ?>
<label for="asthma" class="col-sm-2 control-label">
<?= $this->lang->line("student_asthma") ?>
</label>
<div class="col-sm-6">
    <div class="input-group" style="width: 100%">
        <span class="input-group-addon"><input type="checkbox" id="asthma_check" onclick="edittextAttr('asthma');"<?= (($student->asthma != '') ? " checked='checked'" : ""); ?>></span>
        <input type="<?= (($student->asthma != '') ? "text" : "hidden"); ?>" class="form-control" id="asthma" name="asthma" value="<?= set_value('asthma', $student->asthma) ?>" >
    </div>
</div>
<span class="col-sm-4 control-label">
<?php echo form_error('asthma'); ?>
</span>
</div>
    <?php
    if (form_error('others'))
        echo "<div class='form-group has-error' >";
    else
        echo "<div class='form-group' >";
    ?>
<label for="others" class="col-sm-2 control-label">
<?= $this->lang->line("student_others") ?>
</label>
<div class="col-sm-6">
    <textarea class="form-control" id="others" name="others"><?= set_value('others', $student->others) ?></textarea>
</div>
<span class="col-sm-4 control-label">
<?php echo form_error('others'); ?>
</span>
</div>

<hr>
<h3 style="color: #dd4b39"><?= $this->lang->line("player_account") ?></h3>
<hr>

    <?php
    if (form_error('username'))
        echo "<div class='form-group has-error' >";
    else
        echo "<div class='form-group' >";
    ?>
<label for="username" class="col-sm-2 control-label">
    <?= $this->lang->line("student_username") ?> <span class="text-red">*</span>
</label>
<div class="col-sm-6">
    <input type="text" class="form-control" id="username" name="username" value="<?= $student->registerNO ?>" readonly="readonly">
</div>
<span class="col-sm-4 control-label">
<?php echo form_error('username'); ?>
</span>
</div>

    <?php
    if (form_error('password'))
        echo "<div class='form-group has-error' >";
    else
        echo "<div class='form-group' >";
    ?>
<label for="password" class="col-sm-2 control-label">
    <?= $this->lang->line("student_password") ?>
</label>
<div class="col-sm-6">
    <input type="text" class="form-control" id="password" name="password" value="<?= set_value('password') ?>" >
</div>
<span class="col-sm-4 control-label">
<?php echo ((form_error('password')) ? form_error('password') : "leave it empty for no changes"); ?>
</span>
</div>


<div class="form-group">
    <div class="col-sm-offset-2 col-sm-8">
        <input type="submit" class="btn btn-success" value="<?= $this->lang->line("update_student") ?>" >
    </div>
</div>

</form>

</div> <!-- col-sm-8 -->
</div><!-- row -->
</div><!-- Body -->
</div><!-- /.box -->

<script type="text/javascript">
    $(".select2").select2();
    $('#dob').datepicker({startView: 2});
    $('#doj').datepicker({startView: 2});

    $('#username').keyup(function () {
        $(this).val($(this).val().replace(/\s/g, ''));
    });

    $(document).on('click', '#close-preview', function () {
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

    $(function () {
        // Create the close button
        var closebtn = $('<button/>', {
            type: "button",
            text: 'x',
            id: 'close-preview',
            style: 'font-size: initial;',
        });
        closebtn.attr("class", "close pull-right");
        // Set the popover default content
        $('.image-preview').popover({
            trigger: 'manual',
            html: true,
            title: "<strong>Preview</strong>" + $(closebtn)[0].outerHTML,
            content: "There's no image",
            placement: 'bottom'
        });
        // Clear event
        $('.image-preview-clear').click(function () {
            $('.image-preview').attr("data-content", "").popover('hide');
            $('.image-preview-filename').val("");
            $('.image-preview-clear').hide();
            $('.image-preview-input input:file').val("");
            $(".image-preview-input-title").text("<?= $this->lang->line('student_file_browse') ?>");
        });
        // Create the preview image
        $(".image-preview-input input:file").change(function () {
            var img = $('<img/>', {
                id: 'dynamic',
                width: 250,
                height: 200,
                overflow: 'hidden'
            });
            var file = this.files[0];
            var reader = new FileReader();
            // Set preview image into the popover data-content
            reader.onload = function (e) {
                $(".image-preview-input-title").text("<?= $this->lang->line('student_file_browse') ?>");
                $(".image-preview-clear").show();
                $(".image-preview-filename").val(file.name);
                img.attr('src', e.target.result);
                $(".image-preview").attr("data-content", $(img)[0].outerHTML).popover("show");
                $('.content').css('padding-bottom', '130px');
            }
            reader.readAsDataURL(file);
        });
    });
    function edittextAttr(id) {
        if (document.getElementById(id + "_check").checked === true) {
            $('#' + id).attr("type", "text");
        } else {
            $('#' + id).val("");
            $('#' + id).attr("type", "hidden");
        }
    }


</script>
