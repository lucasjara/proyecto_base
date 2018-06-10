<?php
/**
 * Created by PhpStorm.
 * User: Lucas
 * Date: 31-03-2018
 */

class usuarios_model extends CI_Model
{
    function obtener_usuarios()
    {
        $this->db->select("U.ID, U.USUARIO, U.NOMBRES,CASE WHEN U.ACTIVO = 'S' THEN 'ACTIVO' ELSE 'INACTIVO' END ESTADO, U.ID_PERFIL PERFIL,P.DESCRIPCION PERFIL_D",false)
            ->from('USUARIOS U')->join("PERFILES P",'P.ID=U.ID_PERFIL','INNER');
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }

    function ingresar_usuario($usuario,$password,$nombre,$perfil)
    {
        $this->db->set('USUARIO', $usuario);
        $this->db->set('PASSWORD', $password);
        $this->db->set('NOMBRES', $nombre);
        $this->db->set('ACTIVO', 'S');
        $this->db->set('ID_PERFIL', $perfil);
        $this->db->insert("usuarios");
        return $this->db->insert_id();
    }
    function cambia_estado_usuario($id,$estado)
    {
        $this->db->set('ACTIVO', $estado);
        $this->db->where('ID', $id);
        return $this->db->update('usuarios');
    }
    function editar_usuario($id, $usuario,$nombre,$perfil)
    {
        $this->db->set('USUARIO', $usuario);
        $this->db->set('NOMBRES', $nombre);
        $this->db->set('ID_PERFIL', $perfil);
        $this->db->where('ID', $id);
        return $this->db->update('usuarios');
    }
}