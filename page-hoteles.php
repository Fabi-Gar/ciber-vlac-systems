<?php
/**
 * Template Name: Hoteles y Posadas
 *
 * Página de rubro para hoteles, posadas y hospedajes. Recorre el módulo de
 * hotel del sistema: habitaciones con sus camas y estados, categorías con
 * planes de tarifa por cantidad de huéspedes, precios por temporada o por
 * días de la semana, el mapa de disponibilidad, la reserva con sus estancias,
 * el check-in y check-out (incluso parciales, cama por cama), los consumos
 * cargados a la habitación y la factura al momento de la salida.
 *
 * Se aplica automáticamente a la página con slug «hoteles»
 * (el menú del tema ya apunta a /industrias/hoteles/), o puede asignarse
 * a mano desde Atributos de página → Plantilla.
 *
 * IMÁGENES (guárdalas en /assets/img/ con estos nombres exactos, o mejor
 * elígelas desde el Personalizador):
 *   hot-hero.png        → foto del hotel/posada para el hero (opcional)
 *   hot-mapa.png        → mapa de disponibilidad (habitaciones × días)
 *   hot-habitacion.png  → ficha de la habitación (código, categoría, camas)
 *   hot-categorias.png  → categorías con planes de tarifa
 *   hot-precios.png     → precios por temporada / días de la semana
 *   hot-reserva.png     → detalle de la reserva con sus estancias
 *   hot-informes.png    → informe de reservas / mapa exportado
 *
 * VIDEOS (guárdalos en /assets/video/):
 *   reserva-hotel.mp4   → crear la reserva desde el mapa de disponibilidad
 *   checkin-hotel.mp4   → check-in con asignación de camas
 *   checkout-hotel.mp4  → consumos, check-out y factura
 * Mientras no existan, se muestra un marcador en su lugar.
 *
 * Los textos se editan en Apariencia → Personalizar → Contenido del sitio →
 * «Página Hoteles y Posadas».
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
$hot_shot = function ( $file, $caption, $opt_key = '' ) use ( $img, $img_dir ) {
	$url    = $opt_key ? vlac_opt( $opt_key ) : '';
	$exists = file_exists( $img_dir . $file );
	echo '<figure class="hot-shot"><div class="hot-frame"><div class="bar"><i></i><i></i><i></i></div>';
	if ( $url ) {
		printf( '<img src="%s" alt="%s" loading="lazy" />', esc_url( $url ), esc_attr( $caption ) );
	} elseif ( $exists ) {
		printf( '<img src="%s" alt="%s" loading="lazy" />', esc_url( $img . '/' . $file ), esc_attr( $caption ) );
	} else {
		printf( '<div class="hot-ph hot-ph-img">Elige la imagen en <b>Personalizar → Página Hoteles y Posadas</b><br>o sube el archivo <code>assets/img/%s</code></div>', esc_html( $file ) );
	}
	echo '</div>';
	if ( $caption ) {
		printf( '<figcaption>%s</figcaption>', esc_html( $caption ) );
	}
	echo '</figure>';
};

// Renderiza un video autoplay. Prioridad:
//   1) El elegido en el Personalizador (Biblioteca de medios de WordPress).
//   2) El archivo en /assets/video/.
//   3) Un marcador con el nombre esperado.
$hot_video = function ( $base, $title, $sub, $opt_key = '' ) use ( $vid_dir, $vid_url ) {
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
	echo '<div class="hot-frame"><div class="bar"><i></i><i></i><i></i></div>';
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
		echo '<div class="hot-ph">';
		echo '<svg viewBox="0 0 24 24" fill="none"><path d="M4 5h16v14H4zM10 9l6 3-6 3V9z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>';
		printf( '<b>%s</b><span>%s</span>', esc_html( $title ), esc_html( $sub ) );
		printf( '<code>assets/video/%s.mp4</code>', esc_html( $base ) );
		echo '</div>';
	}
	echo '</div>';
};
?>

<style>
	/* Estilos de la página de Hoteles y Posadas (ámbito local). */
	#hot-page{--hot-green:#2e9e5b;--hot-amber:#C98A16;--hot-slate:#5A6070;}

	/* HERO */
	#hot-page .hot-hero{position:relative;overflow:hidden;}
	#hot-page .hot-hero::before{content:"";position:absolute;inset:0;z-index:0;background:radial-gradient(760px 400px at 88% 4%,rgba(193,39,45,.08),transparent 60%),linear-gradient(180deg,#fff,var(--bg-alt));}
	#hot-page .hot-hero .hero-grid{position:relative;z-index:1;display:grid;grid-template-columns:1fr 1.05fr;gap:52px;align-items:center;padding:66px 0 108px;}
	#hot-page .hot-hero h1{font-size:clamp(32px,4.4vw,50px);font-weight:800;}
	#hot-page .hot-hero .lead{color:var(--muted);font-size:18px;margin:20px 0 8px;max-width:520px;}
	#hot-page .hot-hero .hero-cta{display:flex;gap:14px;flex-wrap:wrap;margin-top:28px;}
	#hot-page .hot-hero .hero-note{display:flex;align-items:center;gap:8px;font-size:13.5px;color:var(--muted);margin-top:22px;}
	#hot-page .hot-hero .hero-note svg{width:16px;height:16px;color:var(--hot-green);flex-shrink:0;}

	/* Columna visual: foto + tarjeta del mapa de disponibilidad */
	#hot-page .hot-visual{position:relative;}
	/* La foto va al frente; la tarjeta del mapa asoma por detrás. */
	#hot-page .hot-hero-photo{position:relative;z-index:2;width:100%;height:auto;display:block;border-radius:var(--radius);box-shadow:var(--shadow-lg);object-fit:cover;}
	#hot-page .hot-visual > .hot-frame{position:relative;z-index:2;}

	/* Mini «Mapa de reservas» — réplica en CSS de la pantalla del sistema.
	   Los colores son los mismos que usa el módulo de hotel: azul reservado,
	   verde check-in, amarillo check-out y rosa cancelado. */
	#hot-page .hot-cal-card{background:#fff;border:1px solid var(--line);border-radius:16px;box-shadow:var(--shadow-md);padding:14px 16px 16px;}
	#hot-page .hot-cal-top{display:flex;align-items:center;justify-content:space-between;gap:10px;flex-wrap:wrap;}
	#hot-page .hot-cal-top b{font-family:'Manrope';font-weight:800;font-size:14px;color:var(--ink-strong);}
	#hot-page .hot-cal-top .day{font-family:'Manrope';font-weight:700;font-size:10px;color:#2f6fd0;border:1px solid #cfdef7;border-radius:8px;padding:3px 9px;white-space:nowrap;}
	#hot-page .hot-cal-legend{display:flex;gap:11px;flex-wrap:wrap;margin:10px 0 12px;}
	#hot-page .hot-cal-legend span{display:flex;align-items:center;gap:5px;font-size:10px;color:var(--muted);white-space:nowrap;}
	#hot-page .hot-cal-legend i{width:9px;height:9px;border-radius:2px;display:block;}
	#hot-page .hot-cal{display:flex;flex-direction:column;gap:7px;}
	#hot-page .hot-cal-row{display:grid;grid-template-columns:54px 1fr;gap:8px;align-items:start;}
	#hot-page .hot-cal-row .rm{font-size:10px;color:var(--muted);font-family:'Manrope';font-weight:700;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;padding-top:12px;}
	#hot-page .hot-cal-row.head .rm{padding-top:0;color:var(--ink-strong);}
	#hot-page .hot-cal-row .cells{display:grid;grid-template-columns:repeat(4,1fr);gap:3px;}
	#hot-page .hot-cal-row.head .cells span{text-align:center;font-size:9px;color:var(--muted);font-family:'Manrope';font-weight:700;white-space:nowrap;}
	#hot-page .hot-cal-row .cells i{display:flex;flex-direction:column;align-items:center;justify-content:center;gap:3px;height:38px;border:1px solid #ededef;border-radius:4px;font-style:normal;font-family:'Manrope';font-weight:700;font-size:9px;}
	#hot-page .hot-cal-row .cells i::after{content:"";width:8px;height:8px;border-radius:2px;background:#fff;border:1px solid rgba(0,0,0,.15);}
	#hot-page .hot-cal .c-free{background:#fff;color:var(--muted);}
	#hot-page .hot-cal .c-res{background:#2f8bfb;border-color:#2f8bfb;color:#fff;}
	#hot-page .hot-cal .c-in{background:#1f9254;border-color:#1f9254;color:#fff;}
	#hot-page .hot-cal .c-out{background:#efab1e;border-color:#efab1e;color:#fff;}
	#hot-page .hot-cal-row .labels{grid-column:2;display:grid;grid-template-columns:repeat(4,1fr);gap:3px;margin-top:3px;}
	#hot-page .hot-cal-row .labels b{grid-column:var(--s)/var(--e);border-radius:4px;padding:3px 7px;font-family:'Manrope';font-weight:700;font-size:8.5px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
	#hot-page .hot-cal .l-res{background:#d8e7fd;color:#1b4f9e;}
	#hot-page .hot-cal .l-in{background:#d7ebe0;color:#166341;}
	#hot-page .hot-cal .l-out{background:#fdf1d3;color:#8a5c05;}

	/* ESTADOS DE LA HABITACIÓN */
	#hot-page .hot-states{display:grid;grid-template-columns:repeat(5,1fr);gap:14px;}
	#hot-page .hot-state{background:#fff;border:1px solid var(--line);border-radius:var(--radius);padding:18px;transition:transform .18s ease,box-shadow .18s ease,border-color .18s ease;}
	#hot-page .hot-state:hover{transform:translateY(-3px);box-shadow:var(--shadow-md);border-color:#e0d0d0;}
	#hot-page .hot-state .dot{width:12px;height:12px;border-radius:4px;display:block;margin-bottom:12px;}
	#hot-page .hot-state b{display:block;font-family:'Manrope';font-weight:700;font-size:15px;color:var(--ink-strong);}
	#hot-page .hot-state span{display:block;color:var(--muted);font-size:13px;margin-top:5px;}

	/* MARCO (estilo navegador) para capturas y videos */
	#hot-page .hot-frame{background:#fff;border:1px solid #d9d9de;border-radius:14px;overflow:hidden;box-shadow:var(--shadow-md);}
	#hot-page .hot-frame .bar{display:flex;align-items:center;gap:6px;padding:9px 12px;background:#f3f3f5;border-bottom:1px solid #e6e6ea;}
	#hot-page .hot-frame .bar i{width:10px;height:10px;border-radius:50%;background:#d6d6dc;display:block;}
	#hot-page .hot-frame video,#hot-page .hot-frame img{width:100%;height:auto;display:block;background:#000;}
	#hot-page .hot-shot{margin:0;}
	#hot-page .hot-shot figcaption{margin-top:12px;text-align:center;color:var(--muted);font-size:13.5px;}

	/* Marcador (placeholder) */
	#hot-page .hot-ph{aspect-ratio:16/10;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:10px;text-align:center;background:var(--bg-alt);color:var(--muted);padding:24px;font-size:14px;}
	#hot-page .hot-ph svg{width:46px;height:46px;color:#c9c9d0;}
	#hot-page .hot-ph b{font-family:'Manrope';font-weight:700;color:var(--ink-strong);font-size:15px;}
	#hot-page .hot-ph code{font-size:13px;color:var(--red-dark);background:var(--red-soft);padding:4px 10px;border-radius:6px;}
	#hot-page .hot-ph-img{aspect-ratio:auto;padding:52px 20px;}

	/* HUB: tarjetas de lo que resuelve */
	#hot-page .hot-hub{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;}
	#hot-page .hot-tool{position:relative;background:#fff;border:1px solid var(--line);border-radius:var(--radius);padding:24px 22px;transition:transform .18s ease,box-shadow .18s ease,border-color .18s ease;overflow:hidden;}
	#hot-page .hot-tool::after{content:"";position:absolute;right:-40px;top:-40px;width:120px;height:120px;border-radius:50%;background:var(--red-soft);opacity:0;transition:opacity .2s ease;}
	#hot-page .hot-tool:hover{transform:translateY(-4px);box-shadow:var(--shadow-md);border-color:#e0d0d0;}
	#hot-page .hot-tool:hover::after{opacity:.6;}
	#hot-page .hot-tool>*{position:relative;z-index:1;}
	#hot-page .hot-ic{width:50px;height:50px;border-radius:13px;background:var(--red-soft);display:grid;place-items:center;margin-bottom:16px;}
	#hot-page .hot-ic svg{width:25px;height:25px;color:var(--red);}
	#hot-page .hot-tool h3{font-size:17px;font-weight:700;margin-bottom:7px;}
	#hot-page .hot-tool p{color:var(--muted);font-size:14px;}

	/* FILAS ALTERNADAS (texto + captura) */
	#hot-page .hot-rows{display:flex;flex-direction:column;gap:60px;}
	#hot-page .hot-row{display:grid;grid-template-columns:1fr 1.15fr;gap:46px;align-items:center;}
	#hot-page .hot-row.reverse .hot-row-text{order:2;}
	#hot-page .hot-row.reverse .hot-row-media{order:1;}
	/* En las filas invertidas el medio pasa a la primera columna, así que hay
	   que voltear también la proporción para que no quede en la angosta. */
	#hot-page .hot-row.reverse{grid-template-columns:1.15fr 1fr;}
	/* Filas donde la captura o el video llevan más peso que el texto. */
	#hot-page .hot-row.wide{grid-template-columns:1fr 1.55fr;gap:40px;}
	#hot-page .hot-row.reverse.wide{grid-template-columns:1.55fr 1fr;gap:40px;}
	#hot-page .hot-row.wider{grid-template-columns:1fr 1.9fr;gap:36px;}
	#hot-page .hot-row.reverse.wider{grid-template-columns:1.9fr 1fr;gap:36px;}
	#hot-page .hot-row-text .hot-ic{width:52px;height:52px;}
	#hot-page .hot-row-text .hot-ic svg{width:26px;height:26px;}
	#hot-page .hot-row-text h3{font-size:clamp(20px,2.4vw,26px);font-weight:800;}
	#hot-page .hot-row-text p{color:var(--muted);font-size:16.5px;margin-top:14px;max-width:440px;}
	#hot-page .hot-list{list-style:none;margin:18px 0 0;padding:0;display:flex;flex-direction:column;gap:10px;max-width:440px;}
	#hot-page .hot-list li{display:flex;align-items:flex-start;gap:10px;color:var(--ink-strong);font-size:15px;}
	#hot-page .hot-list li svg{width:19px;height:19px;color:var(--hot-green);flex-shrink:0;margin-top:1px;}

	/* CHIPS */
	#hot-page .hot-chips{display:flex;flex-wrap:wrap;gap:10px;margin-top:18px;max-width:460px;}
	#hot-page .hot-chip{display:inline-flex;align-items:center;gap:7px;background:#fff;border:1px solid var(--line);border-radius:999px;padding:7px 14px;font-size:13.5px;font-family:'Manrope';font-weight:700;color:var(--ink-strong);box-shadow:var(--shadow-sm);}
	#hot-page .hot-chip i{width:7px;height:7px;border-radius:50%;background:var(--red);display:block;}

	/* RECORRIDO DE LA RESERVA (línea de tiempo) */
	#hot-page .hot-flow{display:grid;grid-template-columns:repeat(5,1fr);gap:18px;position:relative;}
	#hot-page .hot-flow::before{content:"";position:absolute;left:0;right:0;top:26px;height:2px;background:linear-gradient(90deg,var(--red),#e3c0c0);border-radius:2px;}
	#hot-page .hot-step{position:relative;background:#fff;border:1px solid var(--line);border-radius:var(--radius);padding:20px 18px;box-shadow:var(--shadow-sm);}
	#hot-page .hot-step .num{position:absolute;top:-16px;left:18px;width:34px;height:34px;border-radius:11px;background:var(--red);color:#fff;display:grid;place-items:center;font-family:'Manrope';font-weight:800;font-size:14px;box-shadow:0 6px 14px rgba(193,39,45,.3);}
	#hot-page .hot-step b{display:block;font-family:'Manrope';font-weight:700;font-size:15.5px;color:var(--ink-strong);margin:22px 0 6px;}
	#hot-page .hot-step p{color:var(--muted);font-size:13.5px;}

	/* TARIFAS */
	#hot-page .hot-rates{display:grid;grid-template-columns:repeat(3,1fr);gap:18px;margin-top:20px;}
	#hot-page .hot-rate{background:#fff;border:1px solid var(--line);border-radius:var(--radius);padding:20px;box-shadow:var(--shadow-sm);}
	#hot-page .hot-rate .tag{display:inline-block;background:var(--red-soft);color:var(--red-dark);font-family:'Manrope';font-weight:700;font-size:11.5px;letter-spacing:.05em;text-transform:uppercase;padding:5px 11px;border-radius:999px;}
	#hot-page .hot-rate b{display:block;font-family:'Manrope';font-weight:800;font-size:17px;color:var(--ink-strong);margin:14px 0 6px;}
	#hot-page .hot-rate span{display:block;color:var(--muted);font-size:13.5px;}

	/* SECCIÓN DE VIDEO */
	#hot-page .hot-video-wrap{max-width:900px;margin:0 auto;}
	#hot-page .hot-video-wrap .cap{margin-top:16px;text-align:center;}
	#hot-page .hot-video-wrap .cap b{font-family:'Manrope';font-weight:700;font-size:16px;color:var(--ink-strong);display:block;}
	#hot-page .hot-video-wrap .cap span{color:var(--muted);font-size:14px;}

	/* Tarjeta del mapa flotando sobre la foto (solo pantallas grandes) */
	@media (min-width:1001px){
		/* La tarjeta asoma por detrás de la foto, pero siempre dentro de su
		   propia columna: nunca se monta sobre el texto del hero. */
		#hot-page .hot-cal-card{position:absolute;z-index:1;left:0;bottom:-70px;width:min(430px,100%);transform:rotate(-2deg);transform-origin:bottom left;}
		/* La foto cede un poco de ancho para que se vea más de la tarjeta. */
		#hot-page .hot-visual > .hot-hero-photo,
		#hot-page .hot-visual > .hot-frame{width:88%;margin-left:auto;}
	}
	@media (max-width:1000px){
		#hot-page .hot-cal-card{margin-top:18px;}
		#hot-page .hot-states{grid-template-columns:repeat(3,1fr);}
		#hot-page .hot-hub{grid-template-columns:repeat(2,1fr);}
		#hot-page .hot-flow{grid-template-columns:repeat(2,1fr);}
		#hot-page .hot-flow::before{display:none;}
	}
	@media (max-width:900px){
		#hot-page .hot-hero .hero-grid{grid-template-columns:1fr;gap:34px;padding:52px 0 62px;}
		#hot-page .hot-row,
		#hot-page .hot-row.reverse,
		#hot-page .hot-row.wide,
		#hot-page .hot-row.reverse.wide,
		#hot-page .hot-row.wider,
		#hot-page .hot-row.reverse.wider{grid-template-columns:1fr;gap:22px;}
		#hot-page .hot-row.reverse .hot-row-text{order:0;}
		#hot-page .hot-row.reverse .hot-row-media{order:0;}
		#hot-page .hot-rates{grid-template-columns:1fr;}
	}
	@media (max-width:560px){
		#hot-page .hot-states{grid-template-columns:1fr;}
		#hot-page .hot-hub{grid-template-columns:1fr;}
		#hot-page .hot-flow{grid-template-columns:1fr;}
		#hot-page .hot-cal-row{grid-template-columns:46px 1fr;gap:6px;}
		#hot-page .hot-cal-row .cells{gap:2px;}
		#hot-page .hot-cal-row .cells i{font-size:8px;height:34px;}
		#hot-page .hot-cal-row.head .cells span{font-size:8px;}
	}
