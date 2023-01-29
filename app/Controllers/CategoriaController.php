<?php

namespace App\Controllers;

use App\Models\Categoria;
use CodeIgniter\Controller;

class CategoriaController extends Controller
{


    //FUNCION CREAR
    public function crear()
    {
        $datos['cabecera'] = view('templates/cabecera'); //pasando la vista
        $datos['pie'] = view('templates/pie'); //pasando la vista

        return view('categoria/crear', $datos);
    }


                //FUNCION GUARDAR
    public function guardar()
    {
        $categoria = new Categoria();
        //validacion
        $validacion = $this->validate([
            'nombre' => 'required|min_length[3]'
        ]);
        if (!$validacion) {
            $session = session();
            $session->setFlashdata('mensaje', 'Faltan campos por llenar');
            return redirect()->back()->withInput(); //retornamos con valores
        }
        // $path = $security->sanitizeFilename($request->getVar('filepath'));
        $datos = [
            'nombre' => $this->request->getVar('nombre'),
        ];

        //query
        $db = \Config\Database::connect();
        $sql = "INSERT INTO table (categoria) VALUES (". 
                $db->escape($datos['nombre']). 
                ")";
        //insercion
        //$categoria->db('categoria')->insert($sql);
        $categoria->insert($datos);

        return $this->response->redirect(site_url('/listar')); //redireccionamos
    }

                            //FUNCION BORRAR
    public function borrar($id = null)
    {
        $categoria = new Categoria();
        $categoria->where('id', $id)->db('categoria')->delete($id); //db

        return $this->response->redirect(site_url('/listar')); //redireccionamos
    }

                    // FUNCION EDITAR (solo para mostrar los datos)
    public function editar($id = null)
    {
        $categoria = new Categoria();
        $datos['categoria'] = $categoria->where('id', $id)->first(); //obtenemos el primer id(si hubiese varios iguales)

        $datos['cabecera'] = view('templates/cabecera'); //pasando la vista
        $datos['pie'] = view('templates/pie'); //pasando la vista

        return view('categoria/editar', $datos);
    }


                //FUNCION ACTUALIZAR (guardar datos actualizados)
    public function actualizar()
    {
        $categoria = new Categoria();
       
        //DATOS A OBTENER
        $datos = [
            'nombre' => $this->request->getVar('nombre')
        ];

        $id = $this->request->getVar('id');

        //Validacion
        $validacion = $this->validate([
            'nombre' => 'trim|required|min_length[3]',
        ]);
        if (!$validacion) {
            $session = session();
            $session->setFlashdata('mensaje', 'Faltan campos por llenar');
            return redirect()->back()->withInput(); //retornamos con valores
        }

        //actualizamos el dato
        $categoria->set(
            'nombre', $datos['nombre'],
            )->where('id', $id)->update();
        
        return $this->response->redirect(site_url('/listar')); //redireccionamos
    }
}
