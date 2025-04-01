<?php

//  define('SHOW_VARIABLES', 1);
//  define('DEBUG_LEVEL', 1);

//  error_reporting(E_ALL ^ E_NOTICE);
//  ini_set('display_errors', 'On');

set_include_path('.' . PATH_SEPARATOR . get_include_path());


include_once dirname(__FILE__) . '/' . 'components/utils/system_utils.php';
include_once dirname(__FILE__) . '/' . 'components/mail/mailer.php';
include_once dirname(__FILE__) . '/' . 'components/mail/phpmailer_based_mailer.php';
require_once dirname(__FILE__) . '/' . 'database_engine/mysql_engine.php';

//  SystemUtils::DisableMagicQuotesRuntime();

SystemUtils::SetTimeZoneIfNeed('America/Halifax');

function GetGlobalConnectionOptions()
{
    return
        array(
          'server' => '127.0.0.1',
          'port' => '3306',
          'username' => 'ratikozx_bd_notaria_user',
          'password' => '6Imp#yUbt)Hj',
          'database' => 'ratikozx_bd_notaria',
          'client_encoding' => 'utf8'
        );
}

function HasAdminPage()
{
    return false;
}

function HasHomePage()
{
    return true;
}

function GetHomeURL()
{
    return 'index.php';
}

function GetHomePageBanner()
{
    return '';
}

function GetPageGroups()
{
    $result = array();
    $result[] = array('caption' => '1. Usuarios y Funcionarios', 'description' => '');
    $result[] = array('caption' => '2. Gestion de Tramites', 'description' => '');
    $result[] = array('caption' => '3. Gestion de Flujo de Trabajo', 'description' => '');
    $result[] = array('caption' => '4. Reportes', 'description' => '');
    return $result;
}

