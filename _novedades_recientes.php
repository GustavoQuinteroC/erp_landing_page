            <details class="disc disc--latest" open>
                <summary class="disc__sum">
                    <span class="disc__v">v2.9.0</span>
                    <span class="disc__t">Cada registro muestra solo lo que puedes hacer</span>
                    <span class="disc__d">26 oct 2026</span>
                    <?= a_icon('chevron', 'disc__chev') ?>
                </summary>
                <div class="disc__body">
                    <ul>
                    <li><div><strong>Botones según el estado</strong><p>Un documento timbrado, cancelado o terminado ya no ofrece acciones que no le corresponden, como cambiar el almacén o agregar partidas.</p></div></li>
                    <li><div><strong>El expediente se conserva</strong><p>En un documento cerrado puedes seguir subiendo archivos, pero ya no se borran.</p></div></li>
                    <li><div><strong>Cuentas vencidas y en disputa</strong><p>Las cuentas por cobrar y por pagar se marcan solas como vencidas, y puedes poner una en disputa: conserva su saldo y no recibe abonos hasta resolverla.</p></div></li>
                    <li><div><strong>Pagos por confirmar</strong><p>Registra un cheque o una transferencia por verificar: no baja el saldo hasta que lo confirmas, y si rebota queda anotado.</p></div></li>
                    </ul>
                </div>
            </details>
            <details class="disc">
                <summary class="disc__sum">
                    <span class="disc__v">v2.8.3</span>
                    <span class="disc__t">Imprime el acuse de cancelación</span>
                    <span class="disc__d">24 oct 2026</span>
                    <?= a_icon('chevron', 'disc__chev') ?>
                </summary>
                <div class="disc__body">
                    <ul>
                    <li><div><strong>Botón «Acuse de cancelación»</strong><p>En facturas, notas de crédito, complementos de pago y facturas globales canceladas aparece junto a Imprimir y abre el acuse del SAT en el visor.</p></div></li>
                    <li><div><strong>Formato completo</strong><p>Emisor, receptor, UUID, total, fechas, motivo de cancelación, estatus ante el SAT y su sello digital.</p></div></li>
                    </ul>
                </div>
            </details>
            <details class="disc">
                <summary class="disc__sum">
                    <span class="disc__v">v2.8.2</span>
                    <span class="disc__t">Registro completo de cada timbrado</span>
                    <span class="disc__d">24 oct 2026</span>
                    <?= a_icon('chevron', 'disc__chev') ?>
                </summary>
                <div class="disc__body">
                    <ul>
                    <li><div><strong>Todo queda guardado</strong><p>Cada timbrado, cancelación y consulta de estatus guarda el comprobante y la respuesta completa del servicio de timbrado, para aclarar cualquier rechazo sin adivinar.</p></div></li>
                    </ul>
                </div>
            </details>
            <details class="disc">
                <summary class="disc__sum">
                    <span class="disc__v">v2.8.1</span>
                    <span class="disc__t">Mejora interna del manejo de archivos</span>
                    <span class="disc__d">24 oct 2026</span>
                    <?= a_icon('chevron', 'disc__chev') ?>
                </summary>
                <div class="disc__body">
                    <ul>
                    <li><div><strong>Sin cambios en tu forma de trabajar</strong><p>Se ordenó el código que guarda tus archivos para que sea el mismo en todos los sistemas de Alkes.</p></div></li>
                    </ul>
                </div>
            </details>
            <details class="disc">
                <summary class="disc__sum">
                    <span class="disc__v">v2.8.0</span>
                    <span class="disc__t">Mi nube: tus archivos en un solo lugar</span>
                    <span class="disc__d">23 oct 2026</span>
                    <?= a_icon('chevron', 'disc__chev') ?>
                </summary>
                <div class="disc__body">
                    <ul>
                    <li><div><strong>Mi nube</strong><p>En el menú de tu nombre, después de «Mi perfil y ajustes»: todos tus archivos con el documento y folio al que pertenecen, para verlos, descargarlos, borrarlos o subir archivos sueltos. Cada quien ve solo lo suyo.</p></div></li>
                    <li><div><strong>Tu espacio, siempre a la vista</strong><p>Cada usuario tiene su propio espacio y una barra junto a los adjuntos te dice cuánto llevas usado.</p></div></li>
                    <li><div><strong>Adjuntos en tabla</strong><p>Los adjuntos de cada documento se ven en una tabla con búsqueda y orden; el borrado queda en el historial del documento.</p></div></li>
                    <li><div><strong>Archivos mejor protegidos</strong><p>Cada archivo se revisa por su contenido real y solo se descarga con permiso.</p></div></li>
                    </ul>
                </div>
            </details>
            <details class="disc">
                <summary class="disc__sum">
                    <span class="disc__v">v2.7.2</span>
                    <span class="disc__t">Claves de clientes y proveedores sin choques</span>
                    <span class="disc__d">23 oct 2026</span>
                    <?= a_icon('chevron', 'disc__chev') ?>
                </summary>
                <div class="disc__body">
                    <ul>
                    <li><div><strong>Una sola serie de claves</strong><p>Dar de alta un cliente o proveedor desde cualquier sucursal ya no choca con las claves que dio otra.</p></div></li>
                    </ul>
                </div>
            </details>
            <details class="disc">
                <summary class="disc__sum">
                    <span class="disc__v">v2.7.1</span>
                    <span class="disc__t">Los folios arrancan en 1</span>
                    <span class="disc__d">20 oct 2026</span>
                    <?= a_icon('chevron', 'disc__chev') ?>
                </summary>
                <div class="disc__body">
                    <ul>
                    <li><div><strong>Primer folio correcto</strong><p>El primer documento de una sucursal nueva sale con folio 00001.</p></div></li>
                    <li><div><strong>Próximo folio exacto</strong><p>En Sucursales, «Próximo folio» muestra el folio que realmente se va a emitir.</p></div></li>
                    </ul>
                </div>
            </details>
            <details class="disc">
                <summary class="disc__sum">
                    <span class="disc__v">v2.7.0</span>
                    <span class="disc__t">Inventario físico</span>
                    <span class="disc__d">20 oct 2026</span>
                    <?= a_icon('chevron', 'disc__chev') ?>
                </summary>
                <div class="disc__body">
                    <ul>
                    <li><div><strong>Cuenta un almacén completo o parcial</strong><p>Prepara, cuenta, revisa y aplica. Varias personas capturan a la vez, con lector de código de barras y conteo ciego.</p></div></li>
                    <li><div><strong>Diferencias con su póliza</strong><p>Las diferencias se valúan, cada una lleva su motivo y al aplicarlas se generan los movimientos y la póliza.</p></div></li>
                    <li><div><strong>Bloqueo mientras se cuenta</strong><p>Opcional: nadie vende, recibe ni traspasa un producto que se está contando.</p></div></li>
                    <li><div><strong>Hoja de conteo, diferencias y acta</strong><p>En PDF, y el acta se puede enviar por correo. Tres reportes nuevos en Almacén.</p></div></li>
                    </ul>
                </div>
            </details>
            <details class="disc">
                <summary class="disc__sum">
                    <span class="disc__v">v2.6.6</span>
                    <span class="disc__t">Cobrar y timbrar la factura global sin tropiezos</span>
                    <span class="disc__d">20 oct 2026</span>
                    <?= a_icon('chevron', 'disc__chev') ?>
                </summary>
                <div class="disc__body">
                    <ul>
                    <li><div><strong>Corregido</strong><p>En el punto de venta, Cobrar vuelve a abrir su confirmación, y lo mismo «Generar y timbrar» en las facturas globales.</p></div></li>
                    </ul>
                </div>
            </details>
            <details class="disc">
                <summary class="disc__sum">
                    <span class="disc__v">v2.6.5</span>
                    <span class="disc__t">Cancelaciones de CFDI a prueba de errores</span>
                    <span class="disc__d">20 oct 2026</span>
                    <?= a_icon('chevron', 'disc__chev') ?>
                </summary>
                <div class="disc__body">
                    <ul>
                    <li><div><strong>Se revisa antes de llamar al SAT</strong><p>Si algo impediría revertir inventario, cuentas o pólizas, se avisa antes de cancelar ante el SAT.</p></div></li>
                    <li><div><strong>Cancelación en tres pasos</strong><p>Si el SAT cancela pero el sistema no alcanza a completar, el documento lo dice y el botón «Completar cancelación» lo termina.</p></div></li>
                    <li><div><strong>Consultar estatus SAT resuelve más casos</strong><p>Si el receptor rechaza la cancelación, el documento vuelve a estar vigente y se puede cancelar otra vez.</p></div></li>
                    </ul>
                </div>
            </details>
            <details class="disc">
                <summary class="disc__sum">
                    <span class="disc__v">v2.6.4</span>
                    <span class="disc__t">Encuentra la clave SAT de tus productos</span>
                    <span class="disc__d">17 oct 2026</span>
                    <?= a_icon('chevron', 'disc__chev') ?>
                </summary>
                <div class="disc__body">
                    <ul>
                    <li><div><strong>Buscador de clave SAT</strong><p>Escribe qué vendes y te muestra las claves que coinciden, o explora por categoría: productos o servicios, segmento, clase y producto. Un clic llena la clave y su descripción.</p></div></li>
                    <li><div><strong>Datos fiscales más ordenados</strong><p>Unidad, moneda, clave y descripción quedan alineadas en dos columnas.</p></div></li>
                    </ul>
                </div>
            </details>
            <details class="disc">
                <summary class="disc__sum">
                    <span class="disc__v">v2.6.3</span>
                    <span class="disc__t">Formulario de productos más ordenado</span>
                    <span class="disc__d">17 oct 2026</span>
                    <?= a_icon('chevron', 'disc__chev') ?>
                </summary>
                <div class="disc__body">
                    <ul>
                    <li><div><strong>Cuatro columnas</strong><p>El encabezado del producto se reparte en datos básicos, costos y precios, estado y clasificación, y la descripción es más compacta.</p></div></li>
                    </ul>
                </div>
            </details>
            <details class="disc">
                <summary class="disc__sum">
                    <span class="disc__v">v2.6.2</span>
                    <span class="disc__t">Captura más a prueba de errores</span>
                    <span class="disc__d">17 oct 2026</span>
                    <?= a_icon('chevron', 'disc__chev') ?>
                </summary>
                <div class="disc__body">
                    <ul>
                    <li><div><strong>Valores imposibles rechazados</strong><p>Descuentos, días de crédito, montos, tipos de cambio y otros campos ahora tienen mínimos y máximos razonables.</p></div></li>
                    <li><div><strong>Códigos postales con cero</strong><p>Los códigos que empiezan con cero (como los de la Ciudad de México) ya se guardan completos.</p></div></li>
                    <li><div><strong>Teléfono, sitio web y cuenta</strong><p>Se revisa su formato en clientes y proveedores.</p></div></li>
                    </ul>
                </div>
            </details>
            <details class="disc">
                <summary class="disc__sum">
                    <span class="disc__v">v2.6.1</span>
                    <span class="disc__t">Dos errores de captura de productos</span>
                    <span class="disc__d">17 oct 2026</span>
                    <?= a_icon('chevron', 'disc__chev') ?>
                </summary>
                <div class="disc__body">
                    <ul>
                    <li><div><strong>Servicios sin costo</strong><p>Un servicio ya se puede guardar sin costo, y un producto que no se vende sin precio.</p></div></li>
                    <li><div><strong>Productos con historial</strong><p>Guardar un producto normal que ya aparece en facturas o cotizaciones dejó de marcar un error de kit.</p></div></li>
                    </ul>
                </div>
            </details>
            <details class="disc">
                <summary class="disc__sum">
                    <span class="disc__v">v2.6.0</span>
                    <span class="disc__t">Contabilidad por clase de inventario</span>
                    <span class="disc__d">17 oct 2026</span>
                    <?= a_icon('chevron', 'disc__chev') ?>
                </summary>
                <div class="disc__body">
                    <ul>
                    <li><div><strong>Cada producto, su cuenta</strong><p>Mercancías, materias primas, semiterminados, productos terminados y consumibles ahora se registran en la cuenta que les corresponde.</p></div></li>
                    <li><div><strong>Pólizas que reparten solas</strong><p>Recepciones, movimientos de almacén, producción, remisiones, facturas, devoluciones y tickets arman la póliza por clase.</p></div></li>
                    <li><div><strong>Consumibles al gasto</strong><p>En Configuración puedes elegir gastar los consumibles al comprarlos.</p></div></li>
                    </ul>
                </div>
            </details>
            <details class="disc">
                <summary class="disc__sum">
                    <span class="disc__v">v2.5.0</span>
                    <span class="disc__t">Siete tipos de producto</span>
                    <span class="disc__d">17 oct 2026</span>
                    <?= a_icon('chevron', 'disc__chev') ?>
                </summary>
                <div class="disc__body">
                    <ul>
                    <li><div><strong>Cada producto dice qué es</strong><p>Mercancía para reventa, materia prima, semiterminado, producto terminado, consumibles, activo fijo y servicio.</p></div></li>
                    <li><div><strong>Solo donde corresponde</strong><p>Cada producto aparece únicamente en los documentos donde puede usarse, y el tipo se bloquea cuando ya tiene movimientos.</p></div></li>
                    <li><div><strong>Asistente para elegir tipo</strong><p>Cinco preguntas te sugieren el tipo correcto.</p></div></li>
                    </ul>
                </div>
            </details>
            <details class="disc">
                <summary class="disc__sum">
                    <span class="disc__v">v2.4.4</span>
                    <span class="disc__t">Dos mejoras de seguridad</span>
                    <span class="disc__d">17 oct 2026</span>
                    <?= a_icon('chevron', 'disc__chev') ?>
                </summary>
                <div class="disc__body">
                    <ul>
                    <li><div><strong>Historial solo de tu empresa</strong><p>El historial de un documento solo se consulta dentro de tu empresa.</p></div></li>
                    <li><div><strong>Módulos apagados bien cerrados</strong><p>Un módulo apagado ya no entrega datos en sus listados.</p></div></li>
                    </ul>
                </div>
            </details>
            <details class="disc">
                <summary class="disc__sum">
                    <span class="disc__v">v2.4.3</span>
                    <span class="disc__t">Modal de notas de partida más limpio</span>
                    <span class="disc__d">17 oct 2026</span>
                    <?= a_icon('chevron', 'disc__chev') ?>
                </summary>
                <div class="disc__body">
                    <ul>
                    <li><div><strong>Sin huecos ni íconos sobrantes</strong><p>Las ventanas de captura ya no muestran una fila vacía ni dejan una columna en blanco.</p></div></li>
                    </ul>
                </div>
            </details>
            <details class="disc">
                <summary class="disc__sum">
                    <span class="disc__v">v2.4.2</span>
                    <span class="disc__t">Archivos adjuntos en lista</span>
                    <span class="disc__d">17 oct 2026</span>
                    <?= a_icon('chevron', 'disc__chev') ?>
                </summary>
                <div class="disc__body">
                    <ul>
                    <li><div><strong>Vista de lista</strong><p>Los archivos adjuntos se abren siempre en lista.</p></div></li>
                    </ul>
                </div>
            </details>
            <details class="disc">
                <summary class="disc__sum">
                    <span class="disc__v">v2.4.1</span>
                    <span class="disc__t">Notas y archivos lado a lado</span>
                    <span class="disc__d">17 oct 2026</span>
                    <?= a_icon('chevron', 'disc__chev') ?>
                </summary>
                <div class="disc__body">
                    <ul>
                    <li><div><strong>Mejor aprovechado</strong><p>Las notas internas y los archivos adjuntos van en la misma fila; en celular, uno sobre otro.</p></div></li>
                    </ul>
                </div>
            </details>
            <details class="disc">
                <summary class="disc__sum">
                    <span class="disc__v">v2.4.0</span>
                    <span class="disc__t">Notas internas en todos los documentos</span>
                    <span class="disc__d">17 oct 2026</span>
                    <?= a_icon('chevron', 'disc__chev') ?>
                </summary>
                <div class="disc__body">
                    <ul>
                    <li><div><strong>Notas que no salen de tu empresa</strong><p>Varias notas por documento, con autor y fecha. Nunca se imprimen ni se envían por correo.</p></div></li>
                    <li><div><strong>Con historial</strong><p>Cada alta, edición y eliminación queda en el historial del documento.</p></div></li>
                    </ul>
                </div>
            </details>
            <details class="disc">
                <summary class="disc__sum">
                    <span class="disc__v">v2.3.1</span>
                    <span class="disc__t">Archivos adjuntos en catálogos y ajustes</span>
                    <span class="disc__d">16 oct 2026</span>
                    <?= a_icon('chevron', 'disc__chev') ?>
                </summary>
                <div class="disc__body">
                    <ul>
                    <li><div><strong>Más pantallas</strong><p>Almacenes, usuarios, sucursales, recetas, beneficios, capacitaciones, cajas, encuestas y recompensas también aceptan archivos.</p></div></li>
                    </ul>
                </div>
            </details>
            <details class="disc">
                <summary class="disc__sum">
                    <span class="disc__v">v2.3.0</span>
                    <span class="disc__t">Archivos adjuntos en todo el ERP</span>
                    <span class="disc__d">16 oct 2026</span>
                    <?= a_icon('chevron', 'disc__chev') ?>
                </summary>
                <div class="disc__body">
                    <ul>
                    <li><div><strong>36 pantallas más</strong><p>Cotizaciones, remisiones, notas de crédito, complementos de pago, tickets, cortes de caja y más aceptan archivos, con los mismos límites.</p></div></li>
                    </ul>
                </div>
            </details>
            <details class="disc">
                <summary class="disc__sum">
                    <span class="disc__v">v2.2.3</span>
                    <span class="disc__t">El visor de PDF funciona en el celular</span>
                    <span class="disc__d">16 oct 2026</span>
                    <?= a_icon('chevron', 'disc__chev') ?>
                </summary>
                <div class="disc__body">
                    <ul>
                    <li><div><strong>PDF dentro del mismo visor</strong><p>En Chrome para Android y otros navegadores sin visor propio, el PDF ahora se ve en el modal, página por página, con su botón Descargar.</p></div></li>
                    </ul>
                </div>
            </details>
            <details class="disc">
                <summary class="disc__sum">
                    <span class="disc__v">v2.2.2</span>
                    <span class="disc__t">PDF adjuntos en el celular</span>
                    <span class="disc__d">16 oct 2026</span>
                    <?= a_icon('chevron', 'disc__chev') ?>
                </summary>
                <div class="disc__body">
                    <ul>
                    <li><div><strong>Visor de PDF en el celular</strong><p>Los PDF adjuntos ya se ven dentro del visor en navegadores sin visor propio.</p></div></li>
                    </ul>
                </div>
            </details>
            <details class="disc">
                <summary class="disc__sum">
                    <span class="disc__v">v2.2.1</span>
                    <span class="disc__t">Visor de archivos adjuntos</span>
                    <span class="disc__d">16 oct 2026</span>
                    <?= a_icon('chevron', 'disc__chev') ?>
                </summary>
                <div class="disc__body">
                    <ul>
                    <li><div><strong>Gestor de archivos</strong><p>Los adjuntos se ven en cuadrícula o lista, con miniaturas; imágenes en galería y PDF, audio, video y texto en un visor con botón Descargar.</p></div></li>
                    </ul>
                </div>
            </details>
            <details class="disc">
                <summary class="disc__sum">
                    <span class="disc__v">v2.2.0</span>
                    <span class="disc__t">Archivos adjuntos en documentos</span>
                    <span class="disc__d">16 oct 2026</span>
                    <?= a_icon('chevron', 'disc__chev') ?>
                </summary>
                <div class="disc__body">
                    <ul>
                    <li><div><strong>Facturas, cuentas por pagar y órdenes de compra</strong><p>Arrastra o elige varios archivos a la vez, con barra de avance. Hasta 10 MB por archivo, 20 por documento y 1 GB por persona.</p></div></li>
                    <li><div><strong>Seguros</strong><p>Se rechazan ejecutables, scripts y páginas web.</p></div></li>
                    </ul>
                </div>
            </details>
            <details class="disc">
                <summary class="disc__sum">
                    <span class="disc__v">v2.1.6</span>
                    <span class="disc__t">«Recuérdame» en hasta 5 equipos</span>
                    <span class="disc__d">16 oct 2026</span>
                    <?= a_icon('chevron', 'disc__chev') ?>
                </summary>
                <div class="disc__body">
                    <ul>
                    <li><div><strong>Cada equipo se recuerda por separado</strong><p>Puedes recordar hasta 5 equipos a la vez; al recordar el sexto se olvida el que lleva más tiempo sin usarse.</p></div></li>
                    <li><div><strong>Lista en Mi perfil</strong><p>En Mi perfil › Seguridad ves tus equipos recordados con navegador, sistema, IP y último uso, y puedes olvidar el que quieras.</p></div></li>
                    <li><div><strong>Más seguro</strong><p>Cerrar sesión olvida solo ese equipo, y cambiar la contraseña o dar de baja a un usuario olvida sus equipos recordados. Cada persona inicia sesión una vez más y vuelve a marcar «Recordarme».</p></div></li>
                    </ul>
                </div>
            </details>
            <details class="disc">
                <summary class="disc__sum">
                    <span class="disc__v">v2.1.5</span>
                    <span class="disc__t">Recuperar contraseña y acceso desde el celular</span>
                    <span class="disc__d">16 oct 2026</span>
                    <?= a_icon('chevron', 'disc__chev') ?>
                </summary>
                <div class="disc__body">
                    <ul>
                    <li><div><strong>Recupera tu contraseña desde el acceso</strong><p>Escribes tu correo, recibes un código de 6 dígitos que vence a los 15 minutos y con él pones tu contraseña nueva.</p></div></li>
                    <li><div><strong>Acceso cómodo en el celular</strong><p>La pantalla de acceso se ajusta a cualquier tamaño, en vertical y en horizontal, sin hacer scroll ni tapar la tarjeta con el teclado.</p></div></li>
                    </ul>
                </div>
            </details>
            <details class="disc">
                <summary class="disc__sum">
                    <span class="disc__v">v2.1.4</span>
                    <span class="disc__t">Sin avisos al salir de un formulario</span>
                    <span class="disc__d">15 oct 2026</span>
                    <?= a_icon('chevron', 'disc__chev') ?>
                </summary>
                <div class="disc__body">
                    <ul>
                    <li><div><strong>Sales cuando quieres</strong><p>Ya no aparece la advertencia del navegador al pulsar Regresar, recargar o cerrar la pestaña mientras editas un documento.</p></div></li>
                    </ul>
                </div>
            </details>
            <details class="disc">
                <summary class="disc__sum">
                    <span class="disc__v">v2.1.3</span>
                    <span class="disc__t">Todas las tablas se ordenan igual</span>
                    <span class="disc__d">15 oct 2026</span>
                    <?= a_icon('chevron', 'disc__chev') ?>
                </summary>
                <div class="disc__body">
                    <ul>
                    <li><div><strong>Un solo control de orden</strong><p>Las partidas con Backorders y los reportes ahora ordenan desde el encabezado con el mismo menú (ascendente, descendente, limpiar) que el resto de las tablas.</p></div></li>
                    </ul>
                </div>
            </details>
            <details class="disc">
                <summary class="disc__sum">
                    <span class="disc__v">v2.1.2</span>
                    <span class="disc__t">Encabezado de los documentos más limpio</span>
                    <span class="disc__d">15 oct 2026</span>
                    <?= a_icon('chevron', 'disc__chev') ?>
                </summary>
                <div class="disc__body">
                    <ul>
                    <li><div><strong>Más espacio en el encabezado</strong><p>Quitamos de debajo del encabezado de cada documento la línea de estados y los renglones «Viene de» y «Se generó».</p></div></li>
                    <li><div><strong>Todo en el botón Información</strong><p>El panel Información ahora muestra, arriba del historial, de qué documento viene el actual y qué se generó de él, con un enlace a cada uno y su estado.</p></div></li>
                    </ul>
                </div>
            </details>
            <details class="disc">
                <summary class="disc__sum">
                    <span class="disc__v">v2.1.1</span>
                    <span class="disc__t">Botones iguales y en el mismo orden en todos los módulos</span>
                    <span class="disc__d">15 oct 2026</span>
                    <?= a_icon('chevron', 'disc__chev') ?>
                </summary>
                <div class="disc__body">
                    <ul>
                    <li><div><strong>Cada botón, siempre del mismo color</strong><p>Guardar y Borrador en azul, Procesar en verde, Cancelar y Eliminar en rojo, todas las autorizaciones en amarillo, Imprimir y Regresar en gris. Los mismos colores en todos los módulos.</p></div></li>
                    <li><div><strong>Siempre en el mismo orden</strong><p>De izquierda a derecha, por relevancia: primero guardar, luego las acciones, las cancelaciones y las autorizaciones. Al extremo derecho van Enviar, Información y Regresar.</p></div></li>
                    <li><div><strong>Sin menús escondidos</strong><p>Todos los botones están a la vista, uno por uno, rellenos y con su ícono. Ya no hay botones de solo contorno ni menús «Más».</p></div></li>
                    <li><div><strong>Mejor en el celular</strong><p>En pantallas chicas los botones muestran solo su ícono para que quepan, y la acción principal conserva su texto.</p></div></li>
                    <li><div><strong>El botón de correo, más corto</strong><p>Ahora se llama simplemente Enviar.</p></div></li>
                    </ul>
                </div>
            </details>
            <details class="disc">
                <summary class="disc__sum">
                    <span class="disc__v">v2.1.0</span>
                    <span class="disc__t">Envía tus documentos por correo, desde el sistema</span>
                    <span class="disc__d">15 oct 2026</span>
                    <?= a_icon('chevron', 'disc__chev') ?>
                </summary>
                <div class="disc__body">
                    <ul>
                    <li><div><strong>Un botón para enviar</strong><p>Facturas, notas de crédito, complementos de pago, cotizaciones, remisiones, órdenes de compra y más llevan el botón «Enviar». Se abre una ventana con el correo de tu cliente o proveedor, el asunto y el mensaje ya escritos, y los archivos marcados: el PDF y, en los fiscales, el XML.</p></div></li>
                    <li><div><strong>Correos limpios, que sí llegan</strong><p>Un diseño sencillo que se ve bien en el celular y en modo oscuro, sin enlaces ni botones. El documento viaja como archivo adjunto y cada envío queda anotado en el historial del documento.</p></div></li>
                    <li><div><strong>Varios contactos por cliente y proveedor</strong><p>Registra a quien recibe las facturas, a quien cobra y a quien compra, y marca qué documentos le corresponden a cada uno. Al enviar, el sistema propone a quien toca.</p></div></li>
                    <li><div><strong>Solicitudes de cotización, una por proveedor</strong><p>Al pedir precio a varios proveedores se manda un correo distinto a cada uno, con su nombre, y ninguno ve a los demás.</p></div></li>
                    <li><div><strong>El correo de tu empresa</strong><p>En Configuración › Correo eliges a dónde contestan tus clientes y la firma y el pie de tus correos. Si prefieres, envías con el servidor de correo de tu empresa y los correos salen desde tu propio dominio.</p></div></li>
                    <li><div><strong>Bitácora de correos más completa</strong><p>El reporte muestra qué se envió, a quién, con qué archivos y por qué medio.</p></div></li>
                    </ul>
                </div>
            </details>
            <details class="disc">
                <summary class="disc__sum">
                    <span class="disc__v">v2.0.3</span>
                    <span class="disc__t">Formularios más claros, con ícono en cada campo</span>
                    <span class="disc__d">14 oct 2026</span>
                    <?= a_icon('chevron', 'disc__chev') ?>
                </summary>
                <div class="disc__body">
                    <ul>
                    <li><div><strong>Un ícono en cada campo</strong><p>Cada dato que capturas lleva su ícono al lado izquierdo, para reconocer de un vistazo qué se pide.</p></div></li>
                    <li><div><strong>Nombre y campo en la misma línea</strong><p>El nombre del campo queda a la izquierda y el campo a su derecha, en todos los formularios y ventanas.</p></div></li>
                    <li><div><strong>Tarjetas con título e ícono</strong><p>Cada bloque de una pantalla se identifica con su ícono y su título.</p></div></li>
                    <li><div><strong>Configuración y datos para facturar con el mismo orden</strong><p>Las pantallas de Configuración, suscripción y datos para facturar siguen el mismo acomodo que el resto del sistema.</p></div></li>
                    </ul>
                </div>
            </details>
            <details class="disc">
                <summary class="disc__sum">
                    <span class="disc__v">v2.0.2</span>
                    <span class="disc__t">Cobro por usuario y cupo editable</span>
                    <span class="disc__d">13 oct 2026</span>
                    <?= a_icon('chevron', 'disc__chev') ?>
                </summary>
                <div class="disc__body">
                    <ul>
                    <li><div><strong>Tú decides cuántos usuarios contratas</strong><p>Ya no hay planes ni topes por tipo de usuario. Contratas un número de usuarios y cada persona activa ocupa un lugar, sea cual sea su rol.</p></div></li>
                    <li><div><strong>Cambia tu cupo desde Parámetros</strong><p>El administrador sube o baja el total de varios en varios, con una vista previa del cobro. Al subir, se cobra de inmediato la parte proporcional del periodo.</p></div></li>
                    <li><div><strong>Bajar el cupo, sin sorpresas</strong><p>La reducción queda programada para la renovación y nunca baja de los usuarios activos. Si cambias de opinión, pides de nuevo el total actual y se cancela.</p></div></li>
                    <li><div><strong>Aviso si el cupo está lleno</strong><p>Al dar de alta o reactivar un usuario con el cupo lleno, el sistema avisa en lugar de cobrar por su cuenta. Desactivar un usuario no cambia el cobro.</p></div></li>
                    <li><div><strong>Timbres CFDI por usuario</strong><p>Cada usuario contratado incluye 100 timbres al mes para facturar en producción.</p></div></li>
                    <li><div><strong>Contacto en los documentos</strong><p>La dirección elegida en los documentos de compras y ventas lleva la persona de contacto y sus teléfonos.</p></div></li>
                    <li><div><strong>Aviso de cupo excedido en el Inicio</strong><p>Si tras una renovación hay más usuarios activos que el cupo, el Inicio lo muestra con el plazo para regularizar.</p></div></li>
                    </ul>
                </div>
            </details>
            <details class="disc">
                <summary class="disc__sum">
                    <span class="disc__v">v2.0.1</span>
                    <span class="disc__t">Un menú en el orden en que trabajas</span>
                    <span class="disc__d">9 oct 2026</span>
                    <?= a_icon('chevron', 'disc__chev') ?>
                </summary>
                <div class="disc__body">
                    <h4 class="disc__group">Resumen de la versión</h4>
                    <ul>
                    <li><div><strong>Lo diario, hasta arriba</strong><p>Inicio, Por autorizar y Calendario abren el menú en su propia sección, Trabajo diario, como en Mantis, SmartPend y GeoCheck.</p></div></li>
                    <li><div><strong>Cada área sigue su flujo</strong><p>Primero el catálogo, luego los pasos en su orden real y al final los reportes: en Compras, Recepciones ya va antes de Backorder, y en Producción, Calidad sigue a Terminaciones.</p></div></li>
                    <li><div><strong>Finanzas empieza por lo de todos los días</strong><p>Cuentas por cobrar, Cuentas por pagar y Gastos van primero; Tesorería, Contabilidad e Impuestos después.</p></div></li>
                    <li><div><strong>Reportes en el mismo orden que el menú</strong><p>Las categorías de reportes siguen el orden de las áreas, de Ventas a Sistema.</p></div></li>
                    </ul>
                </div>
            </details>
            <details class="disc">
                <summary class="disc__sum">
                    <span class="disc__v">v2.0.0</span>
                    <span class="disc__t">Interfaz renovada, un inicio que dice qué atender y autorizaciones en un solo lugar</span>
                    <span class="disc__d">9 oct 2026</span>
                    <?= a_icon('chevron', 'disc__chev') ?>
                </summary>
                <div class="disc__body">
                    <h4 class="disc__group">Resumen de la versión</h4>
                    <ul>
                    <li><div><strong>Interfaz renovada de punta a punta</strong><p>Alkes ERP estrena diseño completo, el mismo de Mantis, SmartPend y GeoCheck. El encabezado, el menú y el pie se quedan fijos mientras trabajas, y se usa igual de cómodo en el celular que en la computadora. Tema claro, oscuro o automático, 20 colores de énfasis y un modo compacto para ver más filas.</p></div></li>
                    <li><div><strong>Un inicio que dice qué atender</strong><p>Ventas del mes, cartera vencida, pagos de los próximos días y lo que espera autorización, cada uno con su acceso directo. Además, facturado contra cobrado de los últimos doce meses, lo más vendido, productos bajo mínimo, órdenes de producción en curso y la actividad reciente.</p></div></li>
                    <li><div><strong>Por autorizar, en una sola bandeja</strong><p>Todo documento que espera tu autorización, de cualquier área, con quién lo pidió, desde cuándo y por cuánto. El menú muestra cuántos hay pendientes.</p></div></li>
                    <li><div><strong>Avisos en la campana, los que tú elijas</strong><p>Te avisa cuando un documento espera tu autorización, cuando autorizan o rechazan uno tuyo y cuando se timbra o se cancela ante el SAT. Un interruptor por tipo de aviso decide cuáles recibes.</p></div></li>
                    <li><div><strong>Calendario de la operación</strong><p>Vencimientos por cobrar y por pagar, entregas de compras, fechas requeridas de producción, declaraciones, fin de contratos y cierres de oportunidades, en vista de mes o de lista. Un clic abre el documento.</p></div></li>
                    <li><div><strong>Tableros de oportunidades y de producción</strong><p>Las oportunidades por etapa, con el importe de cada columna, y las órdenes de producción por estado, con su avance. Arrastrar una tarjeta abre la misma acción del documento, con su confirmación.</p></div></li>
                    <li><div><strong>Cada documento cuenta su historia</strong><p>Los botones aparecen según el estado del documento, con la siguiente acción a la mano. Se ve de qué documento viene y cuáles generó, su historial en línea de tiempo y el seguimiento como conversación.</p></div></li>
                    <li><div><strong>Búsqueda en todo el sistema</strong><p>Escribe un folio, un cliente o un producto en la barra de arriba, desde cualquier pantalla. Solo aparece lo que tú puedes abrir.</p></div></li>
                    <li><div><strong>Reportes con gráficas y periodos listos</strong><p>Hoy, esta semana, este mes, el trimestre o el año en un clic; los indicadores del periodo arriba de la gráfica y una impresión limpia, con el encabezado de tu empresa.</p></div></li>
                    <li><div><strong>Punto de venta para el mostrador</strong><p>El cobro abre con el menú plegado y atajos de teclado: F2 cobrar, F3 buscar producto, F4 cliente y Esc para volver al lector. En el celular, los importes abren el teclado numérico.</p></div></li>
                    <li><div><strong>Contabilidad e inventario más claros</strong><p>La póliza dice si está cuadrada o cuánto falta, el catálogo de cuentas se recorre como árbol, el inventario se consulta por almacén y una pestaña reúne lo que está bajo mínimo. La orden de producción muestra lo terminado y lo surtido.</p></div></li>
                    <li><div><strong>Mi perfil y ajustes, sin salir de lo que haces</strong><p>Desde tu nombre, arriba a la derecha: tus datos, la contraseña, la apariencia, tus avisos y tu actividad. Los sellos digitales se suben arrastrando el archivo.</p></div></li>
                    <li><div><strong>Manual de usuario dentro del sistema</strong><p>Abre la ayuda en la pregunta de la pantalla donde estás, con buscador.</p></div></li>
                    <li><div><strong>Encuestas con mejor cara</strong><p>La encuesta que reciben tus clientes lleva tu logo, se ve bien en el celular y se responde con botones grandes.</p></div></li>
                    </ul>
                    <h4 class="disc__group">Impacto en tu día a día</h4>
                    <ul>
                    <li><div><strong>Los mismos flujos, con otra cara</strong><p>Capturar, procesar, autorizar, timbrar y cancelar se hace igual y con las mismas reglas. Tus documentos, permisos y configuración siguen como estaban.</p></div></li>
                    <li><div><strong>Para ordenar y filtrar, el botón de cada columna</strong><p>En los listados cada columna trae su botón para ordenar y su propio filtro; las acciones se quedan fijas a la derecha.</p></div></li>
                    <li><div><strong>Imprimir y descargar, en el menú Más</strong><p>En cada documento, Imprimir, Información, Seguimiento y las descargas se agrupan en el botón Más, junto a las acciones principales.</p></div></li>
                    </ul>
                </div>
            </details>
            <details class="disc">
                <summary class="disc__sum">
                    <span class="disc__v">v1.0.0</span>
                    <span class="disc__t">Primera versión de Alkes ERP</span>
                    <span class="disc__d">jun 2026</span>
                    <?= a_icon('chevron', 'disc__chev') ?>
                </summary>
                <div class="disc__body">
                    <ul>
                    <li><div><strong>Compras, Ventas y Almacén</strong><p>Del pedido a la recepción, de la cotización a la factura y el control de existencias, con lotes, series y paquetes.</p></div></li>
                    <li><div><strong>Facturación electrónica</strong><p>Facturas, complementos de pago y notas de crédito con timbrado ante el SAT.</p></div></li>
                    <li><div><strong>Producción, Finanzas y Recursos humanos</strong><p>Recetas y órdenes de producción, cuentas por cobrar y por pagar, pólizas contables y comisiones.</p></div></li>
                    <li><div><strong>Proyectos, Atención al cliente y Contratos</strong><p>Seguimiento de proyectos, oportunidades, tickets de soporte y contratos con precio y compromiso pactados.</p></div></li>
                    <li><div><strong>Varias empresas y sucursales</strong><p>Cada empresa y sucursal ve solo su información, con permisos por usuario y módulo.</p></div></li>
                    </ul>
                </div>
            </details>
