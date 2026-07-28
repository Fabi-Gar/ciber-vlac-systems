<?php
/**
 * Template Name: Talleres
 *
 * Página de rubro para talleres mecánicos, de enderezado y pintura, de
 * electrónica o de cualquier servicio que reciba, repare y entregue. Recorre
 * el módulo de órdenes de servicio del sistema: la orden con su código y su
 * cliente, los estados desde la cotización hasta el pago, la plantilla con
 * los campos que cada taller define, los responsables con su comisión, el
 * anticipo, los repuestos y la mano de obra, las fotos del ingreso, la nota
 * interna y la que ve el cliente, y los formatos de impresión y entrega.
 *
 * Se aplica automáticamente a la página con slug «talleres»
 * (el menú del tema ya apunta a /industrias/talleres/), o puede asignarse
 * a mano desde Atributos de página → Plantilla.
 *
 * IMÁGENES (guárdalas en /assets/img/ con estos nombres exactos, o mejor
 * elígelas desde el Personalizador):
 *   tal-hero.png      → orden de servicio abierta (va en el hero)
 *   tal-lista.png     → listado de órdenes con sus estados
 *   tal-plantilla.png → configuración de la plantilla y sus campos
 *   tal-cuenta.png    → cobro con repuestos, mano de obra y anticipos
 *   tal-impresion.png → comprobante impreso o de entrega
 *
 * VIDEOS (guárdalos en /assets/video/):
 *   orden-taller.mp4  → crear la orden de servicio y confirmarla
 * Mientras no exista, se muestra un marcador en su lugar.
 *
 * Los textos se editan en Apariencia → Personalizar → Contenido del sitio →
 * «Página Talleres».
 *
 * @package Vlac_Systems
 */

get_header();

$img     = get_template_directory_uri() . '/assets/img';
$img_dir = get_template_directory() . '/assets/img/';
$vid_url = get_template_directory_uri() . '/assets/video';
$vid_dir = get_template_directory() . '/assets/video/';

// Renderiza una captura enmarcada. Prioridad de la imagen:
//   1) La elegida en el Personalizador (Biblioteca de medios de WordPress).
//   2) El archivo en /assets/img/.
//   3) Un marcador con las instrucciones.
$tal_shot = function ( $file, $opt_key = '', $alt = '' ) use ( $img, $img_dir ) {
	$url    = $opt_key ? vlac_opt( $opt_key ) : '';
	$exists = file_exists( $img_dir . $file );
	echo '<div class="tal-frame"><div class="bar"><i></i><i></i><i></i></div>';
	if ( $url ) {
		printf( '<img src="%s" alt="%s" loading="lazy" />', esc_url( $url ), esc_attr( $alt ) );
	} elseif ( $exists ) {
		printf( '<img src="%s" alt="%s" loading="lazy" />', esc_url( $img . '/' . $file ), esc_attr( $alt ) );
	} else {
		printf( '<div class="tal-ph tal-ph-img">Elige la imagen en <b>Personalizar → Página Talleres</b><br>o sube el archivo <code>assets/img/%s</code></div>', esc_html( $file ) );
	}
	echo '</div>';
};

