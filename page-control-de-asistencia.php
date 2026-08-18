<?php
/**
 * Template Name: Control de Asistencia y Nómina
 *
 * Página de producto del módulo de asistencia con lector biométrico
 * Control iD (idFace) y su enlace con la nómina: sincronización de
 * usuarios, registros de horario, contratos de trabajo y cálculo de
 * horas trabajadas contra las esperadas.
 *
 * IMÁGENES (guárdalas en /assets/img/ con estos nombres exactos):
 *   cid-sync.png       → sincronizar usuarios con el aparato (captura 1)
 *   cid-aparatos.png   → registrar un aparato y su configuración
 *   cid-contrato.png   → contrato de trabajo con la jornada semanal (captura 2)
 *   cid-registros.png  → registros de horario / marcajes (captura 3)
 *   cid-nomina.png     → nómina con horas trabajadas (captura 4)
 *   cid-hero.png       → imagen destacada del hero (opcional)
 *
 * VIDEO (opcional, guárdalo en /assets/video/):
 *   controlid-marcaje.mp4  → alguien marcando entrada en el aparato
 *
 * Para usarla: crea una página (Páginas → Añadir nueva) con el título
 * «Control de asistencia» y el slug «control-de-asistencia», y en
 * «Atributos de página → Plantilla» elige «Control de Asistencia y
 * Nómina». No necesita contenido.
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
$cid_shot = function ( $file, $caption, $opt_key = '' ) use ( $img, $img_dir ) {
	$url    = $opt_key ? vlac_opt( $opt_key ) : '';
	$exists = file_exists( $img_dir . $file );
	echo '<figure class="cid-shot"><div class="cid-frame"><div class="bar"><i></i><i></i><i></i></div>';
	if ( $url ) {
		printf( '<img src="%s" alt="%s" loading="lazy" />', esc_url( $url ), esc_attr( $caption ) );
	} elseif ( $exists ) {
		printf( '<img src="%s" alt="%s" loading="lazy" />', esc_url( $img . '/' . $file ), esc_attr( $caption ) );
	} else {
		printf( '<div class="cid-ph cid-ph-img">Elige la imagen en <b>Personalizar → Página Control de Asistencia</b><br>o sube <code>assets/img/%s</code></div>', esc_html( $file ) );
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
$cid_video = function ( $base, $title, $sub, $opt_key = '' ) use ( $vid_dir, $vid_url ) {
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
	echo '<div class="cid-frame"><div class="bar"><i></i><i></i><i></i></div>';
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
		echo '<div class="cid-ph">';
		echo '<svg viewBox="0 0 24 24" fill="none"><path d="M4 5h16v14H4zM10 9l6 3-6 3V9z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>';
		printf( '<b>%s</b><span>%s</span>', esc_html( $title ), esc_html( $sub ) );
		printf( '<code>assets/video/%s.mp4</code>', esc_html( $base ) );
		echo '</div>';
	}
	echo '</div>';
};
?>

<style>
	/* Estilos de la página de Control de Asistencia (ámbito local). */
	#cid-page{--cid-green:#2e9e5b;--cid-amber:#B4801A;}

	/* HERO */
	#cid-page .cid-hero{position:relative;overflow:hidden;}
	#cid-page .cid-hero::before{content:"";position:absolute;inset:0;z-index:0;background:radial-gradient(700px 380px at 82% 8%,rgba(193,39,45,.07),transparent 60%),linear-gradient(180deg,#fff,var(--bg-alt));}
	#cid-page .cid-hero .hero-grid{position:relative;z-index:1;display:grid;grid-template-columns:1fr 1.12fr;gap:48px;align-items:center;padding:66px 0 84px;}
	#cid-page .cid-hero h1{font-size:clamp(32px,4.4vw,50px);font-weight:800;}
	#cid-page .cid-hero .lead{color:var(--muted);font-size:18px;margin:20px 0 8px;max-width:520px;}
	#cid-page .cid-hero .hero-cta{display:flex;gap:14px;flex-wrap:wrap;margin-top:28px;}
	#cid-page .cid-hero .hero-note{display:flex;align-items:center;gap:8px;font-size:13.5px;color:var(--muted);margin-top:22px;}
	#cid-page .cid-hero .hero-note svg{width:16px;height:16px;color:var(--cid-green);flex:none;}

	/* MARCO (estilo navegador) para capturas y videos */
	#cid-page .cid-frame{background:#fff;border:1px solid #d9d9de;border-radius:14px;overflow:hidden;box-shadow:var(--shadow-md);}
	#cid-page .cid-frame .bar{display:flex;align-items:center;gap:6px;padding:9px 12px;background:#f3f3f5;border-bottom:1px solid #e6e6ea;}
	#cid-page .cid-frame .bar i{width:10px;height:10px;border-radius:50%;background:#d6d6dc;display:block;}
	#cid-page .cid-frame video,#cid-page .cid-frame img{width:100%;height:auto;display:block;background:#000;}
	#cid-page .cid-hero .cid-frame{box-shadow:var(--shadow-lg);}

	/* Marcador (placeholder) */
	#cid-page .cid-ph{aspect-ratio:16/10;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:10px;text-align:center;background:var(--bg-alt);color:var(--muted);padding:24px;font-size:14px;}
	#cid-page .cid-ph svg{width:46px;height:46px;color:#c9c9d0;}
	#cid-page .cid-ph b{font-family:'Manrope';font-weight:700;color:var(--ink-strong);font-size:15px;}
	#cid-page .cid-ph code{font-size:13px;color:var(--red-dark);background:var(--red-soft);padding:4px 10px;border-radius:6px;}
	#cid-page .cid-ph-img{aspect-ratio:auto;padding:52px 20px;}

	/* ESTADOS (píldoras que imitan las del sistema) */
	#cid-page .cid-pills{display:flex;flex-wrap:wrap;gap:8px;margin-top:26px;}
	#cid-page .cid-pill{display:inline-flex;align-items:center;gap:7px;font-family:'Manrope';font-weight:700;font-size:12.5px;padding:6px 13px;border-radius:999px;border:1px solid var(--line);background:#fff;color:var(--ink-strong);}
	#cid-page .cid-pill i{width:8px;height:8px;border-radius:50%;display:block;background:var(--muted);}
	#cid-page .cid-pill.ok i{background:var(--cid-green);}
	#cid-page .cid-pill.wait i{background:var(--cid-amber);}
	#cid-page .cid-pill.info i{background:var(--red);}

	/* PASOS (cómo se pone en marcha) */
	#cid-page .cid-steps{display:grid;grid-template-columns:repeat(3,1fr);gap:22px;counter-reset:cid;}
	#cid-page .cid-step{background:#fff;border:1px solid var(--line);border-radius:var(--radius);padding:28px 24px;position:relative;transition:transform .18s ease,box-shadow .18s ease,border-color .18s ease;}
	#cid-page .cid-step:hover{transform:translateY(-2px);box-shadow:var(--shadow-md);border-color:#dcdce1;}
	#cid-page .cid-step .num{counter-increment:cid;width:38px;height:38px;border-radius:11px;background:var(--red-soft);color:var(--red-dark);font-family:'Manrope';font-weight:800;font-size:16px;display:grid;place-items:center;margin-bottom:18px;}
	#cid-page .cid-step .num::before{content:counter(cid);}
	#cid-page .cid-step h3{font-size:19px;font-weight:800;}
	#cid-page .cid-step p{color:var(--muted);font-size:15.5px;margin-top:10px;}
	#cid-page .cid-step code{font-size:13px;background:var(--bg-alt);border:1px solid var(--line);border-radius:6px;padding:2px 7px;color:var(--ink-strong);}

	/* FILAS ALTERNADAS (texto + captura) */
	#cid-page .cid-rows{display:flex;flex-direction:column;gap:60px;}
	#cid-page .cid-row{display:grid;grid-template-columns:1fr 1.15fr;gap:46px;align-items:center;}
	#cid-page .cid-row.reverse .cid-row-text{order:2;}
	#cid-page .cid-row.reverse .cid-row-media{order:1;}
	#cid-page .cid-row-text .cid-ic{width:52px;height:52px;border-radius:13px;background:var(--red-soft);display:grid;place-items:center;margin-bottom:18px;}
	#cid-page .cid-row-text .cid-ic svg{width:26px;height:26px;color:var(--red);}
	#cid-page .cid-row-text h3{font-size:clamp(20px,2.4vw,26px);font-weight:800;}
	#cid-page .cid-row-text p{color:var(--muted);font-size:16.5px;margin-top:14px;max-width:440px;}
	#cid-page .cid-row-text ul{list-style:none;margin-top:18px;display:flex;flex-direction:column;gap:10px;max-width:440px;}
	#cid-page .cid-row-text li{display:flex;gap:10px;align-items:flex-start;color:var(--ink);font-size:15.5px;}
	#cid-page .cid-row-text li svg{width:17px;height:17px;color:var(--cid-green);flex:none;margin-top:3px;}

	/* CAPTURAS EN REJILLA */
	#cid-page .cid-shots{display:grid;grid-template-columns:repeat(2,1fr);gap:26px;}
	#cid-page .cid-shot{margin:0;}
	#cid-page .cid-shot figcaption{margin-top:14px;font-family:'Manrope';font-weight:600;font-size:15px;color:var(--ink-strong);text-align:center;}

	/* TARJETA DE APARATO COMPATIBLE */
	#cid-page .cid-device{display:grid;grid-template-columns:1fr 1fr;gap:30px;align-items:center;background:#fff;border:1px solid var(--line);border-radius:20px;padding:38px;box-shadow:var(--shadow-sm);}
	#cid-page .cid-device h3{font-size:clamp(21px,2.4vw,27px);font-weight:800;}
	#cid-page .cid-device p{color:var(--muted);font-size:16.5px;margin-top:14px;}
	#cid-page .cid-device .cid-specs{display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-top:24px;}
	#cid-page .cid-device .cid-spec{background:var(--bg-alt);border:1px solid var(--line);border-radius:12px;padding:14px 16px;}
	#cid-page .cid-device .cid-spec b{display:block;font-family:'Manrope';font-weight:700;font-size:14px;color:var(--ink-strong);}
	#cid-page .cid-device .cid-spec span{font-size:13.5px;color:var(--muted);}
	#cid-page .cid-device .cid-link{display:inline-flex;align-items:center;gap:7px;margin-top:22px;font-family:'Manrope';font-weight:700;font-size:14.5px;color:var(--red-dark);}
	#cid-page .cid-device .cid-link svg{width:15px;height:15px;}

	@media (max-width:900px){
		#cid-page .cid-hero .hero-grid{grid-template-columns:1fr;gap:34px;padding:52px 0 56px;}
		#cid-page .cid-steps{grid-template-columns:1fr;}
		#cid-page .cid-shots{grid-template-columns:1fr;}
		#cid-page .cid-row{grid-template-columns:1fr;gap:22px;}
		#cid-page .cid-row.reverse .cid-row-text{order:0;}
		#cid-page .cid-row.reverse .cid-row-media{order:0;}
		#cid-page .cid-device{grid-template-columns:1fr;padding:28px 22px;gap:22px;}
		#cid-page .cid-device .cid-specs{grid-template-columns:1fr;}
	}
