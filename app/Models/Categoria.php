<?php 
namespace App\Models;

use CodeIgniter\Model;
use Model\ActiveRecord;

class Categoria extends Model{
    protected $table = 'categoria';
    // Uncomment below if you want add primary key
    protected $primaryKey = 'id';
    protected $allowedFields = ['id','nombre'];
}