<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
</head>
<body>
    <div class="profileArea">
        <?php featureheader($siteinfos);?>
        <div class="mainArea">
            <div class="areaTop">
                <div class="studentImage">
                    <img class="studentImg" src="<?=pdfimagelink($student->photo)?>" alt="">
                </div>
                <div class="studentProfile">
                    <div class="singleItem">
                        <div class="single_label"><?=$this->lang->line('mark_name')?></div>
                        <div class="single_value">: <?=$student->srname?></div>
                    </div>
                    <div class="singleItem">
                        <div class="single_label"><?=$this->lang->line('mark_type')?></div>
                        <div class="single_value">: <?=count($usertype) ? $usertype->usertype : '';?></div>
                    </div>
                    <div class="singleItem">
                        <div class="single_label"><?=$this->lang->line('mark_registerNO')?></div>
                        <div class="single_value">: <?=$student->srregisterNO?></div>
                    </div>
                    <div class="singleItem">
                        <div class="single_label"><?=$this->lang->line('mark_roll')?></div>
                        <div class="single_value">: <?=$student->srroll?></div>
                    </div>
                    <div class="singleItem">
                        <div class="single_label"><?=$this->lang->line('mark_classes')?></div>
                        <div class="single_value">: <?=count($classes) ? $classes->classes : ''?></div>
                    </div>
                    <div class="singleItem">
                        <div class="single_label"><?=$this->lang->line('mark_section')?></div>
                        <div class="single_value">: <?=count($section) ? $section->section : '' ?></div>
                    </div>
                </div>
            </div>
            <div class="markArea">
                <?php
                    $text = '';
                    $subjectCount = count($mandatorysubjects);
                    if($student->sroptionalsubjectID > 0) {
                        if(isset($optionalsubjects[$student->sroptionalsubjectID])) {
                            $subjectCount++;
                        }
                    }

                    if(count($exams)) {
                        foreach ($exams as $exam) {
                            if(isset($marks[$exam->examID])) {
                                if(count($marks[$exam->examID])) {
                                    $text .= '<div style="border-top:1px solid #23292F; border-left:1px solid #23292F; border-right:1px solid #23292F; border-bottom:1px solid #23292F;" class="box" id="e'.$exam->examID.'">';
                                        $headerColor = ['bg-sky', 'bg-purple-shipu','bg-sky-total-grade', 'bg-sky-light', 'bg-sky-total' ];
                                        $text .= '<div class="box-header" style="background-color:#FFFFFF;">';
                                            $text .= '<h3 style="color:#23292F;padding:5px">'; 
                                               $text .= $exam->exam;
                                            $text .= '</h3>';
                                        $text .= '</div>';
                                        $text .= '<div class="box-body mark-bodyID" style="border-top:1px solid #23292F;">';
                                            $totalMark = 0;
                                            $text .= "<table class=\"table table-striped table-bordered\" >";
                                                    $text .= "<tr>";
                                                        $text .= "<th class='text-center' rowspan='2' style='background-color:#395C7F;color:#fff;'>";
                                                            $text .= $this->lang->line("mark_subject");
                                                        $text .= "</th>";
                                                        $headerCount = 1;
                                                        foreach ($markpercentages as $markpercentage) {
                                                            $text .= "<th colspan='2' class=' text-center' style='background-color:#395C7F;color:#fff;'>";
                                                                $text .= $markpercentage->markpercentagetype;
                                                            $text .= "</th>";
                                                            $headerCount++;
                                                        }
                                                        $text .= "<th colspan='3' class='text-center ' style='background-color:#395C7F;color:#fff;'>";
                                                            $text .= $this->lang->line("mark_total");
                                                        $text .= "</th>";
                                                    $text .= "</tr>";
                                                    $text .= "<tr>";
                                                        foreach ($markpercentages as $value) {
                                                            $text .= "<th>";
                                                                $text .= $this->lang->line("mark_mark");
                                                            $text .= "</th>";

                                                            $text .= "<th>";
                                                                $text .= $this->lang->line("mark_highest_mark");
                                                            $text .= "</th>";
                                                        }
                                                        $text .= "<th>";
                                                            $text .= $this->lang->line("mark_mark");
                                                        $text .= "</th>";
                                                        $text .= "<th>";
                                                            $text .= $this->lang->line("mark_point");
                                                        $text .= "</th>";
                                                        $text .= "<th>";
                                                            $text .= $this->lang->line("mark_grade");
                                                        $text .= "</th>";
                                                    $text .= "</tr>";



                                                    if(count($mandatorysubjects)) {
                                                        foreach ($mandatorysubjects as $mandatorysubject) {
                                                            $text.= "<tr>";
                                                                $text.= "<td>";
                                                                    $text.= $mandatorysubject->subject;
                                                                $text.= "</td>";

                                                                $totalSubjectMark = 0;
                                                                foreach ($markpercentages as $markpercentage) {
                                                                    $text.= "<td>";
                                                                        if(isset($marks[$exam->examID][$mandatorysubject->subjectID][$markpercentage->markpercentageID])) {
                                                                            $text.= $marks[$exam->examID][$mandatorysubject->subjectID][$markpercentage->markpercentageID];

                                                                            $totalSubjectMark += $marks[$exam->examID][$mandatorysubject->subjectID][$markpercentage->markpercentageID];
                                                                        } else {
                                                                            $text.= 'N/A';
                                                                        }

                                                                    $text.= "</td>";
                                                                    $text.= "<td>";
                                                                        if(isset($hightmarks[$exam->examID][$mandatorysubject->subjectID][$markpercentage->markpercentageID]) && ($hightmarks[$exam->examID][$mandatorysubject->subjectID][$markpercentage->markpercentageID] != -1)) {
                                                                            $text.= $hightmarks[$exam->examID][$mandatorysubject->subjectID][$markpercentage->markpercentageID];
                                                                        } else {
                                                                            $text.= 'N/A';
                                                                        }
                                                                    $text.= "</td>";
                                                                }

                                                                $text.= "<td>";
                                                                    $text.= $totalSubjectMark;
                                                                    $totalMark += $totalSubjectMark;
                                                                $text.= "</td>";


                                                                if(count($grades)) {
                                                                    foreach ($grades as $grade) {
                                                                        if($grade->gradefrom <= floor($totalSubjectMark) && $grade->gradeupto >= floor($totalSubjectMark)) {
                                                                            $text.= "<td>";
                                                                                $text.= $grade->point;
                                                                            $text.= "</td>";
                                                                            $text.= "<td>";
                                                                                $text.= $grade->grade;
                                                                            $text.= "</td>";
                                                                        }
                                                                    }
                                                                } else {
                                                                    $text.= "<td>";
                                                                        $text.= 'N/A';
                                                                    $text.= '</td>';
                                                                    $text.= "<td>";
                                                                        $text.= 'N/A';
                                                                    $text.= '</td>';
                                                                }
                                                            $text.= '</tr>';
                                                        }
                                                    }

                                                    if($student->sroptionalsubjectID) {
                                                        if(isset($optionalsubjects[$student->sroptionalsubjectID])) {
                                                            $text.= "<tr>";
                                                                $text.= "<td>";
                                                                    $text.= $optionalsubjects[$student->sroptionalsubjectID];
                                                                $text.= "</td>";

                                                                $totalSubjectMark = 0;
                                                                foreach ($markpercentages as $markpercentage) {
                                                                    $text .=  "<td>";
                                                                        if(isset($marks[$exam->examID][$student->sroptionalsubjectID][$markpercentage->markpercentageID])) {
                                                                            $text .=  $marks[$exam->examID][$student->sroptionalsubjectID][$markpercentage->markpercentageID];

                                                                            $totalSubjectMark += $marks[$exam->examID][$student->sroptionalsubjectID][$markpercentage->markpercentageID];
                                                                        } else {
                                                                            $text .=  'N/A';
                                                                        }
                                                                    $text .=  "</td>";
                                                                    $text .=  "<td>";
                                                                        if(isset($hightmarks[$exam->examID][$student->sroptionalsubjectID][$markpercentage->markpercentageID]) && ($hightmarks[$exam->examID][$student->sroptionalsubjectID][$markpercentage->markpercentageID] != -1)) {
                                                                            $text .=  $hightmarks[$exam->examID][$student->sroptionalsubjectID][$markpercentage->markpercentageID];
                                                                        } else {
                                                                            $text .=  'N/A';
                                                                        }
                                                                    $text .=  "</td>";
                                                                }

                                                                $text .=  "<td>";
                                                                    $text .=  $totalSubjectMark;
                                                                    $totalMark += $totalSubjectMark;
                                                                $text .=  "</td>";

                                                                if(count($grades)) {
                                                                    foreach ($grades as $grade) {
                                                                        if($grade->gradefrom <= floor($totalSubjectMark) && $grade->gradeupto >= floor($totalSubjectMark)) {
                                                                            $text .=  "<td>";
                                                                                $text .=  $grade->point;
                                                                            $text .=  "</td>";
                                                                            $text .=  "<td>";
                                                                                $text .=  $grade->grade;
                                                                            $text .=  "</td>";
                                                                        }
                                                                    }
                                                                } else {
                                                                    $text .=  "<td>";
                                                                        $text .=  'N/A';
                                                                    $text .=  '</td>';
                                                                    $text .=  "<td>";
                                                                        $text .=  'N/A';
                                                                    $text .=  '</td>';
                                                                }
                                                            $text .= '</tr>';
                                                        }
                                                    }
                                            $text .= '</table>';
                                            $text .= '<div style="padding-left:0px;">';
                                                $totalAverageMark = ($totalMark == 0) ? 0 :  (($subjectCount > 0) ? ($totalMark/$subjectCount) : 0);
                                                $text .= '<p style="font-size:14px">'. $this->lang->line('mark_total_marks').' : <span>'. number_format((float)($totalMark), 2, '.', '').'</span>';
                                                $text .= '&nbsp;&nbsp;&nbsp;&nbsp;'.$this->lang->line('mark_average_marks').' : <span>'. number_format((float)($totalAverageMark), 2, '.', '').'</span>';
                                                if(count($grades)) {
                                                    foreach ($grades as $grade) {
                                                        if($grade->gradefrom <= floor($totalAverageMark) && $grade->gradeupto >= floor($totalAverageMark)) {
                                                            $text .= '&nbsp;&nbsp;&nbsp;&nbsp;'.$this->lang->line('mark_average_point').' : <span>'.$grade->point.'</span>';
                                                            $text .= '&nbsp;&nbsp;&nbsp;&nbsp;'.$this->lang->line('mark_average_grade').' : <span>'.$grade->grade.'</span>';
                                                        }
                                                    }
                                                }
                                                $text .= '</p>';
                                            $text .= '</div>';
                                        $text .= '</div>';
                                    $text .= '</div><br>';
                                }
                            }
                        }
                    }

                    echo $text;
                ?>
            </div>
        </div>
    </div>
    <?php featurefooter($siteinfos);?>
</body>
</html>
