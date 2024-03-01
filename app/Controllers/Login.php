<?php

namespace App\Controllers;
use App\Models\M_login;
use App\Models\M_model;
class Login extends BaseController
{

   protected function isLoggedIn()
   {
        return session()->has('id');
    }

    public function index()
    {
        if ($this->isLoggedIn()) {
            return redirect()->to('dashboard');
        }

        $data['title']='Login';
        echo view ('partial/header_datatable', $data);
        echo view('login/view');
        echo view('partial/footer_datatable');
    }

    public function aksi_login()
	{
		$u=$this->request->getPost('username');
		$p=$this->request->getPost('pswd');
		$model= new M_model();
		$data=array(
			'username'=>$u,
			'password'=>md5($p)

		);
		$cek=$model->getWhere2('user', $data);
		if ($cek>0) {
			session()->set('id', $cek['id_user']);
			session()->set('username', $cek['username']);
			session()->set('level', $cek['level']);
			return redirect()->to('dashboard');
		}else {
			return redirect()->to('/');
		}
	}
    public function log_out()
    {
        session()->destroy();
        return redirect()->to('login');
    }
}