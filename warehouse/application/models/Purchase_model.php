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

		if($this->session->userdata('type') == "admin"){

			$this->db->select('p.*,s.*,ar.*')
				 ->from('purchases p')
				 ->join('suppliers s','p.supplier_id = s.supplier_id')
				 ->join('account_receipts ar','ar.purchase_id = p.purchase_id')
				 ->where('p.delete_status',0);
			$data = $this->db->get();
			log_message('debug', print_r($data, true));
			return $data->result();

		}else if($this->session->userdata('type') == "purchaser"){
			$this->db->select('p.*,s.*,ar.*')
				 ->from('purchases p')
				 ->join('suppliers s','p.supplier_id = s.supplier_id')
				 ->join('account_receipts ar','ar.purchase_id = p.purchase_id')
				 ->where('p.user',$this->session->userdata('user_id'))
				 ->where('p.delete_status',0);
			$data = $this->db->get();
			log_message('debug', print_r($data, true));
			return $data->result();

		}

	}
	/*
		return warehouse detail use drop down
	*/
	public function getWarehouse(){
		if($this->session->userdata('type') == "admin"){
			$this->db->select('w.*, b.*, cs.name as city_name, s.name as state_name, c.name as country_name, b.branch_name as branch_name ')
				 ->from('warehouse w')
				 ->join('warehouse_management wm','wm.warehouse_id = w.warehouse_id')
				 ->join('branch b','b.branch_id = w.branch_id')
				 ->join('cities cs','cs.id = b.city_id')
				 ->join('states s','s.id = cs.state_id')
				 ->join('countries c','c.id = s.country_id')
				 ->join('users u','wm.user_id = u.id')
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

	public function checkPurchaserForPrimaryWarehouse(){

		$result = $this->db->select('*')
				 ->from('warehouse w')
				 ->join('warehouse_management wm','wm.warehouse_id = w.warehouse_id')
				 ->join('branch b','b.branch_id = w.branch_id')
				 ->join('users u','wm.user_id = u.id')
				 ->join('users_groups ug','ug.user_id = u.id')
				 ->join('groups g','g.id = ug.group_id')
				 ->where('w.primary_warehouse',1)
				 ->where('g.id',2)
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

	public function getPurchaserWarehouse(){

		$purchase_user_id = $this->db->select('w.*,wm.user_id as user_id,cs.name as city_name, s.name as state_name, c.name as country_name,b.branch_name as branch_name, s.id as state_id, b.address as address')
				 ->from('warehouse w')
				 ->join('warehouse_management wm','wm.warehouse_id = w.warehouse_id')
				 ->join('branch b','b.branch_id = w.branch_id')
				 ->join('cities cs','cs.id = b.city_id')
				 ->join('states s','s.id = cs.state_id')
				 ->join('countries c','c.id = s.country_id')
				 ->join('users u','wm.user_id = u.id')
				 ->join('users_groups ug','ug.user_id = u.id')
				 ->join('groups g','g.id = ug.group_id')
				 ->where('g.id',2)
				 ->where('w.delete_status',0)
				 ->get()
				 ->result();
		// echo '<pre>';
		// print_r($purchase_user_id);
		// exit;
		return $purchase_user_id;

			// $this->db->select('w.*, b.*, cs.name as city_name, s.name as state_name, c.name as country_name, b.branch_name as branch_name,u.id as user_id')
			// 	 ->from('warehouse w')
			// 	 ->join('warehouse_management wm','wm.warehouse_id = w.warehouse_id')
			// 	 ->join('branch b','b.branch_id = w.branch_id')
			// 	 ->join('cities cs','cs.id = b.city_id')
			// 	 ->join('states s','s.id = cs.state_id')
			// 	 ->join('countries c','c.id = s.country_id')
			// 	 ->join('users u','wm.user_id = u.id')
			// 	 ->join('users_groups ug','ug.user_id = u.id')
			// 	 ->join('groups g','g.id = ug.group_id')
			// 	 ->where('g.id',2)
			// 	 ->where('w.delete_status',0);
			// return $this->db->get()->result();

	}

	/*
		return purchaser count detail use drop down
	*/
	public function getPurchaserCount(){

			$this->db->select('count(*) as no_of_purchaser')
				 ->from('users u')
				 ->join('users_groups ug','ug.user_id = u.id')
				 ->join('groups g','g.id = ug.group_id')
				 ->where('g.id',2);

			return $this->db->get()->row()->no_of_purchaser;

	}

	/*
		return purchaser assign count detail use drop down
	*/
	public function getPurchaserAssignmentCount(){

			$data = $this->db->select('*')
				 ->from('users u')
				 ->join('users_groups ug','ug.user_id = u.id')
				 ->join('warehouse_management wm','wm.user_id = ug.user_id')
				 ->join('groups g','g.id = ug.group_id')
				 ->where('g.id',2)
				 ->get()
				 ->result();

			if(sizeof($data)){
				return sizeof($data);
			}else{
				return 0;
			}

			//return $this->db->get()->row()->no_of_purchaser_assignment;

	}

	/*
		return warehouse detail use drop down
	*/
	public function getWarehouesDetails($warehouse_id){

			$this->db->select('w.*,b.state_id as warehouse_state_id')
				 ->from('warehouse w')
				 ->join('warehouse_management wm','wm.warehouse_id = w.warehouse_id')
				 ->join('branch b','b.branch_id = w.branch_id')
				 ->where('w.warehouse_id',$warehouse_id)
				 ->where('w.delete_status',0);
			return $this->db->get()->result();

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
		return "PO-".$no;
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

 			/*echo '<pre>';
			print_r($data);
			print_r($invoice);
			exit;*/

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
	public function updateProductQuantity($piece_id,$quantity){
		$sql = "select * from pieces where piece_id = ?";
		$product_data = $this->db->query($sql,array($piece_id));

		if($product_data->num_rows()>0){
			$p_data = $product_data->result();
			foreach ($p_data as $pvalue) {
			  $pquantity = $quantity + $pvalue->quantity;
			  $sql = "update pieces set quantity = ? where piece_id = ?";
			  if($this->db->query($sql,array($pquantity,$piece_id))){
			  	return true;
			  }

			}
		}
	}
	/*
		add new record or update quantity in warehouse_pieces table
	*/
	public function addProductInWarehouse($piece_id,$quantity,$warehouse_id,$warehouse_data){
		$sql = "select * from warehouses_pieces where piece_id = ? AND warehouse_id = ?";
		$query = $this->db->query($sql,array($piece_id,$warehouse_id));

		if($query->num_rows()>0){
			$result = $query->result();
			foreach ($result as  $value) {
				$wquantity = $quantity + $value->quantity;
				$sql = "update warehouses_pieces set quantity = ? where piece_id = ? AND warehouse_id = ?";
				if($this->db->query($sql,array($wquantity,$piece_id,$warehouse_id)) && $this->updateProductQuantity($piece_id,$quantity)){
					return true;
				}else{
					return false;
				}
			}

		}
		else{
			$sql = "insert into warehouses_pieces (piece_id,warehouse_id,quantity) values (?,?,?)";
			if($this->db->query($sql,$warehouse_data) && $this->updateProductQuantity($piece_id,$quantity)){
				return true;
			}else{
				return false;
			}
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
	public function addUpdatePurchaseItem($purchase_id,$piece_id,$warehouse_id,$quantity,$warehouse_data,$data){

		// echo '<pre>';
		// echo 'Warehouse Data';
		// print_r($warehouse_data);
		// echo 'Purchase item data';
		// print_r($data);
		// exit;

		$sql = "select * from purchase_items where purchase_id = ? AND piece_id = ?";
		$result = $this->db->query($sql,array($purchase_id,$piece_id));

		if($result->num_rows()>0){
			$purchase_quantity = $result->row()->quantity;
			$where = "purchase_id = $purchase_id AND piece_id = $piece_id";
			$this->db->where($where);
			$this->db->update('purchase_items',$data);
			$sql = "select * from warehouses_pieces where warehouse_id = ? AND piece_id = ?";
			$warehouse_quantity = $this->db->query($sql,array($warehouse_id,$piece_id))->row()->quantity;

			$new_quantity = $warehouse_quantity + $quantity - $purchase_quantity;
			$sql = "update warehouses_pieces set quantity = ? where warehouse_id = ? AND piece_id = ?";
			$this->db->query($sql,array($new_quantity,$warehouse_id,$piece_id));


			$sql = "select * from pieces where piece_id = ?";
			$product_quantity = $this->db->query($sql,array($piece_id))->row()->quantity;

			$new_quantity = $product_quantity + $quantity - $purchase_quantity;
			$sql = "update pieces set quantity = ? where piece_id = ?";
			$this->db->query($sql,array($new_quantity,$piece_id));

		}
		else{
			if($this->addProductInWarehouse($piece_id,$quantity,$warehouse_id,$warehouse_data) && $this->addPurchaseItem($data)){
				return true;
			}else{
				return false;
			}

		}

	}
	/*
		return pieces details
	*/
	public function getProduct(){
		return $this->db->get_where('pieces',array('delete_status'=>0))->result();
	}
	/*
		return  product code or name it use to purchase table in web page
	*/
	public function getProductAjax($id){
		$sql = "select * from pieces where piece_id = ?";
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
		$this->db->select('purchase_items.*,warehouses_pieces.quantity as warehouses_quantity,pieces.piece_id,pieces.code,pieces.name,pieces.unit,pieces.price,pieces.hsn_sac_code,pieces.details')
				 ->from('purchase_items')
				 ->join('pieces','purchase_items.piece_id = pieces.piece_id')
				 ->join('warehouses_pieces','warehouses_pieces.piece_id = pieces.piece_id')
				 ->where('warehouses_pieces.warehouse_id',$warehouse_id)
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
	public function deletePurchaseItems($purchase_id,$piece_id,$warehouse_id){

		$sql = "select * from purchase_items where purchase_id = ? AND piece_id = ?";
		// echo $purchase_id.'-'.$piece_id;
		// exit;
		$delete_quantity = $this->db->query($sql,array($purchase_id,$piece_id))->row()->quantity;

		$sql = "select * from warehouses_pieces where warehouse_id = ? AND piece_id = ?";
		$warehouse_quantity = $this->db->query($sql,array($warehouse_id,$piece_id))->row()->quantity;

		$wquantity = $warehouse_quantity - $delete_quantity;
		$sql = "update warehouses_pieces set quantity = ? where warehouse_id = ? AND piece_id = ?";
		$this->db->query($sql,array($wquantity,$warehouse_id,$piece_id));

		$sql = "select * from pieces where piece_id = ?";
		$product_quantity = $this->db->query($sql,array($piece_id))->row()->quantity;

		$pquantity = $product_quantity - $delete_quantity;
		$sql = "update pieces set quantity = ? where piece_id = ?";
		$this->db->query($sql,array($pquantity,$piece_id));

		/*$sql = "delete from purchase_items where purchase_id = ? AND piece_id = ?";
		if($this->db->query($sql,array($purchase_id,$piece_id))){*/
		$this->db->where('purchase_id',$purchase_id);
		$this->db->where('piece_id',$piece_id);
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
			return	$this->db->select('p.*,
								  ar.receipt_voucher_no as invoice_id,
								  ar.invoice_no,
								  ar.paid_amount,
								  b.branch_name,
								  b.branch_id,
								  cb.name as branch_city,
								  b.address as branch_address,
								  s.supplier_name,
								  s.address as supplier_address,
								  ct.name as supplier_city,
								  s.mobile as supplier_mobile,
								  s.email as supplier_email,
								  s.state_id as supplier_state_id,
								  s.postal_code as supplier_postal_code,
								  s.company_name as supplier_company_name,
								  st.name as supplier_state_name,
								  cu.name as supplier_country_name,
								  s.gstid as supplier_gstin,
								  u.first_name,u.last_name,
								  ar.invoice_no as invoice_no,
								  p.supplier_id as supplier_id,
								  w.warehouse_name as warehouse_name
								')
						 ->from('purchases p')
						 ->join('account_receipts ar','ar.purchase_id = p.purchase_id')
						 ->join('warehouse w','w.warehouse_id = p.warehouse_id')
						 ->join('branch b','b.branch_id = w.branch_id')
						 ->join('suppliers s','p.supplier_id = s.supplier_id')
						 ->join('cities ct','s.city_id = ct.id')
						 ->join('cities cb','b.city_id = cb.id')
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
						 ->join('pieces pr','pi.piece_id = pr.piece_id')
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
	public function getBarcodepieces($term){
		return  $this->db->select('piece_id,code,name')
				        ->from('pieces')
				        ->like('code',$term)
				        ->or_like('name',$term)
				        ->where('delete_status',0)
				        ->get()
				        ->result_array();
	}
	/*
		return ajax name product
	*/
	public function getNamepieces($term){
		return  $this->db->select('piece_id,code,name')
				        ->from('pieces')
				        ->like('name',$term)
				        ->where('delete_status',0)
				        ->get()
				        ->result_array();
	}
	/*
		return product details
	*/
	public function getProductUseCode($piece_id){
		return $this->db->select('p.*')
			 ->from('pieces p')
			 ->where('p.piece_id',$piece_id)
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
	/*
		return customer data for shipping address
	*/
	public function getSupplierData($id){
		$this->db->where('supplier_id',$id);
		return $this->db->get_where('suppliers')->row();
	}
	/*
		return warehouse id of warehouse
	*/
	public function getBillerWarehouse($id){
		return $this->db->select('warehouse_id')
						->from('biller b')
						->join('warehouse_management wm','wm.user_id = b.user_id')
						->where('b.biller_id',$id)
						->get()
						->row()->warehouse_id;
	}

	/*
		return branch id of warehouse
	*/
	public function getBranchIdOfWarehouse($id){
		return $this->db->select('b.branch_id as branch_id')
						->from('warehouse w')
						->join('branch b','b.branch_id = w.branch_id')
						->where('w.warehouse_id',$id)
						->get()
						->row()->branch_id;
	}
	/*
		return biller details
	*/
	public function getSupplierState($id){
		return $this->db->get_where('suppliers',array('supplier_id'=>$id))->row()->state_id;
		//return $this->db->get_where('SUP',array('biller_id' =>$id))->row()->state_id;
	}
}
?>
