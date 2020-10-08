<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Product extends Admin_Controller {
    /*
      | -----------------------------------------------------
      | PRODUCT NAME: 	INILABS SCHOOL MANAGEMENT SYSTEM
      | -----------------------------------------------------
      | AUTHOR:			INILABS TEAM
      | -----------------------------------------------------
      | EMAIL:			info@inilabs.net
      | -----------------------------------------------------
      | COPYRIGHT:		RESERVED BY INILABS IT
      | -----------------------------------------------------
      | WEBSITE:			http://inilabs.net
      | -----------------------------------------------------
     */

    function __construct() {
        parent::__construct();
        $this->load->model("product_m");
        $this->load->model("productcategory_m");
        $language = $this->session->userdata('lang');
        $this->lang->load('product', $language);
    }

    public function index() {
        $this->data['productcategorys'] = pluck($this->productcategory_m->get_productcategory(), 'productcategoryname', 'productcategoryID');
        $this->data['products'] = $this->product_m->get_product();
        $this->data["subview"] = "product/index";
        $this->load->view('_layout_main', $this->data);
    }

    protected function rules() {
        $rules = array(
            array(
                'field' => 'productname',
                'label' => $this->lang->line("product_product"),
                'rules' => 'trim|required|xss_clean|max_length[60]|callback_unique_productname'
            ),
            array(
                'field' => 'productsize',
                'label' => $this->lang->line("product_size"),
                'rules' => 'trim|xss_clean|max_length[10]'
            ),
            array(
                'field' => 'productcolor',
                'label' => $this->lang->line("product_color"),
                'rules' => 'trim|xss_clean|max_length[50]'
            ),
            array(
                'field' => 'productcategoryID',
                'label' => $this->lang->line("product_category"),
                'rules' => 'trim|required|xss_clean|numeric|max_length[11]|callback_unique_prodectcategory'
            ),
            array(
                'field' => 'productbuyingprice',
                'label' => $this->lang->line("product_buyingprice"),
                'rules' => 'trim|required|xss_clean|max_length[15]|numeric'
            )
            , array(
                'field' => 'productsellingprice',
                'label' => $this->lang->line("product_sellingprice"),
                'rules' => 'trim|required|xss_clean|max_length[15]|numeric'
            ),
            array(
                'field' => 'photo',
                'label' => $this->lang->line("product_photo"),
                'rules' => 'trim|max_length[200]|xss_clean|callback_photoupload'
            ),
            array(
                'field' => 'productdesc',
                'label' => $this->lang->line("product_desc"),
                'rules' => 'trim|xss_clean|max_length[250]'
            )
        );
        return $rules;
    }

    public function add() {
        $this->data['headerassets'] = array(
            'css' => array(
                'assets/select2/css/select2.css',
                'assets/select2/css/select2-bootstrap.css'
            ),
            'js' => array(
                'assets/select2/select2.js'
            )
        );

        $this->data['productcategorys'] = $this->productcategory_m->get_productcategory();
        if ($_POST) {
            $rules = $this->rules();
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == FALSE) {
                $this->data["subview"] = "product/add";
                $this->load->view('_layout_main', $this->data);
            } else {
                $newProductName = $this->input->post("productname");
                if ($this->input->post("bundleMark") == "TRUE") {
                    $newProductName .= " (";
                    $bundleProduct = $this->input->post("bundleProduct");
                    for ($i = 0; $i < count($bundleProduct); $i++) {
                        $newProductName .= $bundleProduct[$i];
                        if ($i < (count($bundleProduct) - 1)) {
                            $newProductName .= " - ";
                        }
                    }
                    $newProductName .= ")";
                }
                $array = array(
                    "productname" => $newProductName,
                    "productsize" => $this->input->post("productsize"),
                    "productcolor" => $this->input->post("productcolor"),
                    "photo" => $this->upload_data['file']['file_name'],
                    "productcategoryID" => $this->input->post("productcategoryID"),
                    "productbuyingprice" => $this->input->post("productbuyingprice"),
                    "productsellingprice" => $this->input->post("productsellingprice"),
                    "productdesc" => $this->input->post("productdesc"),
                    "create_date" => date("Y-m-d H:i:s"),
                    "modify_date" => date("Y-m-d H:i:s"),
                    "create_userID" => $this->session->userdata('loginuserID'),
                    "create_usertypeID" => $this->session->userdata('usertypeID')
                );
                $this->product_m->insert_product($array);
                $this->session->set_flashdata('success', $this->lang->line('menu_success'));
                redirect(base_url("product/index"));
            }
        } else {
            $this->data["subview"] = "product/add";
            $this->load->view('_layout_main', $this->data);
        }
    }

    public function edit() {
        $this->data['headerassets'] = array(
            'css' => array(
                'assets/select2/css/select2.css',
                'assets/select2/css/select2-bootstrap.css'
            ),
            'js' => array(
                'assets/select2/select2.js'
            )
        );

        $id = htmlentities(escapeString($this->uri->segment(3)));
        if ((int) $id) {
            $this->data['product'] = $this->product_m->get_single_product(array('productID' => $id));
            $this->data['productcategorys'] = $this->productcategory_m->get_productcategory();
            if ($this->data['product']) {
                if ($_POST) {
                    $rules = $this->rules();
                    $this->form_validation->set_rules($rules);
                    if ($this->form_validation->run() == FALSE) {
                        $this->data["subview"] = "product/edit";
                        $this->load->view('_layout_main', $this->data);
                    } else {
                        $array = array(
                            "productname" => $this->input->post("productname"),
                            "productsize" => $this->input->post("productsize"),
                            "productcolor" => $this->input->post("productcolor"),
                            "photo" => $this->upload_data['file']['file_name'],
                            "productcategoryID" => $this->input->post("productcategoryID"),
                            "productbuyingprice" => $this->input->post("productbuyingprice"),
                            "productsellingprice" => $this->input->post("productsellingprice"),
                            "productdesc" => $this->input->post("productdesc"),
                            "modify_date" => date("Y-m-d H:i:s"),
                        );

                        $this->product_m->update_product($array, $id);
                        $this->session->set_flashdata('success', $this->lang->line('menu_success'));
                        redirect(base_url("product/index"));
                    }
                } else {
                    $this->data["subview"] = "product/edit";
                    $this->load->view('_layout_main', $this->data);
                }
            } else {
                $this->data["subview"] = "error";
                $this->load->view('_layout_main', $this->data);
            }
        } else {
            $this->data["subview"] = "error";
            $this->load->view('_layout_main', $this->data);
        }
    }

    public function photoupload() {
        $id = htmlentities(escapeString($this->uri->segment(3)));
        $product = array();
        if ((int) $id) {
            $product = $this->product_m->get_single_product(array('productID' => $id));
        }

        $new_file = "default.png";
        if ($_FILES["photo"]['name'] != "") {
            $file_name = $_FILES["photo"]['name'];
            $random = random19();
            $makeRandom = hash('sha512', $random . $this->input->post('productname') . config_item("encryption_key"));
            $file_name_rename = $makeRandom;
            $explode = explode('.', $file_name);
            if (count($explode) >= 2) {
                $new_file = $file_name_rename . '.' . end($explode);
                $config['upload_path'] = "./uploads/images";
                $config['allowed_types'] = "gif|jpg|png";
                $config['file_name'] = $new_file;
                $config['max_size'] = '1024';
                $config['max_width'] = '3000';
                $config['max_height'] = '3000';
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload("photo")) {
                    $this->form_validation->set_message("photoupload", $this->upload->display_errors());
                    return FALSE;
                } else {
                    $this->upload_data['file'] = $this->upload->data();
                    return TRUE;
                }
            } else {
                $this->form_validation->set_message("photoupload", "Invalid file");
                return FALSE;
            }
        } else {
            if (count($product)) {
                $this->upload_data['file'] = array('file_name' => $product->photo);
                return TRUE;
            } else {
                $this->upload_data['file'] = array('file_name' => $new_file);
                return TRUE;
            }
        }
    }

    public function delete() {
        $id = htmlentities(escapeString($this->uri->segment(3)));
        if ((int) $id) {
            $this->data['product'] = $this->product_m->get_single_product(array('productID' => $id));
            if ($this->data['product']) {
                $this->product_m->delete_product($id);
                $this->session->set_flashdata('success', $this->lang->line('menu_success'));
                redirect(base_url("product/index"));
            } else {
                redirect(base_url("product/index"));
            }
        } else {
            redirect(base_url("product/index"));
        }
    }

    public function unique_productname() {
        $id = htmlentities(escapeString($this->uri->segment(3)));
        if ((int) $id) {
            $product = $this->product_m->get_order_by_product(array("productname" => $this->input->post("productname"), "productID !=" => $id));
            if (count($product)) {
                $this->form_validation->set_message("unique_productname", "The %s is already exists.");
                return FALSE;
            }
            return TRUE;
        } else {
            $product = $this->product_m->get_order_by_product(array("productname" => $this->input->post("productname")));
            if (count($product)) {
                $this->form_validation->set_message("unique_productname", "The %s is already exists.");
                return FALSE;
            }
            return TRUE;
        }
    }

    public function unique_prodectcategory() {
        if ($this->input->post("productcategoryID") == 0) {
            $this->form_validation->set_message("unique_prodectcategory", "The %s field is required");
            return FALSE;
        }
        return TRUE;
    }

    public function getProductForBundle() {
        if ($this->input->post() && $this->input->post("bundle") == "TRUE") {
            $products = $this->product_m->get_product();
            echo '<label for="photo" class="col-sm-2 control-label">' . $this->lang->line("product_bundle_product") . '</label>
                    <div class="row">
                    <div class="col-sm-6" style="display:-webkit-inline-box;padding-top:10px;">';
            foreach ($products as $product) {
                echo '<input type="checkbox" class="form-control" value="' . $product->productname . '" name="bundleProduct[]" style="width: 15px;margin-top:-10px;"> <b style="margin: 10px;">' . $product->productname . '</b>';
            }
            echo '</div></div><span class="col-sm-4"></span>';
        }
    }

}