// Renderiza un video autoplay. Prioridad:
//   1) El elegido en el Personalizador (Biblioteca de medios de WordPress).
//   2) El archivo en /assets/video/.
//   3) Un marcador con el nombre esperado.
$tal_video = function ( $base, $title, $sub, $opt_key = '' ) use ( $vid_dir, $vid_url ) {
	$wp_url  = '';
	$wp_type = '';
	if ( $opt_key ) {
		$vid_id = vlac_opt( $opt_key );
		if ( $vid_id ) {
			$wp_url  = wp_get_attachment_url( $vid_id );
			$wp_type = get_post_mime_type( $vid_id );
		}
	}
	$has_mp4  = file_exists( $vid_dir . $base . '.mp4' );
	$has_webm = file_exists( $vid_dir . $base . '.webm' );
	echo '<div class="tal-frame"><div class="bar"><i></i><i></i><i></i></div>';
	if ( $wp_url ) {
		echo '<video autoplay muted loop playsinline preload="metadata">';
		printf( '<source src="%s"%s />', esc_url( $wp_url ), $wp_type ? ' type="' . esc_attr( $wp_type ) . '"' : '' );
		echo '</video>';
	} elseif ( $has_mp4 || $has_webm ) {
		echo '<video autoplay muted loop playsinline preload="metadata">';
		if ( $has_webm ) {
			printf( '<source src="%s" type="video/webm" />', esc_url( $vid_url . '/' . $base . '.webm' ) );
		}
		if ( $has_mp4 ) {
			printf( '<source src="%s" type="video/mp4" />', esc_url( $vid_url . '/' . $base . '.mp4' ) );
		}
		echo '</video>';
	} else {
		echo '<div class="tal-ph">';
		echo '<svg viewBox="0 0 24 24" fill="none"><path d="M4 5h16v14H4zM10 9l6 3-6 3V9z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>';
		printf( '<b>%s</b><span>%s</span>', esc_html( $title ), esc_html( $sub ) );
		printf( '<code>assets/video/%s.mp4</code>', esc_html( $base ) );
		echo '</div>';
	}
	echo '</div>';
};
?>

