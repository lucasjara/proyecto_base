<?php
/**
 * Created by PhpStorm.
 * User: Lucas
 * Date: 06-05-2018
 * Time: 1:11
 */

class control_existencia_model extends CI_Model
{
    function obtener_grafico_stock()
    {
        $this->db->select("productos.NOMBRE_FANTASIA PRODUCTO, stock.SALDO CANTIDAD")
            ->from('stock')
            ->join("productos", 'productos.ID=stock.ID_PRODUCTO', 'INNER')
            ->order_by("stock.SALDO");
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }

    function obtener_grafico_stock_lineal()
    {
        $this->db->select("SUM(mv_stock.CANTIDAD) CANTIDAD, DATE_FORMAT(mv_stock.FECHA, '%Y-%m-%d') FECHA")
            ->from('stock')
            ->join("mv_stock", 'mv_stock.ID_STOCK=stock.ID', 'INNER')
            ->where("mv_stock.ID_TIPO_MOVIMIENTO",1)
            ->group_by("mv_stock.FECHA");
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }
    function comprobar_usuario($usuario, $pass)
    {
        $this->db->select("usuarios.ID_PERFIL")->from('usuarios')
            ->where("usuarios.USUARIO", $usuario)
            ->where("usuarios.PASSWORD", $pass);
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result() : null;
    }
    function obtener_ultimos_movimientos(){
        $this->db->select("mv_stock.CANTIDAD,mv_stock.ID_TIPO_MOVIMIENTO TIPO_MOVIMIENTO,productos.NOMBRE_FANTASIA PRODUCTO")
            ->from("mv_stock")
            ->join("stock",'mv_stock.ID_STOCK=stock.ID',"INNER")
            ->join('productos','productos.ID=stock.ID_PRODUCTO','INNER')
            ->order_by("mv_stock.ID",'DESC')->limit(6);
        $query = $this->db->get();
        return $query->result();
    }
}