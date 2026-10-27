<?php
$NOINDEX = false;

require_once __DIR__ . '/_erp.php';
require_once __DIR__ . '/_seo.php';

$URL_APP = ER_APP;
$PROD    = 'erp';

$DESDE_TXT = '$' . a_num(er_tarifa_min());

$TITULO  = 'Alkes ERP: sistema de gestión empresarial con facturación CFDI 4.0 | Alkes';
$DESC    = 'ERP con ventas, compras, almacén, producción, finanzas y contabilidad, y facturación CFDI 4.0 desde la misma venta. Desde ' . $DESDE_TXT . ' MXN por usuario al mes. Pruébalo.';
$DESC_OG = 'Ventas, compras, almacén, producción, finanzas y facturación CFDI 4.0 en un solo sistema. Desde ' . $DESDE_TXT . ' MXN por usuario al mes.';

/* Capacidades en pestañas: una por área del ERP. */
$CAPACIDADES = array(
    array('id' => 'ventas', 'tab' => 'Ventas', 'eyebrow' => 'Ventas y facturación',
        'h3' => 'De la cotización a la factura timbrada',
        'p' => 'La cotización pasa a remisión y a factura CFDI 4.0, con su cuenta por cobrar. El timbrado ante el SAT ocurre a través de PAC desde la misma pantalla y cada operación queda en la bitácora.',
        'items' => array(
            array('invoice', 'Facturas, complementos de pago y notas de crédito', 'Emisión y timbrado desde la venta registrada, con el registro de los pagos recibidos y las devoluciones sobre la factura original.'),
            array('cart', 'Punto de venta para el mostrador', 'Cajas, cortes de caja, tickets y facturas globales, con atajos de teclado: F2 cobrar, F3 buscar producto y F4 cliente.'),
            array('form', 'Cotizaciones, remisiones y contratos de venta', 'Cotizaciones con seguimiento de su conversión, remisiones por facturar y contratos de venta con su avance.'),
        ),
        'img' => 'assets/img/ventas.jpg', 'alt' => 'Módulo de ventas de Alkes ERP con facturas CFDI 4.0 y su estado', 'w' => 1568, 'h' => 768,
        'cap' => 'Ventas: documentos encadenados hasta la factura'),
    array('id' => 'compras', 'tab' => 'Compras', 'eyebrow' => 'Compras',
        'h3' => 'De la requisición a la recepción',
        'p' => 'Una requisición abre la necesidad, se cotiza con proveedores y la orden de compra genera la recepción: el material entra al almacén y la cuenta por pagar queda ligada al documento.',
        'items' => array(
            array('form', 'Requisiciones y cotizaciones', 'Se solicitan cotizaciones a varios proveedores, se reciben y se adjudica la mejor, partida por partida.'),
            array('cart', 'Órdenes de compra y recepciones', 'La orden genera la recepción; las recepciones parciales y los rechazos quedan registrados.'),
            array('repeat', 'Backorder y contratos de compra', 'Lo que falta por recibir queda controlado como backorder, y los contratos de compra llevan su avance.'),
        ),
        'img' => 'assets/img/compras.jpg', 'alt' => 'Requisiciones de Alkes ERP con sus productos y su estado', 'w' => 1568, 'h' => 768,
        'cap' => 'Compras: documentos encadenados y su estado'),
    array('id' => 'almacen', 'tab' => 'Almacén', 'eyebrow' => 'Almacén e inventario',
        'h3' => 'Inventario que se puede rastrear',
        'p' => 'Cada entrada, salida y traspaso queda registrada. Las existencias se consultan por almacén y por ubicación, con su valuación y lo que está bajo mínimo.',
        'items' => array(
            array('box', 'Productos, almacenes e inventario', 'Existencias por almacén, productos bajo mínimo, productos sin movimiento y valuación de inventario.'),
            array('route', 'Lotes y números de serie', 'El movimiento conserva el lote y la serie de cada partida, y un reporte sigue un lote de punta a punta.'),
            array('warehouse', 'Movimientos y traspasos', 'Entradas, salidas y traspasos entre almacenes, con su kardex por producto.'),
        ),
        'img' => 'assets/img/almacen.jpg', 'alt' => 'Inventario de Alkes ERP con existencias por almacén', 'w' => 1568, 'h' => 768,
        'cap' => 'Inventario por almacén'),
    array('id' => 'produccion', 'tab' => 'Producción', 'eyebrow' => 'Producción',
        'h3' => 'Producción por receta, con costos',
        'p' => 'La receta define los materiales; la orden de producción surte, termina y calcula sus costos. El inventario se mueve solo con cada surtido y cada terminación.',
        'items' => array(
            array('factory', 'Recetas y órdenes de producción', 'Órdenes con su avance, su fecha requerida y los materiales pendientes de surtir.'),
            array('box', 'Surtidos, terminaciones y backorder', 'Cada surtido y cada terminación mueven el inventario; lo que falta queda como backorder.'),
            array('badge', 'Calidad', 'Criterios e inspecciones de calidad, con rechazos y scrap por orden.'),
        ),
        'img' => 'assets/img/produccion.jpg', 'alt' => 'Órdenes de producción de Alkes ERP con su avance', 'w' => 1568, 'h' => 768,
        'cap' => 'Órdenes de producción por estado'),
    array('id' => 'finanzas', 'tab' => 'Finanzas', 'eyebrow' => 'Finanzas, contabilidad e impuestos',
        'h3' => 'Cobranza, tesorería y contabilidad en el mismo sistema',
        'p' => 'Lo que se vende y se compra alimenta las cuentas por cobrar y por pagar, y de ahí la tesorería, las pólizas contables y las declaraciones.',
        'items' => array(
            array('coins', 'Cuentas por cobrar y por pagar', 'El estado de cada cliente y proveedor ligado a sus documentos, con antigüedad de saldos, días de cartera y calendario de pagos.'),
            array('database', 'Tesorería', 'Cuentas bancarias, caja chica, créditos, conciliaciones y flujo de efectivo.'),
            array('report', 'Contabilidad e impuestos', 'Catálogo de cuentas, pólizas, cierre contable, libro diario y mayor, balanza, balance general, estado de resultados, declaraciones, retenciones y DIOT.'),
        ),
        'img' => 'assets/img/finanzas.jpg', 'alt' => 'Pólizas contables de Alkes ERP', 'w' => 1568, 'h' => 768,
        'cap' => 'Contabilidad: pólizas y su cuadre'),
    array('id' => 'clientes', 'tab' => 'Clientes y equipo', 'eyebrow' => 'Clientes, proyectos y personas',
        'h3' => 'Lo que pasa antes y después de la venta',
        'p' => 'Las oportunidades, los tickets de atención, los proyectos y el personal viven en el mismo sistema que las ventas y las compras.',
        'items' => array(
            array('users', 'Atención al cliente', 'Oportunidades en tablero por etapa, tickets con cumplimiento de SLA y un programa de fidelización con recompensas y encuestas.'),
            array('layers', 'Proyectos', 'Seguimiento de cada proyecto con sus documentos, su avance y su rentabilidad.'),
            array('user-check', 'Recursos humanos', 'Empleados, comisiones, capacitación y beneficios, con reportes de costo de nómina, altas y bajas.'),
        ),
        'img' => 'assets/img/clientes.jpg', 'alt' => 'Tablero de oportunidades de Alkes ERP por etapa', 'w' => 1568, 'h' => 768,
        'cap' => 'Oportunidades por etapa, con el importe de cada columna'),
    array('id' => 'control', 'tab' => 'Control', 'eyebrow' => 'Control y trazabilidad',
        'h3' => 'Cada documento cuenta su historia',
        'p' => 'Los botones aparecen según el estado del documento, con la siguiente acción a la mano. Se ve de qué documento viene, cuáles generó y quién hizo qué.',
        'items' => array(
            array('history', 'Historial y seguimiento', 'Línea de tiempo de cada documento y un seguimiento como conversación, con bitácoras de timbrado y de correos.'),
            array('lock', 'Permisos y autorizaciones', 'Matriz de permisos por usuario y una bandeja Por autorizar con todo lo que espera tu visto bueno, de cualquier área.'),
            array('building', 'Multi-sucursal', 'Configuración de la empresa y sus sucursales, cada una con sus usuarios y permisos.'),
        ),
        'img' => 'assets/img/control.jpg', 'alt' => 'Bandeja Por autorizar de Alkes ERP con los documentos pendientes', 'w' => 1568, 'h' => 768,
        'cap' => 'Por autorizar: todo lo pendiente en una sola bandeja'),
);

