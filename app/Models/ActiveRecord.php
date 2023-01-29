<?php

namespace Model;

class ActiveRecord{

      //Base de datos. protected porque solamente queremos que este disponible para la clase y 
// static porque no queremos instanciar cada vez que la llamemos, porque la direccion o credenciales serán la misma
protected static $db;
protected static $columnasDB = [];
protected static $tabla = '';

//protected poque solamente se podrá modificar en la clase, static porque no se instanciará
protected static $errores = []; //Areeglo vacío para los errores

//Definir la conexion a la base de datos
public static function setDB($database){
    self::$db = $database;
}

    //Identificar y unir los atributos de la BD o identificar cuales tenemos
    public function atributos(){
        $atributos = [];
        foreach(static::$columnasDB as $columna){
        //Esto permite que si el dato es id, lo deja por alto y continua, porque es un valor que no ingresa el usuario
            if($columna === 'id')continue;
            //Esto le da un formato  a los datos en memoria igual a los datos que necesita la BD
            $atributos[$columna] =  $this->$columna;
        }
        return $atributos;
    }


//Vamos a limpiar los datos antes de guardarlos
public function sanitizarDatos(){
    $atributos = $this->atributos();
    $sanitizado = [];

// self::$db-> este es el codigo relacionado a la base de datos
    //$key = a las llaves o titulos de las columnas y $value = valores 
    foreach($atributos as $key => $value){
        $sanitizado[$key] = self::$db->escape_string($value);
    }
    return $sanitizado;
}

public function guardar(){
    if (!is_null($this->id)) { //Si no es nulo el id, actualiza, si no crea
        //Actualizar si existe el id
        $this->actualizar();
    } else{
        //Si no existe id crea un nuevo registro
        $this->crear();
    }
}


public function crear(){
    //Sanitizando los datos
    $atributos = $this->sanitizarDatos();

    // $string = join(', ', array_keys($atributos));
                    //Insertar en base de datos
    // join permite alinear uno tras otro, array_keys forma un arreglo a partir de las columnas o llaves de la BD
    $query = " INSERT INTO ". static::$tabla . " ("; //Insertará según el valor que tenga la variable $tabla
    $query .= join(', ', array_keys($atributos));  //Esto permite mostrar o alinear los campos como normalmente lo acepta sql
    $query.= " ) VALUES ( ' ";
    $query .= join("', '", array_values($atributos));
    $query .= " ') ";

    $resultado = self::$db->query($query); //Este codigo permite ingresar a la base de datos
    //debuguear es una funcion que se encuentra en el archivo de funciones.php
    
    //Si es corecto el resultado lo indica al usuario
    if ($resultado) {
        //Redireccionar al usuario despues de ingresar los datos
        header("Location: /crear?resultado=1"); //Utilizar poco y solamente cuando no haya codigo html arriba de esta funcion
        
    }
}

public function actualizar(){
    //Sanitizando los datos, siempre antes de interatuar con la BD
    $atributos = $this->sanitizarDatos();

    $valores = [];
    foreach($atributos as $key => $value){
        $valores[] = "{$key}='{$value}'";
    }
      //Atualizar en la base de datoa
    $query = "UPDATE " . static::$tabla . " SET ";
    $query .= join(', ', $valores ); //Divide los valores y los dividirá con una comaa
    $query .= " WHERE id = '" . self::$db->escape_string($this->id). "' "; //Siempre sanitizar los datos antes de ingresar a la BD
    $query .= " LIMIT 1" ; //La cantidad de registros a mostrar

    $resultado = self::$db->query($query);
    
    if ($resultado) {
        //Redireccionar al usuario despues de ingresar los datos
        header('Location: /actualizar?resultado=2'); //Utiliar poco y solamente cuando no haya codigo html arriba de esta funcion
        
    }
}

//Eliminar una propiedad
public function eliminar(){

    $query = "DELETE FROM " . static::$tabla. " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
    $resultado = self::$db->query($query);
    if ($resultado) {
        header('Location: /borrar?resultado=3');
    }
}


//Validacion
public static function getErrores(){
    return static::$errores;
}

public function validar(){
    static::$errores = [];
    return static::$errores;
}

//Selecciona todos los datos o propiedades de la BD
public static function all(){
    $query = "SELECT * FROM " . static::$tabla . " ORDER BY id DESC"; //static me permite obtener el valor de la variable donde haya una heredad de esta clase
    $resultado = self::consultarSQL($query);

    return $resultado;
}

//Obtiene ceirta cantidad limitada de registros
//Selecciona todos los datos o propiedades de la BD
public static function get($cantidad){
    $query = "SELECT * FROM " . static::$tabla . " ORDER BY id DESC LIMIT " . $cantidad; //static me permite obtener el valor de la variable donde haya una heredad de esta clase
    $resultado = self::consultarSQL($query);

    return $resultado;
}

//Busca un registro por su id
public static function find($id){
    //Cosntruyendo el query o la consulta a la base de datos
$query= "SELECT * FROM ". static::$tabla . " WHERE id = ${id} "; //static porque las clases hijas buscarán en sus regitros propios


$resultado = self::consultarSQL($query); //Aqui de una sola vez lo pasamos a objeto
    return array_shift($resultado); //array_shift retorna el primer elemento de un arreglo
}


//Vamos a consultar la base de datos
public static function consultarSQL($query){
    //Consultar la BD
    $resultado = self::$db->query($query);

    //Iterar los resultados
    $array = [];
    while($registro = $resultado->fetch_assoc()){
        $array[] = static::crearObjetos($registro);
    }

    //Liberar la memoria
    $resultado->free();

    //Retornar los resultados
    return $array;
}


//creando los objetos a partir de arreglos (formatear de arreglo a objeto)
protected static function crearObjetos($registro){
    $objeto = new static; //Va crear nuevos objetos de la clase actual, a partir de

    foreach($registro as $key => $value){
        if(property_exists($objeto, $key)){ //Verifica si existe la propiedad
            $objeto->$key = $value;
        }
    }
    return $objeto;
}


//Sincroniza los objetos en memoria con lo datos ingresados por el usuario, por si hay nuevo reescribe
public function sincronizar($args = [] ){
    foreach($args as $key => $value){
        if(property_exists($this, $key) && !is_null($value)){ //property_exists verifica si una propiedad existe
            $this->$key = $value; //!is_null($value) si no estan vacíos le vamos asignar algo que sería $this->$key = $value;
            }
        }
    }
}
