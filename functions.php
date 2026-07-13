<?php
/**
 * Ciber Vlac Systems — funciones del tema
 *
 * @package Vlac_Systems
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // No acceso directo.
}

if ( ! defined( 'VLAC_VERSION' ) ) {
	define( 'VLAC_VERSION', '1.2.0' );
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
 * Se usa como destino por defecto de los botones «Prueba gratis»,
 * «Ayuda» y «Hablar con un asesor». Prioridad:
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
		'foot_copy'   => array( __( 'Texto de copyright', 'vlac-systems' ), '© ' . date( 'Y' ) . ' Ciber Vlac Systems S.A. Todos los derechos reservados.', 'text' ),
		'foot_legal'  => array( __( 'Texto legal derecho', 'vlac-systems' ), 'Guatemala · Certificado ante la SAT', 'text' ),
	);
	vlac_add_fields( $wp_customize, $footer_fields, 'vlac_footer' );
}
add_action( 'customize_register', 'vlac_customize_register' );

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
		'Ayuda'        => '#',
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