$SOSTIENE = array(
    array('route', 'Documentos encadenados', 'Cada documento hereda las partidas del anterior, sin recapturar información.'),
    array('search', 'Búsqueda en todo el sistema', 'Un folio, un cliente o un producto desde la barra de arriba; solo aparece lo que tú puedes abrir.'),
    array('calendar', 'Calendario de la operación', 'Vencimientos por cobrar y por pagar, entregas de compras, declaraciones, fin de contratos y cierres de oportunidades.'),
    array('bell', 'Avisos que tú eliges', 'Cuando un documento espera tu autorización, cuando se timbra o se cancela ante el SAT; un interruptor por tipo de aviso.'),
    array('report', 'Impresión limpia', 'Cada documento se imprime con el encabezado de tu empresa, sin menús ni botones.'),
    array('book', 'Manual dentro del sistema', 'La ayuda se abre en la pregunta de la pantalla donde estás, con buscador.'),
);

$AVANZADAS = array(
    array('layers', 'Tableros de oportunidades y de producción', 'Las oportunidades por etapa y las órdenes de producción por estado; arrastrar una tarjeta abre la acción del documento, con su confirmación.'),
    array('filter', 'Listados con filtro por columna', 'Cada columna trae su botón para ordenar y su propio filtro; las acciones se quedan fijas a la derecha.'),
    array('globe', 'Ventas en moneda extranjera', 'Un reporte de ventas en moneda extranjera junto a los de ventas netas, margen y comparativos.'),
    array('mail', 'Encuestas con tu logo', 'La encuesta que reciben tus clientes lleva tu logo, se ve bien en el celular y se responde con botones grandes.'),
    array('display', 'Apariencia a tu gusto', 'Tema claro, oscuro o automático, 20 colores de énfasis y un modo compacto para ver más filas.'),
    array('user-check', 'Mi perfil y sellos digitales', 'Tus datos, tu contraseña, tus avisos y tu actividad; los sellos digitales se suben arrastrando el archivo.'),
);

/* 153 reportes en 14 categorías (conteo real del menú de Reportes). */
$REPORTES = array(
    array('Ventas', 26, 'Ventas por cliente, margen de utilidad, pipeline de ventas, ranking ABC de clientes y estatus de CFDI.'),
    array('Punto de venta', 10, 'Cortes de caja, diferencias de caja, tickets por facturar y ventas por cajero.'),
    array('Compras', 17, 'Ciclo de compra, comparativo de cotizaciones, variación de precio y cumplimiento de entrega.'),
    array('Almacén', 16, 'Kardex por producto, valuación de inventario, lotes por vencer y trazabilidad de lote.'),
    array('Producción', 12, 'Costos por orden, avance de órdenes, variación de materiales y rechazos y scrap.'),
    array('Contratos', 5, 'Contratos de venta y de compra, avance de contratos y contratos por vencer.'),
    array('Cartera', 10, 'Antigüedad de saldos, días de cartera (DSO), cobranza del periodo y estado de cuenta por socio.'),
    array('Tesorería', 8, 'Flujo de efectivo, conciliaciones bancarias, calendario de pagos y saldos bancarios.'),
    array('Contabilidad', 12, 'Balance general, estado de resultados, balanza de comprobación, libro diario y libro mayor.'),
    array('Impuestos', 5, 'DIOT, IVA por cobrar y por pagar, retenciones efectuadas y calendario de declaraciones.'),
    array('Atención al cliente', 12, 'Embudo de ventas, tasa de conversión, tiempos de resolución y cumplimiento de SLA.'),
    array('Proyectos', 4, 'Avance, documentos y rentabilidad de proyectos.'),
    array('Recursos humanos', 9, 'Costo de nómina, altas y bajas, comisiones del periodo y plantilla de personal.'),
    array('Sistema', 7, 'Bitácora de timbrado, control de folios, historial de documentos y matriz de permisos.'),
);

