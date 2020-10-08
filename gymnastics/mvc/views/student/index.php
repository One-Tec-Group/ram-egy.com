<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa icon-student"></i> <?= $this->lang->line('panel_title') ?></h3>
        <ol class="breadcrumb">
            <li><a href="<?= base_url("dashboard/index") ?>"><i class="fa fa-laptop"></i> <?= $this->lang->line('menu_dashboard') ?></a></li>
            <li class="active"><?= $this->lang->line('menu_student') ?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <?php if ((($siteinfos->school_year == $this->session->userdata('defaultschoolyearID')) || ($this->session->userdata('usertypeID') == 1)) || ($this->session->userdata('usertypeID') != 3)) { ?>
                    <h5 class="page-header">
                        <?php if (($siteinfos->school_year == $this->session->userdata('defaultschoolyearID')) || ($this->session->userdata('usertypeID') == 1)) { ?>
                            <?php if (permissionChecker('student_add')) { ?>
                                <a href="<?php echo base_url('student/add') ?>">
                                    <i class="fa fa-plus"></i>
                                    <?= $this->lang->line('add_title') ?>
                                </a>
                            <?php } ?>
                        <?php } ?>

                        <?php if ($this->session->userdata('usertypeID') != 3) { ?>
                            <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12 pull-right drop-marg">
                                <?php
                                $array = array("0" => $this->lang->line("student_select_class"));
                                if (count($classes)) {
                                    foreach ($classes as $classa) {
                                        $array[$classa->classesID] = $classa->classes;
                                    }
                                }
                                echo form_dropdown("classesID", $array, set_value("classesID", $set), "id='classesID' class='form-control select2'");
                                ?>
                            </div>
                        <?php } ?>
                    </h5>
                    <?php
                }
                if (count($students) > 0) {
                    ?>
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li<?= (($this->uri->segment(4)) ? "" : ' class="active"'); ?>><a data-toggle="tab" href="#all" aria-expanded="true"><?= $this->lang->line("student_all_students") ?></a></li>
                            <?php
                            if ((int) $this->uri->segment(3)) {
                                foreach ($sections as $key => $section) {
                                    echo '<li' . (($this->uri->segment(4) && $this->uri->segment(4) == $section->sectionID) ? ' class="active"' : '') . '><a data-toggle="tab" href="#tab' . $section->classesID . $section->sectionID . '" aria-expanded="false">' . $section->section . '</a></li>';
                                }
                            }
                            ?>
                        </ul>


                        <div class="tab-content">
                            <div id="all" class="tab-pane<?= (($this->uri->segment(4)) ? "" : ' active'); ?>">
                                <div id="hide-table">
                                    <table class="table table-striped table-bordered table-hover dataTable no-footer">
                                        <thead>
                                            <tr>
                                                <th class='coachCount'><?= $this->lang->line('slno') ?></th>
                                                <th class="col-sm-2"><?= $this->lang->line('student_photo') ?></th>
                                                <th class="col-sm-2"><?= $this->lang->line('student_name') ?></th>
                                                <th class="col-sm-2"><?= $this->lang->line('student_phone') ?></th>
                                                <th class="col-sm-1"><?= $this->lang->line('student_yrs') ?></th>
                                                <!-- <th class="col-sm-2"><?= $this->lang->line('student_dob') ?></th> -->
                                                <?php if (permissionChecker('student_edit')) { ?>
                                                    <th class="col-sm-1"><?= $this->lang->line('student_status') ?></th>
                                                <?php } ?>
                                                <?php if (permissionChecker('student_edit') || permissionChecker('student_delete') || permissionChecker('student_view')) { ?>
                                                    <th class='actionField'><?= $this->lang->line('action') ?></th>
                                                <?php } ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (count($students)) {
                                                $existingStudents = array();
                                                $i = 1;
                                                foreach ($students as $student) {
                                                    if ($allStudentNoClass == "TRUE") {
                                                        if (!in_array($student->studentID, $existingStudents)) {
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
                                                                    <?php echo $student->name; ?>
                                                                </td>
                                                                <td data-title="<?= $this->lang->line('student_phone') ?>">
                                                                    <?php echo $student->phone; ?>
                                                                </td>
                                                                <td data-title="<?= $this->lang->line('student_yrs') ?>">
                                                                    <?php echo floor(abs(strtotime(date("Y-m-d")) - strtotime($student->dob)) / (365 * 60 * 60 * 24)); ?>
                                                                </td>
                                                                <!-- <td data-title="<?= $this->lang->line('student_dob') ?>">
                                                                    <?php echo $student->dob; ?>
                                                                </td> -->
                                                                <?php if (permissionChecker('student_edit')) { ?>
                                                                    <td data-title="<?= $this->lang->line('student_status') ?>">
                                                                        <div class="onoffswitch-small" id="<?= $student->studentID ?>">
                                                                            <input type="checkbox" id="myonoffswitch<?= $student->studentID ?>" class="onoffswitch-small-checkbox" name="paypal_demo" <?php if ($student->active === '1') echo "checked='checked'"; ?>>
                                                                            <label for="myonoffswitch<?= $student->studentID ?>" class="onoffswitch-small-label">
                                                                                <span class="onoffswitch-small-inner"></span>
                                                                                <span class="onoffswitch-small-switch"></span>
                                                                            </label>
                                                                        </div>
                                                                    </td>
                                                                <?php } ?>
                                                                <?php if (permissionChecker('student_edit') || permissionChecker('student_delete') || permissionChecker('student_view')) { ?>
                                                                    <td data-title="<?= $this->lang->line('action') ?>">
                                                                        <?php
                                                                        if (($siteinfos->school_year == $this->session->userdata('defaultschoolyearID')) || ($this->session->userdata('usertypeID') == 1)) {
                                                                            echo btn_edit('student/edit/' . $student->studentID . "/", $this->lang->line('edit'));
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                <?php } ?>
                                                            </tr>
                                                            <?php
                                                            $i++;
                                                        }
                                                    } else {
                                                        if (!in_array($student->srstudentID, $existingStudents)) {
                                                            array_push($existingStudents, $student->srstudentID);
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
                                                                <td data-title="<?= $this->lang->line('student_yrs') ?>">
                                                                    <?php echo floor(abs(strtotime(date("Y-m-d")) - strtotime($student->dob)) / (365 * 60 * 60 * 24)); ?>
                                                                </td>
                                                                <!-- <td data-title="<?= $this->lang->line('student_dob') ?>">
                                                                    <?php echo $student->dob; ?>
                                                                </td> -->
                                                                <?php if (permissionChecker('student_edit')) { ?>
                                                                    <td data-title="<?= $this->lang->line('student_status') ?>">
                                                                        <div class="onoffswitch-small" id="<?= $student->srstudentID ?>">
                                                                            <input type="checkbox" id="myonoffswitch<?= $student->srstudentID ?>" class="onoffswitch-small-checkbox" name="paypal_demo" <?php if ($student->active === '1') echo "checked='checked'"; ?>>
                                                                            <label for="myonoffswitch<?= $student->srstudentID ?>" class="onoffswitch-small-label">
                                                                                <span class="onoffswitch-small-inner"></span>
                                                                                <span class="onoffswitch-small-switch"></span>
                                                                            </label>
                                                                        </div>
                                                                    </td>
                                                                <?php } ?>
                                                                <?php if (permissionChecker('student_edit') || permissionChecker('student_delete') || permissionChecker('student_view')) { ?>
                                                                    <td data-title="<?= $this->lang->line('action') ?>">
                                                                        <?php
                                                                        echo anchor('student/view/' . $student->studentID . '/' . $set . '/?tab=files', "<i class='fa fa-file-o'></i>", "class='btn btn-primary btn-large mrg' data-placement='top' data-toggle='tooltip' data-original-title='View Files'");
                                                                        echo btn_view('student/view/' . $student->srstudentID . "/" . $set, $this->lang->line('view'));
                                                                        if (($siteinfos->school_year == $this->session->userdata('defaultschoolyearID')) || ($this->session->userdata('usertypeID') == 1)) {
                                                                            echo btn_edit('student/edit/' . $student->srstudentID . "/" . $set, $this->lang->line('edit'));
                                                                            echo btn_delete('student/delete/' . $student->srstudentID . "/" . $set, $this->lang->line('delete'));
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                <?php } ?>
                                                            </tr>
                                                            <?php
                                                            $i++;
                                                        }
                                                    }
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <?php
                            $existingStudent = array();
                            if ((int) $this->uri->segment(3)) {
                                if (!in_array($student->studentID, $existingStudent)) {
                                    foreach ($sections as $key => $section) {
                                        array_push($existingStudent, $student->studentID);
                                        ?>
                                        <div id="tab<?= $section->classesID . $section->sectionID ?>" class="tab-pane<?= (($this->uri->segment(4) && $this->uri->segment(4) == $section->sectionID) ? ' active' : ''); ?>">
                                            <div id="hide-table">
                                                <table class="table table-striped table-bordered table-hover dataTable no-footer">
                                                    <thead>
                                                        <tr>
                                                            <th class='coachCount'><?= $this->lang->line('slno') ?></th>
                                                            <th class="col-sm-2"><?= $this->lang->line('student_photo') ?></th>
                                                            <th class="col-sm-2"><?= $this->lang->line('student_name') ?></th>
                                                            <th class="col-sm-2"><?= $this->lang->line('student_phone') ?></th>
                                                            <th class="col-sm-1"><?= $this->lang->line('student_yrs') ?></th>
                                                            <!-- <th class="col-sm-2"><?= $this->lang->line('student_dob') ?></th> -->
                                                            <?php if (permissionChecker('student_edit') || permissionChecker('student_delete') || permissionChecker('student_view')) { ?>
                                                                <th class='actionField'><?= $this->lang->line('action') ?></th>
                                                            <?php } ?>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        if (count($allsection[$section->sectionID])) {
                                                            $i = 1;
                                                            foreach ($allsection[$section->sectionID] as $student) {
                                                                if ($section->sectionID === $student->srsectionID) {
                                                                    ?>
                                                                    <tr>
                                                                        <td data-title="<?= $this->lang->line('slno') ?>">
                                                                            <?php echo $student->registerNO; ?>
                                                                        </td>

                                                                        <td data-title="<?= $this->lang->line('student_photo') ?>">
                                                                            <?= profileimage($student->photo) ?>
                                                                        </td>
                                                                        <td data-title="<?= $this->lang->line('student_name') ?>">
                                                                            <?php echo $student->srname; ?>
                                                                        </td>
                                                                        <td data-title="<?= $this->lang->line('student_phone') ?>">
                                                                            <?php echo $student->phone; ?>
                                                                        </td>
                                                                        <td data-title="<?= $this->lang->line('student_yrs') ?>">
                                                                            <?php echo floor(abs(strtotime(date("Y-m-d")) - strtotime($student->dob)) / (365 * 60 * 60 * 24)); ?>
                                                                        </td>
                                                                        <!-- <td data-title="<?= $this->lang->line('student_dob') ?>">
                                                                            <?php echo $student->dob; ?>
                                                                        </td> -->
                                                                        <?php if (permissionChecker('student_edit') || permissionChecker('student_delete') || permissionChecker('student_view')) { ?>
                                                                            <td data-title="<?= $this->lang->line('action') ?>">
                                                                                <?php
                                                                                echo anchor('student/view/' . $student->studentID . '/' . $set . '/?tab=files', "<i class='fa fa-file-o'></i>", "class='btn btn-primary btn-large mrg' data-placement='top' data-toggle='tooltip' data-original-title='View files'");
                                                                                echo btn_view('student/view/' . $student->srstudentID . "/" . $set, $this->lang->line('view'));
                                                                                if (($siteinfos->school_year == $this->session->userdata('defaultschoolyearID')) || ($this->session->userdata('usertypeID') == 1)) {
                                                                                    echo btn_edit('student/edit/' . $student->srstudentID . "/" . $set, $this->lang->line('edit'));
                                                                                    echo btn_delete('student/delete/' . $student->srstudentID . "/" . $set, $this->lang->line('delete'));
                                                                                }
                                                                                ?>
                                                                            </td>
                                                                        <?php } ?>
                                                                    </tr>
                                                                    <?php
                                                                    $i++;
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                            }
                            ?>
                        </div>
                    </div> <!-- nav-tabs-custom -->
                <?php } else { ?>
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#all" aria-expanded="true"><?= $this->lang->line("student_all_students") ?></a></li>
                        </ul>

                        <div class="tab-content">
                            <div id="all" class="tab-pane active">
                                <div id="hide-table">
                                    <table id="example1" class="table table-striped table-bordered table-hover dataTable no-footer">
                                        <thead>
                                            <tr>
                                                <th class='coachCount'><?= $this->lang->line('slno') ?></th>
                                                <th class="col-sm-2"><?= $this->lang->line('student_photo') ?></th>
                                                <th class="col-sm-2"><?= $this->lang->line('student_name') ?></th>
                                                <th class="col-sm-2"><?= $this->lang->line('student_phone') ?></th>
                                                <th class="col-sm-1"><?= $this->lang->line('student_yrs') ?></th>
                                                <!-- <th class="col-sm-2"><?= $this->lang->line('student_dob') ?></th> -->
                                                <?php if (permissionChecker('student_edit')) { ?>
                                                    <th class="col-sm-1"><?= $this->lang->line('student_status') ?></th>
                                                <?php } ?>
                                                <?php if (permissionChecker('student_edit') || permissionChecker('student_delete') || permissionChecker('student_view')) { ?>
                                                    <th class='actionField'><?= $this->lang->line('action') ?></th>
                                                    <?php } ?>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div> <!-- nav-tabs-custom -->
                <?php } ?>
            </div> <!-- col-sm-12 -->
        </div><!-- row -->
    </div><!-- Body -->
</div><!-- /.box -->

<script type="text/javascript">
    $(document).ready(function () {
        $(".coachCount").attr("style", "width: 1px !important;");
        $(".actionField").attr("style", "width: 100px !important;");
    });
    $(".select2").select2();

    $('#classesID').change(function () {
        var classesID = $(this).val();
        if (classesID == 0) {
            $('#hide-table').hide();
            $('.nav-tabs-custom').hide();
        } else {
            $.ajax({
                type: 'POST',
                url: "<?= base_url('student/student_list') ?>",
                data: "id=" + classesID,
                dataType: "html",
                success: function (data) {
                    window.location.href = data;
                }
            });
        }
    });


    var status = '';
    var id = 0;
    $('.onoffswitch-small-checkbox').click(function () {
        if ($(this).prop('checked')) {
            status = 'chacked';
            id = $(this).parent().attr("id");
        } else {
            status = 'unchacked';
            id = $(this).parent().attr("id");
        }

        if ((status != '' || status != null) && (id != '')) {
            $.ajax({
                type: 'POST',
                url: "<?= base_url('student/active') ?>",
                data: "id=" + id + "&status=" + status,
                dataType: "html",
                success: function (data) {
                    if (data == "<?= $this->lang->line("student_success"); ?>") {
                        toastr["success"]("<?= $this->lang->line("student_success"); ?>")
                        toastr.options = {
                            "closeButton": true,
                            "debug": false,
                            "newestOnTop": false,
                            "progressBar": false,
                            "positionClass": "toast-top-right",
                            "preventDuplicates": false,
                            "onclick": null,
                            "showDuration": "500",
                            "hideDuration": "500",
                            "timeOut": "5000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        }
                    } else {
                        toastr["error"]("Error")
                        toastr.options = {
                            "closeButton": true,
                            "debug": false,
                            "newestOnTop": false,
                            "progressBar": false,
                            "positionClass": "toast-top-right",
                            "preventDuplicates": false,
                            "onclick": null,
                            "showDuration": "500",
                            "hideDuration": "500",
                            "timeOut": "5000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        }
                    }
                }
            });
        }
    });
</script>