<style>
	/* Estilos de la página de Talleres (ámbito local). */
	#tal-page{--tal-green:#2e9e5b;--tal-slate:#5A6070;}

	/* HERO */
	#tal-page .tal-hero{position:relative;overflow:hidden;}
	#tal-page .tal-hero::before{content:"";position:absolute;inset:0;z-index:0;background:radial-gradient(720px 400px at 86% 2%,rgba(193,39,45,.08),transparent 62%),linear-gradient(180deg,#fff,var(--bg-alt));}
	#tal-page .tal-hero .hero-grid{position:relative;z-index:1;display:grid;grid-template-columns:1fr 1.2fr;gap:50px;align-items:center;padding:64px 0 82px;}
	#tal-page .tal-hero h1{font-size:clamp(32px,4.4vw,50px);font-weight:800;}
	#tal-page .tal-hero .lead{color:var(--muted);font-size:18px;margin:20px 0 0;max-width:510px;}
	#tal-page .tal-hero .hero-cta{display:flex;gap:14px;flex-wrap:wrap;margin-top:28px;}
	#tal-page .tal-hero .hero-note{display:flex;align-items:center;gap:8px;font-size:13.5px;color:var(--muted);margin-top:22px;}
	#tal-page .tal-hero .hero-note svg{width:16px;height:16px;color:var(--tal-green);flex-shrink:0;}

	/* MARCO (estilo navegador) para capturas y videos */
	#tal-page .tal-frame{background:#fff;border:1px solid #d9d9de;border-radius:14px;overflow:hidden;box-shadow:var(--shadow-md);}
	#tal-page .tal-hero .tal-frame{box-shadow:var(--shadow-lg);}
	#tal-page .tal-frame .bar{display:flex;align-items:center;gap:6px;padding:9px 12px;background:#f3f3f5;border-bottom:1px solid #e6e6ea;}
	#tal-page .tal-frame .bar i{width:10px;height:10px;border-radius:50%;background:#d6d6dc;display:block;}
	#tal-page .tal-frame video,#tal-page .tal-frame img{width:100%;height:auto;display:block;background:#000;}

	/* Marcador (placeholder) */
	#tal-page .tal-ph{aspect-ratio:16/10;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:10px;text-align:center;background:var(--bg-alt);color:var(--muted);padding:24px;font-size:14px;}
	#tal-page .tal-ph svg{width:46px;height:46px;color:#c9c9d0;}
	#tal-page .tal-ph b{font-family:'Manrope';font-weight:700;color:var(--ink-strong);font-size:15px;}
	#tal-page .tal-ph code{font-size:13px;color:var(--red-dark);background:var(--red-soft);padding:4px 10px;border-radius:6px;}
	#tal-page .tal-ph-img{aspect-ratio:auto;padding:52px 20px;}

	/* PISTA DE ESTADOS — barra segmentada de la orden de servicio */
	#tal-page .tal-track{display:grid;grid-template-columns:repeat(6,1fr);gap:8px;max-width:1000px;margin:0 auto;}
	#tal-page .tal-seg span{display:block;height:10px;border-radius:999px;}
	#tal-page .tal-seg b{display:block;font-family:'Manrope';font-weight:800;font-size:14px;color:var(--ink-strong);margin-top:14px;}
	#tal-page .tal-seg em{display:block;font-style:normal;color:var(--muted);font-size:13px;margin-top:5px;}
	#tal-page .tal-seg.s1 span{background:#f6e0e0;}
	#tal-page .tal-seg.s2 span{background:#eecbcc;}
	#tal-page .tal-seg.s3 span{background:#e3adaf;}
	#tal-page .tal-seg.s4 span{background:#d68689;}
	#tal-page .tal-seg.s5 span{background:#c95a5f;}
	#tal-page .tal-seg.s6 span{background:var(--red);}
	#tal-page .tal-notes{display:grid;grid-template-columns:repeat(3,1fr);gap:22px;margin-top:56px;}
	#tal-page .tal-note{background:#fff;border:1px solid var(--line);border-radius:var(--radius);padding:22px 24px;}
	#tal-page .tal-note b{display:block;font-family:'Manrope';font-weight:700;font-size:16px;color:var(--ink-strong);margin-bottom:7px;}
	#tal-page .tal-note p{color:var(--muted);font-size:14.5px;}
	#tal-page .tal-cancel{margin-top:26px;text-align:center;color:var(--muted);font-size:14px;}
	#tal-page .tal-cancel b{font-family:'Manrope';color:var(--ink-strong);}

	/* SPLIT (el medio siempre en la columna ancha) */
	#tal-page .tal-split{display:grid;grid-template-columns:1fr 1.3fr;gap:46px;align-items:center;}
	#tal-page .tal-split.rev{grid-template-columns:1.3fr 1fr;}
	#tal-page .tal-split.rev .tal-split-media{order:-1;}
	#tal-page .tal-split .ic{width:52px;height:52px;border-radius:13px;background:var(--red-soft);display:grid;place-items:center;margin-bottom:18px;}
	#tal-page .tal-split .ic svg{width:26px;height:26px;color:var(--red);}
	#tal-page .tal-split h3{font-size:clamp(20px,2.4vw,26px);font-weight:800;}
	#tal-page .tal-split p.txt{color:var(--muted);font-size:16.5px;margin-top:14px;max-width:440px;}
	#tal-page .tal-list{list-style:none;margin:18px 0 0;padding:0;display:flex;flex-direction:column;gap:10px;max-width:440px;}
	#tal-page .tal-list li{display:flex;align-items:flex-start;gap:10px;color:var(--ink-strong);font-size:15px;}
	#tal-page .tal-list li svg{width:19px;height:19px;color:var(--tal-green);flex-shrink:0;margin-top:1px;}

	/* CHIPS de campos y de tipos de pregunta */
	#tal-page .tal-chips{display:flex;flex-wrap:wrap;gap:9px;margin-top:20px;max-width:470px;}
	#tal-page .tal-chip{display:inline-flex;align-items:center;gap:7px;background:#fff;border:1px solid var(--line);border-radius:999px;padding:7px 14px;font-size:13.5px;font-family:'Manrope';font-weight:700;color:var(--ink-strong);box-shadow:var(--shadow-sm);}
	#tal-page .tal-chip i{width:7px;height:7px;border-radius:50%;background:var(--red);display:block;}
	#tal-page .tal-types{margin-top:18px;color:var(--muted);font-size:14px;max-width:470px;}
	#tal-page .tal-types b{font-family:'Manrope';color:var(--ink-strong);}

	/* RESPONSABLES */
	#tal-page .tal-crew{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;}
	#tal-page .tal-member{background:#fff;border:1px solid var(--line);border-radius:var(--radius);padding:26px 24px;transition:transform .18s ease,box-shadow .18s ease,border-color .18s ease;}
	#tal-page .tal-member:hover{transform:translateY(-4px);box-shadow:var(--shadow-md);border-color:#e0d0d0;}
	#tal-page .tal-member .tag{display:inline-block;background:var(--red-soft);color:var(--red-dark);font-family:'Manrope';font-weight:700;font-size:11.5px;letter-spacing:.05em;text-transform:uppercase;padding:5px 11px;border-radius:999px;}
	#tal-page .tal-member b{display:block;font-family:'Manrope';font-weight:800;font-size:17.5px;color:var(--ink-strong);margin:14px 0 7px;}
	#tal-page .tal-member p{color:var(--muted);font-size:14.5px;}

	/* EN ACCIÓN — un solo medio grande centrado */
	#tal-page .tal-stage{max-width:940px;margin:0 auto;}
	#tal-page .tal-stage .cap{margin-top:16px;text-align:center;}
	#tal-page .tal-stage .cap b{display:block;font-family:'Manrope';font-weight:700;font-size:16px;color:var(--ink-strong);}
	#tal-page .tal-stage .cap span{color:var(--muted);font-size:14px;}

	/* CAPACIDADES — lista compacta en tres columnas */
	#tal-page .tal-caps{display:grid;grid-template-columns:repeat(3,1fr);gap:4px 40px;}
	#tal-page .tal-cap{display:flex;align-items:flex-start;gap:11px;padding:15px 0;border-bottom:1px solid var(--line);}
	#tal-page .tal-cap i{width:8px;height:8px;border-radius:50%;background:var(--red);flex-shrink:0;margin-top:7px;}
	#tal-page .tal-cap b{display:block;font-family:'Manrope';font-weight:700;font-size:15px;color:var(--ink-strong);}
	#tal-page .tal-cap p{color:var(--muted);font-size:13.5px;margin-top:2px;}

	@media (max-width:980px){
		#tal-page .tal-track{grid-template-columns:repeat(3,1fr);gap:14px 10px;}
		#tal-page .tal-notes{grid-template-columns:1fr;}
		#tal-page .tal-crew{grid-template-columns:1fr;}
		#tal-page .tal-caps{grid-template-columns:repeat(2,1fr);}
	}
	@media (max-width:900px){
		#tal-page .tal-hero .hero-grid{grid-template-columns:1fr;gap:32px;padding:50px 0 58px;}
		#tal-page .tal-split,
		#tal-page .tal-split.rev{grid-template-columns:1fr;gap:24px;}
		#tal-page .tal-split.rev .tal-split-media{order:0;}
	}
	@media (max-width:560px){
		#tal-page .tal-track{grid-template-columns:repeat(2,1fr);}
		#tal-page .tal-caps{grid-template-columns:1fr;}
	}
