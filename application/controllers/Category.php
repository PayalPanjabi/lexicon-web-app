<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Category extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
    }

    public function index()
    {
        if (!$this->rbac->hasPrivilege('student_categories', 'can_view')) {
            access_denied();
        }
        $this->session->set_userdata('top_menu', 'Student Information');
        $this->session->set_userdata('sub_menu', 'category/index');
        $data['title']        = 'Category List';
        $admin = $this->session->userdata('admin');
        $school_id = $admin['sch_id'];
        $category_result      = $this->category_model->get_record_by_sch($school_id);
        // print_r($category_result);die;
        $data['categorylist'] = $category_result;
        $this->load->view('layout/header', $data);
        $this->load->view('category/categoryList', $data);
        $this->load->view('layout/footer', $data);
    }

    public function view($id)
    {

        // echo "tetststst";die;
        if (!$this->rbac->hasPrivilege('student_categories', 'can_view')) {
            access_denied();
        }
        $data['title']    = 'Category List';
        $category         = $this->category_model->get($id);
        $data['category'] = $category;
        $this->load->view('layout/header', $data);
        $this->load->view('category/categoryShow', $data);
        $this->load->view('layout/footer', $data);
    }

    public function delete($id)
    {
        if (!$this->rbac->hasPrivilege('student_categories', 'can_delete')) {
            access_denied();
        }
        $data['title'] = 'Category List';
        $this->category_model->remove($id);
        $this->session->set_flashdata('msgdelete', '<div class="alert alert-success text-left">' . $this->lang->line('delete_message') . '</div>');
        redirect('category/index');
    }

    public function create()
    {
        
        if (!$this->rbac->hasPrivilege('student_categories', 'can_add')) {
            access_denied();
        }
        $data['title']        = 'Add Category';
        $category_result      = $this->category_model->get();
        $data['categorylist'] = $category_result;
        $this->form_validation->set_rules('category', $this->lang->line('category'), 'trim|required|xss_clean');
        if ($this->form_validation->run() == false) {
            $this->load->view('layout/header', $data);
            $this->load->view('category/categoryList', $data);
            $this->load->view('layout/footer', $data);
        } else {

            $admin = $this->session->userdata('admin');
            $school_id = $admin['sch_id'];
            // $data_insert['sch_id'] = $school_id;

            $data = array(
                'category' => $this->input->post('category'),
                'sch_id' =>  $school_id,
            );

            $this->category_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">' . $this->lang->line('success_message') . '</div>');
            redirect('category/index');
        }
    }

    public function edit($id)
    {
        if (!$this->rbac->hasPrivilege('student_categories', 'can_edit')) {
            access_denied();
        }
        $data['title']        = 'Edit Category';
        $category_result      = $this->category_model->get();
        $data['categorylist'] = $category_result;
        $data['id']           = $id;
        $category             = $this->category_model->get($id);
        $data['category']     = $category;
        $this->form_validation->set_rules('category', $this->lang->line('category'), 'trim|required|xss_clean');
        if ($this->form_validation->run() == false) {
            $this->load->view('layout/header', $data);
            $this->load->view('category/categoryEdit', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $data = array(
                'id'       => $id,
                'category' => $this->input->post('category'),
            );
            $this->category_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">' . $this->lang->line('update_message') . '</div>');
            redirect('category/index');
        }
    }

}