function er_items($lista)
{
    $h = '';
    foreach ($lista as $i) {
        $h .= '<div class="item">' . a_icon($i[0]) . '<div><h4>' . a_e($i[1]) . '</h4><p>' . a_e($i[2]) . '</p></div></div>';
    }
    return $h;
}

function er_reportes_items($lista)
{
    $h = '';
    foreach ($lista as $r) {
        $h .= '<div class="item">' . a_icon('chart') . '<div><h4>' . a_e($r[0]) . ' · ' . (int) $r[1] . ' reportes</h4><p>' . a_e($r[2]) . '</p></div></div>';
    }
    return $h;
}
?>
<?php
// SEO y GEO: datos para seo_head() y seo_enriquecer() (ver _seo.php).
$SEO_PAG = seo_de_pagina(ER_SITIO, isset($CAPACIDADES) ? $CAPACIDADES : array(), array($SOSTIENE, $AVANZADAS));
$SEO = array(
    'sitio' => ER_SITIO, 'nombre' => 'Alkes ERP', 'titulo' => $TITULO, 'noindex' => $NOINDEX,
    'subcategoria' => 'ERP y facturación electrónica', 'dispositivos' => 'Computadora, teléfono y tableta', 'requisitos' => 'Navegador web moderno con conexión a internet',
    'alt' => 'Vista de Alkes ERP, software en la nube de Alkes',
    'palabras' => array('ERP México', 'sistema ERP para pymes', 'ERP en la nube', 'facturación electrónica CFDI 4.0', 'timbrado CFDI', 'complemento de pago', 'notas de crédito', 'punto de venta', 'control de inventarios', 'compras y requisiciones', 'producción', 'contabilidad', 'software administrativo', 'sistema de gestión empresarial', 'software Guadalajara', 'Alkes'),
    'version' => seo_version(__DIR__), 'funciones' => $SEO_PAG['funciones'], 'capturas' => $SEO_PAG['capturas'],
);
?>
<!doctype html>
<html lang="es" class="no-js">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title><?= a_e($TITULO) ?></title>

<meta name="description" content="<?= a_e($DESC) ?>">
<meta name="author" content="Alkes">
<meta name="theme-color" content="#061c6b">
<meta name="format-detection" content="telephone=no">
<?php if ($NOINDEX): ?><meta name="robots" content="noindex,nofollow">
<?php endif; ?>
<link rel="canonical" href="<?= ER_SITIO ?>/">

<meta property="og:type" content="website">
<meta property="og:site_name" content="Alkes ERP">
<meta property="og:url" content="<?= ER_SITIO ?>/">
<meta property="og:title" content="<?= a_e($TITULO) ?>">
<meta property="og:description" content="<?= a_e($DESC_OG) ?>">
<meta property="og:image" content="<?= ER_SITIO ?>/assets/img/og-image.png">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:alt" content="Alkes ERP, sistema de gestión empresarial con facturación CFDI 4.0">
<meta property="og:locale" content="es_MX">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?= a_e($TITULO) ?>">
<meta name="twitter:description" content="<?= a_e($DESC_OG) ?>">
<meta name="twitter:image" content="<?= ER_SITIO ?>/assets/img/og-image.png">
<?= seo_head($SEO) ?>
<link rel="icon" href="assets/img/favicon.ico" type="image/x-icon">
<link rel="apple-touch-icon" href="assets/img/apple-touch-icon.png">

<link rel="preload" href="assets/fonts/lexend-latin.woff2" as="font" type="font/woff2" crossorigin>
<link rel="preload" href="assets/fonts/source-sans-3-latin.woff2" as="font" type="font/woff2" crossorigin>
<link rel="stylesheet" href="assets/css/erp.css">

<script type="application/ld+json"><?= er_jsonld($SEO) ?></script>

<script>
(function () {
    var r = document.documentElement;
    r.className = r.className.replace('no-js', 'js');
    try {
        var t = localStorage.getItem('tema');
        if (t === 'dark' || t === 'light') { r.setAttribute('data-theme', t); }
    } catch (e) {}
})();
</script>
</head>
<body>

<a class="skip" href="#main">Saltar al contenido</a>

<header class="nav" id="nav">
    <div class="container nav__in">
        <a class="brand" href="#inicio"><?= er_logo(34) ?><span>Alkes ERP</span></a>
        <a class="brand__by" href="<?= ALKES_SITIO ?>">por <strong>Alkes</strong></a>
        <nav class="nav__links" aria-label="Secciones">
            <a class="nav__link" href="#producto">Producto</a>
            <a class="nav__link" href="#capacidades">Capacidades</a>
            <a class="nav__link" href="#reportes">Reportes</a>
            <a class="nav__link" href="#precios">Precios</a>
            <a class="nav__link" href="#preguntas">Preguntas</a>
            <a class="nav__link" href="#novedades">Novedades</a>
            <a class="nav__link" href="#contacto">Contacto</a>
        </nav>
        <div class="nav__actions">
            <?= a_tema() ?>
            <a class="btn btn--line btn--sm" href="<?= a_e($URL_APP) ?>">Iniciar sesión</a>
            <a class="btn btn--primary btn--sm" href="#precios">Ver precios</a>
        </div>
        <button class="nav__burger" type="button" id="navToggle" aria-expanded="false" aria-controls="navPanel" aria-label="Abrir menú">
            <?= a_icon('menu', 'i-menu') ?><?= a_icon('close', 'i-close') ?>
        </button>
    </div>
    <div class="nav__panel container" id="navPanel">
        <a class="nav__link" href="#producto">Producto</a>
        <a class="nav__link" href="#capacidades">Capacidades</a>
        <a class="nav__link" href="#precios">Precios</a>
        <a class="nav__link" href="#preguntas">Preguntas</a>
        <a class="nav__link" href="#novedades">Novedades</a>
        <a class="nav__link" href="#contacto">Contacto</a>
        <a class="nav__link" href="#ecosistema">Ecosistema Alkes</a>
        <div class="nav__panel-actions">
            <?= a_tema() ?>
            <a class="btn btn--line" href="<?= a_e($URL_APP) ?>">Iniciar sesión</a>
            <a class="btn btn--primary" href="#precios">Ver precios</a>
        </div>
    </div>
