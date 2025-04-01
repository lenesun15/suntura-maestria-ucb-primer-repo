<?php

include_once dirname(__FILE__) . '/' . 'phpgen_settings.php';
include_once dirname(__FILE__) . '/' . 'components/application.php';
include_once dirname(__FILE__) . '/' . 'components/security/permission_set.php';
include_once dirname(__FILE__) . '/' . 'components/security/user_authentication/table_based_user_authentication.php';
include_once dirname(__FILE__) . '/' . 'components/security/grant_manager/hard_coded_user_grant_manager.php';
include_once dirname(__FILE__) . '/' . 'components/security/table_based_user_manager.php';
include_once dirname(__FILE__) . '/' . 'components/security/user_identity_storage/user_identity_session_storage.php';
include_once dirname(__FILE__) . '/' . 'components/security/recaptcha.php';
include_once dirname(__FILE__) . '/' . 'database_engine/mysql_engine.php';

$grants = array('guest' => 
        array()
    ,
    'defaultUser' => 
        array('usuarios' => new PermissionSet(false, false, false, false),
        'usuarios.categorias_tramite' => new PermissionSet(false, false, false, false),
        'usuarios.clientes' => new PermissionSet(false, false, false, false),
        'usuarios.documentos' => new PermissionSet(false, false, false, false),
        'usuarios.etapas_tramite' => new PermissionSet(false, false, false, false),
        'usuarios.funcionarios' => new PermissionSet(false, false, false, false),
        'usuarios.funcionarios01' => new PermissionSet(false, false, false, false),
        'usuarios.pagos' => new PermissionSet(false, false, false, false),
        'usuarios.seguimiento_etapas' => new PermissionSet(false, false, false, false),
        'usuarios.tipos_funcionario' => new PermissionSet(false, false, false, false),
        'usuarios.tipos_tramite' => new PermissionSet(false, false, false, false),
        'usuarios.tramites' => new PermissionSet(false, false, false, false),
        'tipos_funcionario' => new PermissionSet(false, false, false, false),
        'tipos_funcionario.funcionarios' => new PermissionSet(false, false, false, false),
        'funcionarios' => new PermissionSet(false, false, false, false),
        'funcionarios.tramites' => new PermissionSet(false, false, false, false),
        'categorias_tramite' => new PermissionSet(false, false, false, false),
        'categorias_tramite.tipos_tramite' => new PermissionSet(false, false, false, false),
        'tipos_tramite' => new PermissionSet(false, false, false, false),
        'tipos_tramite.etapas_tramite' => new PermissionSet(false, false, false, false),
        'tipos_tramite.tramites' => new PermissionSet(false, false, false, false),
        'etapas_tramite' => new PermissionSet(false, false, false, false),
        'etapas_tramite.seguimiento_etapas' => new PermissionSet(false, false, false, false),
        'tramites' => new PermissionSet(false, false, false, false),
        'tramites.documentos' => new PermissionSet(false, false, false, false),
        'tramites.pagos' => new PermissionSet(false, false, false, false),
        'tramites.seguimiento_etapas' => new PermissionSet(false, false, false, false),
        'seguimiento_etapas' => new PermissionSet(false, false, false, false),
        'clientes' => new PermissionSet(false, false, false, false),
        'clientes.tramites' => new PermissionSet(false, false, false, false),
        'documentos' => new PermissionSet(false, false, false, false),
        'pagos' => new PermissionSet(false, false, false, false),
        'v_datos' => new PermissionSet(false, false, false, false),
        'v_estadisticas' => new PermissionSet(false, false, false, false))
    ,
    'admin@notaria.com' => 
        array('usuarios' => new PermissionSet(false, false, false, false),
        'usuarios.categorias_tramite' => new PermissionSet(false, false, false, false),
        'usuarios.clientes' => new PermissionSet(false, false, false, false),
        'usuarios.documentos' => new PermissionSet(false, false, false, false),
        'usuarios.etapas_tramite' => new PermissionSet(false, false, false, false),
        'usuarios.funcionarios' => new PermissionSet(false, false, false, false),
        'usuarios.funcionarios01' => new PermissionSet(false, false, false, false),
        'usuarios.pagos' => new PermissionSet(false, false, false, false),
        'usuarios.seguimiento_etapas' => new PermissionSet(false, false, false, false),
        'usuarios.tipos_funcionario' => new PermissionSet(false, false, false, false),
        'usuarios.tipos_tramite' => new PermissionSet(false, false, false, false),
        'usuarios.tramites' => new PermissionSet(false, false, false, false),
        'tipos_funcionario' => new PermissionSet(false, false, false, false),
        'tipos_funcionario.funcionarios' => new PermissionSet(false, false, false, false),
        'funcionarios' => new PermissionSet(false, false, false, false),
        'funcionarios.tramites' => new PermissionSet(false, false, false, false),
        'categorias_tramite' => new PermissionSet(false, false, false, false),
        'categorias_tramite.tipos_tramite' => new PermissionSet(false, false, false, false),
        'tipos_tramite' => new PermissionSet(false, false, false, false),
        'tipos_tramite.etapas_tramite' => new PermissionSet(false, false, false, false),
        'tipos_tramite.tramites' => new PermissionSet(false, false, false, false),
        'etapas_tramite' => new PermissionSet(false, false, false, false),
        'etapas_tramite.seguimiento_etapas' => new PermissionSet(false, false, false, false),
        'tramites' => new PermissionSet(false, false, false, false),
        'tramites.documentos' => new PermissionSet(false, false, false, false),
        'tramites.pagos' => new PermissionSet(false, false, false, false),
        'tramites.seguimiento_etapas' => new PermissionSet(false, false, false, false),
        'seguimiento_etapas' => new PermissionSet(false, false, false, false),
        'clientes' => new PermissionSet(false, false, false, false),
        'clientes.tramites' => new PermissionSet(false, false, false, false),
        'documentos' => new PermissionSet(false, false, false, false),
        'pagos' => new PermissionSet(false, false, false, false),
        'v_datos' => new PermissionSet(false, false, false, false),
        'v_estadisticas' => new PermissionSet(false, false, false, false))
    );

