<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pieces_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function index() {
    }

    public function getBrand() {
        $this->db->select('*');
        $data = $this->db->get_where('brand', array('delete_status' => 0));
        return $data->result();
    }

    public function getUqc() {
        return $this->db->get_where('uqc', array('delete_status' => 0))->result();
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

    public function getPieces() {
        $u_type = $this->session->userdata('type');
        if ($u_type == "manager" || $u_type == "sales_person") {
            $user_id = $this->session->userdata('user_id');
            $this->db->select('p.piece_id')->from('warehouses_piecess p')->join('warehouse_management w', 'w.warehouse_id = p.warehouse_id')->where('w.warehouse_id', $warehouse_id);
            $data = $this->db->get()->result();
            foreach ($data as $value) {
                $p_id[] = $value->piece_id;
            }
            if ($data) {
                $this->db->select('p.*')->from('pieces p')->where_in('p.piece_id', $p_id)->where('p.delete_status', 0);
                return $this->db->get()->result();
            } else {

                $this->db->select('p.*')->from('pieces p')->where('p.piece_id', 0)->where('p.delete_status', 0);
                return $this->db->get()->result();
            }
        } else {
            $this->db->select('p.*')->from('pieces p')->where('p.delete_status', 0);
            return $this->db->get()->result();
        }
    }

    public function getPiecesWarehouseWise($user_id) {
        $u_type = $this->session->userdata('type');
        if ($u_type == "manager" || $u_type == "sales_person") {
            $user_id = $this->session->userdata('user_id');
            $this->db->select('p.*,ws.quantity as w_quantity')->from('pieces p')->join('warehouses_pieces ws', 'ws.piece_id = p.piece_id')->join('warehouse_management wm', 'wm.warehouse_id = ws.warehouse_id')->where('wm.user_id', $user_id);
            return $this->db->get()->result();
        } else {
            $this->db->select('p.*')->from('pieces p')->where('p.delete_status', 0);
            return $this->db->get()->result();
        }
    }

    function codeExist($key) {
        $sql = "select * from pieces where code = ?";
        $query = $this->db->query($sql, array("code" => $key));
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function addModel($data) {
        log_message('debug', print_r($data, true));
        if ($this->db->insert('pieces', $data)) {
            return $this->db->insert_id();
        } else {
            return FALSE;
        }
    }

    public function getRecord($data) {
        $this->db->select('pieces.*')->from('pieces')->where('pieces.piece_id', $data);
        $query = $this->db->get();
        if ($query) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    public function getRecordByPieceId($piece_id) {
        $this->db->select('pieces.*')->from('pieces')->where('pieces.piece_id', $piece_id);
        $query = $this->db->get();
        if ($query) {
            return $query->row();
        } else {
            return FALSE;
        }
    }

    public function getRecordByCode($code) {
        $this->db->select('pieces.*')->from('pieces')->where('pieces.code', $code);
        $query = $this->db->get();
        if ($query) {
            return $query->row();
        } else {
            return FALSE;
        }
    }

    public function editModel($data, $id) {
        $this->db->where('piece_id', $id);
        if ($this->db->update('pieces', $data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deleteModel($id) {
        $this->db->where('piece_id', $id);
        if ($this->db->update('pieces', array('delete_status' => 1))) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getBarcode() {
        return $this->db->get_where('pieces', array('delete_status' => 0))->result();
    }

    public function insertOpeningStock($id, $quantity) {
        $warehouse = $this->db->get_where('warehouse', array('primary_warehouse' => 1))->row();
        if ($warehouse != null) {
            $warehouse_id = $warehouse->warehouse_id;
            $this->db->insert('warehouses_pieces', array('piece_id' => $id, 'warehouse_id' => $warehouse_id, 'quantity' => $quantity));
        }
    }

    public function updateOpeningStock($id, $quantity, $old_qty) {
        $warehouse = $this->db->select('w.warehouse_id,wp.quantity')->from('warehouse w')->join('warehouses_pieces wp', 'wp.warehouse_id = w.warehouse_id')->where('w.primary_warehouse', 1)->get()->row();
        $piece_quantity = $this->getRecordByPieceId($id)->quantity;
        if ($warehouse != null) {
            $warehouse_id = $warehouse->warehouse_id;
            $old_quantity = $warehouse->quantity;
            $this->db->where('piece_id', $id);
            $this->db->where('warehouse_id', $warehouse_id);
            $new_qty = $old_quantity - $old_qty + $quantity;
            $this->db->update('warehouses_pieces', array('quantity' => $new_qty));

            $piece_quantity = $piece_quantity - $old_quantity + $new_qty;
            $data = array(
                "quantity" => $piece_quantity,
                "opening_stock" => $quantity
            );
            if ($this->editModel($data, $id)) {
                return true;
            }
        }
    }

}

?>
