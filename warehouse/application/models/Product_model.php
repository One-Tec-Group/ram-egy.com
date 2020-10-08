<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function index() {

    }

    public function getCategory() {
        $this->db->select('category_id,category_name');
        $data = $this->db->get_where('category', array('delete_status' => 0));
        return $data->result();
    }

    public function getBrand() {
        $this->db->select('*');
        $data = $this->db->get_where('brand', array('delete_status' => 0));
        return $data->result();
    }

    public function getUqc() {
        return $this->db->get_where('uqc', array('delete_status' => 0))->result();
    }

    public function getSubcategory($id) {
        $sql = "SELECT s.* FROM sub_category s INNER JOIN products p ON s.category_id = p.category_id where p.product_id = ?";
        $data = $this->db->query($sql, array($id));
        return $data->result();
    }

    public function getSac() {

        return $this->db->get('sac')->result();
    }

    public function getHsnChapter() {
        return $this->db->get('hsn_chapter')->result();
    }

    public function getHsn() {
        return $this->db->get_where('hsn', array('chapter' => 1))->result();
    }

    public function getHsnData($id) {
        return $this->db->get_where('hsn', array('chapter' => $id))->result();
    }

    public function selectSubcategory($id) {
        $data = $this->db->get_where('sub_category', array('category_id' => $id, 'delete_status' => 0));
        return $data->result();
    }

    public function getProducts() {
        $u_type = $this->session->userdata('type');
        if ($u_type == "manager" || $u_type == "sales_person") {
            $user_id = $this->session->userdata('user_id');
            $this->db->select('p.product_id')
                    ->from('warehouses_products p')
                    ->join('warehouse_management w', 'w.warehouse_id = p.warehouse_id')
                    ->where('w.warehouse_id', $warehouse_id);
            $data = $this->db->get()->result();
            foreach ($data as $value) {
                $p_id[] = $value->product_id;
            }
            if ($data) {
                $this->db->select('p.*,c.category_name')
                        ->from('products p')
                        ->join('category c', 'c.category_id = p.category_id')
                        ->where_in('p.product_id', $p_id)
                        ->where('p.delete_status', 0);
                return $this->db->get()->result();
            } else {

                $this->db->select('p.*,c.category_name')
                        ->from('products p')
                        ->join('category c', 'c.category_id = p.category_id')
                        ->where('p.product_id', 0)
                        ->where('p.delete_status', 0);
                return $this->db->get()->result();
            }
        } else {
            $this->db->select('p.*,c.category_name')
                    ->from('products p')
                    ->join('category c', 'c.category_id = p.category_id')
                    ->where('p.delete_status', 0);
            return $this->db->get()->result();
        }
    }

    public function getProductsWarehouseWise($user_id) {
        $u_type = $this->session->userdata('type');
        if ($u_type == "manager" || $u_type == "sales_person") {
            $user_id = $this->session->userdata('user_id');
            $this->db->select('p.*,ws.quantity as w_quantity,c.category_name')
                    ->from('products p')
                    ->join('warehouses_products ws', 'ws.product_id = p.product_id')
                    ->join('warehouse_management wm', 'wm.warehouse_id = ws.warehouse_id')
                    ->join('category c', 'c.category_id = p.category_id')
                    ->where('wm.user_id', $user_id);
            return $this->db->get()->result();
        } else {
            $this->db->select('p.*,c.category_name')
                    ->from('products p')
                    ->join('category c', 'c.category_id = p.category_id')
                    ->where('p.delete_status', 0);
            return $this->db->get()->result();
        }
    }

    function codeExist($key) {
        $sql = "select * from products where code = ?";
        $query = $this->db->query($sql, array("code" => $key));
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function addModel($data) {
        log_message('debug', print_r($data, true));
        if ($this->db->insert('products', $data)) {
            return $this->db->insert_id();
        } else {
            return FALSE;
        }
    }

    public function getRecord($data) {
        $this->db->select('products.*, category.category_id,category.category_name, sub_category.sub_category_id, sub_category.sub_category_name')
                ->from('products')
                ->join('category', 'products.category_id = category.category_id')
                ->join('sub_category', 'products.subcategory_id = sub_category.sub_category_id', 'left')
                ->where('products.product_id', $data);
        $query = $this->db->get();
        if ($query) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    public function getRecordByProductId($product_id) {
        $this->db->select('products.*, category.category_id,category.category_name, sub_category.sub_category_id, sub_category.sub_category_name')
                ->from('products')
                ->join('category', 'products.category_id = category.category_id')
                ->join('sub_category', 'products.subcategory_id = sub_category.sub_category_id', 'left')
                ->where('products.product_id', $product_id);
        $query = $this->db->get();
        if ($query) {
            return $query->row();
        } else {
            return FALSE;
        }
    }

    public function getRecordByCode($code) {
        $this->db->select('products.*, category.category_id,category.category_name, sub_category.sub_category_id, sub_category.sub_category_name')
                ->from('products')
                ->join('category', 'products.category_id = category.category_id')
                ->join('sub_category', 'products.subcategory_id = sub_category.sub_category_id', 'left')
                ->where('products.code', $code);
        $query = $this->db->get();
        if ($query) {
            return $query->row();
        } else {
            return FALSE;
        }
    }

    public function editModel($data, $id) {
        $this->db->where('product_id', $id);
        if ($this->db->update('products', $data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deleteModel($id) {
        /* $sql = "delete from products where product_id = ?";
          if($this->db->query($sql,array($id))){ */
        $this->db->where('product_id', $id);
        if ($this->db->update('products', array('delete_status' => 1))) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getBarcode() {
        return $this->db->get_where('products', array('delete_status' => 0))->result();
    }

    public function updateProductStock($id, $new_qty) {
        $warehouse = $this->db->select('w.warehouse_id,wp.quantity')->from('warehouse w')->join('warehouses_products wp', 'wp.warehouse_id = w.warehouse_id')->where('w.primary_warehouse', 1)->get()->row();
        $product_quantity = $this->getRecordByProductId($id)->quantity;
        if ($warehouse != null) {
            $warehouse_id = $warehouse->warehouse_id;
            $this->db->where('product_id', $id);
            $this->db->where('warehouse_id', $warehouse_id);
            $this->db->update('warehouses_products', array('quantity' => $new_qty));
            $data = array(
                "quantity" => $new_qty
            );
						$this->db->where('product_id', $id);
						$product = $this->db->get("products")->row();
						$productOldQty = $product->quantity;
						$QtyDiff = $new_qty - $productOldQty;
            if ($this->editModel($data, $id)) {
								$piecesData = $product->p_pieces;
								$piecesData = explode(",", $piecesData);
								for ($i = 0; $i < count($piecesData); $i++) {
										$piece = str_replace(array("{", "}"), "", $piecesData[$i]);
										$piece = explode(":", $piece);
										$this->db->where("piece_id", $piece[0]);
										$piecee = $this->db->get("pieces")->row();
										$data = array(
				                "quantity" => (($piecee->quantity) - ($piece[1] * $QtyDiff))
				            );
										$this->db->where("piece_id", $piece[0]);
										$this->db->update("pieces", $data);
								}
                return true;
            }
        }
    }

}
?>
