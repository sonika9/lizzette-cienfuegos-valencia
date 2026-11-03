## Autenticación de usuarios
- ** Para la autenticación de usuarios se utilizó Laravel Breeze, la cual incluye formularios de registro y login.
- ** La sección del Admin Panel esta protegida mediante el middleware auth proporcionado por Laravel, con el cual se verifica
- que el usuario haya iniciado sesión.

## Consulta tipo de cambio
Se creo una interface para el servicio web de tipo de cambio ITipoCambio y se creo una implementacion
ExchangeRateAPI, esta implementacion se baso en el patron Adapter para tener flexibilidad a la hora de necesitar
cambiar el servicio web. Cuando se realiza una consulta de tipo de cambio primero se verifica si existe en cache (Redis) con el fin
de evitar consultar el servicio web, en caso contrario se consulta el servicio web y se guarda el tipo de cambio en cache para reutilizarlo en consultas posteriores,
el tipo de cambio se guarda en cache con un tiempo de expiracion de 2 horas.

app/Servicios/ITipoCambio.php
app/Servicios/ExchangeRateAPI.php

- ** Servicio Web: https://open.er-api.com/v6/latest/USD

La consulta de tipo de cambio se integro en el formulario de crear/editar productos, funcionando de la siguiente manera:
Cuando el usuario introduce el precio en pesos mexicanos se realiza una consulta al servicio de tipo de cambio (ExchangeRateAPI/ITipoCambio).

## Servicio Web para realizar pagos

Para esta funcionalidad se creo un Servicio Mock el cual regresara una respuesta de exito. De igual manera se implemento el
patron Adapter para mayor flexibilidad a la hora de implementar el servicio real.

app/Servicios/IServicioPago.php
app/Servicios/MockServicioPago.php

## Componentes Livewire
- ** Para la sección de productos se creo un Form llamado ProductoForm con el fin de reutilizarlo en las vistas de creación y edición del
producto.
- ** El carrito de compras es gestionado mediante Livewire, de igual manera se agrego el estado del carrito a la session esto con el fin 
- de que si el usuario recarga la pagina no se pierda el contenido del carrito.

## Librerias para Estilos y Graficas

- ** Para la creacion de graficas se utilizo Chart.js.
- ** Para el estilo de la aplicacion se utilizo Tailwind CSS.

