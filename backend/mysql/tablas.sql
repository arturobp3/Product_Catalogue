SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*---------------------------------------------------------------------------*/
/*-----------------------------TABLA CLIENTE---------------------------------*/
/*---------------------------------------------------------------------------*/

CREATE TABLE Cliente(
	id int(32) NOT NULL,
	user varchar(32) UNIQUE NOT NULL,
	pass varchar(80) NOT NULL,
	email varchar(32),
	nombre varchar(32),
	apellidos varchar(32),
	direccion varchar(32),

	PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE Cliente
	 MODIFY id int(32) NOT NULL AUTO_INCREMENT;


/*---------------------------------------------------------------------------*/
/*-----------------------------TABLA PEDIDO----------------------------------*/
/*---------------------------------------------------------------------------*/

CREATE TABLE Pedido(
	id int(32) NOT NULL,
	fecha datetime,

	PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
 


ALTER TABLE Pedido
	 MODIFY id int(32) NOT NULL AUTO_INCREMENT;
	
/*---------------------------------------------------------------------------*/
/*---------------------------------TABLA REALIZA-----------------------------*/
/*---------------------------------------------------------------------------*/

/*Esta tabla indica los pedidos que ha realizado cada cliente y el precio total que tiene
el pedido.*/


CREATE TABLE Realiza (
	id_cliente int(32) NOT NULL, 
	id_pedido int(32) NOT NULL,
	precioTotal int(32) NOT NULL,

	PRIMARY KEY (id_cliente, id_pedido),
	CONSTRAINT realiza_fk_1 FOREIGN KEY (id_cliente) REFERENCES Cliente (id) ON DELETE CASCADE,
	CONSTRAINT realiza_fk_2 FOREIGN KEY (id_pedido) REFERENCES Pedido (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


	 
/*---------------------------------------------------------------------------*/
/*------------------------------TABLA PRODUCTO-------------------------------*/
/*---------------------------------------------------------------------------*/

	 
CREATE TABLE Producto (
	id int (32) NOT NULL, 
	nombre varchar(80) NOT NULL,
	cantidad int(32) NOT NULL,
	categoria varchar(32) NOT NULL,
	informacion text,
	marca varchar(32),
	precioEuros int(32),

	PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	
ALTER TABLE Producto
	 MODIFY id int(32) NOT NULL AUTO_INCREMENT;


/*---------------------------------------------------------------------------*/
/*---------------------------------TABLA TIENE-------------------------------*/
/*---------------------------------------------------------------------------*/

/*Esta tabla indica los pedidos que ha realizado cada cliente y el precio total que tiene
el pedido.*/


CREATE TABLE Tiene (
	id_producto int(32) NOT NULL, 
	id_pedido int(32) NOT NULL,

	PRIMARY KEY (id_producto, id_pedido),
	CONSTRAINT tiene_fk_1 FOREIGN KEY (id_producto) REFERENCES Producto (id) ON DELETE CASCADE,
	CONSTRAINT tiene_fk_2 FOREIGN KEY (id_pedido) REFERENCES Pedido (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	 

	
COMMIT;















	