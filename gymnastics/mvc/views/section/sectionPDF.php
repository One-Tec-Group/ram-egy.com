<div class="col-sm-3" style="padding:15px;width:40%;border:1px solid grey;border-radius:5px;height:300px;">
    <div style="width:250px;display:inline-table;">
        <?= profileviewimage($section->photo); ?> 
        <h3 class="profile-username text-center"><?= $section->section; ?></h3>
        <br/>
        <ul style="list-style-type: none;">
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
<div style="padding:15px;margin-left:60%;margin-top:-330px;width:40%;border:1px solid grey;border-radius:5px;height: 300px;">
    <div class="box-body box-profile" style="width:250px;">
        <h3 class="text-muted text-center">Coaches & Employees</h3>
        <br/><br/>
        <ul style="list-style-type: none;">
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
<div style="text-align:center;">
    <div style="text-align:center;"><h2><b><br><br><?php echo $section->section; ?></b></h2></div>
    <hr/>
    <div style="text-align:center;">
        <table border="2" style="margin:0 auto;width: 100%;">
            <thead>
                <tr>
                    <th style="border:1px;"><?= $this->lang->line('slno') ?></th>
                    <th style="border:1px;"><?= $this->lang->line('student_photo') ?></th>
                    <th style="border:1px;"><?= $this->lang->line('student_name') ?></th>
                    <th style="border:1px;"><?= $this->lang->line('student_phone') ?></th>
                    <th style="border:1px;"><?= $this->lang->line('student_dob') ?></th>
                    <th style="border:1px;"><?= $this->lang->line('section_joing_date') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $existingStudents = array();
                if (count($students) > 0) {
                    foreach ($students as $student) {
                        array_push($existingStudents, $student->studentID);
                        ?>
                        <tr>
                            <td style="border:1px;">
                                <?php echo $student->registerNO; ?>
                            </td>
                            <td style="border:1px;">
                                <?= profileimage($student->photo); ?>
                            </td>
                            <td style="border:1px;">
                                <?php echo $student->srname; ?>
                            </td>
                            <td style="border:1px;">
                                <?php echo $student->phone; ?>
                            </td>
                            <td style="border:1px;">
                                <?php echo $student->dob; ?>
                            </td>
                            <td style="border:1px;">
                                <?php echo $student->srjoinDate; ?>
                            </td>
                        </tr>
                        <?php
                        $i++;
                    }
                } else {
                    ?>
                    <tr><td colspan="6" style="text-align:center;">NO STUDENT ASSIGNED</td></tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>