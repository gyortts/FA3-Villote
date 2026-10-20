<?php
namespace App\Controllers;
use App\Models\CustomerModel;
class CustomersController extends BaseController {
 public function index() { return view('customers/index',['rows'=>(new CustomerModel())->orderBy('id','DESC')->findAll()]); }
 public function new() { return view('customers/form',['customer'=>null,'errors'=>[]]); }
 public function create() {
  $rules=['full_name'=>'required|max_length[150]','email'=>'required|valid_email|max_length[190]','phone'=>'permit_empty|max_length[40]'];
  if (!$this->validate($rules)) return view('customers/form',['customer'=>null,'errors'=>$this->validator->getErrors()]);
  (new CustomerModel())->insert($this->request->getPost(['full_name','email','phone']));
  return redirect()->to('/customers')->with('success','Customer added.');
 }
 public function edit($id) { $customer=(new CustomerModel())->find($id); if (!$customer) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(); return view('customers/form',['customer'=>$customer,'errors'=>[]]); }
 public function update($id) {
  $model=new CustomerModel(); $customer=$model->find($id); if (!$customer) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
  $rules=['full_name'=>'required|max_length[150]','email'=>'required|valid_email|max_length[190]','phone'=>'permit_empty|max_length[40]'];
  if (!$this->validate($rules)) return view('customers/form',['customer'=>$customer,'errors'=>$this->validator->getErrors()]);
  $model->update($id,$this->request->getPost(['full_name','email','phone']));
  return redirect()->to('/customers')->with('success','Customer updated.');
 }
}
