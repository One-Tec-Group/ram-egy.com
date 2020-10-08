<?php $this->load->view("components/page_header"); ?>
<?php $this->load->view("components/page_topbar"); ?>
<?php $this->load->view("components/page_menu"); ?>

        <aside class="right-side" style="width: 100% !important;">
            <section class="content" style="width: 100% !important;">
                <div class="row" style="width: 100% !important;">
                    <div class="col-xs-12" style="width: 100% !important;">
                        <?php $this->load->view($subview); ?>
                    </div>
                </div>
            </section>
        </aside>

        <footer class="main-footer">
          	<div class="pull-right hidden-xs">
            	<b>v</b> <?=config_item('ini_version')?>
          	</div>
          	<strong>One Tec Group L.L.C.</strong>
        </footer>
<?php $this->load->view("components/page_footer"); ?>