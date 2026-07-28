<?php
/**
 * Template Name: Veterinarias
 *
 * Página de rubro para clínicas veterinarias y pet shops. Recorre el módulo
 * médico del sistema aplicado a mascotas: el dueño con sus mascotas, la ficha
 * de cada una (especie, raza, color, microchip, castrado, vacunado), el
 * historial de atendimientos, los formularios propios de la clínica, las
 * recetas, el control de vacunas con su próxima dosis, los archivos adjuntos
 * y el cobro con factura, incluida la venta de alimento y accesorios.
 *
 * Se aplica automáticamente a la página con slug «veterinarias»
 * (el menú del tema ya apunta a /industrias/veterinarias/), o puede asignarse
 * a mano desde Atributos de página → Plantilla.
 *
 * IMÁGENES (guárdalas en /assets/img/ con estos nombres exactos, o mejor
 * elígelas desde el Personalizador):
 *   vet-hero.png       → atendimiento de la mascota (va en el hero)
 *   vet-mascotas.png   → listado de mascotas del dueño
 *   vet-ficha.png      → ficha de la mascota (especie, raza, microchip)
 *   vet-vacunas.png    → registro de vacunas con próxima dosis
 *   vet-registrar.png  → alta de una mascota nueva
 *   vet-cuenta.png     → cobro de la consulta y de los productos
 *
 * VIDEOS (guárdalos en /assets/video/):
 *   consulta-veterinaria.mp4 → atender a la mascota, llenar el formulario y
 *                              registrar la vacuna con su próxima dosis
 * Mientras no existan, se muestra un marcador en su lugar.
 *
 * Los textos se editan en Apariencia → Personalizar → Contenido del sitio →
 * «Página Veterinarias».
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
$vet_shot = function ( $file, $opt_key = '', $alt = '' ) use ( $img, $img_dir ) {
	$url    = $opt_key ? vlac_opt( $opt_key ) : '';
	$exists = file_exists( $img_dir . $file );
	echo '<div class="vet-frame"><div class="bar"><i></i><i></i><i></i></div>';
	if ( $url ) {
		printf( '<img src="%s" alt="%s" loading="lazy" />', esc_url( $url ), esc_attr( $alt ) );
	} elseif ( $exists ) {
		printf( '<img src="%s" alt="%s" loading="lazy" />', esc_url( $img . '/' . $file ), esc_attr( $alt ) );
	} else {
		printf( '<div class="vet-ph vet-ph-img">Elige la imagen en <b>Personalizar → Página Veterinarias</b><br>o sube el archivo <code>assets/img/%s</code></div>', esc_html( $file ) );
	}
	echo '</div>';
};

// Renderiza un video autoplay. Prioridad:
//   1) El elegido en el Personalizador (Biblioteca de medios de WordPress).
//   2) El archivo en /assets/video/.
//   3) Un marcador con el nombre esperado.
$vet_video = function ( $base, $title, $sub, $opt_key = '' ) use ( $vid_dir, $vid_url ) {
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
	echo '<div class="vet-frame"><div class="bar"><i></i><i></i><i></i></div>';
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
		echo '<div class="vet-ph">';
		echo '<svg viewBox="0 0 24 24" fill="none"><path d="M4 5h16v14H4zM10 9l6 3-6 3V9z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>';
		printf( '<b>%s</b><span>%s</span>', esc_html( $title ), esc_html( $sub ) );
		printf( '<code>assets/video/%s.mp4</code>', esc_html( $base ) );
		echo '</div>';
	}
	echo '</div>';
};
?>

<style>
	/* Estilos de la página de Veterinarias (ámbito local). */
	#vet-page{--vet-green:#2e9e5b;--vet-slate:#5A6070;}

	/* HERO — la captura a la izquierda y el texto a la derecha */
	#vet-page .vet-hero{position:relative;overflow:hidden;}
	#vet-page .vet-hero::before{content:"";position:absolute;inset:0;z-index:0;background:radial-gradient(700px 400px at 12% 4%,rgba(193,39,45,.08),transparent 62%),linear-gradient(180deg,#fff,var(--bg-alt));}
	#vet-page .vet-hero .hero-grid{position:relative;z-index:1;display:grid;grid-template-columns:1.12fr 1fr;gap:52px;align-items:center;padding:64px 0 84px;}
	#vet-page .vet-hero .hero-copy{order:2;}
	#vet-page .vet-hero .hero-media{order:1;}
	#vet-page .vet-hero h1{font-size:clamp(32px,4.4vw,50px);font-weight:800;}
	#vet-page .vet-hero .lead{color:var(--muted);font-size:18px;margin:20px 0 0;max-width:520px;}
	#vet-page .vet-hero .hero-cta{display:flex;gap:14px;flex-wrap:wrap;margin-top:28px;}
	#vet-page .vet-hero .hero-note{display:flex;align-items:center;gap:8px;font-size:13.5px;color:var(--muted);margin-top:22px;}
	#vet-page .vet-hero .hero-note svg{width:16px;height:16px;color:var(--vet-green);flex-shrink:0;}

	/* Chips con los datos que lleva la ficha de la mascota */
	#vet-page .vet-chips{display:flex;flex-wrap:wrap;gap:9px;margin-top:22px;max-width:500px;}
	#vet-page .vet-chip{display:inline-flex;align-items:center;gap:7px;background:#fff;border:1px solid var(--line);border-radius:999px;padding:7px 14px;font-size:13.5px;font-family:'Manrope';font-weight:700;color:var(--ink-strong);box-shadow:var(--shadow-sm);}
	#vet-page .vet-chip i{width:7px;height:7px;border-radius:50%;background:var(--red);display:block;}

	/* MARCO (estilo navegador) para capturas y videos */
	#vet-page .vet-frame{background:#fff;border:1px solid #d9d9de;border-radius:14px;overflow:hidden;box-shadow:var(--shadow-md);}
	#vet-page .vet-hero .vet-frame{box-shadow:var(--shadow-lg);}
	#vet-page .vet-frame .bar{display:flex;align-items:center;gap:6px;padding:9px 12px;background:#f3f3f5;border-bottom:1px solid #e6e6ea;}
	#vet-page .vet-frame .bar i{width:10px;height:10px;border-radius:50%;background:#d6d6dc;display:block;}
	#vet-page .vet-frame video,#vet-page .vet-frame img{width:100%;height:auto;display:block;background:#000;}

	/* Marcador (placeholder) */
	#vet-page .vet-ph{aspect-ratio:16/10;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:10px;text-align:center;background:var(--bg-alt);color:var(--muted);padding:24px;font-size:14px;}
	#vet-page .vet-ph svg{width:46px;height:46px;color:#c9c9d0;}
	#vet-page .vet-ph b{font-family:'Manrope';font-weight:700;color:var(--ink-strong);font-size:15px;}
	#vet-page .vet-ph code{font-size:13px;color:var(--red-dark);background:var(--red-soft);padding:4px 10px;border-radius:6px;}
	#vet-page .vet-ph-img{aspect-ratio:auto;padding:52px 20px;}

	/* CADENA: dueño → mascotas → atendimientos */
	#vet-page .vet-chain{display:grid;grid-template-columns:repeat(3,1fr);gap:44px;}
	#vet-page .vet-link{position:relative;background:#fff;border:1px solid var(--line);border-radius:var(--radius);padding:28px 24px;text-align:center;transition:transform .18s ease,box-shadow .18s ease,border-color .18s ease;}
	#vet-page .vet-link:hover{transform:translateY(-4px);box-shadow:var(--shadow-md);border-color:#e0d0d0;}
	#vet-page .vet-link:not(:last-child)::after{content:"";position:absolute;right:-29px;top:50%;width:13px;height:13px;border-top:2px solid #dcc4c4;border-right:2px solid #dcc4c4;transform:translateY(-50%) rotate(45deg);}
	#vet-page .vet-link .ic{width:54px;height:54px;border-radius:15px;background:var(--red-soft);display:grid;place-items:center;margin:0 auto 16px;}
	#vet-page .vet-link .ic svg{width:27px;height:27px;color:var(--red);}
	#vet-page .vet-link b{display:block;font-family:'Manrope';font-weight:800;font-size:17.5px;color:var(--ink-strong);}
	#vet-page .vet-link p{color:var(--muted);font-size:14.5px;margin-top:8px;}

	/* FICHA — captura fija a la izquierda mientras avanzan los bloques */
	#vet-page .vet-sticky{display:grid;grid-template-columns:1.02fr .98fr;gap:52px;align-items:start;}
	#vet-page .vet-sticky-media{position:sticky;top:104px;}
	#vet-page .vet-blocks{display:flex;flex-direction:column;gap:20px;}
	#vet-page .vet-block{background:#fff;border:1px solid var(--line);border-radius:var(--radius);padding:22px 24px;display:flex;gap:16px;align-items:flex-start;transition:transform .18s ease,box-shadow .18s ease,border-color .18s ease;}
	#vet-page .vet-block:hover{transform:translateX(4px);box-shadow:var(--shadow-md);border-color:#e0d0d0;}
	#vet-page .vet-block .ic{width:44px;height:44px;border-radius:12px;background:var(--red-soft);display:grid;place-items:center;flex-shrink:0;}
	#vet-page .vet-block .ic svg{width:22px;height:22px;color:var(--red);}
	#vet-page .vet-block b{display:block;font-family:'Manrope';font-weight:700;font-size:16.5px;color:var(--ink-strong);}
	#vet-page .vet-block p{color:var(--muted);font-size:14.5px;margin-top:5px;}

	/* SPLIT (el medio siempre en la columna ancha) */
	#vet-page .vet-split{display:grid;grid-template-columns:1fr 1.3fr;gap:46px;align-items:center;}
	#vet-page .vet-split.rev{grid-template-columns:1.3fr 1fr;}
	#vet-page .vet-split.rev .vet-split-media{order:-1;}
	#vet-page .vet-split .ic{width:52px;height:52px;border-radius:13px;background:var(--red-soft);display:grid;place-items:center;margin-bottom:18px;}
	#vet-page .vet-split .ic svg{width:26px;height:26px;color:var(--red);}
	#vet-page .vet-split h3{font-size:clamp(20px,2.4vw,26px);font-weight:800;}
	#vet-page .vet-split p.txt{color:var(--muted);font-size:16.5px;margin-top:14px;max-width:430px;}
	#vet-page .vet-list{list-style:none;margin:18px 0 0;padding:0;display:flex;flex-direction:column;gap:10px;max-width:430px;}
	#vet-page .vet-list li{display:flex;align-items:flex-start;gap:10px;color:var(--ink-strong);font-size:15px;}
	#vet-page .vet-list li svg{width:19px;height:19px;color:var(--vet-green);flex-shrink:0;margin-top:1px;}

	/* EN ACCIÓN — texto angosto a un lado y el medio grande al otro */
	#vet-page .vet-steps{display:flex;flex-direction:column;gap:58px;}
	#vet-page .vet-step{display:grid;grid-template-columns:270px 1fr;gap:38px;align-items:center;}
	#vet-page .vet-step .num{display:inline-grid;place-items:center;width:34px;height:34px;border-radius:11px;background:var(--red-soft);color:var(--red-dark);font-family:'Manrope';font-weight:800;font-size:14px;margin-bottom:13px;}
	#vet-page .vet-step b{display:block;font-family:'Manrope';font-weight:800;font-size:19px;color:var(--ink-strong);}
	#vet-page .vet-step p{color:var(--muted);font-size:15px;margin-top:8px;}

	@media (max-width:980px){
		#vet-page .vet-chain{grid-template-columns:1fr;gap:20px;}
		#vet-page .vet-link:not(:last-child)::after{right:auto;left:50%;top:auto;bottom:-17px;transform:translateX(-50%) rotate(135deg);}
		#vet-page .vet-sticky{grid-template-columns:1fr;gap:30px;}
		#vet-page .vet-sticky-media{position:static;}
	}
	@media (max-width:900px){
		#vet-page .vet-hero .hero-grid{grid-template-columns:1fr;gap:32px;padding:50px 0 60px;}
		#vet-page .vet-hero .hero-copy{order:1;}
		#vet-page .vet-hero .hero-media{order:2;}
		#vet-page .vet-split,
		#vet-page .vet-split.rev{grid-template-columns:1fr;gap:24px;}
		#vet-page .vet-split.rev .vet-split-media{order:0;}
		#vet-page .vet-step{grid-template-columns:1fr;gap:18px;}
		#vet-page .vet-steps{gap:44px;}
	}
