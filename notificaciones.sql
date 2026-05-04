-- notificaciones.sql
-- Archivo para insertar datos de prueba en la tabla notificationes

INSERT INTO `notificationes` (`titulo`, `mensaje`, `created_at`, `updated_at`) VALUES
('Bienvenido a Market', 'Gracias por registrarte en nuestra plataforma. Explora los mejores comercios cercanos y empieza a reservar tus productos favoritos.', NOW(), NOW()),
('Nueva Frutería Disponible', '¡La Frutería Paco se ha unido a la plataforma! Revisa sus productos frescos de la huerta.', NOW(), NOW()),
('Actualización del Sistema', 'Hemos mejorado el sistema de reservas para que sea más rápido. ¡Pruébalo ahora en tu panel!', NOW(), NOW()),
('Ofertas de Fin de Semana', 'Recuerda visitar la sección de Panadería María este fin de semana para probar sus nuevas ensaimadas.', NOW(), NOW()),
('Recordatorio de Reserva', 'Tienes reservas pendientes de recoger. No olvides pasar por tu comercio habitual.', NOW(), NOW());
