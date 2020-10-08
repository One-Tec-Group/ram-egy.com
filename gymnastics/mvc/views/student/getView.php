<?php if (count($profile)) { ?>
    <div class="well">
        <div class="row">
            <div class="col-sm-6">
                <?php
                if (!permissionChecker('student_view') && permissionChecker('student_add')) {
                    echo btn_sm_add('student/add', $this->lang->line('add_student'));
                }
                ?>
                <button class="btn-cs btn-large-cs" onclick="javascript:printDiv('printablediv')"><span class="fa fa-print"></span> <?= $this->lang->line('print') ?> </button>
                <?php
                echo btn_add_pdf('student/print_preview/' . $profile->srstudentID . "/" . $set, $this->lang->line('pdf_preview'))
                ?>

                <?php
                if ($siteinfos->school_year == $this->session->userdata('defaultschoolyearID')) {
                    if (permissionChecker('student_edit')) {
                        echo btn_sm_edit('student/edit/' . $profile->srstudentID . "/" . $set, $this->lang->line('edit'));
                    }
                }
                ?>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb">
                    <li><a href="<?= base_url("dashboard/index") ?>"><i class="fa fa-laptop"></i> <?= $this->lang->line('menu_dashboard') ?></a></li>
                    <li><a href="<?= base_url("student/index/$set") ?>"><?= $this->lang->line('menu_student') ?></a></li>
                    <li class="active"><?= $this->lang->line('view') ?></li>
                </ol>
            </div>
        </div>
    </div>

    <div id="printablediv">
        <div class="row">
            <div class="col-sm-3">
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <?= profileviewimage($profile->photo) ?>
                        <h3 class="profile-username text-center"><?= $profile->srname ?></h3>
                        <p class="text-muted text-center" style="font-size:12px"><?= $usertype->usertype ?></p>
                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item" style="background-color: #FFF">
                                <b><?= $this->lang->line('student_registerNO') ?></b> <a class="pull-right"><?= $profile->srregisterNO ?></a>
                            </li>
                            <li class="list-group-item" style="background-color: #FFF">
                                <b><?= $this->lang->line('student_roll') ?></b> <a class="pull-right"><?= $profile->roll ?></a>
                            </li>
                            <li class="list-group-item" style="background-color: #FFF">
                                <b><?= $this->lang->line('student_classes') ?></b> <a class="pull-right"><?= count($class) ? $class->classes : '' ?></a>
                            </li>
                            <li class="list-group-item" style="background-color: #FFF">
                                <b><?= $this->lang->line('student_section') ?></b> <a class="pull-right"><?= count($section) ? $section->section : '' ?></a>
                            </li>
                        </ul>

                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item" style="background-color: #FFF" align="center">
                                <b><?= strtoupper($this->lang->line('student_notes')); ?></b>
                            </li>
                            <li class="list-group-item" style="background-color: #FFF;padding-left:5px;" align="left">
                                <ul style="margin-left: -20px;">
                                    <?php
                                    $this->db->limit(3);
                                    $this->db->order_by("id", "DESC");
                                    $this->db->where("studentID", $studenID);
                                    $query = $this->db->get("notes");
                                    if ($query->num_rows() > 0) {
                                        foreach ($query->result() as $note) {
                                            echo "<li>" . $note->note . " (" . $note->addedby . " - " . date('d-m-Y', strtotime($note->date)) . ")</li><br/>";
                                        }
                                    } else {
                                        echo "<li>0 Notes</li>";
                                    }
                                    ?>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-sm-9">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li<?= (($this->input->get("tab") == NULL || $this->input->get("tab") == "") ? ' class="active"' : ''); ?>><a href="#profile" data-toggle="tab"><?= $this->lang->line('student_profile') ?></a></li>
                        <?php if (count($parents)) { ?> <li><a href="#parents" data-toggle="tab"><?= $this->lang->line('student_parents') ?></a></li> <?php } ?>
                        <?php if ((permissionChecker('student_add') && permissionChecker('student_delete')) || ($this->session->userdata('usertypeID') == $profile->usertypeID && $this->session->userdata('loginuserID') == $profile->srstudentID)) { ?>
                            <li><a href="#routine" data-toggle="tab"><?= $this->lang->line('student_routine') ?></a></li>
                            <li><a href="#attendance" data-toggle="tab"><?= $this->lang->line('student_attendance') ?></a></li>
                            <!-- <li><a href="#mark" data-toggle="tab"><?= $this->lang->line('student_mark') ?></a></li> -->
                            <li><a href="#invoice" data-toggle="tab"><?= $this->lang->line('student_invoice') ?></a></li>
                            <!-- <li><a href="#payment" data-toggle="tab"><?= $this->lang->line('student_payment') ?></a></li> -->
                            <li<?= (($this->input->get("tab") != NULL && $this->input->get("tab") == "files") ? ' class="active"' : ''); ?>><a href="#document" data-toggle="tab"><?= $this->lang->line('student_document') ?></a></li>
                            <li><a href="#notes" data-toggle="tab"><?= $this->lang->line('student_notes') ?></a></li>
                        <?php } ?>
                    </ul>

                    <div class="tab-content">
                        <div class="<?= (($this->input->get("tab") == NULL || $this->input->get("tab") == "") ? 'active ' : ''); ?>tab-pane" id="profile">
                            <div class="panel-body profile-view-dis">
                                <div class="row">

                                    <h3 style="color: #dd4b39"><?= $this->lang->line("player_info") ?></h3>
                                    <hr>

                                    <div class="profile-view-tab">
                                        <p><span><b><?= $this->lang->line("student_name") ?></b></span><?= $profile->name ?></p>
                                    </div>
                                    <div class="profile-view-tab">
                                        <p><span><b><?= $this->lang->line("student_roll") ?></b></span><?= $profile->roll ?></p>
                                    </div>
                                    <div class="profile-view-tab">
                                        <p><span><b><?= $this->lang->line("student_dob") ?></b></span>
                                            <?php
                                            if ($profile->dob) {
                                                echo date("d M Y", strtotime($profile->dob));
                                            }
                                            ?></p>
                                    </div>
                                    <div class="profile-view-tab">
                                        <p><span><b><?= $this->lang->line("student_sex") ?></b></span>
                                            <?= $profile->sex ?></p>
                                    </div>
                                    <div class="profile-view-tab">
                                        <p><span><b><?= $this->lang->line("student_religion") ?></b></span> <?= $profile->religion ?></p>
                                    </div>

                                    <div class="profile-view-tab">
                                        <p><span><b><?= $this->lang->line("student_doj") ?></b></span> <?= $profile->doj ?></p>
                                    </div>

                                    <hr>
                                    <h3 style="color: #dd4b39"><?= $this->lang->line("player_contact") ?></h3>
                                    <hr>

                                    <div class="profile-view-tab">
                                        <p><span><b><?= $this->lang->line("student_email") ?></b></span><?= $profile->email ?></p>
                                    </div>
                                    <div class="profile-view-tab">
                                        <p><span><b><?= $this->lang->line("student_phone") ?></b></span><?= $profile->phone ?></p>
                                    </div>
                                    <div class="profile-view-tab">
                                        <p><span><b><?= $this->lang->line("student_phone") ?> 2</b></span><?= $profile->phone2 ?></p>
                                    </div>
                                    <div class="profile-view-tab">
                                        <p><span><b><?= $this->lang->line("student_address") ?></b></span><?= $profile->address ?></p>
                                    </div>
                                    <div class="profile-view-tab">
                                        <p><span><b><?= $this->lang->line("student_state") ?></b></span><?= $profile->state ?></p>
                                    </div>
                                    <div class="profile-view-tab">
                                        <p><span><b><?= $this->lang->line("student_country") ?></b></span>
                                            <?php
                                            if (isset($allcountry[$profile->country])) {
                                                echo $allcountry[$profile->country];
                                            }
                                            ?></p>
                                    </div>

                                    <hr>
                                    <h3 style="color: #dd4b39"><?= $this->lang->line("player_skills") ?></h3>
                                    <hr>

                                    <div class="profile-view-tab">
                                        <p><span><b><?= $this->lang->line("student_remarks") ?></b></span><?= $profile->remarks ?></p>
                                    </div>
                                    <div class="profile-view-tab">
                                        <p><span><b><?= $this->lang->line("student_extracurricularactivities") ?></b></span> <?= $profile->extracurricularactivities ?></p>
                                    </div>

                                    <div class="profile-view-tab">
                                        <p><span></span></p>
                                    </div>

                                    <hr>
                                    <h3 style="color: #dd4b39"><?= $this->lang->line("player_data") ?></h3>
                                    <hr>

                                    <div class="profile-view-tab">
                                        <p><b><span><?= $this->lang->line("student_height") ?></b></span> <?= $profile->height ?></p>
                                    </div>
                                    <div class="profile-view-tab">
                                        <p><b><span><?= $this->lang->line("student_weight") ?></b></span> <?= $profile->weight ?></p>
                                    </div>
                                    <div class="profile-view-tab">
                                        <p><b><span><?= $this->lang->line("student_foot_size") ?></b></span> <?= $profile->foot_size ?></p>
                                    </div>
                                    <div class="profile-view-tab">
                                        <p><b><span><?= $this->lang->line("student_others") ?></b></span> <?= $profile->others ?></p>
                                    </div>
                                    <div class="profile-view-tab">
                                        <p><b><span><?= $this->lang->line("student_weakness_points") ?></b></span> <?= $profile->weaknes_points ?></p>
                                    </div>
                                    <div class="profile-view-tab">
                                        <p><b><span><?= $this->lang->line("student_strength_points") ?></b></span> <?= $profile->strength_points ?></p>
                                    </div>

                                    <hr>
                                    <h3 style="color: #dd4b39"><?= $this->lang->line("player_medicine") ?></h3>
                                    <hr>

                                    <div class="profile-view-tab">
                                        <p><b><span><?= $this->lang->line("student_previous_injuries") ?></b></span> <?= $profile->previous_injuries ?></p>
                                    </div>
                                    <div class="profile-view-tab">
                                        <p><b><span><?= $this->lang->line("student_surgery") ?></b></span> <?= $profile->surgery ?></p>
                                    </div>
                                    <div class="profile-view-tab">
                                        <p><b><span><?= $this->lang->line("student_allergy") ?></b></span> <?= $profile->allrgy ?></p>
                                    </div>
                                    <div class="profile-view-tab">
                                        <p><b><span><?= $this->lang->line("student_asthma") ?></b></span> <?= $profile->asthma ?></p>
                                    </div>

                                    <hr>
                                    <h3 style="color: #dd4b39"><?= $this->lang->line("player_account") ?></h3>
                                    <hr>

                                    <div class="profile-view-tab">
                                        <p><span><b><?= $this->lang->line("student_username") ?></b></span> <?= $profile->username ?></p>
                                    </div>


                                    <?php
                                    if ($siteinfos->school_year == $this->session->userdata('defaultschoolyearID')) {
                                        if (permissionChecker('student_edit')) {
                                            echo btn_sm_edit('student/edit/' . $profile->srstudentID . "/" . $set, $this->lang->line('student_edit_password'));
                                        }
                                    }
                                    ?>

                                </div>
                            </div>
                        </div>

                        <?php if (count($parents)) { ?>
                            <div class="tab-pane" id="parents">
                                <div class="panel-body profile-view-dis">
                                    <div class="row">

                                        <h3 style="color: #dd4b39"><?= $this->lang->line("parent_info") ?></h3>
                                        <hr>

                                        <div class="profile-view-tab">
                                            <p><span><b><?= $this->lang->line("parent_guargian_name") ?></b></span><?= $parents->name ?></p>
                                        </div>
                                        <div class="profile-view-tab">
                                            <p><span><b><?= $this->lang->line("parent_father_name") ?></b></span><?= $parents->father_name ?></p>
                                        </div>
                                        <div class="profile-view-tab">
                                            <p><span><b><?= $this->lang->line("parent_mother_name") ?></b></span><?= $parents->mother_name ?></p>
                                        </div>
                                        <div class="profile-view-tab">
                                            <p><span><b><?= $this->lang->line("parent_father_profession") ?></b></span><?= $parents->father_profession ?></p>
                                        </div>
                                        <div class="profile-view-tab">
                                            <p><span><b><?= $this->lang->line("parent_mother_profession") ?></b></span><?= $parents->mother_profession ?></p>
                                        </div>
                                        <div class="profile-view-tab">
                                            <p><span></span></p>
                                        </div>

                                        <h3 style="color: #dd4b39"><?= $this->lang->line("player_contact") ?></h3>
                                        <hr>

                                        <div class="profile-view-tab">
                                            <p><span><b><?= $this->lang->line("parent_email") ?></b></span><?= $parents->email ?></p>
                                        </div>
                                        <div class="profile-view-tab">
                                            <p><span><b><?= $this->lang->line("parent_phone") ?></b></span>: <?= $parents->phone ?></p>
                                        </div>
                                        <div class="profile-view-tab">
                                            <p><span><b><?= $this->lang->line("parent_address") ?></b></span><?= $parents->address ?></p>
                                        </div>
                                        <div class="profile-view-tab">
                                            <p><span></span></p>
                                        </div>

                                        <h3 style="color: #dd4b39"><?= $this->lang->line("player_account") ?></h3>
                                        <hr>

                                        <div class="profile-view-tab">
                                            <p><span><b><?= $this->lang->line("parent_username") ?></b></span><?= $parents->username ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <?php if ((permissionChecker('student_add') && permissionChecker('student_delete')) || ($this->session->userdata('usertypeID') == $profile->usertypeID && $this->session->userdata('loginuserID') == $profile->srstudentID)) { ?>

                            <div class="tab-pane" id="routine">
                                <?php
                                $us_days = array('monday' => $this->lang->line('monday'), 'tuesday' => $this->lang->line('tuesday'), 'wednesday' => $this->lang->line('wednesday'), 'thursday' => $this->lang->line('thursday'), 'friday' => $this->lang->line('friday'), 'saturday' => $this->lang->line('saturday'), 'sunday' => $this->lang->line('sunday'));
                                $dayArrays = array();
                                if (count($routines)) { ?>
                                    <?php
                                    $maxClass = 0;
                                    foreach ($routines as $routineKey => $routine) {
                                        if (count($routine) > $maxClass) {
                                            $maxClass = count($routine);
                                        }
                                        array_push($dayArrays, $routineKey);
                                    }
                                    //$dayArrays = array('Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday');
                                    ?>

                                    <div class="table-responsive">
                                        <table class="table table-bordered table-responsive">
                                            <thead>
                                            <th class="text-center"><?php echo $this->lang->line('student_day'); ?></th>
                                            <?php
                                            for ($i = 1; $i <= $maxClass; $i++) {
                                                ?>
                                                <th class="text-center"><?= $this->lang->line('student_period'); ?></th>
                                                <?php
                                            }
                                            ?>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($dayArrays as $dayArray) { ?>
                                                    <?php if (!in_array($dayArray, $routineweekends)) { ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo $us_days[$dayArray]; ?>
                                                            </td>
                                                            <?php if (isset($routines[$dayArray])) { ?>
                                                                <?php
                                                                $i = 0;
                                                                foreach ($routines[$dayArray] as $routineDayArrayKey => $routineDayArray) {
                                                                    $i++;
                                                                    ?>
                                                                    <td class="text-center">
                                                                        <p style="margin: 0 0 1px"><?= $routineDayArray->start_time; ?>-<?= $routineDayArray->end_time; ?></p>
                                                                        <p style="margin: 0 0 1px">
                                                                            <span class="left"><?= $this->lang->line('student_teacher') ?> :</span>
                                                                            <span class="right">
                                                                                <?php
                                                                                if (isset($teachers[$routineDayArray->teacherID])) {
                                                                                    echo $teachers[$routineDayArray->teacherID];
                                                                                }
                                                                                ?>
                                                                            </span>
                                                                        </p>
                                                                        <p style="margin: 0 0 1px"><span class="left"><?= $this->lang->line('student_room') ?> : </span><span class="right"><?= $routineDayArray->room; ?></span></p>
                                                                    </td>
                                                                    <?php
                                                                }
                                                                $j = ($maxClass - $i);
                                                                if ($i < $maxClass) {
                                                                    ?>
                                                                    <?php for ($i = 1; $i <= $j; $i++) { ?>
                                                                        <td>
                                                                            N/A
                                                                        </td>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            <?php } else { ?>
                                                                <?php for ($i = 1; $i <= $maxClass; $i++) { ?>
                                                                    <td>
                                                                        N/A
                                                                    </td>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        </tr>
                                                    <?php } ?>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php } ?>
                            </div>

                            <div class="tab-pane" id="attendance">
                                <?php
                                $monthArray = array(
                                    "01" => "jan", "02" => "feb", "03" => "mar", "04" => "apr", "05" => "may", "06" => "jun", "07" => "jul", "08" => "aug", "09" => "sep", "10" => "oct", "11" => "nov", "12" => "dec");
                                ?>
                                <?php
                                if ($setting->attendance == 'subject') {

                                    if (count($attendancesubjects)) {
                                        foreach ($attendancesubjects as $subject) {
                                            $holidayCount = 0;
                                            $weekendayCount = 0;
                                            $leavedayCount = 0;
                                            $presentCount = 0;
                                            $lateexcuseCount = 0;
                                            $lateCount = 0;
                                            $absentCount = 0;
                                            if ($subject->type === '1') {
                                                echo "<h4>" . $subject->subject . "</h4>";
                                                ?>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="studentDIV">
                                                            <table class="attendance_table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <?php
                                                                        for ($i = 1; $i <= 31; $i++) {
                                                                            echo "<th>" . $this->lang->line('student_' . $i) . "</th>";
                                                                        }
                                                                        ?>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    $schoolyearstartingdate = $schoolyearsessionobj->startingdate;
                                                                    $schoolyearendingdate = $schoolyearsessionobj->endingdate;

                                                                    $allMonths = get_month_and_year_using_two_date($schoolyearstartingdate, $schoolyearendingdate);
                                                                    $holidaysArray = explode('","', $holidays);

                                                                    $allMonthsArray = array();

                                                                    foreach ($allMonths as $yearKey => $allMonth) {
                                                                        if ($yearKey == date("Y", strtotime(date("d-m-Y")))) {
                                                                            foreach ($allMonth as $month) {
                                                                                $mmonth = (int) $month;
                                                                                $monthAndYear = $month . '-' . $yearKey;
                                                                                if (isset($attendances_subjectwisess[$subject->subjectID][$monthAndYear])) {
                                                                                    $attendanceMonthAndYear = $attendances_subjectwisess[$subject->subjectID][$monthAndYear];
                                                                                    echo "<tr>";
                                                                                    echo "<td>" . ucwords($monthArray[$month]) . "</td>";
                                                                                    for ($i = 1; $i <= 31; $i++) {
                                                                                        $acolumnname = 'a' . $i;
                                                                                        $d = sprintf('%02d', $i);

                                                                                        $date = $d . "-" . $month . "-" . $yearKey;
                                                                                        if ($i > cal_days_in_month(CAL_GREGORIAN, $mmonth, $yearKey) || !(in_array(strtolower(date("l", strtotime($date))), $dayArrays))) {
                                                                                            echo "<td></td>";
                                                                                        }elseif (in_array($date, $holidaysArray)) {
                                                                                            $holidayCount++;
                                                                                            echo "<td class='ini-bg-primary'>" . 'H' . "</td>";
                                                                                        } elseif (in_array($date, $getWeekendDays)) {
                                                                                            $weekendayCount++;
                                                                                            echo "<td class='ini-bg-info'>" . 'W' . "</td>";
                                                                                        } elseif (in_array($date, $leaveapplications)) {
                                                                                            $leavedayCount++;
                                                                                            echo "<td class='ini-bg-success'>" . 'LA' . "</td>";
                                                                                        } else {
                                                                                            $textcolorclass = '';
                                                                                            $val = false;
                                                                                            if (isset($attendanceMonthAndYear) && $attendanceMonthAndYear->$acolumnname == 'P') {
                                                                                                $presentCount++;
                                                                                                $textcolorclass = 'ini-bg-success';
                                                                                            } elseif (isset($attendanceMonthAndYear) && $attendanceMonthAndYear->$acolumnname == 'LE') {
                                                                                                $lateexcuseCount++;
                                                                                                $textcolorclass = 'ini-bg-success';
                                                                                            } elseif (isset($attendanceMonthAndYear) && $attendanceMonthAndYear->$acolumnname == 'L') {
                                                                                                $lateCount++;
                                                                                                $textcolorclass = 'ini-bg-success';
                                                                                            } elseif (isset($attendanceMonthAndYear) && $attendanceMonthAndYear->$acolumnname == 'A') {
                                                                                                $absentCount++;
                                                                                                $textcolorclass = 'ini-bg-danger';
                                                                                            } elseif ((isset($attendanceMonthAndYear) && ($attendanceMonthAndYear->$acolumnname == NULL || $attendanceMonthAndYear->$acolumnname == ''))) {
                                                                                                $textcolorclass = 'ini-bg-secondary';
                                                                                                $defaultVal = 'N/A';
                                                                                                $val = true;
                                                                                            }

                                                                                            if ($val) {
                                                                                                echo "<td class='" . $textcolorclass . "'>" . $defaultVal . "</td>";
                                                                                            } else {
                                                                                                echo "<td class='" . $textcolorclass . "'>" . $attendanceMonthAndYear->$acolumnname . "</td>";
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                    echo "</tr>";
                                                                                } else {
                                                                                    echo "<tr>";
                                                                                    echo "<td>" . ucwords($monthArray[$month]) . "</td>";
                                                                                    for ($i = 1; $i <= 31; $i++) {
                                                                                        $acolumnname = 'a' . $i;
                                                                                        $d = sprintf('%02d', $i);

                                                                                        $date = $d . "-" . $month . "-" . $yearKey;
                                                                                        if ($i > cal_days_in_month(CAL_GREGORIAN, $mmonth, $yearKey) || !(in_array(strtolower(date("l", strtotime($date))), $dayArrays))) {
                                                                                            echo "<td></td>";
                                                                                        }elseif (in_array($date, $holidaysArray)) {
                                                                                            $holidayCount++;
                                                                                            echo "<td class='ini-bg-primary'>" . 'H' . "</td>";
                                                                                        } elseif (in_array($date, $getWeekendDays)) {
                                                                                            $weekendayCount++;
                                                                                            echo "<td class='ini-bg-info'>" . 'W' . "</td>";
                                                                                        } elseif (in_array($date, $leaveapplications)) {
                                                                                            $leavedayCount++;
                                                                                            echo "<td class='ini-bg-success'>" . 'LA' . "</td>";
                                                                                        } else {
                                                                                            $textcolorclass = 'ini-bg-secondary';
                                                                                            echo "<td class='" . $textcolorclass . "'>" . 'N/A' . "</td>";
                                                                                        }
                                                                                    }
                                                                                    echo "</tr>";
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                    ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <p class="totalattendanceCount pull-left">
                                                          <?php
                                                          // echo $this->lang->line('student_total_holiday') . ': ' . $holidayCount . ', ';
                                                          // echo $this->lang->line('student_total_weekenday') . ': ' . $weekendayCount . ', ';
                                                          // echo $this->lang->line('student_total_leaveday') . ': ' . $leavedayCount . ', ';
                                                          echo $this->lang->line('student_total_present') . ': ' . $presentCount . ', ';
                                                          // echo $this->lang->line('student_total_latewithexcuse') . ': ' . $lateexcuseCount . ', ';
                                                          // echo $this->lang->line('student_total_late') . ': ' . $lateCount . ', ';
                                                          echo $this->lang->line('student_total_absent') . ': ' . $absentCount;
                                                          ?>
                                                        </p>
                                                        <p class="pull-right">FOR YEAR: <b><?= date("Y"); ?></b></p>
                                                    </div>
                                                </div>
                                                <br/>
                                                <?php
                                            } else {
                                                if ($subject->subjectID == $profile->sroptionalsubjectID) {
                                                    ?>
                                                    <h4><?= $subject->subject; ?></h4>
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="studentDIV">
                                                                <table class="attendance_table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>#</th>
                                                                            <?php
                                                                            for ($i = 1; $i <= 31; $i++) {
                                                                                echo "<th>" . $this->lang->line('student_' . $i) . "</th>";
                                                                            }
                                                                            ?>
                                                                        </tr>1
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        $schoolyearstartingdate = $schoolyearsessionobj->startingdate;
                                                                        $schoolyearendingdate = $schoolyearsessionobj->endingdate;

                                                                        $allMonths = get_month_and_year_using_two_date($schoolyearstartingdate, $schoolyearendingdate);
                                                                        $holidaysArray = explode('","', $holidays);

                                                                        $allMonthsArray = array();

                                                                        foreach ($allMonths as $yearKey => $allMonth) {
                                                                            if ($yearKey == date("Y", strtotime(date("d-m-Y")))) {
                                                                                foreach ($allMonth as $month) {
                                                                                    $mmonth = (int) $month;
                                                                                    $monthAndYear = $month . '-' . $yearKey;
                                                                                    if (isset($attendances_subjectwisess[$subject->subjectID][$monthAndYear])) {
                                                                                        $attendanceMonthAndYear = $attendances_subjectwisess[$subject->subjectID][$monthAndYear];
                                                                                        echo "<tr>";
                                                                                        echo "<td>" . ucwords($monthArray[$month]) . "</td>";
                                                                                        for ($i = 1; $i <= 31; $i++) {
                                                                                            $acolumnname = 'a' . $i;
                                                                                            $d = sprintf('%02d', $i);

                                                                                            $date = $d . "-" . $month . "-" . $yearKey;
                                                                                            if ($i > cal_days_in_month(CAL_GREGORIAN, $mmonth, $yearKey) || !(in_array(strtolower(date("l", strtotime($date))), $dayArrays))) {
                                                                                                echo "<td></td>";
                                                                                            }elseif (in_array($date, $holidaysArray)) {
                                                                                                $holidayCount++;
                                                                                                echo "<td class='ini-bg-primary'>" . 'H' . "</td>";
                                                                                            } elseif (in_array($date, $getWeekendDays)) {
                                                                                                $weekendayCount++;
                                                                                                echo "<td class='ini-bg-info'>" . 'W' . "</td>";
                                                                                            } elseif (in_array($date, $leaveapplications)) {
                                                                                                $leavedayCount++;
                                                                                                echo "<td class='ini-bg-success'>" . 'LA' . "</td>";
                                                                                            } else {
                                                                                                $textcolorclass = '';
                                                                                                $val = false;
                                                                                                if (isset($attendanceMonthAndYear) && $attendanceMonthAndYear->$acolumnname == 'P') {
                                                                                                    $presentCount++;
                                                                                                    $textcolorclass = 'ini-bg-success';
                                                                                                } elseif (isset($attendanceMonthAndYear) && $attendanceMonthAndYear->$acolumnname == 'LE') {
                                                                                                    $lateexcuseCount++;
                                                                                                    $textcolorclass = 'ini-bg-success';
                                                                                                } elseif (isset($attendanceMonthAndYear) && $attendanceMonthAndYear->$acolumnname == 'L') {
                                                                                                    $lateCount++;
                                                                                                    $textcolorclass = 'ini-bg-success';
                                                                                                } elseif (isset($attendanceMonthAndYear) && $attendanceMonthAndYear->$acolumnname == 'A') {
                                                                                                    $absentCount++;
                                                                                                    $textcolorclass = 'ini-bg-danger';
                                                                                                } elseif ((isset($attendanceMonthAndYear) && ($attendanceMonthAndYear->$acolumnname == NULL || $attendanceMonthAndYear->$acolumnname == ''))) {
                                                                                                    $textcolorclass = 'ini-bg-secondary';
                                                                                                    $defaultVal = 'N/A';
                                                                                                    $val = true;
                                                                                                }

                                                                                                if ($val) {
                                                                                                    echo "<td class='" . $textcolorclass . "'>" . $defaultVal . "</td>";
                                                                                                } else {
                                                                                                    echo "<td class='" . $textcolorclass . "'>" . $attendanceMonthAndYear->$acolumnname . "</td>";
                                                                                                }
                                                                                            }
                                                                                        }
                                                                                        echo "</tr>";
                                                                                    } else {

                                                                                        echo "<tr>";
                                                                                        echo "<td>" . ucwords($monthArray[$month]) . "</td>";
                                                                                        for ($i = 1; $i <= 31; $i++) {
                                                                                            $acolumnname = 'a' . $i;
                                                                                            $d = sprintf('%02d', $i);

                                                                                            $date = $d . "-" . $month . "-" . $yearKey;
                                                                                            if ($i > cal_days_in_month(CAL_GREGORIAN, $mmonth, $yearKey) || !(in_array(strtolower(date("l", strtotime($date))), $dayArrays))) {
                                                                                                echo "<td></td>";
                                                                                            }elseif (in_array($date, $holidaysArray)) {
                                                                                                $holidayCount++;
                                                                                                echo "<td class='ini-bg-primary'>" . 'H' . "</td>";
                                                                                            } elseif (in_array($date, $getWeekendDays)) {
                                                                                                $weekendayCount++;
                                                                                                echo "<td class='ini-bg-info'>" . 'W' . "</td>";
                                                                                            } elseif (in_array($date, $leaveapplications)) {
                                                                                                $leavedayCount++;
                                                                                                echo "<td class='ini-bg-success'>" . 'LA' . "</td>";
                                                                                            } else {
                                                                                                $textcolorclass = 'ini-bg-secondary';
                                                                                                echo "<td class='" . $textcolorclass . "'>" . 'N/A' . "</td>";
                                                                                            }
                                                                                        }
                                                                                        echo "</tr>";
                                                                                    }
                                                                                }
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <p class="totalattendanceCount pull-left">
                                                            <?php
                                                            // echo $this->lang->line('student_total_holiday') . ': ' . $holidayCount . ', ';
                                                            // echo $this->lang->line('student_total_weekenday') . ': ' . $weekendayCount . ', ';
                                                            // echo $this->lang->line('student_total_leaveday') . ': ' . $leavedayCount . ', ';
                                                            echo $this->lang->line('student_total_present') . ': ' . $presentCount . ', ';
                                                            // echo $this->lang->line('student_total_latewithexcuse') . ': ' . $lateexcuseCount . ', ';
                                                            // echo $this->lang->line('student_total_late') . ': ' . $lateCount . ', ';
                                                            echo $this->lang->line('student_total_absent') . ': ' . $absentCount;
                                                            ?>
                                                            </p>
                                                            <p class="pull-right">FOR YEAR: <b><?= date("Y"); ?></b></p>
                                                        </div>
                                                    </div>
                                                    <br/>
                                                    <?php
                                                }
                                            }
                                        }
                                    }
                                    ?>
                                    <?php
                                } else {
                                    $holidayCount = 0;
                                    $weekendayCount = 0;
                                    $leavedayCount = 0;
                                    $presentCount = 0;
                                    $lateexcuseCount = 0;
                                    $lateCount = 0;
                                    $absentCount = 0;
                                    ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="studentDIV">
                                                <table class="attendance_table">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <?php
                                                            for ($i = 1; $i <= 31; $i++) {
                                                                echo "<th>" . $this->lang->line('student_' . $i) . "</th>";
                                                            }
                                                            ?>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $schoolyearstartingdate = $schoolyearsessionobj->startingdate;
                                                        $schoolyearendingdate = $schoolyearsessionobj->endingdate;
                                                        $allMonths = get_month_and_year_using_two_date($schoolyearstartingdate, $schoolyearendingdate);
                                                        $holidaysArray = explode('","', $holidays);

                                                        foreach ($allMonths as $yearKey => $months) {
                                                            if ($yearKey == date("Y", strtotime(date("d-m-Y")))) {
                                                                foreach ($months as $month) {
                                                                    $mmonth = (int) $month;
                                                                    $monthyear = $month . "-" . $yearKey;
                                                                    if (isset($attendancesArray[$monthyear])) {
                                                                        echo "<tr>";
                                                                        echo "<td>" . ucwords($monthArray[$month]) . "</td>";
                                                                        for ($i = 1; $i <= 31; $i++) {
                                                                            $acolumnname = 'a' . $i;
                                                                            $d = sprintf('%02d', $i);
                                                                            $date = $d . "-" . $month . "-" . $yearKey;
                                                                            if ($i > cal_days_in_month(CAL_GREGORIAN, $mmonth, $yearKey) || !(in_array(strtolower(date("l", strtotime($date))), $dayArrays))) {
                                                                                echo "<td></td>";
                                                                            }elseif (in_array($date, $holidaysArray)) {
                                                                                $holidayCount++;
                                                                                echo "<td class='ini-bg-primary'>" . 'H' . "</td>";
                                                                            } elseif (in_array($date, $getWeekendDays)) {
                                                                                $weekendayCount++;
                                                                                echo "<td class='ini-bg-info'>" . 'W' . "</td>";
                                                                            } elseif (in_array($date, $leaveapplications)) {
                                                                                $leavedayCount++;
                                                                                echo "<td class='ini-bg-success'>" . 'LA' . "</td>";
                                                                            } else {
                                                                                $textcolorclass = '';
                                                                                $val = false;
                                                                                if (isset($attendancesArray[$monthyear]) && $attendancesArray[$monthyear]->$acolumnname == 'P') {
                                                                                    $presentCount++;
                                                                                    $textcolorclass = 'ini-bg-success';
                                                                                } elseif (isset($attendancesArray[$monthyear]) && $attendancesArray[$monthyear]->$acolumnname == 'LE') {
                                                                                    $lateexcuseCount++;
                                                                                    $textcolorclass = 'ini-bg-success';
                                                                                } elseif (isset($attendancesArray[$monthyear]) && $attendancesArray[$monthyear]->$acolumnname == 'L') {
                                                                                    $lateCount++;
                                                                                    $textcolorclass = 'ini-bg-success';
                                                                                } elseif (isset($attendancesArray[$monthyear]) && $attendancesArray[$monthyear]->$acolumnname == 'A') {
                                                                                    $absentCount++;
                                                                                    $textcolorclass = 'ini-bg-danger';
                                                                                } elseif ((isset($attendancesArray[$monthyear]) && ($attendancesArray[$monthyear]->$acolumnname == NULL || $attendancesArray[$monthyear]->$acolumnname == ''))) {
                                                                                    $textcolorclass = 'ini-bg-secondary';
                                                                                    $defaultVal = 'N/A';
                                                                                    $val = true;
                                                                                }

                                                                                if ($val) {
                                                                                    echo "<td class='" . $textcolorclass . "'>" . $defaultVal . "</td>";
                                                                                } else {
                                                                                    echo "<td class='" . $textcolorclass . "'>" . $attendancesArray[$monthyear]->$acolumnname . "</td>";
                                                                                }
                                                                            }
                                                                        }
                                                                        echo "</tr>";
                                                                    } else {
                                                                        $monthyear = $month . "-" . $yearKey;
                                                                        echo "<tr>";
                                                                        echo "<td>" . ucwords($monthArray[$month]) . "</td>";
                                                                        for ($i = 1; $i <= 31; $i++) {
                                                                            $acolumnname = 'a' . $i;
                                                                            $d = sprintf('%02d', $i);

                                                                            $date = $d . "-" . $month . "-" . $yearKey;
                                                                            if ($i > cal_days_in_month(CAL_GREGORIAN, $mmonth, $yearKey) || !(in_array(strtolower(date("l", strtotime($date))), $dayArrays))) {
                                                                                echo "<td></td>";
                                                                            }elseif (in_array($date, $holidaysArray)) {
                                                                                $holidayCount++;
                                                                                echo "<td class='ini-bg-primary'>" . 'H' . "</td>";
                                                                            } elseif (in_array($date, $getWeekendDays)) {
                                                                                $weekendayCount++;
                                                                                echo "<td class='ini-bg-info'>" . 'W' . "</td>";
                                                                            } elseif (in_array($date, $leaveapplications)) {
                                                                                $leavedayCount++;
                                                                                echo "<td class='ini-bg-success'>" . 'LA' . "</td>";
                                                                            } else {
                                                                                $textcolorclass = 'ini-bg-secondary';
                                                                                echo "<td class='" . $textcolorclass . "'>" . 'N/A' . "</td>";
                                                                            }
                                                                        }
                                                                        echo "</tr>";
                                                                    }
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <p class="totalattendanceCount pull-left">
                                            <?php
                                            // echo $this->lang->line('student_total_holiday') . ': ' . $holidayCount . ', ';
                                            // echo $this->lang->line('student_total_weekenday') . ': ' . $weekendayCount . ', ';
                                            // echo $this->lang->line('student_total_leaveday') . ': ' . $leavedayCount . ', ';
                                            echo $this->lang->line('student_total_present') . ': ' . $presentCount . ', ';
                                            // echo $this->lang->line('student_total_latewithexcuse') . ': ' . $lateexcuseCount . ', ';
                                            // echo $this->lang->line('student_total_late') . ': ' . $lateCount . ', ';
                                            echo $this->lang->line('student_total_absent') . ': ' . $absentCount;
                                            ?>
                                            </p>
                                            <p class="pull-right">FOR YEAR: <b><?= date("Y"); ?></b></p>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>

                            <div class="tab-pane" id="mark">
                                <?php
                                $subjectCount = count($mandatorysubjects);
                                if ($profile->sroptionalsubjectID > 0) {
                                    if (isset($optionalsubjects[$profile->sroptionalsubjectID])) {
                                        $subjectCount++;
                                    }
                                }

                                if (count($exams)) {
                                    foreach ($exams as $exam) {
                                        if (isset($marks[$exam->examID])) {
                                            if (count($marks[$exam->examID])) {
                                                echo '<div style="border-top:1px solid #23292F; border-left:1px solid #23292F; border-right:1px solid #23292F; border-bottom:1px solid #23292F;" class="box" id="e' . $exam->examID . '">';

                                                $headerColor = ['bg-sky', 'bg-purple-shipu', 'bg-sky-total-grade', 'bg-sky-light', 'bg-sky-total'];

                                                echo '<div class="box-header" style="background-color:#FFFFFF;">';
                                                echo '<h3 class="box-title" style="color:#23292F;">';
                                                echo $exam->exam;
                                                echo '</h3>';
                                                echo '</div>';

                                                echo '<div class="box-body mark-bodyID" style="border-top:1px solid #23292F;">';
                                                $totalMark = 0;
                                                echo "<table class=\"table table-striped table-bordered\" >";
                                                echo "<thead>";
                                                echo "<tr>";
                                                echo "<th class='text-center' rowspan='2' style='background-color:#395C7F;color:#fff;'>";
                                                echo $this->lang->line("student_subject");
                                                echo "</th>";
                                                $headerCount = 1;
                                                foreach ($markpercentages as $markpercentage) {
                                                    $color = 'bg-aqua';
                                                    if ($headerCount % 2 == 0) {
                                                        $color = 'bg-aqua';
                                                    }
                                                    echo "<th colspan='2' class=' text-center' style='background-color:#395C7F;color:#fff;'>";
                                                    echo $markpercentage->markpercentagetype;
                                                    echo "</th>";
                                                    $headerCount++;
                                                }
                                                echo "<th colspan='3' class='text-center ' style='background-color:#395C7F;color:#fff;'>";
                                                echo $this->lang->line("student_total");
                                                echo "</th>";
                                                echo "</tr>";
                                                echo "<tr>";
                                                foreach ($markpercentages as $value) {
                                                    echo "<th class='" . $headerColor[0] . " text-center '>";
                                                    echo $this->lang->line("student_mark");
                                                    echo "</th>";

                                                    echo "<th class='" . $headerColor[3] . " text-center' data-title='" . $this->lang->line('student_highest_mark') . "'>";
                                                    echo $this->lang->line("student_highest_mark");
                                                    echo "</th>";
                                                }
                                                echo "<th class='" . $headerColor[4] . " text-center'>";
                                                echo $this->lang->line("student_mark");
                                                echo "</th>";
                                                echo "<th class='" . $headerColor[1] . " text-center' data-title='" . $this->lang->line('student_point') . "'>";
                                                echo $this->lang->line("student_point");
                                                echo "</th>";
                                                echo "<th class='" . $headerColor[2] . " text-center' data-title='" . $this->lang->line('student_grade') . "'>";
                                                echo $this->lang->line("student_grade");
                                                echo "</th>";
                                                echo "</tr>";
                                                echo "</thead>";

                                                echo "<tbody>";
                                                if (count($mandatorysubjects)) {
                                                    foreach ($mandatorysubjects as $mandatorysubject) {
                                                        echo "<tr>";
                                                        echo "<td class='text-black' data-title='" . $this->lang->line('student_subject') . "'>";
                                                        echo $mandatorysubject->subject;
                                                        echo "</td>";

                                                        $totalSubjectMark = 0;
                                                        foreach ($markpercentages as $markpercentage) {
                                                            echo "<td class='text-black' data-title='" . $this->lang->line('student_mark') . "'>";
                                                            if (isset($marks[$exam->examID][$mandatorysubject->subjectID][$markpercentage->markpercentageID])) {
                                                                echo $marks[$exam->examID][$mandatorysubject->subjectID][$markpercentage->markpercentageID];

                                                                $totalSubjectMark += $marks[$exam->examID][$mandatorysubject->subjectID][$markpercentage->markpercentageID];
                                                            } else {
                                                                echo 'N/A';
                                                            }

                                                            echo "</td>";
                                                            echo "<td class='text-black' data-title='" . $this->lang->line('student_highest_mark') . "'>";
                                                            if (isset($hightmarks[$exam->examID][$mandatorysubject->subjectID][$markpercentage->markpercentageID]) && ($hightmarks[$exam->examID][$mandatorysubject->subjectID][$markpercentage->markpercentageID] != -1)) {
                                                                echo $hightmarks[$exam->examID][$mandatorysubject->subjectID][$markpercentage->markpercentageID];
                                                            } else {
                                                                echo 'N/A';
                                                            }
                                                            echo "</td>";
                                                        }

                                                        echo "<td class='text-black' data-title='" . $this->lang->line('student_mark') . "'>";
                                                        echo $totalSubjectMark;
                                                        $totalMark += $totalSubjectMark;
                                                        echo "</td>";


                                                        if (count($grades)) {
                                                            foreach ($grades as $grade) {
                                                                if ($grade->gradefrom <= floor($totalSubjectMark) && $grade->gradeupto >= floor($totalSubjectMark)) {
                                                                    echo "<td class='text-black' data-title='" . $this->lang->line('student_point') . "'>";
                                                                    echo $grade->point;
                                                                    echo "</td>";
                                                                    echo "<td class='text-black' data-title='" . $this->lang->line('student_grade') . "'>";
                                                                    echo $grade->grade;
                                                                    echo "</td>";
                                                                }
                                                            }
                                                        } else {
                                                            echo "<td class='text-black' data-title='" . $this->lang->line('student_point') . "'>";
                                                            echo 'N/A';
                                                            echo '</td>';
                                                            echo "<td class='text-black' data-title='" . $this->lang->line('student_grade') . "'>";
                                                            echo 'N/A';
                                                            echo '</td>';
                                                        }
                                                        echo '</tr>';
                                                    }
                                                }

                                                if ($profile->sroptionalsubjectID) {
                                                    if (isset($optionalsubjects[$profile->sroptionalsubjectID])) {
                                                        echo "<tr>";
                                                        echo "<td class='text-black' data-title='" . $this->lang->line('student_subject') . "'>";
                                                        echo $optionalsubjects[$profile->sroptionalsubjectID];
                                                        echo "</td>";

                                                        $totalSubjectMark = 0;
                                                        foreach ($markpercentages as $markpercentage) {
                                                            echo "<td class='text-black' data-title='" . $this->lang->line('student_mark') . "'>";
                                                            if (isset($marks[$exam->examID][$profile->sroptionalsubjectID][$markpercentage->markpercentageID])) {
                                                                echo $marks[$exam->examID][$profile->sroptionalsubjectID][$markpercentage->markpercentageID];

                                                                $totalSubjectMark += $marks[$exam->examID][$profile->sroptionalsubjectID][$markpercentage->markpercentageID];
                                                            } else {
                                                                echo 'N/A';
                                                            }
                                                            echo "</td>";
                                                            echo "<td class='text-black' data-title='" . $this->lang->line('student_highest_mark') . "'>";
                                                            if (isset($hightmarks[$exam->examID][$profile->sroptionalsubjectID][$markpercentage->markpercentageID]) && ($hightmarks[$exam->examID][$profile->sroptionalsubjectID][$markpercentage->markpercentageID] != -1)) {
                                                                echo $hightmarks[$exam->examID][$profile->sroptionalsubjectID][$markpercentage->markpercentageID];
                                                            } else {
                                                                echo 'N/A';
                                                            }
                                                            echo "</td>";
                                                        }

                                                        echo "<td class='text-black' data-title='" . $this->lang->line('student_mark') . "'>";
                                                        echo $totalSubjectMark;
                                                        $totalMark += $totalSubjectMark;
                                                        echo "</td>";

                                                        if (count($grades)) {
                                                            foreach ($grades as $grade) {
                                                                if ($grade->gradefrom <= floor($totalSubjectMark) && $grade->gradeupto >= floor($totalSubjectMark)) {
                                                                    echo "<td class='text-black' data-title='" . $this->lang->line('student_point') . "'>";
                                                                    echo $grade->point;
                                                                    echo "</td>";
                                                                    echo "<td class='text-black' data-title='" . $this->lang->line('student_grade') . "'>";
                                                                    echo $grade->grade;
                                                                    echo "</td>";
                                                                }
                                                            }
                                                        } else {
                                                            echo "<td class='text-black' data-title='" . $this->lang->line('student_point') . "'>";
                                                            echo 'N/A';
                                                            echo '</td>';
                                                            echo "<td class='text-black' data-title='" . $this->lang->line('student_grade') . "'>";
                                                            echo 'N/A';
                                                            echo '</td>';
                                                        }
                                                        echo '</tr>';
                                                    }
                                                }
                                                echo "</tbody>";
                                                echo '</table>';

                                                echo '<div class="box-footer" style="padding-left:0px;">';
                                                $totalAverageMark = ($totalMark == 0) ? 0 : (($subjectCount > 0) ? ($totalMark / $subjectCount) : 0);
                                                echo '<p class="text-black">' . $this->lang->line('student_total_marks') . ' : <span class="text-red text-bold">' . number_format((float) ($totalMark), 2, '.', '') . '</span>';
                                                echo '&nbsp;&nbsp;&nbsp;&nbsp;' . $this->lang->line('student_average_marks') . ' : <span class="text-red text-bold">' . number_format((float) ($totalAverageMark), 2, '.', '') . '</span>';
                                                if (count($grades)) {
                                                    foreach ($grades as $grade) {
                                                        if ($grade->gradefrom <= floor($totalAverageMark) && $grade->gradeupto >= floor($totalAverageMark)) {
                                                            echo '&nbsp;&nbsp;&nbsp;&nbsp;' . $this->lang->line('student_average_point') . ' : <span class="text-red text-bold">' . $grade->point . '</span>';
                                                            echo '&nbsp;&nbsp;&nbsp;&nbsp;' . $this->lang->line('student_average_grade') . ' : <span class="text-red text-bold">' . $grade->grade . '</span>';
                                                        }
                                                    }
                                                }
                                                echo '</p>';
                                                echo '</div>';

                                                echo '</div>';



                                                echo '</div>';
                                            }
                                        }
                                    }
                                }
                                ?>
                            </div>

                            <div class="tab-pane" id="invoice">
                                <div id="hide-table">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th><?= $this->lang->line('student_invoice_no') ?></th>
                                                <th><?= $this->lang->line('student_feetype') ?></th>
                                                <th><?= $this->lang->line('student_date') ?></th>
                                                <th><?= $this->lang->line('student_status') ?></th>
                                                <th><?= $this->lang->line('student_fees_amount') ?></th>
                                                <th><?= $this->lang->line('student_discount') ?></th>
                                                <th><?= $this->lang->line('student_paid') ?></th>
                                                <th><?= $this->lang->line('student_due') ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $totalInvoice = 0;
                                            $totalDiscount = 0;
                                            $totalPaid = 0;
                                            $totalWeaver = 0;
                                            $totalDue = 0;
                                            $totalFine = 0;
                                            if (count($invoices)) {
                                                $i = 1;
                                                foreach ($invoices as $invoice) {
                                                    ?>
                                                    <tr>
                                                        <td data-title="<?= $this->lang->line('student_invoice_no') ?>">
                                                            <?php echo "<a href='" . base_url("invoice/view/" . $invoice->maininvoiceID) . "'>000" . (($invoice->maininvoiceID * 10)) . "</a>"; ?>
                                                        </td>

                                                        <td data-title="<?= $this->lang->line('student_feetype') ?>">
                                                            <?= isset($feetypes[$invoice->feetypeID]) ? $feetypes[$invoice->feetypeID] : '' ?>
                                                        </td>

                                                        <td data-title="<?= $this->lang->line('student_date') ?>">
                                                            <?= !empty($invoice->date) ? date('d M Y', strtotime($invoice->date)) : '' ?>
                                                        </td>

                                                        <td data-title="<?= $this->lang->line('student_status') ?>">
                                                            <?php
                                                            $status = $invoice->paidstatus;
                                                            $setButton = '';
                                                            if ($status == 0) {
                                                                $status = $this->lang->line('student_notpaid');
                                                                $setButton = 'text-danger';
                                                            } elseif ($status == 1) {
                                                                $status = $this->lang->line('student_partially_paid');
                                                                $setButton = 'text-warning';
                                                            } elseif ($status == 2) {
                                                                $status = $this->lang->line('student_fully_paid');
                                                                $setButton = 'text-success';
                                                            }

                                                            echo "<span class='" . $setButton . "'>" . $status . "</span>";
                                                            ?>
                                                        </td>

                                                        <td data-title="<?= $this->lang->line('student_fees_amount') ?>">
                                                            <?php
                                                            $invoiceAmount = $invoice->amount;
                                                            echo number_format($invoiceAmount, 2);
                                                            $totalInvoice += $invoiceAmount;
                                                            ?>
                                                        </td>

                                                        <td data-title="<?= $this->lang->line('student_discount') ?>">
                                                            <?php
                                                            $discountAmount = 0;
                                                            if ($invoice->discount > 0) {
                                                                $discountAmount = (($invoice->amount / 100) * $invoice->discount);
                                                            } echo number_format($discountAmount, 2);
                                                            $totalDiscount += $discountAmount;
                                                            ?>
                                                        </td>

                                                        <td data-title="<?= $this->lang->line('student_paid') ?>">
                                                            <?php
                                                            $paymentAmount = 0;
                                                            if (isset($allpaymentbyinvoice[$invoice->invoiceID])) {
                                                                $paymentAmount = $allpaymentbyinvoice[$invoice->invoiceID];
                                                            } echo number_format($paymentAmount, 2);
                                                            $totalPaid += $paymentAmount;
                                                            ?>
                                                        </td>

                                                        <td data-title="<?= $this->lang->line('student_due') ?>">
                                                            <?php
                                                            $dueAmount = ((($invoiceAmount - $discountAmount) - $paymentAmount));
                                                            echo number_format($dueAmount, 2);
                                                            $totalDue += $dueAmount;
                                                            ?>
                                                        </td>

                                                    </tr>

                                                    <?php
                                                    $i++;
                                                }
                                            }
                                            ?>

                                            <tr>
                                                <td colspan="4" data-title="<?= $this->lang->line('student_total') ?>">
                                                    <?php
                                                    if ($siteinfos->currency_code) {
                                                        echo '<b>' . $this->lang->line('student_total') . ' (' . $siteinfos->currency_code . ')' . '</b>';
                                                    } else {
                                                        echo '<b>' . $this->lang->line('student_total') . '</b>';
                                                    }
                                                    ?>
                                                </td>
                                                <td data-title="<?= $this->lang->line('student_total') ?> <?= $this->lang->line('student_fees_amount') ?>">
                                                    <?= number_format($totalInvoice, 2) ?>
                                                </td>
                                                <td data-title="<?= $this->lang->line('student_total') ?> <?= $this->lang->line('student_discount') ?>">
                                                    <?= number_format($totalDiscount, 2) ?>
                                                </td>
                                                <td data-title="<?= $this->lang->line('student_total') ?> <?= $this->lang->line('student_paid') ?>">
                                                    <?= number_format($totalPaid, 2) ?>
                                                </td>
                                                <td data-title="<?= $this->lang->line('student_total') ?> <?= $this->lang->line('student_due') ?>">
                                                    <?= number_format($totalDue, 2) ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>


                            <div class="tab-pane" id="payment">
                                <div id="hide-table">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th><?= $this->lang->line('slno') ?></th>
                                                <th><?= $this->lang->line('student_feetype') ?></th>
                                                <th><?= $this->lang->line('student_date') ?></th>
                                                <th><?= $this->lang->line('student_paid') ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $totalPaymentPaid = 0;
                                            $totalPaymentWeaver = 0;
                                            $totalPaymentFine = 0;
                                            if (count($payments)) {
                                                $i = 1;
                                                foreach ($payments as $payment) {
                                                    ?>
                                                    <tr>
                                                        <td data-title="<?= $this->lang->line('slno') ?>">
                                                            <?php echo $i; ?>
                                                        </td>

                                                        <td data-title="<?= $this->lang->line('student_feetype') ?>">
                                                            <?= isset($feetypes[$payment->feetypeID]) ? $feetypes[$payment->feetypeID] : '' ?>
                                                        </td>

                                                        <td data-title="<?= $this->lang->line('student_date') ?>">
                                                            <?= !empty($payment->paymentdate) ? date('d M Y', strtotime($payment->paymentdate)) : '' ?>
                                                        </td>

                                                        <td data-title="<?= $this->lang->line('student_paid') ?>">
                                                            <?php
                                                            $paymentpaidAmount = $payment->paymentamount;
                                                            echo number_format($paymentpaidAmount, 2);
                                                            $totalPaymentPaid += $paymentpaidAmount;
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    $i++;
                                                }
                                            }
                                            ?>

                                            <tr>
                                                <td colspan="3" data-title="<?= $this->lang->line('student_total') ?>">
                                                    <?php
                                                    if ($siteinfos->currency_code) {
                                                        echo '<b>' . $this->lang->line('student_total') . ' (' . $siteinfos->currency_code . ')' . '</b>';
                                                    } else {
                                                        echo '<b>' . $this->lang->line('student_total') . '</b>';
                                                    }
                                                    ?>
                                                </td>
                                                <td data-title="<?= $this->lang->line('student_total') ?> <?= $this->lang->line('student_paid') ?>">
                                                    <?= number_format($totalPaymentPaid, 2) ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="<?= (($this->input->get("tab") != NULL && $this->input->get("tab") == "files") ? 'active ' : ''); ?>tab-pane" id="document">
                                <?php if (permissionChecker('student_add')) { ?>
                                    <input class="btn btn-success btn-sm" style="margin-bottom: 10px" type="button" value="<?= $this->lang->line('student_add_document') ?>" data-toggle="modal" data-target="#documentupload">
                                <?php } ?>
                                <div id="hide-table">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th><?= $this->lang->line('slno') ?></th>
                                                <th><?= $this->lang->line('student_title') ?></th>
                                                <th><?= $this->lang->line('student_date') ?></th>
                                                <th><?= $this->lang->line('action') ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (count($documents)) {
                                                $i = 1;
                                                foreach ($documents as $document) {
                                                    ?>
                                                    <tr>
                                                        <td data-title="<?= $this->lang->line('slno') ?>">
                                                            <?php echo $i; ?>
                                                        </td>

                                                        <td data-title="<?= $this->lang->line('student_title') ?>">
                                                            <?= $document->title ?>
                                                        </td>

                                                        <td data-title="<?= $this->lang->line('student_date') ?>">
                                                            <?= date('d M Y', strtotime($document->create_date)) ?>
                                                        </td>

                                                        <td data-title="<?= $this->lang->line('action') ?>">
                                                            <?php
                                                            if ((permissionChecker('student_add') && permissionChecker('student_delete')) || ($this->session->userdata('usertypeID') == 3 && $this->session->userdata('loginuserID') == $profile->srstudentID)) {
                                                                echo btn_download('student/download_document/' . $document->documentID . '/' . $profile->srstudentID . '/' . $profile->srclassesID, $this->lang->line('download'));
                                                            }

                                                            if (permissionChecker('student_add') && permissionChecker('student_delete')) {
                                                                echo btn_delete_show('student/delete_document/' . $document->documentID . '/' . $profile->srstudentID . "/" . $profile->srclassesID, $this->lang->line('delete'));
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    $i++;
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>


                            <div class="tab-pane" id="notes">
                                <div id="hide-table">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <!-- <th style="width: 1px;"><?= $this->lang->line('slno') ?></th> -->
                                                <th style="width: 300px;"><?= $this->lang->line('student_note') ?></th>
                                                <th style="width: 100px;"><?= $this->lang->line('student_note_added_by') ?></th>
                                                <th style="width: 100px;"><?= $this->lang->line('student_note_date') ?></th>
                                                <th style="width: 50px;"><?= $this->lang->line('action') ?></th>
                                            </tr>
                                        </thead>
                                        <tbody id="notesTableBody">
                                            <?php
                                            if (count($notes)) {
                                                $i = 1;
                                                foreach ($notes as $note) {
                                                    ?>
                                                    <tr>
                                                        <!-- <td data-title="<?= $this->lang->line('slno') ?>">
                                                        <?php echo $i; ?>
                                                        </td> -->

                                                        <td data-title="<?= $this->lang->line('student_note') ?>">
                                                            <?= $note->note ?>
                                                        </td>

                                                        <td data-title="<?= $this->lang->line('student_note_added_by') ?>">
                                                            <?= $note->addedby ?>
                                                        </td>
                                                        <td data-title="<?= $this->lang->line('student_note_date') ?>">
                                                            <?= date('d F Y', strtotime($note->date)) ?>
                                                        </td>

                                                        <td data-title="<?= $this->lang->line('action') ?>">
                                                            <a href="javascript::();" class="btn btn-danger btn-sm mrg" data-placement="top" data-toggle="tooltip" data-original-title="Delete Note" onclick="deleteNote(<?= $note->id . ',' . $note->studentID; ?>);"><i class="fa fa-remove"></i></a>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    $i++;
                                                }
                                            } else {
                                                echo '<tr><td colspan="5" align="center">NO Notes to show</td></tr>';
                                            }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3"><input type="hidden" value="<?= $studenID; ?>" id="studentID"/><input type="text" placeholder="New Note" title="New Note" id="newPlayerNote" name="newPlayerNote" class="form-control"/></td>
                                                <td><button class="btn btn-success btn-sm" id="submitAddNote">ADD</button></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if (permissionChecker('student_add')) { ?>
        <form id="documentUploadDataForm" class="form-horizontal" enctype="multipart/form-data" role="form" action="<?= base_url('student/send_mail'); ?>" method="post">
            <div class="modal fade" id="documentupload">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title"><?= $this->lang->line('student_document_upload') ?></h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group" >
                                <label for="title" class="col-sm-2 control-label">
                                    <?= $this->lang->line("student_title") ?> <span class="text-red">*</span>
                                </label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="title" name="title" value="<?= set_value('title') ?>" >
                                </div>
                                <span class="col-sm-4 control-label" id="title_error">
                                </span>
                            </div>

                            <div class="form-group">
                                <label for="file" class="col-sm-2 control-label">
                                    <?= $this->lang->line("student_file") ?> <span class="text-red">*</span>
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
                                                <input type="file" id="file" name="file"/>
                                            </div>
                                        </span>
                                    </div>
                                </div>
                                <span class="col-sm-4 control-label" id="file_error">
                                </span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" style="margin-bottom:0px;" data-dismiss="modal"><?= $this->lang->line('close') ?></button>
                            <input type="button" id="uploadfile" class="btn btn-success" value="<?= $this->lang->line("student_upload") ?>" />
                        </div>
                    </div>
                </div>
            </div>
        </form>


        <script type="text/javascript">
            $(document).on('click', '#uploadfile', function () {
                var title = $('#title').val();
                var file = $('#file').val();
                var error = 0;

                if (title == '' || title == null) {
                    error++;
                    $('#title_error').html("<?= $this->lang->line('student_title_required') ?>");
                    $('#title_error').parent().addClass('has-error');
                } else {
                    $('#title_error').html('');
                    $('#title_error').parent().removeClass('has-error');
                }

                if (file == '' || file == null) {
                    error++;
                    $('#file_error').html("<?= $this->lang->line('student_file_required') ?>");
                    $('#file_error').parent().addClass('has-error');
                } else {
                    $('#file_error').html('');
                    $('#file_error').parent().removeClass('has-error');
                }

                if (error == 0) {
                    var studentID = "<?= $profile->srstudentID ?>";
                    var formData = new FormData($('#documentUploadDataForm')[0]);
                    formData.append("studentID", studentID);
                    $.ajax({
                        type: 'POST',
                        dataType: "json",
                        url: "<?= base_url('student/documentUpload') ?>",
                        data: formData,
                        async: false,
                        dataType: "html",
                        success: function (data) {
                            var response = jQuery.parseJSON(data);
                            if (response.status) {
                                $('#title_error').html();
                                $('#title_error').parent().removeClass('has-error');

                                $('#file_error').html();
                                $('#file_error').parent().removeClass('has-error');
                                location.reload();
                            } else {
                                if (response.errors['title']) {
                                    $('#title_error').html(response.errors['title']);
                                    $('#title_error').parent().addClass('has-error');
                                } else {
                                    $('#title_error').html();
                                    $('#title_error').parent().removeClass('has-error');
                                }

                                if (response.errors['file']) {
                                    $('#file_error').html(response.errors['file']);
                                    $('#file_error').parent().addClass('has-error');
                                } else {
                                    $('#file_error').html();
                                    $('#file_error').parent().removeClass('has-error');
                                }
                            }
                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });
                }
            });

            $(function () {
                var closebtn = $('<button/>', {
                    type: "button",
                    text: 'x',
                    id: 'close-preview',
                    style: 'font-size: initial;',
                });
                closebtn.attr("class", "close pull-right");

                $('.image-preview').popover({
                    trigger: 'manual',
                    html: true,
                    title: "<strong>Preview</strong>" + $(closebtn)[0].outerHTML,
                    content: "There's no image",
                    placement: 'bottom'
                });

                $('.image-preview-clear').click(function () {
                    $('.image-preview').attr("data-content", "").popover('hide');
                    $('.image-preview-filename').val("");
                    $('.image-preview-clear').hide();
                    $('.image-preview-input input:file').val("");
                    $(".image-preview-input-title").text("<?= $this->lang->line('student_file_browse') ?>");
                });

                $(".image-preview-input input:file").change(function () {
                    var img = $('<img/>', {
                        id: 'dynamic',
                        width: 250,
                        height: 200,
                        overflow: 'hidden'
                    });

                    var file = this.files[0];
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $(".image-preview-input-title").text("<?= $this->lang->line('student_file_browse') ?>");
                        $(".image-preview-clear").show();
                        $(".image-preview-filename").val(file.name);
                    }
                    reader.readAsDataURL(file);
                });
            });
        </script>
    <?php } ?>

    <form class="form-horizontal" role="form" action="<?= base_url('student/send_mail'); ?>" method="post">
        <div class="modal fade" id="mail">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title"><?= $this->lang->line('mail') ?></h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="to" class="col-sm-2 control-label">
                                <?= $this->lang->line("to") ?> <span class="text-red">*</span>
                            </label>
                            <div class="col-sm-6">
                                <input type="email" class="form-control" id="to" name="to" value="<?= set_value('to') ?>" >
                            </div>
                            <span class="col-sm-4 control-label" id="to_error">
                            </span>
                        </div>

                        <div class="form-group">
                            <label for="subject" class="col-sm-2 control-label">
                                <?= $this->lang->line("subject") ?> <span class="text-red">*</span>
                            </label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="subject" name="subject" value="<?= set_value('subject') ?>" >
                            </div>
                            <span class="col-sm-4 control-label" id="subject_error">
                            </span>
                        </div>

                        <div class="form-group">
                            <label for="message" class="col-sm-2 control-label">
                                <?= $this->lang->line("message") ?>
                            </label>
                            <div class="col-sm-6">
                                <textarea class="form-control" id="message" style="resize: vertical;" name="message" value="<?= set_value('message') ?>" ></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" style="margin-bottom:0px;" data-dismiss="modal"><?= $this->lang->line('close') ?></button>
                        <input type="button" id="send_pdf" class="btn btn-success" value="<?= $this->lang->line("send") ?>"/>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script language="javascript" type="text/javascript">
        function printDiv(divID) {
            var divElements = document.getElementById(divID).innerHTML;
            var oldPage = document.body.innerHTML;
            document.body.innerHTML =
                    "<html><head><title></title></head><body>" +
                    divElements + "</body>";
            window.print();
            document.body.innerHTML = oldPage;
            window.location.reload();
        }

        function closeWindow() {
            location.reload();
        }

        function check_email(email) {
            var status = false;
            var emailRegEx = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i;
            if (email.search(emailRegEx) == -1) {
                $("#to_error").html('');
                $("#to_error").html("<?= $this->lang->line('mail_valid') ?>").css("text-align", "left").css("color", 'red');
            } else {
                status = true;
            }
            return status;
        }

        $('#send_pdf').click(function () {
            var to = $('#to').val();
            var subject = $('#subject').val();
            var message = $('#message').val();
            var id = "<?= $profile->srstudentID; ?>";
            var set = "<?= $set; ?>";
            var error = 0;

            $("#to_error").html("");
            if (to == "" || to == null) {
                error++;
                $("#to_error").html("");
                $("#to_error").html("<?= $this->lang->line('mail_to') ?>").css("text-align", "left").css("color", 'red');
            } else {
                if (check_email(to) == false) {
                    error++
                }
            }

            if (subject == "" || subject == null) {
                error++;
                $("#subject_error").html("");
                $("#subject_error").html("<?= $this->lang->line('mail_subject') ?>").css("text-align", "left").css("color", 'red');
            } else {
                $("#subject_error").html("");
            }

            if (error == 0) {
                $('#send_pdf').attr('disabled', 'disabled');
                $.ajax({
                    type: 'POST',
                    url: "<?= base_url('student/send_mail') ?>",
                    data: 'to=' + to + '&subject=' + subject + "&studentID=" + id + "&message=" + message + "&classesID=" + set,
                    dataType: "html",
                    success: function (data) {
                        var response = JSON.parse(data);
                        if (response.status == false) {
                            $('#send_pdf').removeAttr('disabled');
                            $.each(response, function (index, value) {
                                if (index != 'status') {
                                    toastr["error"](value)
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
                            });
                        } else {
                            location.reload();
                        }
                    }
                });
            }
        });

        $('.mark-bodyID').mCustomScrollbar({
            axis: "x"
        });

        $('.studentDIV').each(function () {
            $(this).mCustomScrollbar({
                axis: "x"
            });
        });

        $("#submitAddNote").click(function () {
            var note = $("#newPlayerNote").val();
            var studentID = $("#studentID").val();
            $.ajax({
                type: 'POST',
                url: "<?= base_url('student/addNote') ?>",
                data: 'note=' + note + "&studentID=" + studentID,
                success: function (data) {
                    $("#notesTableBody").html(data);
                    $("#newPlayerNote").val("");
                }
            });
        });

        function deleteNote(noteID, studentID) {
            $.ajax({
                type: 'POST',
                url: "<?= base_url('student/deleteNote') ?>",
                data: 'noteID=' + noteID + '&studentID=' + studentID,
                success: function (data) {
                    $("#notesTableBody").html(data);
                }
            });
        }
    </script>
<?php } ?>
