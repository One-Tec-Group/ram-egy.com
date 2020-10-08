<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
</head>
<body>
<?php if(count($students)) { foreach($students as $student) { ?>
    <div class="mainprogresscardreport">
        <div class="progresscard-headers">
            <div class="progresscard-logo">
                <img src="<?=base_url("uploads/images/$siteinfos->photo")?>" alt="">
            </div>
            <div class="school-name">
                <h2><?=$siteinfos->sname?></h2>
            </div>
        </div>
        <div class="progresscard-infos">
            <div class="school-address">
                <h4><b><?=$siteinfos->sname?></b></h4>
                <p><?=$siteinfos->address?></p>
                <p><?=$this->lang->line('progresscardreport_phone')?> : <?=$siteinfos->phone?></p>
                <p><?=$this->lang->line('progresscardreport_email')?> : <?=$siteinfos->email?></p>
            </div>
            <div class="student-profile">
                <h4><b><?=$student->srname?></b></h4>
                <p><?=$this->lang->line('progresscardreport_academic_year')?> : <b><?=$schoolyearsessionobj->schoolyear;?></b>
                <p><?=$this->lang->line('progresscardreport_reg_no')?> : <b><?=$student->srregisterNO?></b>, <?=$this->lang->line('progresscardreport_class')?> : <b><?=isset($classes[$student->srclassesID]) ? $classes[$student->srclassesID] : ''?></b></p>
                <p><?=$this->lang->line('progresscardreport_section')?> : <b><?=isset($sections[$student->srsectionID]) ? $sections[$student->srsectionID] : ''?></b>, <?=$this->lang->line('progresscardreport_roll_no')?> : <b><?=$student->srroll?></b></p>  
                <p><?=$this->lang->line('progresscardreport_group')?> : <b><?=isset($groups[$student->srstudentgroupID]) ? $groups[$student->srstudentgroupID] : ''?></b></p> 
            </div>
            <div class="student-profile-img">
                <img class="profileimg" src="<?=imagelink($student->photo)?>" alt="">
            </div>
        </div>
        <div class="progresscard-contents">
            <table>
                <thead>
                    <tr>
                        <th rowspan="2"><?=$this->lang->line('progresscardreport_subjects')?></th>
                        <?php if(count($exams)) { foreach($exams as $examID => $exam) { ?>
                            <th colspan="<?=count($markpercentages)?>"><?=$exam?></th>
                        <?php } } ?>
                        <th rowspan="2"><?=$this->lang->line('progresscardreport_total')?></th>
                        <th rowspan="2"><?=$this->lang->line('progresscardreport_grade')?></th>
                        <th rowspan="2"><?=$this->lang->line('progresscardreport_point')?></th>
                    </tr>
                    <tr>
                        <?php if(count($exams)) { foreach($exams as $examID => $exam) {
                            if(count($markpercentages)) { foreach($markpercentages as $markpercentage) { ?>
                                <th><?=substr($markpercentage->markpercentagetype, 0, 2)?></th>
                            <?php } } } } ?>
                    </tr>
                </thead>
                <tbody>
                <?php $totalAllSubjectMark = 0;
                $totalsemisterCol = (((count($exams) - 1) * count($markpercentages)) + 3);
                if(count($mandatorySubjects)) { foreach($mandatorySubjects  as $mandatorySubject) {
                    $totalSubjectMark = 0; ?>
                    <tr>
                        <td><?=$mandatorySubject->subject?></td>
                        <?php if(count($exams)) { foreach($exams as $examID => $exam) { 
                            if(count($markpercentages)) { foreach($markpercentages as $markpercentage) { ?>
                            <td>
                                <?php
                                    if(isset($markArray[$examID][$student->srstudentID]['markpercentageMark'][$mandatorySubject->subjectID][$markpercentage->markpercentageID])) {
                                        $mark = $markArray[$examID][$student->srstudentID]['markpercentageMark'][$mandatorySubject->subjectID][$markpercentage->markpercentageID];
                                    } else {
                                        $mark = 0;
                                    }

                                    echo $mark;
                                    $totalSubjectMark += $mark;
                                ?>
                            </td>
                        <?php } } } } ?>
                        <td><?=$totalSubjectMark?></td>
                        <?php
                        $totalAllSubjectMark += $totalSubjectMark;
                        $subjectGradeMark = floor($totalSubjectMark / count($exams));
                        if(count($grades)) { foreach($grades as $grade) { 
                            if(($grade->gradefrom <= $subjectGradeMark) && ($grade->gradeupto >= $subjectGradeMark)) { ?>
                                <td><?=$grade->grade?></td>
                                <td><?=$grade->point?></td>
                        <?php } } } ?>
                    </tr>
                <?php } } if($student->sroptionalsubjectID > 0) { 
                    $totalSubjectMark = 0;?>
                    <tr>
                        <td><?=isset($optionalSubjects[$student->sroptionalsubjectID]) ? $optionalSubjects[$student->sroptionalsubjectID] : ''?></td>
                        <?php if(count($exams)) { foreach($exams as $examID => $exam) { 
                            if(count($markpercentages)) { foreach($markpercentages as $markpercentage) { ?>
                            <td>
                                <?php
                                    if(isset($markArray[$examID][$student->srstudentID]['markpercentageMark'][$student->sroptionalsubjectID][$markpercentage->markpercentageID])) {
                                        $mark = $markArray[$examID][$student->srstudentID]['markpercentageMark'][$student->sroptionalsubjectID][$markpercentage->markpercentageID];
                                    } else {
                                        $mark = 0;
                                    }

                                    echo $mark;
                                    $totalSubjectMark += $mark;
                                ?>
                            </td>
                        <?php } } } } ?>
                        <td><?=$totalSubjectMark?></td>
                        <?php
                        $totalAllSubjectMark += $totalSubjectMark;
                        $subjectGradeMark = floor($totalSubjectMark / count($exams));
                        if(count($grades)) { foreach($grades as $grade) { 
                            if(($grade->gradefrom <= $subjectGradeMark) && ($grade->gradeupto >= $subjectGradeMark)) { ?>
                                <td><?=$grade->grade?></td>
                                <td><?=$grade->point?></td>
                        <?php } } } ?>
                    </tr>
                <?php } ?>
                <tr>
                    <td colspan="<?=(count($markpercentages) + 1)?>"><?=$this->lang->line('progresscardreport_total_mark')?> </td>
                    <td colspan="<?=$totalsemisterCol?>"><b><?=$totalAllSubjectMark?></b></td>
                </tr>
                <tr>
                    <td colspan="<?=(count($markpercentages) + 1)?>"><?=$this->lang->line('progresscardreport_average_mark')?> </td>
                    <td colspan="<?=$totalsemisterCol?>">
                        <b>
                            <?php
                                $tSubject = $totalSubject;
                                if($student->sroptionalsubjectID > 0) {
                                    $tSubject = $tSubject + 1;
                                }
                                $totalAllSubject = $tSubject * count($exams);
                                echo number_format($totalAllSubjectMark / $totalAllSubject,2);
                                $totalAllSubjectGrade = floor($totalAllSubjectMark / $totalAllSubject);
                            ?>
                        </b>
                    </td>
                </tr>
                    <?php
                        if(count($grades)) { foreach($grades as $grade) { 
                            if(($grade->gradefrom <= $totalAllSubjectGrade) && ($grade->gradeupto >= $totalAllSubjectGrade)) { ?>
                            <tr>
                                <td colspan="<?=(count($markpercentages) + 1)?>"><?=$this->lang->line('progresscardreport_point')?> </td>
                                <td colspan="<?=$totalsemisterCol?>"><b><?=$grade->point?></b></td>
                            </tr>
                            <tr>
                                <td colspan="<?=(count($markpercentages) + 1)?>"><?=$this->lang->line('progresscardreport_grade')?></td>
                                <td colspan="<?=$totalsemisterCol?>"><b><?=$grade->grade?></b></td>
                            </tr>
                    <?php } } } ?>
                    <tr>
                        <td colspan="<?=(count($markpercentages) + 1)?>"><?=$this->lang->line('progresscardreport_from_teacher_remarks')?></td>
                        <td colspan="<?=$totalsemisterCol?>"></td>
                    </tr>
                    <tr>
                        <td colspan="<?=(count($markpercentages) + 1)?>"><?=$this->lang->line('progresscardreport_house_teacher_remarks')?></td>
                        <td colspan="<?=$totalsemisterCol?>"></td>
                    </tr>
                    <tr>
                        <td colspan="<?=(count($markpercentages) + 1)?>"><?=$this->lang->line('progresscardreport_principal_remarks')?></td>
                        <td colspan="<?=$totalsemisterCol?>"></td>
                    </tr>
                    <tr>
                        <td colspan="<?=((count($markpercentages) + 1) + ($totalsemisterCol))?>">
                            <?=$this->lang->line('progresscardreport_interpretation')?> :
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
        <p><?=$this->lang->line('progresscardreport_data_not_found')?></p>
    </div>
<?php } ?>
</body>
</html>