<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa icon-invoice"></i> <?= $this->lang->line('panel_title') ?></h3>
        <ol class="breadcrumb">
            <li><a href="<?= base_url("dashboard/index") ?>"><i class="fa fa-laptop"></i> <?= $this->lang->line('menu_dashboard') ?></a></li>
            <li class="active"><?= $this->lang->line('menu_invoice') ?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <?php if (($siteinfos->school_year == $this->session->userdata('defaultschoolyearID')) || ($this->session->userdata('usertypeID') == 1) || ($this->session->userdata('usertypeID') == 5)) { ?>
                    <?php if (permissionChecker('invoice_add')) { ?>
                        <h5 class="page-header">
                            <a href="<?php echo base_url('invoice/add') ?>">
                                <i class="fa fa-plus"></i> 
                                <?= $this->lang->line('add_title') ?>
                            </a>
                        </h5>
                    <?php } ?>
                <?php } ?>

                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#all" aria-expanded="true"><?= $this->lang->line('invoice_all') ?></a></li>
                        <li><a data-toggle="tab" href="#paid" aria-expanded="true"><?= $this->lang->line('invoice_paid') ?></a></li>
                        <li><a data-toggle="tab" href="#partialypaid" aria-expanded="true"><?= $this->lang->line('invoice_partially_paid') ?></a></li>
                        <li><a data-toggle="tab" href="#unpaid" aria-expanded="true"><?= $this->lang->line('invoice_unpaid') ?></a></li>
                        <li><a data-toggle="tab" href="#overDue" aria-expanded="true"><?= $this->lang->line('invoice_overDue') ?></a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="all" class="tab-pane active">
                            <div id="hide-table">
                                <table id="example1" class="table table-striped table-bordered table-hover dataTable no-footer">
                                    <thead>
                                        <tr>
                                            <th><?= $this->lang->line('slno') ?></th>
                                            <th><?= $this->lang->line('invoice_student') ?></th>
                                            <th><?= $this->lang->line('invoice_total') ?></th>
                                            <th><?= $this->lang->line('invoice_discount') ?></th>
                                            <th><?= $this->lang->line('invoice_paid') ?></th>
                                            <th><?= $this->lang->line('invoice_balance') ?></th>
                                            <th><?= $this->lang->line('invoice_onlystatus') ?></th>
                                            <th><?= $this->lang->line('invoice_date') ?></th>
                                            <?php if (permissionChecker('invoice_view') || permissionChecker('invoice_edit') || permissionChecker('invoice_delete')) { ?>
                                                <th><?= $this->lang->line('action') ?></th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (count($maininvoices)) {
                                            $i = 1;
                                            foreach ($maininvoices as $maininvoice) {
                                                ?>
                                                <tr>
                                                    <td data-title="<?= $this->lang->line('slno') ?>">
                                                        <?= " 000" . (($maininvoice->maininvoiceID * 10)) ?>
                                                    </td>
                                                    <td data-title="<?= $this->lang->line('invoice_student') ?>">
                                                        <?php echo $maininvoice->name; ?>
                                                    </td>
                                                    <td data-title="<?= $this->lang->line('invoice_total') ?>">
                                                        <?php
                                                        if (isset($grandtotalandpayment['totalamount'][$maininvoice->maininvoiceID])) {
                                                            echo number_format($grandtotalandpayment['totalamount'][$maininvoice->maininvoiceID], 2);
                                                        } else {
                                                            echo '0.00';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td data-title="<?= $this->lang->line('invoice_discount') ?>">
                                                        <?php
                                                        if (isset($grandtotalandpayment['totaldiscount'][$maininvoice->maininvoiceID])) {
                                                            echo number_format($grandtotalandpayment['totaldiscount'][$maininvoice->maininvoiceID], 2);
                                                        } else {
                                                            echo '0.00';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td data-title="<?= $this->lang->line('invoice_paid') ?>">
                                                        <?php
                                                        if (isset($grandtotalandpayment['totalpayment'][$maininvoice->maininvoiceID])) {
                                                            echo number_format($grandtotalandpayment['totalpayment'][$maininvoice->maininvoiceID], 2);
                                                        } else {
                                                            echo '0.00';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td data-title="<?= $this->lang->line('invoice_balance') ?>">
                                                        <?php
                                                        if (isset($grandtotalandpayment['grandtotal'][$maininvoice->maininvoiceID])) {
                                                            if (isset($grandtotalandpayment['totalpayment'][$maininvoice->maininvoiceID])) {
                                                                if (isset($grandtotalandpayment['totalweaver'][$maininvoice->maininvoiceID])) {
                                                                    $paymentandweaver = ($grandtotalandpayment['totalpayment'][$maininvoice->maininvoiceID] + $grandtotalandpayment['totalweaver'][$maininvoice->maininvoiceID]);
                                                                    echo number_format(((float) $grandtotalandpayment['grandtotal'][$maininvoice->maininvoiceID] - (float) $paymentandweaver), 2);
                                                                } else {
                                                                    echo number_format(((float) $grandtotalandpayment['grandtotal'][$maininvoice->maininvoiceID] - (float) $grandtotalandpayment['totalpayment'][$maininvoice->maininvoiceID]), 2);
                                                                }
                                                            } else {
                                                                if (isset($grandtotalandpayment['totalweaver'][$maininvoice->maininvoiceID])) {
                                                                    echo number_format(((float) $grandtotalandpayment['grandtotal'][$maininvoice->maininvoiceID] - (float) $grandtotalandpayment['totalweaver'][$maininvoice->maininvoiceID]), 2);
                                                                } else {
                                                                    echo number_format((float) $grandtotalandpayment['grandtotal'][$maininvoice->maininvoiceID], 2);
                                                                }
                                                            }
                                                        } else {
                                                            echo '0.00';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td data-title="<?= $this->lang->line('invoice_onlystatus') ?>">
                                                        <?php
                                                        $status = $maininvoice->maininvoicestatus;
                                                        $setButton = '';
                                                        if ($status == 0) {
                                                            $status = $this->lang->line('invoice_notpaid');
                                                            $setButton = 'btn-danger';
                                                        } elseif ($status == 1) {
                                                            $status = $this->lang->line('invoice_partially_paid');
                                                            $setButton = 'btn-warning';
                                                        } elseif ($status == 2) {
                                                            $status = $this->lang->line('invoice_fully_paid');
                                                            $setButton = 'btn-success';
                                                        }

                                                        echo "<button class='btn " . $setButton . " btn-xs'>" . $status . "</button>";
                                                        ?>
                                                    </td>
                                                    <td data-title="<?= $this->lang->line('invoice_date') ?>">
                                                        <?php echo date("d M Y", strtotime($maininvoice->maininvoicedate)); ?>
                                                    </td>
                                                    <?php if (permissionChecker('invoice_view') || permissionChecker('invoice_edit') || permissionChecker('invoice_delete')) { ?>
                                                        <td data-title="<?= $this->lang->line('action') ?>">
                                                            <?php echo btn_view('invoice/view/' . $maininvoice->maininvoiceID, $this->lang->line('view')) ?>
                                                            <?php if (($siteinfos->school_year == $this->session->userdata('defaultschoolyearID')) || ($this->session->userdata('usertypeID') == 1) || ($this->session->userdata('usertypeID') == 5)) { ?>
                                                                <?php
                                                                if ($maininvoice->maininvoicestatus != 1 && $maininvoice->maininvoicestatus != 2) {
                                                                    echo btn_edit('invoice/edit/' . $maininvoice->maininvoiceID, $this->lang->line('edit'));
                                                                }
                                                                ?>
                                                                <?php
                                                                if ($maininvoice->maininvoicestatus != 1 && $maininvoice->maininvoicestatus != 2) {
                                                                    echo btn_delete('invoice/delete/' . $maininvoice->maininvoiceID, $this->lang->line('delete'));
                                                                }
                                                                ?>
                                                            <?php } ?>
                                                            <?php
                                                            if (permissionChecker('invoice_view')) {
                                                                if ($maininvoice->maininvoicestatus != 2) {
                                                                    echo btn_invoice('invoice/payment/' . $maininvoice->maininvoiceID, $this->lang->line('payment'));
                                                                }
                                                            }
                                                            ?>
                                                            <?php
                                                            if (permissionChecker('invoice_view')) {
                                                                echo '<a href="#paymentlist" id="' . $maininvoice->maininvoiceID . '" class="btn btn-info btn-sm mrg getpaymentinfobtn" rel="tooltip" data-toggle="modal"><i class="fa fa-list-ul" data-toggle="tooltip" data-placement="top" data-original-title="' . $this->lang->line('invoice_view_payments') . '"></i></a>';
                                                            }
                                                            ?>
                                                        </td>
                                                    <?php } ?>
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
                        <div id="paid" class="tab-pane">
                            <div id="hide-table">
                                <table id="example1" class="table table-striped table-bordered table-hover dataTable no-footer">
                                    <thead>
                                        <tr>
                                            <th><?= $this->lang->line('slno') ?></th>
                                            <th><?= $this->lang->line('invoice_student') ?></th>
                                            <th><?= $this->lang->line('invoice_total') ?></th>
                                            <th><?= $this->lang->line('invoice_discount') ?></th>
                                            <th><?= $this->lang->line('invoice_paid') ?></th>
                                            <th><?= $this->lang->line('invoice_balance') ?></th>
                                            <th><?= $this->lang->line('invoice_onlystatus') ?></th>
                                            <th><?= $this->lang->line('invoice_date') ?></th>
                                            <?php if (permissionChecker('invoice_view') || permissionChecker('invoice_edit') || permissionChecker('invoice_delete')) { ?>
                                                <th><?= $this->lang->line('action') ?></th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (count($maininvoices)) {
                                            $i = 1;
                                            foreach ($maininvoices as $maininvoice) {
                                                if ($maininvoice->maininvoicestatus == 2) {
                                                    ?>
                                                    <tr>
                                                        <td data-title="<?= $this->lang->line('slno') ?>">
                                                            <?= " 000" . (($maininvoice->maininvoiceID * 10)) ?>
                                                        </td>
                                                        <td data-title="<?= $this->lang->line('invoice_student') ?>">
                                                            <?php echo $maininvoice->name; ?>
                                                        </td>
                                                        <td data-title="<?= $this->lang->line('invoice_total') ?>">
                                                            <?php
                                                            if (isset($grandtotalandpayment['totalamount'][$maininvoice->maininvoiceID])) {
                                                                echo number_format($grandtotalandpayment['totalamount'][$maininvoice->maininvoiceID], 2);
                                                            } else {
                                                                echo '0.00';
                                                            }
                                                            ?>
                                                        </td>
                                                        <td data-title="<?= $this->lang->line('invoice_discount') ?>">
                                                            <?php
                                                            if (isset($grandtotalandpayment['totaldiscount'][$maininvoice->maininvoiceID])) {
                                                                echo number_format($grandtotalandpayment['totaldiscount'][$maininvoice->maininvoiceID], 2);
                                                            } else {
                                                                echo '0.00';
                                                            }
                                                            ?>
                                                        </td>
                                                        <td data-title="<?= $this->lang->line('invoice_paid') ?>">
                                                            <?php
                                                            if (isset($grandtotalandpayment['totalpayment'][$maininvoice->maininvoiceID])) {
                                                                echo number_format($grandtotalandpayment['totalpayment'][$maininvoice->maininvoiceID], 2);
                                                            } else {
                                                                echo '0.00';
                                                            }
                                                            ?>
                                                        </td>
                                                        <td data-title="<?= $this->lang->line('invoice_balance') ?>">
                                                            <?php
                                                            if (isset($grandtotalandpayment['grandtotal'][$maininvoice->maininvoiceID])) {
                                                                if (isset($grandtotalandpayment['totalpayment'][$maininvoice->maininvoiceID])) {
                                                                    if (isset($grandtotalandpayment['totalweaver'][$maininvoice->maininvoiceID])) {
                                                                        $paymentandweaver = ($grandtotalandpayment['totalpayment'][$maininvoice->maininvoiceID] + $grandtotalandpayment['totalweaver'][$maininvoice->maininvoiceID]);
                                                                        echo number_format(((float) $grandtotalandpayment['grandtotal'][$maininvoice->maininvoiceID] - (float) $paymentandweaver), 2);
                                                                    } else {
                                                                        echo number_format(((float) $grandtotalandpayment['grandtotal'][$maininvoice->maininvoiceID] - (float) $grandtotalandpayment['totalpayment'][$maininvoice->maininvoiceID]), 2);
                                                                    }
                                                                } else {
                                                                    if (isset($grandtotalandpayment['totalweaver'][$maininvoice->maininvoiceID])) {
                                                                        echo number_format(((float) $grandtotalandpayment['grandtotal'][$maininvoice->maininvoiceID] - (float) $grandtotalandpayment['totalweaver'][$maininvoice->maininvoiceID]), 2);
                                                                    } else {
                                                                        echo number_format((float) $grandtotalandpayment['grandtotal'][$maininvoice->maininvoiceID], 2);
                                                                    }
                                                                }
                                                            } else {
                                                                echo '0.00';
                                                            }
                                                            ?>
                                                        </td>
                                                        <td data-title="<?= $this->lang->line('invoice_onlystatus') ?>">
                                                            <?php
                                                            $status = $this->lang->line('invoice_fully_paid');
                                                            $setButton = 'btn-success';
                                                            echo "<button class='btn " . $setButton . " btn-xs'>" . $status . "</button>";
                                                            ?>
                                                        </td>
                                                        <td data-title="<?= $this->lang->line('invoice_date') ?>">
                                                            <?php echo date("d M Y", strtotime($maininvoice->maininvoicedate)); ?>
                                                        </td>
                                                        <?php if (permissionChecker('invoice_view') || permissionChecker('invoice_edit') || permissionChecker('invoice_delete')) { ?>
                                                            <td data-title="<?= $this->lang->line('action') ?>">
                                                                <?php echo btn_view('invoice/view/' . $maininvoice->maininvoiceID, $this->lang->line('view')) ?>
                                                                <?php if (($siteinfos->school_year == $this->session->userdata('defaultschoolyearID')) || ($this->session->userdata('usertypeID') == 1) || ($this->session->userdata('usertypeID') == 5)) { ?>
                                                                    <?php
                                                                    if ($maininvoice->maininvoicestatus != 1 && $maininvoice->maininvoicestatus != 2) {
                                                                        echo btn_edit('invoice/edit/' . $maininvoice->maininvoiceID, $this->lang->line('edit'));
                                                                    }
                                                                    ?>
                                                                    <?php
                                                                    if ($maininvoice->maininvoicestatus != 1 && $maininvoice->maininvoicestatus != 2) {
                                                                        echo btn_delete('invoice/delete/' . $maininvoice->maininvoiceID, $this->lang->line('delete'));
                                                                    }
                                                                    ?>
                                                                <?php } ?>
                                                                <?php
                                                                if (permissionChecker('invoice_view')) {
                                                                    if ($maininvoice->maininvoicestatus != 2) {
                                                                        echo btn_invoice('invoice/payment/' . $maininvoice->maininvoiceID, $this->lang->line('payment'));
                                                                    }
                                                                }
                                                                ?>
                                                                <?php
                                                                if (permissionChecker('invoice_view')) {
                                                                    echo '<a href="#paymentlist" id="' . $maininvoice->maininvoiceID . '" class="btn btn-info btn-sm mrg getpaymentinfobtn" rel="tooltip" data-toggle="modal"><i class="fa fa-list-ul" data-toggle="tooltip" data-placement="top" data-original-title="' . $this->lang->line('invoice_view_payments') . '"></i></a>';
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
                        <div id="partialypaid" class="tab-pane">
                            <div id="hide-table">
                                <table id="example1" class="table table-striped table-bordered table-hover dataTable no-footer">
                                    <thead>
                                        <tr>
                                            <th><?= $this->lang->line('slno') ?></th>
                                            <th><?= $this->lang->line('invoice_student') ?></th>
                                            <th><?= $this->lang->line('invoice_total') ?></th>
                                            <th><?= $this->lang->line('invoice_discount') ?></th>
                                            <th><?= $this->lang->line('invoice_paid') ?></th>
                                            <th><?= $this->lang->line('invoice_balance') ?></th>
                                            <th><?= $this->lang->line('invoice_onlystatus') ?></th>
                                            <th><?= $this->lang->line('invoice_date') ?></th>
                                            <?php if (permissionChecker('invoice_view') || permissionChecker('invoice_edit') || permissionChecker('invoice_delete')) { ?>
                                                <th><?= $this->lang->line('action') ?></th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (count($maininvoices)) {
                                            $i = 1;
                                            foreach ($maininvoices as $maininvoice) {
                                                if ($maininvoice->maininvoicestatus == 1) {
                                                    ?>
                                                    <tr>
                                                        <td data-title="<?= $this->lang->line('slno') ?>">
                                                            <?= " 000" . (($maininvoice->maininvoiceID * 10)) ?>
                                                        </td>
                                                        <td data-title="<?= $this->lang->line('invoice_student') ?>">
                                                            <?php echo $maininvoice->name; ?>
                                                        </td>
                                                        <td data-title="<?= $this->lang->line('invoice_total') ?>">
                                                            <?php
                                                            if (isset($grandtotalandpayment['totalamount'][$maininvoice->maininvoiceID])) {
                                                                echo number_format($grandtotalandpayment['totalamount'][$maininvoice->maininvoiceID], 2);
                                                            } else {
                                                                echo '0.00';
                                                            }
                                                            ?>
                                                        </td>
                                                        <td data-title="<?= $this->lang->line('invoice_discount') ?>">
                                                            <?php
                                                            if (isset($grandtotalandpayment['totaldiscount'][$maininvoice->maininvoiceID])) {
                                                                echo number_format($grandtotalandpayment['totaldiscount'][$maininvoice->maininvoiceID], 2);
                                                            } else {
                                                                echo '0.00';
                                                            }
                                                            ?>
                                                        </td>
                                                        <td data-title="<?= $this->lang->line('invoice_paid') ?>">
                                                            <?php
                                                            if (isset($grandtotalandpayment['totalpayment'][$maininvoice->maininvoiceID])) {
                                                                echo number_format($grandtotalandpayment['totalpayment'][$maininvoice->maininvoiceID], 2);
                                                            } else {
                                                                echo '0.00';
                                                            }
                                                            ?>
                                                        </td>
                                                        <td data-title="<?= $this->lang->line('invoice_balance') ?>">
                                                            <?php
                                                            if (isset($grandtotalandpayment['grandtotal'][$maininvoice->maininvoiceID])) {
                                                                if (isset($grandtotalandpayment['totalpayment'][$maininvoice->maininvoiceID])) {
                                                                    if (isset($grandtotalandpayment['totalweaver'][$maininvoice->maininvoiceID])) {
                                                                        $paymentandweaver = ($grandtotalandpayment['totalpayment'][$maininvoice->maininvoiceID] + $grandtotalandpayment['totalweaver'][$maininvoice->maininvoiceID]);
                                                                        echo number_format(((float) $grandtotalandpayment['grandtotal'][$maininvoice->maininvoiceID] - (float) $paymentandweaver), 2);
                                                                    } else {
                                                                        echo number_format(((float) $grandtotalandpayment['grandtotal'][$maininvoice->maininvoiceID] - (float) $grandtotalandpayment['totalpayment'][$maininvoice->maininvoiceID]), 2);
                                                                    }
                                                                } else {
                                                                    if (isset($grandtotalandpayment['totalweaver'][$maininvoice->maininvoiceID])) {
                                                                        echo number_format(((float) $grandtotalandpayment['grandtotal'][$maininvoice->maininvoiceID] - (float) $grandtotalandpayment['totalweaver'][$maininvoice->maininvoiceID]), 2);
                                                                    } else {
                                                                        echo number_format((float) $grandtotalandpayment['grandtotal'][$maininvoice->maininvoiceID], 2);
                                                                    }
                                                                }
                                                            } else {
                                                                echo '0.00';
                                                            }
                                                            ?>
                                                        </td>
                                                        <td data-title="<?= $this->lang->line('invoice_onlystatus') ?>">
                                                            <?php
                                                            $status = $this->lang->line('invoice_partially_paid');
                                                            $setButton = 'btn-warning';
                                                            echo "<button class='btn " . $setButton . " btn-xs'>" . $status . "</button>";
                                                            ?>
                                                        </td>
                                                        <td data-title="<?= $this->lang->line('invoice_date') ?>">
                                                            <?php echo date("d M Y", strtotime($maininvoice->maininvoicedate)); ?>
                                                        </td>
                                                        <?php if (permissionChecker('invoice_view') || permissionChecker('invoice_edit') || permissionChecker('invoice_delete')) { ?>
                                                            <td data-title="<?= $this->lang->line('action') ?>">
                                                                <?php echo btn_view('invoice/view/' . $maininvoice->maininvoiceID, $this->lang->line('view')) ?>
                                                                <?php if (($siteinfos->school_year == $this->session->userdata('defaultschoolyearID')) || ($this->session->userdata('usertypeID') == 1) || ($this->session->userdata('usertypeID') == 5)) { ?>
                                                                    <?php
                                                                    if ($maininvoice->maininvoicestatus != 1 && $maininvoice->maininvoicestatus != 2) {
                                                                        echo btn_edit('invoice/edit/' . $maininvoice->maininvoiceID, $this->lang->line('edit'));
                                                                    }
                                                                    ?>
                                                                    <?php
                                                                    if ($maininvoice->maininvoicestatus != 1 && $maininvoice->maininvoicestatus != 2) {
                                                                        echo btn_delete('invoice/delete/' . $maininvoice->maininvoiceID, $this->lang->line('delete'));
                                                                    }
                                                                    ?>
                                                                <?php } ?>
                                                                <?php
                                                                if (permissionChecker('invoice_view')) {
                                                                    if ($maininvoice->maininvoicestatus != 2) {
                                                                        echo btn_invoice('invoice/payment/' . $maininvoice->maininvoiceID, $this->lang->line('payment'));
                                                                    }
                                                                }
                                                                ?>
                                                                <?php
                                                                if (permissionChecker('invoice_view')) {
                                                                    echo '<a href="#paymentlist" id="' . $maininvoice->maininvoiceID . '" class="btn btn-info btn-sm mrg getpaymentinfobtn" rel="tooltip" data-toggle="modal"><i class="fa fa-list-ul" data-toggle="tooltip" data-placement="top" data-original-title="' . $this->lang->line('invoice_view_payments') . '"></i></a>';
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
                        <div id="unpaid" class="tab-pane">
                            <div id="hide-table">
                                <table id="example1" class="table table-striped table-bordered table-hover dataTable no-footer">
                                    <thead>
                                        <tr>
                                            <th><?= $this->lang->line('slno') ?></th>
                                            <th><?= $this->lang->line('invoice_student') ?></th>
                                            <th><?= $this->lang->line('invoice_total') ?></th>
                                            <th><?= $this->lang->line('invoice_discount') ?></th>
                                            <th><?= $this->lang->line('invoice_paid') ?></th>
                                            <th><?= $this->lang->line('invoice_balance') ?></th>
                                            <th><?= $this->lang->line('invoice_onlystatus') ?></th>
                                            <th><?= $this->lang->line('invoice_date') ?></th>
                                            <?php if (permissionChecker('invoice_view') || permissionChecker('invoice_edit') || permissionChecker('invoice_delete')) { ?>
                                                <th><?= $this->lang->line('action') ?></th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (count($maininvoices)) {
                                            $i = 1;
                                            foreach ($maininvoices as $maininvoice) {
                                                if ($maininvoice->maininvoicestatus == 0) {
                                                    ?>
                                                    <tr>
                                                        <td data-title="<?= $this->lang->line('slno') ?>">
                                                            <?= " 000" . (($maininvoice->maininvoiceID * 10)) ?>
                                                        </td>
                                                        <td data-title="<?= $this->lang->line('invoice_student') ?>">
                                                            <?php echo $maininvoice->name; ?>
                                                        </td>
                                                        <td data-title="<?= $this->lang->line('invoice_total') ?>">
                                                            <?php
                                                            if (isset($grandtotalandpayment['totalamount'][$maininvoice->maininvoiceID])) {
                                                                echo number_format($grandtotalandpayment['totalamount'][$maininvoice->maininvoiceID], 2);
                                                            } else {
                                                                echo '0.00';
                                                            }
                                                            ?>
                                                        </td>
                                                        <td data-title="<?= $this->lang->line('invoice_discount') ?>">
                                                            <?php
                                                            if (isset($grandtotalandpayment['totaldiscount'][$maininvoice->maininvoiceID])) {
                                                                echo number_format($grandtotalandpayment['totaldiscount'][$maininvoice->maininvoiceID], 2);
                                                            } else {
                                                                echo '0.00';
                                                            }
                                                            ?>
                                                        </td>
                                                        <td data-title="<?= $this->lang->line('invoice_paid') ?>">
                                                            <?php
                                                            if (isset($grandtotalandpayment['totalpayment'][$maininvoice->maininvoiceID])) {
                                                                echo number_format($grandtotalandpayment['totalpayment'][$maininvoice->maininvoiceID], 2);
                                                            } else {
                                                                echo '0.00';
                                                            }
                                                            ?>
                                                        </td>
                                                        <td data-title="<?= $this->lang->line('invoice_balance') ?>">
                                                            <?php
                                                            if (isset($grandtotalandpayment['grandtotal'][$maininvoice->maininvoiceID])) {
                                                                if (isset($grandtotalandpayment['totalpayment'][$maininvoice->maininvoiceID])) {
                                                                    if (isset($grandtotalandpayment['totalweaver'][$maininvoice->maininvoiceID])) {
                                                                        $paymentandweaver = ($grandtotalandpayment['totalpayment'][$maininvoice->maininvoiceID] + $grandtotalandpayment['totalweaver'][$maininvoice->maininvoiceID]);
                                                                        echo number_format(((float) $grandtotalandpayment['grandtotal'][$maininvoice->maininvoiceID] - (float) $paymentandweaver), 2);
                                                                    } else {
                                                                        echo number_format(((float) $grandtotalandpayment['grandtotal'][$maininvoice->maininvoiceID] - (float) $grandtotalandpayment['totalpayment'][$maininvoice->maininvoiceID]), 2);
                                                                    }
                                                                } else {
                                                                    if (isset($grandtotalandpayment['totalweaver'][$maininvoice->maininvoiceID])) {
                                                                        echo number_format(((float) $grandtotalandpayment['grandtotal'][$maininvoice->maininvoiceID] - (float) $grandtotalandpayment['totalweaver'][$maininvoice->maininvoiceID]), 2);
                                                                    } else {
                                                                        echo number_format((float) $grandtotalandpayment['grandtotal'][$maininvoice->maininvoiceID], 2);
                                                                    }
                                                                }
                                                            } else {
                                                                echo '0.00';
                                                            }
                                                            ?>
                                                        </td>
                                                        <td data-title="<?= $this->lang->line('invoice_onlystatus') ?>">
                                                            <?php
                                                            $status = $this->lang->line('invoice_notpaid');
                                                            $setButton = 'btn-danger';
                                                            echo "<button class='btn " . $setButton . " btn-xs'>" . $status . "</button>";
                                                            ?>
                                                        </td>
                                                        <td data-title="<?= $this->lang->line('invoice_date') ?>">
                                                            <?php echo date("d M Y", strtotime($maininvoice->maininvoicedate)); ?>
                                                        </td>
                                                        <?php if (permissionChecker('invoice_view') || permissionChecker('invoice_edit') || permissionChecker('invoice_delete')) { ?>
                                                            <td data-title="<?= $this->lang->line('action') ?>">
                                                                <?php echo btn_view('invoice/view/' . $maininvoice->maininvoiceID, $this->lang->line('view')) ?>
                                                                <?php if (($siteinfos->school_year == $this->session->userdata('defaultschoolyearID')) || ($this->session->userdata('usertypeID') == 1) || ($this->session->userdata('usertypeID') == 5)) { ?>
                                                                    <?php
                                                                    if ($maininvoice->maininvoicestatus != 1 && $maininvoice->maininvoicestatus != 2) {
                                                                        echo btn_edit('invoice/edit/' . $maininvoice->maininvoiceID, $this->lang->line('edit'));
                                                                    }
                                                                    ?>
                                                                    <?php
                                                                    if ($maininvoice->maininvoicestatus != 1 && $maininvoice->maininvoicestatus != 2) {
                                                                        echo btn_delete('invoice/delete/' . $maininvoice->maininvoiceID, $this->lang->line('delete'));
                                                                    }
                                                                    ?>
                                                                <?php } ?>
                                                                <?php
                                                                if (permissionChecker('invoice_view')) {
                                                                    if ($maininvoice->maininvoicestatus != 2) {
                                                                        echo btn_invoice('invoice/payment/' . $maininvoice->maininvoiceID, $this->lang->line('payment'));
                                                                    }
                                                                }
                                                                ?>
                                                                <?php
                                                                if (permissionChecker('invoice_view')) {
                                                                    echo '<a href="#paymentlist" id="' . $maininvoice->maininvoiceID . '" class="btn btn-info btn-sm mrg getpaymentinfobtn" rel="tooltip" data-toggle="modal"><i class="fa fa-list-ul" data-toggle="tooltip" data-placement="top" data-original-title="' . $this->lang->line('invoice_view_payments') . '"></i></a>';
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
                        <div id="overDue" class="tab-pane">
                            <div id="hide-table">
                                <table id="example1" class="table table-striped table-bordered table-hover dataTable no-footer">
                                    <thead>
                                        <tr>
                                            <th><?= $this->lang->line('slno') ?></th>
                                            <th><?= $this->lang->line('invoice_student') ?></th>
                                            <th><?= $this->lang->line('invoice_total') ?></th>
                                            <th><?= $this->lang->line('invoice_discount') ?></th>
                                            <th><?= $this->lang->line('invoice_paid') ?></th>
                                            <th><?= $this->lang->line('invoice_balance') ?></th>
                                            <th><?= $this->lang->line('invoice_onlystatus') ?></th>
                                            <th><?= $this->lang->line('invoice_date') ?></th>
                                            <?php if (permissionChecker('invoice_view') || permissionChecker('invoice_edit') || permissionChecker('invoice_delete')) { ?>
                                                <th><?= $this->lang->line('action') ?></th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $now = new DateTime();

                                        if (count($maininvoices)) {
                                            $i = 1;
                                            foreach ($maininvoices as $maininvoice) {
                                                $date = new DateTime($maininvoice->maininvoicedate);
                                                if (((int) date("Y", strtotime($maininvoice->maininvoicedate)) >= (int) date("Y")) && $date < $now && ($maininvoice->maininvoicestatus == 0 || $maininvoice->maininvoicestatus == 1)) {
                                                    ?>
                                                    <tr>
                                                        <td data-title="<?= $this->lang->line('slno') ?>">
                                                            <?= " 000" . (($maininvoice->maininvoiceID * 10)) ?>
                                                        </td>
                                                        <td data-title="<?= $this->lang->line('invoice_student') ?>">
                                                            <?php echo $maininvoice->name; ?>
                                                        </td>
                                                        <td data-title="<?= $this->lang->line('invoice_total') ?>">
                                                            <?php
                                                            if (isset($grandtotalandpayment['totalamount'][$maininvoice->maininvoiceID])) {
                                                                echo number_format($grandtotalandpayment['totalamount'][$maininvoice->maininvoiceID], 2);
                                                            } else {
                                                                echo '0.00';
                                                            }
                                                            ?>
                                                        </td>
                                                        <td data-title="<?= $this->lang->line('invoice_discount') ?>">
                                                            <?php
                                                            if (isset($grandtotalandpayment['totaldiscount'][$maininvoice->maininvoiceID])) {
                                                                echo number_format($grandtotalandpayment['totaldiscount'][$maininvoice->maininvoiceID], 2);
                                                            } else {
                                                                echo '0.00';
                                                            }
                                                            ?>
                                                        </td>
                                                        <td data-title="<?= $this->lang->line('invoice_paid') ?>">
                                                            <?php
                                                            if (isset($grandtotalandpayment['totalpayment'][$maininvoice->maininvoiceID])) {
                                                                echo number_format($grandtotalandpayment['totalpayment'][$maininvoice->maininvoiceID], 2);
                                                            } else {
                                                                echo '0.00';
                                                            }
                                                            ?>
                                                        </td>
                                                        <td data-title="<?= $this->lang->line('invoice_balance') ?>">
                                                            <?php
                                                            if (isset($grandtotalandpayment['grandtotal'][$maininvoice->maininvoiceID])) {
                                                                if (isset($grandtotalandpayment['totalpayment'][$maininvoice->maininvoiceID])) {
                                                                    if (isset($grandtotalandpayment['totalweaver'][$maininvoice->maininvoiceID])) {
                                                                        $paymentandweaver = ($grandtotalandpayment['totalpayment'][$maininvoice->maininvoiceID] + $grandtotalandpayment['totalweaver'][$maininvoice->maininvoiceID]);
                                                                        echo number_format(((float) $grandtotalandpayment['grandtotal'][$maininvoice->maininvoiceID] - (float) $paymentandweaver), 2);
                                                                    } else {
                                                                        echo number_format(((float) $grandtotalandpayment['grandtotal'][$maininvoice->maininvoiceID] - (float) $grandtotalandpayment['totalpayment'][$maininvoice->maininvoiceID]), 2);
                                                                    }
                                                                } else {
                                                                    if (isset($grandtotalandpayment['totalweaver'][$maininvoice->maininvoiceID])) {
                                                                        echo number_format(((float) $grandtotalandpayment['grandtotal'][$maininvoice->maininvoiceID] - (float) $grandtotalandpayment['totalweaver'][$maininvoice->maininvoiceID]), 2);
                                                                    } else {
                                                                        echo number_format((float) $grandtotalandpayment['grandtotal'][$maininvoice->maininvoiceID], 2);
                                                                    }
                                                                }
                                                            } else {
                                                                echo '0.00';
                                                            }
                                                            ?>
                                                        </td>
                                                        <td data-title="<?= $this->lang->line('invoice_onlystatus') ?>">
                                                            <?php
                                                            $status = $maininvoice->maininvoicestatus;
                                                            $setButton = '';
                                                            if ($status == 0) {
                                                                $status = $this->lang->line('invoice_notpaid');
                                                                $setButton = 'btn-danger';
                                                            } elseif ($status == 1) {
                                                                $status = $this->lang->line('invoice_partially_paid');
                                                                $setButton = 'btn-warning';
                                                            }
                                                            echo "<button class='btn " . $setButton . " btn-xs'>" . $status . "</button>";
                                                            ?>
                                                        </td>
                                                        <td data-title="<?= $this->lang->line('invoice_date') ?>">
                                                            <?php echo date("d M Y", strtotime($maininvoice->maininvoicedate)); ?>
                                                        </td>
                                                        <?php if (permissionChecker('invoice_view') || permissionChecker('invoice_edit') || permissionChecker('invoice_delete')) { ?>
                                                            <td data-title="<?= $this->lang->line('action') ?>">
                                                                <?php echo btn_view('invoice/view/' . $maininvoice->maininvoiceID, $this->lang->line('view')) ?>
                                                                <?php if (($siteinfos->school_year == $this->session->userdata('defaultschoolyearID')) || ($this->session->userdata('usertypeID') == 1) || ($this->session->userdata('usertypeID') == 5)) { ?>
                                                                    <?php
                                                                    if ($maininvoice->maininvoicestatus != 1 && $maininvoice->maininvoicestatus != 2) {
                                                                        echo btn_edit('invoice/edit/' . $maininvoice->maininvoiceID, $this->lang->line('edit'));
                                                                    }
                                                                    ?>
                                                                    <?php
                                                                    if ($maininvoice->maininvoicestatus != 1 && $maininvoice->maininvoicestatus != 2) {
                                                                        echo btn_delete('invoice/delete/' . $maininvoice->maininvoiceID, $this->lang->line('delete'));
                                                                    }
                                                                    ?>
                                                                <?php } ?>
                                                                <?php
                                                                if (permissionChecker('invoice_view')) {
                                                                    if ($maininvoice->maininvoicestatus != 2) {
                                                                        echo btn_invoice('invoice/payment/' . $maininvoice->maininvoiceID, $this->lang->line('payment'));
                                                                    }
                                                                }
                                                                ?>
                                                                <?php
                                                                if (permissionChecker('invoice_view')) {
                                                                    echo '<a href="#paymentlist" id="' . $maininvoice->maininvoiceID . '" class="btn btn-info btn-sm mrg getpaymentinfobtn" rel="tooltip" data-toggle="modal"><i class="fa fa-list-ul" data-toggle="tooltip" data-placement="top" data-original-title="' . $this->lang->line('invoice_view_payments') . '"></i></a>';
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="paymentlist">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title"><?= $this->lang->line('invoice_view_payments') ?></h4>
            </div>
            <div class="modal-body">
                <div id="hide-table">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th><?= $this->lang->line('slno') ?></th>
                                <th><?= $this->lang->line('invoice_date') ?></th>
                                <th><?= $this->lang->line('invoice_paidby') ?></th>
                                <th><?= $this->lang->line('invoice_paymentamount') ?></th>
                                <th><?= $this->lang->line('invoice_weaver') ?></th>
                                <th><?= $this->lang->line('invoice_fine') ?></th>
                                <th><?= $this->lang->line('action') ?></th>
                            </tr>
                        </thead>
                        <tbody id="payment-list-body">

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" style="margin-bottom:0px;" data-dismiss="modal"><?= $this->lang->line('close') ?></button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('.getpaymentinfobtn').click(function () {
        var maininvoiceID = $(this).attr('id');
        if (maininvoiceID > 0) {
            $.ajax({
                type: 'POST',
                url: "<?= base_url('invoice/paymentlist') ?>",
                data: {'maininvoiceID': maininvoiceID},
                dataType: "html",
                success: function (data) {
                    $('#payment-list-body').children().remove();
                    $('#payment-list-body').append(data);
                }
            });
        }
    });
</script>
