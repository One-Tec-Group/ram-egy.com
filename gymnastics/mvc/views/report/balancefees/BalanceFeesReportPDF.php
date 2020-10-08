<div class="box">
    <!-- form start -->
    <div class="box-body" style="margin-bottom: 50px;">
        <div class="row">
            <div class="col-sm-12">
                <?=reportheader($siteinfos, $schoolyearsessionobj, true)?>
            </div>
            <div class="box-header bg-gray">
                <h3 class="box-title text-navy"><i class="fa fa-clipboard"></i>
                    <?=$this->lang->line('balancefeesreport_report_for')?> - 
                    <?=$this->lang->line('balancefeesreport_balancefees');?>
                </h3>
            </div><!-- /.box-header -->
            <?php if($classesID >= 0 || $sectionID >= 0 ) { ?>
            <div class="col-sm-12">
                <h5 class="pull-left">
                    <?php 
                        echo $this->lang->line('balancefeesreport_class')." : ";
                        echo isset($classes[$classesID]) ? $classes[$classesID] : $this->lang->line('balancefeesreport_all_class');
                    ?>
                </h5>                         
                <h5 class="pull-right">
                    <?php
                       echo $this->lang->line('balancefeesreport_section')." : ";
                       echo isset($sections[$sectionID]) ? $sections[$sectionID] : $this->lang->line('balancefeesreport_all_section');
                    ?>
                </h5>                        
            </div>
            <?php } 
            if(count($students)) { ?>
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th><?=$this->lang->line('balancefeesreport_name')?></th>
                                    <th><?=$this->lang->line('balancefeesreport_registerNO')?></th>
                                    <?php if($classesID == 0) { ?>
                                      <th><?=$this->lang->line('balancefeesreport_class')?></th>
                                    <?php } ?>
                                    <?php if($sectionID == 0) { ?>
                                      <th><?=$this->lang->line('balancefeesreport_section')?></th>
                                    <?php } ?>
                                    <th><?=$this->lang->line('balancefeesreport_roll')?></th>
                                    <th><?=$this->lang->line('balancefeesreport_fees_amount')?></th>
                                    <th><?=$this->lang->line('balancefeesreport_discount')?> </th>
                                    <th><?=$this->lang->line('balancefeesreport_paid')?> </th>
                                    <th><?=$this->lang->line('balancefeesreport_weaver')?> </th>
                                    <th><?=$this->lang->line('balancefeesreport_balance') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $totalAmount = 0;
                                    $totalDiscount = 0;
                                    $totalPayments = 0;
                                    $totalWeaver = 0;
                                    $totalBalance = 0;
                                    $i=0;
                                    foreach($students as $student) { 
                                        $i++;
                                        ?>
                                        <tr>
                                            <td><?=$i?></td>
                                            <td><?=$student->srname?></td>
                                            <td><?=$student->srregisterNO?></td>
                                            <?php if($classesID == 0) { ?>
                                                <td><?=isset($classes[$student->srclassesID]) ? $classes[$student->srclassesID] : ''?></td>
                                            <?php } ?>

                                            <?php if($sectionID == 0) { ?>
                                                <td><?=isset($sections[$student->srsectionID]) ? $sections[$student->srsectionID] : ''?></td>
                                            <?php } ?>
                                            <td><?=$student->srroll?></td>
                                            <td>
                                                <?=isset($totalAmountAndDiscount[$student->srstudentID]['amount']) ? number_format($totalAmountAndDiscount[$student->srstudentID]['amount'],2) : number_format(0, 2)?>
                                            </td>
                                            <td>
                                                <?=isset($totalAmountAndDiscount[$student->srstudentID]['discount']) ? number_format($totalAmountAndDiscount[$student->srstudentID]['discount'],2) : number_format(0, 2)?>
                                            </td>
                                            <td>
                                                <?=isset($totalPayment[$student->srstudentID]['payment']) ? number_format($totalPayment[$student->srstudentID]['payment'],2) : number_format(0, 2)?>
                                            </td>
                                            <td>
                                                <?=isset($totalweavar[$student->srstudentID]['weaver']) ? number_format($totalweavar[$student->srstudentID]['weaver'],2) : number_format(0, 2)?>
                                            </td>
                                            <td>
                                                <?php 
                                                    $Amount = 0;
                                                    $Discount = 0;
                                                    $Payment = 0;
                                                    $Weaver = 0;

                                                    if(isset($totalAmountAndDiscount[$student->srstudentID]['amount'])) {
                                                        $Amount = $totalAmountAndDiscount[$student->srstudentID]['amount'];
                                                        $totalAmount += $Amount;
                                                    }

                                                    if(isset($totalAmountAndDiscount[$student->srstudentID]['discount'])) {
                                                        $Discount = $totalAmountAndDiscount[$student->srstudentID]['discount'];
                                                        $totalDiscount += $Discount;
                                                    }

                                                    if(isset($totalPayment[$student->srstudentID]['payment'])) {
                                                        $Payment = $totalPayment[$student->srstudentID]['payment'];
                                                        $totalPayments += $Payment;
                                                    }

                                                    if(isset($totalweavar[$student->srstudentID]['weaver'])) {
                                                        $Weaver = $totalweavar[$student->srstudentID]['weaver'];
                                                        $totalWeaver += $Weaver;
                                                    }

                                                    $Balance = ($Amount - $Discount) - ($Payment+$Weaver);

                                                    $totalBalance += $Balance;

                                                    echo number_format($Balance,2);

                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                ?>       
                                <tr>
                                    <?php 
                                        $colspan = 4;
                                        if($classesID == 0) {
                                            $colspan = 5;
                                        }

                                        if($sectionID == 0) {
                                            $colspan = 5;
                                        }

                                        if($classesID == 0 && $sectionID == 0) {
                                            $colspan = 6;
                                        }
                                    ?>
                                    <td class="grand-total" colspan="<?=$colspan?>"><?=$this->lang->line('balancefeesreport_grand_total')?> <?=!empty($siteinfos->currency_code) ? '('.$siteinfos->currency_code.')' : ''?></td>
                                    <td class="rtext-bold"><?=number_format($totalAmount,2)?></td>
                                    <td class="rtext-bold"><?=number_format($totalDiscount,2)?></td>
                                    <td class="rtext-bold"><?=number_format($totalPayments,2)?></td>
                                    <td class="rtext-bold"><?=number_format($totalWeaver,2)?></td>
                                    <td class="rtext-bold"><?=number_format($totalBalance,2)?></td>
                                </tr>                             
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php } else { ?>
                <div class="col-sm-12">
                    <div class="notfound">
                        <p><b class="text-info"><?=$this->lang->line('report_data_not_found')?></b></p>
                    </div>
                </div>
            <?php } ?>
            <div class="col-sm-12 text-center footerAll">
                <?=reportfooter($siteinfos, $schoolyearsessionobj, true)?>
            </div>
        </div><!-- row -->
    </div><!-- Body -->
</div>

