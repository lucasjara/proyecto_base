<?php
/**
 * Created by PhpStorm.
 * User: Lucas
 * Date: 13-05-2018
 * Time: 18:44
 */

class stock_model extends CI_Model
{
    function obtener_stock()
    {
        $this->db->select("productos.ID, productos.NOMBRE_FANTASIA PRODUCTO, SUM(stock.SALDO) CANTIDAD")
            ->from('stock')
            ->join("productos", 'productos.ID=stock.ID_PRODUCTO', 'INNER')
            ->group_by("productos.ID");
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result();
    }

    function obtener_ubicacion_producto($id_producto)
    {
        $this->db->select("stock.ID,ubicacion.ID ID_UBICACION,productos.ID ID_PRODUCTO, productos.NOMBRE_FANTASIA PRODUCTO, stock.SALDO CANTIDAD, ubicacion.CAPACIDAD , CONCAT(locales.DESCRIPCION ,' ', filas.DESCRIPCION, letras.DESCRIPCION ) AS DESCRIPCION")
            ->from('stock')
            ->join("productos", 'productos.ID=stock.ID_PRODUCTO', 'INNER')
            ->join("ubicacion", 'ubicacion.ID=stock.ID_UBICACION', 'INNER')
            ->join("locales", 'locales.ID=ubicacion.ID_LOCAL', 'INNER')
            ->join("filas", 'filas.ID=ubicacion.ID_FILA', 'INNER')
            ->join("letras", 'letras.ID=ubicacion.ID_LETRA', 'INNER')
            ->where("productos.ID", $id_producto);
        $query = $this->db->get();
        return $query->result();
    }

    function obtener_cantidad_ubicacion($id_ubicacion, $id_producto)
    {
        $this->db->select("stock.SALDO CANTIDAD")
            ->from('stock')
            ->where("stock.ID_UBICACION", $id_ubicacion)
            ->where("stock.ID_PRODUCTO", $id_producto);
        $query = $this->db->get();
        return $query->result();
    }

    function obtener_datos_ubicacion($id_ubicacion)
    {
        $this->db->select("ubicacion.ID ID_UBICACION, CONCAT(locales.DESCRIPCION ,' ', filas.DESCRIPCION, letras.DESCRIPCION ) AS DESCRIPCION, ubicacion.CAPACIDAD, IFNULL(SUM(stock.SALDO),0) SALDO")
            ->from('ubicacion')
            ->join("stock", 'ubicacion.ID=stock.ID_UBICACION', 'LEFT')
            ->join("locales", 'locales.ID=ubicacion.ID_LOCAL', 'INNER')
            ->join("filas", 'filas.ID=ubicacion.ID_FILA', 'INNER')
            ->join("letras", 'letras.ID=ubicacion.ID_LETRA', 'INNER')
            ->where("ubicacion.ID", $id_ubicacion)
            ->where("ubicacion.ACTIVO", 'S')
            ->group_by("ubicacion.ID");
        $query = $this->db->get();
        return $query->result();
    }

    function obtener_ubicaciones()
    {
        $this->db->select("ubicacion.ID ID_UBICACION, CONCAT(locales.DESCRIPCION ,' ', filas.DESCRIPCION, letras.DESCRIPCION ) AS DESCRIPCION, ubicacion.CAPACIDAD, SUM(stock.SALDO) SALDO")
            ->from('ubicacion')
            ->join("stock", 'ubicacion.ID=stock.ID_UBICACION', 'LEFT')
            ->join("locales", 'locales.ID=ubicacion.ID_LOCAL', 'INNER')
            ->join("filas", 'filas.ID=ubicacion.ID_FILA', 'INNER')
            ->join("letras", 'letras.ID=ubicacion.ID_LETRA', 'INNER')
            ->where("ubicacion.ACTIVO", 'S')
            ->group_by("ubicacion.ID");
        $query = $this->db->get();
        return $query->result();
    }

