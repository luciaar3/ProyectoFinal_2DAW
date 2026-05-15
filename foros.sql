-- foros.sql
-- Inserción de un usuario Cliente para hacer preguntas
INSERT INTO `users` (`id`, `nombre`, `primer_apellido`, `segundo_apellido`, `email`, `password`, `rol`, `created_at`, `updated_at`) VALUES
(3, 'Ana', 'Gómez', 'Sanz', 'ana@cliente.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Cliente', NOW(), NOW());

-- Mensajes para el Foro de Frutería Paco (negocio_id = 1)
INSERT INTO `foros` (`titulo`, `contenido`, `user_id`, `negocio_id`, `created_at`, `updated_at`) VALUES
('¡Bienvenidos al foro de Frutería Paco!', 'Hola a todos. He abierto este foro para que podáis preguntarme cualquier duda sobre mis productos, disponibilidad o pedir ayuda. ¡Estaré encantado de responderos!', 1, 1, NOW(), NOW()),
('¿Tienen cerezas?', 'Buenas tardes, ¿han llegado ya las cerezas de temporada? Me gustaría pasarme esta tarde a por un par de kilos.', 3, 1, NOW(), NOW()),
('Disponibilidad de tomates', 'Hola Paco, ¿vas a tener tomates de colgar esta semana?', 3, 1, NOW(), NOW());

-- Mensajes para el Foro de Panadería María (negocio_id = 2)
INSERT INTO `foros` (`titulo`, `contenido`, `user_id`, `negocio_id`, `created_at`, `updated_at`) VALUES
('¡Bienvenidos al foro de Panadería María!', 'Hola a todos. He abierto este foro para que podáis preguntarme cualquier duda sobre mis productos, disponibilidad o pedir ayuda. ¡Estaré encantado de responderos!', 2, 2, NOW(), NOW()),
('Encargo de ensaimadas', 'Hola María, ¿puedo encargarte 10 ensaimadas para el sábado por la mañana?', 3, 2, NOW(), NOW()),
('Pan sin gluten', 'Buenos días, ¿hacéis algún tipo de pan sin gluten o apto para celíacos?', 3, 2, NOW(), NOW());
