<?php
/**
 * Template Name: Clínicas y Hospitales
 *
 * Página de rubro para clínicas, consultorios y hospitales. Recorre el módulo
 * médico del sistema: la agenda de citas con sus estados, la consulta con su
 * cronómetro, el expediente del paciente y sus dependientes, los formularios
 * configurables, las notas y recetas, el control de vacunas, los archivos
 * adjuntos, los convenios con seguros y el cobro con factura.
 *
 * Se aplica automáticamente a la página con slug «clinicas-y-hospitales»
 * (el menú del tema ya apunta a /industrias/clinicas-y-hospitales/), o puede
 * asignarse a mano desde Atributos de página → Plantilla.
 *
 * IMÁGENES (guárdalas en /assets/img/ con estos nombres exactos, o mejor
 * elígelas desde el Personalizador):
 *   cli-agenda.png      → agenda de citas del día (va en el hero)
 *   cli-expediente.png  → historial médico del paciente
 *   cli-formulario.png  → formulario configurable de la consulta
 *   cli-preguntas.png   → listado de preguntas del formulario
 *   cli-receta.png      → nota o receta lista para imprimir
 *   cli-cuenta.png      → cobro de la consulta con sus procedimientos
 *   cli-agendar.png     → diálogo de nueva consulta (agendar una cita)
 *
 * VIDEOS (guárdalos en /assets/video/):
 *   consulta-medica.mp4 → iniciar la consulta y llenar el formulario
 *   receta-medica.mp4   → emitir una receta e imprimirla
 * Mientras no existan, se muestra un marcador en su lugar.
 *
 * Los textos se editan en Apariencia → Personalizar → Contenido del sitio →
 * «Página Clínicas y Hospitales».
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
$cli_shot = function ( $file, $opt_key = '', $alt = '' ) use ( $img, $img_dir ) {
	$url    = $opt_key ? vlac_opt( $opt_key ) : '';
	$exists = file_exists( $img_dir . $file );
	echo '<div class="cli-frame"><div class="bar"><i></i><i></i><i></i></div>';
	if ( $url ) {
		printf( '<img src="%s" alt="%s" loading="lazy" />', esc_url( $url ), esc_attr( $alt ) );
	} elseif ( $exists ) {
		printf( '<img src="%s" alt="%s" loading="lazy" />', esc_url( $img . '/' . $file ), esc_attr( $alt ) );
	} else {
		printf( '<div class="cli-ph cli-ph-img">Elige la imagen en <b>Personalizar → Página Clínicas y Hospitales</b><br>o sube el archivo <code>assets/img/%s</code></div>', esc_html( $file ) );
	}
	echo '</div>';
};

// Renderiza un video autoplay. Prioridad:
//   1) El elegido en el Personalizador (Biblioteca de medios de WordPress).
//   2) El archivo en /assets/video/.
//   3) Un marcador con el nombre esperado.
$cli_video = function ( $base, $title, $sub, $opt_key = '' ) use ( $vid_dir, $vid_url ) {
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
	echo '<div class="cli-frame"><div class="bar"><i></i><i></i><i></i></div>';
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
		echo '<div class="cli-ph">';
		echo '<svg viewBox="0 0 24 24" fill="none"><path d="M4 5h16v14H4zM10 9l6 3-6 3V9z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>';
		printf( '<b>%s</b><span>%s</span>', esc_html( $title ), esc_html( $sub ) );
		printf( '<code>assets/video/%s.mp4</code>', esc_html( $base ) );
		echo '</div>';
	}
	echo '</div>';
};
?>

<style>
	/* Estilos de la página de Clínicas y Hospitales (ámbito local). */
	#cli-page{--cli-green:#2e9e5b;--cli-slate:#5A6070;}

	/* HERO CENTRADO — a diferencia de las otras páginas de rubro, aquí el
	   texto va centrado y la captura ocupa todo el ancho debajo. */
	#cli-page .cli-hero{position:relative;overflow:hidden;}
	#cli-page .cli-hero::before{content:"";position:absolute;inset:0;z-index:0;background:radial-gradient(680px 420px at 50% -6%,rgba(193,39,45,.09),transparent 62%),linear-gradient(180deg,#fff,var(--bg-alt));}
	#cli-page .cli-hero .inner{position:relative;z-index:1;padding:62px 0 88px;text-align:center;}
	#cli-page .cli-hero h1{font-size:clamp(32px,4.4vw,50px);font-weight:800;max-width:830px;margin:0 auto;}
	#cli-page .cli-hero .lead{color:var(--muted);font-size:18px;margin:22px auto 0;max-width:620px;}
	#cli-page .cli-hero .hero-cta{display:flex;gap:14px;flex-wrap:wrap;justify-content:center;margin-top:30px;}
	#cli-page .cli-hero .hero-note{display:flex;align-items:center;justify-content:center;gap:8px;font-size:13.5px;color:var(--muted);margin-top:22px;flex-wrap:wrap;}
	#cli-page .cli-hero .hero-note svg{width:16px;height:16px;color:var(--cli-green);flex-shrink:0;}

	/* Escenario del hero: la captura de la agenda a todo lo ancho */
	#cli-page .cli-stage{position:relative;max-width:960px;margin:52px auto 0;}

	/* MARCO (estilo navegador) para capturas y videos */
	#cli-page .cli-frame{background:#fff;border:1px solid #d9d9de;border-radius:14px;overflow:hidden;box-shadow:var(--shadow-md);}
	#cli-page .cli-stage .cli-frame{box-shadow:var(--shadow-lg);}
	#cli-page .cli-frame .bar{display:flex;align-items:center;gap:6px;padding:9px 12px;background:#f3f3f5;border-bottom:1px solid #e6e6ea;}
	#cli-page .cli-frame .bar i{width:10px;height:10px;border-radius:50%;background:#d6d6dc;display:block;}
	#cli-page .cli-frame video,#cli-page .cli-frame img{width:100%;height:auto;display:block;background:#000;}

	/* Marcador (placeholder) */
	#cli-page .cli-ph{aspect-ratio:16/10;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:10px;text-align:center;background:var(--bg-alt);color:var(--muted);padding:24px;font-size:14px;}
	#cli-page .cli-ph svg{width:46px;height:46px;color:#c9c9d0;}
	#cli-page .cli-ph b{font-family:'Manrope';font-weight:700;color:var(--ink-strong);font-size:15px;}
	#cli-page .cli-ph code{font-size:13px;color:var(--red-dark);background:var(--red-soft);padding:4px 10px;border-radius:6px;}
	#cli-page .cli-ph-img{aspect-ratio:auto;padding:56px 20px;}

	/* RECORRIDO DEL PACIENTE — línea de tiempo vertical con título fijo */
	#cli-page .cli-flow{display:grid;grid-template-columns:.9fr 1.1fr;gap:52px;align-items:start;}
	#cli-page .cli-flow-head{position:sticky;top:104px;}
	#cli-page .cli-flow-head h2{font-size:clamp(28px,3.4vw,40px);font-weight:800;}
	#cli-page .cli-flow-head p{color:var(--muted);font-size:17px;margin-top:14px;max-width:400px;}
	#cli-page .cli-steps{position:relative;padding-left:38px;}
	#cli-page .cli-steps::before{content:"";position:absolute;left:12px;top:8px;bottom:8px;width:2px;background:linear-gradient(180deg,var(--red),#e8cccc);border-radius:2px;}
	#cli-page .cli-step{position:relative;padding-bottom:34px;}
	#cli-page .cli-step:last-child{padding-bottom:0;}
	#cli-page .cli-step .dot{position:absolute;left:-38px;top:1px;width:26px;height:26px;border-radius:50%;background:#fff;border:2px solid var(--red);display:grid;place-items:center;font-family:'Manrope';font-weight:800;font-size:11.5px;color:var(--red);}
	#cli-page .cli-step b{display:block;font-family:'Manrope';font-weight:800;font-size:18px;color:var(--ink-strong);}
	#cli-page .cli-step p{color:var(--muted);font-size:15.5px;margin-top:7px;max-width:470px;}
	#cli-page .cli-step .tags{display:flex;flex-wrap:wrap;gap:7px;margin-top:11px;}
	#cli-page .cli-step .tags span{font-family:'Manrope';font-weight:700;font-size:11.5px;color:var(--cli-slate);background:#fff;border:1px solid var(--line);border-radius:999px;padding:4px 11px;}

	/* BENTO — el expediente */
	#cli-page .cli-bento{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;}
	#cli-page .cli-cell{background:#fff;border:1px solid var(--line);border-radius:var(--radius);padding:24px 22px;transition:transform .18s ease,box-shadow .18s ease,border-color .18s ease;}
	#cli-page .cli-cell:hover{transform:translateY(-4px);box-shadow:var(--shadow-md);border-color:#e0d0d0;}
	#cli-page .cli-cell .ic{width:46px;height:46px;border-radius:12px;background:var(--red-soft);display:grid;place-items:center;margin-bottom:15px;}
	#cli-page .cli-cell .ic svg{width:23px;height:23px;color:var(--red);}
	#cli-page .cli-cell h3{font-size:16.5px;font-weight:700;margin-bottom:6px;}
	#cli-page .cli-cell p{color:var(--muted);font-size:14px;}
	#cli-page .cli-cell.big{grid-column:span 2;grid-row:span 2;display:flex;flex-direction:column;gap:18px;}
	#cli-page .cli-cell.big:hover{transform:none;}
	#cli-page .cli-cell.big h3{font-size:clamp(20px,2.3vw,26px);font-weight:800;}
	#cli-page .cli-cell.big p{font-size:15.5px;max-width:460px;}
	#cli-page .cli-cell.big .med{margin-top:auto;}

	/* SPLIT genérico (el medio siempre en la columna ancha) */
	#cli-page .cli-split{display:grid;grid-template-columns:1fr 1.15fr;gap:46px;align-items:center;}
	#cli-page .cli-split.rev{grid-template-columns:1.15fr 1fr;}
	#cli-page .cli-split.rev .cli-split-media{order:-1;}
	#cli-page .cli-split h3{font-size:clamp(20px,2.4vw,26px);font-weight:800;}
	#cli-page .cli-split p.txt{color:var(--muted);font-size:16.5px;margin-top:14px;max-width:450px;}
	#cli-page .cli-split .ic{width:52px;height:52px;border-radius:13px;background:var(--red-soft);display:grid;place-items:center;margin-bottom:18px;}
	#cli-page .cli-split .ic svg{width:26px;height:26px;color:var(--red);}
	#cli-page .cli-list{list-style:none;margin:18px 0 0;padding:0;display:flex;flex-direction:column;gap:10px;max-width:450px;}
	#cli-page .cli-list li{display:flex;align-items:flex-start;gap:10px;color:var(--ink-strong);font-size:15px;}
	#cli-page .cli-list li svg{width:19px;height:19px;color:var(--cli-green);flex-shrink:0;margin-top:1px;}

	/* Captura secundaria dentro de la columna de texto */
	#cli-page .cli-inline-shot{margin-top:24px;max-width:430px;}

	/* EN ACCIÓN — capturas y videos a lo ancho, uno debajo del otro, con su
	   título numerado arriba. Apilados se leen; en columnas no se veía nada. */
	#cli-page .cli-media-list{display:flex;flex-direction:column;gap:54px;max-width:940px;margin:0 auto;}
	#cli-page .cli-media-item .cap{display:flex;align-items:flex-start;gap:14px;margin-bottom:16px;}
	#cli-page .cli-media-item .num{width:32px;height:32px;border-radius:10px;background:var(--red-soft);color:var(--red-dark);display:grid;place-items:center;font-family:'Manrope';font-weight:800;font-size:13.5px;flex-shrink:0;}
	#cli-page .cli-media-item .cap b{display:block;font-family:'Manrope';font-weight:800;font-size:19px;color:var(--ink-strong);}
	#cli-page .cli-media-item .cap span{display:block;color:var(--muted);font-size:15px;margin-top:2px;}

	/* CAPACIDADES en dos columnas de lista */
	#cli-page .cli-caps{display:grid;grid-template-columns:repeat(2,1fr);gap:0 46px;}
	#cli-page .cli-cap{display:flex;align-items:flex-start;gap:15px;padding:19px 0;border-top:1px solid var(--line);}
	#cli-page .cli-cap .ic{width:42px;height:42px;border-radius:12px;background:var(--red-soft);display:grid;place-items:center;flex-shrink:0;}
	#cli-page .cli-cap .ic svg{width:21px;height:21px;color:var(--red);}
	#cli-page .cli-cap b{display:block;font-family:'Manrope';font-weight:700;font-size:15.5px;color:var(--ink-strong);}
	#cli-page .cli-cap p{color:var(--muted);font-size:14px;margin-top:3px;}

	@media (max-width:980px){
		#cli-page .cli-flow{grid-template-columns:1fr;gap:30px;}
		#cli-page .cli-flow-head{position:static;}
		#cli-page .cli-bento{grid-template-columns:repeat(2,1fr);}
		#cli-page .cli-cell.big{grid-column:span 2;grid-row:auto;}
		#cli-page .cli-media-list{gap:42px;}
	}
	@media (max-width:900px){
		#cli-page .cli-split,
		#cli-page .cli-split.rev{grid-template-columns:1fr;gap:24px;}
		#cli-page .cli-split.rev .cli-split-media{order:0;}
		#cli-page .cli-inline-shot{max-width:none;}
	}
	@media (max-width:640px){
		#cli-page .cli-hero .inner{padding:48px 0 62px;}
		#cli-page .cli-stage{margin-top:34px;}
		#cli-page .cli-bento{grid-template-columns:1fr;}
		#cli-page .cli-cell.big{grid-column:auto;}
		#cli-page .cli-caps{grid-template-columns:1fr;}
	}
