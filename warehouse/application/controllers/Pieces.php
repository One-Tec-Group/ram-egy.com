<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Pieces extends CI_Controller
{
	function __construct() {
		parent::__construct();
		$this->load->model('pieces_model');
		$this->load->model('log_model');
		$this->load->library('zend');
	    $this->zend->load('Zend/Barcode');
	    $this->load->model('sales_model');
	    $this->load->model('ion_auth_model');
	    $this->load->model('warehouse_model');
	    $this->load->model('biller_model');

	    if ( ! $this->session->userdata('loggedin'))
        {
            redirect('auth/login');
        }
	}
	public function index(){

		$data['user'] = $this->ion_auth_model->user()->row();
		$data['user_group'] = $this->ion_auth_model->get_users_groups($data['user']->id)->result();

		// echo $data['user_group'][0]->name;
		if($data['user_group'][0]->name =="sales_person" || $data['user_group'][0]->name =="purchaser"){


			$data['data'] = $this->pieces_model->getPiecesWarehouseWise($data['user']->id);

		}else{

			$data['data'] = $this->pieces_model->getPieces();

		}

		$data['no_of_warehouse'] = sizeof($this->warehouse_model->getWarehouseCount());


		// $data['no_of_branch']
		// echo '<pre>';
		// print_r($data);
		// exit;

		$this->load->view('pieces/list',$data);
	}
	/*
		call add view to add piece record
	*/
	public function add(){
	  $data['sac']      = $this->pieces_model->getSac();
		$data['chapter']  = $this->pieces_model->getHsnChapter();
		$data['hsn']      = $this->pieces_model->getHsn();
		$data['brand']	  = $this->pieces_model->getBrand();
		$data['uqc']	  = $this->pieces_model->getUqc();
		$this->load->view('pieces/add',$data);
	}

	public function getHsnData($id){
		$data = $this->pieces_model->getHsnData($id);
		echo json_encode($data);
	}
	/*
		This function is used to add piece record in database
	*/
	public function addPiece(){
		$this->load->helper('security');
		$this->form_validation->set_rules('code', 'Code', 'trim|required|xss_clean');
		$this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[3]|xss_clean');
		$this->form_validation->set_rules('cost', 'Cost', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('price', 'Price', 'trim|required|numeric|xss_clean');

		if ($this->form_validation->run() == FALSE)
        {
            $this->add();
        }
        else
        {
        	if($_FILES["image"]["name"]){
        		$type = explode('.',$_FILES["image"]["name"]);
				$type = $type[count($type)-1];
				$url = "assets/images/pieces/".uniqid(rand()).'.'.$type;

				if(in_array($type,array("jpg","jpeg","gif","png"))){

					if(is_uploaded_file($_FILES["image"]["tmp_name"])){

						if(move_uploaded_file($_FILES["image"]["tmp_name"],$url)){

						}
					}
				}
        	}
        	else{
        		$url = "assets/images/pieces/no_image.jpg";
        	}


			$data = array(
					"code"           => $this->input->post('code'),
					"name"           => $this->input->post('name'),
					"hsn_sac_code"   => $this->input->post('hsn_sac_code'),
					"barcode"		 => $this->barcode($this->input->post('code')),
					"brand_id"       => $this->input->post('brand'),
					"unit"           => $this->input->post('unit'),
					"size"           => $this->input->post('size'),
					"cost"           => $this->input->post('cost'),
					"price"          => $this->input->post('price'),
					"alert_quantity" => $this->input->post('alert_quantity'),
					"opening_stock"  => $this->input->post('opening_stock'),
					"igst" 			 => $this->input->post('igst'),
					"cgst" 			 => $this->input->post('cgst'),
					"sgst" 			 => $this->input->post('sgst'),
					"image"          => base_url().''.$url,
					"date"           => date('Y-m-d'),
					"details"        => $this->input->post('note')
				);

			if($id = $this->pieces_model->addModel($data)){

				$this->pieces_model->insertOpeningStock($id,$this->input->post('opening_stock'));

				$log_data = array(
						'user_id'  => $this->session->userdata('user_id'),
						'table_id' => $id,
						'message'  => 'Piece Inserted'
					);
				$this->log_model->insert_log($log_data);
				redirect('pieces','refresh');
			}
			else{
				$this->session->set_flashdata('fail', 'Piece can not be Inserted.');
				redirect("pieces",'refresh');
			}
		}
	}
	/*
		call edit view to edit piece record
	*/
	public function edit($id){
		$data['data']        = $this->pieces_model->getRecord($id);
		if($data['data'] == null){
			$this->session->set_flashdata('fail', 'Piece is not available. It might be deleted or removed.');
			redirect("pieces/index",'refresh');
		}
		$data['sac']         = $this->pieces_model->getSac();
		$data['chapter']     = $this->pieces_model->getHsnChapter();
		$data['hsn']         = $this->pieces_model->getHsn();
		$data['brand']	     = $this->pieces_model->getBrand();
		$data['uqc']	     = $this->pieces_model->getUqc();
		$this->load->view('pieces/edit',$data);
	}
	/*
		This function is used to edit piece in database
	*/
	public function editPiece(){
		$id = $this->input->post('id');
		$this->form_validation->set_rules('code', 'Code', 'trim|required');
		$this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[3]');
		$this->form_validation->set_rules('cost', 'Cost', 'trim|required|numeric');
		$this->form_validation->set_rules('price', 'Price', 'trim|required|numeric');


		if ($this->form_validation->run() == FALSE)
        {
            $this->edit($id);
        }
        else
        {

			if($_FILES["image"]["name"] == null){
				$url = $this->input->post('hidden_image');
			}
			else{
				$type = explode('.',$_FILES["image"]["name"]);
				$type = $type[count($type)-1];
				$url = "./assets/images/pieces/".uniqid(rand()).'.'.$type;

				if(in_array($type,array("jpg","jpeg","gif","png"))){

					if(is_uploaded_file($_FILES["image"]["tmp_name"])){

						if(move_uploaded_file($_FILES["image"]["tmp_name"],$url)){
							$url = base_url().''.$url;
						}
					}
				}
			}


			$data = array(
					"code"           => $this->input->post('code'),
					"name"           => $this->input->post('name'),
					"hsn_sac_code"   => $this->input->post('hsn_sac_code'),
					"brand_id"       => $this->input->post('brand'),
					"unit"           => $this->input->post('unit'),
					"size"           => $this->input->post('size'),
					"cost"           => $this->input->post('cost'),
					"price"          => $this->input->post('price'),
					"alert_quantity" => $this->input->post('alert_quantity'),
					"opening_stock"  => $this->input->post('opening_stock'),
					"igst" 			 => $this->input->post('igst'),
					"cgst" 			 => $this->input->post('cgst'),
					"sgst" 			 => $this->input->post('sgst'),
					"image"          => $url,
					"date"           => date('Y-m-d'),
					"details"        => $this->input->post('note')
				);
			// echo '<pre>';
			// print_r($data);
			// exit;
			if($this->pieces_model->editModel($data,$id)){
				$this->pieces_model->updateOpeningStock($id,$this->input->post('opening_stock'),$this->input->post('old_qty'));
				$log_data = array(
						'user_id'  => $this->session->userdata('user_id'),
						'table_id' => $id,
						'message'  => 'Piece Updated'
					);
				$this->log_model->insert_log($log_data);
				// redirect('pieces','refresh');
				$this->session->set_flashdata('success', 'Pieces updated successfully.');
				redirect("pieces",'refresh');
			}
			else{
				$this->session->set_flashdata('fail', 'Piece can not be Updated.');
				redirect("pieces",'refresh');
			}
		}
	}
	/*
		This function is used to delete piece record in databse
	*/
	public function delete($id){
		if($this->pieces_model->deleteModel($id)){
			$log_data = array(
					'user_id'  => $this->session->userdata('user_id'),
					'table_id' => $id,
					'message'  => 'Piece Deleted'
				);
				$this->log_model->insert_log($log_data);
			redirect('pieces','refresh');
		}
		else{
			$this->session->set_flashdata('fail', 'Piece can not be Deleted.');
			redirect("pieces",'refresh');
		}
	}
	/*
		this function call CSV file view
	*/
	public function import(){
		$this->load->view('pieces/import');
	}
	/*
		this  function get csv file data
	*/
	public function import_csv(){
        $update_records = $this->input->post('update_records');
        $filename		= $_FILES["csv"]["tmp_name"];

        if($_FILES["csv"]["size"] > 0)
        {
            $file = fopen($filename, "r");

            for ($lines = 0; $data = fgetcsv($file,1000,",",'"'); $lines++)
            {


                if ($lines == 0){
                	if(sizeof($data)!=13){
						if(sizeof($data)<13){
							fclose($file);
	        				$this->session->set_flashdata('fail', 'Few columns are missing in uploaded file.');
							redirect("pieces/import",'refresh');
						}else{
							fclose($file);
	        				$this->session->set_flashdata('fail', 'There are few extra columns are available in uploaded file.');
							redirect("pieces/import",'refresh');
						}

					}else if(
								($data[0] != "Code") ||
								($data[1] != "Name") ||
								($data[2] != "Hsn Sac Code") ||
								($data[3] != "Unit") ||
								($data[4] != "Size") ||
								($data[5] != "Cost") ||
								($data[6] != "Price") ||
								($data[7] != "Opening Qty") ||
								($data[8] != "Alert Quantity") ||
								($data[9] != "Details") ||
								($data[10] != "IGST") ||
								($data[11] != "CGST") ||
								($data[12] != "SGST")
							){

        				fclose($file);
        				$this->session->set_flashdata('fail', 'File is not having proper format as per sample piece file.');
						redirect("pieces/import",'refresh');
					}else{
						continue;
					}
                }

                if($data[10] == null || $data[10] == ""){
                	$igst = 0;
                }else{
                	$igst = $data[10];
                }


                if($data[11] == null || $data[11] == ""){
                	$cgst = 0;
                }else{
                	$cgst = $data[11];
                }


                if($data[12] == null || $data[12] == ""){
                	$sgst = 0;
                }else{
                	$sgst = $data[12];
                }


                $sql = "INSERT INTO `pieces`(
                						`code`,
                						`name`,
                						`hsn_sac_code`,
                						`unit`,
                						`size`,
                						`cost`,
                						`price`,
                						`quantity`,
                						`opening_stock`,
                						`alert_quantity`,
                						`details`,
                						`igst`,
                						`cgst`,
                						`sgst`
                						)
                					VALUES (
                						'".
                						trim($data[0])."','".
                						trim($data[1])."','".
                						trim($data[2])."','".
                						trim($data[3])."','".
                						trim($data[4])."','".
                						trim($data[5])."','".
                						trim($data[6])."','".
                						trim($data[7])."','".
                						trim($data[7])."','".
                						trim($data[8])."','".
                						trim($data[9])."','".
                						trim($igst)."','".
                						trim($cgst)."','".
                						trim($sgst)."')";
                $this->db->query($sql);
                if($id = $this->db->insert_id()){
                	$this->pieces_model->insertOpeningStock($id,$data[7]);
                }else{
                	$error = $this->db->error();

					if ($error['code'] == 1062) {
						if($update_records=="yes"){
							$piece = $this->pieces_model->getRecordByCode(trim($data[0]));
							$this->pieces_model->updateOpeningStock($piece->piece_id,trim($data[7]),$piece->quantity);
						}
					}
                }
            }
            fclose($file);
            $this->session->set_flashdata('success', 'Piecess are imported successfully.');
			redirect("pieces",'refresh');


        }
        else{
            redirect("pieces/import",'refresh');
        }
        redirect('pieces','refresh');
	}
	/*
		generate basr code
	*/
	function barcode($code=100)
	{
	    $file = Zend_Barcode::draw('code128', 'image', array('text' => $code), array());
	   	$code = time().$code;
	   	$store_image = imagepng($file,"./assets/images/barcode/{$code}.png");
	   	return   base_url('assets/images/barcode/').$code.'.png';

	}
	/*
		call barcode list view
	*/
	public function piecess_barcode(){
		$data['data'] = $this->pieces_model->getBarcode();
		$this->load->view('pieces/barcode',$data);
	}
	function code_exists($code) {
		if($this->pieces_model->codeExist($code)){
			$this->form_validation->set_message('code_exists', 'Code Already Exist');
			return false;
		}
		else{
			return true;
		}
	}
	function alpha_dash_space($str) {
		if (! preg_match("/^([-a-zA-Z0-9_ ])+$/i", $str))
	    {
	        $this->form_validation->set_message('alpha_dash_space', 'The %s field may only contain alpha-numeric characters, spaces, underscores, and dashes.');
	        return FALSE;
	    }
	    else
	    {
	        return TRUE;
	    }
	}
}
?>
