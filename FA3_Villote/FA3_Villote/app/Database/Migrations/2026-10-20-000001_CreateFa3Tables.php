<?php
namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;
class CreateFa3Tables extends Migration {
 public function up() {
  $this->forge->addField(['id'=>['type'=>'INT','unsigned'=>true,'auto_increment'=>true],'full_name'=>['type'=>'VARCHAR','constraint'=>150],'email'=>['type'=>'VARCHAR','constraint'=>190],'phone'=>['type'=>'VARCHAR','constraint'=>40,'null'=>true],'created_at'=>['type'=>'DATETIME','null'=>true],'updated_at'=>['type'=>'DATETIME','null'=>true]]);
  $this->forge->addKey('id',true); $this->forge->createTable('customers',true);
  $this->forge->addField(['id'=>['type'=>'INT','unsigned'=>true,'auto_increment'=>true],'username'=>['type'=>'VARCHAR','constraint'=>80],'full_name'=>['type'=>'VARCHAR','constraint'=>150],'avatar'=>['type'=>'VARCHAR','constraint'=>255,'null'=>true],'created_at'=>['type'=>'DATETIME','null'=>true],'updated_at'=>['type'=>'DATETIME','null'=>true]]);
  $this->forge->addKey('id',true); $this->forge->addUniqueKey('username'); $this->forge->createTable('users',true);
 }
 public function down() { $this->forge->dropTable('users',true); $this->forge->dropTable('customers',true); }
}
