-- productos.sql
-- Inserción de Productos para la Frutería (negocio_id = 1)
INSERT INTO `productos` (`negocio_id`, `nombre`, `descripcion`, `precio`, `stock`, `imagen`, `categoria`, `disponible`, `created_at`, `updated_at`) VALUES
(1, 'Naranjas de Valencia', 'Malla de 5kg de naranjas dulces y jugosas, ideales para zumo.', 4.50, 50, NULL, 'Frutas', 1, NOW(), NOW()),
(1, 'Manzanas Golden', 'Manzanas frescas, crujientes y dulces por kilo.', 2.10, 30, NULL, 'Frutas', 1, NOW(), NOW()),
(1, 'Tomate de ensalada', 'Tomates maduros y sabrosos, cultivados sin pesticidas.', 1.80, 40, NULL, 'Verduras', 1, NOW(), NOW());

-- Inserción de Productos para la Panadería (negocio_id = 2)
INSERT INTO `productos` (`negocio_id`, `nombre`, `descripcion`, `precio`, `stock`, `imagen`, `categoria`, `disponible`, `created_at`, `updated_at`) VALUES
(2, 'Hogaza de Masa Madre', 'Pan rústico de 500g, corteza crujiente y miga esponjosa.', 3.20, 15, NULL, 'Pan', 1, NOW(), NOW()),
(2, 'Ensaimada', 'Ensaimada artesana tradicional espolvoreada con azúcar glass.', 1.50, 20, NULL, 'Dulces', 1, NOW(), NOW()),
(2, 'Empanadilla de Pisto', 'Empanadilla casera al horno rellena de tomate y pisto.', 1.20, 25, NULL, 'Salados', 1, NOW(), NOW());
