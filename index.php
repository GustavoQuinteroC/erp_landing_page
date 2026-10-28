<?php
$NOINDEX = false;

// Contacto institucional. Se define antes de cargar el kit: el kit solo
// define estas constantes si no existen.
define('ALKES_MAIL',    'soporte@alkes.mx');
define('ALKES_TEL',     '+523339460097');
define('ALKES_TEL_TXT', '333 946 0097');


if (!defined('ER_SITIO'))     { define('ER_SITIO', 'https://erp.alkes.mx'); }
if (!defined('ER_APP'))       { define('ER_APP', 'https://app.erp.alkes.mx'); }
if (!defined('ER_WHATSAPP'))  { define('ER_WHATSAPP', 'https://wa.me/523339460097'); }

/** Redes oficiales de Alkes. */
function er_redes()
{
    return array(
        array('n' => 'Facebook',  'u' => 'https://www.facebook.com/alkes.mx'),
        array('n' => 'Instagram', 'u' => 'https://www.instagram.com/alkes.mx'),
        array('n' => 'LinkedIn',  'u' => 'https://www.linkedin.com/company/alkes-mx'),
        array('n' => 'TikTok',    'u' => 'https://www.tiktok.com/@alkes.mx'),
    );
}

/** Mensaje de partida para pedir una demostración guiada. */
function er_url_agendar()
{
    return 'mailto:' . ALKES_MAIL . '?subject=' . rawurlencode('Demostración guiada de Alkes ERP');
}

/** Logo en dos versiones; el CSS muestra la que corresponde al tema. */
function er_logo($px = 34)
{
    $px = (int) $px;
    return '<img class="logo logo--claro" src="assets/img/logo.png" alt="" width="' . $px . '" height="' . $px . '">'
         . '<img class="logo logo--oscuro" src="assets/img/logo-blanco.png" alt="" width="' . $px . '" height="' . $px . '">';
}

/**
 * Captura dentro de una ventana de navegador. Si existe la versión oscura se
 * pintan las dos y el CSS muestra la del tema activo.
 */
function er_ventana($archivo, $alt, $w, $h, $url = 'app.erp.alkes.mx', $carga = 'lazy')
{
    $existe = is_file(__DIR__ . '/' . $archivo);
    $osc    = preg_replace('/\.(png|jpe?g|webp)$/i', '-oscuro.$1', $archivo);
    $hayOsc = $osc !== $archivo && is_file(__DIR__ . '/' . $osc);
    $o  = '<figure class="win">';
    $o .= '<div class="win__bar"><span class="win__dots" aria-hidden="true"><i></i><i></i><i></i></span>';
    $o .= '<span class="win__url">' . a_e($url) . '</span></div>';
    $o .= '<div class="win__shot" style="--ar:' . (int) $w . ' / ' . (int) $h . '">';
    if ($existe) {
        $o .= '<img src="' . a_e($archivo) . '" alt="' . a_e($alt) . '"' . ($hayOsc ? ' data-tema-img="claro"' : '')
            . ' width="' . (int) $w . '" height="' . (int) $h . '" loading="' . a_e($carga) . '" decoding="async">';
        if ($hayOsc) {
            $o .= '<img src="' . a_e($osc) . '" alt="' . a_e($alt) . '" data-tema-img="oscuro"'
                . ' width="' . (int) $w . '" height="' . (int) $h . '" loading="' . a_e($carga) . '" decoding="async">';
        }
    } else {
        $o .= '<div class="win__falta"><b>Captura pendiente</b><code>' . a_e($archivo) . '</code></div>';
    }
    return $o . '</div></figure>';
}

/** Tarifa por usuario (tarifa.json): el descuento sube 1% por cada usuario adicional hasta el tope, y aplica al precio de todos. */
function er_tarifa()
{
    static $t = null;
    if ($t !== null) { return $t; }
    $t = array('anual_meses' => 10, 'base' => 500, 'paso' => 0.01, 'tope_descuento' => 0.5);
    $f = __DIR__ . '/tarifa.json';
    if (is_file($f)) {
        $j = json_decode((string) @file_get_contents($f), true);
        if (is_array($j) && !empty($j['base'])) { $t = $j + $t; }
    }
    return $t;
}

/** Mensualidad para $n usuarios: descuento de (n-1) × paso, con tope; el precio por usuario va a centavos. */
function er_calcular($n)
{
    $n = max(1, (int) $n);
    $t = er_tarifa();
    $d = min((float) $t['tope_descuento'], ($n - 1) * (float) $t['paso']);
    $precio = round((float) $t['base'] * (1 - $d), 2);
    return array('total' => round($n * $precio, 2), 'precio' => $precio, 'n' => $n, 'descuento' => $d);
}

/** Precio por usuario más alto (calculadora y checkout; la publicidad no lo cita). */
function er_tarifa_max()
{
    return (float) er_tarifa()['base'];
}

/** Precio por usuario más bajo (el que se anuncia). */
function er_tarifa_min()
{
    $t = er_tarifa();
    return round((float) $t['base'] * (1 - (float) $t['tope_descuento']), 2);
}

/** Usuario desde el que aplica el descuento máximo. */
function er_tarifa_tope_usuarios()
{
    $t = er_tarifa();
    return (int) ceil((float) $t['tope_descuento'] / (float) $t['paso']) + 1;
}

/** Sección de precios: explicación y calculadora. Sin JS se ve la explicación. */
function er_tarifas_html($url_base)
{
    $t = er_tarifa();
    $meses = (int) $t['anual_meses'];
    $pct = rtrim(rtrim(number_format((float) $t['paso'] * 100, 2, '.', ''), '0'), '.');
    $top = (int) round((float) $t['tope_descuento'] * 100);
    $h  = '<div class="tarifa" data-tarifa="' . a_e(json_encode($t, JSON_UNESCAPED_UNICODE)) . '" data-url="' . a_e($url_base) . '">';

    $h .= '<div class="tarifa__card"><p class="eyebrow">Precio por usuario</p>';
    $h .= '<p class="tarifa__desde"><small>Desde</small><b>$' . a_num(er_tarifa_min()) . '</b><small>MXN por usuario al mes</small></p>';
    $h .= '<h3>Más usuarios, menos pagas por cada uno</h3>';
    $h .= '<ul class="tarifa__reglas">';
    $h .= '<li>' . a_icon('check') . 'Cada usuario adicional baja ' . $pct . '% el precio de todos tus usuarios.</li>';
    $h .= '<li>' . a_icon('check') . 'Arriba de ' . (er_tarifa_tope_usuarios() - 1) . ' usuarios, obtienes el descuento máximo de ' . $top . '%.</li>';
    $h .= '<li>' . a_icon('check') . 'Incluye todas las áreas del sistema, el soporte, las actualizaciones y la implantación. Sin módulos de pago.</li>';
    $h .= '<li>' . a_icon('check') . 'Al sumar un usuario se cobra al momento la parte proporcional del periodo. Al reducir tus usuarios contratados, el cobro menor rige desde tu siguiente renovación.</li>';
    $h .= '<li>' . a_icon('check') . 'Con el plan anual solo pagas ' . $meses . ' meses, y los otros ' . (12 - $meses) . ' son gratis.</li>';
    $h .= '</ul></div>';

    $h .= '<div class="tarifa__card tarifa__calc" hidden data-calc>';
    $h .= '<p class="eyebrow">Calcula tu mensualidad</p>';
    $h .= '<label class="tarifa__lbl" for="tarifa-n">¿Cuántos usuarios tendrás?</label>';
    $h .= '<input class="tarifa__in" id="tarifa-n" type="number" inputmode="numeric" min="1" max="100000" value="1">';
    $h .= '<div class="period period--sm" role="group" aria-label="Periodo de facturación">';
    $h .= '<button type="button" data-per="mensual" aria-pressed="true">Mensual</button>';
    $h .= '<button type="button" data-per="anual" aria-pressed="false">Anual<span class="save">−17%</span></button></div>';
    $h .= '<ul class="tarifa__desg" data-desg></ul>';
    $h .= '<p class="tarifa__tot"><span data-tot>$0</span><small data-per-txt>MXN al mes</small></p>';
    $h .= '<p class="tarifa__prom muted" data-prom></p>';
    $h .= '<a class="btn btn--primary btn--block" data-cta href="' . a_e($url_base) . '">Contratar' . a_icon('arrow') . '</a>';
    $h .= '</div>';
    $h .= '</div>';
    return $h;
}

