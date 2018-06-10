<?php
/**
 * Created by PhpStorm.
 * User: Lucas
 * Date: 31-03-2018
 */

class productos_model extends CI_Model
{
    function obtener_productos()
    {
        $this->db->select("p.ID, p.COD_PRODUCTO as CODIGO, p.NOMBRE as NOMBRE, p.DESCRIPCION as DESCRIPCION, p.NOMBRE_FANTASIA as NOMBRE_FANTASIA, CASE WHEN p.ACTIVO = 'S' THEN 'ACTIVO' ELSE 'INACTIVO' END ESTADO", false)
            ->from('productos p');
        $query = $this->db->get();
        return $query->result();
    }

    function ingresar_producto($cod_producto, $descripcion, $nombre, $nombre_fantasia)
    {
        $this->db->set('COD_PRODUCTO', $cod_producto);
        $this->db->set('NOMBRE', $nombre);
        $this->db->set('DESCRIPCION', $descripcion);
        $this->db->set('NOMBRE_FANTASIA', $nombre_fantasia);
        $this->db->set('ACTIVO', 'S');
        $this->db->insert("productos");
        return $this->db->insert_id();
    }

    function cambia_estado_producto($id, $estado)
    {
        $this->db->set('ACTIVO', $estado);
        $this->db->where('ID', $id);
        return $this->db->update('productos');
    }

    function editar_producto($id, $cod_producto, $nombre, $descripcion, $nombre_fantasia)
    {
        $this->db->set('COD_PRODUCTO', $cod_producto);
        $this->db->set('NOMBRE', $nombre);
        $this->db->set('DESCRIPCION', $descripcion);
        $this->db->set('NOMBRE_FANTASIA', $nombre_fantasia);
        $this->db->where('ID', $id);
        return $this->db->update('productos');
    }
}