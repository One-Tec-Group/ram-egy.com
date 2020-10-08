<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sales_model extends CI_Model
{
	function __construct() {
		parent::__construct();

		
	}
	/* 
		return all sales details to display list 
	*/
	public function getSales(){

		// echo $this->session->userdata('user_id');
		// exit;

		if($this->session->userdata('type') == "admin"){
			$this->db->select('s.*,c.*,i.*,b.*')
			         ->from('sales s')
			         ->join('biller b','s.biller_id=b.biller_id')
			         ->join('customer c','s.customer_id=c.customer_id')
			         ->join('invoice i ','i.sales_id = s.sales_id')			    			         	
			         ->where('s.delete_status',0);
			         
			return $this->db->get()->result();
		}else if($this->session->userdata('type') == "sales_person" || $this->session->userdata('type') == "purchaser"){
			$data = $this->db->select('s.*,bc.biller_name as biller_name,cc.customer_id as customer_id,cc.customer_name as customer_name,i.*')
			         ->from('sales s')	
			         ->join('invoice i ','i.sales_id = s.sales_id')
			         ->join('biller bc','bc.biller_id = s.biller_id')
			         ->join('customer cc','cc.customer_id = s.customer_id')
			         ->join('warehouse_management wm','wm.user_id = bc.user_id')
			         ->where('bc.user_id',$this->session->userdata('user_id'))
			         ->where('s.delete_status',0);
			return $data->get()->result();

		}
	}
	/* 
		return warehouse detail use drop down 
	*/
	public function getWarehouse(){
		if($this->session->userdata('type') == "admin"){
			
			$this->db->select('w.*,wm.user_id as user_id,b.branch_name as branch_name,bl.biller_name as biller_name')
					 ->from('warehouse w')
					 ->join('branch b','w.branch_id = b.branch_id')
					 ->join('warehouse_management wm','wm.warehouse_id = w.warehouse_id')
					 ->join('users u','wm.user_id = u.id')
					 ->join('biller bl','bl.user_id = u.id')
					 ->where('w.delete_status',0);

			return $this->db->get()->result();
		}
		else{

			$this->db->select('w.*,wm.user_id as user_id,b.branch_name as branch_name,bl.biller_name as biller_name')
					 ->from('warehouse w')
					 ->join('branch b','w.branch_id = b.branch_id')
					 ->join('warehouse_management wm','wm.warehouse_id = w.warehouse_id')
					 ->join('users u','wm.user_id = u.id')
					 ->join('biller bl','bl.user_id = u.id')
					 ->where('wm.user_id',$this->session->userdata('user_id'))
					 ->where('w.delete_status',0);


			return $this->db->get()->result();
		}
	}

	/* 
		return warehouse detail use drop down 
	*/
	public function getSalesWarehouse(){
		
		// $users_id = $this->db->select('u.id')
		// 					 ->from('users u')
		// 					 ->join('warehouse_management wm','wm.user_id = u.id')
		// 					 ->join('users_groups ug','ug.user_id = u.id')
		// 					 ->join('groups g','g.id = ug.group_id')
		// 					 ->where('g.id !=',3)
		// 					 ->get()
		// 					 ->result();	
		
		// $user_id_array = array();
		// echo '<pre>';
		// print_r($user_id_array);
		// exit;
		// foreach($users_id as $user_id){
		// 	$user_id_array[] = $user_id->id;
		// }
		// if(!empty($user_id_array)){
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
			// echo '<pre>';
			// print_r($sales_user_id);
			// exit;		 
			return $sales_user_id;
		// 	if($sales_user_id == null){
		// 		return false;
		// 	}else{
		// 		return $sales_user_id;
		// 	}
		// }else{
		// 	return false;
		// }		
	}

	/* 
		return biller warehouse detail from user id  
	*/
	public function getBillerWarehouseDetails($user_id){
		
		$biller_warehouse = $this->db->select('w.*,wm.user_id as user_id,b.biller_id as biller_id,br.state_id as biller_state_id')
				 ->from('warehouse w')
				 ->join('warehouse_management wm','wm.warehouse_id = w.warehouse_id')
				 ->join('users u','wm.user_id = u.id')
				 ->join('biller b','wm.user_id = b.user_id ')
				 ->join('branch br','br.branch_id = w.branch_id')
				 ->where('u.id',$user_id)
				 ->where('w.delete_status',0)
				 ->get()
				 ->result();
		// echo '<pre>';
		// print_r($biller_warehouse);
		// exit;
		return $biller_warehouse;
		
	}

	/* 
		return biller warehouse detail from user id  
	*/
	public function getBillerStateIdFromBiller($biller_id){
		
		return $biller_warehouse = $this->db->select('br.state_id as biller_state_id')
				 ->from('warehouse w')
				 ->join('warehouse_management wm','wm.warehouse_id = w.warehouse_id')
				 ->join('users u','wm.user_id = u.id')
				 ->join('biller b','wm.user_id = b.user_id ')
				 ->join('branch br','br.branch_id = w.branch_id')
				 ->where('b.biller_id',$biller_id)
				 ->where('w.delete_status',0)
				 ->get()
				 ->row()
				 ->biller_state_id;
		// echo '<pre>';
		// print_r($biller_warehouse);
		// exit;
		//return $biller_warehouse;
		
	}

	/* 
		return biller warehouse detail from user id  
	*/
	public function getCustomerStateId($customer_id){
		
		//return $this->db->get_where('customer',array('customer_id'=>$customer_id))->row()->state_id;
		$result = $this->db->select('state_id')
		         ->from('customer')
		         ->where('customer_id',$customer_id)
		         ->get()
		         ->result();

		return $result;
		// echo '<pre>';
		// print_r($result);
		// exit;
		// echo '<pre>';
		// print_r($biller_warehouse);
		// exit;
		//return $biller_warehouse;
		
	}

	public function checkBillerForPrimaryWarehouse(){

		$result = $this->db->select('*')
				 ->from('warehouse w')
				 ->join('warehouse_management wm','wm.warehouse_id = w.warehouse_id')
				 ->join('branch b','b.branch_id = w.branch_id')
				 ->join('users u','wm.user_id = u.id')
				 ->join('users_groups ug','ug.user_id = u.id')
				 ->join('groups g','g.id = ug.group_id')
				 ->where('w.primary_warehouse',1)
				 ->where('g.id',3)
				 ->where('w.delete_status',0)
				 ->get()
				 ->result();
		// echo '<pre>';
		// print_r($result);
		// exit;
		if($result != null){
			return true;
		}else{
			return false;
		}

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
		return warehouse details available in warehouse products warehouse wise
		@warehouse_id 
	*/
	public function getWarehouseProductsFromWarehouse($warehouse_id){
		$this->db->select('warehouse.warehouse_id,warehouses_products.product_id,quantity')
		         ->from('warehouse')
		         ->join('warehouses_products','warehouse.warehouse_id = warehouses_products.warehouse_id')
		         ->where('warehouse.warehouse_id',$warehouse_id);
		return $this->db->get()->result();
	}
	/* 
		return biller detail use drop down 
	*/
	public function getBiller(){
		//return $this->db->get_where('biller',array('delete_status'=>0))->result();
		if($this->session->userdata('type') == "admin"){
			
			return $this->db->get_where('biller',array('delete_status'=>0))->result();

		}else{

			return $this->db->get_where('biller',array('delete_status'=>0,'user_id'=>$this->session->userdata('user_id')))->result();			
		}
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
		return "INV-".$no;
	}
	
	/* 
		return last purchase id 
	*/
	public function createReferenceNo(){
		$query = $this->db->query("SELECT * FROM sales ORDER BY sales_id DESC LIMIT 1");
		$result = $query->result();
		return $result;
	}
	/* 
		return sales record 
	*/
	public function getRecord($id){
		return $this->db->select('s.*,b.state_id as biller_state_id,sct.name as shipping_city,sst.name as shipping_state,sco.name as shipping_country,cct.name as billing_city,cst.name as billing_state,cco.name as billing_country,c.address as billing_address,b.biller_name as biller_name,c.postal_code as billing_postal_code')
						->from('sales s')
						->join('biller b','b.biller_id = s.biller_id')
						->join('cities sct','s.shipping_city_id = sct.id')
						->join('states sst','s.shipping_state_id = sst.id')
						->join('countries sco','s.shipping_country_id = sco.id')
						->join('customer c','c.customer_id = s.customer_id')
						->join('cities cct','c.city_id = cct.id')
						->join('states cst','c.state_id = cst.id')
						->join('countries cco','c.country_id = cco.id')
						->where('s.sales_id',$id)
						->get()
						->result();
	}

	/* 
		return sales record from invoice number
	*/
	public function getRecordFromInvoice($invoice){
		return $this->db->select('s.*,b.state_id as biller_state_id,sct.name as shipping_city,sst.name as shipping_state,sco.name as shipping_country,cct.name as billing_city,cst.name as billing_state,cco.name as billing_country,c.address as billing_address,b.biller_name as biller_name,c.postal_code as billing_postal_code')
						->from('sales s')
						->join('invoice i','i.sales_id = s.sales_id')
						->join('biller b','b.biller_id = s.biller_id')
						->join('cities sct','s.shipping_city_id = sct.id')
						->join('states sst','s.shipping_state_id = sst.id')
						->join('countries sco','s.shipping_country_id = sco.id')
						->join('customer c','c.customer_id = s.customer_id')
						->join('cities cct','c.city_id = cct.id')
						->join('states cst','c.state_id = cst.id')
						->join('countries cco','c.country_id = cco.id')
						->where('i.id',$invoice)
						->get()
						->result();
	}
	/* 
		add new sales record in database 
	*/
	public function addModel($data,$invoice){
		/*$sql = "insert into sales (date,reference_no,warehouse_id,customer_id,biller_id,total,discount_value,tax_value,note,shipping_city_id,shipping_state_id,shipping_country_id,shipping_address,shipping_charge,internal_note,user) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
		if($this->db->query($sql,$data)){*/

		// echo '<pre>';
		// print_r($data);
		// print_r($invoice);
		// $this->db->insert('sales',$data);
		// echo $this->db->last_query();
		// exit;

		if($this->db->insert('sales',$data)){
			$insert_id = $this->db->insert_id(); 
			$invoice['sales_id'] = $insert_id;
			$this->db->insert('invoice',$invoice);
			return $insert_id;
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
	public function checkProductInSales($sales_id,$product_id){
		$sql = "select * from sales_items where sales_id = ? AND product_id = ? AND delete_status = 0";
		if($quantity = $this->db->query($sql,array($sales_id,$product_id))->num_rows() > 0){

			$sql = "select * from sales_items where sales_id = ? AND product_id = ? AND delete_status = 0";
			$quantity = $this->db->query($sql,array($sales_id,$product_id));
			return $quantity->row()->quantity;
		}
		else{
			return false;
		}
		
	}
	/* 
		update quantity in product table 
	*/
	public function updateQuantity($sales_id,$product_id,$warehouse_id,$quantity,$old_quantity,$data){
		/*$sql = "update sales_items set quantity=?,price =?,gross_total=?,discount=?,tax=? where sales_id = ? AND product_id = ?";
		$this->db->query($sql,array($quantity,$data['price'],$data['gross_total'],$data['discount'],$data['tax'],$sales_id,$product_id));*/
		$where = "sales_id = $sales_id AND product_id = $product_id";
		$this->db->where($where);
		$this->db->update('sales_items',$data);
		
		$sql = "select * from warehouses_products where warehouse_id = ? AND product_id = ?";
		$warehouse_quantity = $this->db->query($sql,array($warehouse_id,$product_id))->row()->quantity;
		
		$wquantity = $warehouse_quantity - $quantity + $old_quantity;
		$sql = "update warehouses_products set quantity = ? where warehouse_id = ? AND product_id = ?";
		$this->db->query($sql,array($wquantity,$warehouse_id,$product_id));
		

		$sql = "select * from products where product_id = ?";
		$product_quantity = $this->db->query($sql,array($product_id))->row()->quantity;
		
		$pquantity = $product_quantity - $quantity + $old_quantity;
		$sql = "update products set quantity = ? where product_id = ?";
		$this->db->query($sql,array($pquantity,$product_id));
		
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
	public function addSalesItem($data,$product_id,$warehouse_id,$quantity){
		$sql = "select * from warehouses_products where warehouse_id = ? AND product_id = ?";
		$warehouse_quantity = $this->db->query($sql,array($warehouse_id,$product_id))->row()->quantity;
		
		$wquantity = $warehouse_quantity - $quantity;
		$sql = "update warehouses_products set quantity = ? where warehouse_id = ? AND product_id = ?";
		$this->db->query($sql,array($wquantity,$warehouse_id,$product_id));
		
		$sql = "select * from products where product_id = ?";
		$product_quantity = $this->db->query($sql,array($product_id))->row()->quantity;
		
		$pquantity = $product_quantity - $quantity ;	
		$sql = "update products set quantity = ? where product_id = ?";
		$this->db->query($sql,array($pquantity,$product_id));

		if($this->db->insert('sales_items',$data)){
			return true;
		}
		else{
			return false;
		}
	}
	/* 
		return sales item data when edited 
	*/
	public function getSalesItems($sales_id,$warehouse_id){
		$this->db->select('si.*,wp.quantity as warehouses_quantity,p.product_id,p.code,p.name,p.unit,p.price,p.hsn_sac_code')
				 ->from('sales_items si')
				 ->join('products p','si.product_id = p.product_id')
				 ->join('warehouses_products wp','wp.product_id = p.product_id')
				 ->where('si.sales_id',$sales_id)
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

	*/
	public function getSalesItemsForDelete($id){
		return $this->db->get_where('sales_items',array('sales_id'=>$id))->result();
	}
	/* 
		return  single product to add dynamic table 
	*/
	public function getProduct($product_id,$warehouse_id){
		return $this->db->select('p.product_id,p.code,p.hsn_sac_code,p.unit,p.name,p.size,p.cost,p.price,p.alert_quantity,p.image,p.category_id,p.subcategory_id,p.tax_id,wp.quantity,wp.warehouse_id,t.tax_value')
			 ->from('products p')
			 ->join('warehouses_products wp','p.product_id = wp.product_id')
			 ->join('tax t','p.tax_id = t.tax_id','left')
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
		$this->db->where('sales_id',$id);
		
		if($this->db->update('sales',$data)){
			$this->db->where('sales_id',$id);
			$this->db->update('invoice',array('sales_amount'=>$data['total']));
			return true;
		}
		else{
			return false;
		}
	}
	/* 
		delete old purchase item when edit purchse  
	*/
	public function deleteSalesItems($sales_id,$product_id,$warehouse_id,$old_warehouse_id){
		
		$sql = "select * from sales_items where sales_id = ? AND product_id = ?";
		$delete_quantity = $this->db->query($sql,array($sales_id,$product_id))->row()->quantity;

		$sql = "select * from warehouses_products where warehouse_id = ? AND product_id = ?";
		$warehouse_quantity = $this->db->query($sql,array($warehouse_id,$product_id))->row()->quantity;
		
		$wquantity = $warehouse_quantity + $delete_quantity;
		$sql = "update warehouses_products set quantity = ? where warehouse_id = ? AND product_id = ?";
		$this->db->query($sql,array($wquantity,$warehouse_id,$product_id));
	

		$sql = "select * from products where product_id = ?";
		$product_quantity = $this->db->query($sql,array($product_id))->row()->quantity;
		
		$pquantity = $product_quantity + $delete_quantity;
		$sql = "update products set quantity = ? where product_id = ?";
		$this->db->query($sql,array($pquantity,$product_id));
		/*$sql = "delete from sales_items where sales_id = ? AND product_id = ?";
		if($this->db->query($sql,array($sales_id,$product_id))){*/
		$this->db->where('sales_id',$sales_id);
		$this->db->where('product_id',$product_id);
		if($this->db->update('sales_items',array('delete_status'=>1))){
			return true;
		}
		else{
			return false;
		}
	}
	/* 
		when warehouse change selected items is delete this function  
	*/
	public function changeWarehouseDeleteSalesItems($sales_id,$product_id,$warehouse_id,$old_warehouse_id){

		$sql = "select * from sales_items where sales_id = ? AND product_id = ?";
		$delete_quantity = $this->db->query($sql,array($sales_id,$product_id))->row()->quantity;

		$sql = "select * from warehouses_products where warehouse_id = ? AND product_id = ?";
		$warehouse_quantity = $this->db->query($sql,array($old_warehouse_id,$product_id))->row()->quantity;
		
		$wquantity = $warehouse_quantity + $delete_quantity;
		$sql = "update warehouses_products set quantity = ? where warehouse_id = ? AND product_id = ?";
		$this->db->query($sql,array($wquantity,$old_warehouse_id,$product_id));

		$sql = "select * from products where product_id = ?";
		$product_quantity = $this->db->query($sql,array($product_id))->row()->quantity;
		
		$pquantity = $product_quantity + $delete_quantity;
		$sql = "update products set quantity = ? where product_id = ?";
		$this->db->query($sql,array($pquantity,$product_id));
		
		/*$sql = "delete from sales_items where sales_id = ? AND product_id = ?";
		if($this->db->query($sql,array($sales_id,$product_id))){*/
		$this->db->where('sales_id',$sales_id);
		$this->db->where('product_id',$product_id);
		if($this->db->update('sales_items',array('delete_status'=>1))){
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
		$this->db->where('sales_id',$id);
		if($this->db->update('sales',array('delete_status'=>1,'delete_date'=>date('Y-m-d')))){
			$this->db->where('sales_id',$id);
			$this->db->update('sales_items',array('delete_status'=>1));
			return TRUE;
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

		// if($this->getBillerIdFromSales($id) == 0){
		// 	return  $this->db->select('s.*,
		// 						   i.invoice_no,
		// 						   i.invoice_date,
		// 						   i.paid_amount,
		// 						   c.customer_name as customer_name,
		// 						   c.address as customer_address,
		// 						   c.mobile as customer_mobile,
		// 						   c.email as customer_email,
		// 						   cc.name as customer_city,
		// 						   cs.name as customer_state,
		// 						   ccs.name as customer_country,
		// 						   b.address as biller_address,
		// 						   cb.name as biller_city,
		// 						   sb.name as biller_state,
		// 						   ccb.name as biller_country
		// 					')
		// 				 ->from('sales s')
		// 				 ->join('invoice i','i.sales_id = s.sales_id')
		// 				 ->join('customer c','c.customer_id = s.customer_id')
		// 				 ->join('cities cc','cc.id = c.city_id')
		// 				 ->join('states cs','cs.id = c.state_id')
		// 				 ->join('warehouse w','w.warehouse_id = s.warehouse_id')
		// 				 ->join('branch b','b.branch_id = w.branch_id')
		// 				 ->join('countries ccs','ccs.id = c.country_id')
		// 				 ->join('cities cb','cb.id = b.city_id')
		// 				 ->join('states sb','sb.id = b.state_id')
		// 				 ->join('countries ccb','ccb.id = b.country_id')
		// 				 ->where('s.sales_id',$id)
		// 				 ->get()
		// 				 ->result();

		// }else{

			return  $this->db->select('s.*,
									   i.invoice_no,
									   i.invoice_date,
									   i.paid_amount,
									   c.customer_name,
									   c.address as customer_address,
									   c.mobile as customer_mobile,
									   c.email as customer_email,
									   c.company_name as customer_company,
									   c.postal_code as customer_postal_code,
									   c.gstid as customer_gstid,
									   c.state_id as customer_state_id,
									   c.tan_no as tan_no,
									   c.cst_reg_no as cst_reg_no,
									   c.excise_reg_no as excise_reg_no,
									   c.lbt_reg_no as lbt_reg_no,
									   c.servicetax_reg_no as servicetax_reg_no,
								       ct.name as customer_city,
									   cs.name as customer_state,
									   cc.name as customer_country,
									   b.biller_name as biller_name,
									   b.mobile as biller_mobile,
									   b.email as biller_email,
									   b.company_name as biller_company,
									   b.fax as biller_fax,
									   b.telephone as biller_telephone,
									   b.gstid as biller_gstid,
									   b.state_id as biller_state_id,
									   b.gstid as biller_gstin,
									   br.address as branch_address,
									   br.address as biller_address,
									   cbr.name as biller_city,
									   sbr.name as biller_state,
									   csbr.name as biller_country,
									   cbr.name as branch_city,
									   s.shipping_address as shipping_address,
									   ssh.name as shipping_city,
									   sssh.name as shipping_state,
									   csh.name as shipping_country,
									   t.mode as mode
									')
							 ->from('sales s')
							 ->join('invoice i','i.sales_id = s.sales_id')
							 ->join('customer c','s.customer_id = c.customer_id')
					  		 ->join('cities ct','c.city_id = ct.id')
							 ->join('states cs','c.state_id = cs.id')
							 ->join('countries cc','c.country_id = cc.id')
							 ->join('biller b','b.biller_id = s.biller_id')
							 ->join('warehouse w','s.warehouse_id = w.warehouse_id')
							 ->join('branch br','w.branch_id = br.branch_id')
							 ->join('cities cbr','cbr.id = br.city_id')
							 ->join('states sbr','sbr.id = br.state_id')
							 ->join('countries csbr','csbr.id = br.country_id')
							 ->join('cities ssh','ssh.id = s.shipping_city_id')
							 ->join('states sssh','sssh.id = s.shipping_state_id')
							 ->join('countries csh','csh.id = s.shipping_country_id')
							 ->join('transaction_header t','t.invoice_id = s.sales_invoice','left')
							 ->where('s.sales_id',$id)
							 ->get()
							 ->result();
		// }

		
	}
	
	/*
		return sales item details
	*/
	public function getItems($id){
		return  $this->db->select('si.*,pr.name,pr.code,pr.hsn_sac_code,pr.unit,pr.size')
						 ->from('sales_items si')
						 ->join('sales s','si.sales_id = s.sales_id')
						 ->join('products pr','si.product_id = pr.product_id')
						 ->where('si.sales_id',$id)
						 ->get()
						 ->result();
	}
	/*
		return supplier details
	*/
	public function getCustomerEmail($id){

		return $this->db->select('*')
						 ->from('sales s')
						 ->join('customer c','c.customer_id = s.customer_id')
						 ->where('s.sales_id',$id)
						 ->get()
						 ->result();
	}
	/*
		return details for payment
	*/
	public function getDetailsReceipt($id){

		
			return  $this->db->select('s.*,
								   i.id as invoice_id,
								   i.invoice_no,
								   i.invoice_date,
								   i.paid_amount,
								   c.customer_name,
								   c.address as customer_address,
								   c.mobile as customer_mobile,
								   c.email as customer_email,
								   c.gstid as customer_gstid,
								   ct.name as customer_city,
								   cco.name as customer_country,
								   c.postal_code as customer_postal_code,
								   b.biller_name,
								   b.address as biller_address,
								   cb.name as biller_city,
								   co.name as biller_country,
								   b.mobile as biller_mobile,
								   b.email as biller_email,
								   b.gstid as biller_gstid,
								   w.warehouse_name,
								   br.branch_name,
								   br.branch_id,
								   br.address as branch_address,
								   cr.name as branch_city,
								   u.first_name,
								   u.last_name
								   ')
						 ->from('sales s')
						 ->join('invoice i','i.sales_id = s.sales_id')
						 ->join('customer c','s.customer_id = c.customer_id')
						 ->join('cities ct','c.city_id = ct.id')
						 ->join('countries cco','c.country_id = cco.id')
						 ->join('biller b','s.biller_id = b.biller_id')
						 ->join('cities cb','b.city_id = cb.id')
						 ->join('countries co','b.country_id = co.id')
						 ->join('warehouse w','s.warehouse_id = w.warehouse_id')
						 ->join('branch br','w.branch_id = br.branch_id')
						 ->join('users u','s.user = u.id')
						 ->join('cities cr','br.city_id = cr.id')
						 ->where('s.sales_id',$id)
						 ->get()
						 ->result();
	
	}

	/*
		return biller id from sales table 
	*/
	public function getBillerIdFromSales($sales_id){
		return $this->db->get_where('sales',array('sales_id'=>$sales_id))->row()->biller_id;

	}
	/*
		add payment details
	*/
	public function addPayment($data){
		$paid_amount =  $this->db->get_where('invoice',array('sales_id'=>$data['sales_id']))->row()->paid_amount;
		//echo $data['amount']+$paid_amount;
		$sql = "INSERT INTO payment (sales_id,date,reference_no,amount,paying_by,bank_name,cheque_no,description) VALUES (?,?,?,?,?,?,?,?)";
		if($this->db->query($sql,$data)){
		/*if($this->db->insert('payment',$data)){*/

			$this->db->where('sales_id',$data['sales_id']);
			$this->db->update('invoice',array("paid_amount"=>$data['amount']+$paid_amount));
			return true;
		}else{
			return false;
		}
	}
	/*

	*/
	public function invoice(){
		return $this->db->select('*,c.customer_name')
					    ->from('invoice i')
					    ->join('sales s','s.sales_id = i.sales_id')
					    ->join('customer c','s.customer_id=c.customer_id')
					    ->where('s.user',$this->session->userdata('user_id'))
					    ->where('s.delete_status',0)
					    ->get()
					    ->result();
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
		return customer details with sales details
	*/ 
	public function getCustomerWithAllData($customer_id){
		return  $this->db->select('s.*,
								   i.invoice_no,
								   i.invoice_date,
								   i.paid_amount,
								   sct.name as shipping_city_name,
								   sst.name as shipping_state_name,
								   scu.name as shipping_country_name,
								   c.customer_name,
								   c.address as customer_address,
								   c.mobile as customer_mobile,
								   c.email as customer_email,
								   c.company_name as customer_company,
								   c.postal_code as customer_postal_code,
								   c.gstid as customer_gstin,
								   c.state_id as customer_state_id,
								   c.tan_no as tan_no,
								   c.cst_reg_no as cst_reg_no,
								   c.excise_reg_no as excise_reg_no,
								   c.lbt_reg_no as lbt_reg_no,
								   c.servicetax_reg_no as servicetax_reg_no,
								   ct.name as customer_city,
								   cs.name as customer_state,
								   cc.name as customer_country,
								   b.biller_name,
								   b.address as biller_address,
								   cb.name as biller_city,
								   co.name as biller_country,
								   b.mobile as biller_mobile,
								   b.email as biller_email,
								   b.company_name as biller_company,
								   b.fax as biller_fax,
								   b.telephone as biller_telephone,
								   b.gstid as biller_gstid,
								   b.state_id as biller_state_id,
								   w.warehouse_name,
								   br.address as branch_address,
								   cb.name as branch_city
							')
						 ->from('sales s')
						 ->join('invoice i','i.sales_id = s.sales_id')
						 ->join('cities sct','s.shipping_city_id=sct.id')
						 ->join('states sst','s.shipping_state_id=sst.id')
						 ->join('countries scu','s.shipping_country_id=scu.id')
						 ->join('customer c','s.customer_id = c.customer_id')
						 ->join('cities ct','c.city_id = ct.id')
						 ->join('states cs','c.state_id = cs.id')
						 ->join('countries cc','c.country_id = cc.id')
						 ->join('biller b','s.biller_id = b.biller_id')
						 ->join('cities cb','b.city_id = cb.id')
						 ->join('states bs','b.state_id = bs.id')
						 ->join('countries co','b.country_id = co.id')
						 ->join('warehouse w','s.warehouse_id = w.warehouse_id')
						 ->join('branch br','w.branch_id = br.branch_id')
						 ->where('s.customer_id',$customer_id)
						 ->get()
						 ->result();
	}
	/*
		return customer details with sales details
	*/ 
	public function getBillerWithAllData($biller_id){
		return  $this->db->select('s.*,
								   i.invoice_no,
								   i.invoice_date,
								   i.paid_amount,
								   sct.name as shipping_city_name,
								   sst.name as shipping_state_name,
								   scu.name as shipping_country_name,
								   c.customer_name,
								   c.address as customer_address,
								   c.mobile as customer_mobile,
								   c.email as customer_email,
								   c.company_name as customer_company,
								   c.postal_code as customer_postal_code,
								   c.gstid as customer_gstin,
								   c.state_id as customer_state_id,
								   c.tan_no as tan_no,
								   c.cst_reg_no as cst_reg_no,
								   c.excise_reg_no as excise_reg_no,
								   c.lbt_reg_no as lbt_reg_no,
								   c.servicetax_reg_no as servicetax_reg_no,
								   ct.name as customer_city,
								   cs.name as customer_state,
								   cc.name as customer_country,
								   b.biller_name,
								   b.address as biller_address,
								   cb.name as biller_city,
								   bs.name as biller_state,
								   co.name as biller_country,
								   b.mobile as biller_mobile,
								   b.email as biller_email,
								   b.company_name as biller_company,
								   b.fax as biller_fax,
								   b.telephone as biller_telephone,
								   b.gstid as biller_gstin,
								   b.state_id as biller_state_id,
								   w.warehouse_name,
								   br.address as branch_address,
								   cr.name as branch_city
							')
						 ->from('sales s')
						 ->join('invoice i','i.sales_id = s.sales_id')
						 ->join('cities sct','s.shipping_city_id=sct.id')
						 ->join('states sst','s.shipping_state_id=sst.id')
						 ->join('countries scu','s.shipping_country_id=scu.id')
						 ->join('customer c','s.customer_id = c.customer_id')
						 ->join('cities ct','c.city_id = ct.id')
						 ->join('states cs','c.state_id = cs.id')
						 ->join('countries cc','c.country_id = cc.id')
						 ->join('biller b','s.biller_id = b.biller_id')
						 ->join('cities cb','b.city_id = cb.id')
						 ->join('states bs','b.state_id = bs.id')
						 ->join('countries co','b.country_id = co.id')
						 ->join('warehouse w','s.warehouse_id = w.warehouse_id')
						 ->join('branch br','w.branch_id = br.branch_id')
					 	 ->join('cities cr','br.city_id = cr.id')
						 ->where('s.biller_id',$biller_id)
						 ->get()
						 ->result();
	}
	/*
		return customer ledger account 
	*/
	public function getFromLedger($id){
		return  $this->db->select('l.*')
						 ->from('customer c')
						 ->join('ledger l','c.ledger_id = l.id')
						 ->where('c.customer_id',$id)
						 ->get()
						 ->row();
		
	}
	/*
		return biller ledger account 
	*/
	public function getToLedger($id){
		return  $this->db->select('l.*')
						 ->from('biller b')
						 ->join('ledger l','b.ledger_id = l.id')
						 ->where('b.biller_id',$id)
						 ->get()
						 ->row();
	}
	/*

	*/
	public function restoreQuantity($id,$product_id,$warehouse_id,$quantity){
		$item_quantity = $this->db->get_where('sales_items',array('product_id'=>$product_id,"sales_id"=>$id))->row()->quantity;
		$warehouse_quantity = $this->db->get_where('warehouses_products',array('product_id'=>$product_id,"warehouse_id"=>$warehouse_id))->row()->quantity;
		$product_quantity = $this->db->get_where('products',array('product_id'=>$product_id))->row()->quantity;

		$this->db->where('warehouse_id',$warehouse_id);
		$this->db->where('product_id',$product_id);
		$this->db->update('warehouses_products',array('quantity'=>$warehouse_quantity+$item_quantity));
		$this->db->where('product_id',$product_id);
		$this->db->update('products',array('quantity'=>$product_quantity+$item_quantity));
		
	}
	/*

	*/
	public function getSalesForCreditNote($id){
		return $this->db->select('i.id,i.invoice_no,i.paid_amount,s.sales_id')
					    ->from('sales s')
					    ->join('invoice i','i.sales_id = s.sales_id')
					    ->where('s.sales_id',$id)
					    ->get()
					    ->row();
	}
	/*

	*/
	public function getFromToAccount($id){
		return $this->db->select('s.sales_id,c.ledger_id as to_account,b.ledger_id as from_account')
				    	->from('sales s')
				    	->join('customer c','c.customer_id = s.customer_id')
				    	->join('biller b','b.biller_id = s.biller_id')
				    	->get()
				    	->row();

	}

	public function isFieldExist($field_name){
		$fields = $this->db->list_fields('sales');
		// echo '<pre>';
		// print_r($fields);
		// exit;
		foreach ($fields as $field) {
			if($field == $field_name){
				return true;
			}
		}
		return false;
	}

	// public function isFieldExist($field_name){
	// 	$fields = $this->db->list_fields('sales');

	// 	foreach ($fields as $field) {
	// 		if($field->name == $field_name){
	// 			return true;
	// 		}
	// 	}
	// 	return false;
	// }
	/*

	*/
	public function getPDFPage(){
		return $this->db->get_where('multiple_invoice',array('active'=>1))->row()->name;
	}
}
?>