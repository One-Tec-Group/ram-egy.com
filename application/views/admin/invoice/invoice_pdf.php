<!DOCTYPE html>
<html lang="en">
<head>
    <!-- <meta charset="utf-8"> -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title><?= lang('invoice') ?></title>
    <?php   header('Content-type: text/plain; charset=utf-8');
    $direction = $this->session->userdata('direction');
    if (!empty($direction) && $direction == 'rtl') {
        $RTL = 'on';
    } else {
        $RTL = config_item('RTL');
    }
    ?>
    <style type="text/css">

      @page {
             margin: 25px 20px 20px 20px;
        }

      * {
           /* font-family: DejaVu Sans, sans-serif;  */
           font-family: "Arial";
        }
     @font-face {
           font-family: "Arial";
/* font-family: DejaVu Sans, sans-serif; */
        }

        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }

        a {
            color: #0087C3;
            text-decoration: none;
        }

        body {
            color: #555555;
            background: #ffffff;
            font-size: 10px;
             font-family: "Arial";
             /* font-family: DejaVu Sans, sans-serif; */
            width: 100%;
            /* margin-top: 5px;
            margin-left: 50px;
            margin-right: 50px;
            margin-bottom: 0px; */

        <?php if(!empty($RTL)){?> text-align: right;
        <?php }?>
        }

        header {
            padding: 1px 0;
            margin-bottom: 2px;
            border-bottom: 1px solid #aaaaaa;
        <?php if(!empty($RTL)){?> text-align: right;
        <?php }?>
        }

        #logo {
        <?php if(!empty($RTL)){?> text-align: right;
        <?php }?>
        }

        #company {
        <?php if(!empty($RTL)){?> text-align: left;
        <?php }else{?> text-align: right;
        <?php }?>
        }

        #details {
            margin-bottom: 2px;
        <?php if(!empty($RTL)){?> text-align: right;
        <?php }?>
        }

        #client {
            padding-left: 5px;
            border-left: 6px solid #0087C3;
            background-color: red;
        <?php if(!empty($RTL)){?> text-align: right;
        <?php }?>
        }

        #client .to {
            color: #777777;
            background-color: red;
        }

        h2.name {
            font-size: 14px;
            font-weight: normal;
            margin: 0;
        <?php if(!empty($RTL)){?> text-align: right;
        <?php }?>
        }

        #invoice {
        <?php if(!empty($RTL)){?> text-align: left;
        <?php }else{?> text-align: right;
        <?php }?>
        }

        #invoice h1 {
            color: #0087C3;
            font-size: 1.5em;
            line-height: 1em;
            font-weight: normal;
        <?php if(!empty($RTL)){?> text-align: right;
        <?php }?>
        }

        #invoice .date {
            font-size: 1.1em;
            color: #777777;
        <?php if(!empty($RTL)){?> text-align: right;
        <?php }?>
        }

        table {
            width: 100%;
            border-spacing: 2px;
        <?php if(!empty($RTL)){?> text-align: right;
        <?php }?>
        }

        table.items {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 2px;
            margin-bottom: 50px;
        <?php if(!empty($RTL)){?> text-align: right;
        <?php }?>
        }

        table.items th,
        table.items td {
            padding: 2px;
             border-bottom: 1px solid #FFFFFF;
        <?php if(!empty($RTL)){?> text-align: right;
        <?php }else{?> text-align: left;
        <?php }?>

        }

        table.items th {
            white-space: nowrap;
            font-weight: normal;
        <?php if(!empty($RTL)){?> text-align: right;
        <?php }?>
        }

        table.items td {
        <?php if(!empty($RTL)){?> text-align: right;
        <?php }else{?> text-align: left;
        <?php }?>
        }

        table.items td h3 {
            color: #57B223 !important;
            font-size: 12px;
            font-weight: normal;
            margin-top: 3px;
            margin-bottom: 3px;
        <?php if(!empty($RTL)){?> text-align: right;
        <?php }?>
        }

        table.items .no {
            background: #dddddd;
        }

        table.items .desc {
        <?php if(!empty($RTL)){?> text-align: right;
        <?php }else{?> text-align: left;
        <?php }?>
        }

        table.items .unit {
            background: #F3F3F3;
        }

        table.items .qty {
        }

        table.items td.unit,
        table.items td.qty,
        table.items td.total {
            font-size: 12px;
         }

        table.items tbody tr:last-child td {
            border: none;

        }

        table.items tfoot td {
            padding: 4px 4px;
            background: #FFFFFF;
            border-bottom: none;
            font-size: 1.2em;
            white-space: nowrap;
            border-top: 1px solid #AAAAAA;
        <?php if(!empty($RTL)){?> text-align: right;
        <?php }?>
        }

        table.items tfoot tr:first-child td {
            border-top: none;
        }

        table.items tfoot tr:last-child td {
            color: #57B223;
            font-size: 12px;
            border-top: 1px solid #57B223;

        }

        table.items tfoot tr td:first-child {
            border: none;
        <?php if(!empty($RTL)){?> text-align: left;
        <?php }else{?> text-align: right;
        <?php }?>
        }