</header>

<main id="main">

<!-- Hero ------------------------------------------------------------------ -->
<section class="hero" id="inicio">
    <div class="container">
        <div class="hero__grid">
            <div class="hero__body">
                <p class="eyebrow" data-reveal>ERP para empresas que compran, producen, venden y facturan en México</p>
                <h1 data-reveal>De la requisición a la factura timbrada, en un <em>solo</em> sistema</h1>
                <p class="lede" data-reveal>Alkes ERP junta ventas, compras, almacén, producción, finanzas y más. Cada documento hereda del anterior y la factura CFDI 4.0 se timbra desde la misma venta. Desde <?= a_e($DESDE_TXT) ?> MXN por usuario al mes.</p>
                <div class="row" data-reveal>
                    <a class="btn btn--primary btn--lg" href="<?= a_e($URL_APP) ?>" data-open-demo><?= a_icon('play') ?>Probar el demo</a>
                    <a class="btn btn--line btn--lg" href="#precios">Ver precios</a>
                </div>
                <div class="row" data-reveal>
                    <a class="link" href="<?= a_e(er_url_agendar()) ?>">Agendar demostración guiada<?= a_icon('arrow') ?></a>
                    <a class="link" href="#novedades">Ver novedades<?= a_icon('arrow') ?></a>
                </div>
                <ul class="hero__facts" data-reveal>
                    <li><?= a_icon('check') ?>CFDI 4.0 con timbrado</li>
                    <li><?= a_icon('check') ?>Multi-sucursal</li>
                    <li><?= a_icon('check') ?>Trazabilidad por lote</li>
                </ul>
            </div>
            <div class="hero__aside" data-reveal>
                <div class="scene" data-scene>
  <svg class="scene__svg" viewBox="0 0 560 420" role="img" aria-label="Animación: una requisición se convierte en orden y llega la mercancía; un montacargas la acomoda en el almacén, el pedido de venta viaja a la oficina y la factura recibe el sello de timbrada. Arriba, la cadena de documentos se va encendiendo sin recapturar.">
    <defs><clipPath id="sc-tr"><rect x="384" y="200" width="48" height="80" rx="14"/></clipPath></defs>
    <rect class="sc-wall" x="0" y="0" width="560" height="330"/><rect class="sc-wall2" x="0" y="258" width="560" height="72"/><path class="sc-line" d="M0 258H560"/>
    <rect class="sc-floor" x="0" y="330" width="560" height="90"/><path class="sc-line" d="M0 330H560"/>
    <path class="sc-tile" d="M0 356H560M0 384H560M120 330L72 420M290 330L284 420M450 330L500 420"/>
    <path class="er-fl" d="M20 346H236"/>
    <g class="er-chain"><path class="er-ln" d="M60 40H500"/><path class="er-lf" d="M60 40H500"/><g class="er-n n0"><circle class="er-nb" cx="60" cy="40" r="13"/><g class="er-nl"><circle class="er-ng" cx="60" cy="40" r="13"/><path class="sc-ck3" d="M55 40l3.500 3.500 6.500-7"/></g><text class="er-nt" x="60" y="72" text-anchor="middle">Requisición</text></g><g class="er-n n1"><circle class="er-nb" cx="170" cy="40" r="13"/><g class="er-nl"><circle class="er-ng" cx="170" cy="40" r="13"/><path class="sc-ck3" d="M165 40l3.500 3.500 6.500-7"/></g><text class="er-nt" x="170" y="72" text-anchor="middle">Orden</text></g><g class="er-n n2"><circle class="er-nb" cx="280" cy="40" r="13"/><g class="er-nl"><circle class="er-ng" cx="280" cy="40" r="13"/><path class="sc-ck3" d="M275 40l3.500 3.500 6.500-7"/></g><text class="er-nt" x="280" y="72" text-anchor="middle">Recepción</text></g><g class="er-n n3"><circle class="er-nb" cx="390" cy="40" r="13"/><g class="er-nl"><circle class="er-ng" cx="390" cy="40" r="13"/><path class="sc-ck3" d="M385 40l3.500 3.500 6.500-7"/></g><text class="er-nt" x="390" y="72" text-anchor="middle">Venta</text></g><g class="er-n n4"><circle class="er-nb" cx="500" cy="40" r="13"/><g class="er-nl"><circle class="er-ng" cx="500" cy="40" r="13"/><path class="sc-ck3" d="M495 40l3.500 3.500 6.500-7"/></g><text class="er-nt" x="500" y="72" text-anchor="middle">Factura</text></g></g>
    <g class="er-all">
      <g class="er-sg"><rect class="er-sgb" x="20" y="96" width="92" height="22" rx="11"/><text class="er-sgt" x="66" y="111" text-anchor="middle">Compras</text>
        <rect class="er-sgb" x="272" y="96" width="92" height="22" rx="11" style="display:none"/>
        <rect class="er-sgb" x="408" y="96" width="132" height="22" rx="11"/><text class="er-sgt" x="474" y="111" text-anchor="middle">Facturación</text></g>
      <path class="er-up" d="M256 126V330M372 126V330"/><rect class="er-bd" x="252" y="196" width="124" height="7" rx="2"/><rect class="er-bd" x="252" y="264" width="124" height="7" rx="2"/><rect class="er-bd" x="252" y="128" width="124" height="7" rx="2"/><rect class="er-bx" x="262" y="152" width="30" height="44" rx="3"/><path class="er-tp" d="M262 158H292M274.0 152v6h6v-6"/><rect class="er-bx" x="298" y="164" width="28" height="32" rx="3"/><path class="er-tp" d="M298 170H326M309.0 164v6h6v-6"/><rect class="er-bx" x="330" y="156" width="34" height="40" rx="3"/><path class="er-tp" d="M330 162H364M344.0 156v6h6v-6"/><rect class="er-bx" x="262" y="222" width="34" height="42" rx="3"/><path class="er-tp" d="M262 228H296M276.0 222v6h6v-6"/><rect class="er-bx" x="338" y="232" width="28" height="32" rx="3"/><path class="er-tp" d="M338 238H366M349.0 232v6h6v-6"/><rect class="er-bx" x="264" y="292" width="40" height="38" rx="3"/><path class="er-tp" d="M264 298H304M281.0 292v6h6v-6"/><rect class="er-bx" x="312" y="300" width="24" height="30" rx="3"/><path class="er-tp" d="M312 306H336M321.0 300v6h6v-6"/><rect class="er-bx" x="342" y="290" width="24" height="40" rx="3"/><path class="er-tp" d="M342 296H366M351.0 290v6h6v-6"/>
      <g class="er-sbx"><rect class="er-bx new" x="276" y="162" width="32" height="34" rx="3"/><path class="er-tp" d="M276 168H308M289 162v6h6v-6"/></g>
      <g class="er-lot"><rect class="er-lotb" x="312" y="168" width="48" height="26" rx="5"/><path class="er-bar" d="M318 176v10M322 176v10M325 176v10M330 176v10M334 176v10M338 176v10M343 176v10M347 176v10"/><text class="er-lt" x="336" y="192" text-anchor="middle">L-0425</text></g>
      <ellipse class="sc-shd" cx="150" cy="333" rx="64" ry="6"/>
      <g class="er-fkm"><g class="er-fk">
        <ellipse class="sc-shd" cx="40" cy="334" rx="52" ry="5"/>
        <rect class="er-fb" x="0" y="272" width="58" height="48" rx="9"/><rect class="er-fs" x="0" y="296" width="58" height="8"/>
        <rect class="er-fr" x="4" y="246" width="44" height="5" rx="2.500"/><path class="er-fp" d="M8 251V274M44 251V274"/>
        <ellipse class="p2-skin" cx="26" cy="262" rx="9" ry="10"/><ellipse class="p2-skin" cx="35.200" cy="263" rx="1.800" ry="2.300"/><path class="sc-hat" d="M16.500 261a9.500 8.500 0 0 1 19 0z"/><rect class="sc-hat" x="14.500" y="259.500" width="23" height="3" rx="1.500"/><ellipse class="p2-eyew" cx="30" cy="264" rx="1.900" ry="2"/><circle class="p2-iris" cx="30.500" cy="264.200" r="1.150"/><circle class="p2-blush" cx="28.500" cy="268" r="2"/><path class="p2-mouth" style="stroke-width:1.400" d="M23 270.500Q27 273.500 31 270.500"/>
        <rect class="er-mt" x="60" y="196" width="7" height="124" rx="3"/>
        <g class="er-fork"><rect class="er-fkc" x="58" y="300" width="9" height="16" rx="2"/><rect class="er-fkf" x="64" y="312" width="38" height="5" rx="2"/>
          <g class="er-cb"><rect class="er-bx new" x="70" y="278" width="32" height="34" rx="3"/><path class="er-tp" d="M70 284H102M83 278v6h6v-6"/></g></g>
        <g class="er-wh"><circle class="er-w" cx="14" cy="324" r="11"/><path class="er-p" d="M14 316v16M6 324h16"/></g><g class="er-wh"><circle class="er-w" cx="46" cy="324" r="11"/><path class="er-p" d="M46 316v16M38 324h16"/></g>
      </g></g>
      <rect class="er-desk" x="414" y="284" width="136" height="12" rx="3"/><path class="er-leg" d="M424 296v34M540 296v34"/>
      <rect class="er-mon" x="428" y="226" width="64" height="48" rx="6"/><rect class="er-scr" x="433" y="231" width="54" height="34" rx="3"/>
      <path class="er-ml" d="M439 240H478M439 248H470M439 256H474"/><path class="er-leg" d="M460 274v10M448 284H472"/>
      <g class="er-ps"><rect class="er-pp" x="498" y="224" width="44" height="58" rx="4"/><text class="er-pt" x="520" y="238" text-anchor="middle">FACTURA</text><path class="er-pl" d="M524 246H536M524 254H536"/><rect class="er-qr" x="503" y="244" width="4" height="4"/><rect class="er-qr" x="513" y="244" width="4" height="4"/><rect class="er-qr" x="508" y="249" width="4" height="4"/><rect class="er-qr" x="503" y="254" width="4" height="4"/><rect class="er-qr" x="513" y="254" width="4" height="4"/></g>
      <g class="er-mark"><rect class="er-mr" x="496" y="259" width="48" height="19" rx="5"/><text class="er-mt2" x="520" y="272" text-anchor="middle">TIMBRADA</text></g>
      <circle class="er-sw" cx="520" cy="268" r="10"/>
      <g class="er-stamp"><path class="er-arm" d="M520 130V222"/><circle class="sc-handc" cx="520" cy="224" r="8"/><rect class="er-sth" x="514" y="232" width="12" height="22" rx="5"/><rect class="er-stb" x="502" y="254" width="36" height="9" rx="3"/></g>
      <g class="sc-tag er-tag"><rect class="sc-tagb" x="148" y="346" width="264" height="32" rx="16"/><circle class="sc-tagc" cx="170" cy="362" r="9.500"/><path class="sc-ck" d="M165 362l3.500 3.500 6.500-7"/><text class="sc-txt2" x="186" y="367">Un solo flujo, sin recapturar</text></g>
    </g>
  </svg>