</style>

<div id="cid-page">

	<!-- HERO -->
	<section class="cid-hero">
		<div class="wrap">
			<div class="hero-grid">
				<div class="hero-copy">
					<span class="eyebrow"><span class="dot"></span> <?php echo esc_html( vlac_opt( 'cid_eyebrow', 'Control de Asistencia · Control iD' ) ); ?></span>
					<h1><?php echo wp_kses_post( vlac_opt( 'cid_title', 'El <span class="accent">marcaje</span> de tu personal, conectado a la <span class="accent">nómina</span>' ) ); ?></h1>
					<p class="lead"><?php echo esc_html( vlac_opt( 'cid_sub', 'Integramos el lector facial Control iD idFace con tu sistema: los usuarios se sincronizan solos, cada entrada y salida queda registrada, y las horas trabajadas se comparan con la jornada del contrato.' ) ); ?></p>
					<div class="hero-cta">
						<a class="btn btn-red btn-lg" href="<?php echo esc_url( vlac_cta_url( 'hero_cta1_url' ) ); ?>"><?php echo esc_html( vlac_opt( 'hero_cta1_txt', 'Prueba gratis' ) ); ?></a>
						<a class="btn btn-ghost" href="<?php echo esc_url( vlac_opt( 'hero_cta2_url', '#' ) ); ?>"><?php echo esc_html( vlac_opt( 'hero_cta2_txt', 'Ver una demo' ) ); ?></a>
					</div>
					<div class="cid-pills">
						<span class="cid-pill wait"><i></i> Pendientes</span>
						<span class="cid-pill info"><i></i> Nombre distinto</span>
						<span class="cid-pill ok"><i></i> Sincronizados</span>
					</div>
					<div class="hero-note">
						<svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
						Reconocimiento facial · Sin planillas en papel · Horas calculadas solas
					</div>
				</div>

				<div class="cid-visual">
					<?php
					$cid_hero_key  = vlac_opt( 'cid_img_hero' ) ? 'cid_img_hero' : 'cid_img_sync';
					$cid_hero_file = file_exists( $img_dir . 'cid-hero.png' ) ? 'cid-hero.png' : 'cid-sync.png';
					$cid_shot( $cid_hero_file, '', $cid_hero_key );
					?>
				</div>
			</div>
		</div>
	</section>

	<!-- CÓMO SE PONE EN MARCHA -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Puesta en marcha</div>
				<h2>Tres pasos y el aparato ya está trabajando</h2>
				<p>No hace falta instalar nada en una computadora: el lector consulta al sistema por su cuenta.</p>
			</div>

			<div class="cid-steps">
				<div class="cid-step">
					<div class="num"></div>
					<h3>Registra el aparato</h3>
					<p>Ponle un nombre («Entrada principal») y copia su <code>device_id</code> desde la pantalla del lector, en <b>Configuraciones → Sobre</b>.</p>
				</div>
				<div class="cid-step">
					<div class="num"></div>
					<h3>Pégale la configuración</h3>
					<p>El sistema te genera la dirección del servidor, el monitor y el <code>token</code>. La primera vez se deja a mano en el aparato; después se le puede escribir desde el sistema.</p>
				</div>
				<div class="cid-step">
					<div class="num"></div>
					<h3>Sincroniza a tu gente</h3>
					<p>Lee los usuarios que ya tiene el lector, compáralos con los del negocio y manda solo los que faltan. El aparato consulta cada 60 segundos y aplica los cambios.</p>
				</div>
			</div>
		</div>
	</section>

	<!-- SINCRONIZACIÓN Y APARATOS -->
	<section class="section">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Usuarios y aparatos</div>
				<h2>Los usuarios del sistema, dentro del lector</h2>
				<p>Un solo lugar para ver qué usuario ya está en el aparato, cuál falta y cuál cambió de nombre.</p>
			</div>

			<div class="cid-rows">
				<div class="cid-row">
					<div class="cid-row-text">
						<div class="cid-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M21 12a9 9 0 01-14.5 7M3 12a9 9 0 0114.5-7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/><path d="M3 20v-5h5M21 4v5h-5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
						<h3>Sincronizar usuarios</h3>
						<p>Compara lado a lado tu lista de usuarios con la del aparato y decide qué mandar.</p>
						<ul>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/></svg>Estados claros: pendiente, nombre distinto o sincronizado.</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/></svg>Selecciona varios y mándalos de una sola vez.</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/></svg>Cada fila muestra su resultado: en cola, ejecutando, aplicado o el error.</li>
						</ul>
					</div>
					<div class="cid-row-media"><?php $cid_shot( 'cid-sync.png', '', 'cid_img_sync' ); ?></div>
				</div>

				<div class="cid-row reverse">
					<div class="cid-row-text">
						<div class="cid-ic"><svg viewBox="0 0 24 24" fill="none"><rect x="4" y="3" width="16" height="18" rx="3" stroke="currentColor" stroke-width="1.7"/><circle cx="12" cy="10" r="3" stroke="currentColor" stroke-width="1.7"/><path d="M7 18a5 5 0 0110 0" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
						<h3>Tus aparatos, a la vista</h3>
						<p>Registra tantos lectores como puertas o sucursales tengas y revisa si están reportando.</p>
						<ul>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/></svg>Marca la hora del último evento recibido de cada aparato.</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/></svg>Token propio por aparato, que puedes regenerar cuando quieras.</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/></svg>La configuración del lector se le puede escribir desde el sistema.</li>
						</ul>
					</div>
					<div class="cid-row-media"><?php $cid_shot( 'cid-aparatos.png', '', 'cid_img_aparatos' ); ?></div>
				</div>
			</div>
		</div>
	</section>

	<!-- EL APARATO -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="cid-device">
				<div>
					<span class="eyebrow"><span class="dot"></span> <?php echo esc_html( vlac_opt( 'cid_dev_kicker', 'Aparato compatible' ) ); ?></span>
					<h3><?php echo esc_html( vlac_opt( 'cid_dev_title', 'Control iD idFace' ) ); ?></h3>
					<p><?php echo esc_html( vlac_opt( 'cid_dev_sub', 'Terminal de reconocimiento facial que identifica al trabajador en menos de un segundo. Se coloca en la entrada, alterna entrada y salida solo, y le avisa al sistema cada marcaje.' ) ); ?></p>
					<div class="cid-specs">
						<div class="cid-spec"><b>Reconocimiento facial</b><span>Sin contacto ni tarjetas</span></div>
						<div class="cid-spec"><b>Reporta en vivo</b><span>Cada marcaje llega al sistema</span></div>
						<div class="cid-spec"><b>Varias entradas</b><span>Un aparato por puerta o sucursal</span></div>
						<div class="cid-spec"><b>Sin PC de por medio</b><span>El lector consulta directo</span></div>
					</div>
					<a class="cid-link" href="<?php echo esc_url( vlac_opt( 'cid_dev_url', 'https://www.controlid.com.br/es/control-de-acceso/idface/' ) ); ?>" target="_blank" rel="noopener">
						Ficha del fabricante
						<svg viewBox="0 0 24 24" fill="none"><path d="M7 17L17 7M9 7h8v8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
					</a>
				</div>
				<div><?php $cid_video( 'controlid-marcaje', 'Video: marcaje en el aparato', 'Entrada registrada con la cara', 'cid_video_marcaje' ); ?></div>
			</div>
		</div>
	</section>

	<!-- HORARIOS Y NÓMINA -->
	<section class="section">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Del marcaje al pago</div>
				<h2>Cada entrada cuenta cuando toca pagar</h2>
				<p>Los marcajes alimentan la jornada del contrato y el cálculo de horas de la nómina.</p>
			</div>

			<div class="cid-rows">
				<div class="cid-row">
					<div class="cid-row-text">
						<div class="cid-ic"><svg viewBox="0 0 24 24" fill="none"><rect x="3" y="4" width="18" height="17" rx="2" stroke="currentColor" stroke-width="1.7"/><path d="M3 9h18M8 2v4M16 2v4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
						<h3>Registros de horario</h3>
						<p>Todos los marcajes con fecha, hora, trabajador y sucursal, filtrables por período, persona o entrada/salida.</p>
						<ul>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/></svg>El aparato alterna entrada y salida automáticamente.</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/></svg>¿Alguien marcó de más? Corrígelo a mano y queda señalado.</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/></svg>Filtra por sucursal cuando tienes varios lectores.</li>
						</ul>
					</div>
					<div class="cid-row-media"><?php $cid_shot( 'cid-registros.png', '', 'cid_img_registros' ); ?></div>
				</div>

				<div class="cid-row reverse">
					<div class="cid-row-text">
						<div class="cid-ic"><svg viewBox="0 0 24 24" fill="none"><rect x="4" y="3" width="16" height="18" rx="2" stroke="currentColor" stroke-width="1.7"/><path d="M8 8h8M8 12h8M8 16h5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
						<h3>Contrato con su jornada</h3>
						<p>Define sueldo, fechas, sucursal y el horario de cada día: entrada, salida, minutos de almuerzo y descansos.</p>
						<ul>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/></svg>Aplica el horario del lunes al resto de la semana en un clic.</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/></svg>Total de horas semanales calculado mientras escribes.</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/></svg>Marca los días de descanso y no se cuentan como falta.</li>
						</ul>
					</div>
					<div class="cid-row-media"><?php $cid_shot( 'cid-contrato.png', '', 'cid_img_contrato' ); ?></div>
				</div>

				<div class="cid-row">
					<div class="cid-row-text">
						<div class="cid-ic"><svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.7"/><path d="M12 7v5l3 2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
						<h3>Horas trabajadas en la nómina</h3>
						<p>Dentro del pago de cada trabajador ves día por día lo esperado, lo trabajado y la diferencia.</p>
						<ul>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/></svg>Avisa cuando faltan marcajes en un día y no se totaliza.</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/></svg>Calcula el valor de la hora y sugiere la multa por horas faltantes.</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/></svg>Convive con bonos, IGSS, multas, adelantos y comisiones.</li>
						</ul>
					</div>
					<div class="cid-row-media"><?php $cid_shot( 'cid-nomina.png', '', 'cid_img_nomina' ); ?></div>
				</div>
			</div>
		</div>
	</section>

	<!-- CAPACIDADES -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Todo lo que incluye</div>
				<h2>Asistencia y nómina, sin planillas a mano</h2>
			</div>
			<div class="feat-grid">
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><rect x="4" y="3" width="16" height="18" rx="3" stroke="currentColor" stroke-width="1.7"/><circle cx="12" cy="10" r="3" stroke="currentColor" stroke-width="1.7"/><path d="M7 18a5 5 0 0110 0" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
					<h3>Marcaje facial</h3>
					<p>Identificación sin contacto con el lector Control iD idFace.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M21 12a9 9 0 01-14.5 7M3 12a9 9 0 0114.5-7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/><path d="M3 20v-5h5M21 4v5h-5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Usuarios sincronizados</h3>
					<p>La misma lista del sistema, dentro del aparato.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M3 21V9l9-6 9 6v12M3 21h18M9 21v-6h6v6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Varias sucursales</h3>
					<p>Un lector por puerta y los marcajes separados por sucursal.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.7"/><path d="M12 7v5l3 2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Horas contra el contrato</h3>
					<p>Trabajadas, esperadas y la diferencia, día por día.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M4 20h16M6 16l8-8 3 3-8 8H6v-3z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Corrección a mano</h3>
					<p>Arregla un marcaje invertido y queda marcado como editado.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M12 1v22M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Bonos, IGSS y multas</h3>
					<p>Súmalos o réstalos al pago del período con su comprobante.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M6 3h9l3 3v15H6z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/><path d="M9 12l2 2 4-4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Recibos y historial</h3>
					<p>Adelantos y pagos con su recibo en PDF o térmica.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><circle cx="9" cy="8" r="4" stroke="currentColor" stroke-width="1.6"/><path d="M2 21a7 7 0 0114 0M16 11l2 2 4-4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Ligado al usuario</h3>
					<p>Mismo código de trabajador en el sistema y en el lector.</p>
				</div>
			</div>
		</div>
	</section>

	<!-- CTA -->
	<section class="section" style="padding-top:0;">
		<div class="wrap">
			<div class="cta-strip">
				<h2><?php echo esc_html( vlac_opt( 'cid_cta_title', 'Deja de contar horas a mano' ) ); ?></h2>
				<p><?php echo esc_html( vlac_opt( 'cid_cta_sub', 'Conecta tu lector Control iD, sincroniza a tu personal y que la nómina se calcule sola.' ) ); ?></p>
				<a class="btn btn-red btn-lg" href="<?php echo esc_url( vlac_cta_url( 'cta_btn_url' ) ); ?>"><?php echo esc_html( vlac_opt( 'hero_cta1_txt', 'Prueba gratis' ) ); ?></a>
			</div>
		</div>
	</section>

</div>

<?php
get_footer();
