<?php
namespace App\Controllers;
use App\Models\UserModel;
class UsersController extends BaseController {
 public function index() { return view('users/index',['rows'=>(new UserModel())->orderBy('id','DESC')->findAll()]); }
 public function new() { return view('users/form',['user'=>null,'errors'=>[]]); }
 private function rules(?array $user=null): array {
  $unique=$user ? 'is_unique[users.username,id,'.$user['id'].']' : 'is_unique[users.username]';
  return ['username'=>'required|max_length[80]|alpha_dash|'.$unique,'full_name'=>'required|max_length[150]'];
 }
 public function create() {
  if (!$this->validate($this->rules())) return view('users/form',['user'=>null,'errors'=>$this->validator->getErrors()]);
  (new UserModel())->insert($this->request->getPost(['username','full_name']));
  return redirect()->to('/users')->with('success','User added.');
 }
 public function edit($id) { $user=(new UserModel())->find($id); if (!$user) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(); return view('users/form',['user'=>$user,'errors'=>[]]); }
 public function update($id) {
  $model=new UserModel(); $user=$model->find($id); if (!$user) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
  $errors=[];
  if (!$this->validate($this->rules($user))) $errors=$this->validator->getErrors();
  $file=$this->request->getFile('avatar'); $newName=null;
  if ($file && $file->getError() !== UPLOAD_ERR_NO_FILE) {
   if (!$file->isValid()) $errors['avatar']='The upload failed.';
   elseif ($file->getSize()>2097152) $errors['avatar']='Avatar must be 2 MB or less.';
   elseif (!in_array($file->getMimeType(),['image/jpeg','image/png'],true)) $errors['avatar']='Use a JPG or PNG image.';
   elseif (!extension_loaded('gd')) $errors['avatar']='Enable the PHP GD extension to process avatars.';
   else {
    $newName=bin2hex(random_bytes(16)).'.jpg';
    $folder=FCPATH.'uploads/avatars/';
    if (!is_dir($folder) && !mkdir($folder,0755,true) && !is_dir($folder)) $errors['avatar']='Cannot create upload directory.';
    else {
     try { service('image')->withFile($file->getTempName())->fit(200,200,'center')->convert(IMAGETYPE_JPEG)->save($folder.$newName,85); }
     catch (\Throwable $e) { $errors['avatar']='Could not prepare image.'; }
    }
   }
  }
  if ($errors) { if ($newName && is_file(FCPATH.'uploads/avatars/'.$newName)) unlink(FCPATH.'uploads/avatars/'.$newName); return view('users/form',['user'=>$user,'errors'=>$errors]); }
  $data=$this->request->getPost(['username','full_name']);
  if ($newName) $data['avatar']=$newName;
  $model->update($id,$data);
  if ($newName && $user['avatar'] && is_file(FCPATH.'uploads/avatars/'.$user['avatar'])) unlink(FCPATH.'uploads/avatars/'.$user['avatar']);
  return redirect()->to('/users')->with('success','User updated.');
 }
}