</div>
                <p class="hero__note"><?= a_icon('route') ?><span><strong>Un solo hilo de principio a fin</strong>Cada documento hereda del anterior, sin recapturar.</span></p>
            </div>
        </div>
    </div>
</section>

<!-- Qué es ---------------------------------------------------------------- -->
<section class="section section--tight" id="producto">
    <div class="container">
        <h2 class="sr-only">Qué es Alkes ERP, para quién es y qué resuelve</h2>
        <div class="mosaic" data-reveal>
            <div class="card card--big">
                <p class="eyebrow">Qué es</p>
                <h3>Un ERP con el ciclo completo</h3>
                <p>Once áreas conectadas: ventas, compras, almacén, producción, contratos, finanzas, atención al cliente, proyectos, recursos humanos, reportes y parámetros. Los documentos se encadenan entre sí.</p>
                <p class="muted">Alkes ERP concentra la operación de la empresa en un solo lugar: lo que se cotiza, se compra, se almacena, se produce, se vende, se factura, se cobra y se paga, con 153 reportes y trazabilidad entre etapas.</p>
            </div>
            <div class="card card--md">
                <p class="eyebrow">Para quién</p>
                <h3>Empresas que compran, producen y facturan</h3>
                <p class="muted">Operaciones con inventario propio, procesos de producción por receta, punto de venta y obligación de facturar electrónicamente en México.</p>
            </div>
            <div class="card card--md">
                <p class="eyebrow">Qué resuelve</p>
                <h3>Los sistemas que no se hablan</h3>
                <p class="muted">Evita recapturar la misma información en compras, almacén y facturación, y perder la trazabilidad entre etapas.</p>
            </div>
        </div>
    </div>