/** Diálogo con las credenciales del demo. */
function er_dialogo_demo($url_app)
{
    $h  = '<dialog id="demoDialog" aria-labelledby="demoTitulo"><div class="dlg">';
    $h .= '<h2 id="demoTitulo">Acceso al demo</h2>';
    $h .= '<p>Entra a la empresa de demostración con estas credenciales. No captures información real.</p>';
    $h .= '<dl class="dlg__creds"><div><dt>Usuario</dt><dd>demo@alkes.mx</dd></div>';
    $h .= '<div><dt>Contraseña</dt><dd>Demo@Alkes2026</dd></div></dl>';
    $h .= '<p>Para una demostración guiada escríbenos a <a href="' . a_e(er_url_agendar()) . '">' . ALKES_MAIL . '</a>, '
        . 'llama al <a href="tel:' . ALKES_TEL . '">' . ALKES_TEL_TXT . '</a> o usa '
        . '<a href="' . ER_WHATSAPP . '" target="_blank" rel="noopener">WhatsApp</a>.</p>';
    $h .= '<div class="dlg__foot"><a class="btn btn--primary" href="' . a_e($url_app) . '" target="_blank" rel="noopener">Ir a la app' . a_icon('external') . '</a>';
    $h .= '<button class="btn btn--line" type="button" data-close-demo>Cerrar</button></div>';
    return $h . '</div></dialog>';
}

/** Preguntas frecuentes: la misma lista alimenta la sección y el JSON-LD. */
function er_faq()
{
    return array(
        array('q' => '¿Qué es Alkes ERP?',
              'a' => 'Un sistema de gestión empresarial de Alkes que conecta ventas, compras, almacén, producción, finanzas y contabilidad, atención al cliente, proyectos y recursos humanos, con facturación electrónica CFDI 4.0 integrada.'),
        array('q' => '¿Cuánto cuesta?',
              'a' => er_faq_precio() . ' Incluye todas las áreas del sistema.'),
        array('q' => '¿Cómo se calcula mi mensualidad?',
              'a' => er_faq_calculo()),
        array('q' => '¿Qué pasa si agrego o quito usuarios a mitad del periodo?',
              'a' => er_faq_altas()),
        array('q' => '¿Qué incluye el precio?',
              'a' => 'Todas las áreas del sistema, el soporte, las actualizaciones y la implantación. El precio depende solo del número de usuarios con cuenta activa.'),
        array('q' => '¿Hay módulos o ediciones de pago aparte?',
              'a' => 'No. Todas las áreas del sistema están incluidas y el precio depende solo del número de usuarios; tú decides qué usuario tiene qué permisos.'),
        array('q' => '¿Emite facturas CFDI 4.0?',
              'a' => 'Sí. La factura nace de la venta registrada en el sistema y se timbra ante el SAT a través de PAC desde la misma pantalla. Cada operación de timbrado queda en una bitácora. También maneja complementos de pago y notas de crédito.'),
        array('q' => '¿Qué áreas incluye?',
              'a' => 'Ventas (con punto de venta), compras, almacén, producción, contratos, finanzas (cuentas por cobrar y por pagar, gastos, tesorería, contabilidad e impuestos), atención al cliente, proyectos, recursos humanos, reportes y parámetros.'),
        array('q' => '¿Controla lotes y números de serie?',
              'a' => 'Sí. El movimiento de inventario conserva el lote y el número de serie de cada partida, y hay un reporte de trazabilidad de lote.'),
        array('q' => '¿Sirve para varias sucursales?',
              'a' => 'Sí. Se configuran la empresa y sus sucursales, cada una con sus usuarios y permisos.'),
        array('q' => '¿Cuántos reportes trae?',
              'a' => '153 reportes en 14 categorías, de ventas, compras, almacén, producción, cartera, tesorería, contabilidad e impuestos (incluida la DIOT), entre otras.'),
        array('q' => '¿Hay que instalar algo?',
              'a' => 'No. Se usa desde el navegador, en la computadora o en el celular.'),
        array('q' => '¿Puedo probarlo?',
              'a' => 'Sí, con el demo y sus credenciales de prueba.'),
    );
}

/** Datos estructurados. Todo sale de lo que la página dice; sin reseñas ni calificaciones. */
function er_jsonld($seo = array())
{
    $ofertas = array(
        '@type' => 'AggregateOffer',
        'priceCurrency' => 'MXN',
        'lowPrice' => (string) er_tarifa_min(),
        'highPrice' => (string) er_tarifa_max(),
        'url' => ER_SITIO . '/#precios',
    );
    $faq = array();
    foreach (er_faq() as $f) {
        $faq[] = array('@type' => 'Question', 'name' => $f['q'],
                       'acceptedAnswer' => array('@type' => 'Answer', 'text' => $f['a']));
    }
    $redes = array();
    foreach (er_redes() as $r) { $redes[] = $r['u']; }

    $g = array(
        '@context' => 'https://schema.org',
        '@graph' => array(
            array('@type' => 'Organization', '@id' => ALKES_SITIO . '/#org', 'name' => 'Alkes', 'url' => ALKES_SITIO,
                  'email' => ALKES_MAIL, 'telephone' => ALKES_TEL, 'sameAs' => $redes),
            array('@type' => 'WebSite', '@id' => ER_SITIO . '/#web', 'name' => 'Alkes ERP', 'url' => ER_SITIO . '/',
                  'inLanguage' => 'es-MX', 'publisher' => array('@id' => ALKES_SITIO . '/#org')),
            array('@type' => 'SoftwareApplication', '@id' => ER_SITIO . '/#app', 'name' => 'Alkes ERP',
                  'applicationCategory' => 'BusinessApplication', 'operatingSystem' => 'Web',
                  'description' => 'ERP en la nube con ventas, compras, almacén, producción, finanzas y contabilidad, atención al cliente, proyectos y recursos humanos, con facturación CFDI 4.0.',
                  'url' => ER_SITIO . '/', 'inLanguage' => 'es-MX', 'image' => ER_SITIO . '/assets/img/og-image.png',
                  'publisher' => array('@id' => ALKES_SITIO . '/#org'), 'offers' => $ofertas),
            array('@type' => 'FAQPage', '@id' => ER_SITIO . '/#faq', 'mainEntity' => $faq),
        ),
    );
    $g = seo_enriquecer($g, $seo);
    return json_encode($g, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG);
}

