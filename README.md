# Vlac Systems — Tema de WordPress

Réplica fiel de la landing page de **Vlac Systems** (ERP + Facturador FEL para Guatemala), convertida en un tema de WordPress instalable y editable.

## Contenido del tema

```
ciber-vlac-systems/
├── style.css          → Cabecera del tema + todo el CSS del diseño
├── functions.php      → Configuración, menús, carga de assets y opciones del Personalizador
├── header.php         → Encabezado con mega-menú "Industrias" y panel móvil
├── front-page.php     → Portada: hero, features, industrias y CTA
├── footer.php         → Pie de página con menús editables
├── index.php          → Plantilla de respaldo (blog/archivos)
├── page.php           → Plantilla para páginas estándar
├── screenshot.png     → Vista previa en el panel de temas
└── assets/
    ├── img/           → Imágenes (logo, capturas de monitor/tablet/teléfono, mapa de mesas)
    └── js/            → Script del menú móvil
```

## Instalación

1. Comprime la carpeta `ciber-vlac-systems` en un `.zip` (o usa el `.zip` incluido).
2. En WordPress ve a **Apariencia → Temas → Añadir nuevo → Subir tema**.
3. Sube el `.zip` y pulsa **Instalar** y luego **Activar**.

### Mostrar la landing como página de inicio

El diseño se muestra automáticamente gracias a `front-page.php`. Para asegurarte:

- Ve a **Ajustes → Lectura → Tu página de inicio muestra** y elige **Una página estática**, o déjalo en "Tus últimas entradas": en ambos casos `front-page.php` tiene prioridad.

## Personalización sin tocar código

Ve a **Apariencia → Personalizar → Contenido de la portada**. Podrás editar:

- **Hero:** etiqueta, título (admite `<span class="accent">` para las palabras en rojo), subtítulo, ambos botones y la nota de confianza.
- **CTA final:** título, subtítulo y botón.
- **Encabezado:** textos y enlaces de "Iniciar sesión" y del botón rojo.
- **Pie de página:** descripción de la marca, copyright y texto legal.

**Logo:** en **Apariencia → Personalizar → Identidad del sitio** puedes subir tu propio logo; si no, se usa el logo incluido.

**Menús del pie de página:** en **Apariencia → Menús** puedes asignar menús a las áreas *Footer — Producto*, *Footer — Industrias* y *Footer — Empresa*. Si no asignas ninguno, se muestran los enlaces por defecto.

## Página «Control de asistencia y nómina» (Control iD)

Plantilla `page-control-de-asistencia.php`. Cubre la integración con el lector facial
**Control iD idFace**: sincronización de los usuarios del sistema con el aparato, registros
de horario, contratos con jornada semanal y el cálculo de horas dentro de la nómina.

1. **Páginas → Añadir nueva**, título «Control de asistencia», slug **`control-de-asistencia`**
   (el menú «Aplicaciones → Administración» ya apunta ahí).
2. En **Atributos de página → Plantilla** elige *Control de Asistencia y Nómina*.
3. Los textos, imágenes y videos se editan en **Personalizar → Contenido del sitio →
   Página Control de Asistencia**.

Si prefieres subir los archivos al tema en vez de usar el Personalizador, los nombres son
`cid-sync.png`, `cid-aparatos.png`, `cid-registros.png`, `cid-contrato.png`, `cid-nomina.png`
y `cid-hero.png` (opcional) en `assets/img/`, más `controlid-marcaje.mp4` en `assets/video/`.
Mientras falten, la página muestra un marcador con las instrucciones.

## Página «Venta en línea» (tienda SoftShop)

Plantilla `page-venta-en-linea.php`. Cubre el módulo de **Venta en Línea**: publicar
categorías y productos desde el ERP, armar la vitrina con banners y secciones,
configurar la identidad de la tienda, definir entrega a domicilio y retiro en tienda,
y atender los pedidos en el panel de ventas.

1. **Páginas → Añadir nueva**, título «Venta en línea», slug **`venta-en-linea`**
   (el menú «Aplicaciones → Facturación y ventas» ya apunta ahí).
2. En **Atributos de página → Plantilla** elige *Venta en Línea (Tienda)*.
3. Los textos y las imágenes se editan en **Personalizar → Contenido del sitio →
   Página Venta en Línea**.

