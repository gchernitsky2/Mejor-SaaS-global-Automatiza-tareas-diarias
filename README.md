# TaskLoop AI (Versión PHP Unificada)

Sistema SaaS de automatización con IA en PHP, contenido en un solo archivo.

## 🚀 Funcionalidades

- Automatizador visual básico
- Conexión con OpenAI para generación de texto
- Panel de usuario y administración
- Plantillas SQL visualizadas desde el navegador
- Preparado para Stripe, WhatsApp, Gmail, etc.

## ⚙️ Instalación

1. Sube `taskloop-ai-unificado.php` a tu servidor con PHP (Apache recomendado)
2. Crea una base de datos MySQL y carga el archivo SQL desde la vista `?view=sql`
3. Reemplaza la constante `OPENAI_API_KEY` con tu clave personal
4. Accede a `taskloop-ai-unificado.php` desde el navegador

## 🔗 Navegación

- `?view=usuario` → Vista del usuario
- `?view=admin` → Panel administrativo
- `?view=sql` → Ver base de datos en pantalla

## 📄 Licencia

MIT License – Libre para usar, modificar y distribuir.
