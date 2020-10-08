<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa fa-star"></i> <?= $this->lang->line('panel_title') ?></h3>
        <ol class="breadcrumb">
            <li><a href="<?= base_url("dashboard/index") ?>"><i class="fa fa-laptop"></i> <?= $this->lang->line('menu_dashboard') ?></a></li>
            <li><a href="<?= base_url("section/index/$set") ?>"></i><?= $this->lang->line('menu_section') ?></a></li>
            <li class="active"><?= $this->lang->line('menu_edit') ?> <?= $this->lang->line('menu_section') ?></li>
        </ol>
    </div>
    <div class="box-body">
        <h3 class="profile-username text-center"><?= $section->section; ?></h3>
        <a href="<?= base_url("section/exportPDF/" . $this->uri->segment(3) . "/" . $this->uri->segment(4)); ?>" target="_blank" class="btn btn-primary pull-right">EXPORT PDF</a>
        <hr/>
        </br>
        <div class="row">
            <div class="col-sm-4">
                <div class="box box-primary" style="height:380px;">
                    <div class="box-body box-profile">
                        <div style="height:300px"><?= profileviewimage($section->photo); ?> </div>
                        <br/>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="box box-primary" style="height:380px;">
                    <div class="box-body box-profile text">
                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item" style="background-color: #FFF">
                                <b><?= $this->lang->line("section_teacher_name_first"); ?></b> <a class="pull-right"><?php
                                    for ($i = 0; $i < count($teachers); $i++) {
                                        if ($teachers[$i]->teacherID == $section->teacherID) {
                                            echo $teachers[$i]->name;
                                            break;
                                        }
                                    }
                                    ?></a>
                            </li>
                            <li class="list-group-item" style="background-color: #FFF">
                                <b><?= $this->lang->line("section_teacher_name_second"); ?></b> <a class="pull-right"><?php
                                    for ($i = 0; $i < count($teachers); $i++) {
                                        if ($teachers[$i]->teacherID == $section->teacherID_second) {
                                            echo $teachers[$i]->name;
                                            break;
                                        }
                                    }
                                    ?></a>
                            </li>
                            <li class="list-group-item" style="background-color: #FFF">
                                <b><?= $this->lang->line("section_teacher_name_third"); ?></b> <a class="pull-right"><?php
                                    for ($i = 0; $i < count($teachers); $i++) {
                                        if ($teachers[$i]->teacherID == $section->teacherID_third) {
                                            echo $teachers[$i]->name;
                                            break;
                                        }
                                    }
                                    ?></a>
                            </li>
                            <li class="list-group-item" style="background-color: #FFF">
                                <b><?= $this->lang->line("goalkeeper_coach"); ?></b> <a class="pull-right"><?php
                                    for ($i = 0; $i < count($teachers); $i++) {
                                        if ($teachers[$i]->teacherID == $section->goalkeeper_coach) {
                                            echo $teachers[$i]->name;
                                            break;
                                        }
                                    }
                                    ?></a>
                            </li>
                            <li class="list-group-item" style="background-color: #FFF">
                                <b><?= $this->lang->line("supervisor"); ?></b> <a class="pull-right"><?php
                                    for ($i = 0; $i < count($supervisors); $i++) {
                                        if ($supervisors[$i]->userID == $section->supervisor) {
                                            echo $supervisors[$i]->name;
                                            break;
                                        }
                                    }
                                    ?></a>
                            </li>
                            <li class="list-group-item" style="background-color: #FFF">
                                <b><?= $this->lang->line("supervisor2"); ?></b> <a class="pull-right"><?php
                                    for ($i = 0; $i < count($supervisors); $i++) {
                                        if ($supervisors[$i]->userID == $section->supervisor2) {
                                            echo $supervisors[$i]->name;
                                            break;
                                        }
                                    }
                                    ?></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="col-sm-4">
                <div class="box box-primary" style="height:380px;">
                    <div class="box-body box-profile text">
                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item" style="background-color: #FFF;">
                                <b><?= $this->lang->line("section_classes"); ?></b> <a class="pull-right"><?php
                                    for ($i = 0; $i < count($classes); $i++) {
                                        if ($classes[$i]->classesID == $section->classesID) {
                                            echo $classes[$i]->classes;
                                            break;
                                        }
                                    }
                                    ?></a>
                            </li>
                            <li class="list-group-item" style="background-color: #FFF;">
                                <b><?= $this->lang->line("section_capacity"); ?></b> <a class="pull-right"><?= count($students) . "/" . $section->capacity; ?></a>
                            </li>
                            <li class="list-group-item" style="background-color: #FFF;">
                                <b><?= $this->lang->line("section_monthly_fees"); ?></b> <a class="pull-right"><?= $section->monthly_fees; ?></a>
                            </li>
                            <li class="list-group-item" style="background-color: #FFF;">
                                <b><?= $this->lang->line("section_note"); ?></b><a class="pull-right">asdasd<?= $section->note; ?></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            
        </div>

        <div class="row">
            <div class="text text-center"><h4><b><?= $this->lang->line('section_add_player') ?><br><br><?php echo $section->section; ?></b></h4></div>
            <hr/>
            <div class="col-sm-12">
                <?php if (count($students) > 0) { ?>
                    <div id="hide-table">
                        <table class="table table-striped table-bordered table-hover dataTable no-footer">
                            <thead>
                                <tr>
                                    <th class='coachCount'><?= $this->lang->line('slno') ?></th>
                                    <th class="col-sm-2"><?= $this->lang->line('student_photo') ?></th>
                                    <th class="col-sm-2"><?= $this->lang->line('student_name') ?></th>
                                    <th class="col-sm-2"><?= $this->lang->line('student_phone') ?></th>
                                    <th class="col-sm-2"><?= $this->lang->line('student_dob') ?></th>
                                    <th class="col-sm-2"><?= $this->lang->line('section_joing_date') ?></th>
                                    <?php if (permissionChecker('student_edit') || permissionChecker('student_delete') || permissionChecker('student_view')) { ?>
                                        <th class='actionField'><?= $this->lang->line('action') ?></th>
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
                                            <td data-title="<?= $this->lang->line('slno') ?>">
                                                <?php echo $student->registerNO; ?>
                                            </td>
                                            <td data-title="<?= $this->lang->line('student_photo') ?>">
                                                <?= profileimage($student->photo); ?>
                                            </td>
                                            <td data-title="<?= $this->lang->line('student_name') ?>">
                                                <?php echo $student->srname; ?>
                                            </td>
                                            <td data-title="<?= $this->lang->line('student_phone') ?>">
                                                <?php echo $student->phone; ?>
                                            </td>
                                            <td data-title="<?= $this->lang->line('student_dob') ?>">
                                                <?php echo $student->dob; ?>
                                            </td>
                                            <td data-title="<?= $this->lang->line('section_joing_date') ?>">
                                                <?php echo $student->srjoinDate; ?>
                                            </td>
                                            <?php if (permissionChecker('student_edit') || permissionChecker('student_delete') || permissionChecker('student_view')) { ?>
                                                <td data-title="<?= $this->lang->line('action') ?>">
                                                    <?php
                                                    echo btn_view('student/view/' . $student->srstudentID . "/" . $set, $this->lang->line('view'));
                                                    ?>
                                                    <a href="<?php echo base_url('section/remove/' . $student->srstudentID . "/" . $this->uri->segment(3) . "/" . $section->classesID); ?>" class="btn btn-danger btn-large mrg" data-placement="top" data-toggle="tooltip" data-original-title="Remove"><i class="fa fa-trash"></i></a>
                                                </td>
                                            <?php } ?>
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                }
                                ?>
                            </tbody>
                            <?php if (count($students) < $sectionStudentCount) { ?>
                                <tfoot>
                                    <tr>
                                        <th colspan="7" class="text text-center"><?= $this->lang->line('section_assign') ?></th>
                                    </tr>
                                    <tr>
                                        <th colspan="7">
                                            <form action="<?= base_url('section/sectionAdd') ?>" method="post" class="text text-center">
                                                <input type='hidden' name='sectionID' value='<?= $section->sectionID; ?>'/>
                                                <input type='hidden' name='classesID' value='<?= $section->classesID; ?>'/>
                                                <label for="studentID"><?= $this->lang->line('section_select_player') ?></label>
                                                <select class="form-control select2" id="studentID" name="studentID" style="width:50%;margin: 0 auto;" required='required'>
                                                    <option value selected disabled><?= $this->lang->line('section_select_player') ?></option>
                                                    <?php
                                                    foreach ($allStudents as $studentt) {
                                                        if (!in_array($studentt->studentID, $existingStudents)) {
                                                            echo "<option value='" . $studentt->studentID . "'>" . $studentt->name . "</option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <label style="margin: 0 auto;margin-top:20px;" for="studentID"><?= $this->lang->line('section_select_subscription') ?></label>
                                                <select style="margin: 0 auto;width:50%;" class="form-control select2" id="invoiceID" name="invoiceID" required='required'>
                                                    <option value="2" selected><?= $this->lang->line('section_select_subscription') ?></option>
                                                </select>
                                                <label style="margin: 0 auto;margin-top:20px;" for="studentID"><?= $this->lang->line('section_joing_date') ?></label><br/>
                                                <input style="margin: 0 auto;width:50%;" type="text" class="form-control join_date" id="join_date" name="join_date"/>
                                                <br/>
                                                <input style="margin: 0 auto;margin-top:20px" class="btn btn-warning btn-sm" type="submit" value="<?= $this->lang->line('section_add_player') ?>">
                                            </form>
                                        </th>
                                    </tr>
                                </tfoot>
                            <?php } ?>
                        </table>
                    </div>
                <?php } else { ?>
                    <div id="hide-table">
                        <table id="example1" class="table table-striped table-bordered table-hover dataTable no-footer">
                            <thead>
                                <tr>
                                    <th class='coachCount'><?= $this->lang->line('slno') ?></th>
                                    <th class="col-sm-2"><?= $this->lang->line('student_photo') ?></th>
                                    <th class="col-sm-2"><?= $this->lang->line('student_name') ?></th>
                                    <th class="col-sm-2"><?= $this->lang->line('student_phone') ?></th>
                                    <th class="col-sm-2"><?= $this->lang->line('student_email') ?></th>
                                    <?php if (permissionChecker('student_edit')) { ?>
                                        <th class="col-sm-1"><?= $this->lang->line('student_status') ?></th>
                                    <?php } ?>
                                    <?php if (permissionChecker('student_edit') || permissionChecker('student_delete') || permissionChecker('student_view')) { ?>
                                        <th class='actionField'><?= $this->lang->line('action') ?></th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <?php if (count($students) < $sectionStudentCount) { ?>
                                <tfoot>
                                    <tr>
                                        <th colspan="7" class="text text-center">... Add new player to this section from here ...</th>
                                    </tr>
                                    <tr>
                                        <th colspan="7">
                                            <form action="<?= base_url('section/sectionAdd') ?>" method="post" class="text text-center">
                                                <input type='hidden' name='sectionID' value='<?= $section->sectionID; ?>'/>
                                                <input type='hidden' name='classesID' value='<?= $section->classesID; ?>'/>
                                                <label for="studentID"><?= $this->lang->line('section_select_player') ?></label>
                                                <select class="form-control select2" id="studentID" name="studentID" style="width:50%;margin: 0 auto;" required='required'>
                                                    <option value selected disabled><?= $this->lang->line('section_select_player') ?></option>
                                                    <?php
                                                    foreach ($allStudents as $studentt) {
                                                        if (!in_array($studentt->studentID, $existingStudents)) {
                                                            echo "<option value='" . $studentt->studentID . "'>" . $studentt->name . "</option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <label style="margin: 0 auto;margin-top:20px;" for="studentID"><?= $this->lang->line('section_select_subscription') ?></label>
                                                <select style="margin: 0 auto;width:50%;" class="form-control select2" id="invoiceID" name="invoiceID" required='required'>
                                                    <option value="2" selected><?= $this->lang->line('section_select_subscription') ?></option>
                                                </select>
                                                <label style="margin: 0 auto;margin-top:20px;" for="studentID"><?= $this->lang->line('section_joing_date') ?></label><br/>
                                                <input style="margin: 0 auto;width:50%;" type="text" class="form-control join_date" id="join_date" name="join_date"/>
                                                <br/>
                                                <input style="margin: 0 auto;margin-top:20px" class="btn btn-warning btn-sm" type="submit" value="<?= $this->lang->line('section_add_player') ?>">
                                            </form>
                                        </th>
                                    </tr>
                                </tfoot>
                            <?php } ?>
                        </table>
                    </div>
                <?php } ?>
            </div> <!-- col-sm-12 -->
        </div>
    </div>
</div>

<script>
    $(".select2").select2({placeholder: "", maximumSelectionSize: 6});
    $('.join_date').datepicker({startView: 2});

    $(document).ready(function () {
        $("#studentID").change(function () {
            //            alert("Working");
            $('#load_classreport').html('');
            var id = $(this).val();
            if (id == 0) {
                $('#invoiceID').html('<option value="2"><?= $this->lang->line('section_select_subscription') ?></option>');
                $('#invoiceID').val('');
            } else {
                $.ajax({
                    type: 'POST',
                    url: "<?= base_url('section/getInvoices') ?>",
                    data: {"studentID": id, "sectionID":<?php echo $set; ?>, "groupID":<?php echo $set; ?>},
                    dataType: "html",
                    success: function (data) {
                        $('#invoiceID').html(data);
                    }
                });
            }
        });
    });
</script>