/*
        #thanks {
            font-size: 12px;
            margin-bottom: 5px;
        }

        #notices {
            padding-left: 6px;
            border-left: 6px solid #0087C3;

        }

        #notices .notice {
            font-size: 1em;
            color: #777;
        }
*/
        footer {
            top: 75%;
            color: #777777;
            width: 100%;
            height: 430px;
            position: fixed;
            bottom: 0 !important;
            border-top: 1px solid #aaaaaa;
            padding: 3px 0;


        }

        tr.total td, tr th.total, tr td.total {
        <?php if(!empty($RTL)){?> text-align: left;
        <?php }else{?> text-align: right;
        <?php }?>
        }

        .bg-items {
            background: #515151 !important;
            color: #FFFFFF
        }

        .p-md {
            padding: 15px !important;
        }

    </style>
</head>
<body>

<?php
$paid_amount = $this->invoice_model->calculate_to('paid_amount', $invoice_info->invoices_id);
$client_info = $this->invoice_model->check_by(array('client_id' => $invoice_info->client_id), 'tbl_client');
if (!empty($client_info)) {
    $currency = $this->invoice_model->client_currency_sambol($invoice_info->client_id);
    $client_lang = $client_info->language;
} else {
    $client_lang = 'english';
    $currency = $this->invoice_model->check_by(array('code' => config_item('default_currency')), 'tbl_currencies');
}

unset($this->lang->is_loaded[5]);
$language_info = $this->lang->load('sales_lang', $client_lang, TRUE, FALSE, '', TRUE);
$payment_status = $this->invoice_model->get_payment_status($invoice_info->invoices_id);

$uri = $this->uri->segment(3);
if ($uri == 'invoice_email') {
    $img = base_url() . config_item('invoice_logo');
} else {
    $img = ROOTPATH . '/' . config_item('invoice_logo');
    $a = file_exists($img);
    if (empty($a)) {
        $img = base_url() . config_item('invoice_logo');
    }
    if (!file_exists($img)) {
        $img = ROOTPATH . '/' . 'uploads/default_logo.png';
    }
}

?>
<table class="clearfix">
    <tr>
        <td style="width: 50%;">
            <div id="logo" class="left">
                <img style="width: 233px;height: 120px;float: left !important;" src="<?= $img ?>">
            </div>
        </td>
        <td style="width: 50%;">
            <div class="right" style="">
                <h2 style="margin-bottom: 0"><?= $language_info['invoice'] ?>: <span
                            style="text-align: right"><?= $invoice_info->reference_no ?></span></h2>
                <div class="date"><?= $language_info['invoice_date'] ?>
                    : <span
                            style="text-align: right"><?= strftime(config_item('date_format'), strtotime($invoice_info->invoice_date)); ?></span>
                </div>
                <div class="date"><?= $language_info['due_date'] ?>
                    : <span
                            style="text-align: right"><?= strftime(config_item('date_format'), strtotime($invoice_info->due_date)); ?></span>
                </div>
                <?php if (!empty($invoice_info->user_id)) { ?>
                    <div class="date">
                        <?= lang('sales') . ' ' . lang('agent') ?>: <span style="text-align: right"><?php
                            $profile_info = $this->db->where('user_id', $invoice_info->user_id)->get('tbl_account_details')->row();
                            if (!empty($profile_info)) {
                                echo $profile_info->fullname;
                            }
                            ?></span>
                    </div>
                <?php } ?>
                <div class="date"><?= $language_info['payment_status'] ?>: <span
                            style="text-align: right"> <?= $payment_status ?></span></div>
            </div>

        </td>
    </tr>
