<?php
/**
 * Created by PhpStorm.
 * User: Lucas
 * Date: 31-03-2018
 */

class mercado_publico_model extends CI_Model
{
    function obtener_usuarios()
    {
        $this->db->select("U.ID, U.USUARIO, U.NOMBRES,CASE WHEN U.ACTIVO = 'S' THEN 'ACTIVO' ELSE 'INACTIVO' END ESTADO, U.ID_PERFIL PERFIL,P.DESCRIPCION PERFIL_D", false)
            ->from('USUARIOS U')->join("PERFILES P", 'P.ID=U.ID_PERFIL', 'INNER');
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }

    function transaccion_ingresar_productos_mercado_publico($codigo, $productos, $cantidades)
    {
        $this->db->trans_begin();
        $id_mp = $this->ingresar_codigo_mp($codigo);
        for ($i = 0; $i < count($productos); $i++) {
            $id_stock = $this->comprobar_existencia_producto($productos[$i]);
            if ($id_stock != null) {
                //conversion del resultado
                foreach ($id_stock as $row) {
                    $id_stock = $row->ID;
                }
                // aumentamos
                $this->generar_movimientos_stock($cantidades[$i], 1, 1, $id_stock, $id_mp);
                $this->aumentar_stock_producto($id_stock, $cantidades[$i]);
            } else {
                // agregamos
                $id_stock = $this->generar_existencia_producto($productos[$i]);
                $this->generar_movimientos_stock($cantidades[$i], 1, 1, $id_stock, $id_mp);
                $this->aumentar_stock_producto($id_stock, $cantidades[$i]);
            }
        }
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    function ingresar_codigo_mp($codigo)
    {
        $this->db->set('COD_MP', $codigo);
        $this->db->insert("mercado_publico");
        return $this->db->insert_id();
    }

    function generar_movimientos_stock($cantidad, $tipo_movimiento, $usuario, $stock, $id_mp)
    {
        $this->db->set('CANTIDAD', $cantidad);
        $this->db->set('ID_TIPO_MOVIMIENTO', $tipo_movimiento);
        $this->db->set('ID_USUARIO', $usuario);
        $this->db->set('ID_STOCK', $stock);
        $this->db->set('ID_MERCADO_PUBLICO', $id_mp);
        $this->db->set('FECHA',date("Y-m-d"));
        $this->db->set('MOTIVO', 'CARGA MERCADO PUBLICO');
        $this->db->insert("mv_stock");
        return $this->db->insert_id();
    }

    function comprobar_existencia_producto($producto)
    {
        $this->db->select("stock.ID")->from('stock')->where("stock.ID_UBICACION", 3)->where("stock.ID_PRODUCTO", $producto);
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result() : null;
    }

    function aumentar_stock_producto($id_stock, $cantidad)
    {
        $this->db->set('SALDO', "SALDO+" . $cantidad, false);
        $this->db->where('ID', (int)$id_stock);
        return $this->db->update('stock');
    }

    function generar_existencia_producto($producto)
    {
        $this->db->set('ID_PRODUCTO', $producto);
        $this->db->set('SALDO', 0);
        $this->db->set('ID_UBICACION', 3);
        $this->db->set('ACTIVO', 'S');
        $this->db->insert("stock");
        return $this->db->insert_id();
    }

    function comprobar_existencia_codigo_mp($codigo)
    {
        $this->db->select("mercado_publico.ID")->from('mercado_publico')->where("mercado_publico.COD_MP", $codigo);
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result() : null;
    }
}