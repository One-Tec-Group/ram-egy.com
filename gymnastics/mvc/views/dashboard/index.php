<div class="row">
    <?php
    $getActiveUserID = $this->session->userdata('usertypeID');
    if (config_item('demo')) {
        ?>
        <div class="col-sm-12" id="resetDummyData">
            <div class="callout callout-danger">
                <h4>Reminder!</h4>
                <p>Dummy data will be reset in every <code>30</code> minutes</p>
            </div>
        </div>

        <script type="text/javascript">
            $(document).ready(function () {
                var count = 7;
                var countdown = setInterval(function () {
                    $("p.countdown").html(count + " seconds remaining!");
                    if (count == 0) {
                        clearInterval(countdown);
                        $('#resetDummyData').hide();
                    }
                    count--;
                }, 1000);
            });
        </script>
    <?php } ?>

    <div style="padding:0 15px;">
        <?php if ($getActiveUserID == 1 || $getActiveUserID == 5) { ?>
            <?php if (permissionChecker('notice')) { ?>
                <div class="col-sm-12">
                    <?php $this->load->view('dashboard/NoticeBoard', array('val' => 5, 'length' => 100, 'maxlength' => 45)); ?>
                </div>
            <?php } ?>

        <?php } else { ?>
            <div class="col-sm-4">
                <?php $this->load->view('dashboard/ProfileBox'); ?>
            </div>
            <?php if (permissionChecker('notice')) { ?>
                <div class="col-sm-8">
                    <div class="box">
                        <div class="box-body" style="padding: 0px;height: 320px">
                            <?php $this->load->view('dashboard/NoticeBoard', array('val' => 5, 'length' => 20, 'maxlength' => 70)); ?>
                        </div>
                    </div>
                </div>
            <?php } ?>

        <?php } ?>
    </div>

    <?php if ($this->session->userdata('usertypeID') == 1) { ?>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box ">
                <a class="small-box-footer bg-orange-dark" href="<?= base_url('student') ?>">
                    <div class="icon  bg-orange-dark" style="padding: 9.5px 18px 8px 18px;">
                        <i class="fa fa-user"></i>
                    </div>
                    <div class="inner ">
                        <h3 class="text-white">
                            <?php
                            $this->db->where("active", 1);
                            echo $this->db->get("student")->num_rows();
                            ?>
                        </h3>
                        <p class="text-white">
                            <?= $this->lang->line('menu_student') ?>
                        </p>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box ">
                <a class="small-box-footer bg-teal-light" href="<?= base_url('teacher') ?>">
                    <div class="icon  bg-teal-light" style="padding: 9.5px 18px 8px 18px;">
                        <i class="fa icon-teacher"></i>
                    </div>
                    <div class="inner ">
                        <h3 class="text-white">
                            <?php
                            $this->db->where("active", 1);
                            echo $this->db->get("teacher")->num_rows();
                            ?>
                        </h3>
                        <p class="text-white">
                            <?= $this->lang->line('menu_teacher') ?>
                        </p>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box ">
                <a class="small-box-footer bg-pink-light" href="<?= base_url('parents') ?>">
                    <div class="icon bg-pink-light" style="padding: 9.5px 18px 8px 18px;">
                        <i class="fa fa-user"></i>
                    </div>
                    <div class="inner ">
                        <h3 class="text-white">
                            <?php
                            $this->db->where("active", 1);
                            echo $this->db->get("parents")->num_rows();
                            ?>
                        </h3>
                        <p class="text-white">
                            <?= $this->lang->line('menu_parents') ?>
                        </p>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box ">
                <a class="small-box-footer bg-purple-light" href="<?= base_url('student/index/1') ?>">
                    <div class="icon bg-purple-light" style="padding: 9.5px 18px 8px 18px;">
                        <i class="fa fa-sitemap"></i>
                    </div>
                    <div class="inner ">
                        <h3 class="text-white">
                            <?php
                            $this->db->where("classes", "A PRO ACADEMY CAIRO");
                            foreach ($this->db->get("classes")->result() as $classTRYOUT) {
                                $this->db->where("classesID", $classTRYOUT->classesID);
                                echo $this->db->get("section")->num_rows();
                            }
                            ?>
                        </h3>
                        <p class="text-white">
                            <?= $this->lang->line('menu_ACADEMIC_class') ?>
                        </p>
                    </div>
                </a>
            </div>
        </div>
        <?php $fullBallance = 0; ?>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box ">
                <a class="small-box-footer bg-green-gradient" href="javascript::();">
                    <div class="icon bg-green-gradient" style="padding: 9.5px 18px 8px 18px;">
                        <i class="fa fa-university"></i>
                    </div>
                    <div class="inner ">
                        <h3 class="text-white">
                            <?php
                            $this->db->where("balance", "bank");
                            $incomeBalance = 0;
                            foreach ($this->db->get("income")->result() as $income) {
                                $incomeBalance += $income->amount;
                            }
                            $this->db->where("balance", "bank");
                            $expenseBalance = 0;
                            foreach ($this->db->get("expense")->result() as $expense) {
                                $expenseBalance += $expense->amount;
                            }
                            $this->db->where("paymenttype", "bank");
                            $payBalance = 0;
                            foreach ($this->db->get("payment")->result() as $payment) {
                                $payBalance += $payment->paymentamount;
                            }
                            $fullBallance += (($incomeBalance + $payBalance) - $expenseBalance);
                            echo (($incomeBalance + $payBalance) - $expenseBalance);
                            ?>
                        </h3>
                        <p class="text-white">
                            <?= $this->lang->line('menu_bankBalance') ?>
                        </p>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box ">
                <a class="small-box-footer bg-green-gradient" href="javascript::();">
                    <div class="icon bg-green-gradient" style="padding: 9.5px 18px 8px 18px;">
                        <i class="fa fa-archive"></i>
                    </div>
                    <div class="inner ">
                        <h3 class="text-white">
                            <?php
                            $this->db->where("balance", "cash");
                            $incomeBalance = 0;
                            foreach ($this->db->get("income")->result() as $income) {
                                $incomeBalance += $income->amount;
                            }
                            $this->db->where("balance", "cash");
                            $expenseBalance = 0;
                            foreach ($this->db->get("expense")->result() as $expense) {
                                $expenseBalance += $expense->amount;
                            }
                            $this->db->where("paymenttype", "cash");
                            $payBalance = 0;
                            foreach ($this->db->get("payment")->result() as $payment) {
                                $payBalance += $payment->paymentamount;
                            }
                            $fullBallance += (($incomeBalance + $payBalance) - $expenseBalance);
                            echo (($incomeBalance + $payBalance) - $expenseBalance);
                            ?>
                        </h3>
                        <p class="text-white">
                            <?= $this->lang->line('menu_cashBalance') ?>
                        </p>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box ">
                <a class="small-box-footer bg-green-gradient" href="javascript::();">
                    <div class="icon bg-green-gradient" style="padding: 9.5px 18px 8px 18px;">
                        <i class="fa fa-money"></i>
                    </div>
                    <div class="inner ">
                        <h3 class="text-white">
                            <?php
                            echo $fullBallance;
                            ?>
                        </h3>
                        <p class="text-white">
                            <?= $this->lang->line('menu_BalanceTotal') ?>
                        </p>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box ">
                <a class="small-box-footer bg-purple-light" href="<?= base_url('student/index/5') ?>">
                    <div class="icon bg-purple-light" style="padding: 9.5px 18px 8px 18px;">
                        <i class="fa fa-sitemap"></i>
                    </div>
                    <div class="inner ">
                        <h3 class="text-white">
                            <?php
                            $this->db->where("classes", "TRYOUT");
                            foreach ($this->db->get("classes")->result() as $classTRYOUT) {
                                $this->db->where("classesID", $classTRYOUT->classesID);
                                echo $this->db->get("section")->num_rows();
                            }
                            ?>
                        </h3>
                        <p class="text-white">
                            <?= $this->lang->line('menu_TRYOUT_class') ?>
                        </p>
                    </div>
                </a>
            </div>
        </div>
    <?php } ?>
