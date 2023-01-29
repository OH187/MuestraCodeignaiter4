<?php

namespace App\Controllers;

use App\Models\Zapato;
use App\Models\Categoria;
use CodeIgniter\Controller;
use CodeIgniter\Security\Security;

class ZapatoController extends Controller
{

    public function index()
    {
        //Agrego las dos tablas y busco los datos si quiero tener la informacion en la mismam pagina
        $categoria = new Categoria();
        $zapato = new Zapato();
        $datos['zapatos'] = $zapato->orderBy('id', 'ASC')->findAll(); //Ordenamos id en ascendente y buscamos toda la info
        $datos['categorias'] = $categoria->orderBy('id', 'ASC')->findAll(); //Ordenamos id en ascendente y buscamos toda la info


        $datos['cabecera'] = view('templates/cabecera'); //pasando la vista
        $datos['pie'] = view('templates/pie'); //pasando la vista

        return view('zapato/listar', $datos);
    }

    //FUNCION CREAR
    public function crear()
    {
        $categoria = new Categoria();
        $datos['categorias'] = $categoria->orderBy('id', 'ASC')->findAll(); //Ordenamos id en ascendente y buscamos toda la info
        $zapato = new Zapato();
        $datos['zapatos'] = $zapato->orderBy('id', 'ASC')->findAll(); //Ordenamos id en ascendente y buscamos toda la info

        $datos['cabecera'] = view('templates/cabecera'); //pasando la vista
        $datos['pie'] = view('templates/pie'); //pasando la vista

        return view('zapato/crear', $datos);
    }


                //FUNCION GUARDAR
    public function guardar()
    {

        $zapato = new Zapato();
        //validacion
        $codigo = $this->request->getVar('codigoestilo');
        $material = $this->request->getVar('tipomaterial');
        $idcategoria = $this->request->getVar('categoria_id');
       

        $validacion = $this->validate([
            'codigoestilo' => 'trim|required|min_length[3]',
            'tipomaterial' => 'trim|required|min_length[5]',
            'categoria_id' => 'required',
        ]);
        if (!$validacion) {
            $session = session();
            $session->setFlashdata('mensaje', 'Faltan campos por llenar');
            return redirect()->back()->withInput(); //retornamos con valores
        }
        // $path = $security->sanitizeFilename($request->getVar('filepath'));
        $security = \Config\Services::security();
        //$codigo = $this->$security->xss_clean($codigo);
        //$material = $this->$security->xss_clean($material);
        //$idcategoria = $this->$security->xss_cleanr($idcategoria);

        $codigo = $this->$security->sanitizeFilename($codigo->getVar('codigoestilo'));
        $material = $this->$security->sanitizeFilename($material->getVar('tipomaterial'));
        $idcategoria = $this->$security->sanitizeFilename($idcategoria->getVar('categoria_id'));

        $datos = [
            'codigoestilo' => $codigo,
            'tipomaterial' => $material,
            'categoria_id' => $idcategoria
        ];



        //$builder = $db->table('categoria');
        //$query   = $builder->get(); 

        //query
        /*$db = \Config\Database::connect();
        $sql = "INSERT INTO table (categoria) VALUES (". 
                $db->escape($datos). 
                ")";*/

        //inserccion
        //$zapato->db('zapato')->insert($sql);
        $zapato->db->table('zapato')->insert($datos);

        return $this->response->redirect(site_url('/listar')); //redireccionamos
    }

                            //FUNCION BORRAR
    public function borrar($id = null)
    {
        $zapato = new Zapato();
        $zapato->where('id', $id)->delete($id);

        return $this->response->redirect(site_url('/listar')); //redireccionamos
    }

                    // FUNCION EDITAR (solo para mostrar los datos)
    public function editar($id = null)
    {
        //Agrego las dos tablas y busco los datos si quiero tener la informacion en la mismam pagina
        $categoria = new Categoria();
        $zapato = new Zapato();
        //$datos['zapatos'] = $zapato->orderBy('id', 'ASC')->findAll(); //Ordenamos id en ascendente y buscamos toda la info
        $datos['categorias'] = $categoria->orderBy('id', 'ASC')->findAll(); //Ordenamos id en ascendente y buscamos toda la info
        $datos['zapato'] = $zapato->where('id', $id)->first(); //obtenemos el primer id(si hubiese varios iguales)

        $datos['cabecera'] = view('templates/cabecera'); //pasando la vista
        $datos['pie'] = view('templates/pie'); //pasando la vista

        return view('zapato/editar', $datos);
    }


                //FUNCION ACTUALIZAR (guardar datos actualizados)
    public function actualizar()
    {
        $zapato= new Zapato();
       
        //DATOS A OBTENER
        $datos = [
            'codigoestilo' => $this->request->getVar('codigoestilo'),
            'tipomaterial' => $this->request->getVar('tipomaterial'),
            'categoria_id' => $this->request->getVar('categoria_id')
        ];

        $id = $this->request->getVar('id');

        //Validacion
        $validacion = $this->validate([
            'codigoestilo' => 'trim|required|min_length[3]',
            'tipomaterial' => 'trim|required|min_length[5]',
            'categoria_id' => 'required',
        ]);
        if (!$validacion) {
            $session = session();
            $session->setFlashdata('mensaje', 'Faltan campos por llenar');
            return redirect()->back()->withInput(); //retornamos con valores
        }

       // $db = \Config\Database::connect();
        /*$sql = "UPDATE (categoria) SET (". 
                $db->escape($datos). 
                ")";
            */
        //inserccion
       // $zapato->db('zapato')->insert($sql);

        //actualizamos el dato
        $zapato->set(
            'codigoestilo', $datos['codigoestilo'],
            'tipomaterial', $datos['tipomaterial'],
            'categoria_id', $datos['categoria_id']
            )->where('id', $id)->update();
        
        return $this->response->redirect(site_url('/listar')); //redireccionamos
    }
}