</style>

<div id="cli-page">

	<!-- HERO -->
	<section class="cli-hero">
		<div class="wrap">
			<div class="inner">
				<span class="eyebrow"><span class="dot"></span> <?php echo esc_html( vlac_opt( 'cli_eyebrow', 'Clínicas y Hospitales' ) ); ?></span>
				<h1><?php echo wp_kses_post( vlac_opt( 'cli_title', 'El sistema para tu <span class="accent">clínica</span> u <span class="accent">hospital</span>' ) ); ?></h1>
				<p class="lead"><?php echo esc_html( vlac_opt( 'cli_sub', 'Agenda las citas, atiende la consulta con tus propios formularios, emite recetas y guarda todo en el expediente del paciente, con el cobro y la factura en el mismo lugar.' ) ); ?></p>
				<div class="hero-cta">
					<a class="btn btn-red btn-lg" href="<?php echo esc_url( vlac_cta_url( 'hero_cta1_url' ) ); ?>"><?php echo esc_html( vlac_opt( 'hero_cta1_txt', 'Prueba gratis' ) ); ?></a>
					<a class="btn btn-ghost" href="<?php echo esc_url( vlac_opt( 'hero_cta2_url', '#' ) ); ?>"><?php echo esc_html( vlac_opt( 'hero_cta2_txt', 'Ver una demo' ) ); ?></a>
				</div>
				<div class="hero-note">
					<svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
					Agenda · Expediente · Recetas · Vacunas · Facturación
				</div>

				<div class="cli-stage">
					<?php $cli_shot( 'cli-agenda.png', 'cli_img_agenda', 'Agenda de citas' ); ?>
				</div>
			</div>
		</div>
	</section>

	<!-- RECORRIDO DEL PACIENTE -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="cli-flow">
				<div class="cli-flow-head">
					<div class="sec-kicker">De la cita al expediente</div>
					<h2>Toda la atención, en un solo recorrido</h2>
					<p>El paciente entra por la agenda y sale con su receta y su factura. Nada queda en un cuaderno aparte.</p>
				</div>

				<div class="cli-steps">
					<div class="cli-step">
						<span class="dot">1</span>
						<b>Se agenda la cita</b>
						<p>Eliges al paciente, al doctor y la hora. La cita queda en la agenda de esa sucursal, con recordatorio y aviso al llegar el día.</p>
						<div class="tags"><span>Por doctor</span><span>Por sucursal</span><span>Con recordatorio</span></div>
					</div>
					<div class="cli-step">
						<span class="dot">2</span>
						<b>Llega el paciente y se inicia la consulta</b>
						<p>La cita pasa de agendada a iniciada y arranca el cronómetro, así sabes cuánto duró realmente cada atención.</p>
						<div class="tags"><span>Agendado</span><span>Iniciado</span><span>Finalizado</span></div>
					</div>
					<div class="cli-step">
						<span class="dot">3</span>
						<b>Se llena el formulario de la consulta</b>
						<p>Los campos son los que tu clínica definió: motivo, signos, diagnóstico, lo que necesites. Se guardan como parte del expediente.</p>
						<div class="tags"><span>Formularios propios</span><span>Archivos adjuntos</span></div>
					</div>
					<div class="cli-step">
						<span class="dot">4</span>
						<b>Receta, notas y vacunas</b>
						<p>Emites la receta con sus indicaciones, dejas notas de la consulta y registras la vacuna aplicada con su próxima dosis.</p>
						<div class="tags"><span>Receta impresa</span><span>Orientaciones</span><span>Próxima dosis</span></div>
					</div>
					<div class="cli-step">
						<span class="dot">5</span>
						<b>Cobro y factura</b>
						<p>La consulta lleva sus procedimientos, medicamentos y productos. Aplicas el convenio del seguro, cobras y facturas al momento.</p>
						<div class="tags"><span>Procedimientos</span><span>Convenios</span><span>Factura</span></div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- EXPEDIENTE (BENTO) -->
	<section class="section">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Expediente del paciente</div>
				<h2>Todo el historial, en la misma ficha</h2>
				<p>Cada paciente con sus consultas, sus recetas, sus vacunas y sus archivos, disponibles la próxima vez que entre por la puerta.</p>
			</div>

			<div class="cli-bento">
				<div class="cli-cell big">
					<div>
						<div class="ic"><svg viewBox="0 0 24 24" fill="none"><path d="M6 3h9l4 4v14H6z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M9 12h7M9 16h5M9 8h4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
						<h3>Historial médico completo</h3>
						<p>Abre la ficha del paciente y ahí está todo lo anterior: qué consultas tuvo, qué se le recetó, qué vacunas lleva y qué documentos se adjuntaron, ordenado por fecha.</p>
					</div>
					<div class="med"><?php $cli_shot( 'cli-expediente.png', 'cli_img_expediente', 'Historial médico del paciente' ); ?></div>
				</div>

				<div class="cli-cell">
					<div class="ic"><svg viewBox="0 0 24 24" fill="none"><path d="M8 3h8a2 2 0 012 2v16l-6-3-6 3V5a2 2 0 012-2z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg></div>
					<h3>Notas de la consulta</h3>
					<p>Lo observado en cada atención, guardado con su fecha y su doctor.</p>
				</div>

				<div class="cli-cell">
					<div class="ic"><svg viewBox="0 0 24 24" fill="none"><rect x="4" y="3" width="16" height="18" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="M8 9h8M8 13h6M8 17h4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
					<h3>Recetas</h3>
					<p>Medicamento, dosis y orientaciones, listas para imprimir o enviar.</p>
				</div>

				<div class="cli-cell">
					<div class="ic"><svg viewBox="0 0 24 24" fill="none"><path d="M14 4l6 6M11 7l6 6M8 10l6 6M4 20l3-1 9-9-4-4-9 9-1 3z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Vacunas</h3>
					<p>Nombre, dosis, fecha de aplicación y cuándo toca la siguiente.</p>
				</div>

				<div class="cli-cell">
					<div class="ic"><svg viewBox="0 0 24 24" fill="none"><path d="M14 3v5h5M14 3H6v18h12V8l-4-5z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M9 13h6M9 17h4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
					<h3>Archivos adjuntos</h3>
					<p>Exámenes, radiografías y documentos guardados en la consulta.</p>
				</div>

				<div class="cli-cell">
					<div class="ic"><svg viewBox="0 0 24 24" fill="none"><path d="M9 11a3 3 0 100-6 3 3 0 000 6zM3 20a6 6 0 0112 0M17 8a2.5 2.5 0 100-5M18 20a5 5 0 00-3-4.6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg></div>
					<h3>Dependientes</h3>
					<p>Los hijos o familiares a cargo del titular, cada uno con su propio historial.</p>
				</div>
			</div>
		</div>
	</section>

	<!-- FORMULARIOS -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="cli-split">
				<div class="cli-split-text">
					<div class="ic"><svg viewBox="0 0 24 24" fill="none"><rect x="3" y="4" width="18" height="16" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="M7 9h6M7 13h10M7 17h4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
					<h3>Los formularios los defines tú</h3>
					<p class="txt">Ninguna clínica pregunta lo mismo. Arma tus propios formularios con las preguntas que de verdad usas y decide en qué momento aparecen: al abrir la ficha del paciente, durante la consulta o al aplicar una vacuna.</p>
					<ul class="cli-list">
						<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Formulario de ficha médica, de consulta o de vacuna</li>
						<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Preguntas de texto libre o de opciones</li>
						<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>El orden en que se muestran lo decides tú</li>
						<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Se imprimen junto con el expediente</li>
					</ul>

					<div class="cli-inline-shot"><?php $cli_shot( 'cli-preguntas.png', 'cli_img_preguntas', 'Listado de preguntas del formulario' ); ?></div>
				</div>
				<div class="cli-split-media"><?php $cli_shot( 'cli-formulario.png', 'cli_img_formulario', 'Formulario configurable' ); ?></div>
			</div>
		</div>
	</section>

	<!-- RECETAS -->
	<section class="section">
		<div class="wrap">
			<div class="cli-split rev">
				<div class="cli-split-text">
					<div class="ic"><svg viewBox="0 0 24 24" fill="none"><rect x="4" y="3" width="16" height="18" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="M8 9h8M8 13h6M8 17h4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
					<h3>Recetas con la imagen de tu clínica</h3>
					<p class="txt">Escribes el medicamento y las indicaciones, y la receta sale lista para entregar. Puedes imprimirla con tu logo, sin logo si usas papel membretado, o con una plantilla hecha a la medida de tu clínica.</p>
					<ul class="cli-list">
						<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Con logo, sin logo o con plantilla personalizada</li>
						<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Indicaciones y orientaciones al paciente</li>
						<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Queda amarrada a la consulta que la generó</li>
					</ul>
				</div>
				<div class="cli-split-media"><?php $cli_shot( 'cli-receta.png', 'cli_img_receta', 'Receta lista para imprimir' ); ?></div>
			</div>
		</div>
	</section>

	<!-- VIDEOS -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">En acción</div>
				<h2>Así se ve un día en la clínica</h2>
				<p>Tres momentos de la atención: agendar la cita, atender la consulta y emitir la receta.</p>
			</div>

			<div class="cli-media-list">
				<div class="cli-media-item">
					<div class="cap">
						<span class="num">1</span>
						<span>
							<b>Agendar una cita</b>
							<span>Eliges al paciente, el título de la consulta, la fecha, el horario y el doctor que atiende.</span>
						</span>
					</div>
					<?php $cli_shot( 'cli-agendar.png', 'cli_img_agendar', 'Agendar una cita' ); ?>
				</div>
				<div class="cli-media-item">
					<div class="cap">
						<span class="num">2</span>
						<span>
							<b>Atender la consulta</b>
							<span>Inicia la atención y llena el formulario que tu clínica definió, sección por sección.</span>
						</span>
					</div>
					<?php $cli_video( 'consulta-medica', 'Video: atender la consulta', 'Inicia y llena el formulario', 'cli_video_consulta' ); ?>
				</div>
				<div class="cli-media-item">
					<div class="cap">
						<span class="num">3</span>
						<span>
							<b>Emitir la receta</b>
							<span>Escribes el medicamento y las indicaciones, y la receta sale lista para imprimir.</span>
						</span>
					</div>
					<?php $cli_video( 'receta-medica', 'Video: emitir una receta', 'Medicamento e indicaciones', 'cli_video_receta' ); ?>
				</div>
			</div>
		</div>
	</section>

	<!-- CONVENIOS Y COBRO -->
	<section class="section">
		<div class="wrap">
			<div class="cli-split">
				<div class="cli-split-text">
					<div class="ic"><svg viewBox="0 0 24 24" fill="none"><path d="M12 3l8 4v5c0 4.4-3.2 7.9-8 9-4.8-1.1-8-4.6-8-9V7l8-4z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M9 12l2 2 4-4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Convenios con seguros y cobro de la consulta</h3>
					<p class="txt">Registra los seguros y convenios con los que trabajas y su descuento. Al cobrar, la consulta ya trae sus procedimientos, medicamentos y productos, se aplica el convenio y se emite la factura.</p>
					<ul class="cli-list">
						<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Cada seguro con su descuento configurado</li>
						<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Procedimientos y medicamentos en la misma cuenta</li>
						<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Total pagado y total pendiente por paciente</li>
						<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Comprobante en hoja completa o impresora térmica</li>
					</ul>

				</div>
				<div class="cli-split-media"><?php $cli_shot( 'cli-cuenta.png', 'cli_img_cuenta', 'Cobro de la consulta' ); ?></div>
			</div>
		</div>
	</section>

	<!-- CAPACIDADES -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Todo lo que incluye</div>
				<h2>Pensado para el día a día de tu clínica</h2>
			</div>

			<div class="cli-caps">
				<div class="cli-cap">
					<div class="ic"><svg viewBox="0 0 24 24" fill="none"><rect x="3" y="5" width="18" height="16" rx="2" stroke="currentColor" stroke-width="1.7"/><path d="M3 10h18M8 3v4M16 3v4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
					<div><b>Agenda por doctor</b><p>Cada profesional con su propia agenda y sus horarios.</p></div>
				</div>
				<div class="cli-cap">
					<div class="ic"><svg viewBox="0 0 24 24" fill="none"><path d="M12 8v4l3 2" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/></svg></div>
					<div><b>Duración real de la consulta</b><p>Cronómetro desde que inicia hasta que finaliza la atención.</p></div>
				</div>
				<div class="cli-cap">
					<div class="ic"><svg viewBox="0 0 24 24" fill="none"><path d="M6 3h9l4 4v14H6z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M9 12h7M9 16h5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
					<div><b>Expediente por paciente</b><p>Historial completo, también para sus dependientes.</p></div>
				</div>
				<div class="cli-cap">
					<div class="ic"><svg viewBox="0 0 24 24" fill="none"><rect x="3" y="4" width="18" height="16" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="M7 9h6M7 13h10M7 17h4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
					<div><b>Formularios configurables</b><p>Las preguntas que tu clínica necesita, no las de otra.</p></div>
				</div>
				<div class="cli-cap">
					<div class="ic"><svg viewBox="0 0 24 24" fill="none"><path d="M14 4l6 6M11 7l6 6M4 20l3-1 9-9-4-4-9 9-1 3z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<div><b>Control de vacunas</b><p>Dosis aplicada y aviso de la próxima.</p></div>
				</div>
				<div class="cli-cap">
					<div class="ic"><svg viewBox="0 0 24 24" fill="none"><path d="M12 3l8 4v5c0 4.4-3.2 7.9-8 9-4.8-1.1-8-4.6-8-9V7l8-4z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg></div>
					<div><b>Seguros y convenios</b><p>Cada uno con su descuento aplicado al cobrar.</p></div>
				</div>
				<div class="cli-cap">
					<div class="ic"><svg viewBox="0 0 24 24" fill="none"><path d="M3 5h2l2.4 10.2a2 2 0 002 1.6h7.6a2 2 0 002-1.6L21 8H6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><circle cx="10" cy="20" r="1.4" stroke="currentColor" stroke-width="1.5"/><circle cx="17" cy="20" r="1.4" stroke="currentColor" stroke-width="1.5"/></svg></div>
					<div><b>Farmacia e insumos</b><p>Los medicamentos que entregas descuentan del inventario.</p></div>
				</div>
				<div class="cli-cap">
					<div class="ic"><svg viewBox="0 0 24 24" fill="none"><path d="M12 3l8 4.5v9L12 21l-8-4.5v-9L12 3z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/><path d="M9 12h6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
					<div><b>Varias sucursales</b><p>Cada sede con su agenda, su caja y sus informes.</p></div>
				</div>
				<div class="cli-cap">
					<div class="ic"><svg viewBox="0 0 24 24" fill="none"><path d="M4 19V5M4 19h16M8 16l3-4 3 2 4-6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<div><b>Informes</b><p>Consultas atendidas, ingresos y pendientes por período.</p></div>
				</div>
				<div class="cli-cap">
					<div class="ic"><svg viewBox="0 0 24 24" fill="none"><path d="M12 15a3 3 0 100-6 3 3 0 000 6z" stroke="currentColor" stroke-width="1.6"/><path d="M6 20V6a2 2 0 012-2h8a2 2 0 012 2v14" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg></div>
					<div><b>Auditoría de cambios</b><p>Quién modificó qué en el expediente y cuándo.</p></div>
				</div>
			</div>
		</div>
	</section>

	<!-- CTA -->
	<section class="section">
		<div class="wrap">
			<div class="cta-strip">
				<h2><?php echo esc_html( vlac_opt( 'cli_cta_title', 'Ordena tu clínica y dedica el tiempo al paciente' ) ); ?></h2>
				<p><?php echo esc_html( vlac_opt( 'cli_cta_sub', 'Agenda, expediente, recetas, vacunas y cobro en un solo sistema conectado, con el historial de cada paciente siempre a la mano.' ) ); ?></p>
				<a class="btn btn-red btn-lg" href="<?php echo esc_url( vlac_cta_url( 'cta_btn_url' ) ); ?>"><?php echo esc_html( vlac_opt( 'hero_cta1_txt', 'Prueba gratis' ) ); ?></a>
			</div>
		</div>
	</section>

</div>

<?php
get_footer();