</section>

<!-- Capacidades ----------------------------------------------------------- -->
<section class="section" id="capacidades">
    <div class="container">
        <header class="head" data-reveal>
            <p class="eyebrow">Capacidades</p>
            <h2>Cada área del negocio, conectada con las demás</h2>
            <p class="lede">Ventas, compras, almacén, producción, finanzas, atención al cliente y personal comparten la misma información, sin capturas duplicadas.</p>
        </header>

        <div data-reveal>
            <div class="tabs" role="tablist" aria-label="Áreas de Alkes ERP">
                <?php foreach ($CAPACIDADES as $i => $c): ?>
                <button class="tab" type="button" role="tab" id="tab-<?= a_e($c['id']) ?>" aria-selected="<?= $i === 0 ? 'true' : 'false' ?>"<?= $i === 0 ? '' : ' tabindex="-1"' ?> aria-controls="panel-<?= a_e($c['id']) ?>"><?= a_e($c['tab']) ?></button>
                <?php endforeach; ?>
            </div>
            <?php foreach ($CAPACIDADES as $i => $c): ?>
            <div class="cap-panel" role="tabpanel" id="panel-<?= a_e($c['id']) ?>" aria-labelledby="tab-<?= a_e($c['id']) ?>"<?= $i === 0 ? '' : ' hidden' ?>>
                <div class="split">
                    <div class="split__body">
                        <p class="eyebrow"><?= a_e($c['eyebrow']) ?></p>
                        <h3 style="font-size:clamp(1.5rem,1.4vw + 1rem,2rem)"><?= a_e($c['h3']) ?></h3>
                        <p class="muted"><?= a_e($c['p']) ?></p>
                        <ul class="feat-list">
                            <?php foreach ($c['items'] as $it): ?>
                            <li><span class="ico"><?= a_icon($it[0]) ?></span><div><strong><?= a_e($it[1]) ?></strong><p><?= a_e($it[2]) ?></p></div></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="split__media">
                        <?= er_ventana($c['img'], $c['alt'], $c['w'], $c['h']) ?>
                        <p class="cap"><?= a_e($c['cap']) ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="group" data-reveal>
            <h3>Y todo lo que sostiene la operación</h3>
            <div class="items items--3"><?= er_items($SOSTIENE) ?></div>
            <details class="more">
                <summary>Ver más del sistema<?= a_icon('chevron') ?></summary>
                <h3 style="margin-top:22px;margin-bottom:0">Más del sistema</h3>
                <div class="items items--3"><?= er_items($AVANZADAS) ?></div>
            </details>
        </div>
    </div>
</section>

<!-- Reportes -------------------------------------------------------------- -->
<section class="section section--sunken" id="reportes">
    <div class="container">
        <header class="head" data-reveal>
            <p class="eyebrow">Reportes</p>
            <h2>153 reportes en 14 categorías</h2>
            <p class="lede">De las ventas del día al balance general: indicadores del periodo, gráficas, periodos listos con un clic y una impresión limpia con el encabezado de tu empresa.</p>
        </header>
        <div class="group" data-reveal>
            <div class="items items--3"><?= er_reportes_items(array_slice($REPORTES, 0, 6)) ?></div>
            <details class="more">
                <summary>Ver las 14 categorías<?= a_icon('chevron') ?></summary>
                <div class="items items--3"><?= er_reportes_items(array_slice($REPORTES, 6)) ?></div>
            </details>
        </div>
    </div>
</section>

<!-- Por qué Alkes ERP ------------------------------------------------------ -->
<section class="section" id="resultados">
    <div class="container">
        <header class="head" data-reveal>
            <p class="eyebrow">Por qué Alkes ERP</p>
            <h2>El sistema completo, sin módulos de pago</h2>
            <p class="lede">No hay ediciones ni módulos extra por contratar: todas las áreas están incluidas y el precio depende solo de cuántos usuarios tienes.</p>
        </header>

        <div class="why" data-reveal>
            <div class="why__col">
                <p class="eyebrow">Un solo hilo</p>
                <h3>Lo que hoy vive repartido, en un mismo expediente</h3>
                <p class="muted">El ciclo que hoy se reparte entre correos, hojas de cálculo y el sistema de facturación, dentro de un mismo expediente.</p>
                <ul class="checks">
                    <li><div><strong>Sin recapturar</strong><p>Cada documento hereda las partidas del anterior.</p></div></li>
                    <li><div><strong>Factura desde la venta</strong><p>La facturación no es un servicio aparte que haya que alimentar a mano: nace del documento de venta.</p></div></li>
                    <li><div><strong>Trazabilidad por lote y serie</strong><p>El movimiento de inventario conserva el lote y la serie de cada partida.</p></div></li>
                    <li><div><strong>Cuentas por cobrar y pagar ligadas</strong><p>El estado financiero de cada cliente y proveedor, ligado a sus documentos.</p></div></li>
                    <li><div><strong>Permisos por persona</strong><p>Cada quien ve y opera únicamente lo que su rol le permite.</p></div></li>
                    <li><div><strong>Reportes de todas las áreas</strong><p>153 reportes, con periodos listos y comparativos.</p></div></li>
                </ul>
            </div>
            <div class="why__col">
                <p class="eyebrow">Integración con tu operación</p>
                <p class="muted">Alkes ERP se adapta a cómo trabaja tu empresa, no al revés.</p>
                <div>
                    <details class="disc" open>
                        <summary class="disc__sum"><span class="disc__t">De la requisición a la factura</span><?= a_icon('chevron', 'disc__chev') ?></summary>
                        <div class="disc__body"><p>Se pide, se cotiza, se recibe, se produce y se factura dentro del mismo sistema, y cada paso hereda del anterior.</p></div>
                    </details>
                    <details class="disc">
                        <summary class="disc__sum"><span class="disc__t">Varias sucursales</span><?= a_icon('chevron', 'disc__chev') ?></summary>
                        <div class="disc__body"><p>Configuras la empresa y sus sucursales, cada una con sus usuarios, sus permisos y sus folios.</p></div>
                    </details>
                    <details class="disc">
                        <summary class="disc__sum"><span class="disc__t">Facturación CFDI 4.0</span><?= a_icon('chevron', 'disc__chev') ?></summary>
                        <div class="disc__body"><p>Facturas, complementos de pago y notas de crédito, con timbrado ante el SAT a través de PAC y una bitácora de cada operación.</p></div>
                    </details>
                    <details class="disc">
                        <summary class="disc__sum"><span class="disc__t">Autorizaciones en un solo lugar</span><?= a_icon('chevron', 'disc__chev') ?></summary>
                        <div class="disc__body"><p>Todo documento que espera tu autorización, de cualquier área, con quién lo pidió, desde cuándo y por cuánto.</p></div>
                    </details>
                </div>
                <div class="dif">
                    <p class="eyebrow">La diferencia Alkes ERP</p>
                    <p class="lede">No ofrecemos solo un software, ofrecemos una solución completa para operar tu empresa. Con soporte directo del equipo que lo desarrolla, tu inversión evoluciona contigo.</p>
                </div>
            </div>
        </div>

        <div class="facts" data-reveal>
            <div class="fact"><b>11 áreas conectadas</b><span>De ventas a recursos humanos.</span></div>
            <div class="fact"><b>153 reportes</b><span>En 14 categorías.</span></div>
            <div class="fact"><b>CFDI 4.0 integrado</b><span>Timbrado desde la venta.</span></div>
            <div class="fact"><b>Lote y serie</b><span>Trazabilidad en cada movimiento.</span></div>
        </div>
    </div>