</table>

<table id="details" class="clearfix">
  <tr>
      <td style="width: 50%;overflow: hidden; padding:12px; background:#515151;margin-top:20px; ">
          <h4 class="p-md bg-items ">
              <?= lang('our_info') ?>
          </h4>
      </td>
      <td style="width: 50%; padding:12px; background:#515151; ">
          <h4 class="p-md bg-items ">
              <?= lang('customer') ?>
          </h4>
      </td>
  </tr>
    <tr style="margin-top: 0px">
        <td style="width: 50%;overflow: hidden">
            <div style="padding-left: 5px">
                <h3 style="margin: 0px"><?= (config_item('company_legal_name_' . $client_lang) ? config_item('company_legal_name_' . $client_lang) : config_item('company_legal_name')) ?></h3>
                <div><?= (config_item('company_address_' . $client_lang) ? config_item('company_address_' . $client_lang) : config_item('company_address')) ?></div>
                <div><?= (config_item('company_city_' . $client_lang) ? config_item('company_city_' . $client_lang) : config_item('company_city')) ?>
                    , <?= config_item('company_zip_code') ?></div>
                <div><?= (config_item('company_country_' . $client_lang) ? config_item('company_country_' . $client_lang) : config_item('company_country')) ?></div>
                <div> <?= config_item('company_phone') ?></div>
                <div><a href="mailto:<?= config_item('company_email') ?>"><?= config_item('company_email') ?></a></div>
                <div><?= config_item('company_vat') ?></div>
            </div>
        </td>
        <td style="width: 50%">
            <div style="padding-left: 5px">
                <?php
                if (!empty($client_info)) {
                    $client_name = $client_info->name;
                    $address = $client_info->address;
                    $city = $client_info->city;
                    $zipcode = $client_info->zipcode;
                    $country = $client_info->country;
                    $phone = $client_info->phone;
                    $email = $client_info->email;
                } else {
                    $client_name = '-';
                    $address = '-';
                    $city = '-';
                    $zipcode = '-';
                    $country = '-';
                    $phone = '-';
                    $email = '-';
                }
                ?>
                <h3 style="margin: 0px"><?= $client_name ?></h3>
                <div class="address"><?= $address ?></div>
                <div class="address"><?= $city ?>, <?= $zipcode ?>
                    ,<?= $country ?></div>
                <div class="address"><?= $phone ?></div>
                <div class="email"><a href="mailto:<?= $email ?>"><?= $email ?></a></div>
                <?php if (!empty($client_info->vat)) { ?>
                    <div class="email"><?= lang('vat_number') ?>: <?= $client_info->vat ?></div>
                <?php } ?>
            </div>
        </td>
    </tr>
</table>