$appGrants = array('guest' => new PermissionSet(false, false, false, false),
    'defaultUser' => new PermissionSet(true, false, false, false),
    'admin@notaria.com' => new AdminPermissionSet());

$dataSourceRecordPermissions = array();

$tableCaptions = array('usuarios' => 'Usuarios',
'usuarios.categorias_tramite' => 'Usuarios->Categorias Tramite',
'usuarios.clientes' => 'Usuarios->Clientes',
'usuarios.documentos' => 'Usuarios->Documentos',
'usuarios.etapas_tramite' => 'Usuarios->Etapas Tramite',
'usuarios.funcionarios' => 'Usuarios->Funcionarios',
'usuarios.funcionarios01' => 'Usuarios->Funcionarios',
'usuarios.pagos' => 'Usuarios->Pagos',
'usuarios.seguimiento_etapas' => 'Usuarios->Seguimiento Etapas',
'usuarios.tipos_funcionario' => 'Usuarios->Tipos Funcionario',
'usuarios.tipos_tramite' => 'Usuarios->Tipos Tramite',
'usuarios.tramites' => 'Usuarios->Tramites',
'tipos_funcionario' => 'Tipos de Funcionario',
'tipos_funcionario.funcionarios' => 'Tipos de Funcionario->Funcionarios',
'funcionarios' => 'Funcionarios',
'funcionarios.tramites' => 'Funcionarios->Tramites',
'categorias_tramite' => 'Categorias de Tramite',
'categorias_tramite.tipos_tramite' => 'Categorias de Tramite->Tipos Tramite',
'tipos_tramite' => 'Tipos de Tramite',
'tipos_tramite.etapas_tramite' => 'Tipos de Tramite->Etapas Tramite',
'tipos_tramite.tramites' => 'Tipos de Tramite->Tramites',
'etapas_tramite' => 'Etapas de los Tramites',
'etapas_tramite.seguimiento_etapas' => 'Etapas de los Tramites->Seguimiento Etapas',
'tramites' => 'Tramites',
'tramites.documentos' => 'Tramites->Documentos',
'tramites.pagos' => 'Tramites->Pagos',
'tramites.seguimiento_etapas' => 'Tramites->Seguimiento Etapas',
'seguimiento_etapas' => 'Seguimiento de Etapas',
'clientes' => 'Clientes',
'clientes.tramites' => 'Clientes->Tramites',
'documentos' => 'Documentos',
'pagos' => 'Pagos',
'v_datos' => 'V Datos',
'v_estadisticas' => 'V Estadisticas');

$usersTableInfo = array(
    'TableName' => 'usuarios',
    'UserId' => 'id_usuario',
    'UserName' => 'email',
    'Password' => 'password',
    'Email' => '',
    'UserToken' => '',
    'UserStatus' => ''
);

function EncryptPassword($password, &$result)
{

}

function VerifyPassword($enteredPassword, $encryptedPassword, &$result)
{

}

function BeforeUserRegistration($userName, $email, $password, &$allowRegistration, &$errorMessage)
{

}    

function AfterUserRegistration($userName, $email)
{

}    

function PasswordResetRequest($userName, $email)
{

}

function PasswordResetComplete($userName, $email)
{

}

function VerifyPasswordStrength($password, &$result, &$passwordRuleMessage) 
{

}

function CreatePasswordHasher()
{
    $hasher = CreateHasher('SHA256');
    if ($hasher instanceof CustomStringHasher) {
        $hasher->OnEncryptPassword->AddListener('EncryptPassword');
        $hasher->OnVerifyPassword->AddListener('VerifyPassword');
    }
    return $hasher;
}

function CreateGrantManager() 
{
    global $grants;
    global $appGrants;
    
    return new HardCodedUserGrantManager($grants, $appGrants);
}

function CreateTableBasedUserManager() 
{
    global $usersTableInfo;

    $userManager = new TableBasedUserManager(MyPDOConnectionFactory::getInstance(), GetGlobalConnectionOptions(), 
        $usersTableInfo, CreatePasswordHasher(), false);
    $userManager->OnVerifyPasswordStrength->AddListener('VerifyPasswordStrength');

    return $userManager;
}

function GetReCaptcha($formId) 
{
    return null;
}

function SetUpUserAuthorization() 
{
    global $dataSourceRecordPermissions;

    $hasher = CreatePasswordHasher();

    $grantManager = CreateGrantManager();

    $userAuthentication = new TableBasedUserAuthentication(new UserIdentitySessionStorage(), false, $hasher, CreateTableBasedUserManager(), true, false, false);

    GetApplication()->SetUserAuthentication($userAuthentication);
    GetApplication()->SetUserGrantManager($grantManager);
    GetApplication()->SetDataSourceRecordPermissionRetrieveStrategy(new HardCodedDataSourceRecordPermissionRetrieveStrategy($dataSourceRecordPermissions));
}
