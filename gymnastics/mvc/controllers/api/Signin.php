<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'AbstractOverall.php';

class Signin extends AbstractOverall
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $models = [ 'setting_m', 'student_m', 'user_m', 'parents_m', 'usertype_m' ];
        foreach ($models as $model) {
            $this->load->model($model);
        }
    }

    public function setModel()
    {
        return 'signin';
    }

    //User JWT authentication to get the toekn

//    public function token_get(...$array)
//    {
//        // $
//        // $this->response($this->input->get(), REST_Controller::HTTP_OK);
//        $this->response($array, REST_Controller::HTTP_OK);
//    }


    public function index_post()
    {


        // dd($this->post());
        if ($this->post('username') && $this->post('password')) {
            $token['username'] = $this->post('username');

            $userdata = $this->user_info($this->post('username'), $this->post('password'));
            
            if (is_array($userdata)) {
                $date                 = new DateTime();
                $token['iat']         = $date->getTimestamp();
                $token['exp']         = $date->getTimestamp() + $this->config->item('jwt_token_expire');
                $token['userdata']    = $userdata;
                $output_data['token'] = $this->jwt_encode($token);
                $this->response($output_data, REST_Controller::HTTP_OK);
            } else {
                $output_data[ $this->config->item('rest_status_field_name') ]  = "invalid_credentials";
                $output_data[ $this->config->item('rest_message_field_name') ] = "Invalid username or password!";
                $this->response($output_data, REST_Controller::HTTP_UNAUTHORIZED);
            }

            

        } else {
            $output_data[ $this->config->item('rest_status_field_name') ]  = "invalid_credentials";
            $output_data[ $this->config->item('rest_message_field_name') ] = "Invalid username or password!";
            $this->response($output_data, REST_Controller::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * Check Login info
     *
     * @param $username
     * @param $password
     * @param int $shipu
     * @return array|bool
     */
    public function user_info($username, $password, $shipu = 1)

    {
        $tables   = [
            'student'     => 'student',
            'parents'     => 'parents',
            'teacher'     => 'teacher',
            'user'        => 'user',
            'systemadmin' => 'systemadmin',
        ];
        $settings = $this->setting_m->get_setting(1);
        $lang     = $settings->language;
//        $defaultschoolyearID = $settings->school_year;
        $defaultschoolyearID = $shipu;
        $array               = [];

        $password = $this->hash($password);
        $userdata = '';
        foreach ($tables as $table) {
            $user = $this->db->get_where($table, [ "username" => $username, "password" => $password, 'active' => 1 ]);
            $data = $user->row();
            if (count($data)) {
                $data->user_primary_key = $table . "ID";
                $userdata               = $data;
                $array['usercolname']   = $table . 'ID';
            }
        }

        if (count($userdata)) {
            $usertype = $this->usertype_m->get_usertype($userdata->usertypeID);
            if (count($usertype)) {

                $data = [
                    "loginuserID"         => $userdata->$array['usercolname'],
                    "name"                => $userdata->name,
                    "email"               => $userdata->email,
                    "usertypeID"          => $userdata->usertypeID,
                    'usertype'            => $usertype->usertype,
                    "username"            => $userdata->username,
                    "photo"               => $userdata->photo,
                    "lang"                => $lang,
                    "defaultschoolyearID" => $defaultschoolyearID,
                    "loggedin"            => true,
                ];


                $this->session->set_userdata($data);

                return $data;
            } else {
                return false;
            }
        } else {

            return false;
        }
    }

    public function hash($string)
    {
        return hash("sha512", $string . config_item("encryption_key"));
    }


}