    function transaccion_modificar_cantidad_producto($id_ubicacion, $id_producto, $cantidad, $motivo)
    {
        $this->db->trans_begin();
        $id_stock = $this->comprobar_existencia_producto($id_ubicacion, $id_producto);
        if ($id_stock != null) {
            //conversion del resultado
            foreach ($id_stock as $row) {
                $id_stock = $row->ID;
                $cantidad_anterior =$row->CANTIDAD;
            }
            // Disminuimos stock
            if ($cantidad_anterior == $cantidad){
            }else if($cantidad > $cantidad_anterior){
                if ($_SESSION['perfil'] == 1 || $_SESSION['perfil'] == 2) {
                    $this->generar_movimientos_stock($cantidad, 2, 1, $id_stock, $motivo);
                    $this->disminuir_stock_producto($id_stock, $cantidad);
                }else{
                    $this->db->trans_rollback();
                    return false;
                }
            }else{
                $this->generar_movimientos_stock($cantidad, 2, 1, $id_stock, $motivo);
                $this->disminuir_stock_producto($id_stock, $cantidad);
            }
        } else {
            $this->db->trans_rollback();
            return false;
        }
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    function transaccion_trasladar_producto($id_ubicacion, $id_ubicacion_destino, $cantidad, $id_producto)
    {
        $this->db->trans_begin();
        $id_stock = $this->comprobar_existencia_producto($id_ubicacion, $id_producto);
        if ($id_stock != null) {
            //conversion del resultado
            foreach ($id_stock as $row) {
                $id_stock = $row->ID;
            }
            // Disminuir Stock
            $this->generar_movimientos_stock($cantidad, 2, 1, $id_stock, 'TRANSFERENCIA DESCUENTO');
            $this->disminuir_stock_producto_cantidad_especifica($id_stock, $cantidad);
            // Aumentar Stock
            $id_stock = $this->comprobar_existencia_producto($id_ubicacion_destino, $id_producto);
            if ($id_stock != null) {
                foreach ($id_stock as $row) {
                    $id_stock = $row->ID;
                }
                $this->generar_movimientos_stock($cantidad, 1, 1, $id_stock, 'TRANSFERENCIA INCREMENTO');
                $this->aumentar_stock_producto_cantidad_especifica($id_stock, $cantidad);
            } else {
                // No existe id_stock producto en esa ubicacion
                $id_stock = $this->generar_existencia_producto($id_producto, $id_ubicacion_destino, $cantidad);
                $this->generar_movimientos_stock($cantidad, 1, 1, $id_stock, 'TRANSFERENCIA INCREMENTO');
                $this->aumentar_stock_producto_cantidad_especifica_nuevo($id_stock, $cantidad);
            }
        } else {
            $this->db->trans_rollback();
            return false;
        }
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    function generar_existencia_producto($producto, $id_ubicacion_destino, $cantidad)
    {
        $this->db->set('ID_PRODUCTO', $producto);
        $this->db->set('SALDO', $cantidad);
        $this->db->set('ID_UBICACION', $id_ubicacion_destino);
        $this->db->set('ACTIVO', 'S');
        $this->db->insert("stock");
        return $this->db->insert_id();
    }

    function aumentar_stock_producto_cantidad_especifica_nuevo($id_stock, $cantidad)
    {
        $this->db->set('SALDO', $cantidad);
        $this->db->where('ID', (int)$id_stock);
        return $this->db->update('stock');
    }

    function aumentar_stock_producto_cantidad_especifica($id_stock, $cantidad)
    {
        $this->db->set('SALDO', "SALDO+" . $cantidad, false);
        $this->db->where('ID', (int)$id_stock);
        return $this->db->update('stock');
    }

    function disminuir_stock_producto_cantidad_especifica($id_stock, $cantidad)
    {
        $this->db->set('SALDO', "SALDO-" . $cantidad, false);
        $this->db->where('ID', (int)$id_stock);
        return $this->db->update('stock');
    }

    function disminuir_stock_producto($id_stock, $cantidad)
    {
        $this->db->set('SALDO', $cantidad);
        $this->db->where('ID', (int)$id_stock);
        return $this->db->update('stock');
    }

    function comprobar_existencia_producto($id_ubicacion, $id_producto)
    {
        $this->db->select("stock.ID,stock.SALDO CANTIDAD")->from('stock')
            ->where("stock.ID_UBICACION", $id_ubicacion)
            ->where("stock.ID_PRODUCTO", $id_producto);
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result() : null;
    }

    function generar_movimientos_stock($cantidad, $tipo_movimiento, $usuario, $stock, $motivo)
    {
        $this->db->set('CANTIDAD', $cantidad);
        $this->db->set('ID_TIPO_MOVIMIENTO', $tipo_movimiento);
        $this->db->set('ID_USUARIO', $usuario);
        $this->db->set('ID_STOCK', $stock);
        $this->db->set('FECHA', date("Y-m-d"));
        $this->db->set('MOTIVO', $motivo);
        $this->db->insert("mv_stock");
        return $this->db->insert_id();
    }

    function comprobar_usuario($usuario, $pass)
    {
        $this->db->select("usuarios.ID_TIPO_PERFIL")->from('usuarios')
            ->where("usuarios.USUARIO", $usuario)
            ->where("usuarios.PASSWORD", $pass)
            ->where("usuarios.ACTIVO", 'S');
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result() : null;
    }
}