<table class="items">
    <thead class="p-md bg-items">
    <tr>
        <th style="padding:8px; background:#515151;color: #ffffff;"><?= $language_info['description'] ?></th>
        <?php
        $colspan = 3;
        $invoice_view = config_item('invoice_view');
        if (!empty($invoice_view) && $invoice_view == '2') {
            $colspan = 4;
            ?>
            <th style="padding:8px; background:#515151;color: #ffffff;"><?= lang('hsn_code') ?></th>
        <?php } ?>
        <th style="text-align: right;padding:8px; background:#515151;color: #ffffff;"><?= $language_info['price'] ?></th>
        <th style="text-align: right;padding:8px; background:#515151;color: #ffffff;"><?= $language_info['qty'] ?></th>
        <th style="text-align: right;padding:8px; background:#515151;color: #ffffff;"><?= $language_info['tax'] ?></th>
        <th style="text-align: right;padding:8px; background:#515151;color: #ffffff;"><?= $language_info['total'] ?></th>
    </tr>
    </thead>
    <tbody>
    <?php
    $invoice_items = $this->invoice_model->ordered_items_by_id($invoice_info->invoices_id);

    if (!empty($invoice_items)) :
        foreach ($invoice_items as $key => $v_item) :
            $item_name = $v_item->item_name ? $v_item->item_name : $v_item->item_desc;
            $item_tax_name = json_decode($v_item->item_tax_name);
            ?>
            <tr>
                <td class="unit"><h3><?= $item_name ?></h3><?= nl2br($v_item->item_desc) ?></td>
                <?php
                $invoice_view = config_item('invoice_view');
                if (!empty($invoice_view) && $invoice_view == '2') {
                    ?>
                    <td><?= $v_item->hsn_code ?></td>
                <?php } ?>
                <td class="unit" style="text-align: right"><?= display_money($v_item->unit_cost) ?></td>
                <td class="unit" style="text-align: right"><?= $v_item->quantity . '   ' . $v_item->unit ?></td>
                <td class="unit" style="text-align: right"><?php
                    if (!empty($item_tax_name)) {
                        foreach ($item_tax_name as $v_tax_name) {
                            $i_tax_name = explode('|', $v_tax_name);
                            echo '<small class="pr-sm">' . $i_tax_name[0] . ' (' . $i_tax_name[1] . ' %)' . '</small>' . display_money($v_item->total_cost / 100 * $i_tax_name[1]) . ' <br>';
                        }
                    }
                    ?></td>
                <td class="unit" style="text-align: right"><?= display_money($v_item->total_cost) ?></td>
            </tr>
        <?php endforeach; ?>
    <?php endif ?>

    </tbody>
    <tfoot>
    <tr class="total">
        <td colspan="<?= $colspan ?>"></td>
        <td colspan="1"><?= $language_info['sub_total'] ?></td>
        <td><?= display_money($this->invoice_model->calculate_to('invoice_cost', $invoice_info->invoices_id)) ?></td>
    </tr>
    <?php if ($invoice_info->discount_total > 0): ?>
        <tr class="total">
            <td colspan="<?= $colspan ?>"></td>
            <td colspan="1"><?= $language_info['discount'] ?>(<?php echo $invoice_info->discount_percent; ?>%)</td>
            <td> <?= display_money($this->invoice_model->calculate_to('discount', $invoice_info->invoices_id)) ?></td>
        </tr>
    <?php endif;
    $tax_info = json_decode($invoice_info->total_tax);
    $tax_total = 0;
    if (!empty($tax_info)) {
        $tax_name = $tax_info->tax_name;
        $total_tax = $tax_info->total_tax;
        if (!empty($tax_name)) {
            foreach ($tax_name as $t_key => $v_tax_info) {
                $tax = explode('|', $v_tax_info);
                $tax_total += $total_tax[$t_key];
                ?>
                <tr class="total">
                    <td colspan="<?= $colspan ?>"></td>
                    <td colspan="1"><?= $tax[0] . ' (' . $tax[1] . ' %)' ?></td>
                    <td> <?= display_money($total_tax[$t_key]); ?></td>
                </tr>
            <?php }
        }
    } ?>
    <?php if ($tax_total > 0): ?>
        <tr class="total">
            <td colspan="<?= $colspan ?>"></td>
            <td colspan="1"><?= $language_info['total'] . ' ' . $language_info['tax'] ?></td>
            <td><?= display_money($tax_total); ?></td>
        </tr>
    <?php endif;
    if ($invoice_info->adjustment > 0): ?>
        <tr class="total">
            <td colspan="<?= $colspan ?>"></td>
            <td colspan="1"><?= $language_info['adjustment'] ?></td>
            <td><?= display_money($invoice_info->adjustment); ?></td>
        </tr>
    <?php endif ?>
    <tr class="total">
        <td colspan="<?= $colspan ?>"></td>
        <td colspan="1"><?= $language_info['total'] ?></td>
        <td><?= display_money($this->invoice_model->calculate_to('total', $invoice_info->invoices_id), $currency->symbol); ?></td>
    </tr>
    <?php
    $paid_amount = $this->invoice_model->calculate_to('paid_amount', $invoice_info->invoices_id);
    $invoice_due = $this->invoice_model->calculate_to('invoice_due', $invoice_info->invoices_id);
    if ($paid_amount > 0) {
        $total = $language_info['total_due'];
        if ($paid_amount > 0) {
            $text = 'style="color:red"';
            ?>
            <tr class="total">
                <td colspan="<?= $colspan ?>"></td>
                <td colspan="1"><?= $language_info['paid_amount'] ?></td>
                <td><?= $paid_amount ?></td>
            </tr>
        <?php } else {
            $text = '';
        } ?>
        <tr class="total">
            <td colspan="<?= $colspan ?>"></td>
            <td colspan="1"><span <?= $text ?>><?= $total ?></span></td>
            <td><?= display_money($invoice_due, $currency->symbol); ?></td>
        </tr>
    <?php } ?>
    </tfoot>
