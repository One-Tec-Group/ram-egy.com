
<div class="box">
    <div class="box-body">
        <div class="row">
            <?php include_once 'sidebar.php'; ?>
            <!-- reply error -->

            <!-- message box -->
            <div class="col-md-9">
                <!-- Chat box -->
                <div class="box box-success">
                    <div class="box-header">
                        <h3 class="box-title"><?= $this->lang->line('conversation_conversation') ?></h3>
                    </div>
                    <div class="box-body chat" id="chat-box">
                        <!-- chat item -->
                        <?php foreach ($messages as $message): ?>
                            <div class="item">
                                <img src="<?= imagelink($message->photo) ?>" alt="user image" class="online"/>
                                <p class="message">
                                    <a href="#" class="name">
                                        <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> <?= date('d M Y h:i:s A', strtotime($message->create_date)) ?></small>
                                        <?php echo $message->sender; ?>
                                    </a>
                                    <?php echo $message->msg; ?>
                                </p>
                                <?php if ($message->attach1): ?>
                                    <div class="attachment">
                                        <h4><?= $this->lang->line('attachment') ?>:</h4>
                                        <p class="filename">
                                            <?php echo $message->attach1; ?>
                                        </p>
                                        <div class="pull-right">
                                            <a target="_blank" href="<?php echo base_url("uploads/attach/$message->attach_file_name1"); ?>"
                                               download class="btn btn-primary btn-sm btn-flat"><?= $this->lang->line('open') ?></a>
                                        </div>
                                    </div><!-- /.attachment -->           
                                <?php endif ?>
                                <?php if ($message->attach2): ?>
                                    <div class="attachment">
                                        <h4><?= $this->lang->line('attachment') ?>:</h4>
                                        <p class="filename">
                                            <?php echo $message->attach2; ?>
                                        </p>
                                        <div class="pull-right">
                                            <a target="_blank" href="<?php echo base_url("uploads/attach/$message->attach_file_name2"); ?>"
                                               download class="btn btn-primary btn-sm btn-flat"><?= $this->lang->line('open') ?></a>
                                        </div>
                                    </div><!-- /.attachment -->           
                                <?php endif ?>
                                <?php if ($message->attach3): ?>
                                    <div class="attachment">
                                        <h4><?= $this->lang->line('attachment') ?>:</h4>
                                        <p class="filename">
                                            <?php echo $message->attach3; ?>
                                        </p>
                                        <div class="pull-right">
                                            <a target="_blank" href="<?php echo base_url("uploads/attach/$message->attach_file_name3"); ?>"
                                               download class="btn btn-primary btn-sm btn-flat"><?= $this->lang->line('open') ?></a>
                                        </div>
                                    </div><!-- /.attachment -->           
                                <?php endif ?>
                            </div><!-- /.item -->
                        <?php endforeach ?>
                        <!-- chat item -->
                    </div><!-- /.chat -->
                    <div class="box-footer">
                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input class="form-control" id="reply" name="reply" placeholder="<?= $this->lang->line('typemessage') ?>..."/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="btn btn-info btn-file">
                                    <i class="fa fa-paperclip"></i> <?= $this->lang->line('attachment') ?>
                                    <input type="file" id="attachment1" name="attachment1"/>
                                </div>
                                <div class="btn btn-warning" onclick="openAttach(2);" id="attachBtn2" style="width: 37px;height: 34px;">
                                    <i class="fa fa-plus"></i>
                                </div>
                                <div class="col-sm-3" style="padding-left:0;">
                                    <input class="form-control"  id="uploadFile1" placeholder="<?= $this->lang->line('choosefile'); ?>" disabled />
                                </div>
                                <div class="has-error">
                                    <p class="text-danger"> <?php if (isset($attachment_error)) echo $attachment_error; ?></p>
                                </div>
                            </div>
                            <div class="form-group" style="display:none;" id='attachmentDiv2'>
                                <div class="btn btn-info btn-file">
                                    <i class="fa fa-paperclip"></i> <?= $this->lang->line('attachment') ?>
                                    <input type="file" id="attachment2" name="attachment2"/>
                                </div>
                                <div class="btn btn-danger" onclick="closeAttach(2);" id="attachBtnRemove2" style="width: 37px;height: 34px;">
                                    <i class="fa fa-remove"></i>
                                </div>
                                <div class="btn btn-warning" onclick="openAttach(3);" id="attachBtn3" style="width: 37px;height: 34px;">
                                    <i class="fa fa-plus"></i>
                                </div>
                                <div class="col-sm-3" style="padding-left:0;">
                                    <input class="form-control"  id="uploadFile2" placeholder="<?= $this->lang->line('choosefile'); ?>" disabled />
                                </div>
                                <div class="has-error">
                                    <p class="text-danger"> <?php if (isset($attachment_error)) echo $attachment_error; ?></p>
                                </div>
                            </div>
                            <div class="form-group" style="display:none;" id='attachmentDiv3'>
                                <div class="btn btn-info btn-file">
                                    <i class="fa fa-paperclip"></i> <?= $this->lang->line('attachment') ?>
                                    <input type="file" id="attachment3" name="attachment3"/>
                                </div>
                                <div class="btn btn-danger" onclick="closeAttach(3);" id="attachBtnRemove3" style="width: 37px;height: 34px;">
                                    <i class="fa fa-remove"></i>
                                </div>
                                <div class="btn btn-warning" onclick="openAttach(4);" id="attachBtn4" style="width: 37px;height: 34px;">
                                    <i class="fa fa-plus"></i>
                                </div>
                                <div class="col-sm-3" style="padding-left:0;">
                                    <input class="form-control"  id="uploadFile3" placeholder="<?= $this->lang->line('choosefile'); ?>" disabled />
                                </div>
                                <div class="has-error">
                                    <p class="text-danger"> <?php if (isset($attachment_error)) echo $attachment_error; ?></p>
                                </div>
                            </div>
                            <div class="form-group" style="display:none;" id='attachmentDiv4'>
                                <div class="btn btn-info btn-file">
                                    <i class="fa fa-paperclip"></i> <?= $this->lang->line('attachment') ?>
                                    <input type="file" id="attachment4" name="attachment4"/>
                                </div>
                                <div class="btn btn-danger" onclick="closeAttach(4);" id="attachBtnRemove4" style="width: 37px;height: 34px;">
                                    <i class="fa fa-remove"></i>
                                </div>
                                <div class="col-sm-3" style="padding-left:0;">
                                    <input class="form-control" id="uploadFile4" placeholder="<?= $this->lang->line('choosefile'); ?>" disabled />
                                </div>
                                <div class="has-error">
                                    <p class="text-danger"> <?php if (isset($attachment_error)) echo $attachment_error; ?></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-8">
                                    <input type="submit" value="<?= $this->lang->line('reply') ?>" class="btn btn-success">
                                </div>
                            </div>
                        </form>
                    </div>
                </div><!-- /.box (chat box) -->
            </div><!-- /.col -->
        </div>
    </div>