</section>

<!-- Precios --------------------------------------------------------------- -->
<section class="section section--sunken" id="precios">
    <div class="container">
        <header class="head" data-reveal>
            <p class="eyebrow">Precios</p>
            <h2>Un precio por usuario, sin módulos de pago</h2>
            <p class="lede">Pagas por cada usuario con cuenta activa, y el precio baja con cada usuario que sumas. Incluye todas las áreas del sistema, el soporte, las actualizaciones y la implantación.</p>
        </header>
        <div data-reveal><?= er_tarifas_html(ALKES_CENTRAL . '/?producto=erp') ?></div>
        <ul class="plan-foot" data-reveal>
            <li><?= a_icon('check') ?>Todas las áreas incluidas</li>
            <li><?= a_icon('check') ?>Soporte y actualizaciones incluidos</li>
            <li><?= a_icon('check') ?>Implantación incluida</li>
            <li><?= a_icon('check') ?>Facturación CFDI 4.0</li>
            <li><?= a_icon('check') ?>Roles y permisos por usuario</li>
            <li><?= a_icon('check') ?>Multi-sucursal</li>
            <li><?= a_icon('check') ?>Precios en pesos mexicanos</li>
        </ul>
    </div>
</section>

<!-- Preguntas frecuentes -------------------------------------------------- -->
<section class="section" id="preguntas">
    <div class="container">
        <div class="faq">
            <div class="faq__intro" data-reveal>
                <p class="eyebrow">Preguntas frecuentes</p>
                <h2>Lo que más nos preguntan sobre Alkes ERP</h2>
                <p class="muted">¿Tienes otra duda? Escríbenos a <a href="mailto:<?= ALKES_MAIL ?>"><?= ALKES_MAIL ?></a>.</p>
            </div>
            <div class="faq__list" data-reveal>
                <?php foreach (er_faq() as $i => $f): ?>
                <details class="disc"<?= $i === 0 ? ' open' : '' ?>>
                    <summary class="disc__sum"><span class="disc__t"><?= a_e($f['q']) ?></span><?= a_icon('chevron', 'disc__chev') ?></summary>
                    <div class="disc__body"><p><?= a_e($f['a']) ?></p></div>
                </details>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- Confianza ------------------------------------------------------------- -->
<section class="section section--sunken" id="confianza">
    <div class="container">
        <header class="head" data-reveal>
            <p class="eyebrow">Confianza</p>
            <h2>Un equipo con nombre, correo y teléfono</h2>
            <p class="lede">Alkes ERP es un producto de Alkes. Nuestro equipo desarrolla, opera y da soporte al mismo sistema.</p>
        </header>
        <div class="tiles" data-reveal>
            <div class="tile"><?= a_icon('display') ?><h3>Sin instalar nada</h3><p>Se usa desde el navegador, en la computadora o en el celular.</p></div>
            <div class="tile"><?= a_icon('history') ?><h3>Bitácoras de todo</h3><p>Timbrado, correos y el historial de cada documento, con autor y fecha.</p></div>
            <div class="tile"><?= a_icon('lock') ?><h3>Permisos por rol</h3><p>Cada persona ve y opera únicamente lo que su rol le permite.</p></div>
            <div class="tile"><?= a_icon('route') ?><h3>Documentos encadenados</h3><p>Cada documento hereda del anterior, sin recapturar información.</p></div>
        </div>
        <div class="team" data-reveal>
            <div>
                <h3>Soporte del equipo que construye Alkes ERP</h3>
                <p>Nuestro equipo desarrolla, opera y da soporte a Alkes ERP de principio a fin. Para soporte técnico, una demostración guiada o un módulo a la medida de tu operación, hablas directamente con el equipo que construye el sistema.</p>
            </div>
            <div class="team__links">
                <a class="btn btn--primary" href="<?= a_e(er_url_agendar()) ?>"><?= a_icon('mail') ?>Escribir al equipo</a>
                <a class="btn btn--line" href="tel:<?= ALKES_TEL ?>"><?= a_icon('phone') ?><?= ALKES_TEL_TXT ?></a>
                <a class="btn btn--line" href="<?= ER_WHATSAPP ?>" target="_blank" rel="noopener">WhatsApp<?= a_icon('external') ?></a>
            </div>
        </div>
    </div>
