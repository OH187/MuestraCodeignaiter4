<?php 
namespace App\Models;

use CodeIgniter\Model;

class Zapato extends Model{
    protected $table = 'zapato';
    // Uncomment below if you want add primary key
    protected $primaryKey = 'id';
    protected $allowedFields = ['codigoestilo', 'tipomaterial', 'categoria_id'];

}