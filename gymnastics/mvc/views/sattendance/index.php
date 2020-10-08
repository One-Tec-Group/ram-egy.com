
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa icon-sattendance"></i> <?=$this->lang->line('panel_title')?></h3>

       
        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li class="active"><?=$this->lang->line('menu_sattendance')?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <?php if((($siteinfos->school_year == $this->session->userdata('defaultschoolyearID') || $this->session->userdata('usertypeID') == 1)) || ($this->session->userdata('usertypeID') != 3)) { ?>
                    <h5 class="page-header">
                        <?php if(($siteinfos->school_year == $this->session->userdata('defaultschoolyearID') || $this->session->userdata('usertypeID') == 1)) { ?>
                            <?php if(permissionChecker('sattendance_add')) { ?>
                                <a href="<?php echo base_url('sattendance/add') ?>">
                                    <i class="fa fa-plus"></i> 
                                    <?=$this->lang->line('add_title')?>
                                </a>
                            <?php } ?>
                        <?php } ?>

                        <?php if($this->session->userdata('usertypeID') != 3) { ?>
                            
                        <?php } ?>
                    </h5>
                <?php } ?>
                
                <?php if(count($students) > 0 ) { ?>
                    
                <?php } else { ?>
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#all" aria-expanded="true"><?=$this->lang->line("attendance_all_students")?></a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="all" class="tab-pane active">
                                <div id="hide-table">
                                    
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
    $('.select2').select2();
    $('#classesID').change(function() {
        var classesID = $(this).val();
        if(classesID == 0) {
            $('#hide-table').hide();
        } else {
            $.ajax({
                type: 'POST',
                url: "<?=base_url('sattendance/student_list')?>",
                data: "id=" + classesID,
                dataType: "html",
                success: function(data) {
                    window.location.href = data;
                }
            });
        }
    });
</script>