</style>

<div id="hot-page">

	<!-- HERO -->
	<section class="hot-hero">
		<div class="wrap">
			<div class="hero-grid">
				<div class="hero-copy">
					<span class="eyebrow"><span class="dot"></span> <?php echo esc_html( vlac_opt( 'hot_eyebrow', 'Hoteles y Posadas' ) ); ?></span>
					<h1><?php echo wp_kses_post( vlac_opt( 'hot_title', 'El sistema para tu <span class="accent">hotel</span> o <span class="accent">posada</span>' ) ); ?></h1>
					<p class="lead"><?php echo esc_html( vlac_opt( 'hot_sub', 'Mira la disponibilidad de todas tus habitaciones en un solo mapa, reserva, haz check-in cama por cama y cierra la cuenta con los consumos y la factura al momento de la salida.' ) ); ?></p>
					<div class="hero-cta">
						<a class="btn btn-red btn-lg" href="<?php echo esc_url( vlac_cta_url( 'hero_cta1_url' ) ); ?>"><?php echo esc_html( vlac_opt( 'hero_cta1_txt', 'Prueba gratis' ) ); ?></a>
						<a class="btn btn-ghost" href="<?php echo esc_url( vlac_opt( 'hero_cta2_url', '#' ) ); ?>"><?php echo esc_html( vlac_opt( 'hero_cta2_txt', 'Ver una demo' ) ); ?></a>
					</div>
					<div class="hero-note">
						<svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
						Mapa de reservas · Check-in y check-out · Tarifas · Facturación
					</div>
				</div>

				<div class="hot-visual">
					<?php
					// Foto real del hotel o la posada. Prioridad: imagen del
					// Personalizador, luego /assets/img/hot-hero.png, y si no hay,
					// un marcador con las instrucciones.
					$hot_hero_url = vlac_opt( 'hot_img_hero' );
					if ( ! $hot_hero_url && file_exists( $img_dir . 'hot-hero.png' ) ) {
						$hot_hero_url = $img . '/hot-hero.png';
					}
					if ( $hot_hero_url ) {
						printf( '<img class="hot-hero-photo" src="%s" alt="%s" loading="lazy" />', esc_url( $hot_hero_url ), esc_attr( get_the_title() ) );
					} else {
						echo '<div class="hot-frame"><div class="hot-ph hot-ph-img">Sube una foto del hotel o la posada en <b>Personalizar → Página Hoteles y Posadas → Hero</b><br>o el archivo <code>assets/img/hot-hero.png</code></div></div>';
					}
					?>

					<!-- Mini «Mapa de reservas» (ilustración hecha con CSS) -->
					<div class="hot-cal-card" aria-hidden="true">
						<div class="hot-cal-top">
							<b>Mapa de reservas</b>
							<span class="day">27 julio de 2026</span>
						</div>
						<div class="hot-cal-legend">
							<span><i style="background:#4c6ef5"></i>Reservado</span>
							<span><i style="background:#1f9254"></i>Check-in</span>
							<span><i style="background:#efab1e"></i>Check-out</span>
							<span><i style="background:#e8467c"></i>Cancelado</span>
						</div>
						<div class="hot-cal">
							<div class="hot-cal-row head">
								<span class="rm">Habitación</span>
								<div class="cells"><span>lun 27/07</span><span>mar 28/07</span><span>mié 29/07</span><span>jue 30/07</span></div>
							</div>
							<div class="hot-cal-row">
								<span class="rm">101 · Doble</span>
								<div class="cells">
									<i class="c-in">Q 260.00</i><i class="c-in">Q 260.00</i><i class="c-free">Q 260.00</i><i class="c-free">Q 400.00</i>
								</div>
								<div class="labels"><b class="l-in" style="--s:1;--e:3">#127 · ANTONIO</b></div>
							</div>
							<div class="hot-cal-row">
								<span class="rm">102 · Doble</span>
								<div class="cells">
									<i class="c-free">Q 260.00</i><i class="c-out">Q 260.00</i><i class="c-out">Q 260.00</i><i class="c-out">Q 400.00</i>
								</div>
								<div class="labels"><b class="l-out" style="--s:2;--e:5">#128 · Blanca Magaly</b></div>
							</div>
							<div class="hot-cal-row">
								<span class="rm">201 · Familiar</span>
								<div class="cells">
									<i class="c-res">Q 400.00</i><i class="c-res">Q 400.00</i><i class="c-res">Q 400.00</i><i class="c-free">Q 400.00</i>
								</div>
								<div class="labels"><b class="l-res" style="--s:1;--e:4">#126 · Aníbal Meda</b></div>
							</div>
							<div class="hot-cal-row">
								<span class="rm">202 · Suite</span>
								<div class="cells">
									<i class="c-free">Q 400.00</i><i class="c-free">Q 400.00</i><i class="c-in">Q 400.00</i><i class="c-in">Q 400.00</i>
								</div>
								<div class="labels"><b class="l-in" style="--s:3;--e:5">#135 · CONSUMIDOR FINAL</b></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- LO QUE RESUELVE -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Pensado para el rubro</div>
				<h2>Lo que un hotel o una posada necesita, resuelto</h2>
				<p>Del mapa de disponibilidad a la factura de salida, con las habitaciones, las tarifas y los consumos en el mismo sistema.</p>
			</div>

			<div class="hot-hub">
				<div class="hot-tool">
					<div class="hot-ic"><svg viewBox="0 0 24 24" fill="none"><rect x="3" y="5" width="18" height="16" rx="2" stroke="currentColor" stroke-width="1.7"/><path d="M3 10h18M8 3v4M16 3v4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
					<h3>Mapa de reservas</h3>
					<p>Todas tus habitaciones por día, con lo ocupado, lo reservado y lo libre a la vista.</p>
				</div>
				<div class="hot-tool">
					<div class="hot-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M3 18v-6a2 2 0 012-2h14a2 2 0 012 2v6M3 18h18M3 18v2M21 18v2M6 10V8a2 2 0 012-2h8a2 2 0 012 2v2" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Habitaciones y camas</h3>
					<p>Cada habitación con su código, categoría, camas y foto, y su estado del momento.</p>
				</div>
				<div class="hot-tool">
					<div class="hot-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M12 12a4 4 0 100-8 4 4 0 000 8zM4 21a8 8 0 0116 0" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
					<h3>Reservas por cliente</h3>
					<p>Una reserva con varias habitaciones y fechas, con su total y su saldo pendiente.</p>
				</div>
				<div class="hot-tool">
					<div class="hot-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M15 4h4a1 1 0 011 1v14a1 1 0 01-1 1h-4M10 8l4 4-4 4M14 12H3" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Check-in y check-out</h3>
					<p>Entrada y salida por habitación o cama, incluso parcial cuando el grupo llega o se va por partes.</p>
				</div>
				<div class="hot-tool">
					<div class="hot-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M4 7l8-4 8 4v10l-8 4-8-4V7z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M9 12h6M12 9v6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
					<h3>Tarifas por temporada</h3>
					<p>Precios por rango de fechas o por días de la semana, por habitación o por huésped.</p>
				</div>
				<div class="hot-tool">
					<div class="hot-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M6 3h9l4 4v14H6z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M9 12h7M9 16h5M9 8h4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
					<h3>Consumos y factura</h3>
					<p>Restaurante, bar o servicios se cargan a la habitación y salen en la cuenta final.</p>
				</div>
			</div>
		</div>
	</section>

	<!-- MAPA Y HABITACIONES -->
	<section class="section">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Disponibilidad</div>
				<h2>Qué habitación está libre, ocupada o por salir</h2>
				<p>Un solo mapa te dice qué puedes vender hoy y qué se libera mañana, sin llamar a recepción.</p>
			</div>

			<div class="hot-rows">
				<div class="hot-row">
					<div class="hot-row-text">
						<div class="hot-ic"><svg viewBox="0 0 24 24" fill="none"><rect x="3" y="5" width="18" height="16" rx="2" stroke="currentColor" stroke-width="1.7"/><path d="M3 10h18M8 3v4M16 3v4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
						<h3>El mapa de reservas, día por día</h3>
						<p>Cada habitación con el precio de cada noche y el color de su estado: reservado, check-in, check-out o cancelado. Recorre los días hacia adelante o hacia atrás, vuelve a hoy con un clic y marca las fechas para reservar ahí mismo.</p>
						<ul class="hot-list">
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>El precio de cada noche visible en la celda</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Cada reserva con su número y el nombre del cliente</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Selecciona fechas sobre el mapa y reserva</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Descarga el mapa y el listado de reservas</li>
						</ul>
					</div>
					<div class="hot-row-media"><?php $hot_shot( 'hot-mapa.png', '', 'hot_img_mapa' ); ?></div>
				</div>

				<div class="hot-row reverse">
					<div class="hot-row-text">
						<div class="hot-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M3 18v-6a2 2 0 012-2h14a2 2 0 012 2v6M3 18h18M3 18v2M21 18v2M6 10V8a2 2 0 012-2h8a2 2 0 012 2v2" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
						<h3>Cada habitación con sus camas</h3>
						<p>Registra la habitación con su código, su nombre, su categoría y su foto, y define las camas que tiene. Al hacer el check-in asignas al huésped la cama que ocupa.</p>
						<ul class="hot-list">
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Camas nombradas una por una</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Foto de la habitación y de la categoría</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Fechas de alta y baja para sacarla de venta</li>
						</ul>
					</div>
					<div class="hot-row-media"><?php $hot_shot( 'hot-habitacion.png', '', 'hot_img_habitacion' ); ?></div>
				</div>
			</div>
		</div>
	</section>

	<!-- ESTADOS DE LA HABITACIÓN -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Estado en vivo</div>
				<h2>Recepción y limpieza, hablando el mismo idioma</h2>
				<p>Cada habitación lleva su estado, así nadie vende un cuarto que todavía no está listo.</p>
			</div>

			<div class="hot-states">
				<div class="hot-state">
					<span class="dot" style="background:#2e9e5b"></span>
					<b>Disponible</b>
					<span>Lista para recibir al siguiente huésped.</span>
				</div>
				<div class="hot-state">
					<span class="dot" style="background:var(--red)"></span>
					<b>Ocupada</b>
					<span>Con huéspedes dentro y su estancia abierta.</span>
				</div>
				<div class="hot-state">
					<span class="dot" style="background:#C98A16"></span>
					<b>Sucia</b>
					<span>Ya salió el huésped y espera limpieza.</span>
				</div>
				<div class="hot-state">
					<span class="dot" style="background:#5A6070"></span>
					<b>Mantenimiento</b>
					<span>En reparación, fuera de venta por unos días.</span>
				</div>
				<div class="hot-state">
					<span class="dot" style="background:#22242a"></span>
					<b>Fuera de servicio</b>
					<span>No se ofrece hasta que la vuelvas a habilitar.</span>
				</div>
			</div>
		</div>
	</section>

	<!-- RECORRIDO DE LA RESERVA -->
	<section class="section">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">De la reserva a la factura</div>
				<h2>Todo el paso del huésped, registrado</h2>
				<p>Cada movimiento queda guardado con la fecha y el usuario que lo hizo.</p>
			</div>

			<div class="hot-flow">
				<div class="hot-step">
					<span class="num">1</span>
					<b>Reserva</b>
					<p>Eliges habitación y fechas, indicas adultos y niños, y queda el total con su saldo pendiente.</p>
				</div>
				<div class="hot-step">
					<span class="num">2</span>
					<b>Check-in</b>
					<p>Llega el huésped, se le asigna su cama y la habitación pasa a ocupada. Si el grupo llega por partes, el check-in queda parcial.</p>
				</div>
				<div class="hot-step">
					<span class="num">3</span>
					<b>Estancia</b>
					<p>Los consumos del restaurante, el bar o los servicios se cargan a la habitación durante la estadía.</p>
				</div>
				<div class="hot-step">
					<span class="num">4</span>
					<b>Check-out</b>
					<p>Se cierra la estancia, se cobra el saldo y la habitación pasa a limpieza.</p>
				</div>
				<div class="hot-step">
					<span class="num">5</span>
					<b>Factura</b>
					<p>El alojamiento y los consumos salen en una sola cuenta, facturada al instante.</p>
				</div>
			</div>

			<div class="hot-rows" style="margin-top:60px">
				<div class="hot-row">
					<div class="hot-row-text">
						<div class="hot-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M6 3h9l4 4v14H6z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M9 12h7M9 16h5M9 8h4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
						<h3>La reserva, con todo adentro</h3>
						<p>Una reserva puede llevar varias habitaciones y varias fechas. Ves el total del alojamiento, lo pagado, lo pendiente, las notas y el historial completo de lo que pasó con ella.</p>
						<ul class="hot-list">
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Varias habitaciones en una sola reserva</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Total pagado y total pendiente siempre visibles</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Historial: creada, editada, check-in, pagos, notas y cancelaciones</li>
						</ul>
					</div>
					<div class="hot-row-media"><?php $hot_shot( 'hot-reserva.png', '', 'hot_img_reserva' ); ?></div>
				</div>
			</div>
		</div>
	</section>

	<!-- TARIFAS Y PRECIOS -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Tarifas</div>
				<h2>Cobra distinto según la temporada y la ocupación</h2>
				<p>El precio se arma solo, según la categoría, la cantidad de huéspedes y la fecha en la que se hospedan.</p>
			</div>

			<div class="hot-rows">
				<div class="hot-row">
					<div class="hot-row-text">
						<div class="hot-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M4 7l8-4 8 4v10l-8 4-8-4V7z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M9 12h6M12 9v6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
						<h3>Categorías con planes de tarifa</h3>
						<p>Cada categoría define su capacidad máxima y sus planes por cantidad de huéspedes. Si entran más personas de las que cubre el plan, se suma automáticamente el precio del huésped adicional.</p>
						<div class="hot-rates">
							<div class="hot-rate">
								<span class="tag">Plan 1</span>
								<b>1 a 2 huéspedes</b>
								<span>Tarifa base de la categoría.</span>
							</div>
							<div class="hot-rate">
								<span class="tag">Plan 2</span>
								<b>3 a 4 huéspedes</b>
								<span>Su propia tarifa base, sin recargos.</span>
							</div>
							<div class="hot-rate">
								<span class="tag">Extra</span>
								<b>Huésped adicional</b>
								<span>Se suma por cada persona de más.</span>
							</div>
						</div>
					</div>
					<div class="hot-row-media"><?php $hot_shot( 'hot-categorias.png', '', 'hot_img_categorias' ); ?></div>
				</div>

				<div class="hot-row reverse">
					<div class="hot-row-text">
						<div class="hot-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M12 21s7-4.5 7-10a7 7 0 10-14 0c0 5.5 7 10 7 10z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M12 7v4l2.5 1.5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
						<h3>Precios por temporada y por día</h3>
						<p>Arma precios para un rango de fechas —Semana Santa, fin de año, feria del pueblo— o para ciertos días de la semana, como el fin de semana. Cuando dos precios coinciden, manda el de mayor prioridad.</p>
						<div class="hot-chips">
							<span class="hot-chip"><i></i>Rango de fechas</span>
							<span class="hot-chip"><i></i>Días de la semana</span>
							<span class="hot-chip"><i></i>Por habitación</span>
							<span class="hot-chip"><i></i>Por huésped</span>
							<span class="hot-chip"><i></i>Prioridad</span>
						</div>
						<ul class="hot-list">
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Un mismo precio aplicado a varias habitaciones</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>El total de la estancia se calcula solo, noche por noche</li>
						</ul>
					</div>
					<div class="hot-row-media"><?php $hot_shot( 'hot-precios.png', '', 'hot_img_precios' ); ?></div>
				</div>
			</div>
		</div>
	</section>

	<!-- VIDEOS: RESERVA Y CHECK-IN -->
	<section class="section">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">En acción</div>
				<h2>Así se ve el día a día en recepción</h2>
				<p>Desde que entra la llamada del huésped hasta que entrega la llave.</p>
			</div>

			<div class="hot-rows">
				<div class="hot-row wide">
					<div class="hot-row-text">
						<div class="hot-ic"><svg viewBox="0 0 24 24" fill="none"><rect x="3" y="5" width="18" height="16" rx="2" stroke="currentColor" stroke-width="1.7"/><path d="M3 10h18M8 3v4M16 3v4M9 15h6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
						<h3>Crear la reserva desde el mapa</h3>
						<p>Marcas los días sobre la habitación libre, eliges al cliente, indicas cuántos adultos y niños llegan, y la reserva queda hecha con su precio calculado.</p>
					</div>
					<div class="hot-row-media"><?php $hot_video( 'reserva-hotel', 'Video: crear una reserva', 'Elige fechas sobre el mapa y confirma', 'hot_video_reserva' ); ?></div>
				</div>

				<div class="hot-row reverse wider">
					<div class="hot-row-text">
						<div class="hot-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M15 4h4a1 1 0 011 1v14a1 1 0 01-1 1h-4M10 8l4 4-4 4M14 12H3" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
						<h3>Check-in con asignación de camas</h3>
						<p>Al llegar el huésped registras su entrada y le asignas la cama que va a ocupar. Si el grupo llega en momentos distintos, cada quien entra cuando llega y la reserva queda en check-in parcial.</p>
					</div>
					<div class="hot-row-media"><?php $hot_video( 'checkin-hotel', 'Video: check-in del huésped', 'Registra la entrada y asigna la cama', 'hot_video_checkin' ); ?></div>
				</div>
			</div>
		</div>
	</section>

	<!-- VIDEO: SALIDA Y FACTURA -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">La cuenta final</div>
				<h2>Salida, consumos y factura en un solo paso</h2>
				<p>Mira cómo se cierra la estancia con todo lo que consumió el huésped.</p>
			</div>

			<div class="hot-video-wrap">
				<?php $hot_video( 'checkout-hotel', 'Video: check-out y facturación', 'Cierra la estancia, cobra el saldo y factura', 'hot_video_checkout' ); ?>
				<div class="cap">
					<b>Check-out con la cuenta completa</b>
					<span>Alojamiento y consumos en un mismo documento, listo para facturar</span>
				</div>
			</div>
		</div>
	</section>

	<!-- INFORMES -->
	<section class="section">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Informes</div>
				<h2>Cómo va la ocupación de tu hotel</h2>
				<p>Saca el mapa de reservas y el listado de estancias del período que necesites.</p>
			</div>

			<div class="hot-rows">
				<div class="hot-row wide">
					<div class="hot-row-text">
						<div class="hot-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M4 19V5M4 19h16M8 16l3-4 3 2 4-6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
						<h3>Reservas y ocupación, en Excel</h3>
						<p>Exporta el mapa de reservas o el listado detallado con cliente, habitación, fechas, huéspedes, total y saldo, para revisarlo o compartirlo con tu contador.</p>
						<ul class="hot-list">
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Mapa de reservas del período</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Listado de reservas con totales y pendientes</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Un informe por sucursal si tienes varias propiedades</li>
						</ul>
					</div>
					<div class="hot-row-media"><?php $hot_shot( 'hot-informes.png', '', 'hot_img_informes' ); ?></div>
				</div>
			</div>
		</div>
	</section>

	<!-- CAPACIDADES -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Todo lo que incluye</div>
				<h2>Pensado para el día a día de tu hospedaje</h2>
			</div>
			<div class="feat-grid">
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><rect x="3" y="5" width="18" height="16" rx="2" stroke="currentColor" stroke-width="1.7"/><path d="M3 10h18M8 3v4M16 3v4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
					<h3>Mapa de reservas</h3>
					<p>Habitaciones por día, agrupadas por categoría.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M3 18v-6a2 2 0 012-2h14a2 2 0 012 2v6M3 18h18M6 10V8a2 2 0 012-2h8a2 2 0 012 2v2" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Camas por habitación</h3>
					<p>Asignación del huésped a su cama en el check-in.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M4 7l8-4 8 4v10l-8 4-8-4V7z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M9 12h6M12 9v6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
					<h3>Tarifas por temporada</h3>
					<p>Por rango de fechas, días de semana o huésped.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M15 4h4a1 1 0 011 1v14a1 1 0 01-1 1h-4M10 8l4 4-4 4M14 12H3" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Check-in parcial</h3>
					<p>El grupo entra o sale por partes, sin enredar la cuenta.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M3 5h2l2.4 10.2a2 2 0 002 1.6h7.6a2 2 0 002-1.6L21 8H6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><circle cx="10" cy="20" r="1.4" stroke="currentColor" stroke-width="1.5"/><circle cx="17" cy="20" r="1.4" stroke="currentColor" stroke-width="1.5"/></svg></div>
					<h3>Consumos a la habitación</h3>
					<p>Restaurante, bar y servicios cargados a la estancia.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M6 3h9l4 4v14H6z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M9 12h7M9 16h5M9 8h4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
					<h3>Facturación electrónica</h3>
					<p>La cuenta del huésped, facturada al instante.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M12 8v4l3 2" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/></svg></div>
					<h3>Historial de la reserva</h3>
					<p>Quién hizo cada cambio, pago o cancelación y cuándo.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M4 19V5M4 19h16M8 16l3-4 3 2 4-6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Informes de ocupación</h3>
					<p>Mapa y listado de reservas exportables.</p>
				</div>
			</div>
		</div>
	</section>

	<!-- CTA -->
	<section class="section">
		<div class="wrap">
			<div class="cta-strip">
				<h2><?php echo esc_html( vlac_opt( 'hot_cta_title', 'Llena tu hotel y controla cada habitación' ) ); ?></h2>
				<p><?php echo esc_html( vlac_opt( 'hot_cta_sub', 'Reserva, hospeda, cobra y factura desde un solo sistema conectado, con la disponibilidad de tus habitaciones siempre al día.' ) ); ?></p>
				<a class="btn btn-red btn-lg" href="<?php echo esc_url( vlac_cta_url( 'cta_btn_url' ) ); ?>"><?php echo esc_html( vlac_opt( 'hero_cta1_txt', 'Prueba gratis' ) ); ?></a>
			</div>
		</div>
	</section>

</div>

<?php
get_footer();