</div>

<?php if ($getActiveUserID == 1 || $getActiveUserID == 5) { ?>
    <div class="row" style="padding:0 30px;">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-body" style="padding: 0px;">
                    <div id="earningGraph"></div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<div class="row" style="padding:0 30px;">
    <div class="col-sm-12">
        <div class="box">
            <div class="box-header" style="background-color: #F4F3F1;padding: 5px;text-align: center;"><h4>Notices</h4></div>
            <div class="box-body" style="padding: 5px;">
                <table class="table table-responsive table-striped table-bordered" id="notice-area">
                    <thead>
                        <tr>
                            <th style="width: 3%;">#</th>
                            <th style="width: 30%;"><?= $this->lang->line('menu_notice_title') ?></th>
                            <th style="width: 40%;"><?= $this->lang->line('menu_notice_notice') ?></th>
                            <th style="width: 15%;"><?= $this->lang->line('menu_notice_date') ?></th>
                            <th style="width: 15%;"><?= $this->lang->line('menu_notice_action') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $this->db->where("userID", $getActiveUserID);
                        $this->db->where("userTypeID", $this->session->userdata('usertypeID'));
                        $qury = $this->db->get("prvt_notice");
                        if ($qury->num_rows() > 0) {
                            foreach ($qury->result() as $notice) {
                                echo "<tr id='notice_" . $notice->nID . "'>"
                                . "<td>" . $notice->nID . "</td>"
                                . "<td id='ntitle_" . $notice->nID . "'>" . $notice->title . "</td>"
                                . "<td id='nnotice_" . $notice->nID . "'>" . $notice->notice . "</td>"
                                . "<td id='ndate_" . $notice->nID . "'>" . $notice->date . "</td>"
                                . '<td id="naction_' . $notice->nID . '"><a href="javascipt::();" onclick="notice_action(' . $notice->nID . ', &quot;delete&quot;);" class="btn btn-danger btn-large mrg pull-right" data-placement="top" data-toggle="tooltip" data-original-title="'. $this->lang->line('menu_notice_delete') .'"><i class="fa fa-remove"></i></a>'
                                . '<a href="javascript::();" onclick="notice_action(' . $notice->nID . ', &quot;edit&quot;);" class="btn btn-warning btn-large mrg pull-right" data-placement="top" data-toggle="tooltip" data-original-title="'. $this->lang->line('menu_notice_edit') .'"><i class="fa fa-edit"></i></a></td>'
                                . "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5' style='text-align: center;'>No Notice found</td></tr>";
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th><input type="text" class="form-control" id="noticeTitle_<?= $getActiveUserID; ?>" placeholder="<?= $this->lang->line('menu_notice_title') ?>"/></th>
                            <th><textarea class="form-control" id="notice_<?= $getActiveUserID; ?>" placeholder="<?= $this->lang->line('menu_notice_notice') ?>" style="height: 34px;"></textarea></th>
                            <th><input type="date" class="form-control" id="noticeDate_<?= $getActiveUserID; ?>" value="<?= date("Y-m-d"); ?>"/></th>
                            <th><button class="btn btn-success pull-right" type="button" onclick="addNotice(<?= $getActiveUserID; ?>);"><?= $this->lang->line('menu_notice_add') ?></button></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<br/><br/>
<script>
    function addNotice(id) {
        var title = $("#noticeTitle_" + id).val();
        var notice = $('textarea#notice_' + id).val();
        var date = $("#noticeDate_" + id).val();
        if (title != "" && title != null && notice != "" && notice != null && date != "" && date != null) {
            $.ajax({
                type: 'POST',
                url: "<?= base_url('dashboard/add_notice') ?>",
                data: {id: id, title: title, notice: notice, date: date},
                dataType: "html",
                success: function (response) {
                    alert(response);
                    if (response == "Notice added successfully") {
                        $("#notice-area").load(window.location.href + " #notice-area");
                    }
                }
            });
        } else {
            alert("Some fields is missing");
        }
    }

    function notice_action(id, action) {
        if (localStorage.getItem("oldContent_" + id) === null) {
            localStorage["oldContent_" + id] = $("#notice_" + id).html();
        }
        if (action == "edit") {
            $("#ntitle_" + id).html('<input type="text" class="form-control" id="titleInput_' + id + '" value="' + $("#ntitle_" + id).html() + '"/>');
            $("#nnotice_" + id).html('<input type="text" class="form-control" id="noticeInput_' + id + '" value="' + $("#nnotice_" + id).html() + '"/>');
            $("#ndate_" + id).html('<input type="date" class="form-control" id="dateInput_' + id + '" value="' + $("#ndate_" + id).html() + '"/>');
            $("#naction_" + id).html('<a href="javascript::();" onclick="notice_action(' + id + ', &quot;cancel&quot;);" class="btn btn-danger btn-sm mrg pull-right" data-placement="top" data-toggle="tooltip" data-original-title="Cancel"><i class="fa fa-remove"></i></a>'
                    + '<a href="javascript::();" onclick="notice_action(' + id + ', &quot;confirm&quot;);" class="btn btn-success btn-sm mrg pull-right" data-placement="top" data-toggle="tooltip" data-original-title="<?= $this->lang->line('menu_notice_edit'); ?>"><?= $this->lang->line('menu_notice_edit'); ?></a>');
        } else if (action == "delete") {
            if (confirm("Are you sure to delete this notice (" + id + ") ??")) {
                $.ajax({
                    type: 'POST',
                    url: "<?= base_url('dashboard/delete_notice') ?>",
                    data: {id: id},
                    dataType: "html",
                    success: function (response) {
                        alert(response);
                        localStorage.removeItem("oldContent_" + id);
                        if (response == "Notice deleted successfully") {
                            $("#notice-area").load(window.location.href + " #notice-area");
                        }
                    }
                });
            }
        } else if (action == "cancel") {
            $("#notice_" + id).empty();
            $("#notice_" + id).html(localStorage["oldContent_" + id]);
            localStorage.removeItem("oldContent_" + id);
        } else if (action = "confirm") {
            var title = $("#titleInput_" + id).val();
            var notice = $("#noticeInput_" + id).val();t
            var date = $("#dateInput_" + id).val();
            if (title != "" && title != null && notice != "" && notice != null && date != "" && date != null) {
                $.ajax({
                    type: 'POST',
                    url: "<?= base_url('dashboard/edit_notice') ?>",
                    data: {id: id, title: title, notice: notice, date: date},
                    dataType: "html",
                    success: function (response) {
                        alert(response);
                        if (response == "Notice Edited successfully") {
                            $("#notice-area").load(window.location.href + " #notice-area");
                        }
                    }
                });
            } else {
                alert("Some fields is missing");
            }
        }
    }
</script>
<?php $this->load->view("dashboard/EarningHighChartJavascript.php"); ?>
