<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
</head>
<body>
 <?php if(count($studentLists)) { foreach($studentLists as $student) { ?>
    <div class="mainterminalreport">
        <div class="terminal-headers">
            <div class="terminal-logo">
                <img src="<?=base_url("uploads/images/$siteinfos->photo")?>" alt="">
            </div>
            <div class="school-name">
                <h2><?=$siteinfos->sname?></h2>
            </div>
        </div>
        <div class="terminal-infos">
            <div class="school-address">
                <h4><b><?=$siteinfos->sname?></b></h4>
                <p><?=$siteinfos->address?></p>
                <p><?=$this->lang->line('terminalreport_phone')?> : <?=$siteinfos->phone?></p>
                <p><?=$this->lang->line('terminalreport_email')?> : <?=$siteinfos->email?></p>
            </div>
            <div class="student-profile">
                <h4><b><?=$student->srname?></b></h4>
                <p><?=$this->lang->line('terminalreport_academic_year')?> : <b><?=$schoolyearsessionobj->schoolyear;?></b>
                <p><?=$this->lang->line('terminalreport_position_in_class')?> :  <b><?=count($studentPosition['studentClassPositionArray']) ? addOrdinalNumberSuffix((int)array_search($student->srstudentID, array_keys($studentPosition['studentClassPositionArray'])) + 1) : ''?></b></p>
                <p><?=$this->lang->line('terminalreport_reg_no')?> : <b><?=$student->srregisterNO?></b>, <?=$this->lang->line('terminalreport_class')?> : <b><?=isset($classes[$student->srclassesID]) ? $classes[$student->srclassesID] : ''?></b></p>
                <p><?=$this->lang->line('terminalreport_section')?> : <b><?=isset($sections[$student->srsectionID]) ? $sections[$student->srsectionID] : ''?></b>, <?=$this->lang->line('terminalreport_roll_no')?> : <b><?=$student->srroll?></b></p>  
                <p><?=$this->lang->line('terminalreport_group')?> : <b><?=isset($groups[$student->srstudentgroupID]) ? $groups[$student->srstudentgroupID] : ''?></b></p>
                <p><?=$this->lang->line('terminalreport_exam')?> : <b><?=$examName?></b></p>  
            </div>
            <div class="student-profile-img">
                <img class="profileimg" src="<?=imagelink($student->photo)?>" alt="">
            </div>
        </div>
        <div class="terminal-contents">
            <h4><?=$this->lang->line('terminalreport_terminal_report')?></h4>
            <table>
                <thead>
                    <tr>
                        <th><?=$this->lang->line('terminalreport_subjects');?></th>
                        <?php if(count($markpercentages)) { foreach($markpercentages as $markpercentage) { ?>
                        <th><?php echo $markpercentage->markpercentagetype?></th>
                        <?php } } ?>
                        <th><?=$this->lang->line('terminalreport_total')?></th>
                        <th><?=$this->lang->line('terminalreport_position_subject');?></th>
                        <th><?=$this->lang->line('terminalreport_grade');?></th>
                        <th><?=$this->lang->line('terminalreport_remarks');?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(count($subjects)) { foreach($subjects as $subject) { ?> 
                        <?php if(isset($studentPosition[$student->srstudentID]['subjectMark'][$subject->subjectID])) { ?>
                            <tr>
                                <td><?=$subject->subject?></td>
                                <?php if(count($markpercentages)) { foreach($markpercentages as $markpercentage) { ?>
                                <td><?=isset($studentPosition[$student->srstudentID]['markpercentageMark'][$subject->subjectID][$markpercentage->markpercentageID]) ? $studentPosition[$student->srstudentID]['markpercentageMark'][$subject->subjectID][$markpercentage->markpercentageID] : '0'?></td>
                                <?php } } ?>
                                <td><?=isset($studentPosition[$student->srstudentID]['subjectMark'][$subject->subjectID]) ? $studentPosition[$student->srstudentID]['subjectMark'][$subject->subjectID] : '0'?></td>
                                <td>
                                    <?=isset($studentPosition['studentSubjectPositionMark'][$subject->subjectID]) ? addOrdinalNumberSuffix((int)array_search($student->srstudentID, array_keys($studentPosition['studentSubjectPositionMark'][$subject->subjectID])) + 1) : '';?>
                                </td>
                                <?php
                                    $subjectMark = isset($studentPosition[$student->srstudentID]['subjectMark'][$subject->subjectID]) ? $studentPosition[$student->srstudentID]['subjectMark'][$subject->subjectID] : '0';
                                $subjectMark = floor($subjectMark);
                                if(count($grades)) { foreach($grades as $grade) { 
                                    if(($grade->gradefrom <= floor($subjectMark)) && ($grade->gradeupto >= floor($subjectMark))) { ?>
                                        <td><?=$grade->grade?></td>
                                        <td><?=$grade->note?></td>
                                <?php } } } ?>
                            </tr>
                        <?php } ?>
                    <?php } }  ?>
                    <tr>
                        <td><?=$this->lang->line('terminalreport_total')?></td>
                        <?php if(count($markpercentages)) { foreach($markpercentages as $markpercentage) { ?>
                        <td><?=isset($studentPosition[$student->srstudentID]['markpercentagetotalmark'][$markpercentage->markpercentageID]) ? $studentPosition[$student->srstudentID]['markpercentagetotalmark'][$markpercentage->markpercentageID] : '0'?></td>
                        <?php } } ?>
                        <td><?=isset($studentPosition[$student->srstudentID]['totalSubjectMark']) ? $studentPosition[$student->srstudentID]['totalSubjectMark'] : '0'?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    
                    <tr>
                        <td colspan="<?=($col-4)?>"><b><?=$this->lang->line('terminalreport_mark_average')?> : <?=isset($studentPosition[$student->srstudentID]['classPositionMark']) ? number_format($studentPosition[$student->srstudentID]['classPositionMark'],2) : '0.00'?></b></td>
                        <td colspan="4">
                            <b>
                                <?=$this->lang->line('terminalreport_class_average')?> :
                                <?php 
                                    if(isset($studentPosition[$student->srstudentID]['classPositionMark']) && $studentPosition[$student->srstudentID]['classPositionMark'] > 0 && isset($studentPosition['totalStudentMarkAverage'])) {
                                        echo number_format($studentPosition['totalStudentMarkAverage'] / $studentPosition[$student->srstudentID]['classPositionMark'],2);
                                    } else {
                                        echo "0.00";
                                    }
                                ?>
                            </b>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><b><?=$this->lang->line('terminalreport_promoted_to');?></b></td>
                        <td colspan="<?=($col-2)?>"></td>
                    </tr>
                    <tr>
                        <td colspan="2"><?=$this->lang->line('terminalreport_attendance');?></td>
                        <td colspan="<?=($col-2)?>"><?=isset($attendance[$student->srstudentID]) ? $attendance[$student->srstudentID] : '0'?></td>
                    </tr>
                    <tr>
                        <td colspan="2"><?=$this->lang->line('terminalreport_from_teacher_remarks')?></td>
                        <td colspan="<?=($col-2)?>"></td>
                    </tr>
                    <tr>
                        <td colspan="2"><?=$this->lang->line('terminalreport_house_teacher_remarks')?></td>
                        <td colspan="<?=($col-2)?>"></td>
                    </tr>
                    <tr>
                        <td colspan="2"><?=$this->lang->line('terminalreport_principal_remarks')?></td>
                        <td colspan="<?=($col-2)?>"></td>
                    </tr>
                    <tr>
                        <td colspan="<?=$col?>"><?=$this->lang->line('terminalreport_interpretation')?> : 
                            <b>
                                <?php if(count($grades)) { $i = 1; foreach($grades as $grade) { 
                                    if(count($grades) == $i) {
                                        echo $grade->gradefrom.'-'.$grade->gradeupto." = ".$grade->point." [".$grade->grade."]";
                                    } else {
                                        echo $grade->gradefrom.'-'.$grade->gradeupto." = ".$grade->point." [".$grade->grade."], ";
                                    }
                                    $i++;
                                }}?>
                            </b>
                        </td>
                    </tr> 
                </tbody>
            </table>
        </div>
    </div>
    <p style="page-break-after: always;">&nbsp;</p>
    <?php } } else { ?>
        <div class="notfound">
            <?php echo $this->lang->line('terminalreport_data_not_found'); ?>
        </div>
    <?php } ?>
</body>
</html>