</div>
<!-- Slimscroll -->
<script src="<?php echo base_url(); ?>assets/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script type="text/javascript">
                                    document.getElementById("attachment1").onchange = function () {
                                        document.getElementById("uploadFile1").value = this.value;
                                    };
                                    document.getElementById("attachment2").onchange = function () {
                                        document.getElementById("uploadFile2").value = this.value;
                                    };
                                    document.getElementById("attachment3").onchange = function () {
                                        document.getElementById("uploadFile3").value = this.value;
                                    };
                                    document.getElementById("attachment4").onchange = function () {
                                        document.getElementById("uploadFile4").value = this.value;
                                    };

                                    function openAttach(id) {
                                        $("#attachBtn" + id).css("display", "none");
                                        $("#attachmentDiv" + id).css("display", "block");
                                        $("#attachBtnRemove" + (id - 1)).css("display", "none");
                                    }

                                    function closeAttach(id) {
                                        $("#attachBtn" + id).css("display", "inline");
                                        $("#attachmentDiv" + id).css("display", "none");
                                        $("#attachBtnRemove" + (id - 1)).css("display", "inline");
                                        $("#attachBtnRemove" + (id - 1)).css("margin-right", "3px");
                                    }

                                    $('#chat-box').slimScroll({
                                        height: '250px',
                                        start: 'bottom'
                                    });
</script>
