<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Purchase_return_model extends CI_Model
{
	public function index(){
		
	} 
	/* 
		return all purchase return details to display list 
	*/
	public function getPurchaseReturn(){
		$this->db->select('purchase_return.*,suppliers.*')
				 ->from('purchase_return')
				 ->join('suppliers','purchase_return.supplier_id = suppliers.supplier_id')
				 ->where('purchase_return.delete_status',0);
		$data = $this->db->get();
		log_message('debug', print_r($data, true));
		return $data->result();
	}
	/* 
		return warehouse detail use drop down 
	*/
	public function getWarehouse(){
		if($this->session->userdata('type') == "admin"){
			//return $this->db->get_where('warehouse',array('delete_status'=>0))->result();
			$this->db->select('w.*, b.*, cs.name as city_name, s.name as state_name, c.name as country_name, b.branch_name as branch_name ')
				 ->from('warehouse w')
				 ->join('branch b','b.branch_id = w.branch_id')
				 ->join('cities cs','cs.id = b.city_id')
				 ->join('states s','s.id = cs.state_id')
				 ->join('countries c','c.id = s.country_id')
				 ->where('w.delete_status',0);	
			return $this->db->get()->result();

		}
		else{
			$this->db->select('w.*')
					 ->from('warehouse w')
					 ->join('warehouse_management wm','wm.warehouse_id = w.warehouse_id')
					 ->where('wm.user_id',$this->session->userdata('user_id'))
					 ->where('w.delete_status',0);
			return $this->db->get()->result();
		}
	}
	/* 
		return supplier detail use drop down 
	*/
	public function getSupplier(){
		return $this->db->get_where('suppliers',array('delete_status'=>0))->result();
	}
	/* 
		return last purchase id 
	*/
	public function createReferenceNo(){
		$query = $this->db->query("SELECT * FROM purchase_return ORDER BY id DESC LIMIT 1");
		$result = $query->result();
		return $result;
	}
	/* 
		return supplier name whose id get 
	*/
	public function getSupplierName($id){
		$sql = "select supplier_name from suppliers where supplier_id = ?";
		return $this->db->query($sql,array($id))->result();
	}
	/* add new purchase return record in database */
	public function addModel($data){
		if($this->db->insert('purchase_return',$data)){
			return $this->db->insert_id();
		}
		else{
			return FALSE;
		}
	}
	/* 
		update quantity in product table 
	*/
	public function updateProductQuantity($product_id,$quantity){
		$sql = "select * from products where product_id = ?";
		$product_data = $this->db->query($sql,array($product_id));
		
		if($product_data->num_rows()>0){
			$p_data = $product_data->result();
			foreach ($p_data as $pvalue) {
			  $pquantity = $pvalue->quantity - $quantity;	
			  $sql = "update products set quantity = ? where product_id = ?";
			  $this->db->query($sql,array($pquantity,$product_id));	
			  
			} 
		}
	}
	/* 
		add new record or update quantity in warehouse_products table 
	*/
	public function addProductInWarehouse($product_id,$quantity,$warehouse_id,$warehouse_data){
		$sql = "select * from warehouses_products where product_id = ? AND warehouse_id = ?";
		$query = $this->db->query($sql,array($product_id,$warehouse_id));
		
		if($query->num_rows()>0){
			$result = $query->result();
			foreach ($result as  $value) {
				$wquantity = $value->quantity - $quantity;
				$sql = "update warehouses_products set quantity = ? where product_id = ? AND warehouse_id = ?";
				$this->db->query($sql,array($wquantity,$product_id,$warehouse_id));
				$this->updateProductQuantity($product_id,$quantity);
			}
			
		}
	}
	/*  
		add newly purchse items record in database 
	*/
	public function addPurchaseItem($data){
		if($this->db->insert('purchase_return_items',$data)){
			return true;
		}
		else{
			return false;
		}
	}
	/* 
		add or update purchase items in database 
	*/
	public function addUpdatePurchaseItem($id,$product_id,$warehouse_id,$quantity,$data,$warehouse_data){
		$sql = "select * from purchase_return_items where purchase_return_id = ? AND product_id = ?";
		$result = $this->db->query($sql,array($id,$product_id));
		$where = "purchase_return_id = $id AND product_id = $product_id";
		
		if($result->num_rows()>0){

			$purchase_quantity = $result->row()->quantity;
			$this->db->where($where);
			$this->db->update('purchase_return_items',$data);

			$sql = "select * from warehouses_products where warehouse_id = ? AND product_id = ?";
			$warehouse_quantity = $this->db->query($sql,array($warehouse_id,$product_id))->row()->quantity;
			
			$new_quantity = $warehouse_quantity - $quantity + $purchase_quantity;
			$sql = "update warehouses_products set quantity = ? where warehouse_id = ? AND product_id = ?";
			$this->db->query($sql,array($new_quantity,$warehouse_id,$product_id));

			$sql = "select * from products where product_id = ?";
			$product_quantity = $this->db->query($sql,array($product_id))->row()->quantity;
		
			$new_quantity = $product_quantity - $quantity + $purchase_quantity;
			$sql = "update products set quantity = ? where product_id = ?";
			$this->db->query($sql,array($new_quantity,$product_id));
	
		}
		else{
			$this->addProductInWarehouse($product_id,$quantity,$warehouse_id,$warehouse_data);
			$this->addPurchaseItem($data);
		}

	}
	/* 
		return  single product to add dynamic table 
	*/
	public function getProduct($product_id,$warehouse_id){
		return $this->db->select('p.*,wp.quantity,wp.warehouse_id')
			 ->from('products p')
			 ->join('warehouses_products wp','p.product_id = wp.product_id')
			 ->where('wp.warehouse_id',$warehouse_id)
			 ->where('wp.product_id',$product_id)
		     ->get()
		     ->result();
	}
	/* return  product list to add product dropdown */
	public function getProducts($warehouse_id){
		return  $this->db->select('p.*')
					 ->from('products p')
					 ->join('warehouses_products wp','p.product_id = wp.product_id')
					 ->where('wp.warehouse_id',$warehouse_id)
					 ->where('wp.quantity > 0')
					 ->get()
					 ->result();
	}
	/*  
		return purchase return record to edit 
	*/
	public function getRecord($id){
		$sql = "select * from purchase_return where id = ?";
		if($query = $this->db->query($sql,array($id))){
			return $query->result();
		}
		else{
			return FALSE;
		}
	}
	/* 
		return purchase return items to purchase 
	*/
	public function getPurchaseReturnItems($id,$warehouse_id){
		$this->db->select('pi.*,wp.quantity as warehouses_quantity,pr.product_id,pr.code,pr.name,pr.unit,pr.price,pr.cost,pr.hsn_sac_code')
				 ->from('purchase_return_items pi')
				 ->join('products pr','pi.product_id = pr.product_id')
				 ->join('warehouses_products wp','wp.product_id = pr.product_id')
				 ->where('pi.purchase_return_id',$id)
				 ->where('wp.warehouse_id',$warehouse_id)
				 ->where('pi.delete_status',0);
		if($query = $this->db->get()){
			return $query->result();
		}
		else{
			return FALSE;
		}
	}
	/* 
		save edited record in database 
	*/
	public function editModel($id,$data){
		$this->db->where('id',$id);
		if($this->db->update('purchase_return',$data)){
			return true;
		}
		else{
			return false;
		}
	}
	/* 
		delete purchase return record in database 
	*/
	public function deleteModel($id){
		/*$sql = "delete from purchase_return where id = ?";
		if($this->db->query($sql,array($id))){*/
		$this->db->where('id',$id);
		if($this->db->update('purchase_return',array('delete_status'=>1))){
			/*$sql = "delete from purchase_return_items where purchase_return_id = ?";
			if($this->db->query($sql,array($id))){
				return TRUE;
			}*/
			$this->db->where('purchase_return_id',$id);
			$this->db->update('purchase_return_items',array('delete_status'=>1));
		}
		else{
			return FALSE;
		}
	}
	/* 
		delete old purchase return item when edit purchse  
	*/
	public function deletePurchaseReturnItems($id,$product_id,$warehouse_id){

		$where = "purchase_return_id = $id AND product_id = $product_id";
		$this->db->where($where);
		$delete_quantity = $this->db->get('purchase_return_items')->row()->quantity;
		
		$where = "warehouse_id = $warehouse_id AND product_id = $product_id";
		$this->db->where($where);
		$warehouse_quantity = $this->db->get('warehouses_products')->row()->quantity;
		$wquantity = $warehouse_quantity + $delete_quantity;
	
		$this->db->where($where);
		$this->db->update('warehouses_products',array("quantity"=>$wquantity));
		
		$this->db->where('product_id',$product_id);
		$product_quantity = $this->db->get('products')->row()->quantity;
		$pquantity = $product_quantity + $delete_quantity;
		
		$this->db->where('product_id',$product_id);
		$this->db->update('products',array("quantity"=>$pquantity));
		
		/*$where = "purchase_return_id = $id AND product_id = $product_id";
		$this->db->where($where);
		if($this->db->delete('purchase_return_items')){*/
		$this->db->where('purchase_return_id',$id);
		$this->db->where('product_id',$product_id);
		if($this->db->update('purchase_return_items',array('delete_status'=>1))){
			return true;
		}
		else{
			return false;
		}
	}
	/*
		return discount value
	*/
	public function getDiscount(){
		return $this->db->get_where('discount',array('delete_status'=>0))->result();
	}
	/*
		return discount value
	*/
	public function getTax(){
		return $this->db->get_where('tax',array('delete_status'=>0))->result();
	}
	/*
		return ajax barcode product 
	*/
	public function getBarcodeProducts($term,$warehouse_id){
			$where = "(p.code LIKE '%".$term."%' OR p.name LIKE '%".$term."%' )";
		   	return $this->db->select('p.product_id,p.code,p.name')
					 	 ->from('products p')
						 ->join('warehouses_products wp','p.product_id = wp.product_id')
						 ->where('wp.warehouse_id',$warehouse_id)
						 ->where('wp.quantity > 0')
						 ->where($where)
						 ->where('p.delete_status',0)
					     ->get()
					     ->result_array();
			/*echo $this->db->last_query();
			exit;*/
			/*echo "<pre>";
			print_r($data);
			exit;*/
	}
	/*
		return product details
	*/
	public function getProductUseCode($product_id,$warehouse_id){
		return $this->db->select('p.*,wp.quantity,wp.warehouse_id')
			 ->from('products p')
			 ->join('warehouses_products wp','p.product_id = wp.product_id')
			 ->where('wp.warehouse_id',$warehouse_id)
			 ->where('p.product_id',$product_id)
		     ->get()
		     ->result();

		/*echo '<pre>';
		print_r($data);
		exit;*/

	}
	/*
		return biller details
	*/
	public function getBillerState($id){
		return $this->db->get_where('biller',array('biller_id' =>$id))->row()->state_id;
	}

	/*
		return warehouse state 
	*/
	public function getWarehouseState($warehouse_id){
		return $this->db->select('b.state_id')
			 ->from('warehouse w')
			 ->join('branch b','b.branch_id = w.branch_id','left')
			 ->where('w.warehouse_id',$warehouse_id)
			 ->get()
		     ->result();
		     
		/*return $this->db->get_where('biller',array('biller_id' =>$id))->row()->state_id;*/
	}

	/*
		return warehouse address 
	*/
	public function getWarehouseAddress($warehouse_id){
		return $this->db->select('w.*,cs.name as warehouse_city, s.name as warehouse_state, ces.name as warehouse_country, b.address as warehouse_address, b.city_id as warehouse_city_id, b.state_id as warehouse_state_id, b.country_id as warehouse_country_id')
			 ->from('warehouse w')
			 ->join('branch b','b.branch_id = w.branch_id','left')
			 ->join('cities cs','cs.id = b.city_id')
             ->join('states s','s.id = cs.state_id')
             ->join('countries ces','ces.id = s.country_id')
			 ->where('w.warehouse_id',$warehouse_id)
			 ->get()
		     ->result();
		     
		/*return $this->db->get_where('biller',array('biller_id' =>$id))->row()->state_id;*/
	}
	/*
		return biller details
	*/
	public function getCustomerState($id){
		return $this->db->get_where('customer',array('customer_id' =>$id))->row()->state_id;
	}
}
?>