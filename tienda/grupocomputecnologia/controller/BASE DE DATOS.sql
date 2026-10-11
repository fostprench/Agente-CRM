 
 CREATE VIEW v_componentes_fuentepoder  AS  
SELECT p.idproducto AS id,m.descripcion AS marca,p.descripcion AS producto,i.precio_v AS precio,t.idtipo AS tipo,p.informacion AS informacion,i.precio_c AS precio_c,i.stock AS stock from (((producto p join marca m on((m.idmarca = p.idmarca))) join tipo t on((m.idmarca = p.idmarca))) join inventario i on((p.idproducto = i.idproducto))) where ((p.idmarca = m.idmarca) and (t.idtipo = p.idtipo) and (p.estado = 1) and (t.idtipo = 27)) ;


CREATE VIEW v_componentes_impresora  AS  
select p.idproducto AS id,m.descripcion AS marca,p.descripcion AS producto,i.precio_v AS precio,t.idtipo AS tipo,p.informacion AS informacion,i.precio_c AS precio_c,i.stock AS stock 
from (((producto p join marca m on((m.idmarca = p.idmarca))) 
join tipo t on((m.idmarca = p.idmarca))) 
join inventario i on((p.idproducto = i.idproducto))) 
where ((p.idmarca = m.idmarca) and (t.idtipo = p.idtipo) and (p.estado = 1) and (t.idtipo = 21)) ;



ALTER TABLE `detalle_otro` ADD `por_ganancia` DECIMAL(18,2) NOT NULL AFTER `garantia`, ADD `subtotal` DECIMAL(18,2) NOT NULL AFTER `por_ganancia`;




DELIMITER $$
CREATE PROCEDURE sp_detalle_otro(
     didproformas INT, 
     didproducto INT, 
     ddescripcion VARCHAR(300), 
     dcantidad INT, 
     dmonto DOUBLE, 
     ddescuento DOUBLE, 
     dgarantia INT, 
     dganancia DECIMAL(10,2), 
     dsubtotal DECIMAL(10,2)
) 
BEGIN
    INSERT INTO detalle_otro(
        idproformas, 
        idproducto, 
        descripcion, 
        cantidad, 
        monto, 
        descuento, 
        garantia, 
        por_ganancia, 
        subtotal
    ) 
    VALUES(
        didproformas, 
        didproducto, 
        ddescripcion, 
        dcantidad, 
        dmonto, 
        ddescuento, 
        dgarantia, 
        dganancia, 
        dsubtotal
    );
END$$

DELIMITER ;