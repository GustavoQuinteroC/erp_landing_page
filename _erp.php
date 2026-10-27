<?php

// Contacto institucional. Se define antes de cargar el kit: el kit solo
// define estas constantes si no existen.
define('ALKES_MAIL',    'soporte@alkes.mx');
define('ALKES_TEL',     '+523339460097');
define('ALKES_TEL_TXT', '333 946 0097');

require_once __DIR__ . '/_planes.php';

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
