--
-- Índices para tablas volcadas
--
INSERT INTO snxt_plantilla (id, nombre, uuid, is_active, orden, created_at, updated_at, created_by, updated_by) VALUES
(1, 'nombre 1', NULL, 1, 1, '2030-01-01 12:00:00', '2030-01-01 12:00:00', 1, 1),
(2, 'nombre 2', NULL, 0, 2, '2030-01-01 12:00:00', '2030-01-01 12:00:00', 1, 1),
(3, 'nombre 3', NULL, 1, 3, '2030-01-01 12:00:00', '2030-01-01 12:00:00', 1, 1),
(4, 'nombre 4', NULL, 0, 4, '2030-01-01 12:00:00', '2030-01-01 12:00:00', 1, 1),
(5, 'nombre 5', NULL, 1, 5, '2030-01-01 12:00:00', '2030-01-01 12:00:00', 1, 1);


INSERT INTO snxt_eventos(
nombre, fecha_desde, fecha_hasta) 
VALUES 
('Ingreso Docentes', '2023-02-01', '2023-02-01'),
('Capacitación y organización del inicio del año escolar.', '2023-02-01', '2023-02-04'),
('Ingreso Clases', '2023-02-06', '2023-02-06'),
("Happy Valentine's day", '2023-02-14', '2023-02-14'),
("REUNIÓN DOCENTES 1ER CONSEJO ACADÉMICO", '2023-02-25', '2023-02-25'),
("Revisión y entrega de logros a Coordinadores de áreas.", '2023-02-28', '2023-02-28'),

("Entrega de programaciones actualizadas a Coordinadores de Área", '2023-03-01', '2023-03-01'),
("Elección de Personero y Representantes de grado al Consejo Estudiantil.", '2023-03-06', '2023-03-06'),
("Ingreso actas de seguimiento académico intermedio.", '2023-03-03', '2023-03-08'),
("Envío de informes de Seguimiento Académico a padres de familia.", '2023-03-10', '2023-03-10'),
("Citaciones padres de familia", '2023-03-13', '2023-03-17'),
("Entrega a coordinación de actas citación a padres de familia por seguimiento intermedio.", '2023-03-17', '2023-03-17'),
("Evaluaciones Finales de Período Bachillerato", '2023-03-22', '2023-03-31'),
("Evaluaciones Finales de Período Primaria", '2023-03-27', '2023-03-31'),
("REUNIÓN DOCENTES 2DO CONSEJO ACADÉMICO", '2023-03-25', '2023-03-25'),
("Finalización 1 período", '2023-03-31', '2023-03-31'),
("Acto Religioso: SEMANA SANTA", '2023-03-31', '2023-03-31'),

("Ingreso Notas finales 1° período.", '2023-04-01', '2023-04-10'),
("Inicio 2º período", '2023-04-03', '2023-04-03'),
("Receso Semana Santa 2023", '2023-04-03', '2023-04-07'),
("OPEN DAY I PERÍODO ACADÉMICO", '2023-04-14', '2023-04-14'),
("Revisión Registro Escolar", '2023-04-14', '2023-04-14'),
("DIA DEL IDIOMA", '2023-04-21', '2023-04-21'),
("Festival de la leyenda vallenata 2023", '2023-04-25', '2023-04-25'),
("Receso FESTIVAL VALLENATO 2023", '2023-04-26', '2023-04-28'),

("REUNIÓN DOCENTES 3ER CONSEJO ACADÉMICO", '2023-05-06', '2023-05-06'),
("III Concurso Léxico Semántico", '2023-05-12', '2023-05-12'),
("Ingreso acciones de seguimiento intermedio 2 período.", '2023-05-11', '2023-05-15'),
("DIA DEL PROFESOR", '2023-05-15', '2023-05-15'),
("Revisión y entrega de logros a Coordinadores de áreas", '2023-05-16', '2023-05-16'),
("Envío de seguimientos intermedios padres de familia.", '2023-05-17', '2023-05-17'),
("Citaciones padres de familia", '2023-05-18', '2023-05-24'),

("Evaluaciones Finales de Período Primaria", '2023-06-01', '2023-06-07'),
("Evaluaciones Finales de Período Bachillerato", '2023-06-01', '2023-06-13'),
("Ingreso notas finales 2 período", '2023-06-01', '2023-06-13'),
("DIA DEL ESTUDIANTE", '2023-06-08', '2023-06-08'),
("Ingreso Notas finales 2° período.", '2023-06-09', '2023-06-15'),
("OPEN DAY II PERÍODO ACADÉMICO", '2023-06-16', '2023-06-16'),
("Revisión Registros Escolares.", '2023-06-16', '2023-06-16'),
("RECESO VACACIONES INTERMEDIAS", '2023-06-20', '2023-07-11');