</style>

<div id="tal-page">

	<!-- HERO -->
	<section class="tal-hero">
		<div class="wrap">
			<div class="hero-grid">
				<div class="hero-copy">
					<span class="eyebrow"><span class="dot"></span> <?php echo esc_html( vlac_opt( 'tal_eyebrow', 'Talleres' ) ); ?></span>
					<h1><?php echo wp_kses_post( vlac_opt( 'tal_title', 'El sistema para tu <span class="accent">taller</span>' ) ); ?></h1>
					<p class="lead"><?php echo esc_html( vlac_opt( 'tal_sub', 'Levanta la orden de servicio con los datos que tu taller pide, cotiza el trabajo, controla en qué va cada unidad y entrega con su comprobante, sus repuestos y su factura.' ) ); ?></p>
					<div class="hero-cta">
						<a class="btn btn-red btn-lg" href="<?php echo esc_url( vlac_cta_url( 'hero_cta1_url' ) ); ?>"><?php echo esc_html( vlac_opt( 'hero_cta1_txt', 'Prueba gratis' ) ); ?></a>
						<a class="btn btn-ghost" href="<?php echo esc_url( vlac_opt( 'hero_cta2_url', '#' ) ); ?>"><?php echo esc_html( vlac_opt( 'hero_cta2_txt', 'Ver una demo' ) ); ?></a>
					</div>
					<div class="hero-note">
						<svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
						Órdenes de servicio · Anticipos · Repuestos · Comisiones · Facturación
					</div>
				</div>

				<div class="hero-media"><?php $tal_shot( 'tal-hero.png', 'tal_img_hero', 'Orden de servicio' ); ?></div>
			</div>
		</div>
	</section>

	<!-- ESTADOS DE LA ORDEN -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">El recorrido del trabajo</div>
				<h2>De la cotización al trabajo pagado</h2>
				<p>Cada orden avanza por sus etapas, así que en cualquier momento sabes qué unidades están esperando, cuáles están en el taller y cuáles ya se entregaron.</p>
			</div>

			<div class="tal-track">
				<div class="tal-seg s1">
					<span></span>
					<b>Cotización</b>
					<em>Aún no se confirma</em>
				</div>
				<div class="tal-seg s2">
					<span></span>
					<b>Confirmado</b>
					<em>El cliente aprobó</em>
				</div>
				<div class="tal-seg s3">
					<span></span>
					<b>Iniciado</b>
					<em>Empezó el trabajo</em>
				</div>
				<div class="tal-seg s4">
					<span></span>
					<b>En preparación</b>
					<em>Listo casi para entregar</em>
				</div>
				<div class="tal-seg s5">
					<span></span>
					<b>Finalizado</b>
					<em>Trabajo terminado</em>
				</div>
				<div class="tal-seg s6">
					<span></span>
					<b>Pagado</b>
					<em>Cobrado y facturado</em>
				</div>
			</div>

			<div class="tal-notes">
				<div class="tal-note">
					<b>La cotización se vuelve orden</b>
					<p>Presupuestas el trabajo y, cuando el cliente aprueba, la misma cotización se confirma y genera la orden con sus repuestos y su mano de obra.</p>
				</div>
				<div class="tal-note">
					<b>Sabes dónde está cada unidad</b>
					<p>Filtras por estado y ves de un vistazo qué está iniciado, qué está en preparación y qué ya se terminó, sin preguntarle a nadie.</p>
				</div>
				<div class="tal-note">
					<b>Se entrega y se cobra</b>
					<p>Al finalizar imprimes el comprobante de entrega, cobras el saldo contra el anticipo y emites la factura.</p>
				</div>
			</div>

			<p class="tal-cancel">¿Se cayó el trabajo? La orden se marca como <b>anulada</b> y queda registrada, no se borra.</p>
		</div>
	</section>

	<!-- LA ORDEN DE SERVICIO -->
	<section class="section">
		<div class="wrap">
			<div class="tal-split">
				<div class="tal-split-text">
					<div class="ic"><svg viewBox="0 0 24 24" fill="none"><path d="M6 3h9l4 4v14H6z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M9 12h7M9 16h5M9 8h4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
					<h3>La orden de servicio es el centro de todo</h3>
					<p class="txt">Cada trabajo tiene su orden con número propio, su cliente, la fecha del servicio y su estado. Ahí van los datos de la unidad, los repuestos, la mano de obra, las fotos del ingreso, las notas y quién trabajó en ella.</p>
					<ul class="tal-list">
						<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Correlativo propio y cliente asignado</li>
						<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Fotos y archivos del estado de ingreso</li>
						<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Nota interna del taller y nota que sí ve el cliente</li>
						<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Historial de cambios de cada orden</li>
					</ul>
				</div>
				<div class="tal-split-media"><?php $tal_shot( 'tal-lista.png', 'tal_img_lista', 'Listado de órdenes por estado' ); ?></div>
			</div>
		</div>
	</section>

	<!-- PLANTILLA CONFIGURABLE -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="tal-split rev">
				<div class="tal-split-text">
					<div class="ic"><svg viewBox="0 0 24 24" fill="none"><rect x="3" y="4" width="18" height="16" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="M7 9h6M7 13h10M7 17h4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
					<h3>La orden se adapta a lo que tu taller anota</h3>
					<p class="txt">Un taller mecánico no anota lo mismo que uno de electrónica. Nos dices qué datos necesitas y dejamos la plantilla lista con hasta veinte campos, marcando cuáles son obligatorios y cuáles se autocompletan. Tu personal solo llena la orden ya armada.</p>
					<div class="tal-chips">
						<span class="tal-chip"><i></i>Placa</span>
						<span class="tal-chip"><i></i>Marca</span>
						<span class="tal-chip"><i></i>Modelo</span>
						<span class="tal-chip"><i></i>Año</span>
						<span class="tal-chip"><i></i>Kilometraje</span>
						<span class="tal-chip"><i></i>Combustible</span>
						<span class="tal-chip"><i></i>Daños al ingreso</span>
						<span class="tal-chip"><i></i>Accesorios</span>
					</div>
					<p class="tal-types"><b>Tipos de campo:</b> texto, texto con formato, número, fecha, sí/no, opción única, opción múltiple y tabla. ¿Cambió lo que necesitas anotar? Nos lo pides y ajustamos la plantilla.</p>
				</div>
				<div class="tal-split-media"><?php $tal_shot( 'tal-plantilla.png', 'tal_img_plantilla', 'Plantilla de la orden de servicio' ); ?></div>
			</div>
		</div>
	</section>

	<!-- RESPONSABLES Y COMISIONES -->
	<section class="section">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Quién hizo el trabajo</div>
				<h2>Hasta tres responsables por orden, con su comisión</h2>
				<p>Asignas a quienes participaron en el trabajo y el sistema calcula lo que le toca a cada uno. Los títulos y los roles los defines tú.</p>
			</div>

			<div class="tal-crew">
				<div class="tal-member">
					<span class="tag">Responsable 1</span>
					<b>El que recibe</b>
					<p>Normalmente el asesor que levanta la orden y le explica el trabajo al cliente. Puede llevar su propio porcentaje.</p>
				</div>
				<div class="tal-member">
					<span class="tag">Responsable 2</span>
					<b>El que repara</b>
					<p>El mecánico o técnico a cargo de la unidad, con la comisión que corresponda a su trabajo.</p>
				</div>
				<div class="tal-member">
					<span class="tag">Responsable 3</span>
					<b>El que apoya</b>
					<p>Ayudante, pintor o quien más participe. Cada rol se limita a los usuarios que tú permitas.</p>
				</div>
			</div>
		</div>
	</section>

	<!-- ANTICIPOS, REPUESTOS Y COBRO -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="tal-split">
				<div class="tal-split-text">
					<div class="ic"><svg viewBox="0 0 24 24" fill="none"><path d="M3 5h2l2.4 10.2a2 2 0 002 1.6h7.6a2 2 0 002-1.6L21 8H6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><circle cx="10" cy="20" r="1.4" stroke="currentColor" stroke-width="1.5"/><circle cx="17" cy="20" r="1.4" stroke="currentColor" stroke-width="1.5"/></svg></div>
					<h3>Anticipos, repuestos y la cuenta final</h3>
					<p class="txt">Recibes el anticipo cuando entra la unidad y lo vas descontando del total. Los repuestos que le pones salen de tu inventario y la mano de obra se cobra en la misma cuenta, con la factura al entregar.</p>
					<ul class="tal-list">
						<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Anticipo registrado y saldo siempre a la vista</li>
						<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Repuestos descontados del inventario</li>
						<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Mano de obra y servicios en la misma orden</li>
						<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Total pagado y total pendiente por cliente</li>
					</ul>
				</div>
				<div class="tal-split-media"><?php $tal_shot( 'tal-cuenta.png', 'tal_img_cuenta', 'Cobro de la orden de servicio' ); ?></div>
			</div>
		</div>
	</section>

	<!-- EN ACCIÓN -->
	<section class="section">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">En acción</div>
				<h2>Así se levanta una orden de servicio</h2>
				<p>Desde que entra la unidad hasta que la orden queda confirmada.</p>
			</div>

			<div class="tal-stage">
				<?php $tal_video( 'orden-taller', 'Video: crear una orden de servicio', 'Cliente, campos de la unidad y confirmación', 'tal_video_orden' ); ?>
				<div class="cap">
					<b>Una orden de principio a fin</b>
					<span>Eliges al cliente, llenas los campos de tu plantilla, agregas repuestos y confirmas</span>
				</div>
			</div>
		</div>
	</section>

	<!-- IMPRESIÓN Y ENTREGA -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="tal-split rev">
				<div class="tal-split-text">
					<div class="ic"><svg viewBox="0 0 24 24" fill="none"><path d="M6 9V3h12v6M6 18H4a1 1 0 01-1-1v-5a2 2 0 012-2h14a2 2 0 012 2v5a1 1 0 01-1 1h-2" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><path d="M7 15h10v6H7z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg></div>
					<h3>El papel que entregas, como tú lo quieres</h3>
					<p class="txt">Imprime la orden en hoja completa, en media carta o en impresora térmica, y saca el comprobante de entrega cuando el cliente recoge. El pie de página, las notas y el espacio de firma los configuras una vez y salen siempre igual.</p>
					<ul class="tal-list">
						<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Carta completa, media carta o térmica</li>
						<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Comprobante de entrega para el cliente</li>
						<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Notas al pie y espacio de firma configurables</li>
						<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Con la foto del producto si te sirve mostrarla</li>
					</ul>
				</div>
				<div class="tal-split-media"><?php $tal_shot( 'tal-impresion.png', 'tal_img_impresion', 'Comprobante impreso' ); ?></div>
			</div>
		</div>
	</section>

	<!-- CAPACIDADES -->
	<section class="section">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Todo lo que incluye</div>
				<h2>Pensado para el día a día de tu taller</h2>
			</div>

			<div class="tal-caps">
				<div class="tal-cap"><i></i><div><b>Órdenes de servicio</b><p>Con su correlativo, su cliente y su fecha.</p></div></div>
				<div class="tal-cap"><i></i><div><b>Estados del trabajo</b><p>De la cotización al pago, filtrables.</p></div></div>
				<div class="tal-cap"><i></i><div><b>Plantilla a la medida</b><p>Hasta veinte campos según tu taller.</p></div></div>
				<div class="tal-cap"><i></i><div><b>Responsables</b><p>Hasta tres por orden, con su comisión.</p></div></div>
				<div class="tal-cap"><i></i><div><b>Anticipos</b><p>Registrados y descontados del total.</p></div></div>
				<div class="tal-cap"><i></i><div><b>Repuestos</b><p>Salen del inventario al usarlos.</p></div></div>
				<div class="tal-cap"><i></i><div><b>Fotos y archivos</b><p>El estado de ingreso, documentado.</p></div></div>
				<div class="tal-cap"><i></i><div><b>Agenda del servicio</b><p>La fecha en que entra cada trabajo.</p></div></div>
				<div class="tal-cap"><i></i><div><b>Cotizaciones</b><p>Que se vuelven orden al aprobarse.</p></div></div>
				<div class="tal-cap"><i></i><div><b>Facturación electrónica</b><p>La cuenta del cliente, al instante.</p></div></div>
				<div class="tal-cap"><i></i><div><b>Varias sucursales</b><p>Cada taller con sus órdenes y su caja.</p></div></div>
				<div class="tal-cap"><i></i><div><b>Informes</b><p>Trabajos, ingresos y pendientes por período.</p></div></div>
			</div>
		</div>
	</section>

	<!-- CTA -->
	<section class="section">
		<div class="wrap">
			<div class="cta-strip">
				<h2><?php echo esc_html( vlac_opt( 'tal_cta_title', 'Ordena tu taller desde la primera cotización' ) ); ?></h2>
				<p><?php echo esc_html( vlac_opt( 'tal_cta_sub', 'Órdenes de servicio, anticipos, repuestos, comisiones y facturación en un solo sistema conectado.' ) ); ?></p>
				<a class="btn btn-red btn-lg" href="<?php echo esc_url( vlac_cta_url( 'cta_btn_url' ) ); ?>"><?php echo esc_html( vlac_opt( 'hero_cta1_txt', 'Prueba gratis' ) ); ?></a>
			</div>
		</div>
	</section>

</div>

<?php
get_footer();