</section>

<!-- Novedades ------------------------------------------------------------- -->
<section class="section" id="novedades">
    <div class="container narrow">
        <header class="head" data-reveal>
            <p class="eyebrow">Novedades</p>
            <h2>El producto se mueve, y queda por escrito</h2>
            <p class="lede">Historial público de versiones: lo que se entregó, cuándo y qué cambia en tu trabajo diario.</p>
        </header>
        <div data-reveal>
            <?php include __DIR__ . '/_novedades_recientes.php'; ?>
        </div>
    </div>
</section>

<!-- Cierre ---------------------------------------------------------------- -->
<section class="section section--tight">
    <div class="container">
        <div class="cta" data-reveal>
            <div>
                <p class="eyebrow">Empieza hoy</p>
                <h2>Veámoslo con tu operación en la mano</h2>
                <p class="lede">Entra al demo con las credenciales de prueba, o escríbenos y lo revisamos contigo con tus propios procesos.</p>
            </div>
            <div class="cta__act">
                <a class="btn btn--cta btn--lg" href="<?= a_e($URL_APP) ?>" data-open-demo><?= a_icon('play') ?>Probar el demo</a>
                <a class="btn btn--line btn--lg" href="#precios">Ver precios</a>
                <a class="link" href="<?= a_e(er_url_agendar()) ?>">Agendar demostración guiada<?= a_icon('arrow') ?></a>
            </div>
        </div>
    </div>
</section>

<!-- Contacto -------------------------------------------------------------- -->
<section class="section section--sunken" id="contacto">
    <div class="container">
        <header class="head" data-reveal>
            <p class="eyebrow">Contacto</p>
            <h2>Hablemos</h2>
            <p class="lede">Dudas sobre alcance, módulos, implantación o integración. Tu mensaje llega a una bandeja real.</p>
        </header>
        <div class="contact" data-reveal>
            <a class="contact__item" href="mailto:<?= ALKES_MAIL ?>"><?= a_icon('mail') ?><span class="contact__k">Correo</span><span class="contact__v"><?= ALKES_MAIL ?></span><span class="contact__d">Respuesta en horario hábil.</span></a>
            <a class="contact__item" href="tel:<?= ALKES_TEL ?>"><?= a_icon('phone') ?><span class="contact__k">Teléfono</span><span class="contact__v"><?= ALKES_TEL_TXT ?></span><span class="contact__d">Para demostraciones guiadas.</span></a>
            <a class="contact__item" href="<?= ER_WHATSAPP ?>" target="_blank" rel="noopener"><?= a_icon('phone') ?><span class="contact__k">WhatsApp</span><span class="contact__v"><?= ALKES_TEL_TXT ?></span><span class="contact__d">Escríbenos por mensaje.</span></a>
            <a class="contact__item" href="<?= a_e($URL_APP) ?>"><?= a_icon('login') ?><span class="contact__k">Acceso</span><span class="contact__v">app.erp.alkes.mx</span><span class="contact__d">Entra a tu cuenta de Alkes ERP.</span></a>
        </div>
        <div class="redes" data-reveal>
            <span class="redes__k">Síguenos</span>
            <?php foreach (er_redes() as $r): ?>
            <a href="<?= a_e($r['u']) ?>" target="_blank" rel="noopener"><?= a_e($r['n']) ?><?= a_icon('external') ?></a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Ecosistema ------------------------------------------------------------ -->
<section class="section section--tight" id="ecosistema">
    <div class="container">
        <header class="head" data-reveal>
            <p class="eyebrow">Ecosistema Alkes</p>
            <h2>Alkes ERP no está solo</h2>
            <p class="lede">Cinco productos desarrollados, alojados y operados por Alkes. Mismo soporte, misma casa.</p>
        </header>
        <?= a_ecosistema_grid($PROD) ?>
    </div>
</section>

</main>

<footer class="footer">
    <div class="container footer__top">
        <div class="footer__brand">
            <span class="brand"><?= er_logo(34) ?><span>Alkes ERP</span></span>
            <p>Sistema de gestión empresarial con ventas, compras, almacén, producción y finanzas integrados, y facturación electrónica CFDI 4.0.</p>
        </div>
        <div class="footer__cols">
            <div class="footer__col">
                <h2 class="footer__h">Producto</h2>
                <ul>
                    <li><a href="#producto">Qué es</a></li>
                    <li><a href="#capacidades">Capacidades</a></li>
                    <li><a href="#reportes">Reportes</a></li>
                    <li><a href="#precios">Planes y precios</a></li>
                    <li><a href="#preguntas">Preguntas frecuentes</a></li>
                    <li><a href="#novedades">Novedades</a></li>
                                    </ul>
            </div>
            <div class="footer__col">
                <h2 class="footer__h">Accesos</h2>
                <ul>
                    <li><a href="<?= a_e($URL_APP) ?>">Iniciar sesión</a></li>
                    <li><a href="<?= a_e($URL_APP) ?>" data-open-demo>Probar el demo</a></li>
                    <li><a href="<?= ALKES_CENTRAL ?>">Contratar</a></li>
                    <li><a href="<?= ALKES_SITIO ?>">Alkes</a></li>
                </ul>
            </div>
            <div class="footer__col">
                <h2 class="footer__h">Legal</h2>
                <ul>
                    <li><a href="/terminos/">Términos y condiciones</a></li>
                    <li><a href="/privacidad/">Aviso de privacidad</a></li>
                    <li><a href="/cookies/">Cookies</a></li>
                    <li><a href="/encargo-de-datos/">Tratamiento de datos</a></li>
                </ul>
            </div>
            <div class="footer__col">
                <h2 class="footer__h">Síguenos</h2>
                <ul>
                    <?php foreach (er_redes() as $r): ?>
                    <li><a href="<?= a_e($r['u']) ?>" target="_blank" rel="noopener"><?= a_e($r['n']) ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="footer__bot">
            <p>© <?= date('Y') ?> Alkes. Alkes ERP es un producto de Alkes. Todos los derechos reservados.</p>
        </div>
    </div>
</footer>

<?= er_dialogo_demo($URL_APP) ?>

<script src="assets/js/erp.js" defer></script>
</body>
</html>