</table>
<?php if (config_item('amount_to_words') == 'Yes') { ?>
    <div class="clearfix">
        <p class="right h4"><strong class="h3"><?= lang('num_word') ?>
                : </strong> <?= number_to_word($invoice_info->client_id, $invoice_due); ?></p>
    </div>
<?php } ?>
<!-- <div id="thanks"><?//= lang('thanks') ?>!</div>
<div id="notices">
    <div class="notice"><?//= strip_html_tags($invoice_info->notes, true) ?></div>
</div> -->
<?php
$invoice_view = config_item('invoice_view');
if (!empty($invoice_view) && $invoice_view > 0) {
    ?>
    <style type="text/css">
        .panel {
            margin-bottom: 21px;
            background-color: #ffffff;
            border: 1px solid transparent;
            -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
        }

        .panel-custom .panel-heading {
            border-bottom: 2px solid #2b957a;
        }

        .panel .panel-heading {
            border-bottom: 0;
            font-size: 14px;
        }

        .panel-heading {
            padding: 10px 15px;
            border-bottom: 1px solid transparent;
            border-top-right-radius: 3px;
            border-top-left-radius: 3px;
        }

        .panel-title {
            margin-top: 0;
            margin-bottom: 0;
            font-size: 16px;
        }
    </style>
    <div class="panel panel-custom" style="margin-top: 20px">
        <div class="panel-heading" style="border:1px solid #dde6e9;border-bottom: 2px solid #57B223;">
            <div class="panel-title"><?= lang('tax_summary') ?></div>
        </div>
        <table class="items" border="0" cellspacing="0" cellpadding="0">
            <thead>
            <tr>
                <th class="desc"><?= $language_info['items'] ?></th>
                <?php
                $invoice_view = config_item('invoice_view');
                if (!empty($invoice_view) && $invoice_view == '2') {
                    ?>
                    <th><?= lang('hsn_code') ?></th>
                <?php } ?>
                <th class="unit"><?= $language_info['qty'] ?></th>
                <th class="desc"><?= $language_info['tax'] ?></th>
                <th class="unit" style="text-align: right"><?= $language_info['total_tax'] ?></th>
                <th class="total" style="text-align: right"><?= $language_info['tax_excl_amt'] ?></th>
            </tr>
            </thead>
            <tbody>
            <?php
            $total_tax = 0;
            $total_cost = 0;
            if (!empty($invoice_items)) :
                foreach ($invoice_items as $key => $v_item) :
                    $item_tax_name = json_decode($v_item->item_tax_name);
                    $tax_amount = 0;
                    ?>
                    <tr>
                        <td class="desc"><?= $v_item->item_name ?></td>
                        <?php
                        $invoice_view = config_item('invoice_view');
                        if (!empty($invoice_view) && $invoice_view == '2') {
                            ?>
                            <td><?= $v_item->hsn_code ?></td>
                        <?php } ?>
                        <td class="unit"><?= $v_item->quantity . '   ' . $v_item->unit ?></td>
                        <td class="desc"><?php
                            if (!empty($item_tax_name)) {
                                foreach ($item_tax_name as $v_tax_name) {
                                    $i_tax_name = explode('|', $v_tax_name);
                                    $tax_amount += $v_item->total_cost / 100 * $i_tax_name[1];
                                    echo '<small class="pr-sm">' . $i_tax_name[0] . ' (' . $i_tax_name[1] . ' %)' . '</small>' . display_money($v_item->total_cost / 100 * $i_tax_name[1]) . ' <br>';
                                }
                            }
                            $total_cost += $v_item->total_cost;
                            $total_tax += $tax_amount;
                            ?></td>
                        <td class="unit" style="text-align: right"><?= display_money($tax_amount) ?></td>
                        <td class="total" style="text-align: right"><?= display_money($v_item->total_cost) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif ?>

            </tbody>
            <tfoot>
            <tr class="total">
                <td colspan="<?= $colspan ?>"></td>
                <td><?= $language_info['total'] ?></td>
                <td><?= display_money($total_tax) ?></td>
                <td><?= display_money($total_cost) ?></td>
            </tr>
            </tfoot>
        </table>
    </div>
<?php } ?>
<?php $all_payment_info = $this->db->where('invoices_id', $invoice_info->invoices_id)->get('tbl_payments')->result();
if (!empty($all_payment_info)) { ?>

    <div style="margin-top:20px">
        <div style="width:100%">
            <div style="width:50%;float:left"><h4><?= lang('payment') . ' ' . lang('details') ?></h4></div>
            <div style="clear:both;"></div>
        </div>

        <table style="width:100%;margin-bottom:35px;table-layout:fixed;" cellpadding="0"
               cellspacing="0" border="0">
            <thead>
            <tr style="height:40px;background:#f5f5f5">
                <td style="padding:5px 10px 5px 10px;word-wrap: break-word;">
                    <?= lang('transaction_id') ?>
                </td>
                <td style="padding:5px 10px 5px 5px;word-wrap: break-word;"
                    align="right">
                    <?= lang('payment_date') ?>
                </td>
                <td style="padding:5px 10px 5px 5px;word-wrap: break-word;"
                    align="right">
                    <?= lang('amount') ?>
                </td>
                <td style="padding:5px 10px 5px 5px;word-wrap: break-word;"
                    align="right">
                    <?= lang('payment_mode') ?>
                </td>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($all_payment_info as $v_payments_info) {
                $payment_methods = $this->invoice_model->check_by(array('payment_methods_id' => $v_payments_info->payment_method), 'tbl_payment_methods');
                ?>
                <tr style="border-bottom:1px solid #ededed">
                    <td style="padding: 10px 0px 10px 10px;"
                        valign="top"><?= $v_payments_info->trans_id; ?>
                    </td>
                    <td style="padding: 10px 10px 5px 10px;text-align:right;word-wrap: break-word;"
                        valign="top">
                        <?= strftime(config_item('date_format'), strtotime($v_payments_info->payment_date)); ?>
                    </td>
                    <td style="padding: 10px 10px 5px 10px;text-align:right;word-wrap: break-word;"
                        valign="top"><?= display_money($v_payments_info->amount, $currency->symbol) ?>
                    </td>
                    <td style="text-align:right;padding: 10px 10px 10px 5px;word-wrap: break-word;"
                        valign="top">
                        <?= !empty($payment_methods->method_name) ? $payment_methods->method_name : '-'; ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
<?php } ?>
<footer>

        <table class="items" border="0" cellpadding="0" cellspacing="0"  style="font-size:14px; text-align: left;width:100%">
             <tbody>

              <tr>
                <td><span>TAX Registration Number : </span></td>
                <td><span >728-153-386</span></td>
                <td style="text-align:right;float:right"><span >728-153-386</span></td>
                <td style="text-align:right;float:right"><span > : رقم السجل الضريبي</span></td>
             </tr>

             <tr >
              <td ><span >Trade License  Number : </span></td>
              <td ><span >127595</span></td>
              <td style="text-align:right;float:right"><span >127595</span></td>
              <td style="text-align:right;float:right"><span > : رقم السجل التجاري</span></td>
             </tr>

             <tr  >
              <td  ><span >Address : </span></td>
               <td colspan="0" ><span >2 El-Obour Buildings, Salah Salem Heliopolis</span></td>
               <td style="text-align:right;float:right; direction:rtl;"><span>2عمارات العبور مصر الجديده صلاح سالم القاهره</span></td>
               <td style="text-align:right;float:right"><span > : العنوان</span></td>

             </tr>

          <!--   <tr style="background-color:#b5b5b5;">
               <td colspan="3"><span ><b>PAYMENT DETAILS:</b></span></td>
               <td style="text-align:right;float:right"><span ><b>:بيانات الدفع</b></span></td>
             </tr>

             <tr >
              <td ><span >Cheques are payable  to:</span></td>
              <td ><span >One Tec Group</span></td>
              <td style="text-align:right;float:right"><span >ون تك جروب </span></td>
              <td style="text-align:right;float:right"><span >:تصدر الشيكات بإسم  </span></td>
             </tr>

             <tr style="background-color:#b5b5b5;">
               <td colspan="3"><span><b>Bank Transfer:</b></span></td>
               <td style="text-align:right;float:right"><span><b>:التحويل البنكى</b></span></td>
             </tr>

           <tr >
              <td  ><span >ACCOUNT NAME :</span></td>
              <td ><span >One Tec Group</span></td>
              <td style="text-align:right;float:right"><span>ون تك جروب </span></td>
              <td style="text-align:right;float:right"><span>:اسم الحساب </span></td>
             </tr>

             <tr>
              <td  ><span >A/C # (EGP):</span></td>
              <td ><span >760077-3931-EGP-001</span></td>
              <td style="text-align:right;float:right"><span >760077-3931-EGP-001</span></td>
              <td style="text-align:right;float:right"><span >:رقم الحساب </span></td>
             </tr>

             <tr >
              <td ><span >BANK NAME :</span></td>
               <td><span >Arab African  International Bank</span></td>
               <td style="text-align:right;float:right"><span >البنك العربى الأفريقى الدولى</span></td>
               <td style="text-align:right;float:right"><span >:اسم البنك</span></td>
             </tr>

             <tr>
              <td ><span >SWIFT CODE:</span></td>
              <td ><span >ARAIEGCXXX</span></td>
              <td style="text-align:right;float:right"><span >ARAIEGCXXX</span></td>
              <td style="text-align:right;float:right"><span >:سويفت كود</span></td>
             </tr>

             <tr >
              <td colspan="4" ><span >ADDRESS: 13 Khaled Ebn El Waleed St. - Sheraton  Buildings, Heliopolis, Cairo, Egypt</span></td>
            </tr>-->

              <tr  >
              <td colspan="4"  ><span >If you have any inquiry concerning this invoice, please  send an email to: <font class="font5">amr@ram-egy.com</font></span></td>
             </tr>

             <tr>
              <td colspan="2" style="margin-top:80px !important;"><span >RECEIVED BY:</span></td>
              <td style="margin-top:20px !important;"><span >SIGNATURE:</span></td>
             </tr>

             <tr >
              <td colspan="2"  style="margin-top:80px !important;"><span >DATE:</span></td>
              <td style="margin-top:20px !important;"><span >STAMP:</span></td>
              </tr>

             <tr >
              <td colspan="4" style="margin-top:20px !important;text-align:center;background-color:#273995;color:#fff;"><span >THANK YOU FOR YOUR SUPPORT</span></td>
             </tr>

            </tbody>
            </table>



</footer>
</body>
</html>
