<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Quotation_model extends CI_Model
{
	function __construct() {
		parent::__construct();
		
	}
	/* 
		return all sales details to display list 
	*/
	public function getQuotation(){
		$this->db->select('q.*,b.*,c.*')
		         ->from('quotation q')
		         ->join('biller b','q.biller_id=b.biller_id')
		         ->join('customer c','q.customer_id=c.customer_id')
		         ->where('q.user',$this->session->userdata('user_id'))
		         ->where('q.delete_status',0);
		return $this->db->get()->result();
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
		return warehouse detail use drop down 
	*/
	public function getQuotationWarehouse(){
		$users_id = $this->db->select('u.id')
							 ->from('users u')
							 ->join('warehouse_management wm','wm.user_id = u.id')
							 ->join('users_groups ug','ug.user_id = u.id')
							 ->join('groups g','g.id = ug.group_id')
							 ->where('g.id !=',3)
							 ->get()
							 ->result();	
		
		$user_id_array = array();
		
		foreach($users_id as $user_id){
			$user_id_array[] = $user_id->id;
		}
		
		$sales_user_id = $this->db->select('w.*,wm.user_id as user_id,b.branch_name as branch_name,bl.biller_name as biller_name')
				 ->from('warehouse w')
				 ->join('warehouse_management wm','wm.warehouse_id = w.warehouse_id')
				 ->join('branch b','b.branch_id = w.branch_id')
				 ->join('users u','wm.user_id = u.id')
				 ->join('biller bl','bl.user_id = u.id')
				 ->join('users_groups ug','ug.user_id = u.id')
				 ->join('groups g','g.id = ug.group_id')
				 ->where('g.id',3)
				 ->where('w.delete_status',0)
				 ->get()
				 ->result();
		return $sales_user_id;
		
	}
	/* 
		return warehouse details available in warehouse products 
	*/
	public function getWarehouseProducts(){
		$this->db->select('warehouse.warehouse_id,warehouses_products.product_id,quantity')
		         ->from('warehouse')
		         ->join('warehouses_products','warehouse.warehouse_id = warehouses_products.warehouse_id');
		return $this->db->get()->result();
	}
	/* 
		return biller detail use drop down 
	*/
	public function getBiller(){
		return $this->db->get_where('biller',array('delete_status'=>0))->result();
	}
	/* 
		return customer detail use drop down 
	*/
	public function getCustomer(){
		return $this->db->get_where('customer',array('delete_status'=>0))->result();
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
		generate invoive no
	*/
	public function generateInvoiceNo(){
		$query = $this->db->query("SELECT * FROM invoice ORDER BY id DESC LIMIT 1");
		$result = $query->result();
		if($result==null){
            $no = sprintf('%06d',intval(1));
        }
        else{
          foreach ($result as $value) {
            $no = sprintf('%06d',intval($value->id)+1); 
          }
        }
		return "QO-".$no;
	}
	/*	
		generate payment reference no
	*/
	public function generateReferenceNo(){
		$query = $this->db->query("SELECT * FROM payment ORDER BY id DESC LIMIT 1");
		$result = $query->result();
		return $result;
	}
	/* 
		return last purchase id 
	*/
	public function createReferenceNo(){
		$query = $this->db->query("SELECT * FROM quotation ORDER BY quotation_id DESC LIMIT 1");
		$result = $query->result();
		return $result;
	}
	/* 
		return sales record 
	*/
	public function getRecord($id){
		// $sql = "select * from quotation where quotation_id = ?";
		// if($query = $this->db->query($sql,array($id))){
		// 	return $query->result();
		// }
		// else{
		// 	return FALSE;
		// }

		return $this->db->select('
								q.*,
								c.customer_name as customer_name,
								c.address as billing_address,
								ccs.name as billing_city,
								css.name as billing_state,
								ccrs.name as billing_country,
								q.shipping_address as shipping_address,
								qcs.name as shipping_city,
								qss.name as shipping_state,
								qcrs.name as shipping_country,
								qss.id as shipping_state_id
								')
						 ->from('quotation q')
						 ->join('customer c','c.customer_id = q.customer_id')
						 ->join('cities ccs','ccs.id = c.city_id')
						 ->join('states css','css.id = c.state_id')
						 ->join('countries ccrs','ccrs.id = c.country_id')
						 ->join('cities qcs','qcs.id = c.city_id')
						 ->join('states qss','qss.id = c.state_id')
						 ->join('countries qcrs','qcrs.id = c.country_id')
						 ->where('quotation_id',$id)
					     ->get()
					     ->result();
	}
	/* 
		add new sales record in database 
	*/
	public function addModel($data){
		// $this->db->insert('quotation',$data);
		// echo $this->db->last_query();
		// exit;

		if($this->db->insert('quotation',$data)){
			return $this->db->insert_id(); 
		}
		else{
			return FALSE;
		}
	}
	/* 
		return discount detail use drop down when discount change
	*/
	public function getDiscountAjax($id){
		$sql = "select * from discount where discount_id = ?";
		return $this->db->query($sql,array($id))->result();
	}
	/* 
		check product available in sales or not 
	*/
	public function checkProductInQuotation($quotation_id,$product_id){
		$sql = "select * from quotation_items where quotation_id = ? AND product_id = ?";
		if($quantity = $this->db->query($sql,array($quotation_id,$product_id))->num_rows() > 0){

			$sql = "select * from quotation_items where quotation_id = ? AND product_id = ?";
			$quantity = $this->db->query($sql,array($quotation_id,$product_id));
			return $quantity->row()->quantity;
		}
		else{
			return false;
		}
		
	}
	/* 
		update quantity in product table 
	*/
	public function updateQuantity($quotation_id,$product_id,$warehouse_id,$quantity,$old_quantity,$data){
		$where = "quotation_id = $quotation_id AND product_id = $product_id";
		$this->db->where($where);
		$this->db->update('quotation_items',$data);
	}
	/* 
		check product available in warehouse or not 
	*/
	public function checkProductInWarehouse($product_id,$quantity,$warehouse_id){
		$sql = "select * from warehouses_products where product_id = ? AND warehouse_id = ?";
		$query = $this->db->query($sql,array($product_id,$warehouse_id));
		
		if($query->num_rows()>0){
			$warehouse_quantity = $query->row()->quantity;
			if($warehouse_quantity >= $quantity){
				$wquantity = $warehouse_quantity - $quantity;
				$sql = "update warehouses_products set quantity = ? where product_id = ? AND warehouse_id = ?";
				$this->db->query($sql,array($wquantity,$product_id,$warehouse_id));
				
				$sql = "select * from products where product_id = ?";
				$product_quantity = $this->db->query($sql,array($product_id))->row()->quantity;
				
				$pquantity = $product_quantity - $quantity ;	
				$sql = "update products set quantity = ? where product_id = ?";
				$this->db->query($sql,array($pquantity,$product_id));
			}
		}
	}
	/*  
		add newly sales items record in database 
	*/
	public function addQuotationItem($data,$product_id,$warehouse_id,$quantity){

		if($this->db->insert('quotation_items',$data)){
			return true;
		}
		else{
			return false;
		}
	}
	/* 
		return sales item data when edited 
	*/
	public function getQuotationItems($quotation_id,$warehouse_id){
		$this->db->select('si.*,wp.quantity as warehouses_quantity,p.product_id,p.code,p.name,p.unit,p.price,p.cost,p.hsn_sac_code')
				 ->from('quotation_items si')
				 ->join('products p','si.product_id = p.product_id')
				 ->join('warehouses_products wp','wp.product_id = p.product_id')
				 ->where('si.quotation_id',$quotation_id)
				 ->where('wp.warehouse_id',$warehouse_id)
				 ->where('si.delete_status',0);
		if($query = $this->db->get()){
			return $query->result();
		}
		else{
			return FALSE;
		}
	}
	/* 
		return  single product to add dynamic table 
	*/
	public function getProduct($product_id,$warehouse_id){
		return $this->db->select('p.product_id,code,p.hsn_sac_code,unit,name,size,cost,price,alert_quantity,image,category_id,subcategory_id,wp.quantity,warehouse_id')
			 ->from('products p')
			 ->join('warehouses_products wp','p.product_id = wp.product_id')
			 ->where('wp.warehouse_id',$warehouse_id)
			 ->where('wp.product_id',$product_id)
		     ->get()
		     ->result();
	}
	/* 
		return  product list to add product 
	*/
	public function getProducts($warehouse_id){
		return  $this->db->select('p.*')
					 ->from('products p')
					 ->join('warehouses_products wp','p.product_id = wp.product_id')
					 ->where('wp.warehouse_id',$warehouse_id)
					 ->where('wp.quantity > 0')
					 ->where('p.delete_status',0)
				     ->get()
				     ->result();
	}
	/* 
		save edited record in database 
	*/
	public function editModel($id,$data){
		$this->db->where('quotation_id',$id);
		if($this->db->update('quotation',$data)){
			return true;
		}
		else{
			return false;
		}
	}
	/* 
		delete old purchase item when edit purchse  
	*/
	public function deleteQuotationItems($quotation_id,$product_id,$warehouse_id,$old_warehouse_id){

		$this->db->where('quotation_id',$quotation_id);
		$this->db->where('product_id',$product_id);
		if($this->db->update('quotation_items',array('delete_status'=>1))){
			return true;
		}
		else{
			return false;
		}
	}
	/* 
		when warehouse change selected items is delete this function  
	*/
	public function changeWarehouseDeleteQuotationItems($quotation_id,$product_id,$warehouse_id,$old_warehouse_id){
		$this->db->where('quotation_id',$quotation_id);
		$this->db->where('product_id',$product_id);
		if($this->db->update('quotation_items',array('delete_status'=>1))){
			return true;
		}
		else{
			return false;
		}
	}
	/* 
		delete sales record in database 
	*/
	public function deleteModel($id){
		$this->db->where('quotation_id',$id);
		if($this->db->update('quotation',array('delete_status'=>1))){
			$this->db->where('quotation_id',$id);
			$this->db->update('quotation_items',array('delete_status'=>1));
		}
		else{
			return FALSE;
		}
	}
	/* 
		return all details of sales 
	*/
	public function getSalesData(){
		return $this->db->get('sales')->result();
	}
	/*
		return all details of purchase
	*/
	public function getPurchaseData(){		
		return $this->db->get('purchases')->result();
	}
	/* 
		return sales data for calendar
	*/
	public function getCalendarData(){
		return $this->db->get('sales')->result();
	}
	/*
		return sales details
	*/
	public function getDetails($id){

		$result = $this->db->select('q.*,
									c.customer_name as customer_name,
									c.address as customer_address,
									c.mobile as customer_mobile,
									c.email as customer_email,
									ccs.name as customer_city,
									css.name as customer_state,									
									ccrs.name as customer_country,
									bl.biller_name as biller_name,
									b.address as biller_address,
									ccs.name as biller_city,
									css.name as biller_state,									
									ccrs.name as biller_country,
									bl.mobile as biller_mobile,
									bl.email as biller_email
								 ')
						 ->from('quotation q')
						 ->join('warehouse w','w.warehouse_id = q.customer_id')
						 ->join('branch b','b.branch_id = w.branch_id')
						 ->join('biller bl','bl.biller_id = q.biller_id')
						 ->join('customer c','q.customer_id = c.customer_id')
						 ->join('cities ccs','ccs.id = c.city_id')
						 ->join('states css','css.id = c.state_id')
						 ->join('countries ccrs','ccrs.id = c.country_id')
						 ->join('cities bcs','bcs.id = c.city_id')
						 ->join('states bss','bss.id = c.state_id')
						 ->join('countries bcrs','bcrs.id = c.country_id')
						 ->where('q.quotation_id',$id)
						 ->get()
						 ->result();



		 // echo '<pre>';
		 // print_r($result);
		 // exit;

		 return $result;
	}
	/*
		return details for payment
	*/
	public function getDetailsPayment($id){
		return  $this->db->select('s.*,
								   c.customer_name,
								   c.address as customer_address,
								   c.mobile as customer_mobile,
								   c.email as customer_email,
								   c.gstid as customer_gstid,
								   ct.name as customer_city,
								   cco.name as customer_country,
								   b.biller_name,
								   b.address as biller_address,
								   cb.name as biller_city,
								   co.name as biller_country,
								   b.mobile as biller_mobile,
								   b.email as biller_email,
								   b.gstid as biller_gstid,
								   w.warehouse_name,
								   br.address as branch_address,
								   br.city as branch_city,
								   u.first_name,
								   u.last_name')
						 ->from('sales s')
						 ->join('customer c','s.customer_id = c.customer_id')
						 ->join('cities ct','c.city_id = ct.id')
						 ->join('countries cco','c.country_id = cco.id')
						 ->join('biller b','s.biller_id = b.biller_id')
						 ->join('cities cb','b.city_id = cb.id')
						 ->join('countries co','b.country_id = co.id')
						 ->join('warehouse w','s.warehouse_id = w.warehouse_id')
						 ->join('branch br','w.branch_id = br.branch_id')
						 ->join('users u','s.user = u.id')
						 ->where('s.quotation_id',$id)
						 ->get()
						 ->result();
	}
	/*
		return sales item details
	*/
	public function getItems($id){
		return  $this->db->select('si.*,pr.name,pr.code,pr.hsn_sac_code,pr.unit')
						 ->from('quotation_items si')
						 ->join('quotation s','si.quotation_id = s.quotation_id')
						 ->join('products pr','si.product_id = pr.product_id')
						 ->where('si.quotation_id',$id)
						 ->get()
						 ->result();
	}
	/*
		return supplier details
	*/
	public function getCustomerEmail($id){

		return $this->db->select('*')
						 ->from('quotation s')
						 ->join('customer c','c.customer_id = s.customer_id')
						 ->where('s.quotation_id',$id)
						 ->get()
						 ->result();
	}
	/*
		add payment details
	*/
	public function addPayment($data){

		$sql = "INSERT INTO payment (sales_id,date,reference_no,amount,paying_by,bank_name,cheque_no,description) VALUES (?,?,?,?,?,?,?,?)";
		if($this->db->query($sql,$data)){
		/*if($this->db->insert('payment',$data)){*/

			$this->db->where('sales_id',$data['sales_id']);
			$this->db->update('invoice',array("paid_amount"=>$data['amount']));
			return true;
		}else{
			return false;
		}
	}
	/*

	*/
	public function invoice(){
		return $this->db->get('invoice')->result();
	}
	/*
		return SMTP server Data
	*/
	public function getSmtpSetup(){
		return $this->db->get('email_setup')->row();
	} 
	/*
		return customer data for shipping address
	*/
	public function getCustomerData($id){
		$this->db->where('customer_id',$id);
		return $this->db->get_where('customer')->row();
	}
	/*
		return country
	*/
	public function getCountry(){
		return $this->db->get('countries')->result();
	}
	/*
		return state
	*/
	public function getState($id){	
		return $this->db->select('s.*')
		                 ->from('states s')
		                 ->join('countries c','c.id = s.country_id')
		                 ->where('s.country_id',$id)
		                 ->get()
		                 ->result();
	}
	/*
		return city 
	*/
	public function getCity($id){
		return $this->db->select('c.*')
		                 ->from('cities c')
		                 ->join('states s','s.id = c.state_id')
		                 ->where('c.state_id',$id)
		                 ->get()
		                 ->result();
	} 
	/*
		check invoice created or not
	*/
	public function checkInvoice($id){
		return $this->db->select('q.quotation_id')
					     ->from('quotation q')
					     ->join('invoice i','i.quotation_id = q.quotation_id')
					     ->where('q.quotation_id',$id)
					     ->get()
					     ->row();

	}
}
?>