<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Purchase_model extends CI_Model
{
	public function index(){
		
	} 
	/* 
		return all purchase details to display list 
	*/
	public function getPurchase(){
		$this->db->select('p.*,s.*,ar.*')
				 ->from('purchases p')
				 ->join('suppliers s','p.supplier_id = s.supplier_id')
				 ->join('account_receipts ar','ar.purchase_id = p.purchase_id')
				 ->where('p.delete_status',0);
		$data = $this->db->get();
		log_message('debug', print_r($data, true));
		return $data->result();
	}
	/* 
		return warehouse detail use drop down 
	*/
	public function getWarehouse(){
		if($this->session->userdata('type') == "admin"){
			return $this->db->get_where('warehouse',array('delete_status'=>0))->result();
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
		return discount detail use drop down 
	*/
	public function getDiscount(){
		return $this->db->get_where('discount',array('delete_status'=>0))->result();
	}
	/* 
		return tax detail use dynamic table
	*/
	public function getTax(){
		return $this->db->get_where('tax',array('delete_status'=>0))->result();
	}
	/* 
		return supplier detail use drop down 
	*/
	public function getSupplier(){
		return $this->db->get_where('suppliers',array('delete_status'=>0))->result();
	}
	/*
		generate invoive no
	*/
	public function generateInvoiceNo(){
		$query = $this->db->query("SELECT * FROM account_receipts ORDER BY receipt_voucher_no DESC LIMIT 1");
		$result = $query->result();
		if($result==null){
            $no = sprintf('%06d',intval(1));
        }
        else{
          foreach ($result as $value) {
            $no = sprintf('%06d',intval($value->receipt_voucher_no)+1); 
          }
        }
		return "RCP-".$no;
	}
	/*	
		generate payment reference no
	*/
	public function generateReferenceNo(){
		$query = $this->db->query("SELECT * FROM account_payments ORDER BY payment_voucher_no DESC LIMIT 1");
		$result = $query->result();
		return $result;
	}
	/* 
		return last purchase id 
	*/
	public function createReferenceNo(){
		$query = $this->db->query("SELECT * FROM purchases ORDER BY purchase_id DESC LIMIT 1");
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
	/* 
		add new purchase record in database 
	*/
	public function addModel($data,$invoice){
		if($this->db->insert('purchases',$data)){
			$insert_id = $this->db->insert_id(); 
			$invoice['purchase_id'] = $insert_id;

			$this->db->insert('account_receipts',$invoice);
			return $insert_id;
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
			  $pquantity = $quantity + $pvalue->quantity;
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
				$wquantity = $quantity + $value->quantity;
				$sql = "update warehouses_products set quantity = ? where product_id = ? AND warehouse_id = ?";
				$this->db->query($sql,array($wquantity,$product_id,$warehouse_id));
				$this->updateProductQuantity($product_id,$quantity);
			}
			
		}
		else{
			$sql = "insert into warehouses_products (product_id,warehouse_id,quantity) values (?,?,?)";
			$this->db->query($sql,$warehouse_data);
			$this->updateProductQuantity($product_id,$quantity);
		}

	}
	/*  
		add newly purchse items record in database 
	*/
	public function addPurchaseItem($data){
		if($this->db->insert('purchase_items',$data)){
			return true;
		}
		else{
			return false;
		}
	}
	/* 
		add or update purchase items in database 
	*/
	public function addUpdatePurchaseItem($purchase_id,$product_id,$warehouse_id,$quantity,$data,$warehouse_data){
		$sql = "select * from purchase_items where purchase_id = ? AND product_id = ?";
		$result = $this->db->query($sql,array($purchase_id,$product_id));
		
		if($result->num_rows()>0){
			$purchase_quantity = $result->row()->quantity;
			$where = "purchase_id = $purchase_id AND product_id = $product_id";
			$this->db->where($where);
			$this->db->update('purchase_items',$data);
			$sql = "select * from warehouses_products where warehouse_id = ? AND product_id = ?";
			$warehouse_quantity = $this->db->query($sql,array($warehouse_id,$product_id))->row()->quantity;
			
			$new_quantity = $warehouse_quantity + $quantity - $purchase_quantity;
			$sql = "update warehouses_products set quantity = ? where warehouse_id = ? AND product_id = ?";
			$this->db->query($sql,array($new_quantity,$warehouse_id,$product_id));
			

			$sql = "select * from products where product_id = ?";
			$product_quantity = $this->db->query($sql,array($product_id))->row()->quantity;
			
			$new_quantity = $product_quantity + $quantity - $purchase_quantity;
			$sql = "update products set quantity = ? where product_id = ?";
			$this->db->query($sql,array($new_quantity,$product_id));
			
		}
		else{
			$this->addProductInWarehouse($product_id,$quantity,$warehouse_id,$warehouse_data);
			$this->addPurchaseItem($data);
		}

	}
	/*
		return products details
	*/
	public function getProduct(){
		return $this->db->get_where('products',array('delete_status'=>0))->result();
	}
	/* 
		return  product code or name it use to purchase table in web page 
	*/
	public function getProductAjax($id){
		$sql = "select * from products where product_id = ?";
		$data = $this->db->query($sql,array($id));
		return $data->result();
	}
	/* 
		return purchase record to edit 
	*/
	public function getRecord($id){
		$sql = "select * from purchases where purchase_id = ?";
		if($query = $this->db->query($sql,array($id))){
		
			return $query->result();
		}
		else{
			return FALSE;
		}
	}
	/* 
		return purchase items to purchase 
	*/
	public function getPurchaseItems($purchase_id,$warehouse_id){
		$this->db->select('purchase_items.*,warehouses_products.quantity as warehouses_quantity,products.product_id,products.code,products.name,products.unit,products.price,products.hsn_sac_code,products.details')
				 ->from('purchase_items')
				 ->join('products','purchase_items.product_id = products.product_id')
				 ->join('warehouses_products','warehouses_products.product_id = products.product_id')
				 ->where('warehouses_products.warehouse_id',$warehouse_id)
				 ->where('purchase_items.purchase_id',$purchase_id)
				 ->where('purchase_items.delete_status',0);
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
		/*$data['purchase_id'] = $id;
		$sql = "update purchases set date = ?,reference_no = ?,supplier_id = ?,warehouse_id = ?,total = ?,discount_value=?,tax_value=?,note = ?,user = ? where purchase_id = ?";
		if($this->db->query($sql,$data)){*/
		$this->db->where('purchase_id',$id);
		if($this->db->update('purchases',$data)){
			return true;
		}
		else{
			return false;
		}
	}
	/* 
		delete purchase record in database 
	*/
	public function deleteModel($id){
		/*$sql = "delete from purchases where purchase_id = ?";
		if($this->db->query($sql,array($id))){*/
		$this->db->where('purchase_id',$id);
		if($this->db->update('purchases',array('delete_status'=>1))){
			/*$sql = "delete from purchase_items where purchase_id = ?";
			if($this->db->query($sql,array($id))){
				return TRUE;
			}*/
			$this->db->where('purchase_id',$id);
			$this->db->update('purchase_items',array('delete_status'=>1));
		}
		else{
			return FALSE;
		}
	}
	/* 
		delete old purchase item when edit purchse  
	*/
	public function deletePurchaseItems($purchase_id,$product_id,$warehouse_id){

		$sql = "select * from purchase_items where purchase_id = ? AND product_id = ?";
		$delete_quantity = $this->db->query($sql,array($purchase_id,$product_id))->row()->quantity;
		
		$sql = "select * from warehouses_products where warehouse_id = ? AND product_id = ?";
		$warehouse_quantity = $this->db->query($sql,array($warehouse_id,$product_id))->row()->quantity;
	
		$wquantity = $warehouse_quantity - $delete_quantity;
		$sql = "update warehouses_products set quantity = ? where warehouse_id = ? AND product_id = ?";
		$this->db->query($sql,array($wquantity,$warehouse_id,$product_id));
		
		$sql = "select * from products where product_id = ?";
		$product_quantity = $this->db->query($sql,array($product_id))->row()->quantity;
	
		$pquantity = $product_quantity - $delete_quantity;
		$sql = "update products set quantity = ? where product_id = ?";
		$this->db->query($sql,array($pquantity,$product_id));
		
		/*$sql = "delete from purchase_items where purchase_id = ? AND product_id = ?";
		if($this->db->query($sql,array($purchase_id,$product_id))){*/
		$this->db->where('purchase_id',$purchase_id);
		$this->db->where('product_id',$product_id);
		if($this->db->update('purchase_items',array('delete_status'=>1))){
			return true;
		}
		else{
			return false;
		}
	}
	/*
		return purchase details
	*/
	public function getDetails($id){
		return $this->db->select('p.*,
								  ar.receipt_voucher_no as invoice_id,
								  ar.invoice_no,
								  ar.paid_amount,
								  w.warehouse_name,
								  b.branch_name,
								  b.branch_id,
								  b.city as branch_city,
								  b.address as branch_address,
								  s.supplier_name,
								  s.address as supplier_address,
								  ct.name as supplier_city,
								  s.mobile as supplier_mobile,
								  s.email as supplier_email,
								  s.state_id as supplier_state_id,
								  s.postal_code as supplier_postal_code,
								  st.name as supplier_state_name,
								  cu.name as supplier_country_name,
								  s.gstid as supplier_gstin,
								  u.first_name,u.last_name'
								)
						 ->from('purchases p')
						 ->join('account_receipts ar','ar.purchase_id = p.purchase_id')
						 ->join('warehouse w','p.warehouse_id = w.warehouse_id')
						 ->join('branch b','w.branch_id = b.branch_id')
						 ->join('suppliers s','p.supplier_id = s.supplier_id')
						 ->join('cities ct','s.city_id = ct.id')
						 ->join('states st','s.state_id = st.id')
						 ->join('countries cu','s.country_id = cu.id')
						 ->join('users u','p.user = u.id')
						 ->where('p.purchase_id',$id)
						 ->get()
						 ->result();
	}
	/*

	*/
	public function getDetailsPayment($id){

	}
	/*
		return company setting details
	*/
	public function getCompany(){
		return $this->db->select('cs.*,c.name as city_name,s.name as state_name,co.name as country_name')
		                ->from('company_settings cs')
		                ->join('cities c','cs.city_id = c.id')
		                ->join('states s','cs.state_id = s.id')
		                ->join('countries co','cs.country_id = co.id')
					    ->get()
					    ->result();
	}
	/*		
		return purchase items details
	*/
	public function getItems($id){
		return $this->db->select('pi.*,pr.name,pr.hsn_sac_code,pr.details')
						 ->from('purchase_items pi')
						 ->join('products pr','pi.product_id = pr.product_id')
						 ->where('pi.purchase_id',$id)
						 ->where('pi.delete_status',0)
						 ->get()
						 ->result();
	}
	/*
		return supplier details
	*/
	public function getSupplierEmail($id){

		return $this->db->select('*')
						 ->from('purchases p')
						 ->join('suppliers s','p.supplier_id = s.supplier_id')
						 ->where('p.purchase_id',$id)
						 ->get()
						 ->result();
	}
	/*
		return discount value
	*/
	public function getDiscountValue($id){
		return $this->db->get_where('discount',array('discount_id'=>$id))->result();
	}
	/*
		return discount value
	*/
	public function getTaxValue($id){
		return $this->db->get_where('tax',array('tax_id'=>$id))->result();
	}
	/*
		return SMTP server Data
	*/
	public function getSmtpSetup(){
		return $this->db->get('email_setup')->row();
	} 
	/*
		add payment details
	*/
	public function addPayment($data){
		/*$sql = "INSERT INTO payment (sales_id,date,reference_no,amount,paying_by,bank_name,cheque_no,description) VALUES (?,?,?,?,?,?,?,?)";
		if($this->db->query($sql,$data)){*/
		if($this->db->insert('account_payments',$data)){
			$this->db->where('purchase_id',$data['purchase_id']);
			$this->db->update('account_receipts',array("paid_amount"=>$data['payment_amount']));
			return true;
		}else{
			return false;
		}
	}
	/*
		return ledger
	*/
	public function getLedger(){
		return $this->db->get('ledger')->result();
	}
	/*
		return ajax barcode product 
	*/
	public function getBarcodeProducts($term){
		return  $this->db->select('product_id,code,name')
				        ->from('products')
				        ->like('code',$term)
				        ->where('delete_status',0)
				        ->or_like('name',$term)
				        ->where('delete_status',0)
				        ->get()
				        ->result_array();				        
	}
	/*
		return ajax name product 
	*/
	public function getNameProducts($term){
		return  $this->db->select('product_id,code,name')
				        ->from('products')
				        ->like('name',$term)
				        ->where('delete_status',0)
				        ->get()
				        ->result_array();
	}
	/*
		return product details
	*/
	public function getProductUseCode($product_id){
		return $this->db->select('p.*,t.purchase_tax_value as tax_value')
			 ->from('products p')
			 ->join('tax t','p.tax_id = t.tax_id','left')
			 ->where('p.product_id',$product_id)
		     ->get()
		     ->result();
	}
	/*
		return supplier ledger id
	*/
	public function getToLedger($id){
		return  $this->db->select('l.*')
						 ->from('suppliers s')
						 ->join('ledger l','s.ledger_id = l.id')
						 ->where('s.supplier_id',$id)
						 ->get()
						 ->row();
	}
}
?>