/** Texto de precio para las preguntas frecuentes. */
function er_faq_precio()
{
    $t = er_tarifa();
    $pct = rtrim(rtrim(number_format((float) $t['paso'] * 100, 2, '.', ''), '0'), '.');
    return 'Desde $' . a_num(er_tarifa_min()) . ' MXN por usuario al mes. Se cobra por usuario con cuenta activa, y cada usuario adicional baja ' . $pct . '% el precio de todos hasta llegar a ' . (int) round((float) $t['tope_descuento'] * 100) . '% de descuento arriba de ' . (er_tarifa_tope_usuarios() - 1) . ' usuarios. Con el plan anual solo pagas ' . (int) $t['anual_meses'] . ' meses, y los otros ' . (12 - (int) $t['anual_meses']) . ' son gratis.';
}

function er_faq_calculo()
{
    $c15 = er_calcular(15); $c50 = er_calcular(50);
    return 'Todos tus usuarios pagan el mismo precio, que baja con cada usuario que sumas. Con 15 usuarios son 15 × $' . a_num($c15['precio']) . ' = $' . a_num($c15['total']) . ' MXN al mes; con 50 usuarios son 50 × $' . a_num($c50['precio']) . ' = $' . a_num($c50['total']) . ' MXN al mes. La calculadora de la sección de precios te da el total exacto.';
}

function er_faq_altas()
{
    return 'Al sumar un usuario se cobra al momento la parte proporcional hasta tu próxima factura, y desde la siguiente el precio por usuario se ajusta a tu nuevo total. Desactivar un usuario libera su lugar para otra persona, pero no cambia el cobro: para pagar menos, reduce tus usuarios contratados en Configuración y la reducción rige desde la siguiente renovación; no hay reembolso a mitad del periodo.';
}

if (!defined('ALKES_SITIO'))    { define('ALKES_SITIO', 'https://alkes.mx'); }
if (!defined('ALKES_CENTRAL'))  { define('ALKES_CENTRAL', 'https://contratar.alkes.mx'); }
if (!defined('ALKES_MAIL'))     { define('ALKES_MAIL', 'gquintero@alkes.mx'); }
if (!defined('ALKES_TEL'))      { define('ALKES_TEL', '+523339460097'); }
if (!defined('ALKES_TEL_TXT'))  { define('ALKES_TEL_TXT', '333 946 0097'); }

