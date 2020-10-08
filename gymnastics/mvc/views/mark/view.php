<?php if(count($profile)) { ?>
    <div class="well">
        <div class="row">
            <div class="col-sm-6">
                <?php if(!permissionChecker('mark_view') && permissionChecker('mark_add')) { echo btn_sm_add('mark/add', $this->lang->line('add_sub_mark')); } ?>

                <button class="btn-cs btn-sm-cs" onclick="javascript:printDiv('printablediv')"><span class="fa fa-print"></span> <?=$this->lang->line('print')?> </button>
                <?=btn_add_pdf('mark/print_preview/'.$profile->studentID."/".$profile->srclassesID, $this->lang->line('pdf_preview'))?>

                <button class="btn-cs btn-sm-cs" data-toggle="modal" data-target="#mail"><span class="fa fa-envelope-o"></span> <?=$this->lang->line('mail')?></button>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb">
                    <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
                    <li><a href="<?=base_url("mark/index/$profile->srclassesID")?>"><?=$this->lang->line('menu_mark')?></a></li>
                    <li class="active"><?=$this->lang->line('view')?></li>
                </ol>
            </div>
        </div>
    </div>

    <div id="printablediv">
        <div class="row">
            <div class="col-sm-3">
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <?=profileviewimage($profile->photo)?>
                        <h3 class="profile-username text-center"><?=$profile->name?></h3>
                        <p class="text-muted text-center"><?=$usertype->usertype?></p>
                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item" style="background-color: #FFF">
                                <b><?=$this->lang->line('mark_registerNO')?></b> <a class="pull-right"><?=$profile->srregisterNO?></a>
                            </li>
                            <li class="list-group-item" style="background-color: #FFF">
                                <b><?=$this->lang->line('mark_roll')?></b> <a class="pull-right"><?=$profile->srroll?></a>
                            </li>
                            <li class="list-group-item" style="background-color: #FFF">
                                <b><?=$this->lang->line('mark_classes')?></b> <a class="pull-right"><?=count($class) ? $class->classes : ''?></a>
                            </li>
                            <li class="list-group-item" style="background-color: #FFF">
                                <b><?=$this->lang->line('mark_section')?></b> <a class="pull-right"><?=count($section) ? $section->section : ''?></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-sm-9">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#mark" data-toggle="tab"><?=$this->lang->line('mark_mark')?></a></li>
                    </ul>

                    <div class="tab-content">
                        <div class="active tab-pane" id="mark">
                            <?php 
                                $subjectCount = count($mandatorysubjects);
                                if($profile->sroptionalsubjectID > 0) {
                                    if(isset($optionalsubjects[$profile->sroptionalsubjectID])) {
                                        $subjectCount++;
                                    }
                                }

                                if(count($exams)) {
                                    foreach ($exams as $exam) {
                                        if(isset($marks[$exam->examID])) {
                                            if(count($marks[$exam->examID])) {
                                                echo '<div style="border-top:1px solid #23292F; border-left:1px solid #23292F; border-right:1px solid #23292F; border-bottom:1px solid #23292F;" class="box" id="e'.$exam->examID.'">';

                                                    $headerColor = ['bg-sky', 'bg-purple-shipu','bg-sky-total-grade', 'bg-sky-light', 'bg-sky-total' ];

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
                                                                        echo $this->lang->line("mark_subject");
                                                                    echo "</th>";
                                                                    $headerCount = 1;
                                                                    foreach ($markpercentages as $markpercentage) {
                                                                        $color = 'bg-aqua';
                                                                        if($headerCount % 2 == 0) {
                                                                            $color = 'bg-aqua';
                                                                        }
                                                                        echo "<th colspan='2' class=' text-center' style='background-color:#395C7F;color:#fff;'>";
                                                                            echo $markpercentage->markpercentagetype;
                                                                        echo "</th>";
                                                                        $headerCount++;
                                                                    }
                                                                    echo "<th colspan='3' class='text-center ' style='background-color:#395C7F;color:#fff;'>";
                                                                        echo $this->lang->line("mark_total");
                                                                    echo "</th>";
                                                                echo "</tr>";
                                                                echo "<tr>";
                                                                    foreach ($markpercentages as $value) {
                                                                        echo "<th class='".$headerColor[0]." text-center '>";
                                                                            echo $this->lang->line("mark_mark");
                                                                        echo "</th>";

                                                                        echo "<th class='".$headerColor[3]." text-center' data-title='".$this->lang->line('mark_highest_mark')."'>";
                                                                            echo $this->lang->line("mark_highest_mark");
                                                                        echo "</th>";
                                                                    }
                                                                    echo "<th class='".$headerColor[4]." text-center'>";
                                                                        echo $this->lang->line("mark_mark");
                                                                    echo "</th>";
                                                                    echo "<th class='".$headerColor[1]." text-center' data-title='".$this->lang->line('mark_point')."'>";
                                                                        echo $this->lang->line("mark_point");
                                                                    echo "</th>";
                                                                    echo "<th class='".$headerColor[2]." text-center' data-title='".$this->lang->line('mark_grade')."'>";
                                                                        echo $this->lang->line("mark_grade");
                                                                    echo "</th>";
                                                                echo "</tr>";
                                                            echo "</thead>";

                                                            echo "<tbody>";
                                                                if(count($mandatorysubjects)) {
                                                                    foreach ($mandatorysubjects as $mandatorysubject) {
                                                                        echo "<tr>";
                                                                            echo "<td class='text-black' data-title='".$this->lang->line('mark_subject')."'>";
                                                                                echo $mandatorysubject->subject;
                                                                            echo "</td>";

                                                                            $totalSubjectMark = 0;
                                                                            foreach ($markpercentages as $markpercentage) {
                                                                                echo "<td class='text-black' data-title='".$this->lang->line('mark_mark')."'>";
                                                                                    if(isset($marks[$exam->examID][$mandatorysubject->subjectID][$markpercentage->markpercentageID])) {
                                                                                        echo $marks[$exam->examID][$mandatorysubject->subjectID][$markpercentage->markpercentageID];

                                                                                        $totalSubjectMark += $marks[$exam->examID][$mandatorysubject->subjectID][$markpercentage->markpercentageID];
                                                                                    } else {
                                                                                        echo 'N/A';
                                                                                    }

                                                                                echo "</td>";
                                                                                echo "<td class='text-black' data-title='".$this->lang->line('mark_highest_mark')."'>";
                                                                                    if(isset($hightmarks[$exam->examID][$mandatorysubject->subjectID][$markpercentage->markpercentageID]) && ($hightmarks[$exam->examID][$mandatorysubject->subjectID][$markpercentage->markpercentageID] != -1)) {
                                                                                        echo $hightmarks[$exam->examID][$mandatorysubject->subjectID][$markpercentage->markpercentageID];
                                                                                    } else {
                                                                                        echo 'N/A';
                                                                                    }
                                                                                echo "</td>";
                                                                            }

                                                                            echo "<td class='text-black' data-title='".$this->lang->line('mark_mark')."'>";
                                                                                echo $totalSubjectMark;
                                                                                $totalMark += $totalSubjectMark;
                                                                            echo "</td>";


                                                                            if(count($grades)) {
                                                                                foreach ($grades as $grade) {
                                                                                    if($grade->gradefrom <= floor($totalSubjectMark) && $grade->gradeupto >= floor($totalSubjectMark)) {
                                                                                        echo "<td class='text-black' data-title='".$this->lang->line('mark_point')."'>";
                                                                                            echo $grade->point;
                                                                                        echo "</td>";
                                                                                        echo "<td class='text-black' data-title='".$this->lang->line('mark_grade')."'>";
                                                                                            echo $grade->grade;
                                                                                        echo "</td>";
                                                                                    }
                                                                                }
                                                                            } else {
                                                                                echo "<td class='text-black' data-title='".$this->lang->line('mark_point')."'>";
                                                                                    echo 'N/A';
                                                                                echo '</td>';
                                                                                echo "<td class='text-black' data-title='".$this->lang->line('mark_grade')."'>";
                                                                                    echo 'N/A';
                                                                                echo '</td>';
                                                                            }
                                                                        echo '</tr>';
                                                                    }
                                                                }

                                                                if($profile->sroptionalsubjectID) {
                                                                    if(isset($optionalsubjects[$profile->sroptionalsubjectID])) {
                                                                        echo "<tr>";
                                                                            echo "<td class='text-black' data-title='".$this->lang->line('mark_subject')."'>";
                                                                                echo $optionalsubjects[$profile->sroptionalsubjectID];
                                                                            echo "</td>";

                                                                            $totalSubjectMark = 0;
                                                                            foreach ($markpercentages as $markpercentage) {
                                                                                echo "<td class='text-black' data-title='".$this->lang->line('mark_mark')."'>";
                                                                                    if(isset($marks[$exam->examID][$profile->sroptionalsubjectID][$markpercentage->markpercentageID])) {
                                                                                        echo $marks[$exam->examID][$profile->sroptionalsubjectID][$markpercentage->markpercentageID];

                                                                                        $totalSubjectMark += $marks[$exam->examID][$profile->sroptionalsubjectID][$markpercentage->markpercentageID];
                                                                                    } else {
                                                                                        echo 'N/A';
                                                                                    }
                                                                                echo "</td>";
                                                                                echo "<td class='text-black' data-title='".$this->lang->line('mark_highest_mark')."'>";
                                                                                    if(isset($hightmarks[$exam->examID][$profile->sroptionalsubjectID][$markpercentage->markpercentageID]) && ($hightmarks[$exam->examID][$profile->sroptionalsubjectID][$markpercentage->markpercentageID] != -1)) {
                                                                                        echo $hightmarks[$exam->examID][$profile->sroptionalsubjectID][$markpercentage->markpercentageID];
                                                                                    } else {
                                                                                        echo 'N/A';
                                                                                    }
                                                                                echo "</td>";
                                                                            }

                                                                            echo "<td class='text-black' data-title='".$this->lang->line('mark_mark')."'>";
                                                                                echo $totalSubjectMark;
                                                                                $totalMark += $totalSubjectMark;
                                                                            echo "</td>";

                                                                            if(count($grades)) {
                                                                                foreach ($grades as $grade) {
                                                                                    if($grade->gradefrom <= floor($totalSubjectMark) && $grade->gradeupto >= floor($totalSubjectMark)) {
                                                                                        echo "<td class='text-black' data-title='".$this->lang->line('mark_point')."'>";
                                                                                            echo $grade->point;
                                                                                        echo "</td>";
                                                                                        echo "<td class='text-black' data-title='".$this->lang->line('mark_grade')."'>";
                                                                                            echo $grade->grade;
                                                                                        echo "</td>";
                                                                                    }
                                                                                }
                                                                            } else {
                                                                                echo "<td class='text-black' data-title='".$this->lang->line('mark_point')."'>";
                                                                                    echo 'N/A';
                                                                                echo '</td>';
                                                                                echo "<td class='text-black' data-title='".$this->lang->line('mark_grade')."'>";
                                                                                    echo 'N/A';
                                                                                echo '</td>';
                                                                            }
                                                                        echo '</tr>';
                                                                    }
                                                                }
                                                            echo "</tbody>";
                                                        echo '</table>';

                                                        echo '<div class="box-footer" style="padding-left:0px;">';
                                                            $totalAverageMark = ($totalMark == 0) ? 0 :  (($subjectCount > 0) ? ($totalMark/$subjectCount) : 0);
                                                            echo '<p class="text-black">'. $this->lang->line('mark_total_marks').' : <span class="text-red text-bold">'. number_format((float)($totalMark), 2, '.', '').'</span>';
                                                            echo '&nbsp;&nbsp;&nbsp;&nbsp;'.$this->lang->line('mark_average_marks').' : <span class="text-red text-bold">'. number_format((float)($totalAverageMark), 2, '.', '').'</span>';
                                                            if(count($grades)) {
                                                                foreach ($grades as $grade) {
                                                                    if($grade->gradefrom <= floor($totalAverageMark) && $grade->gradeupto >= floor($totalAverageMark)) {
                                                                        echo '&nbsp;&nbsp;&nbsp;&nbsp;'.$this->lang->line('mark_average_point').' : <span class="text-red text-bold">'.$grade->point.'</span>';
                                                                        echo '&nbsp;&nbsp;&nbsp;&nbsp;'.$this->lang->line('mark_average_grade').' : <span class="text-red text-bold">'.$grade->grade.'</span>';
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
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form class="form-horizontal" role="form" action="<?=base_url('student/send_mail');?>" method="post">
        <div class="modal fade" id="mail">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title"><?=$this->lang->line('mail')?></h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="to" class="col-sm-2 control-label">
                                <?=$this->lang->line("to")?> <span class="text-red">*</span>
                            </label>
                            <div class="col-sm-6">
                                <input type="email" class="form-control" id="to" name="to" value="<?=set_value('to')?>" >
                            </div>
                            <span class="col-sm-4 control-label" id="to_error">
                            </span>
                        </div>

                        <div class="form-group">
                            <label for="subject" class="col-sm-2 control-label">
                                <?=$this->lang->line("subject")?> <span class="text-red">*</span>
                            </label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="subject" name="subject" value="<?=set_value('subject')?>" >
                            </div>
                            <span class="col-sm-4 control-label" id="subject_error">
                            </span>
                        </div>

                        <div class="form-group">
                            <label for="message" class="col-sm-2 control-label">
                                <?=$this->lang->line("message")?>
                            </label>
                            <div class="col-sm-6">
                                <textarea class="form-control" id="message" style="resize: vertical;" name="message" value="<?=set_value('message')?>" ></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" style="margin-bottom:0px;" data-dismiss="modal"><?=$this->lang->line('close')?></button>
                        <input type="button" id="send_pdf" class="btn btn-success" value="<?=$this->lang->line("send")?>" />
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
                $("#to_error").html("<?=$this->lang->line('mail_valid')?>").css("text-align", "left").css("color", 'red');
            } else {
                status = true;
            }
            return status;
        }

        $('#send_pdf').click(function() {
            var to = $('#to').val();
            var subject = $('#subject').val();
            var message = $('#message').val();
            var id = "<?=$profile->studentID;?>";
            var set = "<?=$profile->srclassesID;?>";
            var error = 0;

            $("#to_error").html("");
            if(to == "" || to == null) {
                error++;
                $("#to_error").html("");
                $("#to_error").html("<?=$this->lang->line('mail_to')?>").css("text-align", "left").css("color", 'red');
            } else {
                if(check_email(to) == false) {
                    error++
                }
            }

            if(subject == "" || subject == null) {
                error++;
                $("#subject_error").html("");
                $("#subject_error").html("<?=$this->lang->line('mail_subject')?>").css("text-align", "left").css("color", 'red');
            } else {
                $("#subject_error").html("");
            }

            if(error == 0) {
                $('#send_pdf').attr('disabled','disabled');
                $.ajax({
                    type: 'POST',
                    url: "<?=base_url('mark/send_mail')?>",
                    data: 'to='+ to + '&subject=' + subject + "&id=" + id+ "&message=" + message+ "&set=" + set,
                    dataType: "html",
                    success: function(data) {
                        var response = JSON.parse(data);
                        if (response.status == false) {
                            $('#send_pdf').removeAttr('disabled');
                            $.each(response, function(index, value) {
                                if(index != 'status') {
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
            axis:"x"
        });

    </script>
<?php } ?>