Si prefieres subir las capturas al tema en vez de usar el Personalizador, los nombres
en `assets/img/` son `vlo-tienda.png`, `vlo-config.png`, `vlo-categorias.png`,
`vlo-productos.png`, `vlo-destacados.png`, `vlo-catalogo.png`, `vlo-carrito.png`,
más `vlo-tablet.png` y `vlo-phone.png` para el hero (y `vlo-hero.png`, opcional).
Mientras falten, la página muestra un marcador con las instrucciones.

El panel de ventas (Nueva venta → Preparación → En camino → Entregado) está dibujado
en HTML y CSS dentro de la plantilla, no es una captura: así se ve siempre lleno y se
adapta a móvil.

## Buscador del sitio

En la cabecera hay una lupa que abre el campo de búsqueda; en móvil el buscador
aparece arriba del todo dentro del panel del menú (la lupa se oculta ahí para no
apretar la barra). Los resultados se muestran con `search.php`, y el formulario
vive en `searchform.php`, así que sale igual en los tres sitios donde aparece.

La búsqueda se limita a **páginas y entradas** desde `vlac_search_only_content()`
en `functions.php`: sin ese filtro WordPress también devuelve adjuntos de la
biblioteca de medios, que no son contenido que el visitante quiera abrir.

Como las páginas del tema no tienen contenido propio (todo va en la plantilla),
los resultados salen por **título**. Si quieres que una página se encuentre por
más palabras, escríbelas en el editor de esa página: aparecerán como extracto
bajo el título en los resultados.

## Notas técnicas

- El **mega-menú de "Industrias"** y las secciones de *features* e *industrias* están escritos directamente en las plantillas (`header.php` y `front-page.php`) para conservar los iconos SVG y el diseño exacto. Puedes editar sus textos y enlaces ahí.
- Fuentes: **Inter** y **Manrope** desde Google Fonts (igual que el original).
- Colores de marca definidos como variables CSS en `:root` dentro de `style.css` (`--red: #C1272D`, etc.).
- Compatible con WordPress 6.0+ y PHP 7.4+.

## Cambiar imágenes

Reemplaza los archivos en `assets/img/` manteniendo los mismos nombres:
`logo.png`, `hero-monitor.jpg`, `hero-tablet.png`, `hero-phone.png`, `floor-map.png`.

`logo.png` (256×256) es el logo visible de la cabecera y el pie cuando no hay
uno subido en el Personalizador; los iconos de pestaña y de app son aparte, en
`assets/img/icons/`.

## Sitemap y SEO

El sitemap (`https://vlac.systems/wp-sitemap.xml`) lo genera el propio WordPress.
El tema sólo lo recorta: quita `wp-sitemap-users-1.xml` (autores) y las taxonomías
del blog (categorías y etiquetas), y marca como *noindex* los archivos de autor,
fecha, búsqueda, adjuntos y 404.

Lo que **no** se arregla desde el tema (es contenido, va en el panel):

1. **Entradas → Todas** → enviar «¡Hola, mundo!» (`/2026/06/26/hello-world/`) a la
   papelera y **vaciar la papelera**. Al no quedar entradas publicadas, WordPress
   deja de generar `wp-sitemap-posts-post-1.xml`.
2. **Páginas** → borrar también «Página de ejemplo» si sigue ahí.
3. **Search Console → Sitemaps** → añadir `wp-sitemap.xml` para que deje de decir
   *«No referring sitemaps detected»*.

## Icono de la pestaña (favicon)

Lo correcto es subirlo en **Apariencia → Personalizar → Identidad del sitio →
Icono del sitio** (imagen cuadrada, mínimo 512×512 px). WordPress genera ahí
todos los tamaños que piden los navegadores y los dispositivos móviles.

Mientras no haya un icono propio, el tema imprime como respaldo los archivos de
`assets/img/icons/` (`favicon.ico`, `favicon-16x16.png`, `favicon-32x32.png` y
`apple-touch-icon.png`, de 180×180). Así nunca se ve el logo genérico de
WordPress en la pestaña.

## Instalación en Android (web app manifest)

WordPress no genera ningún *web app manifest*, así que lo sirve el tema en
`https://vlac.systems/?vlac_manifest=1`, enlazado desde la cabecera con
`<link rel="manifest">`. Se genera desde PHP para que tome el nombre, el idioma
y la URL reales del sitio; los iconos salen del **Icono del sitio** si está
puesto, y si no de `assets/img/icons/android-chrome-192x192.png` y
`android-chrome-512x512.png`.

En **Apariencia → Personalizar → Identidad del sitio** se editan el *nombre
corto en el móvil* (el que aparece bajo el icono, máx. 12 caracteres) y el
*color de la barra en el móvil*.
