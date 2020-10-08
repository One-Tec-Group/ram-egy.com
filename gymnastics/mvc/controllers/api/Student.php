<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'AbstractOverall.php';

class Student extends AbstractOverall
{
    /**
     * Model Name
     *
     * @return string
     */
    public function setModel() {
        return 'student';
    }

    /**
     * Show Header for API
     *
     *  databaseColumnName => Language through "$this->header" property
     */
    public function language()
    {
        $this->headers = [
            'view' => [
                'name' => 'Student Nameaa'
            ],
            'list' => [
                'name' => 'Student Name'
            ]
        ];
    }
}