<?php
namespace App\Database\Seeds;
use CodeIgniter\Database\Seeder;
class Fa3Seeder extends Seeder {
 public function run() {
  $this->db->table('customers')->insertBatch([['full_name'=>'Sample Customer','email'=>'sample@example.com','phone'=>'09170000000'],['full_name'=>'Another Customer','email'=>'another@example.com','phone'=>null]]);
  $this->db->table('users')->insertBatch([['username'=>'staff','full_name'=>'Sample Staff'],['username'=>'cashier','full_name'=>'Sample Cashier']]);
 }
}
