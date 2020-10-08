<?php

require_once APPPATH . '/libraries/REST_Controller.php';

abstract class AbstractOverall extends REST_Controller
{

    protected $model;

    protected $callingMethod;

    protected $module;

    protected $withoutToken = false;

    protected $columns = [];

    protected $headers = [];

    protected $decode;

    public function __construct()
    {
        parent::__construct();
        $this->module        = $this->setModel();
        $this->model         = $this->module . '_m';
        $this->callingMethod = 'get_order_by_' . $this->module;
        $this->language();
    }

    /**
     * Model Name
     *
     * @return string
     */
    abstract public function setModel();

    /**
     * Show Header for API
     *
     *  databaseColumnName => Language through "$this->header" property
     */
    abstract public function language();

    /**
     * Getting Module list
     *
     * @return REST_Controller response
     * @return [
     *      'status' => bool,
     *      'token' => string,
     *      'data' => array,
     *      'headers' => array,
     *      'count' => integer,
     *      'message' => string // when status is false
     * ]
     */
    public function index_get()
    {
        $f = false;
        if (!$this->withoutToken) {
            $this->decode = $this->_check_jwt();
            if (isset($this->decode['userdata']) && count($this->decode['userdata'])) {
                $f = true;
            }
        } else {
            $f = true;
        }

        if ($f) {
            $model  = $this->model;
            $method = $this->callingMethod;

            $this->load->model($model);
            $this->load->library('session');

            if (!isset($this->decode['userdata'])) {
                $this->decode['userdata'] = [];
            }

            foreach ($this->decode['userdata'] as $key => $value) {
                $this->session->set_userdata($key, $value);
            }

            $this->db->select($this->columns);
            $all = $this->$model->$method($this->getDataManipulate($this->get()));

            if ($this->object_called == 'index') {
                $this->object_called = 'list';
            }

            $this->data["status"]  = true;
            $this->data["count"]   = count($all);
            $this->data['headers'] = isset($this->headers[ $this->object_called ]) ? $this->headers[ $this->object_called ] : $this->headers;
            $this->data['data']    = $all;
            $permission            = $this->permission($this->decode['userdata']);
            $this->data['token']   = $this->token;

            if (is_array($this->data['data']) && $permission) {
                // Set the response and exit
                $this->response($this->data, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
                // Set the response and exit
                $this->response([
                    'status'  => false,
                    'message' => $permission == false ? 'Permission Denied' : 'Not Found',
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        } else {
            $this->response([
                'status'  => false,
                'message' => 'Not found',
            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
        }
    }

    /**
     * Manipulate Get method url data
     *
     * @param $getData
     * @return mixed
     */
    public function getDataManipulate($getData)
    {
        return $getData;
    }

    /**
     * Checking Permission
     *
     * @param $userdata
     * @return bool
     */
    public function permission($userdata)
    {
//        dd($this->decode);
        $this->decode = json_decode(json_encode($this->decode), true);
        $userdata     = (array) $userdata;
        $this->load->model('permission_m');

        $module = $this->module;
        $action = $this->object_called;

        if ($action == 'index' || $action == 'list' || $action == false) {
            $permission = $module;
        } else {
            $permission = $module . '_' . $action;
        }

        $allmodules = [];
        if ($userdata['usertypeID'] == 1 && $userdata['loginuserID'] == 1) {
            if (isset($userdata['loginuserID']) && !isset($this->decode['get_permission'])) {
                $allmodules                     = $this->permission_m->get_permission();
                $this->decode['get_permission'] = true;
            }
        } else {
            if (isset($userdata['loginuserID']) && !isset($this->decode['get_permission'])) {
                $allmodules                     = $this->permission_m->get_modules_with_permission($userdata['usertypeID']);
                $this->decode['get_permission'] = true;
            }
        }
        if (count($allmodules)) {
//            dd($this->decode);
            foreach ($allmodules as $key => $allmodule) {
                $this->decode['master_permission_set'][ trim($allmodule->name) ] = $allmodule->active;
                if ($allmodule->name == 'report') {
                    $this->decode['master_permission_set'][ trim($allmodule->name) ]  = $allmodule->active;
                    $this->decode['master_permission_set']['report/studentreport']    = $allmodule->active;
                    $this->decode['master_permission_set']['report/classreport']      = $allmodule->active;
                    $this->decode['master_permission_set']['report/attendancereport'] = $allmodule->active;
                    $this->decode['master_permission_set']['report/certificate']      = $allmodule->active;
                }
            }
            $this->decode['master_permission_set']['take_exam'] = 'yes';
            $this->decode['get_permission']                     = true;
        }
        if ($userdata['usertypeID'] == 3) {
            $this->decode['master_permission_set']['take_exam'] = 'yes';
        }
//        dd($this->decode);
//        dd($this->decode);
        if ($this->decode['master_permission_set'][ $permission ] == 'yes') {
            $this->data['token'] = $this->jwt_encode($this->decode);

            return true;
        }

        return false;
    }

    public function setCallingMethod($method)
    {
        $this->callingMethod = $method;
    }

    /**
     * If you want to token less data
     *
     * @param $bool
     * @return $this
     */
    public function withoutToken($bool)
    {
        $this->withoutToken = $bool;

        return $this;
    }
}


?>
