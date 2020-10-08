<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('product_model');
        $this->load->model('pieces_model');
        $this->load->model('category_model');
        $this->load->model('log_model');
        $this->load->library('zend');
        $this->zend->load('Zend/Barcode');
        $this->load->model('sales_model');
        $this->load->model('ion_auth_model');
        $this->load->model('warehouse_model');
        $this->load->model('biller_model');

        if (!$this->session->userdata('loggedin')) {
            redirect('auth/login');
        }
    }

    public function index() {
        $data['user'] = $this->ion_auth_model->user()->row();
        $data['user_group'] = $this->ion_auth_model->get_users_groups($data['user']->id)->result();
        if ($data['user_group'][0]->name == "sales_person" || $data['user_group'][0]->name == "purchaser") {
            $data['data'] = $this->product_model->getProductsWarehouseWise($data['user']->id);
        } else {
            $data['data'] = $this->product_model->getProducts();
        }
        $data['no_of_warehouse'] = sizeof($this->warehouse_model->getWarehouseCount());
        $data['no_of_category'] = sizeof($this->category_model->getCategoryCount());
        $this->load->view('product/list', $data);
    }

    public function add() {
        $data['category'] = $this->product_model->getCategory();
        $data['brand'] = $this->product_model->getBrand();
        $data['uqc'] = $this->product_model->getUqc();
        $data['pieces'] = $this->pieces_model->getPieces();
        $this->load->view('product/add', $data);
    }

    public function getSubcategory($id) {
        $data = $this->product_model->selectSubcategory($id);
        echo json_encode($data);
    }

    public function addProduct() {
        $this->load->helper('security');
        $this->form_validation->set_rules('code', 'Code', 'trim|required|xss_clean');
        $this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[3]|xss_clean');
        $this->form_validation->set_rules('category', 'Category', 'trim|required|numeric|xss_clean');
        $this->form_validation->set_rules('cost', 'Cost', 'trim|required|numeric|xss_clean');
        $this->form_validation->set_rules('price', 'Price', 'trim|required|numeric|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            $this->add();
        } else {
            if ($_FILES["image"]["name"]) {
                $type = explode('.', $_FILES["image"]["name"]);
                $type = $type[count($type) - 1];
                $url = "assets/images/product/" . uniqid(rand()) . '.' . $type;
                if (in_array($type, array("jpg", "jpeg", "gif", "png"))) {
                    if (is_uploaded_file($_FILES["image"]["tmp_name"])) {
                        move_uploaded_file($_FILES["image"]["tmp_name"], $url);
                    }
                }
            } else {
                $url = "assets/images/product/no_image.jpg";
            }

            $data = array(
                "code" => $this->input->post('code'),
                "name" => $this->input->post('name'),
                "barcode" => $this->barcode($this->input->post('code')),
                "category_id" => $this->input->post('category'),
                "subcategory_id" => $this->input->post('subcategory'),
                "brand_id" => $this->input->post('brand'),
                "unit" => $this->input->post('unit'),
                "size" => $this->input->post('size'),
                "cost" => $this->input->post('cost'),
                "price" => $this->input->post('price'),
                "alert_quantity" => $this->input->post('alert_quantity'),
                "image" => base_url() . '' . $url,
                "date" => date('Y-m-d'),
                "details" => $this->input->post('note')
            );

            $pieces = "{";
            for($i = 1; $i <= $this->input->post("piecesTotal"); $i++){
                $pieces .= (($i > 1) ? "," : "") . "{" . $this->input->post("pieces_$i") . ":" . $this->input->post("pieces_count_$i") . "}";
            }
            $pieces .= "}";

            $data['p_pieces'] = $pieces;

            if ($id = $this->product_model->addModel($data)) {
                $log_data = array(
                    'user_id' => $this->session->userdata('user_id'),
                    'table_id' => $id,
                    'message' => 'Product Inserted'
                );
                $this->log_model->insert_log($log_data);
                redirect('product', 'refresh');
            } else {
                $this->session->set_flashdata('fail', 'Product can not be Inserted.');
                redirect("product", 'refresh');
            }
        }
    }

    public function edit($id) {
        $data['data'] = $this->product_model->getRecord($id);
        if ($data['data'] == null) {
            $this->session->set_flashdata('fail', 'Product is not available. It might be deleted or removed.');
            redirect("product/index", 'refresh');
        }
        $data['category'] = $this->product_model->getCategory();
        $data['subcategory'] = $this->product_model->getSubcategory($id);
        $data['pieces'] = $this->pieces_model->getPieces();
        $data['brand'] = $this->product_model->getBrand();
        $data['uqc'] = $this->product_model->getUqc();
        $this->load->view('product/edit', $data);
    }

    public function editProduct() {
        $id = $this->input->post('id');
        $this->form_validation->set_rules('code', 'Code', 'trim|required');
        $this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[3]');
        $this->form_validation->set_rules('category', 'Category', 'trim|required|numeric');
        $this->form_validation->set_rules('cost', 'Cost', 'trim|required|numeric');
        $this->form_validation->set_rules('price', 'Price', 'trim|required|numeric');
        if ($this->form_validation->run() == FALSE) {
            $this->edit($id);
        } else {
            if ($_FILES["image"]["name"] == null) {
                $url = $this->input->post('hidden_image');
            } else {
                $type = explode('.', $_FILES["image"]["name"]);
                $type = $type[count($type) - 1];
                $url = "./assets/images/product/" . uniqid(rand()) . '.' . $type;
                if (in_array($type, array("jpg", "jpeg", "gif", "png"))) {
                    if (is_uploaded_file($_FILES["image"]["tmp_name"])) {
                        if (move_uploaded_file($_FILES["image"]["tmp_name"], $url)) {
                            $url = base_url() . '' . $url;
                        }
                    }
                }
            }

            $data = array(
                "code" => $this->input->post('code'),
                "name" => $this->input->post('name'),
                "category_id" => $this->input->post('category'),
                "subcategory_id" => $this->input->post('subcategory'),
                "brand_id" => $this->input->post('brand'),
                "unit" => $this->input->post('unit'),
                "size" => $this->input->post('size'),
                "cost" => $this->input->post('cost'),
                "price" => $this->input->post('price'),
                "alert_quantity" => $this->input->post('alert_quantity'),
                "image" => $url,
                "date" => date('Y-m-d'),
                "details" => $this->input->post('note')
            );

            $pieces = "{";
            for($i = 1; $i <= $this->input->post("piecesTotal"); $i++){
                $pieces .= (($i > 1) ? "," : "") . "{" . $this->input->post("pieces_$i") . ":" . $this->input->post("pieces_count_$i") . "}";
            }
            $pieces .= "}";

            $data['p_pieces'] = $pieces;


            if ($this->product_model->editModel($data, $id)) {
                $log_data = array(
                    'user_id' => $this->session->userdata('user_id'),
                    'table_id' => $id,
                    'message' => 'Product Updated'
                );
                $this->log_model->insert_log($log_data);
                $this->session->set_flashdata('success', 'Product updated successfully.');
                redirect("product", 'refresh');
            } else {
                $this->session->set_flashdata('fail', 'Product can not be Updated.');
                redirect("product", 'refresh');
            }
        }
    }

    public function editQuantity(){
        if($this->input->is_ajax_request()){
            $id = $this->input->post("productID");
            $quantity = $this->input->post("productQty");
            if($this->product_model->updateProductStock($id, $quantity)){
              echo "SUCCESS";
            }else{
              echo "FAILED";
            }
        }
    }

    public function delete($id) {
        if ($this->product_model->deleteModel($id)) {
            $log_data = array(
                'user_id' => $this->session->userdata('user_id'),
                'table_id' => $id,
                'message' => 'Product Deleted'
            );
            $this->log_model->insert_log($log_data);
            redirect('product', 'refresh');
        } else {
            $this->session->set_flashdata('fail', 'Product can not be Deleted.');
            redirect("product", 'refresh');
        }
    }

    public function import() {
        $data['category'] = $this->product_model->getCategory();
        $this->load->view('product/import', $data);
    }

    public function import_csv() {
        $category_id = $this->input->post('category');
        $update_records = $this->input->post('update_records');
        $filename = $_FILES["csv"]["tmp_name"];
        if ($_FILES["csv"]["size"] > 0) {
            $file = fopen($filename, "r");
            for ($lines = 0; $data = fgetcsv($file, 1000, ",", '"'); $lines++) {
                if ($lines == 0) {
                    if (sizeof($data) != 13) {
                        if (sizeof($data) < 13) {
                            fclose($file);
                            $this->session->set_flashdata('fail', 'Few columns are missing in uploaded file.');
                            redirect("product/import", 'refresh');
                        } else {
                            fclose($file);
                            $this->session->set_flashdata('fail', 'There are few extra columns are available in uploaded file.');
                            redirect("product/import", 'refresh');
                        }
                    } else if (($data[0] != "Code") || ($data[1] != "Name") || ($data[3] != "Unit") ||
                            ($data[4] != "Size") || ($data[5] != "Cost") || ($data[6] != "Price") || ($data[7] != "Opening Qty") ||
                            ($data[8] != "Alert Quantity") || ($data[9] != "Details")) {
                        fclose($file);
                        $this->session->set_flashdata('fail', 'File is not having proper format as per sample product file.');
                        redirect("product/import", 'refresh');
                    } else {
                        continue;
                    }
                }

                $sql = "INSERT INTO `products`(`category_id`, `code`, `name`, `unit`, `size`, `cost`, `price`,
                	`quantity`, `alert_quantity`, `details`)
                	VALUES (" . $category_id . ",'" . trim($data[0]) . "','" . trim($data[1]) . "','" .
                        trim($data[3]) . "','" . trim($data[4]) . "','" . trim($data[5]) . "','" . trim($data[6]) . "','" .
                        trim($data[7]) . "','" . trim($data[8]) . "','" . trim($data[9]) . "')";
                $this->db->query($sql);
                if ($id = $this->db->insert_id()) {
                } else {
                    $error = $this->db->error();

                    if ($error['code'] == 1062) {
                        if ($update_records == "yes") {
                            $product = $this->product_model->getRecordByCode(trim($data[0]));
                        }
                    }
                }
            }
            fclose($file);
            $this->session->set_flashdata('success', 'Products are imported successfully.');
            redirect("product", 'refresh');
        } else {
            redirect("product/import", 'refresh');
        }
        redirect('product', 'refresh');
    }

    function barcode($code = 100) {
        $file = Zend_Barcode::draw('code128', 'image', array('text' => $code), array());
        $code = time() . $code;
        $store_image = imagepng($file, "./assets/images/barcode/{$code}.png");
        return base_url('assets/images/barcode/') . $code . '.png';
    }

    public function products_barcode() {
        $data['data'] = $this->product_model->getBarcode();
        $this->load->view('product/barcode', $data);
    }

    function code_exists($code) {
        if ($this->product_model->codeExist($code)) {
            $this->form_validation->set_message('code_exists', 'Code Already Exist');
            return false;
        } else {
            return true;
        }
    }

    function alpha_dash_space($str) {
        if (!preg_match("/^([-a-zA-Z0-9_ ])+$/i", $str)) {
            $this->form_validation->set_message('alpha_dash_space', 'The %s field may only contain alpha-numeric characters, spaces, underscores, and dashes.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

}
?>