/** Escape de todo dato que entre al HTML. */
function a_e($s) { return htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8'); }

/**
 * La familia completa. Alimenta la rejilla de ecosistema del pie.
 * Orden fijo en las seis landings: la firma tiene que ser reconocible.
 */
function a_familia()
{
    return array(
        'smartpend' => array('nombre' => 'SmartPend', 'url' => 'https://smartpend.alkes.mx', 'que' => 'Pendientes y proyectos'),
        'geocheck'  => array('nombre' => 'GeoCheck',  'url' => 'https://geocheck.alkes.mx',  'que' => 'Asistencia por ubicación'),
        'mantis'    => array('nombre' => 'Mantis',    'url' => 'https://mantis.alkes.mx',    'que' => 'Mantenimiento de activos'),
        'syspower'  => array('nombre' => 'SysPower',  'url' => 'https://syspower.alkes.mx',  'que' => 'Energía controlada a distancia'),
        'erp'       => array('nombre' => 'Alkes ERP', 'url' => 'https://erp.alkes.mx',       'que' => 'Gestión empresarial y CFDI'),
    );
}

// ---------------------------------------------------------------------------
// Iconos. Trazo 1.75, viewBox 24×24, currentColor. Decorativos siempre.
// ---------------------------------------------------------------------------
function a_icon($nombre, $clase = '')
{
    static $d = null;
    if ($d === null) { $d = array(
    'arrow'      => '<path d="M5 12h14M13 6l6 6-6 6"/>',
    'check'      => '<path d="M20 6 9 17l-5-5"/>',
    'close'      => '<path d="M18 6 6 18M6 6l12 12"/>',
    'chevron'    => '<path d="m6 9 6 6 6-6"/>',
    'menu'       => '<path d="M4 7h16M4 12h16M4 17h16"/>',
    'moon'       => '<path d="M21 12.8A9 9 0 1 1 11.2 3a7 7 0 0 0 9.8 9.8Z"/>',
    'sun'        => '<circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4"/>',
    'external'   => '<path d="M14 4h6v6M20 4l-9 9M18 14v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h5"/>',
    'mail'       => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3.5 7 7.6 5.3a1.6 1.6 0 0 0 1.8 0L20.5 7"/>',
    'phone'      => '<path d="M7 3h3l2 5-2.5 1.5a12 12 0 0 0 5 5L16 12l5 2v3a2 2 0 0 1-2.2 2A16.5 16.5 0 0 1 4 5.2 2 2 0 0 1 6 3Z"/>',
    'globe'      => '<circle cx="12" cy="12" r="9"/><path d="M3.5 9h17M3.5 15h17M12 3a15 15 0 0 1 0 18 15 15 0 0 1 0-18Z"/>',
    'shield'     => '<path d="M12 3 5 6v5.5c0 4.2 2.9 7.6 7 9.5 4.1-1.9 7-5.3 7-9.5V6Z"/><path d="m9 12 2 2 4-4"/>',
    'play'       => '<circle cx="12" cy="12" r="9"/><path d="M10.5 9 15 12l-4.5 3Z"/>',
    'eye'        => '<path d="M2.5 12S6 5.5 12 5.5 21.5 12 21.5 12 18 18.5 12 18.5 2.5 12 2.5 12Z"/><circle cx="12" cy="12" r="3"/>',
    'lock'       => '<rect x="4" y="10" width="16" height="11" rx="2"/><path d="M8 10V7a4 4 0 0 1 8 0v3"/>',
    'clock'      => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5.3l3.3 2"/>',
    'history'    => '<path d="M3.5 12a8.5 8.5 0 1 0 2.6-6.1M3.5 5v4h4"/><path d="M12 7.5v5l3.2 1.9"/>',
    'users'      => '<circle cx="9" cy="8" r="3.2"/><path d="M3 20c0-3.3 2.7-5.5 6-5.5s6 2.2 6 5.5"/><path d="M16 5.3a3.2 3.2 0 0 1 0 6.2M17.5 14.8c2.1.6 3.5 2.3 3.5 4.6"/>',
    'user-check' => '<circle cx="10" cy="8" r="3.2"/><path d="M3.5 20c0-3.3 2.9-5.5 6.5-5.5 1 0 2 .2 2.8.5"/><path d="m15.5 17.5 2 2 4-4"/>',
    'mic'        => '<rect x="9" y="3" width="6" height="11" rx="3"/><path d="M5.5 11.5a6.5 6.5 0 0 0 13 0M12 18v3"/>',
    'tag'        => '<path d="M3.5 11.2V4.5a1 1 0 0 1 1-1h6.7a1 1 0 0 1 .7.3l8.3 8.3a1 1 0 0 1 0 1.4l-6.7 6.7a1 1 0 0 1-1.4 0L3.8 11.9a1 1 0 0 1-.3-.7Z"/><circle cx="7.8" cy="7.8" r="1.3"/>',
    'form'       => '<rect x="4" y="3" width="16" height="18" rx="2"/><path d="M8 8h8M8 12h8M8 16h4"/>',
    'report'     => '<path d="M6 3h8l5 5v13a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Z"/><path d="M14 3v5h5"/><path d="M9 17v-3M12 17v-5M15 17v-2"/>',
    'calendar'   => '<rect x="3.5" y="5" width="17" height="16" rx="2"/><path d="M3.5 10h17M8 3v4M16 3v4"/>',
    'repeat'     => '<path d="M4 9V8a3 3 0 0 1 3-3h10l-3-3M20 15v1a3 3 0 0 1-3 3H7l3 3"/>',
    'layers'     => '<path d="m12 3 9 5-9 5-9-5Z"/><path d="m3.5 12.5 8.5 4.7 8.5-4.7"/><path d="m3.5 16.8 8.5 4.7 8.5-4.7"/>',
    'filter'     => '<path d="M3.5 5h17l-6.6 7.8V20l-3.8-2.2v-5Z"/>',
    'building'   => '<path d="M4 21V5a2 2 0 0 1 2-2h7a2 2 0 0 1 2 2v16"/><path d="M15 10h3a2 2 0 0 1 2 2v9M8 7h3M8 11h3M8 15h3M2.5 21h19"/>',
    'bell'       => '<path d="M6 9a6 6 0 1 1 12 0c0 4 1.5 5.5 2 6H4c.5-.5 2-2 2-6Z"/><path d="M10 19a2 2 0 0 0 4 0"/>',
    'cpu'        => '<rect x="6" y="6" width="12" height="12" rx="2"/><rect x="9.5" y="9.5" width="5" height="5" rx="1"/><path d="M9 3v3M15 3v3M9 18v3M15 18v3M3 9h3M3 15h3M18 9h3M18 15h3"/>',
    'sparkle'    => '<path d="m12 3 1.9 5.1L19 10l-5.1 1.9L12 17l-1.9-5.1L5 10l5.1-1.9Z"/><path d="M18.5 16.5 19 18l1.5.5-1.5.5-.5 1.5-.5-1.5L16.5 18l1.5-.5Z"/>',
    'cloud'      => '<path d="M7 18h10.5a3.5 3.5 0 0 0 .4-7A5.5 5.5 0 0 0 7.3 9.6 4.2 4.2 0 0 0 7 18Z"/>',
    'cloud-check'=> '<path d="M7 17.5h10a3.5 3.5 0 0 0 .4-7A5.5 5.5 0 0 0 7.3 9.1 4.2 4.2 0 0 0 7 17.5Z"/><path d="m9.5 13.5 2 2 3.5-3.5"/>',
    'refresh'    => '<path d="M20 11a8 8 0 0 0-13.8-5.2L3.5 8.5"/><path d="M3.5 4v4.5H8"/><path d="M4 13a8 8 0 0 0 13.8 5.2l2.7-2.7"/><path d="M20.5 20v-4.5H16"/>',
    'checklist'  => '<path d="M9 6h11M9 12h11M9 18h11"/><path d="m3.5 6 1.2 1.2L7 5M3.5 12l1.2 1.2L7 11M3.5 18l1.2 1.2L7 17"/>',
    'geo'        => '<path d="M12 21s7-5.7 7-11a7 7 0 1 0-14 0c0 5.3 7 11 7 11Z"/><circle cx="12" cy="10" r="2.7"/>',
    'target'     => '<circle cx="12" cy="12" r="8.5"/><circle cx="12" cy="12" r="4.5"/><circle cx="12" cy="12" r="1"/>',
    'badge'      => '<rect x="3.5" y="4.5" width="17" height="15" rx="2"/><circle cx="9" cy="10.5" r="2.2"/><path d="M5.5 16.5c.5-1.7 1.9-2.6 3.5-2.6s3 .9 3.5 2.6M15 9.5h3.5M15 13h3.5"/>',
    'camera'     => '<path d="M4 7h3l1.5-2h7L17 7h3a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V8a1 1 0 0 1 1-1Z"/><circle cx="12" cy="13" r="3.6"/>',
    'qr'         => '<rect x="3.5" y="3.5" width="7" height="7" rx="1"/><rect x="13.5" y="3.5" width="7" height="7" rx="1"/><rect x="3.5" y="13.5" width="7" height="7" rx="1"/><path d="M13.5 13.5h3v3h-3zM20.5 13.5v3M17.5 20.5h3M13.5 20.5h1"/>',
    'route'      => '<circle cx="6" cy="18" r="2.5"/><circle cx="18" cy="6" r="2.5"/><path d="M15.5 6H10a4 4 0 0 0 0 8h4a4 4 0 0 1 0 8H8.5"/>',
    'truck'      => '<path d="M3 6h10v10H3zM13 9.5h4l3 3.2V16h-7z"/><circle cx="7" cy="18" r="2"/><circle cx="17" cy="18" r="2"/>',
    'warehouse'  => '<path d="M3 21V8.5L12 4l9 4.5V21"/><path d="M7.5 21v-7h9v7M7.5 17.5h9"/>',
    'factory'    => '<path d="M3 21V10l6 4V10l6 4V6h6v15Z"/><path d="M7 17.5h2M13 17.5h2M18 17.5h1"/>',
    'cart'       => '<path d="M3 4h2.2l2.4 11.2a1.5 1.5 0 0 0 1.5 1.2h8.3a1.5 1.5 0 0 0 1.5-1.2L21 8H6"/><circle cx="9.5" cy="20" r="1.4"/><circle cx="17.5" cy="20" r="1.4"/>',
    'invoice'    => '<path d="M5.5 3h13v18l-2.2-1.5-2.1 1.5-2.2-1.5L9.8 21l-2.1-1.5L5.5 21Z"/><path d="M9 8h6M9 12h6"/>',
    'coins'      => '<ellipse cx="9" cy="7" rx="5.5" ry="2.5"/><path d="M3.5 7v5c0 1.4 2.5 2.5 5.5 2.5s5.5-1.1 5.5-2.5V7"/><path d="M14.5 11.4c3 .2 5.2 1.2 5.2 2.4v4.7c0 1.4-2.5 2.5-5.5 2.5s-5.5-1.1-5.5-2.5v-3.6"/>',
    'server'     => '<rect x="3.5" y="4" width="17" height="6.5" rx="1.5"/><rect x="3.5" y="13.5" width="17" height="6.5" rx="1.5"/><path d="M7 7.2h.01M7 16.8h.01"/>',
    'rack'       => '<rect x="4.5" y="3" width="15" height="18" rx="2"/><path d="M4.5 8.5h15M4.5 14h15M8 5.8h.01M8 11.2h.01M8 17.3h.01"/>',
    'ethernet'   => '<path d="M6 10V6.5a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1V10l2 2v5.5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V12Z"/><path d="M8.5 12.5v3M12 12.5v3M15.5 12.5v3"/>',
    'wifi'       => '<path d="M2.5 8.5a15 15 0 0 1 19 0M5.8 12.2a10 10 0 0 1 12.4 0M9.2 15.8a5 5 0 0 1 5.6 0"/><circle cx="12" cy="19.3" r="1.2"/>',
    'power'      => '<path d="M12 3v9"/><path d="M7.3 6.3a8 8 0 1 0 9.4 0"/>',
    'zap'        => '<path d="M13.5 2 5 13.5h6L10.5 22 19 10.5h-6Z"/>',
    'display'    => '<rect x="2.5" y="4" width="19" height="12.5" rx="2"/><path d="M8.5 20.5h7M12 16.5v4"/>',
    'wrench'     => '<path d="M20 5.5a5 5 0 0 1-6.6 6.6L6 19.5a2.1 2.1 0 0 1-3-3l7.4-7.4A5 5 0 0 1 17 2.5l-3 3 1.5 3 3 1.5Z"/>',
    'box'        => '<path d="m12 3 8.5 4.5v9L12 21l-8.5-4.5v-9Z"/><path d="M3.5 7.5 12 12l8.5-4.5M12 12v9"/>',
    'chart'      => '<path d="M4 20V4M4 20h16"/><path d="M8 16.5v-4M12 16.5V8M16 16.5v-6.5"/>',
    'gear'       => '<circle cx="12" cy="12" r="3.2"/><path d="M12 2.5v2.2M12 19.3v2.2M4.2 12H2M22 12h-2.2M6.3 6.3 4.8 4.8M19.2 19.2l-1.5-1.5M6.3 17.7l-1.5 1.5M19.2 4.8l-1.5 1.5"/>',
    'database'   => '<ellipse cx="12" cy="6" rx="7.5" ry="3"/><path d="M4.5 6v12c0 1.7 3.4 3 7.5 3s7.5-1.3 7.5-3V6M4.5 12c0 1.7 3.4 3 7.5 3s7.5-1.3 7.5-3"/>',
    'code'       => '<path d="m8.5 8-5 4 5 4M15.5 8l5 4-5 4M13.5 4.5l-3 15"/>',
    'book'       => '<path d="M4 4.5A1.5 1.5 0 0 1 5.5 3H19v15.5H5.5A1.5 1.5 0 0 0 4 20Z"/><path d="M4 20a1.5 1.5 0 0 0 1.5 1.5H19"/>',
    'search'     => '<circle cx="11" cy="11" r="6.5"/><path d="m16 16 4.5 4.5"/>',
    'image'      => '<rect x="3.5" y="4.5" width="17" height="15" rx="2"/><circle cx="8.8" cy="9.8" r="1.6"/><path d="m4 17 4.8-4.5 3.4 3.2 3-2.7 4.8 4.5"/>',
    'alert'      => '<path d="M12 3.5 21 19.5H3Z"/><path d="M12 10v4M12 16.8h.01"/>',
    'restart'    => '<path d="M12 3v5"/><path d="M17.6 6.4a8 8 0 1 1-11.2 0"/>',
    'login'      => '<path d="M14 3.5h4.5a1.5 1.5 0 0 1 1.5 1.5v14a1.5 1.5 0 0 1-1.5 1.5H14"/><path d="M4 12h11M11.5 8.5 15 12l-3.5 3.5"/>',
    'paperclip'  => '<path d="M20 11.5 12.2 19.3a5 5 0 0 1-7-7L12.9 4.4a3.3 3.3 0 0 1 4.7 4.7l-7.7 7.8a1.7 1.7 0 0 1-2.4-2.4l7.2-7.2"/>',
    'github'     => '<path d="M9 19c-4.5 1.4-4.5-2.4-6.5-2.9m13 4.9v-3.5a3 3 0 0 0-.85-2.35c2.85-.3 5.85-1.4 5.85-6.3a4.9 4.9 0 0 0-1.3-3.4 4.6 4.6 0 0 0-.1-3.4s-1.05-.3-3.5 1.3a12 12 0 0 0-6.3 0C6.85.65 5.8.95 5.8.95a4.6 4.6 0 0 0-.1 3.4A4.9 4.9 0 0 0 4.4 7.75c0 4.9 3 6 5.85 6.3a3 3 0 0 0-.85 2.3V20"/>',
    'linkedin'   => '<path d="M15 8.5a5.5 5.5 0 0 1 5.5 5.5v6h-3.5v-6a2 2 0 0 0-4 0v6H9.5V8.8H13v1.9A4.4 4.4 0 0 1 15 8.5Z"/><rect x="2.5" y="8.8" width="3.5" height="11.2"/><circle cx="4.25" cy="4.5" r="1.9"/>',
    ); }
    $p = isset($d[$nombre]) ? $d[$nombre] : $d['check'];
    $c = $clase !== '' ? ' class="' . a_e($clase) . '"' : '';
    return '<svg' . $c . ' viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"'
         . ' stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">' . $p . '</svg>';
}

// ---------------------------------------------------------------------------
// Piezas compartidas
// ---------------------------------------------------------------------------

/** Rejilla del ecosistema para el pie. */
function a_ecosistema_grid($actual)
{
    $h = '<div class="eco-grid" data-reveal>';
    foreach (a_familia() as $k => $p) {
        if ($k === $actual) {
            $h .= '<div class="eco-card" aria-current="page">';
            $h .= '<div><b>' . a_e($p['nombre']) . '</b><span>Estás aquí</span></div></div>';
        } else {
            $h .= '<a class="eco-card" href="' . a_e($p['url']) . '">';
            $h .= '<div><b>' . a_e($p['nombre']) . '</b><span>' . a_e($p['que']) . '</span></div></a>';
        }
    }
    return $h . '</div>';
}

/** Encabezado de sección: índice en el riel + eyebrow + título + entradilla. */
function a_head($idx, $eyebrow, $titulo, $lede = '', $extra = '')
{
    $h  = '<header class="head' . ($extra ? ' ' . a_e($extra) : '') . '" data-reveal>';
    $h .= '<p class="idx head__idx">' . a_e($idx) . '</p>';
    $h .= '<div class="head__main">';
    if ($eyebrow !== '') { $h .= '<p class="eyebrow">' . a_e($eyebrow) . '</p>'; }
    $h .= '<h2>' . $titulo . '</h2>';
    if ($lede !== '')    { $h .= '<p class="lede">' . a_e($lede) . '</p>'; }
    return $h . '</div></header>';
}

/**
 * Hueco de captura.
 * Si el archivo existe se pinta la imagen; si no, un marco con la ruta y las
 * dimensiones que debe tener, para sustituirlo sin adivinar nada.
 */
function a_shot($archivo, $alt, $w, $h, $pie = '', $fig = '', $clase = '')
{
    $ruta   = __DIR__ . '/' . $archivo;
    $existe = is_file($ruta);
    $osc    = preg_replace('/\.(png|jpe?g|webp)$/i', '-oscuro.$1', $archivo);
    $existeOsc = $osc !== $archivo && is_file(__DIR__ . '/' . $osc);
    $o  = '<figure class="shot' . ($existe ? '' : ' shot--pendiente')
        . ($clase ? ' ' . a_e($clase) : '') . '" data-reveal>';
    $o .= '<div class="shot__box ticks">';
    $o .= '<div class="shot__frame" style="--ar: ' . (int) $w . ' / ' . (int) $h . '">';
    if ($existe) {
        $o .= '<img src="' . a_e($archivo) . '" alt="' . a_e($alt) . '"'
            . ($existeOsc ? ' data-theme-img="light"' : '')
            . ' width="' . (int) $w . '" height="' . (int) $h . '" loading="lazy" decoding="async">';
        if ($existeOsc) {
            $o .= '<img src="' . a_e($osc) . '" alt="' . a_e($alt) . '" data-theme-img="dark"'
                . ' width="' . (int) $w . '" height="' . (int) $h . '" loading="lazy" decoding="async">';
        }
    } else {
        $o .= '<div class="shot__pending">' . a_icon('image')
            . '<b>Captura pendiente</b>'
            . '<code>' . a_e($archivo) . '</code>'
            . '<small>' . (int) $w . ' × ' . (int) $h . ' px</small></div>';
    }
    $o .= '</div></div>';
    if ($pie !== '') {
        $o .= '<figcaption class="shot__cap">';
        if ($fig !== '') { $o .= '<span class="mono">' . a_e($fig) . '</span>'; }
        $o .= '<span>' . a_e($pie) . '</span></figcaption>';
    }
    return $o . '</figure>';
}

/** Conmutador de tema. Muestra el icono de lo que va a activar. */
function a_tema($clase = 'theme-toggle')
{
    return '<button class="' . a_e($clase) . '" type="button" data-theme-toggle aria-label="Cambiar tema">'
         . a_icon('moon', 'i-moon') . a_icon('sun', 'i-sun')
         . '<span class="theme-toggle__label"></span></button>';
}

/** Bloque del autor: la persona real que desarrolla y da soporte. */
function a_autor($cita)
{
    $h  = '<div class="author" data-reveal>';
    $h .= '<img class="author__photo" src="https://gustavoquintero.dev/assets/img/my-profile-image.jpg"'
        . ' alt="Retrato de Gustavo Quintero" width="84" height="84" loading="lazy" decoding="async">';
    $h .= '<div><h3>Gustavo Quintero</h3>';
    $h .= '<p class="author__role">Desarrollo y operación</p>';
    $h .= '<blockquote><p>«' . a_e($cita) . '»</p></blockquote>';
    $h .= '<div class="author__links">';
    $h .= '<a href="mailto:atencion@gustavoquintero.dev">' . a_icon('mail') . 'atencion@gustavoquintero.dev</a>';
    $h .= '<a href="https://gustavoquintero.dev" target="_blank" rel="noopener">' . a_icon('globe')
        . 'gustavoquintero.dev' . a_icon('external') . '</a>';
    $h .= '<a href="https://github.com/GustavoQuinteroC" target="_blank" rel="noopener">' . a_icon('github')
        . 'GitHub' . a_icon('external') . '</a>';
    $h .= '<a href="https://www.linkedin.com/in/gustavo-quintero-81aa18169/" target="_blank" rel="noopener">' . a_icon('linkedin')
        . 'LinkedIn' . a_icon('external') . '</a>';
    $h .= '</div></div></div>';
    return $h;
}

/** Diálogo con las credenciales del demo. */
function a_dialogo_demo($url_app)
{
    $h  = '<dialog id="demoDialog" aria-labelledby="demoTitulo">';
    $h .= '<div class="dlg"><h2 id="demoTitulo">Acceso al demo</h2>';
    $h .= '<p>Entra a la empresa de demostración con estas credenciales.</p>';
    $h .= '<dl class="dlg__creds">';
    $h .= '<div><dt>Usuario</dt><dd>demo@alkes.mx</dd></div>';
    $h .= '<div><dt>Contraseña</dt><dd>Demo@Alkes2026</dd></div>';
    $h .= '</dl>';
    $h .= '<p>Para una demostración guiada, contacta a <strong>Gustavo Quintero</strong> al correo '
        . '<a href="mailto:' . ALKES_MAIL . '">' . ALKES_MAIL . '</a> o al teléfono '
        . '<a href="tel:' . ALKES_TEL . '">' . ALKES_TEL_TXT . '</a>.</p>';
    $h .= '<div class="dlg__foot">';
    $h .= '<a class="btn btn--primary" href="' . a_e($url_app) . '" target="_blank" rel="noopener">Ir a la app' . a_icon('external') . '</a>';
    $h .= '<button class="btn btn--outline" type="button" data-close-demo>Cerrar</button>';
    $h .= '</div></div></dialog>';
    return $h;
}


function a_cache()
{
    static $d = null;
    if ($d !== null) { return $d; }
    $f = __DIR__ . '/planes.cache.json';
    $d = array('producto' => array(), 'planes' => array());
    if (is_file($f)) {
        $j = json_decode((string) @file_get_contents($f), true);
        if (is_array($j)) { $d = $j + $d; }
    }
    return $d;
}

function a_planes()         { $d = a_cache(); return isset($d['planes']) ? $d['planes'] : array(); }
function a_producto_clave() { $d = a_cache(); return isset($d['producto']['clave']) ? $d['producto']['clave'] : ''; }
function a_url_panel()      { $d = a_cache(); return isset($d['producto']['url_panel']) ? $d['producto']['url_panel'] : ALKES_SITIO; }

function a_num($n) { return number_format((float) $n, (floor($n) == $n ? 0 : 2), '.', ','); }

/** Traduce los iconos del catálogo (Bootstrap Icons) al set propio. */
function a_map_icon($bi)
{
    $m = array(
        'bi-people-fill' => 'users',            'bi-cpu-fill' => 'cpu',
        'bi-paperclip' => 'paperclip',          'bi-tools' => 'wrench',
        'bi-arrow-up-circle-fill' => 'refresh', 'bi-clock-history' => 'history',
        'bi-shield-lock' => 'lock',             'bi-box-seam' => 'box',
        'bi-box-seam-fill' => 'box',            'bi-card-checklist' => 'checklist',
        'bi-geo-alt-fill' => 'geo',             'bi-person-badge-fill' => 'badge',
        'bi-file-earmark-bar-graph' => 'report','bi-display-fill' => 'display',
        'bi-ethernet' => 'ethernet',            'bi-hdd-rack-fill' => 'rack',
        'bi-cloud-check-fill' => 'cloud-check',
    );
    return isset($m[$bi]) ? $m[$bi] : 'check';
}

/** Ahorro del plan anual frente a doce mensualidades. Calculado, nunca escrito. */
function a_ahorro_anual()
{
    $m = array(); $a = array();
    foreach (a_planes() as $p) {
        if ($p['periodo'] === 'mensual') { $m[$p['clave']] = (float) $p['precio']; }
        if ($p['periodo'] === 'anual')   { $a[$p['clave']] = (float) $p['precio']; }
    }
    $pcts = array();
    foreach ($a as $k => $precio) {
        if (!empty($m[$k]) && $m[$k] > 0) {
            $full = $m[$k] * 12;
            if ($full > $precio) { $pcts[$k] = (int) round((1 - $precio / $full) * 100); }
        }
    }
    return $pcts ? max($pcts) : 0;
}

/** Rejilla de planes de un periodo. Los de pago único aparecen en ambos. */
function a_grid_planes($periodo)
{
    $items = array();
    foreach (a_planes() as $p) {
        if ($p['periodo'] === $periodo || $p['periodo'] === 'unico') { $items[] = $p; }
    }
    if (!$items) {
        return '<p class="center muted">Por el momento no hay planes publicados. '
             . '<a class="link-arrow" href="mailto:' . ALKES_MAIL . '">Escríbenos' . a_icon('arrow') . '</a></p>';
    }

    $clave  = a_producto_clave();
    $ahorro = a_ahorro_anual();
    $h = '<div class="plans">';

    foreach ($items as $p) {
        $rec = !empty($p['recomendado']);
        $per = $p['periodo'] === 'anual' ? 'MXN / año'
             : ($p['periodo'] === 'unico' ? 'MXN / pago único' : 'MXN / mes');

        $h .= '<div class="plan' . ($rec ? ' plan--rec' : '') . '">';
        $h .= '<div class="plan__head"><h3 class="plan__name">' . a_e($p['nombre']) . '</h3>';
        if ($rec) { $h .= '<span class="plan__tag">Recomendado</span>'; }
        $h .= '</div>';

        $h .= '<p class="plan__price"><span class="plan__cur">$</span>'
            . '<span class="plan__amt">' . a_num($p['precio']) . '</span>'
            . '<span class="plan__per">' . $per . '</span></p>';

        $nota = '';
        if (!empty($p['precio_anterior'])) {
            $nota = 'Antes <s>$' . a_num($p['precio_anterior']) . '</s>';
        } elseif ($p['periodo'] === 'anual') {
            $nota = 'Equivale a $' . a_num(round($p['precio'] / 12)) . ' al mes'
                  . ($ahorro ? ' · ahorras ' . $ahorro . ' %' : '');
        } elseif ($p['periodo'] === 'mensual') {
            $nota = 'Sin permanencia. Cancela cuando quieras.';
        }
        $h .= '<p class="plan__note">' . $nota . '</p>';

        $h .= '<ul class="plan__features">';
        foreach ($p['caracteristicas'] as $c) {
            $h .= '<li>' . a_icon(a_map_icon(isset($c['icono']) ? $c['icono'] : ''))
                . '<div><strong>' . a_e($c['titulo']) . '</strong>';
            if (!empty($c['descripcion'])) { $h .= '<p>' . a_e($c['descripcion']) . '</p>'; }
            $h .= '</div></li>';
        }
        $h .= '</ul>';

        $url = ALKES_CENTRAL . '/?producto=' . urlencode($clave)
             . '&plan=' . urlencode($p['clave'])
             . '&periodo=' . urlencode($p['periodo']);

        $h .= '<a class="btn ' . ($rec ? 'btn--primary' : 'btn--outline') . ' btn--block" href="' . a_e($url) . '">'
            . 'Contratar ' . a_e($p['nombre']) . a_icon('arrow') . '</a>';
        $h .= '</div>';
    }
    return $h . '</div>';
}

if (!defined('SEO_FUNDADOR_ID')) { define('SEO_FUNDADOR_ID', 'https://gustavoquintero.dev/#persona'); }

/** Persona fundadora: la misma entidad que describe gustavoquintero.dev. */
function seo_fundador()
{
    return array(
        '@type' => 'Person', '@id' => SEO_FUNDADOR_ID,
        'name' => 'Gustavo de Jesús Quintero Cerpa', 'alternateName' => 'Gustavo Quintero',
        'jobTitle' => 'Fundador y desarrollador de Alkes',
        'url' => 'https://gustavoquintero.dev/',
        'sameAs' => array('https://www.linkedin.com/in/gustavo-quintero-81aa18169/', 'https://github.com/GustavoQuinteroC'),
        'address' => array('@type' => 'PostalAddress', 'addressLocality' => 'Guadalajara', 'addressRegion' => 'Jalisco', 'addressCountry' => 'MX'),
    );
}

/** Versión publicada más reciente, leída del historial de novedades. */
function seo_version($dir)
{
    $t = (string) file_get_contents($dir . '/index.php');
    return preg_match('/disc__v">v(\d+\.\d+\.\d+)</', $t, $m) ? $m[1] : '';
}

/**
 * Lista de funciones y capturas a partir de los arreglos de la página.
 * Acepta $CAPACIDADES (con 'items' e 'img'), $SOSTIENE y $AVANZADAS.
 */
function seo_de_pagina($sitio, $capacidades, $extras = array())
{
    $funciones = array();
    $capturas = array();
    foreach ((array) $capacidades as $c) {
        if (!empty($c['h3'])) { $funciones[] = $c['h3']; }
        foreach ((array) (isset($c['items']) ? $c['items'] : array()) as $it) {
            if (is_array($it) && isset($it[1])) { $funciones[] = $it[1]; }
        }
        if (!empty($c['img'])) {
            $capturas[] = array_filter(array('@type' => 'ImageObject', 'url' => $sitio . '/' . ltrim($c['img'], '/'),
                                'caption' => isset($c['alt']) ? $c['alt'] : '',
                                'width' => isset($c['w']) ? (int) $c['w'] : null, 'height' => isset($c['h']) ? (int) $c['h'] : null),
                                function ($v) { return $v !== null && $v !== ''; });
        }
    }
    foreach ((array) $extras as $lista) {
        foreach ((array) $lista as $it) {
            if (is_array($it) && isset($it[1])) { $funciones[] = $it[1]; }
        }
    }
    $funciones = array_values(array_unique(array_filter($funciones)));
    return array('funciones' => $funciones, 'capturas' => $capturas);
}

/** Etiquetas extra del <head>. $s: sitio, nombre, titulo, alt, palabras, noindex. */
function seo_head($s)
{
    $e = function ($v) { return htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8'); };
    $sitio = $s['sitio'];
    $og = $sitio . '/assets/img/og-image.png';
    $out = array();
    if (empty($s['noindex'])) {
        $out[] = '<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">';
        $out[] = '<meta name="googlebot" content="index, follow, max-image-preview:large, max-snippet:-1">';
        $out[] = '<meta name="bingbot" content="index, follow, max-image-preview:large, max-snippet:-1">';
    }
    $out[] = '<meta name="keywords" content="' . $e(implode(', ', $s['palabras'])) . '">';
    $out[] = '<meta name="application-name" content="' . $e($s['nombre']) . '">';
    $out[] = '<meta name="apple-mobile-web-app-title" content="' . $e($s['nombre']) . '">';
    $out[] = '<meta name="creator" content="Gustavo Quintero">';
    $out[] = '<meta name="publisher" content="Alkes">';
    $out[] = '<meta name="classification" content="Software empresarial en la nube">';
    $out[] = '<meta name="language" content="es-MX">';
    $out[] = '<meta name="geo.region" content="MX-JAL">';
    $out[] = '<meta name="geo.placename" content="Guadalajara, Jalisco, México">';
    $out[] = '<meta name="geo.position" content="20.6597;-103.3496">';
    $out[] = '<meta name="ICBM" content="20.6597, -103.3496">';
    $out[] = '<link rel="alternate" hreflang="es-MX" href="' . $sitio . '/">';
    $out[] = '<link rel="alternate" hreflang="es" href="' . $sitio . '/">';
    $out[] = '<link rel="alternate" hreflang="x-default" href="' . $sitio . '/">';
    $out[] = '<link rel="alternate" type="text/markdown" title="Resumen para modelos de lenguaje" href="' . $sitio . '/llms.txt">';
    $out[] = '<link rel="sitemap" type="application/xml" href="' . $sitio . '/sitemap.xml">';
    $out[] = '<link rel="author" href="https://gustavoquintero.dev/">';
    $out[] = '<meta property="og:image:secure_url" content="' . $og . '">';
    $out[] = '<meta property="og:image:type" content="image/png">';
    $out[] = '<meta name="twitter:image:alt" content="' . $e($s['alt']) . '">';
    return implode("\n", $out) . "\n";
}

/**
 * Enriquece el grafo JSON-LD que arma cada landing.
 * $s: sitio, nombre, subcategoria, palabras, version, funciones, capturas,
 *     dispositivos, requisitos, titulo.
 */
function seo_enriquecer($g, $s)
{
    if (empty($s) || empty($g['@graph'])) { return $g; }
    $sitio = $s['sitio'];
    $org = ALKES_SITIO . '/#org';
    foreach ($g['@graph'] as $i => $n) {
        $tipo = isset($n['@type']) ? $n['@type'] : '';
        if ($tipo === 'Organization') {
            $g['@graph'][$i] = array_merge($n, array(
                'alternateName' => array('Alkes Software y Soluciones TI', 'Alkes TI'),
                'description' => 'Empresa de software y soluciones TI en Guadalajara, Jalisco. Desarrolla y opera sistemas en la nube para empresas mexicanas: ERP con CFDI 4.0, pendientes con IA, control de asistencia, mantenimiento y reinicio remoto de equipos.',
                'logo' => array('@type' => 'ImageObject', 'url' => ALKES_SITIO . '/assets/img/logo_alkes.png'),
                'address' => array('@type' => 'PostalAddress', 'addressLocality' => 'Guadalajara', 'addressRegion' => 'Jalisco', 'addressCountry' => 'MX'),
                'areaServed' => array('@type' => 'Country', 'name' => 'México'),
                'founder' => array('@id' => SEO_FUNDADOR_ID),
                'foundingLocation' => array('@type' => 'Place', 'name' => 'Guadalajara, Jalisco, México'),
                'contactPoint' => array('@type' => 'ContactPoint', 'contactType' => 'Ventas y soporte', 'telephone' => ALKES_TEL,
                                        'email' => ALKES_MAIL, 'areaServed' => 'MX', 'availableLanguage' => array('es')),
                'knowsAbout' => array('Software empresarial', 'ERP', 'Facturación electrónica CFDI 4.0', 'Gestión de pendientes',
                                      'Control de asistencia', 'Mantenimiento preventivo', 'Internet de las cosas', 'Inteligencia artificial'),
            ));
        } elseif ($tipo === 'SoftwareApplication') {
            $extra = array(
                'applicationSubCategory' => $s['subcategoria'],
                'keywords' => implode(', ', $s['palabras']),
                'countriesSupported' => 'MX',
                'availableOnDevice' => $s['dispositivos'],
                'browserRequirements' => $s['requisitos'],
                'provider' => array('@id' => $org),
                'creator' => array('@id' => SEO_FUNDADOR_ID),
                'author' => array('@id' => SEO_FUNDADOR_ID),
                'isAccessibleForFree' => false,
                'mainEntityOfPage' => array('@id' => $sitio . '/#pagina'),
            );
            if (!empty($s['version'])) {
                $extra['softwareVersion'] = $s['version'];
                $extra['releaseNotes'] = $sitio . '/#novedades';
            }
            if (!empty($s['funciones'])) { $extra['featureList'] = $s['funciones']; }
            if (!empty($s['capturas'])) { $extra['screenshot'] = $s['capturas']; }
            $g['@graph'][$i] = array_merge($n, $extra);
        } elseif ($tipo === 'WebSite') {
            $g['@graph'][$i] = array_merge($n, array(
                'description' => $s['titulo'],
                'creator' => array('@id' => SEO_FUNDADOR_ID),
                'copyrightHolder' => array('@id' => $org),
            ));
        }
    }
    $g['@graph'][] = array(
        '@type' => 'WebPage', '@id' => $sitio . '/#pagina', 'url' => $sitio . '/', 'name' => $s['titulo'],
        'isPartOf' => array('@id' => $sitio . '/#web'), 'about' => array('@id' => $sitio . '/#app'),
        'mainEntity' => array('@id' => $sitio . '/#app'), 'inLanguage' => 'es-MX',
        'primaryImageOfPage' => array('@type' => 'ImageObject', 'url' => $sitio . '/assets/img/og-image.png', 'width' => 1200, 'height' => 630),
        'breadcrumb' => array('@id' => $sitio . '/#migas'),
        'dateModified' => date('Y-m-d', (int) @filemtime(__DIR__ . '/index.php')),
        'publisher' => array('@id' => $org),
    );
    $g['@graph'][] = array(
        '@type' => 'BreadcrumbList', '@id' => $sitio . '/#migas',
        'itemListElement' => array(
            array('@type' => 'ListItem', 'position' => 1, 'name' => 'Alkes', 'item' => ALKES_SITIO . '/'),
            array('@type' => 'ListItem', 'position' => 2, 'name' => $s['nombre'], 'item' => $sitio . '/'),
        ),
    );
    $g['@graph'][] = seo_fundador();
    return $g;
}


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
// SEO y GEO: datos para seo_head() y seo_enriquecer() (ver seo_head).
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
                    <li><a href="/terminos.html">Términos y condiciones</a></li>
                    <li><a href="/privacidad.html">Aviso de privacidad</a></li>
                    <li><a href="/cookies.html">Cookies</a></li>
                    <li><a href="/encargo-de-datos.html">Tratamiento de datos</a></li>
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