function GetPageInfos()
{
    $result = array();
    $result[] = array('caption' => 'Usuarios', 'short_caption' => 'Usuarios', 'filename' => 'usuarios.php', 'name' => 'usuarios', 'group_name' => '1. Usuarios y Funcionarios', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Tipos de Funcionario', 'short_caption' => 'Tipos de Funcionario', 'filename' => 'tipos_funcionario.php', 'name' => 'tipos_funcionario', 'group_name' => '1. Usuarios y Funcionarios', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Funcionarios', 'short_caption' => 'Funcionarios', 'filename' => 'funcionarios.php', 'name' => 'funcionarios', 'group_name' => '1. Usuarios y Funcionarios', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Categorias de Tramite', 'short_caption' => 'Categorias de Tramite', 'filename' => 'categorias_tramite.php', 'name' => 'categorias_tramite', 'group_name' => '2. Gestion de Tramites', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Tipos de Tramite', 'short_caption' => 'Tipos de Tramite', 'filename' => 'tipos_tramite.php', 'name' => 'tipos_tramite', 'group_name' => '2. Gestion de Tramites', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Etapas de los Tramites', 'short_caption' => 'Etapas de los Tramites', 'filename' => 'etapas_tramite.php', 'name' => 'etapas_tramite', 'group_name' => '2. Gestion de Tramites', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Tramites', 'short_caption' => 'Tramites', 'filename' => 'tramites.php', 'name' => 'tramites', 'group_name' => '3. Gestion de Flujo de Trabajo', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Seguimiento de Etapas', 'short_caption' => 'Seguimiento de Etapas', 'filename' => 'seguimiento_etapas.php', 'name' => 'seguimiento_etapas', 'group_name' => '3. Gestion de Flujo de Trabajo', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Clientes', 'short_caption' => 'Clientes', 'filename' => 'clientes.php', 'name' => 'clientes', 'group_name' => '3. Gestion de Flujo de Trabajo', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Documentos', 'short_caption' => 'Documentos', 'filename' => 'documentos.php', 'name' => 'documentos', 'group_name' => '3. Gestion de Flujo de Trabajo', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'Pagos', 'short_caption' => 'Pagos', 'filename' => 'pagos.php', 'name' => 'pagos', 'group_name' => '3. Gestion de Flujo de Trabajo', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'V Datos', 'short_caption' => 'V Datos', 'filename' => 'v_datos.php', 'name' => 'v_datos', 'group_name' => '4. Reportes', 'add_separator' => false, 'description' => '');
    $result[] = array('caption' => 'V Estadisticas', 'short_caption' => 'V Estadisticas', 'filename' => 'v_estadisticas.php', 'name' => 'v_estadisticas', 'group_name' => '4. Reportes', 'add_separator' => false, 'description' => '');
    return $result;
}

function GetPagesHeader()
{
    return
        '';
}

function GetPagesFooter()
{
    return
        '';
}

function ApplyCommonPageSettings(Page $page, Grid $grid)
{
    $page->SetShowUserAuthBar(true);
    $page->setShowNavigation(true);
    $page->OnGetCustomExportOptions->AddListener('Global_OnGetCustomExportOptions');
    $page->getDataset()->OnGetFieldValue->AddListener('Global_OnGetFieldValue');
    $page->getDataset()->OnGetFieldValue->AddListener('OnGetFieldValue', $page);
    $grid->BeforeUpdateRecord->AddListener('Global_BeforeUpdateHandler');
    $grid->BeforeDeleteRecord->AddListener('Global_BeforeDeleteHandler');
    $grid->BeforeInsertRecord->AddListener('Global_BeforeInsertHandler');
    $grid->AfterUpdateRecord->AddListener('Global_AfterUpdateHandler');
    $grid->AfterDeleteRecord->AddListener('Global_AfterDeleteHandler');
    $grid->AfterInsertRecord->AddListener('Global_AfterInsertHandler');
}

function GetAnsiEncoding() { return 'windows-1252'; }

function Global_AddEnvironmentVariablesHandler(&$variables)
{

}

function Global_CustomHTMLHeaderHandler($page, &$customHtmlHeaderText)
{

}

function Global_GetCustomTemplateHandler($type, $part, $mode, &$result, &$params, CommonPage $page = null)
{

}

function Global_OnGetCustomExportOptions($page, $exportType, $rowData, &$options)
{

}

function Global_OnGetFieldValue($fieldName, &$value, $tableName)
{

}

function Global_GetCustomPageList(CommonPage $page, PageList $pageList)
{

}

function Global_BeforeInsertHandler($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
{

}

function Global_BeforeUpdateHandler($page, $oldRowData, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
{

}

function Global_BeforeDeleteHandler($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
{

}

function Global_AfterInsertHandler($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
{

}

function Global_AfterUpdateHandler($page, $oldRowData, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
{

}

function Global_AfterDeleteHandler($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
{

}

function GetDefaultDateFormat()
{
    return 'Y-m-d';
}

function GetFirstDayOfWeek()
{
    return 1;
}

function GetPageListType()
{
    return PageList::TYPE_SIDEBAR;
}

function GetNullLabel()
{
    return null;
}

function UseMinifiedJS()
{
    return true;
}

function GetOfflineMode()
{
    return false;
}

function GetInactivityTimeout()
{
    return 120;
}

function GetMailer()
{
    $mailerOptions = new MailerOptions(MailerType::Sendmail, '', '');
    
    return PHPMailerBasedMailer::getInstance($mailerOptions);
}

function sendMailMessage($recipients, $messageSubject, $messageBody, $attachments = '', $cc = '', $bcc = '')
{
    GetMailer()->send($recipients, $messageSubject, $messageBody, $attachments, $cc, $bcc);
}

function createConnection()
{
    $connectionOptions = GetGlobalConnectionOptions();
    $connectionOptions['client_encoding'] = 'utf8';

    $connectionFactory = MyPDOConnectionFactory::getInstance();
    return $connectionFactory->CreateConnection($connectionOptions);
}

/**
 * @param string $pageName
 * @return IPermissionSet
 */
function GetCurrentUserPermissionsForPage($pageName) 
{
    return GetApplication()->GetCurrentUserPermissionSet($pageName);
}
