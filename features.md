To test:

- Login con roles
    1) Ingreso a /
    2) Completo email y contraseña
    3) Presiono Ingresar
    4) Veo el panel de Admin / Secretaria / Paciente

- Register
    1) Ingreso a /
    2) Presiono registar nuevo usuario
    3) Completo los datos
    4) Presiono registrarme
    5) Redirecciona al panel de Paciente

- CRUD Pofessional
    * Before:
        1) Ingreso a /
        2) Completo email y contraseña con usuario de secretaria
        3) Presiono ingresar
        4) Presiono Configuración -> Médicos
    
    * Create:
        5) Presiono Agregar nuevo
        6) Completo Nombre y apellido
        7) Guardo
        8) Chequeo que exista nombre y apellido del médico en la tabla
    
    * Read: N/A
    
    * Update:
        5) Presiono boton editar médico
        6) Cambio nombre y apellido
        7) Guardo
        8) Chequeo que exista nombre y apellido nuevos del médico en la tabla
    
    * Delete:
        5) Presiono boton borrar médico
        6) Acepto mensaje de confirmación
        7) Chequeo que el nombre y apellido del médico no exista en la tabla

- CRUD Timetable
- CRUD Obra social
- Habilitar y deshabilitar obra social
- CRUD Estudios médicos
- Habilitar y deshabilitar Estudio médico
- CRUD Paciente
- Otorgar turno
- Modificar turno
- Eliminar turno
- Habilitar masivamente turnos
- Habilitar un turno único