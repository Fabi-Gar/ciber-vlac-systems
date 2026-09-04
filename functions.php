<?php
/**
 * Vlac Systems — funciones del tema
 *
 * @package Vlac_Systems
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // No acceso directo.
}

if ( ! defined( 'VLAC_VERSION' ) ) {
	define( 'VLAC_VERSION', '1.4.2' );
}

// Instalador del Agente de impresión (etiquetadoras e impresoras térmicas).
// El JSON publica la última versión: {"version":"1.0.5","url":"…/sc-app-1.0.5.exe"}
if ( ! defined( 'VLAC_AGENT_JSON' ) ) {
	define( 'VLAC_AGENT_JSON', 'https://images.softcontext.app/softcontext_app/public/agent-version.json' );
}

// Instalador que viaja dentro del tema (ruta relativa a la carpeta del tema).
// Es lo que se sirve mientras el bucket no publique el setup.
if ( ! defined( 'VLAC_AGENT_FILE' ) ) {
	define( 'VLAC_AGENT_FILE', 'assets/downloads/sc-agent-setup-1.0.5.exe' );
}

// Misma versión, ya subida al bucket. Se usa si el archivo local no está.
if ( ! defined( 'VLAC_AGENT_URL' ) ) {
	define( 'VLAC_AGENT_URL', 'https://images.softcontext.app/softcontext_app/public/sc-agent-setup-1.0.5.exe' );
}

// El JSON solo manda si anuncia una versión más nueva que esta, así no
// retrocedemos mientras el JSON se actualiza (hoy todavía dice 1.0.4).
if ( ! defined( 'VLAC_AGENT_VERSION' ) ) {
	define( 'VLAC_AGENT_VERSION', '1.0.5' );
}

if ( ! defined( 'VLAC_AGENT_DESC' ) ) {
	define(
		'VLAC_AGENT_DESC',
		'Descarga nuestro agente para conectar tu etiquetadora o impresora térmica con el sistema. Así puedes imprimir desde el teléfono y crear las etiquetas de tu negocio.'
	);
}

/**
 * Configuración base del tema.
 */
