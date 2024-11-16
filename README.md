# Proyecto-Ecommerce

## Descripción del Proyecto
Este proyecto se trata de realizar un e-commerce (tienda online) para una empresa que vende ropa. Nuestro cliente es MicolVio. La tienda tiene diferentes funciones: como iniciar sesión, registrarse y recuperar contraseña. Del lado de Administración podemos crear, eliminar y editar productos, también podemos crear y eliminar categorías y editar roles de usuario, el sitio web cuenta con un carrito de compras, y cuando finalizas una compra te enviamos una facturación.

## Uso
- **Registrarse**: Completar el formulario de registro con los datos solicitados.
- **Logearse**: Iniciar sesión con tu correo y contraseña.
- **Recuperar Contraseña**: Si olvidaste tu contraseña, puedes utilizar la opción de "recuperar contraseña" proporcionando tu correo electrónico para recibir instrucciones de restablecimiento.
- **Ver Producto**: Permite al usuario ver un producto de forma única
- **Agregar Producto a Carrito**: Permite al cliente agregar productos a su carrito seleccionando talle, color, y cantidad.
- **Finalizar Compra**: Cuando el cliente decide comprar los productos que se encuentran en su carrito
- **Completar Pedido**: Si el cliente decide finalizar la compra debe llenar un formulario con toda su información, y los datos de envío y pago.
- **Adjuntar Pago**: Una vez el cliente haya hecho la transferencia debe maracar el pago como enviado
- **Descargar Factura**: Una vez el administrador confirme el pago el cliente podrá descargar la factura, con todos los datos de la compra y su respectiva información 
- **Contactarse**: El cliente puede contactarse con los administradores del sistema mediante un formulario
- **Gestión Categoría**: El Administrador puede agregar, modificar y eliminar categorías
- **Gestión de Prductos**: El Administrador puede agregar, modificar y eliminar productos
- **Gestión de Usuarios**: El SuperAdmin puede modificar el rol de todos los usuarios, de cliente a administrador
- **Gestión de Pedidos**:  El Administrador podrá gestionar los pagos enviados por los clientes y marcarlos como: Completado, Fallido o Rechazado

## Estructura de Carpetas
- `/assets/`: Contiene los archivos CSS, imágenes y scripts.
- `/models/`: Contiene los modelos para interactuar con la base de datos.
- `/controllers/`: Es la parte lógica que maneja todas las funcionalidades del programa tanto de la parte del cliente como la del administrador.
- `/views/`: Son los archivos HTML que representan la interfaz de usuario.
- `/fpdf186/`: Es una biblioteca que importamos para generar la factura electrónica.
- `/productosNuevos/`: Es una carpeta que contiene imagenes para crear nuevos productos

## Instalación
1. Clonar el repositorio: git clone https://github.com/tu-proyecto.git
2. Configurar la base de datos en MySQL: Ejecutar el script database.sql para crear las tablas correspondientes.
3. Iniciar el servidor local usando XAMPP.

## Datos de Prueba
Las credenciales para ingresar como superAdmin al programa son:
Email: superAdmin@aureacode.com
Contraseña: 123

Las credenciales para ingresar como Admin al programa son:
Email: admin@aureacode.com
Contraseña: 123

Las credenciales para ingresar como cliente al programa son:
Email: cliente@aureacode.com
Contraseña: 123

Cada tipo de usuario tiene funcionalidades diferentes, el tipo de usuario esta reflejado en el nombre de la cuenta.

## Autores
- Valentina Maldonado ([valemaldo11](https://github.com/valemaldo11))
- Pedro Zadowoniz ([fleesch2003](https://github.com/fleesch2003))
- Joaquín Peréz ([joaquinperez028](https://github.com/joaquinperez028))
- Lucía Sugasti ([sugastilucia](https://github.com/luciasugasti))
