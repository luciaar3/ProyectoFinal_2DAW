-- comercios.sql
-- Inserción de Usuarios Comerciantes
INSERT INTO `users` (`id`, `nombre`, `primer_apellido`, `segundo_apellido`, `email`, `password`, `rol`, `created_at`, `updated_at`) VALUES
(1, 'Juan', 'Pérez', 'García', 'juan@fruteria.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Comerciante', NOW(), NOW()),
(2, 'María', 'López', 'Martínez', 'maria@panaderia.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Comerciante', NOW(), NOW());

-- Inserción de Negocios
INSERT INTO `negocio` (`id`, `user_id`, `reservation_id`, `nombre_negocio`, `descripcion`, `numero_permiso`, `nif`, `telefono`, `imagen`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 'Frutería Paco', 'Las mejores frutas y verduras de la huerta, directas a tu mesa.', 12345, '12345678A', 600123456, NULL, NOW(), NOW()),
(2, 2, NULL, 'Panadería María', 'Pan artesanal hecho con masa madre y dulces tradicionales.', 67890, '87654321B', 600654321, NULL, NOW(), NOW());

-- Inserción de Horarios (todos los días para que siempre aparezcan)
INSERT INTO `horario_negocio` (`negocio_id`, `dia`, `apertura`, `cierre`, `festivo_cerrado`, `poblacion`, `ubicacion`, `latitud`, `longitud`, `created_at`, `updated_at`) VALUES
(1, 'lunes', '08:00:00', '14:00:00', 0, 'Valencia', 'Mercado Central', 39.4735, -0.3784, NOW(), NOW()),
(1, 'martes', '08:00:00', '14:00:00', 0, 'Valencia', 'Mercado Central', 39.4735, -0.3784, NOW(), NOW()),
(1, 'miercoles', '08:00:00', '14:00:00', 0, 'Valencia', 'Mercado Central', 39.4735, -0.3784, NOW(), NOW()),
(1, 'jueves', '08:00:00', '14:00:00', 0, 'Valencia', 'Mercado Central', 39.4735, -0.3784, NOW(), NOW()),
(1, 'viernes', '08:00:00', '14:00:00', 0, 'Valencia', 'Mercado Central', 39.4735, -0.3784, NOW(), NOW()),
(1, 'sabado', '08:00:00', '14:00:00', 0, 'Valencia', 'Mercado Central', 39.4735, -0.3784, NOW(), NOW()),
(1, 'domingo', '08:00:00', '14:00:00', 0, 'Valencia', 'Mercado Central', 39.4735, -0.3784, NOW(), NOW()),

(2, 'lunes', '07:30:00', '15:00:00', 0, 'Valencia', 'Ruzafa', 39.4616, -0.3734, NOW(), NOW()),
(2, 'martes', '07:30:00', '15:00:00', 0, 'Valencia', 'Ruzafa', 39.4616, -0.3734, NOW(), NOW()),
(2, 'miercoles', '07:30:00', '15:00:00', 0, 'Valencia', 'Ruzafa', 39.4616, -0.3734, NOW(), NOW()),
(2, 'jueves', '07:30:00', '15:00:00', 0, 'Valencia', 'Ruzafa', 39.4616, -0.3734, NOW(), NOW()),
(2, 'viernes', '07:30:00', '15:00:00', 0, 'Valencia', 'Ruzafa', 39.4616, -0.3734, NOW(), NOW()),
(2, 'sabado', '07:30:00', '15:00:00', 0, 'Valencia', 'Ruzafa', 39.4616, -0.3734, NOW(), NOW()),
(2, 'domingo', '07:30:00', '15:00:00', 0, 'Valencia', 'Ruzafa', 39.4616, -0.3734, NOW(), NOW());
