<?php                                              
return array (
    'MODEL_DIGITALDIARYSECTIONS_FIELD_NAME'=>'Nombre',
    'MODEL_DIGITALDIARYSECTIONS_FIELD_DESCRIPTION'=>'Descripción',
    
    'MODEL_DIGITALDIARYSECTIONSNOTIFICATIONS_FIELD_MAIL'=>'Correo electrónico',
    'MODEL_DIGITALDIARYSECTIONSNOTIFICATIONS_FIELD_IDSECTION'=>'Sección',
    'MODEL_DIGITALDIARYSECTIONSNOTIFICATIONS_FIELD_ONLYRECVURGENTEVENTS'=>'Solo recibir mensajes urgentes',
    'MODEL_DIGITALDIARYSECTIONSNOTIFICATIONS_FIELD_ONLYRECVURGENTEVENTS_ABBREVIATION'=>'Urgente',
    
    'MODEL_DIGITALDIARYFORMSTURNEVENTS_FIELD_OWNER'=>'Emitido por',
    'MODEL_DIGITALDIARYFORMSTURNEVENTS_FIELD_DATE'=>'Fecha del turno',
    'MODEL_DIGITALDIARYFORMSTURNEVENTS_FIELD_TURN'=>'Turno',
    'MODEL_DIGITALDIARYFORMSTURNEVENTS_FIELD_STATUS'=>'Estado',
    'MODEL_DIGITALDIARYFORMSTURNEVENTS_FIELD_COMMENTS'=>'Observaciones',
    'MODEL_DIGITALDIARYFORMSTURNEVENTS_FIELD_READLASTTURN'=>'Acepto que he leido la información del turno anterior',
    
    'MODEL_DIGITALDIARYFORMSTURNEVENTLINES_FIELD_HOUR'=>'Hora',
    'MODEL_DIGITALDIARYFORMSTURNEVENTLINES_FIELD_SECTIONNAME'=>'Sección',
    'MODEL_DIGITALDIARYFORMSTURNEVENTLINES_FIELD_IDZONE'=>'Zona',
    'MODEL_DIGITALDIARYFORMSTURNEVENTLINES_FIELD_ZONE'=>'Zona',
    'MODEL_DIGITALDIARYFORMSTURNEVENTLINES_FIELD_IDREGION'=>'Subzona',
    'MODEL_DIGITALDIARYFORMSTURNEVENTLINES_FIELD_REGION'=>'Subzona',
    'MODEL_DIGITALDIARYFORMSTURNEVENTLINES_FIELD_IDEQUIPMENT'=>'Equipo',
    'MODEL_DIGITALDIARYFORMSTURNEVENTLINES_FIELD_EQUIPMENT'=>'Equipo',
    'MODEL_DIGITALDIARYFORMSTURNEVENTLINES_FIELD_DESCRIPTION'=>'Descripción',
    'MODEL_DIGITALDIARYFORMSTURNEVENTLINES_FIELD_URGENT'=>'Mensaje urgente',
    'MODEL_DIGITALDIARYFORMSTURNEVENTLINES_FIELD_URGENT_ABBREVIATION'=>'Urgente',

    'MODEL_DIGITALDIARYFORMSTURNEVENTS_FIELD_STATUS_VALUE_FINALIZED'=>'Todos los eventos han sido enviados',
    'MODEL_DIGITALDIARYFORMSTURNEVENTS_FIELD_STATUS_VALUE_CREATED'=>'Existen eventos pendientes de ser enviados',
    
    'MODEL_DIGITALDIARYEVENTS_FIELD_EMPLOYEE'=>'Trabajador',
    'MODEL_DIGITALDIARYEVENTS_FIELD_ALLEMPLOYEES'=>'Todos',
    'MODEL_DIGITALDIARYEVENTS_FIELD_STARTDATE'=>'Fecha de inicio',
    'MODEL_DIGITALDIARYEVENTS_FIELD_ENDDATE'=>'Fecha de finalización',
    'MODEL_DIGITALDIARYEVENTS_FIELD_DOCFORMAT'=>'Formato del documento',
    
    'MODEL_DIGITALDIARYFORMTURNEVENTEMPLOYEES_FIELD_NAME'=>'Operario',
    'MODEL_DIGITALDIARYFORMTURNEVENTEMPLOYEES_FIELD_EMPLOYEES'=>'Operarios',
    
    'MODEL_DIGITALDIARYDAILYNOTIFICATIONS_FIELD_MAIL'=>'Correo electrónico',
    
    'REPORT_EVENTS_NAME'=>'Eventos',
    
    'PAGE_VIEWFORMSTURNEVENTS_DESCRIPTION'=>'En este apartado podrá gestionar los grupos de los eventos.',
    'PAGE_VIEWFORMSTURNEVENTS_FORM_NEW_DESCRIPTION'=>'Para introducir un nuevo grupo de eventos debe completar el siguiente formulario.',
    'PAGE_VIEWFORMSTURNEVENTS_FORM_NEW_BTN_DESCRIPTION'=>'Nuevo Grupo de Eventos',
    'PAGE_VIEWFORMSTURNEVENTS_FORM_GRID_DESCRIPTION'=>'A continuación se muestra la información mediante celdas.',
    'PAGE_VIEWFORMSTURNEVENTS_FORM_NOTIFY_ERROR_CONFIGURATION'=>'ALERTA - Error durante el proceso de notificación del grupo de eventos seleccionado.<br /><br /><i>Descripción: Falta configurar la cuenta de correo electrónico de envío.</i>',
    'PAGE_VIEWFORMSTURNEVENTS_FORM_NOTIFY_MAIL_SUBJECT'=>'Listado de Eventos {1} de {2} {3} (T.{4}) de {5}',
    'PAGE_VIEWFORMSTURNEVENTS_FORM_NOTIFY_ERROR_SEND'=>'ALERTA - Error durante el proceso de notificación del grupo de eventos seleccionado.<br /><br /><i>Descripción: No se ha podido entregar el mensaje a alguno de los destinatarios.</i>',  
    'PAGE_VIEWFORMSTURNEVENTS_FORM_NOTIFY_SUCCESS'=>'El mensaje se ha enviado correctamente.',
    'PAGE_VIEWFORMSTURNEVENTS_FORM_NOTIFY_ERROR_LINES_NOT_EXIST'=>'ALERTA - Error durante el proceso de notificación del grupo de eventos seleccionado.<br /><br /><i>Descripción: No existen eventos para realizar el proceso de notificación.</i>',  
         
    'PAGE_UPDATEFORMTURNEVENT_HEADER'=>'Eventos - {1} de {2} (T.{3})',
    'PAGE_UPDATEFORMTURNEVENT_DESCRIPTION'=>'En este apartado podrá gestionar los eventos producidos durante el turno.',
    'PAGE_UPDATEFORMTURNEVENT_FORM_NEW_DESCRIPTION'=>'Para introducir un nuevo evento debe completar el siguiente formulario.',
    'PAGE_UPDATEFORMTURNEVENT_FORM_NEW_BTN_DESCRIPTION'=>'Nuevo Evento',
    'PAGE_UPDATEFORMTURNEVENT_SECTION_NOTIFICATIONS'=>'* La información se enviará a las direcciones de correo electrónico siguientes: {1}',
    'PAGE_UPDATEFORMTURNEVENT_SECTION_NOTIFICATION_URGENT'=>'Urgente',
    'PAGE_UPDATEFORMTURNEVENT_FORM_NOTIFY_ERROR_CONFIGURATION'=>'ALERTA - Error durante el proceso de notificación del evento seleccionado.<br /><br /><i>Descripción: Falta configurar la cuenta de correo electrónico de envío.</i>',
    'PAGE_UPDATEFORMTURNEVENT_FORM_NOTIFY_ERROR_SECTION_NOT_EXIST'=>'ALERTA - Error durante el proceso de notificación del evento seleccionado.<br /><br /><i>Descripció: No se ha podido encontrar la sección.</i>',
    'PAGE_UPDATEFORMTURNEVENT_FORM_NOTIFY_ERROR_SEND'=>'ALERTA - Error durante el proceso de notificación del evento seleccionado.<br /><br /><i>Descripción: No se ha podido entregar el mensaje a alguno de los destinatarios.</i>',  
    'PAGE_UPDATEFORMTURNEVENT_FORM_NOTIFY_MAIL_SUBJECT'=>'Evento {1} de {2} {3} (T.{4}) de {5}',
    'PAGE_UPDATEFORMTURNEVENT_FORM_NOTIFY_SUCCESS'=>'El mensaje se ha enviado correctamente.',
    'PAGE_UPDATEFORMTURNEVENT_FORM_EMPLOYEE_NEW_DESCRIPTION'=>'Para introducir un nuevo operario debe completar el siguiente formulario.',
    'PAGE_UPDATEFORMTURNEVENT_FORM_COMMENTS_NEW_DESCRIPTION'=>'Para introducir las observaciones del turno debe completar el siguiente formulario.',
    'PAGE_UPDATEFORMTURNEVENT_HEADER_SECTION_PLANT_MONITORING_FORM_TURN_ROUND'=>'Cuestionarios de los operadores de planta',
    
    'PAGE_UPDATEFORMTURNEVENTLINE_FORM_UPDATE_DESCRIPTION'=>'En el siguiente formulario puede modificar los datos del evento seleccionado.',
    
    'PAGE_VIEWEVENTS_DESCRIPTION'=>'En este apartado podrá visualizar los eventos introducidos en el sistema.',
    'PAGE_VIEWEVENTS_FORM_LIST_DESCRIPTION'=>'Para visualizar los eventos debe completar el siguiente formulario.',
    
    'PAGE_VIEWDAILYNOTIFICATIONS_DESCRIPTION'=>'En este apartado podrá gestionar las notificaciones diarias.',
    'PAGE_VIEWDAILYNOTIFICATIONS_FORM_NEW_DESCRIPTION'=>'Para introducir un nueva notificación debe completar el siguiente formulario.',
    'PAGE_VIEWDAILYNOTIFICATIONS_FORM_NEW_BTN_DESCRIPTION'=>'Nueva Notificación',
    'PAGE_VIEWDAILYNOTIFICATIONS_FORM_GRID_DESCRIPTION'=>'A continuación se muestra la información mediante celdas.',
    
    'PAGE_VIEWDETAILFORMTURNEVENT_HEADER'=>'Diario del jefe de turno - {1} de {2} (T.{3})',
    
    'PAGE_UPDATEDAILYNOTIFICATION_FORM_UPDATE_DESCRIPTION'=>'En el siguiente formulario puede modificar los datos de la notificación seleccionada.',
    
    'PAGE_NOTIFYDAILYEVENTS_NOTIFY_MAIL_SUBJECT'=>'Eventos del día {1}',
    
    'PAGE_VIEWZONES_DESCRIPTION'=>'En este apartado podrá gestionar las zonas.',
    'PAGE_VIEWZONES_FORM_NEW_DESCRIPTION'=>'Para introducir una nueva zona debe completar el siguiente formulario.',
    'PAGE_VIEWZONES_FORM_NEW_BTN_DESCRIPTION'=>'Nueva Zona',
    'PAGE_VIEWZONES_FORM_GRID_DESCRIPTION'=>'A continuación se muestra la información mediante celdas.',
    'PAGE_VIEWZONES_FORM_ASSOCIATION_NEW_BTN_DESCRIPTION'=>'Nueva Relación Zona-Subzona',
    'PAGE_VIEWZONES_FORM_ASSOCIATION_NEW_DESCRIPTION'=>'Para introducir una nueva relación debe completar el siguiente formulario.',
    'PAGE_VIEWZONES_FORM_ASSOCIATION_GRID_DESCRIPTION'=>'A continuación se muestra la información mediante celdas.',
    
    'PAGE_UPDATEZONE_FORM_UPDATE_DESCRIPTION'=>'En el siguiente formulario puede modificar los datos de la zona seleccionada.',
    'PAGE_UPDATEZONEREGION_FORM_UPDATE_DESCRIPTION'=>'En el siguiente formulario puede modificar los datos de la relación seleccionada.',
    
    'PAGE_VIEWREGIONS_DESCRIPTION'=>'En este apartado podrá gestionar las subzonas.',
    'PAGE_VIEWREGIONS_FORM_NEW_DESCRIPTION'=>'Para introducir una nueva subzona debe completar el siguiente formulario.',
    'PAGE_VIEWREGIONS_FORM_NEW_BTN_DESCRIPTION'=>'Nueva Subzona',
    'PAGE_VIEWREGIONS_FORM_GRID_DESCRIPTION'=>'A continuación se muestra la información mediante celdas.',
    'PAGE_VIEWREGIONS_FORM_ASSOCIATION_NEW_BTN_DESCRIPTION'=>'Nueva Relación Subzona-Equipo',
    'PAGE_VIEWREGIONS_FORM_ASSOCIATION_NEW_DESCRIPTION'=>'Para introducir una nueva relación debe completar el siguiente formulario.',
    'PAGE_VIEWREGIONS_FORM_ASSOCIATION_GRID_DESCRIPTION'=>'A continuación se muestra la información mediante celdas.',
    
    'PAGE_UPDATEREGION_FORM_UPDATE_DESCRIPTION'=>'En el siguiente formulario puede modificar los datos de la subzona seleccionada.',
    'PAGE_UPDATEREGIONEQUIPMENT_FORM_UPDATE_DESCRIPTION'=>'En el siguiente formulario puede modificar los datos de la relación seleccionada.',
    
    'PAGE_VIEWEQUIPMENTS_DESCRIPTION'=>'En este apartado podrá gestionar los equipos.',
    'PAGE_VIEWEQUIPMENTS_FORM_NEW_DESCRIPTION'=>'Para introducir un nuevo equipo debe completar el siguiente formulario.',
    'PAGE_VIEWEQUIPMENTS_FORM_NEW_BTN_DESCRIPTION'=>'Nuevo Equipo',
    'PAGE_VIEWEQUIPMENTS_FORM_GRID_DESCRIPTION'=>'A continuación se muestra la información mediante celdas.',
    'PAGE_VIEWEQUIPMENTS_FORM_ASSOCIATION_NEW_BTN_DESCRIPTION'=>'Nueva Relación Equipo-Riesgo',
    'PAGE_VIEWEQUIPMENTS_FORM_ASSOCIATION_NEW_DESCRIPTION'=>'Para introducir una nueva relación debe completar el siguiente formulario.',
    'PAGE_VIEWEQUIPMENTS_FORM_ASSOCIATION_GRID_DESCRIPTION'=>'A continuación se muestra la información mediante celdas.',
    
    'PAGE_UPDATEEQUIPMENT_FORM_UPDATE_DESCRIPTION'=>'En el siguiente formulario puede modificar los datos del equipo seleccionado.',
    
    'PAGE_VIEWSECTIONS_DESCRIPTION'=>'En este apartado podrá gestionar las secciones.',
    'PAGE_VIEWSECTIONS_FORM_NEW_DESCRIPTION'=>'Para introducir un nueva sección debe completar el siguiente formulario.',
    'PAGE_VIEWSECTIONS_FORM_NEW_BTN_DESCRIPTION'=>'Nueva Sección',
    'PAGE_VIEWSECTIONS_FORM_GRID_DESCRIPTION'=>'A continuación se muestra la información mediante celdas.',
    'PAGE_VIEWSECTIONS_FORM_ASSOCIATION_NEW_BTN_DESCRIPTION'=>'Nueva Relación Sección-Notificación',
    'PAGE_VIEWSECTIONS_FORM_ASSOCIATION_NEW_DESCRIPTION'=>'Para introducir una nueva relación debe completar el siguiente formulario.',
    'PAGE_VIEWSECTIONS_FORM_ASSOCIATION_GRID_DESCRIPTION'=>'A continuación se muestra la información mediante celdas.',
    
    'PAGE_UPDATESECTION_FORM_UPDATE_DESCRIPTION'=>'En el siguiente formulario puede modificar los datos de la sección seleccionada.',
    'PAGE_UPDATESECTIONNOTIFICATION_FORM_UPDATE_DESCRIPTION'=>'En el siguiente formulario puede modificar los datos de la relación seleccionada.',
);
?>