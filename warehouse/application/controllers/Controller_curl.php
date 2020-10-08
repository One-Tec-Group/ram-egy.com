<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Controller_curl extends CI_Controller {
	public function __construct() {

		parent::__construct();
		//  Calling cURL Library
		$this->load->library('curl');
		if ( ! $this->session->userdata('loggedin'))
        { 
            redirect('auth/login');
        }
		

	}

	public function index(){

		$this->curl->create('http://localhost/invento-gst/api/v1/list_table');	
		$this->curl->option('buffersize', 10);
		$this->curl->option('returntransfer', 1);
		$this->curl->option('followlocation', 1);
		$this->curl->option('HEADER', false);
		$this->curl->option('connecttimeout', 600);	
		$data = $this->curl->execute();
		
		$json_decoded = json_decode($data,true);
		
		//echo sizeof($json_decoded['row']); // size of json encoded data

		// print list of table
		
		$INT_DATA_TYPE_ARRAY = array("TINYINT","SMALLINT","MEDIUMINT","INT","BIGINT","DECIMAL","FLOAT","DOUBLE","REAL","BIT","BOOLEAN","SERIAL");
		$INT_DATA_TYPE_ARRAY = array_map('strval', $INT_DATA_TYPE_ARRAY);
		$STRING_DATA_TYPE_ARRAY = array("CHAR","VARCHAR","TINYTEXT","MEDIUMTEXT","LONGTEXT","BINARY","VARBINARY");
		$STRING_DATA_TYPE_ARRAY = array_map('strval', $STRING_DATA_TYPE_ARRAY);

		// table list
		$TABLES_LOCALHOST = array();
		$TABLES_LOCALHOST = $this->list_table();
		$primary_key = null;

		// List tables from API
		for($i = 0 ; $i < sizeof($json_decoded['row']); $i++){
	
			$list_fields=$json_decoded['row'][$i]['field'];
			$tmp=array();
			foreach ($list_fields as $key => $value) {
				$tmp[] = $value['fields'];

			}
			if(in_array(strval($json_decoded['row'][$i]['table']),$TABLES_LOCALHOST)){
				
				//number of fields from single table
				$NO_OF_FIELDS=array();
				$NO_OF_FIELDS=$this->num_of_fields_single_table($json_decoded['row'][$i]['table']);
				//echo $NO_OF_FIELDS;

				//list of fields from single table
				$LIST_OF_FIELDS=array();
				$LIST_OF_FIELDS=$this->list_of_fields_single_table($json_decoded['row'][$i]['table']);
				//print_r($LIST_OF_FIELDS);

				$no_fields=$json_decoded['row'][$i]['field'];
				
				$NO_OF_FIELDS_API=0;
				foreach ($no_fields as $key => $value) {						
					$NO_OF_FIELDS_API++;
				}
				/*echo "<br/>";
				echo "from Api : ".$NO_OF_FIELDS_API."<br/>";
				echo "from local: ".$NO_OF_FIELDS."<br/>";*/

				//compare no of fields from single table
				if($NO_OF_FIELDS_API!=$NO_OF_FIELDS)
				{	
					//compare list of fields form single table
					$diff_array = array();
					for($i1 = 0 ; $i1 < sizeof($tmp) ; $i1++){
						if(!(in_array($tmp[$i1], $LIST_OF_FIELDS))){
							$diff_array[] = $tmp[$i1]; 	
						}
					}
					//Alter tble
					$alter_pre_query = "ALTER TABLE ".$json_decoded['row'][$i]['table'] ; 
					$alter_sub_query = null;

					for($j1 = 0 ; $j1 < sizeof($json_decoded['row'][$i]['field']) ; $j1++){
						if(in_array($json_decoded['row'][$i]['field'][$j1]['fields'], $diff_array)){
							$alter_sub_query .= " ADD ".$json_decoded['row'][$i]['field'][$j1]['fields']." ".$json_decoded['row'][$i]['field'][$j1]['data type'].", ";
						}
					}
					// remove last , from string
					$alter_sub_query = rtrim($alter_sub_query,", ");							
					echo $alter_query = $alter_pre_query. $alter_sub_query;
					echo "<br/>";
					//exexute alter query
					if($this->execute_query($alter_query))
					{
						echo "<br/>Table Modified Successfully<br/>";
					}
					else{
						echo "Table Not Modified";
					}
				}else{

				}
			}
			else{
				//create tbale
				$create_table = "CREATE TABLE IF NOT EXISTS `".$json_decoded['row'][$i]['table']."` (";
							
				for($j = 0 ; $j < sizeof($json_decoded['row'][$i]['field']) ; $j++){
					$create_table .=  " `".$json_decoded['row'][$i]['field'][$j]['fields'];
					$create_table .= "` ".$json_decoded['row'][$i]['field'][$j]['data type'];

						// IF FIELDS IS HAVING DEFAULT VALUE
						if($json_decoded['row'][$i]['field'][$j]['null'] == "NO" || $json_decoded['row'][$i]['field'][$j]['null'] == "YES"){
								$create_table .= " NOT NULL";
							// FOR DEFAULT VALUE
							if($json_decoded['row'][$i]['field'][$j]['default']){
								
								if($json_decoded['row'][$i]['field'][$j]['default'] == "CURRENT_TIMESTAMP"){
										$create_table .= " DEFAULT ".$json_decoded['row'][$i]['field'][$j]['default'];	
								}else{
									
										$datatype_element[] = array();
										$datatype_element = explode("(",$json_decoded['row'][$i]['field'][$j]['data type']);

									  // check if default data type if numeric
									  if(in_array(strtoupper($datatype_element[0]), $INT_DATA_TYPE_ARRAY)){
									  		$create_table .= " DEFAULT ".$json_decoded['row'][$i]['field'][$j]['default'];	
									  }
									  // check if default data type if string 
									  else if(in_array(strtoupper($datatype_element[0]), $STRING_DATA_TYPE_ARRAY)){
									  		$create_table .= " DEFAULT '".$json_decoded['row'][$i]['field'][$j]['default']."'";	
									  }	

								} 
							}
							//FOR EXTRA
							$create_table .= " ".strtoupper($json_decoded['row'][$i]['field'][$j]['extra']). ", ";
							// FOR PRIMARY KEY
							if($json_decoded['row'][$i]['field'][$j]['key']=="PRI"){
								$primary_key = " ".$json_decoded['row'][$i]['field'][$j]['fields'];
								
							}
						}	
						else{
							$create_table .= " DEFAULT NULL";
							$create_table .= " ".$json_decoded['row'][$i]['field'][$j]['extra']." ,";
							if($json_decoded['row'][$i]['field'][$j]['key']=="PRI"){
								$create_table .= " PRIMARY KEY (`".$json_decoded['row'][$i]['field'][$j]['fields']."`)";
							}	
						}	
						//$create_table .= " PRIMARY KEY (`".trim($primary_key)."`)";
						//echo $create_table."<br>";
						//$this->execute_query($json_decoded['row'][$i]['table'],$create_table);
				}
				$create_table .= " PRIMARY KEY (`".trim($primary_key)."`)";
				$create_table .=") ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;";
				echo $create_table;
				
				$this->execute_query($create_table);
			}
		}
		//echo "Database Created";
	}

	/*
		get execute query result
	*/
	public function execute_query($create_table){	

		return $this->db->query($create_table);			
	}

	/*
		get the list of fields from api
	*/
	public function fields_from_table_api($field_array){
		
		for($j = 0 ; $j < sizeof($field_array) ; $j++){
			$temp = array();	
			$temp[] = $field_array[$j]['fields'];
		}	
	}

	/*
		get the list of field from single from server using api
	*/
	public function list_table_api()
	{

		$data="SHOW tables";
      	$result=$this->db->query($data);
    
        $temp = array();
        if($result->num_rows()>0){
			
			$data = $result->result();
			foreach ($data as $key => $value) {
				$temp[] = $value->Tables_in_gsfdana1;
			}
			
		}
		return $temp;
	}

	/*
		get list of of table from localhost
	*/
	public function list_table()
	{

		$data="SHOW tables";
      	$result=$this->db->query($data);
    
        $temp = array();
        if($result->num_rows()>0){
			
			$data = $result->result();
			foreach ($data as $key => $value) {
				$temp[] = $value->Tables_in_gsfdana1;
			}
			
		}
		return $temp;
	}

	/*
		get number of fields from single table
	*/
	public function num_of_fields_single_table($table_name)
	{
		$sql="SELECT * FROM ".$table_name;
  		$result= $this->db->query($sql);
  		return $result->num_fields();
	}

	/*
		get list of fields from single table
	*/
	public function list_of_fields_single_table($table_name)
	{
		$sql = "SHOW COLUMNS FROM ". $table_name;
		$result = $this->db->query($sql);
		$temp = array();

		if($result->num_rows()>0){
			
			$data = $result->result();
			foreach ($data as $key => $value) {
				$temp[] = $value->Field;
			}
		}
		return $temp;
	}

	public function get_file()
	{
		$output_filename = "download/testfile.php";

	    //$host = "http://www.xcontest.org/track.php?t=2avxjsv1.igc";
	    $host = "http://vaksys.com/invento/license.txt?t=2avxjsv1.igc";
	    //$host = "http://vaksys.com/invento/install/assets/inventory.sql?t=2avxjsv1.igc";
	   
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $host);
	    curl_setopt($ch, CURLOPT_VERBOSE, 1);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_AUTOREFERER, false);
	    curl_setopt($ch, CURLOPT_REFERER, "http://vaksys.com/");
	    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
	    curl_setopt($ch, CURLOPT_HEADER, 0);
	    $result = curl_exec($ch);
	    curl_close($ch);

	    //print_r($result); // prints the contents of the collected file before writing..

	    // the following lines write the contents to a file in the same directory (provided permissions etc)
	    $fp = fopen($output_filename, 'w');
	    fwrite($fp, $result);
	    fclose($fp);

	    //echo "File Download";
	}

}
?>