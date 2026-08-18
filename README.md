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

## Notas técnicas

- El **mega-menú de "Industrias"** y las secciones de *features* e *industrias* están escritos directamente en las plantillas (`header.php` y `front-page.php`) para conservar los iconos SVG y el diseño exacto. Puedes editar sus textos y enlaces ahí.
- Fuentes: **Inter** y **Manrope** desde Google Fonts (igual que el original).
- Colores de marca definidos como variables CSS en `:root` dentro de `style.css` (`--red: #C1272D`, etc.).
- Compatible con WordPress 6.0+ y PHP 7.4+.

## Cambiar imágenes

Reemplaza los archivos en `assets/img/` manteniendo los mismos nombres:
`logo.png`, `hero-monitor.jpg`, `hero-tablet.png`, `hero-phone.png`, `floor-map.png`.