function vlac_setup() {
	load_theme_textdomain( 'vlac-systems', get_template_directory() . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support(
		'html5',
		array( 'search-form', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' )
	);
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 46,
			'width'       => 46,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	register_nav_menus(
		array(
			'primary'      => __( 'Menú principal', 'vlac-systems' ),
			'footer_prod'  => __( 'Footer — Producto', 'vlac-systems' ),
			'footer_ind'   => __( 'Footer — Industrias', 'vlac-systems' ),
			'footer_emp'   => __( 'Footer — Empresa', 'vlac-systems' ),
		)
	);
}
add_action( 'after_setup_theme', 'vlac_setup' );

/**
 * Carga de fuentes, estilos y scripts.
 */
function vlac_assets() {
	// Google Fonts (Inter + Manrope), igual que el diseño original.
	wp_enqueue_style(
		'vlac-fonts',
		'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Manrope:wght@500;600;700;800&display=swap',
		array(),
		null
	);

	// Hoja de estilos principal (contiene todo el CSS del diseño).
	wp_enqueue_style(
		'vlac-style',
		get_stylesheet_uri(),
		array( 'vlac-fonts' ),
		VLAC_VERSION
	);

	// Script del menú móvil.
	wp_enqueue_script(
		'vlac-nav',
		get_template_directory_uri() . '/assets/js/navigation.js',
		array(),
		VLAC_VERSION,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'vlac_assets' );

/**
 * Preconnect a Google Fonts para mejorar el rendimiento.
 */
function vlac_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = 'https://fonts.googleapis.com';
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'vlac_resource_hints', 10, 2 );

/**
 * Helper: devuelve un valor del Personalizador con respaldo por defecto.
 */
function vlac_opt( $key, $default = '' ) {
	return get_theme_mod( $key, $default );
}

/**
 * Devuelve la URL de la página de Contacto.
 *
 * Se usa como destino por defecto de los botones «Prueba gratis»
 * y «Hablar con un asesor». Prioridad:
 *   1) La página que use la plantilla «Contacto» (page-contacto.php).
 *   2) Una página con slug «contacto».
 *   3) La portada, como último recurso.
 *
 * Cualquier botón puede sobrescribir este destino desde el Personalizador.
 */
function vlac_contact_url() {
	static $url = null;
	if ( null !== $url ) {
		return $url;
	}

	$pages = get_pages(
		array(
			'meta_key'   => '_wp_page_template',
			'meta_value' => 'page-contacto.php',
			'number'     => 1,
		)
	);

	if ( ! empty( $pages ) ) {
		$url = get_permalink( $pages[0]->ID );
	} else {
		$page = get_page_by_path( 'contacto' );
		$url  = $page ? get_permalink( $page->ID ) : home_url( '/' );
	}

	return $url;
}

/**
 * Devuelve la URL de la página «Nuestros clientes».
 *
 * Prioridad:
 *   1) La página que use la plantilla «Nuestros clientes» (page-clientes.php).
 *   2) Una página con slug «clientes».
 *   3) home_url('/clientes/') como último recurso.
 */
function vlac_clients_url() {
	static $url = null;
	if ( null !== $url ) {
		return $url;
	}

	$pages = get_pages(
		array(
			'meta_key'   => '_wp_page_template',
			'meta_value' => 'page-clientes.php',
			'number'     => 1,
		)
	);

	if ( ! empty( $pages ) ) {
		$url = get_permalink( $pages[0]->ID );
	} else {
		$page = get_page_by_path( 'clientes' );
		$url  = $page ? get_permalink( $page->ID ) : home_url( '/clientes/' );
	}

	return $url;
}

/**
 * Lee el JSON de versión del Agente y devuelve array( 'version', 'url' ).
 *
 * El JSON lo publica la API en cada release:
 *   {"version":"1.0.5","url":"https://…/sc-app-1.0.5.exe"}
 *
 * La respuesta se guarda en un transient (1 hora) para no consultar el
 * servidor en cada visita. Si el JSON falla, se usa el último valor
 * conocido y, en su defecto, la constante VLAC_AGENT_URL.
 */
function vlac_agent_info() {
	static $info = null;
	if ( null !== $info ) {
		return $info;
	}

	$cached = get_transient( 'vlac_agent_info' );
	if ( is_array( $cached ) ) {
		$info = $cached;
		return $info;
	}

	$info     = array(
		'version' => '',
		'url'     => VLAC_AGENT_URL,
	);
	$json_url = vlac_opt( 'agent_json', VLAC_AGENT_JSON );

	if ( $json_url ) {
		$response = wp_remote_get(
			$json_url,
			array(
				'timeout' => 5,
				'headers' => array( 'Accept' => 'application/json' ),
			)
		);

		if ( ! is_wp_error( $response ) && 200 === wp_remote_retrieve_response_code( $response ) ) {
			$data = json_decode( wp_remote_retrieve_body( $response ), true );

			if ( is_array( $data ) && ! empty( $data['url'] ) ) {
				$info['url']     = esc_url_raw( $data['url'] );
				$info['version'] = isset( $data['version'] ) ? sanitize_text_field( $data['version'] ) : '';
				// Solo cacheamos una lectura correcta.
				set_transient( 'vlac_agent_info', $info, HOUR_IN_SECONDS );
				return $info;
			}
		}

		// Si falló, reintentamos en 5 minutos en vez de en una hora.
		set_transient( 'vlac_agent_info', $info, 5 * MINUTE_IN_SECONDS );
	}

	return $info;
}

/**
 * Instalador a servir: el que viaja en el tema, o el del bucket si no está.
 * El JSON solo lo reemplaza si su versión supera a VLAC_AGENT_VERSION.
 * Devuelve array( 'version', 'url' ).
 */
function vlac_agent_release() {
	$local = ( VLAC_AGENT_FILE && file_exists( get_template_directory() . '/' . VLAC_AGENT_FILE ) )
		? get_template_directory_uri() . '/' . VLAC_AGENT_FILE
		: '';

	$release = array(
		'version' => VLAC_AGENT_VERSION,
		'url'     => $local ? $local : VLAC_AGENT_URL,
	);

	$info = vlac_agent_info();

	if ( ! empty( $info['url'] ) && ! empty( $info['version'] )
		&& version_compare( $info['version'], VLAC_AGENT_VERSION, '>' ) ) {
		$release = $info;
	}

	return $release;
}

/**
 * Enlace de descarga del Agente de impresión (menú «Agente»).
 * Si el Personalizador tiene un enlace fijo, ese manda; si está vacío,
 * se sirve el instalador de vlac_agent_release().
 */
function vlac_agent_url() {
	$manual = vlac_opt( 'agent_url' );
	if ( $manual ) {
		return $manual;
	}

	$release = vlac_agent_release();
	return $release['url'];
}

/**
 * Nota bajo el botón de descarga; añade la versión del instalador servido.
 */
function vlac_agent_note() {
	$note = vlac_opt( 'agent_note', 'Windows · Instalador .exe' );

	if ( vlac_opt( 'agent_url' ) ) {
		return $note;
	}

	$release = vlac_agent_release();

	if ( ! empty( $release['version'] ) ) {
		$note = $note ? $note . ' · v' . $release['version'] : 'v' . $release['version'];
	}

	return $note;
}

/**
 * Al guardar el Personalizador, olvida la versión cacheada del Agente.
 */
function vlac_flush_agent_cache() {
	delete_transient( 'vlac_agent_info' );
}
add_action( 'customize_save_after', 'vlac_flush_agent_cache' );

/**
 * Enlace de un botón CTA: usa el valor del Personalizador si tiene algo,
 * y si está vacío recurre a la página de Contacto.
 */
function vlac_cta_url( $key ) {
	$url = vlac_opt( $key );
	return $url ? $url : vlac_contact_url();
}

/**
 * Opciones del Personalizador (Apariencia → Personalizar → Contenido de la portada).
 */
function vlac_customize_register( $wp_customize ) {

	$wp_customize->add_panel(
		'vlac_home',
		array(
			'title'    => __( 'Contenido del sitio', 'vlac-systems' ),
			'priority' => 20,
		)
	);

	/* ---------- HERO ---------- */
	$wp_customize->add_section(
		'vlac_hero',
		array(
			'title' => __( 'Hero (encabezado)', 'vlac-systems' ),
			'panel' => 'vlac_home',
		)
	);

	$hero_fields = array(
		'hero_eyebrow'  => array( __( 'Etiqueta superior', 'vlac-systems' ), 'ERP + Facturación Electrónica para Guatemala', 'text' ),
		'hero_title'    => array( __( 'Título (permite HTML con <span class="accent">)', 'vlac-systems' ), 'Tu <span class="accent">ERP</span> con tu <span class="accent">Identidad</span>, y el Facturador <span class="accent">FEL</span> que necesitas.', 'html' ),
		'hero_sub'      => array( __( 'Subtítulo', 'vlac-systems' ), 'Potencia tu negocio con una solución integral personalizada. Incluye Facturador FEL (Guatemala), dominio personalizado y almacenamiento en la nube.', 'textarea' ),
		'hero_cta1_txt' => array( __( 'Botón principal — texto', 'vlac-systems' ), 'Prueba gratis', 'text' ),
		'hero_cta1_url' => array( __( 'Botón principal — enlace (vacío = página de Contacto)', 'vlac-systems' ), '', 'url' ),
		'hero_cta2_txt' => array( __( 'Botón secundario — texto', 'vlac-systems' ), 'Ver una demo', 'text' ),
		'hero_cta2_url' => array( __( 'Botón secundario — enlace', 'vlac-systems' ), '#', 'url' ),
		'hero_note'     => array( __( 'Nota de confianza', 'vlac-systems' ), 'Sin tarjeta de crédito · Certificado ante la SAT · Soporte local', 'text' ),
	);
	vlac_add_fields( $wp_customize, $hero_fields, 'vlac_hero' );

	/* ---------- CTA final ---------- */
	$wp_customize->add_section(
		'vlac_cta',
		array(
			'title' => __( 'Llamado a la acción (CTA)', 'vlac-systems' ),
			'panel' => 'vlac_home',
		)
	);
	$cta_fields = array(
		'cta_title'   => array( __( 'Título', 'vlac-systems' ), 'Empieza con tu ERP personalizado hoy', 'text' ),
		'cta_sub'     => array( __( 'Subtítulo', 'vlac-systems' ), 'Configura tu marca, activa tu Facturador FEL y comienza a facturar en minutos.', 'textarea' ),
		'cta_btn_txt' => array( __( 'Botón — texto', 'vlac-systems' ), 'Prueba gratis', 'text' ),
		'cta_btn_url' => array( __( 'Botón — enlace (vacío = página de Contacto)', 'vlac-systems' ), '', 'url' ),
	);
	vlac_add_fields( $wp_customize, $cta_fields, 'vlac_cta' );

	/* ---------- Negocios (carrusel) ---------- */
	$wp_customize->add_section(
		'vlac_marquee',
		array(
			'title' => __( 'Negocios (carrusel)', 'vlac-systems' ),
			'panel' => 'vlac_home',
		)
	);
	$marquee_fields = array(
		'marquee_title' => array( __( 'Título', 'vlac-systems' ), 'Negocios de todo el país confían en Vlac Systems', 'text' ),
		'marquee_sub'   => array( __( 'Subtítulo', 'vlac-systems' ), 'Desde restaurantes y clínicas hasta talleres y comercios: cientos de negocios ya facturan con nosotros.', 'textarea' ),
	);
	vlac_add_fields( $wp_customize, $marquee_fields, 'vlac_marquee' );

	/* ---------- Página Nuestros clientes ---------- */
	$wp_customize->add_section(
		'vlac_clients',
		array(
			'title' => __( 'Página Nuestros clientes', 'vlac-systems' ),
			'panel' => 'vlac_home',
		)
	);
	$clients_fields = array(
		'clients_title'     => array( __( 'Título', 'vlac-systems' ), 'Negocios reales que crecen con Vlac Systems', 'text' ),
		'clients_sub'       => array( __( 'Subtítulo', 'vlac-systems' ), 'De norte a sur del país, cientos de comercios, restaurantes, clínicas y talleres ya facturan y gestionan su operación con nosotros.', 'textarea' ),
		'clients_cta_title' => array( __( 'CTA final · Título', 'vlac-systems' ), '¿Listo para sumar tu negocio a la lista?', 'text' ),
		'clients_cta_sub'   => array( __( 'CTA final · Subtítulo', 'vlac-systems' ), 'Configura tu marca, activa tu Facturador FEL y empieza a facturar en minutos.', 'textarea' ),
	);
	vlac_add_fields( $wp_customize, $clients_fields, 'vlac_clients' );

	/* ---------- Página Facturador FEL ---------- */
	$wp_customize->add_section(
		'vlac_fac',
		array(
			'title' => __( 'Página Facturador FEL', 'vlac-systems' ),
			'panel' => 'vlac_home',
		)
	);
	$fac_fields = array(
		'fac_eyebrow'   => array( __( 'Etiqueta superior', 'vlac-systems' ), 'Facturador FEL · Guatemala', 'text' ),
		'fac_title'     => array( __( 'Título (permite HTML con <span class="accent">)', 'vlac-systems' ), 'Crea tu factura electrónica <span class="accent">FEL</span> en segundos', 'html' ),
		'fac_sub'       => array( __( 'Subtítulo', 'vlac-systems' ), 'Emite facturas certificadas ante la SAT directamente desde el sistema o desde tu cajero (punto de venta). El mismo flujo, simple y rápido.', 'textarea' ),
		'fac_cta_title' => array( __( 'CTA final · Título', 'vlac-systems' ), 'Empieza a facturar FEL hoy mismo', 'text' ),
		'fac_cta_sub'   => array( __( 'CTA final · Subtítulo', 'vlac-systems' ), 'Activa tu Facturador FEL, personalízalo con tu marca y emite tu primera factura en minutos.', 'textarea' ),
	);
	vlac_add_fields( $wp_customize, $fac_fields, 'vlac_fac' );

	/* ---------- Página Ventas y Clientes ---------- */
	$wp_customize->add_section(
		'vlac_vc',
		array(
			'title' => __( 'Página Ventas y Clientes', 'vlac-systems' ),
			'panel' => 'vlac_home',
		)
	);
	$vc_fields = array(
		'vc_eyebrow'   => array( __( 'Etiqueta superior', 'vlac-systems' ), 'Ventas y Clientes', 'text' ),
		'vc_title'     => array( __( 'Título (permite HTML con <span class="accent">)', 'vlac-systems' ), 'Gestiona tus <span class="accent">clientes</span> y tus <span class="accent">ventas</span> en un solo lugar', 'html' ),
		'vc_sub'       => array( __( 'Subtítulo', 'vlac-systems' ), 'Un directorio completo de clientes con sus direcciones y contactos, conectado a tus órdenes, cajas y reportes de venta.', 'textarea' ),
		'vc_cta_title' => array( __( 'CTA final · Título', 'vlac-systems' ), 'Conoce a fondo a tus clientes y tus ventas', 'text' ),
		'vc_cta_sub'   => array( __( 'CTA final · Subtítulo', 'vlac-systems' ), 'Centraliza tu cartera de clientes y controla cada venta desde un solo sistema.', 'textarea' ),
	);
	vlac_add_fields( $wp_customize, $vc_fields, 'vlac_vc' );

	$vc_images = array(
		'vc_img_tablet'      => __( 'Hero · Tablet', 'vlac-systems' ),
		'vc_img_phone'       => __( 'Hero · Teléfono', 'vlac-systems' ),
		'vc_img_clientes'    => __( 'Listado de clientes', 'vlac-systems' ),
		'vc_img_ficha'       => __( 'Ficha del cliente', 'vlac-systems' ),
		'vc_img_direcciones' => __( 'Direcciones y contactos', 'vlac-systems' ),
		'vc_img_ordenes'     => __( 'Órdenes', 'vlac-systems' ),
		'vc_img_cajas'       => __( 'Historial de cajas', 'vlac-systems' ),
		'vc_img_productos'   => __( 'Productos vendidos', 'vlac-systems' ),
		'vc_img_reportes'    => __( 'Reportes de venta', 'vlac-systems' ),
	);
	vlac_add_image_fields( $wp_customize, $vc_images, 'vlac_vc' );

	$vc_videos = array(
		'vc_video_clientes' => __( 'Video · Flujo de clientes (hero)', 'vlac-systems' ),
	);
	vlac_add_video_fields( $wp_customize, $vc_videos, 'vlac_vc' );

	/* ---------- Página Gestión de Contratos ---------- */
	$wp_customize->add_section(
		'vlac_con',
		array(
			'title' => __( 'Página Gestión de Contratos', 'vlac-systems' ),
			'panel' => 'vlac_home',
		)
	);
	$con_fields = array(
		'con_eyebrow'   => array( __( 'Etiqueta superior', 'vlac-systems' ), 'Gestión de Contratos', 'text' ),
		'con_title'     => array( __( 'Título (permite HTML con <span class="accent">)', 'vlac-systems' ), 'Controla tus <span class="accent">contratos</span> y cuotas sin perder el hilo', 'html' ),
		'con_sub'       => array( __( 'Subtítulo', 'vlac-systems' ), 'Crea planes de pago, registra cuotas y pagos, y consulta el estado de cada contrato: al día, vencido o pagado.', 'textarea' ),
		'con_cta_title' => array( __( 'CTA final · Título', 'vlac-systems' ), 'Ordena tus cobros por cuotas hoy', 'text' ),
		'con_cta_sub'   => array( __( 'CTA final · Subtítulo', 'vlac-systems' ), 'Crea contratos, controla sus cuotas y no vuelvas a perder de vista un pago.', 'textarea' ),
	);
	vlac_add_fields( $wp_customize, $con_fields, 'vlac_con' );

	$con_images = array(
		'con_img_hero'    => __( 'Hero · Imagen destacada (opcional)', 'vlac-systems' ),
		'con_img_listado' => __( 'Listado de contratos', 'vlac-systems' ),
		'con_img_vista'   => __( 'Vista del contrato', 'vlac-systems' ),
		'con_img_crear'   => __( 'Crear un contrato', 'vlac-systems' ),
		'con_img_cuadre'  => __( 'Cuadre mensual', 'vlac-systems' ),
	);
	vlac_add_image_fields( $wp_customize, $con_images, 'vlac_con' );

	$con_videos = array(
		'con_video_pago'   => __( 'Video · Pagar un contrato', 'vlac-systems' ),
		'con_video_cuotas' => __( 'Video · Ver cuotas', 'vlac-systems' ),
	);
	vlac_add_video_fields( $wp_customize, $con_videos, 'vlac_con' );

	/* ---------- Página Control de Asistencia (Control iD) ---------- */
	$wp_customize->add_section(
		'vlac_cid',
		array(
			'title' => __( 'Página Control de Asistencia', 'vlac-systems' ),
			'panel' => 'vlac_home',
		)
	);
	$cid_fields = array(
		'cid_eyebrow'   => array( __( 'Etiqueta superior', 'vlac-systems' ), 'Control de Asistencia · Control iD', 'text' ),
		'cid_title'     => array( __( 'Título (permite HTML con <span class="accent">)', 'vlac-systems' ), 'El <span class="accent">marcaje</span> de tu personal, conectado a la <span class="accent">nómina</span>', 'html' ),
		'cid_sub'       => array( __( 'Subtítulo', 'vlac-systems' ), 'Integramos el lector facial Control iD idFace con tu sistema: los usuarios se sincronizan solos, cada entrada y salida queda registrada, y las horas trabajadas se comparan con la jornada del contrato.', 'textarea' ),
		'cid_dev_kicker' => array( __( 'Aparato · Etiqueta', 'vlac-systems' ), 'Aparato compatible', 'text' ),
		'cid_dev_title'  => array( __( 'Aparato · Título', 'vlac-systems' ), 'Control iD idFace', 'text' ),
		'cid_dev_sub'    => array( __( 'Aparato · Descripción', 'vlac-systems' ), 'Terminal de reconocimiento facial que identifica al trabajador en menos de un segundo. Se coloca en la entrada, alterna entrada y salida solo, y le avisa al sistema cada marcaje.', 'textarea' ),
		'cid_dev_url'    => array( __( 'Aparato · Enlace a la ficha del fabricante', 'vlac-systems' ), 'https://www.controlid.com.br/es/control-de-acceso/idface/', 'url' ),
		'cid_cta_title' => array( __( 'CTA final · Título', 'vlac-systems' ), 'Deja de contar horas a mano', 'text' ),
		'cid_cta_sub'   => array( __( 'CTA final · Subtítulo', 'vlac-systems' ), 'Conecta tu lector Control iD, sincroniza a tu personal y que la nómina se calcule sola.', 'textarea' ),
	);
	vlac_add_fields( $wp_customize, $cid_fields, 'vlac_cid' );

	$cid_images = array(
		'cid_img_hero'      => __( 'Hero · Imagen destacada (opcional)', 'vlac-systems' ),
		'cid_img_sync'      => __( 'Sincronizar usuarios con el aparato', 'vlac-systems' ),
		'cid_img_aparatos'  => __( 'Aparatos registrados y su configuración', 'vlac-systems' ),
		'cid_img_registros' => __( 'Registros de horario (marcajes)', 'vlac-systems' ),
		'cid_img_contrato'  => __( 'Contrato de trabajo con la jornada', 'vlac-systems' ),
		'cid_img_nomina'    => __( 'Nómina con horas trabajadas', 'vlac-systems' ),
	);
	vlac_add_image_fields( $wp_customize, $cid_images, 'vlac_cid' );

	$cid_videos = array(
		'cid_video_marcaje' => __( 'Video · Marcaje en el aparato', 'vlac-systems' ),
	);
	vlac_add_video_fields( $wp_customize, $cid_videos, 'vlac_cid' );

	/* ---------- Página Compras y Proveedores ---------- */
	$wp_customize->add_section(
		'vlac_cp',
		array(
			'title' => __( 'Página Compras y Proveedores', 'vlac-systems' ),
			'panel' => 'vlac_home',
		)
	);
	$cp_fields = array(
		'cp_eyebrow'   => array( __( 'Etiqueta superior', 'vlac-systems' ), 'Compras y Proveedores', 'text' ),
		'cp_title'     => array( __( 'Título (permite HTML con <span class="accent">)', 'vlac-systems' ), 'Controla tus <span class="accent">compras</span> y tus <span class="accent">proveedores</span> de punta a punta', 'html' ),
		'cp_sub'       => array( __( 'Subtítulo', 'vlac-systems' ), 'Un directorio completo de proveedores conectado a tus pedidos de compra: cotiza, confirma, registra facturas y controla lo pagado y lo pendiente.', 'textarea' ),
		'cp_cta_title' => array( __( 'CTA final · Título', 'vlac-systems' ), 'Ordena tus compras y proveedores hoy', 'text' ),
		'cp_cta_sub'   => array( __( 'CTA final · Subtítulo', 'vlac-systems' ), 'Centraliza tus proveedores, controla cada pedido y no vuelvas a perder de vista un pago.', 'textarea' ),
	);
	vlac_add_fields( $wp_customize, $cp_fields, 'vlac_cp' );

	$cp_images = array(
		'cp_img_hero'        => __( 'Hero · Imagen destacada (opcional)', 'vlac-systems' ),
		'cp_img_proveedores' => __( 'Listado de proveedores', 'vlac-systems' ),
		'cp_img_proveedor'   => __( 'Ficha del proveedor', 'vlac-systems' ),
		'cp_img_pedidos'     => __( 'Panel de pedidos', 'vlac-systems' ),
		'cp_img_pedido'      => __( 'Crear un pedido', 'vlac-systems' ),
	);
	vlac_add_image_fields( $wp_customize, $cp_images, 'vlac_cp' );

	$cp_videos = array(
		'cp_video_pedido' => __( 'Video · Crear un pedido a proveedor', 'vlac-systems' ),
	);
	vlac_add_video_fields( $wp_customize, $cp_videos, 'vlac_cp' );

	/* ---------- Página Inventario y Productos ---------- */
	$wp_customize->add_section(
		'vlac_inv',
		array(
			'title' => __( 'Página Inventario y Productos', 'vlac-systems' ),
			'panel' => 'vlac_home',
		)
	);
	$inv_fields = array(
		'inv_eyebrow'   => array( __( 'Etiqueta superior', 'vlac-systems' ), 'Inventario y Productos', 'text' ),
		'inv_title'     => array( __( 'Título (permite HTML con <span class="accent">)', 'vlac-systems' ), 'Un solo <span class="accent">panel</span> para todo tu <span class="accent">inventario</span>', 'html' ),
		'inv_sub'       => array( __( 'Subtítulo', 'vlac-systems' ), 'Conteos, existencias, movimientos y traslados entre bodegas, más un catálogo de productos completo con costos, precios e historial de inventario.', 'textarea' ),
		'inv_cta_title' => array( __( 'CTA final · Título', 'vlac-systems' ), 'Toma el control de tu inventario hoy', 'text' ),
		'inv_cta_sub'   => array( __( 'CTA final · Subtítulo', 'vlac-systems' ), 'Cuenta, valoriza, mueve y controla tu stock desde un solo panel conectado a tus ventas y compras.', 'textarea' ),
	);
	vlac_add_fields( $wp_customize, $inv_fields, 'vlac_inv' );

	// Capturas de pantalla (selector de medios de WordPress). Si se elige una
	// imagen aquí, tiene prioridad sobre el archivo de /assets/img/.
	$inv_images = array(
		'inv_img_hero'         => __( 'Hero · Imagen destacada (opcional)', 'vlac-systems' ),
		'inv_img_panel'        => __( 'Panel de inventario', 'vlac-systems' ),
		'inv_img_conteo'       => __( 'Conteo de inventario', 'vlac-systems' ),
		'inv_img_conteo_print' => __( 'Impresión del conteo (térmica / PDF)', 'vlac-systems' ),
		'inv_img_existencias'  => __( 'Situación de inventario (existencias)', 'vlac-systems' ),
		'inv_img_movimientos'  => __( 'Registro de movimientos', 'vlac-systems' ),
		'inv_img_traslados'    => __( 'Traslados', 'vlac-systems' ),
		'inv_img_gestion'      => __( 'Gestión de traslados', 'vlac-systems' ),
		'inv_img_productos'    => __( 'Listado de productos', 'vlac-systems' ),
		'inv_img_producto'     => __( 'Ficha del producto', 'vlac-systems' ),
	);
	vlac_add_image_fields( $wp_customize, $inv_images, 'vlac_inv' );

	$inv_videos = array(
		'inv_video_conteo' => __( 'Video · Conteo de inventario', 'vlac-systems' ),
	);
	vlac_add_video_fields( $wp_customize, $inv_videos, 'vlac_inv' );

	/* ---------- Página Punto de Venta ---------- */
	$wp_customize->add_section(
		'vlac_pos',
		array(
			'title' => __( 'Página Punto de Venta', 'vlac-systems' ),
			'panel' => 'vlac_home',
		)
	);
	$pos_fields = array(
		'pos_eyebrow'   => array( __( 'Etiqueta superior', 'vlac-systems' ), 'Punto de Venta', 'text' ),
		'pos_title'     => array( __( 'Título (permite HTML con <span class="accent">)', 'vlac-systems' ), 'Tu <span class="accent">caja</span> completa, del turno a la <span class="accent">factura</span>', 'html' ),
		'pos_sub'       => array( __( 'Subtítulo', 'vlac-systems' ), 'Abre la caja, toma órdenes, cobra con cualquier forma de pago, factura, registra gastos y cierra con arqueo. Todo queda cuadrado y auditable al final del turno.', 'textarea' ),
		'pos_cta_title' => array( __( 'CTA final · Título', 'vlac-systems' ), 'Pon a trabajar tu punto de venta hoy', 'text' ),
		'pos_cta_sub'   => array( __( 'CTA final · Subtítulo', 'vlac-systems' ), 'Cobra más rápido, factura al instante y cierra cada turno cuadrado, con la caja conectada a tu inventario y tus ventas.', 'textarea' ),
	);
	vlac_add_fields( $wp_customize, $pos_fields, 'vlac_pos' );

	// Capturas de pantalla (selector de medios de WordPress). Si se elige una
	// imagen aquí, tiene prioridad sobre el archivo de /assets/img/.
	$pos_images = array(
		'pos_img_hero'        => __( 'Hero · Imagen destacada (opcional)', 'vlac-systems' ),
		'pos_img_cajas'       => __( 'Listado de cajas', 'vlac-systems' ),
		'pos_img_apertura'    => __( 'Apertura de caja', 'vlac-systems' ),
		'pos_img_orden'       => __( 'Pantalla de orden (POS)', 'vlac-systems' ),
		'pos_img_pago'        => __( 'Cobro y tipos de pago', 'vlac-systems' ),
		'pos_img_factura'     => __( 'Factura / recibo térmico', 'vlac-systems' ),
		'pos_img_gastos'      => __( 'Registro de gastos', 'vlac-systems' ),
		'pos_img_resumen'     => __( 'Resumen de caja', 'vlac-systems' ),
		'pos_img_libro'       => __( 'Libro de caja / historial', 'vlac-systems' ),
	);
	vlac_add_image_fields( $wp_customize, $pos_images, 'vlac_pos' );

	$pos_videos = array(
		'pos_video_operaciones' => __( 'Video · Operaciones de caja', 'vlac-systems' ),
		'pos_video_billetes'    => __( 'Video · Cálculo de billetes (arqueo)', 'vlac-systems' ),
		'pos_video_venta'       => __( 'Video · Una venta en el punto de venta', 'vlac-systems' ),
	);
	vlac_add_video_fields( $wp_customize, $pos_videos, 'vlac_pos' );

	/* ---------- Página Ferretería y Vidriería ---------- */
	$wp_customize->add_section(
		'vlac_fer',
		array(
			'title' => __( 'Página Ferretería y Vidriería', 'vlac-systems' ),
			'panel' => 'vlac_home',
		)
	);
	$fer_fields = array(
		'fer_eyebrow'   => array( __( 'Etiqueta superior', 'vlac-systems' ), 'Ferretería y Vidriería', 'text' ),
		'fer_title'     => array( __( 'Título (permite HTML con <span class="accent">)', 'vlac-systems' ), 'El sistema para tu <span class="accent">ferretería</span> y <span class="accent">vidriería</span>', 'html' ),
		'fer_sub'       => array( __( 'Subtítulo', 'vlac-systems' ), 'Maneja miles de artículos con su unidad de medida, compra a tus proveedores, cotiza trabajos, etiqueta con código de barras y vende rápido en caja, todo en un mismo sistema.', 'textarea' ),
		'fer_cta_title' => array( __( 'CTA final · Título', 'vlac-systems' ), 'Ordena tu ferretería y vidriería hoy', 'text' ),
		'fer_cta_sub'   => array( __( 'CTA final · Subtítulo', 'vlac-systems' ), 'Controla miles de artículos por medida, compra, cotiza, etiqueta y vende desde un solo sistema conectado.', 'textarea' ),
	);
	vlac_add_fields( $wp_customize, $fer_fields, 'vlac_fer' );

	// Capturas de pantalla (selector de medios de WordPress). Si se elige una
	// imagen aquí, tiene prioridad sobre el archivo de /assets/img/.
	$fer_images = array(
		'fer_img_hero'        => __( 'Hero · Imagen destacada (opcional)', 'vlac-systems' ),
		'fer_img_medidas'     => __( 'Ficha del artículo (unidad de medida)', 'vlac-systems' ),
		'fer_img_catalogo'    => __( 'Catálogo / listado de artículos', 'vlac-systems' ),
	);
	vlac_add_image_fields( $wp_customize, $fer_images, 'vlac_fer' );

	$fer_videos = array(
		'fer_video_cotizacion' => __( 'Video · Cotización de un trabajo', 'vlac-systems' ),
		'fer_video_existencias' => __( 'Video · Existencias por bodega', 'vlac-systems' ),
		'fer_video_venta'       => __( 'Video · Una venta de mostrador', 'vlac-systems' ),
	);
	vlac_add_video_fields( $wp_customize, $fer_videos, 'vlac_fer' );

	/* ---------- Página Venta de Repuestos ---------- */
	$wp_customize->add_section(
		'vlac_rep',
		array(
			'title' => __( 'Página Venta de Repuestos', 'vlac-systems' ),
			'panel' => 'vlac_home',
		)
	);
	$rep_fields = array(
		'rep_eyebrow'   => array( __( 'Etiqueta superior', 'vlac-systems' ), 'Venta de Repuestos', 'text' ),
		'rep_title'     => array( __( 'Título (permite HTML con <span class="accent">)', 'vlac-systems' ), 'El sistema para tu <span class="accent">venta de repuestos</span>', 'html' ),
		'rep_sub'       => array( __( 'Subtítulo', 'vlac-systems' ), 'Encuentra la pieza por cualquiera de sus códigos, sabe en qué anaquel está y en qué sucursal queda, cotiza al taller y vende en mostrador con su factura.', 'textarea' ),
		'rep_cta_title' => array( __( 'CTA final · Título', 'vlac-systems' ), 'Ordena tu venta de repuestos hoy', 'text' ),
		'rep_cta_sub'   => array( __( 'CTA final · Subtítulo', 'vlac-systems' ), 'Catálogo, códigos, existencias, proveedores y facturación en un solo sistema conectado.', 'textarea' ),
	);
	vlac_add_fields( $wp_customize, $rep_fields, 'vlac_rep' );

	// Capturas de pantalla (selector de medios de WordPress). Si se elige una
	// imagen aquí, tiene prioridad sobre el archivo de /assets/img/.
	$rep_images = array(
		'rep_img_hero'         => __( 'Hero · Ficha del repuesto o catálogo', 'vlac-systems' ),
		'rep_img_existencias'  => __( 'Existencias por sucursal', 'vlac-systems' ),
		'rep_img_precios'      => __( 'Listas de precios', 'vlac-systems' ),
		'rep_img_proveedores'  => __( 'Compra o requisición a proveedores', 'vlac-systems' ),
	);
	vlac_add_image_fields( $wp_customize, $rep_images, 'vlac_rep' );

	$rep_videos = array(
		'rep_video_busqueda' => __( 'Video · Encontrar la pieza', 'vlac-systems' ),
		'rep_video_venta'    => __( 'Video · Una venta de mostrador', 'vlac-systems' ),
	);
	vlac_add_video_fields( $wp_customize, $rep_videos, 'vlac_rep' );

	/* ---------- Página Talleres ---------- */
	$wp_customize->add_section(
		'vlac_tal',
		array(
			'title' => __( 'Página Talleres', 'vlac-systems' ),
			'panel' => 'vlac_home',
		)
	);
	$tal_fields = array(
		'tal_eyebrow'   => array( __( 'Etiqueta superior', 'vlac-systems' ), 'Talleres', 'text' ),
		'tal_title'     => array( __( 'Título (permite HTML con <span class="accent">)', 'vlac-systems' ), 'El sistema para tu <span class="accent">taller</span>', 'html' ),
		'tal_sub'       => array( __( 'Subtítulo', 'vlac-systems' ), 'Levanta la orden de servicio con los datos que tu taller pide, cotiza el trabajo, controla en qué va cada unidad y entrega con su comprobante, sus repuestos y su factura.', 'textarea' ),
		'tal_cta_title' => array( __( 'CTA final · Título', 'vlac-systems' ), 'Ordena tu taller desde la primera cotización', 'text' ),
		'tal_cta_sub'   => array( __( 'CTA final · Subtítulo', 'vlac-systems' ), 'Órdenes de servicio, anticipos, repuestos, comisiones y facturación en un solo sistema conectado.', 'textarea' ),
	);
	vlac_add_fields( $wp_customize, $tal_fields, 'vlac_tal' );

	// Capturas de pantalla (selector de medios de WordPress). Si se elige una
	// imagen aquí, tiene prioridad sobre el archivo de /assets/img/.
	$tal_images = array(
		'tal_img_hero'      => __( 'Hero · Orden de servicio abierta', 'vlac-systems' ),
		'tal_img_lista'     => __( 'Listado de órdenes con sus estados', 'vlac-systems' ),
		'tal_img_plantilla' => __( 'Plantilla y campos de la orden', 'vlac-systems' ),
		'tal_img_cuenta'    => __( 'Cobro con repuestos y anticipos', 'vlac-systems' ),
		'tal_img_impresion' => __( 'Comprobante impreso o de entrega', 'vlac-systems' ),
	);
	vlac_add_image_fields( $wp_customize, $tal_images, 'vlac_tal' );

	$tal_videos = array(
		'tal_video_orden' => __( 'Video · Crear una orden de servicio', 'vlac-systems' ),
	);
	vlac_add_video_fields( $wp_customize, $tal_videos, 'vlac_tal' );

	/* ---------- Página Veterinarias ---------- */
	$wp_customize->add_section(
		'vlac_vet',
		array(
			'title' => __( 'Página Veterinarias', 'vlac-systems' ),
			'panel' => 'vlac_home',
		)
	);
	$vet_fields = array(
		'vet_eyebrow'   => array( __( 'Etiqueta superior', 'vlac-systems' ), 'Veterinarias', 'text' ),
		'vet_title'     => array( __( 'Título (permite HTML con <span class="accent">)', 'vlac-systems' ), 'El sistema para tu <span class="accent">veterinaria</span>', 'html' ),
		'vet_sub'       => array( __( 'Subtítulo', 'vlac-systems' ), 'Cada dueño con sus mascotas y cada mascota con su ficha, su historial, sus vacunas y sus recetas. Atiende, vende el alimento y factura desde el mismo lugar.', 'textarea' ),
		'vet_cta_title' => array( __( 'CTA final · Título', 'vlac-systems' ), 'Ordena tu veterinaria y cuida mejor a cada paciente', 'text' ),
		'vet_cta_sub'   => array( __( 'CTA final · Subtítulo', 'vlac-systems' ), 'Fichas, historial, vacunas, recetas, inventario y facturación en un solo sistema conectado.', 'textarea' ),
	);
	vlac_add_fields( $wp_customize, $vet_fields, 'vlac_vet' );

	// Capturas de pantalla (selector de medios de WordPress). Si se elige una
	// imagen aquí, tiene prioridad sobre el archivo de /assets/img/.
	$vet_images = array(
		'vet_img_hero'      => __( 'Hero · Atendimiento de la mascota', 'vlac-systems' ),
		'vet_img_ficha'     => __( 'Ficha de la mascota', 'vlac-systems' ),
		'vet_img_mascotas'  => __( 'Listado de mascotas del dueño', 'vlac-systems' ),
		'vet_img_vacunas'   => __( 'Registro de vacunas', 'vlac-systems' ),
		'vet_img_registrar' => __( 'Alta de una mascota nueva', 'vlac-systems' ),
		'vet_img_cuenta'    => __( 'Cobro de la consulta y los productos', 'vlac-systems' ),
	);
	vlac_add_image_fields( $wp_customize, $vet_images, 'vlac_vet' );

	$vet_videos = array(
		'vet_video_consulta' => __( 'Video · Atender a la mascota y registrar la vacuna', 'vlac-systems' ),
	);
	vlac_add_video_fields( $wp_customize, $vet_videos, 'vlac_vet' );

	/* ---------- Página Clínicas y Hospitales ---------- */
	$wp_customize->add_section(
		'vlac_cli',
		array(
			'title' => __( 'Página Clínicas y Hospitales', 'vlac-systems' ),
			'panel' => 'vlac_home',
		)
	);
	$cli_fields = array(
		'cli_eyebrow'   => array( __( 'Etiqueta superior', 'vlac-systems' ), 'Clínicas y Hospitales', 'text' ),
		'cli_title'     => array( __( 'Título (permite HTML con <span class="accent">)', 'vlac-systems' ), 'El sistema para tu <span class="accent">clínica</span> u <span class="accent">hospital</span>', 'html' ),
		'cli_sub'       => array( __( 'Subtítulo', 'vlac-systems' ), 'Agenda las citas, atiende la consulta con tus propios formularios, emite recetas y guarda todo en el expediente del paciente, con el cobro y la factura en el mismo lugar.', 'textarea' ),
		'cli_cta_title' => array( __( 'CTA final · Título', 'vlac-systems' ), 'Ordena tu clínica y dedica el tiempo al paciente', 'text' ),
		'cli_cta_sub'   => array( __( 'CTA final · Subtítulo', 'vlac-systems' ), 'Agenda, expediente, recetas, vacunas y cobro en un solo sistema conectado, con el historial de cada paciente siempre a la mano.', 'textarea' ),
	);
	vlac_add_fields( $wp_customize, $cli_fields, 'vlac_cli' );

	// Capturas de pantalla (selector de medios de WordPress). Si se elige una
	// imagen aquí, tiene prioridad sobre el archivo de /assets/img/.
	$cli_images = array(
		'cli_img_agenda'     => __( 'Hero · Agenda de citas del día', 'vlac-systems' ),
		'cli_img_expediente' => __( 'Historial médico del paciente', 'vlac-systems' ),
		'cli_img_formulario' => __( 'Formulario configurable de la consulta', 'vlac-systems' ),
		'cli_img_preguntas'  => __( 'Listado de preguntas del formulario', 'vlac-systems' ),
		'cli_img_receta'     => __( 'Receta o nota lista para imprimir', 'vlac-systems' ),
		'cli_img_cuenta'     => __( 'Cobro de la consulta', 'vlac-systems' ),
		'cli_img_agendar'    => __( 'Nueva consulta (agendar una cita)', 'vlac-systems' ),
	);
	vlac_add_image_fields( $wp_customize, $cli_images, 'vlac_cli' );

	$cli_videos = array(
		'cli_video_consulta' => __( 'Video · Atender la consulta', 'vlac-systems' ),
		'cli_video_receta'   => __( 'Video · Emitir una receta', 'vlac-systems' ),
	);
	vlac_add_video_fields( $wp_customize, $cli_videos, 'vlac_cli' );

	/* ---------- Página Hoteles y Posadas ---------- */
	$wp_customize->add_section(
		'vlac_hot',
		array(
			'title' => __( 'Página Hoteles y Posadas', 'vlac-systems' ),
			'panel' => 'vlac_home',
		)
	);
	$hot_fields = array(
		'hot_eyebrow'   => array( __( 'Etiqueta superior', 'vlac-systems' ), 'Hoteles y Posadas', 'text' ),
		'hot_title'     => array( __( 'Título (permite HTML con <span class="accent">)', 'vlac-systems' ), 'El sistema para tu <span class="accent">hotel</span> o <span class="accent">posada</span>', 'html' ),
		'hot_sub'       => array( __( 'Subtítulo', 'vlac-systems' ), 'Mira la disponibilidad de todas tus habitaciones en un solo mapa, reserva, haz check-in cama por cama y cierra la cuenta con los consumos y la factura al momento de la salida.', 'textarea' ),
		'hot_cta_title' => array( __( 'CTA final · Título', 'vlac-systems' ), 'Llena tu hotel y controla cada habitación', 'text' ),
		'hot_cta_sub'   => array( __( 'CTA final · Subtítulo', 'vlac-systems' ), 'Reserva, hospeda, cobra y factura desde un solo sistema conectado, con la disponibilidad de tus habitaciones siempre al día.', 'textarea' ),
	);
	vlac_add_fields( $wp_customize, $hot_fields, 'vlac_hot' );

	// Capturas de pantalla (selector de medios de WordPress). Si se elige una
	// imagen aquí, tiene prioridad sobre el archivo de /assets/img/.
	$hot_images = array(
		'hot_img_hero'       => __( 'Hero · Foto del hotel o la posada (opcional)', 'vlac-systems' ),
		'hot_img_mapa'       => __( 'Mapa de disponibilidad (habitaciones × días)', 'vlac-systems' ),
		'hot_img_habitacion' => __( 'Ficha de la habitación (código, categoría, camas)', 'vlac-systems' ),
		'hot_img_reserva'    => __( 'Detalle de la reserva', 'vlac-systems' ),
		'hot_img_categorias' => __( 'Categorías con planes de tarifa', 'vlac-systems' ),
		'hot_img_precios'    => __( 'Precios por temporada / días de la semana', 'vlac-systems' ),
		'hot_img_informes'   => __( 'Informe de reservas / ocupación', 'vlac-systems' ),
	);
	vlac_add_image_fields( $wp_customize, $hot_images, 'vlac_hot' );

	$hot_videos = array(
		'hot_video_reserva'  => __( 'Video · Crear una reserva desde el mapa', 'vlac-systems' ),
		'hot_video_checkin'  => __( 'Video · Check-in con asignación de camas', 'vlac-systems' ),
		'hot_video_checkout' => __( 'Video · Check-out y facturación', 'vlac-systems' ),
	);
	vlac_add_video_fields( $wp_customize, $hot_videos, 'vlac_hot' );

	/* ---------- Página Tienda de Ropa ---------- */
	$wp_customize->add_section(
		'vlac_ropa',
		array(
			'title' => __( 'Página Tienda de Ropa', 'vlac-systems' ),
			'panel' => 'vlac_home',
		)
	);
	$ropa_fields = array(
		'ropa_eyebrow'   => array( __( 'Etiqueta superior', 'vlac-systems' ), 'Tienda de Ropa', 'text' ),
		'ropa_title'     => array( __( 'Título (permite HTML con <span class="accent">)', 'vlac-systems' ), 'El sistema hecho para tu <span class="accent">tienda de ropa</span>', 'html' ),
		'ropa_sub'       => array( __( 'Subtítulo', 'vlac-systems' ), 'Controla cada prenda por talla y color, imprime etiquetas con código de barras, vende rápido en caja y sabe qué se vende por temporada, todo en un mismo sistema.', 'textarea' ),
		'ropa_cta_title' => array( __( 'CTA final · Título', 'vlac-systems' ), 'Lleva tu tienda de ropa al siguiente nivel', 'text' ),
		'ropa_cta_sub'   => array( __( 'CTA final · Subtítulo', 'vlac-systems' ), 'Controla cada prenda por talla y color, etiqueta, vende y analiza tu temporada desde un solo sistema conectado.', 'textarea' ),
	);
	vlac_add_fields( $wp_customize, $ropa_fields, 'vlac_ropa' );

	// Capturas de pantalla (selector de medios de WordPress). Si se elige una
	// imagen aquí, tiene prioridad sobre el archivo de /assets/img/.
	$ropa_images = array(
		'ropa_img_hero'        => __( 'Hero · Imagen destacada (opcional)', 'vlac-systems' ),
		'ropa_img_producto'    => __( 'Ficha del producto (talla, color, marca)', 'vlac-systems' ),
		'ropa_img_existencias' => __( 'Existencias por variante', 'vlac-systems' ),
		'ropa_img_etiquetas'   => __( 'Etiqueta con código de barras', 'vlac-systems' ),
		'ropa_img_catalogo'    => __( 'Catálogo / listado con fotos', 'vlac-systems' ),
		'ropa_img_informes'    => __( 'Informe de ventas por temporada', 'vlac-systems' ),
	);
	vlac_add_image_fields( $wp_customize, $ropa_images, 'vlac_ropa' );

	$ropa_videos = array(
		'ropa_video_variantes' => __( 'Video · Variantes de la prenda', 'vlac-systems' ),
		'ropa_video_venta'     => __( 'Video · Una venta de ropa', 'vlac-systems' ),
	);
	vlac_add_video_fields( $wp_customize, $ropa_videos, 'vlac_ropa' );

	/* ---------- Página Gestión Financiera ---------- */
	$wp_customize->add_section(
		'vlac_fin',
		array(
			'title' => __( 'Página Gestión Financiera', 'vlac-systems' ),
			'panel' => 'vlac_home',
		)
	);
	$fin_fields = array(
		'fin_eyebrow'   => array( __( 'Etiqueta superior', 'vlac-systems' ), 'Gestión Financiera', 'text' ),
		'fin_title'     => array( __( 'Título (permite HTML con <span class="accent">)', 'vlac-systems' ), 'Toda tu <span class="accent">operación financiera</span> bajo control', 'html' ),
		'fin_sub'       => array( __( 'Subtítulo', 'vlac-systems' ), 'Caja general, comisiones, crédito de clientes, facturas, gastos y ventas por vendedor: el dinero de tu negocio, ordenado en un solo lugar.', 'textarea' ),
		'fin_cta_title' => array( __( 'CTA final · Título', 'vlac-systems' ), 'Ordena las finanzas de tu negocio hoy', 'text' ),
		'fin_cta_sub'   => array( __( 'CTA final · Subtítulo', 'vlac-systems' ), 'Controla tu caja, tus comisiones, tu crédito y tus gastos desde un solo lugar conectado a tus ventas.', 'textarea' ),
	);
	vlac_add_fields( $wp_customize, $fin_fields, 'vlac_fin' );

	$fin_images = array(
		'fin_img_hero'          => __( 'Hero · Imagen destacada (opcional)', 'vlac-systems' ),
		'fin_img_caja'          => __( 'Caja general / transacciones', 'vlac-systems' ),
		'fin_img_cuenta'        => __( 'Vista por cuenta bancaria', 'vlac-systems' ),
		'fin_img_cuadre'        => __( 'Cuadre por sucursales', 'vlac-systems' ),
		'fin_img_com_generar'   => __( 'Generador de comisiones', 'vlac-systems' ),
		'fin_img_com_gestion'   => __( 'Pagar / gestión de comisiones', 'vlac-systems' ),
		'fin_img_credito'       => __( 'Crédito de clientes — listado', 'vlac-systems' ),
		'fin_img_credito_ficha' => __( 'Crédito de clientes — ficha', 'vlac-systems' ),
		'fin_img_facturas'      => __( 'Control de facturas', 'vlac-systems' ),
		'fin_img_gastos'        => __( 'Control de gastos', 'vlac-systems' ),
		'fin_img_ventas'        => __( 'Ventas por vendedor', 'vlac-systems' ),
	);
	vlac_add_image_fields( $wp_customize, $fin_images, 'vlac_fin' );

	$fin_videos = array(
		'fin_video_caja' => __( 'Video · Movimiento de caja', 'vlac-systems' ),
	);
	vlac_add_video_fields( $wp_customize, $fin_videos, 'vlac_fin' );

	/* ---------- Página Gestión de Usuarios ---------- */
	$wp_customize->add_section(
		'vlac_usr',
		array(
			'title' => __( 'Página Gestión de Usuarios', 'vlac-systems' ),
			'panel' => 'vlac_home',
		)
	);
	$usr_fields = array(
		'usr_eyebrow'   => array( __( 'Etiqueta superior', 'vlac-systems' ), 'Gestión de Usuarios', 'text' ),
		'usr_title'     => array( __( 'Título (permite HTML con <span class="accent">)', 'vlac-systems' ), 'Cada persona con su <span class="accent">rol</span> y sus <span class="accent">permisos</span>', 'html' ),
		'usr_sub'       => array( __( 'Subtítulo', 'vlac-systems' ), 'Crea usuarios, asígnales roles por sucursal, y habilita, deshabilita o elimina accesos cuando lo necesites. Tu equipo, bajo control.', 'textarea' ),
		'usr_cta_title' => array( __( 'CTA final · Título', 'vlac-systems' ), 'Ordena los accesos de tu equipo hoy', 'text' ),
		'usr_cta_sub'   => array( __( 'CTA final · Subtítulo', 'vlac-systems' ), 'Define quién entra, a qué sucursal y con qué permisos, desde un solo lugar.', 'textarea' ),
	);
	vlac_add_fields( $wp_customize, $usr_fields, 'vlac_usr' );

	$usr_images = array(
		'usr_img_hero'         => __( 'Hero · Imagen destacada (opcional)', 'vlac-systems' ),
		'usr_img_listado'      => __( 'Listado de usuarios con sus roles', 'vlac-systems' ),
		'usr_img_ficha'        => __( 'Ficha y permisos por sucursal', 'vlac-systems' ),
		'usr_img_crear'        => __( 'Crear un usuario', 'vlac-systems' ),
		'usr_img_deshabilitar' => __( 'Confirmación de deshabilitar', 'vlac-systems' ),
		'usr_img_eliminar'     => __( 'Confirmación de eliminación', 'vlac-systems' ),
	);
	vlac_add_image_fields( $wp_customize, $usr_images, 'vlac_usr' );

	/* ---------- Página Múltiples Sucursales ---------- */
	$wp_customize->add_section(
		'vlac_ms',
		array(
			'title' => __( 'Página Múltiples Sucursales', 'vlac-systems' ),
			'panel' => 'vlac_home',
		)
	);
	$ms_fields = array(
		'ms_eyebrow'   => array( __( 'Etiqueta superior', 'vlac-systems' ), 'Múltiples Sucursales', 'text' ),
		'ms_title'     => array( __( 'Título (permite HTML con <span class="accent">)', 'vlac-systems' ), 'Un sistema, <span class="accent">todas</span> tus sucursales', 'html' ),
		'ms_sub'       => array( __( 'Subtítulo', 'vlac-systems' ), 'Cada sucursal con su propia información, existencias, ventas y equipo —y todas conectadas entre sí desde un mismo lugar.', 'textarea' ),
		'ms_cta_title' => array( __( 'CTA final · Título', 'vlac-systems' ), 'Haz crecer tu negocio, sucursal por sucursal', 'text' ),
		'ms_cta_sub'   => array( __( 'CTA final · Subtítulo', 'vlac-systems' ), 'Abre una nueva sucursal sin duplicar sistemas: mismo software, misma marca, datos separados.', 'textarea' ),
	);
	vlac_add_fields( $wp_customize, $ms_fields, 'vlac_ms' );

	$ms_images = array(
		'ms_img_hero'              => __( 'Hero · Imagen destacada (opcional)', 'vlac-systems' ),
		'ms_img_negocio'           => __( 'Información del negocio — sucursal 1', 'vlac-systems' ),
		'ms_img_negocio_2'         => __( 'Información del negocio — sucursal 2', 'vlac-systems' ),
		'ms_img_existencias'       => __( 'Existencias por sucursal', 'vlac-systems' ),
		'ms_img_ventas'            => __( 'Ventas por sucursal', 'vlac-systems' ),
		'ms_img_usuarios'          => __( 'Usuarios por sucursal', 'vlac-systems' ),
		'ms_img_traslado_detalle'  => __( 'Traslados · 1. Detalle del traslado', 'vlac-systems' ),
		'ms_img_traslados_salidas' => __( 'Traslados · 2. Salidas y confirmación', 'vlac-systems' ),
		'ms_img_traslados'         => __( 'Traslados · 3. Ingresos / recepción', 'vlac-systems' ),
	);
	vlac_add_image_fields( $wp_customize, $ms_images, 'vlac_ms' );

	/* ---------- Página Informes ---------- */
	$wp_customize->add_section(
		'vlac_inf',
		array(
			'title' => __( 'Página Informes', 'vlac-systems' ),
			'panel' => 'vlac_home',
		)
	);
	$inf_fields = array(
		'inf_eyebrow'   => array( __( 'Etiqueta superior', 'vlac-systems' ), 'Informes', 'text' ),
		'inf_title'     => array( __( 'Título (permite HTML con <span class="accent">)', 'vlac-systems' ), 'Un <span class="accent">informe</span> para cada pregunta de tu negocio', 'html' ),
		'inf_sub'       => array( __( 'Subtítulo', 'vlac-systems' ), 'Ventas, inventario, finanzas, productos, clientes, caja y nómina. Elige el período, las columnas que quieres ver e imprime en PDF.', 'textarea' ),
		'inf_cta_title' => array( __( 'CTA final · Título', 'vlac-systems' ), 'Deja de adivinar: mira los números', 'text' ),
		'inf_cta_sub'   => array( __( 'CTA final · Subtítulo', 'vlac-systems' ), 'Genera el informe que necesites, con el período y las columnas que quieras, en segundos.', 'textarea' ),
	);
	vlac_add_fields( $wp_customize, $inf_fields, 'vlac_inf' );

	$inf_images = array(
		'inf_img_columnas'      => __( 'Período y columnas seleccionables', 'vlac-systems' ),
		'inf_img_pdf_ordenes'   => __( 'PDF · Órdenes', 'vlac-systems' ),
		'inf_img_pdf_inventario' => __( 'PDF · Situación de inventario', 'vlac-systems' ),
		'inf_img_pdf_caja'      => __( 'PDF · Utilidad de caja general', 'vlac-systems' ),
		'inf_img_pdf_historial' => __( 'PDF · Historial de inventario', 'vlac-systems' ),
	);
	vlac_add_image_fields( $wp_customize, $inf_images, 'vlac_inf' );

	$inf_videos = array(
		'inf_video_panel' => __( 'Video · Panel de informes', 'vlac-systems' ),
	);
	vlac_add_video_fields( $wp_customize, $inf_videos, 'vlac_inf' );

	/* ---------- Página Precios ---------- */
	$wp_customize->add_section(
		'vlac_pre',
		array(
			'title'       => __( 'Página Precios', 'vlac-systems' ),
			'description' => __( 'El plan que tenga texto en su «Etiqueta» se muestra resaltado como plan destacado. Deja la etiqueta vacía para no resaltarlo.', 'vlac-systems' ),
			'panel'       => 'vlac_home',
		)
	);
	$pre_fields = array(
		'pre_eyebrow'  => array( __( 'Etiqueta superior', 'vlac-systems' ), 'Planes y precios', 'text' ),
		'pre_title'    => array( __( 'Título (permite HTML con <span class="accent">)', 'vlac-systems' ), 'Elige el plan que le queda a tu <span class="accent">negocio</span>', 'html' ),
		'pre_sub'      => array( __( 'Subtítulo', 'vlac-systems' ), 'Todos los planes incluyen el sistema completo. Lo único que cambia es cuántas sucursales y cuántos usuarios necesitas.', 'textarea' ),
		'pre_note'     => array( __( 'Nota bajo el subtítulo', 'vlac-systems' ), 'Facturador FEL y todos los módulos incluidos en cada plan', 'text' ),
		'pre_currency' => array( __( 'Moneda (símbolo)', 'vlac-systems' ), 'Q', 'text' ),
		'pre_period'   => array( __( 'Periodicidad (texto bajo el precio)', 'vlac-systems' ), 'al mes', 'text' ),
		'pre_btn_txt'  => array( __( 'Botón de los planes — texto', 'vlac-systems' ), 'Empezar', 'text' ),
		'pre_cta_url'  => array( __( 'Botón de los planes — enlace (vacío = página de Contacto)', 'vlac-systems' ), '', 'url' ),

		'pre_p1_name'     => array( __( 'Plan 1 · Nombre', 'vlac-systems' ), 'Básico', 'text' ),
		'pre_p1_price'    => array( __( 'Plan 1 · Precio', 'vlac-systems' ), '200', 'text' ),
		'pre_p1_branches' => array( __( 'Plan 1 · Sucursales', 'vlac-systems' ), '1', 'text' ),
		'pre_p1_users'    => array( __( 'Plan 1 · Usuarios', 'vlac-systems' ), '3', 'text' ),
		'pre_p1_badge'    => array( __( 'Plan 1 · Etiqueta (vacío = sin resaltar)', 'vlac-systems' ), '', 'text' ),

		'pre_p2_name'     => array( __( 'Plan 2 · Nombre', 'vlac-systems' ), 'Esencial', 'text' ),
		'pre_p2_price'    => array( __( 'Plan 2 · Precio', 'vlac-systems' ), '550', 'text' ),
		'pre_p2_branches' => array( __( 'Plan 2 · Sucursales', 'vlac-systems' ), '1', 'text' ),
		'pre_p2_users'    => array( __( 'Plan 2 · Usuarios', 'vlac-systems' ), '10', 'text' ),
		'pre_p2_badge'    => array( __( 'Plan 2 · Etiqueta (vacío = sin resaltar)', 'vlac-systems' ), '', 'text' ),

		'pre_p3_name'     => array( __( 'Plan 3 · Nombre', 'vlac-systems' ), 'Estándar', 'text' ),
		'pre_p3_price'    => array( __( 'Plan 3 · Precio', 'vlac-systems' ), '1000', 'text' ),
		'pre_p3_branches' => array( __( 'Plan 3 · Sucursales', 'vlac-systems' ), '2', 'text' ),
		'pre_p3_users'    => array( __( 'Plan 3 · Usuarios', 'vlac-systems' ), '20', 'text' ),
		'pre_p3_badge'    => array( __( 'Plan 3 · Etiqueta (vacío = sin resaltar)', 'vlac-systems' ), 'Más popular', 'text' ),

		'pre_p4_name'     => array( __( 'Plan 4 · Nombre', 'vlac-systems' ), 'Premium', 'text' ),
		'pre_p4_price'    => array( __( 'Plan 4 · Precio', 'vlac-systems' ), '2000', 'text' ),
		'pre_p4_branches' => array( __( 'Plan 4 · Sucursales', 'vlac-systems' ), '4', 'text' ),
		'pre_p4_users'    => array( __( 'Plan 4 · Usuarios', 'vlac-systems' ), '50', 'text' ),
		'pre_p4_badge'    => array( __( 'Plan 4 · Etiqueta (vacío = sin resaltar)', 'vlac-systems' ), '', 'text' ),

		'pre_cta_title' => array( __( 'CTA final · Título', 'vlac-systems' ), '¿No sabes cuál plan te conviene?', 'text' ),
		'pre_cta_sub'   => array( __( 'CTA final · Subtítulo', 'vlac-systems' ), 'Cuéntanos cuántas sucursales tienes y cuánta gente lo va a usar. Un asesor te dice cuál te queda mejor.', 'textarea' ),
	);
	vlac_add_fields( $wp_customize, $pre_fields, 'vlac_pre' );

	/* ---------- Barra superior / botones del header ---------- */
	$wp_customize->add_section(
		'vlac_header',
		array(
			'title' => __( 'Encabezado (botones)', 'vlac-systems' ),
			'panel' => 'vlac_home',
		)
	);
	$header_fields = array(
		'hdr_login_txt'  => array( __( 'Iniciar sesión — texto', 'vlac-systems' ), 'Iniciar sesión', 'text' ),
		'hdr_login_url'  => array( __( 'Iniciar sesión — enlace', 'vlac-systems' ), '#', 'url' ),
		'hdr_cta_txt'    => array( __( 'Botón rojo — texto', 'vlac-systems' ), 'Prueba gratis', 'text' ),
		'hdr_cta_url'    => array( __( 'Botón rojo — enlace (vacío = página de Contacto)', 'vlac-systems' ), '', 'url' ),
		'hdr_asesor_txt' => array( __( 'Botón «Hablar con un asesor» (menú Industrias) — texto', 'vlac-systems' ), 'Hablar con un asesor', 'text' ),
		'hdr_asesor_url' => array( __( 'Botón «Hablar con un asesor» (menú Industrias) — enlace (vacío = Contacto)', 'vlac-systems' ), '', 'url' ),
		'agent_title'    => array( __( 'Menú «Agente» — título', 'vlac-systems' ), 'Agente de impresión', 'text' ),
		'agent_desc'     => array( __( 'Menú «Agente» — descripción', 'vlac-systems' ), VLAC_AGENT_DESC, 'textarea' ),
		'agent_btn_txt'  => array( __( 'Menú «Agente» — texto del botón', 'vlac-systems' ), 'Descargar agente', 'text' ),
		'agent_json'     => array( __( 'Menú «Agente» — JSON de versión (se lee automáticamente)', 'vlac-systems' ), VLAC_AGENT_JSON, 'url' ),
		'agent_url'      => array( __( 'Menú «Agente» — enlace fijo del .exe (vacío = usa el JSON)', 'vlac-systems' ), '', 'url' ),
		'agent_note'     => array( __( 'Menú «Agente» — nota bajo el botón', 'vlac-systems' ), 'Windows · Instalador .exe', 'text' ),
	);
	vlac_add_fields( $wp_customize, $header_fields, 'vlac_header' );

	/* ---------- Página Restaurantes (botones) ---------- */
	$wp_customize->add_section(
		'vlac_rest',
		array(
			'title' => __( 'Página Restaurantes (botones)', 'vlac-systems' ),
			'panel' => 'vlac_home',
		)
	);
	$rest_fields = array(
		'rest_cta1_txt' => array( __( 'Hero · Botón principal — texto', 'vlac-systems' ), 'Empezar ahora', 'text' ),
		'rest_cta1_url' => array( __( 'Hero · Botón principal — enlace (vacío = Contacto)', 'vlac-systems' ), '', 'url' ),
		'rest_cta2_txt' => array( __( 'Hero · Botón secundario — texto', 'vlac-systems' ), 'Ver Demostración', 'text' ),
		'rest_cta2_url' => array( __( 'Hero · Botón secundario — enlace', 'vlac-systems' ), '#', 'url' ),
		'rest_cta3_txt' => array( __( 'CTA final · Botón principal — texto', 'vlac-systems' ), 'Solicitar Demo Gratuita', 'text' ),
		'rest_cta3_url' => array( __( 'CTA final · Botón principal — enlace (vacío = Contacto)', 'vlac-systems' ), '', 'url' ),
		'rest_cta4_txt' => array( __( 'CTA final · Botón secundario — texto', 'vlac-systems' ), 'Hablar con un experto', 'text' ),
		'rest_cta4_url' => array( __( 'CTA final · Botón secundario — enlace (vacío = Contacto)', 'vlac-systems' ), '', 'url' ),
	);
	vlac_add_fields( $wp_customize, $rest_fields, 'vlac_rest' );

	/* ---------- Página Contacto ---------- */
	$wp_customize->add_section(
		'vlac_contact',
		array(
			'title' => __( 'Página Contacto', 'vlac-systems' ),
			'panel' => 'vlac_home',
		)
	);
	$contact_fields = array(
		'contact_kicker' => array( __( 'Etiqueta superior', 'vlac-systems' ), 'Contacto', 'text' ),
		'contact_lead'   => array( __( 'Texto introductorio', 'vlac-systems' ), 'Cuéntanos sobre tu negocio y un asesor te contactará para activar tu prueba gratis o resolver tus dudas.', 'textarea' ),
		'contact_phone'  => array( __( 'Teléfono (opcional)', 'vlac-systems' ), '', 'text' ),
		'contact_email'  => array( __( 'Correo (opcional)', 'vlac-systems' ), '', 'text' ),
		'contact_hours'  => array( __( 'Horario (opcional)', 'vlac-systems' ), '', 'text' ),
		'contact_aside_text' => array( __( 'Panel izquierdo · Texto extra (permite HTML, opcional)', 'vlac-systems' ), '', 'html' ),
	);
	vlac_add_fields( $wp_customize, $contact_fields, 'vlac_contact' );

	// Imagen opcional del panel izquierdo (selector de medios de WordPress).
	$wp_customize->add_setting(
		'contact_aside_image',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'contact_aside_image',
			array(
				'label'       => __( 'Panel izquierdo · Imagen (opcional)', 'vlac-systems' ),
				'description' => __( 'Se muestra bajo los datos de contacto.', 'vlac-systems' ),
				'section'     => 'vlac_contact',
			)
		)
	);

	/* ---------- Página Venta en Línea ---------- */
	$wp_customize->add_section(
		'vlac_vlo',
		array(
			'title' => __( 'Página Venta en Línea', 'vlac-systems' ),
			'panel' => 'vlac_home',
		)
	);
	$vlo_fields = array(
		'vlo_eyebrow'   => array( __( 'Etiqueta superior', 'vlac-systems' ), 'Venta en Línea', 'text' ),
		'vlo_title'     => array( __( 'Título (permite HTML con <span class="accent">)', 'vlac-systems' ), 'Tu <span class="accent">tienda en línea</span>, conectada a tu inventario', 'html' ),
		'vlo_sub'       => array( __( 'Subtítulo', 'vlac-systems' ), 'Publica tus productos con un clic desde el mismo sistema donde llevas el inventario. Tus clientes compran en línea y los pedidos entran directo a tu panel de ventas.', 'textarea' ),
		'vlo_cta_title' => array( __( 'CTA final · Título', 'vlac-systems' ), 'Abre tu tienda en línea esta semana', 'text' ),
		'vlo_cta_sub'   => array( __( 'CTA final · Subtítulo', 'vlac-systems' ), 'Si ya tienes tus productos en el sistema, publicarlos en línea es cuestión de marcarlos.', 'textarea' ),
	);
	vlac_add_fields( $wp_customize, $vlo_fields, 'vlac_vlo' );

	$vlo_images = array(
		'vlo_img_hero'       => __( 'Hero · Imagen destacada (opcional)', 'vlac-systems' ),
		'vlo_img_tablet'     => __( 'Hero · Tablet', 'vlac-systems' ),
		'vlo_img_phone'      => __( 'Hero · Teléfono', 'vlac-systems' ),
		'vlo_img_tienda'     => __( 'Portada de la tienda (banner)', 'vlac-systems' ),
		'vlo_img_categorias' => __( 'Publicación de categorías', 'vlac-systems' ),
		'vlo_img_productos'  => __( 'Publicación de productos', 'vlac-systems' ),
		'vlo_img_catalogo'   => __( 'Catálogo con filtros', 'vlac-systems' ),
		'vlo_img_config'     => __( 'Configuraciones de la tienda', 'vlac-systems' ),
		'vlo_img_destacados' => __( 'Productos más buscados', 'vlac-systems' ),
		'vlo_img_carrito'    => __( 'Carrito y resumen del pedido', 'vlac-systems' ),
	);
	vlac_add_image_fields( $wp_customize, $vlo_images, 'vlac_vlo' );

	/* ---------- Footer ---------- */
	$wp_customize->add_section(
		'vlac_footer',
		array(
			'title' => __( 'Pie de página', 'vlac-systems' ),
			'panel' => 'vlac_home',
		)
	);
	$footer_fields = array(
		'foot_desc'   => array( __( 'Descripción de la marca', 'vlac-systems' ), 'ERP personalizado con Facturación Electrónica FEL para negocios en Guatemala.', 'textarea' ),
		'foot_copy'   => array( __( 'Texto de copyright', 'vlac-systems' ), '© ' . date( 'Y' ) . ' Vlac Systems. Todos los derechos reservados.', 'text' ),
		'foot_legal'  => array( __( 'Texto legal derecho', 'vlac-systems' ), 'Guatemala · Certificado ante la SAT', 'text' ),
	);
	vlac_add_fields( $wp_customize, $footer_fields, 'vlac_footer' );

	/* ---------- Aplicación móvil (manifest) ---------- */
	// Se añade a «Identidad del sitio», junto al Icono del sitio, porque de ahí
	// salen también los iconos que usa Android al instalar la página.
	$app_fields = array(
		'app_short_name' => array( __( 'Nombre corto en el móvil (máx. 12 caracteres)', 'vlac-systems' ), 'Vlac Systems', 'text' ),
	);
	vlac_add_fields( $wp_customize, $app_fields, 'title_tagline' );

	$wp_customize->add_setting(
		'app_theme_color',
		array(
			'default'           => '#C1272D',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'app_theme_color',
			array(
				'label'       => __( 'Color de la barra en el móvil', 'vlac-systems' ),
				'description' => __( 'Tiñe la barra superior del navegador en Android y la ventana al instalar el sitio.', 'vlac-systems' ),
				'section'     => 'title_tagline',
			)
		)
	);
}
add_action( 'customize_register', 'vlac_customize_register' );

/**
 * Helper para registrar selectores de imagen (Biblioteca de medios de WordPress)
 * de forma compacta. Cada ajuste guarda la URL de la imagen elegida.
 */
function vlac_add_image_fields( $wp_customize, $images, $section ) {
	foreach ( $images as $id => $label ) {
		$wp_customize->add_setting(
			$id,
			array(
				'default'           => '',
				'sanitize_callback' => 'esc_url_raw',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				$id,
				array(
					'label'   => $label,
					'section' => $section,
				)
			)
		);
	}
}

/**
 * Helper para registrar selectores de video (Biblioteca de medios de WordPress)
 * de forma compacta. Cada ajuste guarda el ID del archivo de video elegido, así
 * los videos no viajan dentro del tema.
 */
function vlac_add_video_fields( $wp_customize, $videos, $section ) {
	foreach ( $videos as $id => $label ) {
		$wp_customize->add_setting(
			$id,
			array(
				'default'           => '',
				'sanitize_callback' => 'absint',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Media_Control(
				$wp_customize,
				$id,
				array(
					'label'     => $label,
					'section'   => $section,
					'mime_type' => 'video',
				)
			)
		);
	}
}

/**
 * Helper para registrar múltiples campos de texto/HTML de forma compacta.
 */
function vlac_add_fields( $wp_customize, $fields, $section ) {
	foreach ( $fields as $id => $meta ) {
		list( $label, $default, $type ) = $meta;

		$sanitize = 'sanitize_text_field';
		$control  = 'text';
		if ( 'url' === $type ) {
			$sanitize = 'esc_url_raw';
			$control  = 'url';
		} elseif ( 'textarea' === $type ) {
			$sanitize = 'sanitize_textarea_field';
			$control  = 'textarea';
		} elseif ( 'html' === $type ) {
			$sanitize = 'wp_kses_post';
			$control  = 'textarea';
		}

		$wp_customize->add_setting(
			$id,
			array(
				'default'           => $default,
				'sanitize_callback' => $sanitize,
			)
		);
		$wp_customize->add_control(
			$id,
			array(
				'label'   => $label,
				'section' => $section,
				'type'    => $control,
			)
		);
	}
}

/**
 * Devuelve la lista de negocios que confían en Vlac Systems.
 *
 * Lee el archivo JSON en /assets/data/negocios.json y devuelve únicamente
 * los negocios activos que tienen un logo válido (descarta URLs mal formadas
 * como las que apuntan a «.app//image/» sin identificador de negocio).
 *
 * El resultado se cachea durante la petición para no leer el disco dos veces.
 *
 * @return array Lista de negocios con claves «name» y «logoUrl».
 */
function vlac_get_businesses() {
	static $cache = null;
	if ( null !== $cache ) {
		return $cache;
	}

	$cache = array();
	$file  = get_template_directory() . '/assets/data/negocios.json';

	if ( ! is_readable( $file ) ) {
		return $cache;
	}

	$data = json_decode( file_get_contents( $file ), true ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
	if ( ! is_array( $data ) ) {
		return $cache;
	}

	foreach ( $data as $biz ) {
		if ( empty( $biz['active'] ) || empty( $biz['logoUrl'] ) ) {
			continue;
		}
		// Descarta logos mal formados (sin identificador de negocio en la ruta).
		if ( false !== strpos( $biz['logoUrl'], '.app//image/' ) ) {
			continue;
		}
		$type      = isset( $biz['type'] ) ? $biz['type'] : '';
		$cache[]   = array(
			'name'     => isset( $biz['name'] ) ? $biz['name'] : '',
			'logoUrl'  => $biz['logoUrl'],
			'type'     => $type,
			'category' => vlac_business_category( $type ),
		);
	}

	return $cache;
}

/**
 * Traduce el «type» crudo de un negocio a una categoría amigable en español.
 *
 * Varios tipos se agrupan en una misma categoría para mantener el filtro
 * de la página de clientes limpio y legible.
 *
 * @param string $type Tipo crudo (p. ej. «AUTO_SHOP»).
 * @return string Etiqueta de categoría (p. ej. «Automotriz»).
 */
function vlac_business_category( $type ) {
	$map = array(
		'AUTO_SHOP'        => 'Automotriz',
		'CAR_WASH'         => 'Automotriz',
		'BIKE_SHOP'        => 'Automotriz',
		'IT_SERVICE'       => 'Tecnología',
		'PHONE_SHOP'       => 'Tecnología',
		'VET'              => 'Veterinarias',
		'CLOTHES_SHOP'     => 'Ropa y moda',
		'SUPER_MARKET'     => 'Comercio',
		'MINI_SHOP'        => 'Comercio',
		'BOOK_SHOP'        => 'Comercio',
		'ICE_SCREAM_SHOP'  => 'Restaurantes',
		'RESTAURANT'       => 'Restaurantes',
		'MEDICAL_CLINIC'   => 'Salud',
		'PHARMACY'         => 'Salud',
		'GYM'              => 'Fitness',
	);

	return isset( $map[ $type ] ) ? $map[ $type ] : 'Otros';
}

/**
 * Fallback del menú principal cuando aún no se ha asignado uno.
 */
function vlac_primary_fallback() {
	echo '<div class="menu">';
	$items = array(
		'Aplicaciones' => '#',
		'Industrias'   => '#',
		'Precios'      => '#',
	);
	foreach ( $items as $label => $url ) {
		printf(
			'<div class="menu-item"><a class="menu-link" href="%s">%s</a></div>',
			esc_url( $url ),
			esc_html( $label )
		);
	}
	echo '</div>';
}

/* -------------------------------------------------------------------------
 * SEO — Sitemap XML (wp-sitemap.xml) e indexación
 * ---------------------------------------------------------------------- */

/**
 * Quita del sitemap el listado de autores (wp-sitemap-users-1.xml): no aporta
 * nada al SEO del sitio y expone los nombres de usuario del panel.
 *
 * @param WP_Sitemaps_Provider $provider Proveedor del sitemap.
 * @param string               $name     Nombre del proveedor.
 * @return WP_Sitemaps_Provider|false
 */
function vlac_sitemap_providers( $provider, $name ) {
	if ( 'users' === $name ) {
		return false;
	}

	return $provider;
}
add_filter( 'wp_sitemaps_add_provider', 'vlac_sitemap_providers', 10, 2 );

/**
 * Deja fuera del sitemap las taxonomías del blog (categorías y etiquetas),
 * que sólo generan URLs vacías o duplicadas.
 *
 * @param array $taxonomies Taxonomías incluidas.
 * @return array
 */
function vlac_sitemap_taxonomies( $taxonomies ) {
	unset( $taxonomies['category'], $taxonomies['post_tag'] );

	return $taxonomies;
}
add_filter( 'wp_sitemaps_taxonomies', 'vlac_sitemap_taxonomies' );

/**
 * Marca como «noindex» los archivos que no deben competir con las páginas
 * reales del sitio (autor, fechas, búsqueda, adjuntos y 404).
 *
 * @param array $robots Directivas robots.
 * @return array
 */
function vlac_robots_noindex( $robots ) {
	if ( is_author() || is_date() || is_search() || is_attachment() || is_404() ) {
		return wp_robots_no_robots( $robots );
	}

	return $robots;
}
add_filter( 'wp_robots', 'vlac_robots_noindex' );

/**
 * Icono de la pestaña (favicon) de respaldo.
 *
 * WordPress sólo imprime el icono cuando se ha subido uno en «Identidad del
 * sitio»; si no, el navegador muestra el logo genérico de WordPress. Aquí se
 * usan los iconos del tema mientras no haya icono propio.
 *
 * Los archivos de /assets/img/icons/ están generados a los tamaños exactos que
 * pide cada dispositivo, así que dan mejor resultado que reescalar el logo.
 */
function vlac_favicon_fallback() {
	if ( has_site_icon() ) {
		return; // El núcleo ya imprime las etiquetas del icono.
	}

	$icons = get_template_directory_uri() . '/assets/img/icons';

	printf( '<link rel="icon" href="%s" sizes="16x16 32x32">' . "\n", esc_url( $icons . '/favicon.ico' ) );
	printf( '<link rel="icon" type="image/png" sizes="32x32" href="%s">' . "\n", esc_url( $icons . '/favicon-32x32.png' ) );
	printf( '<link rel="icon" type="image/png" sizes="16x16" href="%s">' . "\n", esc_url( $icons . '/favicon-16x16.png' ) );
	printf( '<link rel="apple-touch-icon" sizes="180x180" href="%s">' . "\n", esc_url( $icons . '/apple-touch-icon.png' ) );
}
add_action( 'wp_head', 'vlac_favicon_fallback', 5 );
add_action( 'admin_head', 'vlac_favicon_fallback', 5 );

/**
 * Manifiesto de aplicación web (Android / Chrome).
 *
 * WordPress no genera ningún «web app manifest», así que el tema lo sirve.
 * Se entrega desde PHP —y no como archivo estático— para que respete el
 * nombre del sitio, el icono elegido en «Identidad del sitio» y la URL real
 * de la instalación, sin necesidad de tocar código si algo de eso cambia.
 *
 * Se usa una variable de consulta en lugar de una regla de reescritura para
 * no depender de un vaciado de enlaces permanentes al activar el tema.
 */
function vlac_manifest_query_var( $vars ) {
	$vars[] = 'vlac_manifest';
	return $vars;
}
add_filter( 'query_vars', 'vlac_manifest_query_var' );

/**
 * URL del manifiesto.
 */
function vlac_manifest_url() {
	return add_query_arg( 'vlac_manifest', '1', home_url( '/' ) );
}

/**
 * Iconos de la aplicación: los del Personalizador si hay «Icono del sitio»,
 * y si no los que trae el tema.
 */
function vlac_app_icon( $size ) {
	if ( has_site_icon() ) {
		return get_site_icon_url( $size );
	}

	$file = ( 512 === $size ) ? 'android-chrome-512x512.png' : 'android-chrome-192x192.png';

	return get_template_directory_uri() . '/assets/img/icons/' . $file;
}

/**
 * Imprime el manifiesto en JSON cuando se pide su URL.
 */
function vlac_render_manifest() {
	if ( ! get_query_var( 'vlac_manifest' ) ) {
		return;
	}

	$manifest = array(
		'id'               => home_url( '/' ),
		'name'             => get_bloginfo( 'name' ),
		'short_name'       => vlac_opt( 'app_short_name', 'Vlac Systems' ),
		'description'      => get_bloginfo( 'description' ),
		'lang'             => get_bloginfo( 'language' ),
		'dir'              => is_rtl() ? 'rtl' : 'ltr',
		'start_url'        => home_url( '/' ),
		'scope'            => home_url( '/' ),
		'display'          => 'standalone',
		'theme_color'      => vlac_opt( 'app_theme_color', '#C1272D' ),
		'background_color' => '#FFFFFF',
		'icons'            => array(
			array(
				'src'   => vlac_app_icon( 192 ),
				'sizes' => '192x192',
				'type'  => 'image/png',
			),
			array(
				'src'   => vlac_app_icon( 512 ),
				'sizes' => '512x512',
				'type'  => 'image/png',
			),
		),
	);

	header( 'Content-Type: application/manifest+json; charset=' . get_bloginfo( 'charset' ) );
	echo wp_json_encode( $manifest, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
	exit;
}
add_action( 'template_redirect', 'vlac_render_manifest', 0 );

/**
 * Etiquetas del manifiesto en la cabecera.
 */
function vlac_manifest_link() {
	printf( '<link rel="manifest" href="%s">' . "\n", esc_url( vlac_manifest_url() ) );
	printf( '<meta name="theme-color" content="%s">' . "\n", esc_attr( vlac_opt( 'app_theme_color', '#C1272D' ) ) );
}
add_action( 'wp_head', 'vlac_manifest_link', 6 );