</style>

<div id="vet-page">

	<!-- HERO -->
	<section class="vet-hero">
		<div class="wrap">
			<div class="hero-grid">
				<div class="hero-copy">
					<span class="eyebrow"><span class="dot"></span> <?php echo esc_html( vlac_opt( 'vet_eyebrow', 'Veterinarias' ) ); ?></span>
					<h1><?php echo wp_kses_post( vlac_opt( 'vet_title', 'El sistema para tu <span class="accent">veterinaria</span>' ) ); ?></h1>
					<p class="lead"><?php echo esc_html( vlac_opt( 'vet_sub', 'Cada dueño con sus mascotas y cada mascota con su ficha, su historial, sus vacunas y sus recetas. Atiende, vende el alimento y factura desde el mismo lugar.' ) ); ?></p>

					<div class="vet-chips">
						<span class="vet-chip"><i></i>Especie</span>
						<span class="vet-chip"><i></i>Raza</span>
						<span class="vet-chip"><i></i>Color</span>
						<span class="vet-chip"><i></i>Edad</span>
						<span class="vet-chip"><i></i>Peso</span>
						<span class="vet-chip"><i></i>Microchip</span>
					</div>

					<div class="hero-cta">
						<a class="btn btn-red btn-lg" href="<?php echo esc_url( vlac_cta_url( 'hero_cta1_url' ) ); ?>"><?php echo esc_html( vlac_opt( 'hero_cta1_txt', 'Prueba gratis' ) ); ?></a>
						<a class="btn btn-ghost" href="<?php echo esc_url( vlac_opt( 'hero_cta2_url', '#' ) ); ?>"><?php echo esc_html( vlac_opt( 'hero_cta2_txt', 'Ver una demo' ) ); ?></a>
					</div>
					<div class="hero-note">
						<svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
						Ficha por mascota · Vacunas · Recetas · Tienda y facturación
					</div>
				</div>

				<div class="hero-media"><?php $vet_shot( 'vet-hero.png', 'vet_img_hero', 'Atendimiento de la mascota' ); ?></div>
			</div>
		</div>
	</section>

	<!-- CÓMO SE ORGANIZA -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Cómo se organiza</div>
				<h2>El dueño, sus mascotas y cada atención</h2>
				<p>Un cliente puede traer al perro hoy y al gato la próxima semana. Cada mascota lleva su propio historial, pero la cuenta es del mismo dueño.</p>
			</div>

			<div class="vet-chain">
				<div class="vet-link">
					<div class="ic"><svg viewBox="0 0 24 24" fill="none"><path d="M12 12a4 4 0 100-8 4 4 0 000 8zM4 21a8 8 0 0116 0" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
					<b>El dueño</b>
					<p>Su nombre, su NIT, su teléfono y su correo. Es el cliente al que se le factura.</p>
				</div>
				<div class="vet-link">
					<div class="ic"><svg viewBox="0 0 24 24" fill="none"><path d="M6.5 10a1.8 1.8 0 100-3.6 1.8 1.8 0 000 3.6zM17.5 10a1.8 1.8 0 100-3.6 1.8 1.8 0 000 3.6zM9.5 6.4a1.8 1.8 0 100-3.6 1.8 1.8 0 000 3.6zM14.5 6.4a1.8 1.8 0 100-3.6 1.8 1.8 0 000 3.6z" stroke="currentColor" stroke-width="1.5"/><path d="M12 12.5c2.6 0 4.6 2 4.6 4.3 0 1.7-1.2 2.9-2.8 2.9-.9 0-1.3-.4-1.8-.4s-.9.4-1.8.4c-1.6 0-2.8-1.2-2.8-2.9 0-2.3 2-4.3 4.6-4.3z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/></svg></div>
					<b>Sus mascotas</b>
					<p>Cada una con su foto, su especie, su raza y sus datos. Las que quieras por cliente.</p>
				</div>
				<div class="vet-link">
					<div class="ic"><svg viewBox="0 0 24 24" fill="none"><path d="M6 3h9l4 4v14H6z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M9 12h7M9 16h5M9 8h4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
					<b>Sus atendimientos</b>
					<p>Consultas, vacunas, recetas y archivos, guardados en el historial de esa mascota.</p>
				</div>
			</div>
		</div>
	</section>

	<!-- LA FICHA DE LA MASCOTA -->
	<section class="section">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Ficha de la mascota</div>
				<h2>Todo lo de cada paciente, en una sola pantalla</h2>
				<p>Abres la mascota y ahí está lo que necesitas saber antes de atenderla.</p>
			</div>

			<div class="vet-sticky">
				<div class="vet-sticky-media"><?php $vet_shot( 'vet-ficha.png', 'vet_img_ficha', 'Ficha de la mascota' ); ?></div>

				<div class="vet-blocks">
					<div class="vet-block">
						<div class="ic"><svg viewBox="0 0 24 24" fill="none"><rect x="4" y="4" width="16" height="16" rx="3" stroke="currentColor" stroke-width="1.6"/><path d="M8 9h8M8 13h6M8 17h4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
						<div>
							<b>Los datos de la mascota</b>
							<p>Especie, raza, color, edad, peso y número de microchip, más si está castrada y si está vacunada.</p>
						</div>
					</div>
					<div class="vet-block">
						<div class="ic"><svg viewBox="0 0 24 24" fill="none"><path d="M12 8v4l3 2" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/></svg></div>
						<div>
							<b>Historial de atendimientos</b>
							<p>La lista de todas sus visitas por fecha, con el motivo y el veterinario que la atendió.</p>
						</div>
					</div>
					<div class="vet-block">
						<div class="ic"><svg viewBox="0 0 24 24" fill="none"><path d="M14 4l6 6M11 7l6 6M4 20l3-1 9-9-4-4-9 9-1 3z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
						<div>
							<b>Carné de vacunas</b>
							<p>Qué vacuna se aplicó, en qué dosis, cuándo, y en qué fecha toca la siguiente.</p>
						</div>
					</div>
					<div class="vet-block">
						<div class="ic"><svg viewBox="0 0 24 24" fill="none"><rect x="4" y="3" width="16" height="18" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="M8 9h8M8 13h6M8 17h4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
						<div>
							<b>Recetas y notas</b>
							<p>Lo recetado en cada visita con sus indicaciones, impreso con el logo de tu veterinaria.</p>
						</div>
					</div>
					<div class="vet-block">
						<div class="ic"><svg viewBox="0 0 24 24" fill="none"><path d="M14 3v5h5M14 3H6v18h12V8l-4-5z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M9 13h6M9 17h4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
						<div>
							<b>Exámenes y archivos</b>
							<p>Radiografías, resultados de laboratorio y cualquier documento, adjuntos a la consulta.</p>
						</div>
					</div>
					<div class="vet-block">
						<div class="ic"><svg viewBox="0 0 24 24" fill="none"><rect x="3" y="4" width="18" height="16" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="M7 9h6M7 13h10M7 17h4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
						<div>
							<b>Formularios propios</b>
							<p>Las preguntas que hace tu veterinaria, no las de otra: tú defines los campos de cada consulta.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- MASCOTAS DEL DUEÑO -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="vet-split rev">
				<div class="vet-split-text">
					<div class="ic"><svg viewBox="0 0 24 24" fill="none"><path d="M9 11a3 3 0 100-6 3 3 0 000 6zM3 20a6 6 0 0112 0M17 8a2.5 2.5 0 100-5M18 20a5 5 0 00-3-4.6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg></div>
					<h3>Varias mascotas por cliente</h3>
					<p class="txt">Del lado del dueño ves todas sus mascotas con su foto, su raza y su edad. Cambias de una a otra con un clic y el historial que aparece es siempre el de la mascota seleccionada.</p>
					<ul class="vet-list">
						<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Sin límite de mascotas por dueño</li>
						<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Foto y edad calculada de cada una</li>
						<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Agregas una mascota nueva sin salir de la atención</li>
					</ul>
				</div>
				<div class="vet-split-media"><?php $vet_shot( 'vet-mascotas.png', 'vet_img_mascotas', 'Mascotas del dueño' ); ?></div>
			</div>
		</div>
	</section>

	<!-- VACUNAS -->
	<section class="section">
		<div class="wrap">
			<div class="vet-split">
				<div class="vet-split-text">
					<div class="ic"><svg viewBox="0 0 24 24" fill="none"><path d="M14 4l6 6M11 7l6 6M8 10l6 6M4 20l3-1 9-9-4-4-9 9-1 3z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Vacunas y refuerzos que no se pasan</h3>
					<p class="txt">Registras la vacuna aplicada con su dosis y su fecha, y dejas anotada la fecha del refuerzo. El carné queda en la ficha, listo para consultarlo o imprimirlo cuando el dueño lo pida.</p>
					<ul class="vet-list">
						<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Vacuna, dosis y fecha de aplicación</li>
						<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Fecha de la próxima dosis y observaciones</li>
						<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Queda amarrada a la consulta en la que se aplicó</li>
					</ul>
				</div>
				<div class="vet-split-media"><?php $vet_shot( 'vet-vacunas.png', 'vet_img_vacunas', 'Registro de vacunas' ); ?></div>
			</div>
		</div>
	</section>

	<!-- EN ACCIÓN -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">En acción</div>
				<h2>Así se atiende a una mascota</h2>
				<p>Del alta del paciente a la consulta con su vacuna registrada en el carné.</p>
			</div>

			<div class="vet-steps">
				<div class="vet-step">
					<div class="vet-step-text">
						<span class="num">1</span>
						<b>Dar de alta a la mascota</b>
						<p>Nombre, foto, especie, raza, color, fecha de nacimiento y microchip. Queda ligada a su dueño.</p>
					</div>
					<div class="vet-step-media"><?php $vet_shot( 'vet-registrar.png', 'vet_img_registrar', 'Alta de una mascota' ); ?></div>
				</div>

				<div class="vet-step">
					<div class="vet-step-text">
						<span class="num">2</span>
						<b>Atender la consulta y registrar la vacuna</b>
						<p>Inicias la atención, llenas el formulario de tu veterinaria, dejas la nota de lo observado y anotas la vacuna con su dosis y la fecha del refuerzo, que se suma al carné de la mascota.</p>
					</div>
					<div class="vet-step-media"><?php $vet_video( 'consulta-veterinaria', 'Video: atender a la mascota', 'Consulta, nota y vacuna', 'vet_video_consulta' ); ?></div>
				</div>
			</div>
		</div>
	</section>

	<!-- TIENDA Y COBRO -->
	<section class="section">
		<div class="wrap">
			<div class="vet-split rev">
				<div class="vet-split-text">
					<div class="ic"><svg viewBox="0 0 24 24" fill="none"><path d="M3 5h2l2.4 10.2a2 2 0 002 1.6h7.6a2 2 0 002-1.6L21 8H6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><circle cx="10" cy="20" r="1.4" stroke="currentColor" stroke-width="1.5"/><circle cx="17" cy="20" r="1.4" stroke="currentColor" stroke-width="1.5"/></svg></div>
					<h3>La consulta y la tienda, en la misma cuenta</h3>
					<p class="txt">La mayoría de veterinarias también venden alimento, medicina y accesorios. La consulta, el desparasitante y el saco de comida salen en un solo cobro, y lo que entregas descuenta del inventario.</p>
					<ul class="vet-list">
						<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Consulta, procedimientos y productos en la misma orden</li>
						<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Alimento y medicina descontados del inventario</li>
						<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Factura electrónica al dueño, en hoja completa o térmica</li>
						<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Total pagado y total pendiente por cliente</li>
					</ul>
				</div>
				<div class="vet-split-media"><?php $vet_shot( 'vet-cuenta.png', 'vet_img_cuenta', 'Cobro de la consulta y los productos' ); ?></div>
			</div>
		</div>
	</section>

	<!-- CAPACIDADES -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Todo lo que incluye</div>
				<h2>Pensado para el día a día de tu veterinaria</h2>
			</div>
			<div class="feat-grid">
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M6.5 10a1.8 1.8 0 100-3.6 1.8 1.8 0 000 3.6zM17.5 10a1.8 1.8 0 100-3.6 1.8 1.8 0 000 3.6zM9.5 6.4a1.8 1.8 0 100-3.6 1.8 1.8 0 000 3.6zM14.5 6.4a1.8 1.8 0 100-3.6 1.8 1.8 0 000 3.6z" stroke="currentColor" stroke-width="1.5"/><path d="M12 12.5c2.6 0 4.6 2 4.6 4.3 0 1.7-1.2 2.9-2.8 2.9-.9 0-1.3-.4-1.8-.4s-.9.4-1.8.4c-1.6 0-2.8-1.2-2.8-2.9 0-2.3 2-4.3 4.6-4.3z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/></svg></div>
					<h3>Ficha por mascota</h3>
					<p>Especie, raza, color, peso, microchip y estado.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><rect x="3" y="5" width="18" height="16" rx="2" stroke="currentColor" stroke-width="1.7"/><path d="M3 10h18M8 3v4M16 3v4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
					<h3>Agenda de citas</h3>
					<p>Cada veterinario con su propia agenda y horarios.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M14 4l6 6M11 7l6 6M4 20l3-1 9-9-4-4-9 9-1 3z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Carné de vacunas</h3>
					<p>Dosis aplicada y fecha del próximo refuerzo.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><rect x="4" y="3" width="16" height="18" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="M8 9h8M8 13h6M8 17h4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
					<h3>Recetas</h3>
					<p>Con tu logo, sin logo o con plantilla propia.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M12 3l8 4.5v9L12 21l-8-4.5v-9L12 3zm0 0v18M4 7.5l8 4.5 8-4.5" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/></svg></div>
					<h3>Inventario y farmacia</h3>
					<p>Alimento, medicina y accesorios siempre cuadrados.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M6 3h9l4 4v14H6z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M9 12h7M9 16h5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
					<h3>Facturación electrónica</h3>
					<p>La cuenta del dueño, facturada al instante.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M12 8v4l3 2" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/></svg></div>
					<h3>Duración de la atención</h3>
					<p>Cronómetro desde que inicia hasta que finaliza.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M4 19V5M4 19h16M8 16l3-4 3 2 4-6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Informes</h3>
					<p>Atenciones, ingresos y pendientes por período.</p>
				</div>
			</div>
		</div>
	</section>

	<!-- CTA -->
	<section class="section">
		<div class="wrap">
			<div class="cta-strip">
				<h2><?php echo esc_html( vlac_opt( 'vet_cta_title', 'Ordena tu veterinaria y cuida mejor a cada paciente' ) ); ?></h2>
				<p><?php echo esc_html( vlac_opt( 'vet_cta_sub', 'Fichas, historial, vacunas, recetas, inventario y facturación en un solo sistema conectado.' ) ); ?></p>
				<a class="btn btn-red btn-lg" href="<?php echo esc_url( vlac_cta_url( 'cta_btn_url' ) ); ?>"><?php echo esc_html( vlac_opt( 'hero_cta1_txt', 'Prueba gratis' ) ); ?></a>
			</div>
		</div>
	</section>

</div>

<?php
get_footer();
