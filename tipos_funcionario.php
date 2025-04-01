<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *                                   ATTENTION!
 * If you see this message in your browser (Internet Explorer, Mozilla Firefox, Google Chrome, etc.)
 * this means that PHP is not properly installed on your web server. Please refer to the PHP manual
 * for more details: http://php.net/manual/install.php 
 *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 */

    include_once dirname(__FILE__) . '/components/startup.php';
    include_once dirname(__FILE__) . '/components/application.php';
    include_once dirname(__FILE__) . '/' . 'authorization.php';


    include_once dirname(__FILE__) . '/' . 'database_engine/mysql_engine.php';
    include_once dirname(__FILE__) . '/' . 'components/page/page_includes.php';

    function GetConnectionOptions()
    {
        $result = GetGlobalConnectionOptions();
        $result['client_encoding'] = 'utf8';
        GetApplication()->GetUserAuthentication()->applyIdentityToConnectionOptions($result);
        return $result;
    }

    
    
    
    
    // OnBeforePageExecute event handler
    
    
    
    class tipos_funcionario_funcionariosPage extends DetailPage
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Funcionarios');
            $this->SetMenuLabel('Funcionarios');
    
            $this->dataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`funcionarios`');
            $this->dataset->addFields(
                array(
                    new IntegerField('id_funcionario', true, true, true),
                    new IntegerField('id_usuario', true),
                    new IntegerField('id_tipo_funcionario', true),
                    new DateField('fecha_ingreso', true),
                    new IntegerField('id_estado', true),
                    new IntegerField('usuario_registro', true),
                    new DateTimeField('fecha_registro'),
                    new DateTimeField('fecha_modificacion'),
                    new StringField('nombre_completo', true)
                )
            );
            $this->dataset->AddLookupField('id_usuario', 'usuarios', new IntegerField('id_usuario'), new StringField('nombres', false, false, false, false, 'id_usuario_nombres', 'id_usuario_nombres_usuarios'), 'id_usuario_nombres_usuarios');
            $this->dataset->AddLookupField('id_tipo_funcionario', 'tipos_funcionario', new IntegerField('id_tipo_funcionario'), new StringField('nombre', false, false, false, false, 'id_tipo_funcionario_nombre', 'id_tipo_funcionario_nombre_tipos_funcionario'), 'id_tipo_funcionario_nombre_tipos_funcionario');
            $this->dataset->AddLookupField('usuario_registro', 'usuarios', new IntegerField('id_usuario'), new StringField('nombres', false, false, false, false, 'usuario_registro_nombres', 'usuario_registro_nombres_usuarios'), 'usuario_registro_nombres_usuarios');
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function CreatePageNavigator()
        {
            $result = new CompositePageNavigator($this);
            
            $partitionNavigator = new PageNavigator('pnav', $this, $this->dataset);
            $partitionNavigator->SetRowsPerPage(50);
            $result->AddPageNavigator($partitionNavigator);
            
            return $result;
        }
    
        protected function CreateRssGenerator()
        {
            return null;
        }
    
        protected function setupCharts()
        {
    
        }
    
        protected function getFiltersColumns()
        {
            return array(
                new FilterColumn($this->dataset, 'id_funcionario', 'id_funcionario', 'Id Funcionario'),
                new FilterColumn($this->dataset, 'id_usuario', 'id_usuario_nombres', 'Id Usuario'),
                new FilterColumn($this->dataset, 'id_tipo_funcionario', 'id_tipo_funcionario_nombre', 'Id Tipo Funcionario'),
                new FilterColumn($this->dataset, 'fecha_ingreso', 'fecha_ingreso', 'Fecha Ingreso'),
                new FilterColumn($this->dataset, 'usuario_registro', 'usuario_registro_nombres', 'Usuario Registro'),
                new FilterColumn($this->dataset, 'fecha_registro', 'fecha_registro', 'Fecha Registro'),
                new FilterColumn($this->dataset, 'fecha_modificacion', 'fecha_modificacion', 'Fecha Modificacion'),
                new FilterColumn($this->dataset, 'id_estado', 'id_estado', 'Id Estado'),
                new FilterColumn($this->dataset, 'nombre_completo', 'nombre_completo', 'Nombre Completo')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['id_funcionario'])
                ->addColumn($columns['id_usuario'])
                ->addColumn($columns['id_tipo_funcionario'])
                ->addColumn($columns['fecha_ingreso'])
                ->addColumn($columns['usuario_registro'])
                ->addColumn($columns['fecha_registro'])
                ->addColumn($columns['fecha_modificacion'])
                ->addColumn($columns['id_estado'])
                ->addColumn($columns['nombre_completo']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('id_usuario')
                ->setOptionsFor('id_tipo_funcionario')
                ->setOptionsFor('fecha_ingreso')
                ->setOptionsFor('usuario_registro')
                ->setOptionsFor('fecha_registro')
                ->setOptionsFor('fecha_modificacion')
                ->setOptionsFor('id_estado');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new TextEdit('id_funcionario_edit');
            
            $filterBuilder->addColumn(
                $columns['id_funcionario'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('id_usuario_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_tipos_funcionario_funcionarios_id_usuario_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('id_usuario', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_tipos_funcionario_funcionarios_id_usuario_search');
            
            $text_editor = new TextEdit('id_usuario');
            
            $filterBuilder->addColumn(
                $columns['id_usuario'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('id_tipo_funcionario_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_tipos_funcionario_funcionarios_id_tipo_funcionario_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('id_tipo_funcionario', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_tipos_funcionario_funcionarios_id_tipo_funcionario_search');
            
            $text_editor = new TextEdit('id_tipo_funcionario');
            
            $filterBuilder->addColumn(
                $columns['id_tipo_funcionario'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DateTimeEdit('fecha_ingreso_edit', false, 'Y-m-d');
            
            $filterBuilder->addColumn(
                $columns['fecha_ingreso'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::DATE_EQUALS => $main_editor,
                    FilterConditionOperator::DATE_DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::TODAY => null,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('usuario_registro_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_tipos_funcionario_funcionarios_usuario_registro_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('usuario_registro', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_tipos_funcionario_funcionarios_usuario_registro_search');
            
            $text_editor = new TextEdit('usuario_registro');
            
            $filterBuilder->addColumn(
                $columns['usuario_registro'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DateTimeEdit('fecha_registro_edit', false, 'Y-m-d H:i:s');
            
            $filterBuilder->addColumn(
                $columns['fecha_registro'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::DATE_EQUALS => $main_editor,
                    FilterConditionOperator::DATE_DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::TODAY => null,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DateTimeEdit('fecha_modificacion_edit', false, 'Y-m-d H:i:s');
            
            $filterBuilder->addColumn(
                $columns['fecha_modificacion'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::DATE_EQUALS => $main_editor,
                    FilterConditionOperator::DATE_DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::TODAY => null,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('id_estado_edit');
            
            $filterBuilder->addColumn(
                $columns['id_estado'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('nombre_completo_edit');
            $main_editor->SetMaxLength(100);
            
            $filterBuilder->addColumn(
                $columns['nombre_completo'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
        }
    
        protected function AddOperationsColumns(Grid $grid)
        {
            $actions = $grid->getActions();
            $actions->setCaption($this->GetLocalizerCaptions()->GetMessageString('Actions'));
            $actions->setPosition(ActionList::POSITION_LEFT);
            
            if ($this->GetSecurityInfo()->HasViewGrant()) {
            
                $operation = new AjaxOperation(OPERATION_VIEW,
                    $this->GetLocalizerCaptions()->GetMessageString('View'),
                    $this->GetLocalizerCaptions()->GetMessageString('View'), $this->dataset,
                    $this->GetModalGridViewHandler(), $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
            
            if ($this->GetSecurityInfo()->HasEditGrant())
            {
                $operation = new AjaxOperation(OPERATION_EDIT,
                    $this->GetLocalizerCaptions()->GetMessageString('Edit'),
                    $this->GetLocalizerCaptions()->GetMessageString('Edit'), $this->dataset,
                    $this->GetGridEditHandler(), $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowEditButtonHandler', $this);
            }
            
            if ($this->deleteOperationIsAllowed()) {
                $operation = new AjaxOperation(OPERATION_DELETE,
                    $this->GetLocalizerCaptions()->GetMessageString('Delete'),
                    $this->GetLocalizerCaptions()->GetMessageString('Delete'), $this->dataset,
                    $this->GetModalGridDeleteHandler(), $grid
                );
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowDeleteButtonHandler', $this);
            }
            
            
            if ($this->GetSecurityInfo()->HasAddGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Copy'), OPERATION_COPY, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
        }
    
        protected function AddFieldColumns(Grid $grid, $withDetails = true)
        {
            //
            // View column for id_funcionario field
            //
            $column = new NumberViewColumn('id_funcionario', 'id_funcionario', 'Id Funcionario', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for nombres field
            //
            $column = new TextViewColumn('id_usuario', 'id_usuario_nombres', 'Id Usuario', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for nombre field
            //
            $column = new TextViewColumn('id_tipo_funcionario', 'id_tipo_funcionario_nombre', 'Id Tipo Funcionario', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for fecha_ingreso field
            //
            $column = new DateTimeViewColumn('fecha_ingreso', 'fecha_ingreso', 'Fecha Ingreso', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for nombres field
            //
            $column = new TextViewColumn('usuario_registro', 'usuario_registro_nombres', 'Usuario Registro', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for fecha_registro field
            //
            $column = new DateTimeViewColumn('fecha_registro', 'fecha_registro', 'Fecha Registro', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d H:i:s');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for fecha_modificacion field
            //
            $column = new DateTimeViewColumn('fecha_modificacion', 'fecha_modificacion', 'Fecha Modificacion', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d H:i:s');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for id_estado field
            //
            $column = new TextViewColumn('id_estado', 'id_estado', 'Id Estado', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for nombre_completo field
            //
            $column = new TextViewColumn('nombre_completo', 'nombre_completo', 'Nombre Completo', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for id_funcionario field
            //
            $column = new NumberViewColumn('id_funcionario', 'id_funcionario', 'Id Funcionario', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for nombres field
            //
            $column = new TextViewColumn('id_usuario', 'id_usuario_nombres', 'Id Usuario', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for nombre field
            //
            $column = new TextViewColumn('id_tipo_funcionario', 'id_tipo_funcionario_nombre', 'Id Tipo Funcionario', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for fecha_ingreso field
            //
            $column = new DateTimeViewColumn('fecha_ingreso', 'fecha_ingreso', 'Fecha Ingreso', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for nombres field
            //
            $column = new TextViewColumn('usuario_registro', 'usuario_registro_nombres', 'Usuario Registro', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for fecha_registro field
            //
            $column = new DateTimeViewColumn('fecha_registro', 'fecha_registro', 'Fecha Registro', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d H:i:s');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for fecha_modificacion field
            //
            $column = new DateTimeViewColumn('fecha_modificacion', 'fecha_modificacion', 'Fecha Modificacion', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d H:i:s');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for id_estado field
            //
            $column = new TextViewColumn('id_estado', 'id_estado', 'Id Estado', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for nombre_completo field
            //
            $column = new TextViewColumn('nombre_completo', 'nombre_completo', 'Nombre Completo', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for id_usuario field
            //
            $editor = new DynamicCombobox('id_usuario_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`usuarios`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_usuario', true, true, true),
                    new StringField('nombres', true),
                    new StringField('apellidos', true),
                    new StringField('carnet_identidad', true),
                    new StringField('email', true),
                    new StringField('password', true),
                    new IntegerField('id_estado', true),
                    new IntegerField('usuario_registro'),
                    new DateTimeField('fecha_registro'),
                    new DateTimeField('fecha_modificacion'),
                    new StringField('nombre_completo', true)
                )
            );
            $lookupDataset->setOrderByField('nombres', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Usuario', 'id_usuario', 'id_usuario_nombres', 'edit_tipos_funcionario_funcionarios_id_usuario_search', $editor, $this->dataset, $lookupDataset, 'id_usuario', 'nombres', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for id_tipo_funcionario field
            //
            $editor = new DynamicCombobox('id_tipo_funcionario_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tipos_funcionario`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_tipo_funcionario', true, true, true),
                    new StringField('nombre', true),
                    new StringField('descripcion'),
                    new IntegerField('usuario_registro', true),
                    new DateTimeField('fecha_registro'),
                    new DateTimeField('fecha_modificacion')
                )
            );
            $lookupDataset->setOrderByField('nombre', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Tipo Funcionario', 'id_tipo_funcionario', 'id_tipo_funcionario_nombre', 'edit_tipos_funcionario_funcionarios_id_tipo_funcionario_search', $editor, $this->dataset, $lookupDataset, 'id_tipo_funcionario', 'nombre', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for fecha_ingreso field
            //
            $editor = new DateTimeEdit('fecha_ingreso_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Fecha Ingreso', 'fecha_ingreso', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for usuario_registro field
            //
            $editor = new DynamicCombobox('usuario_registro_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`usuarios`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_usuario', true, true, true),
                    new StringField('nombres', true),
                    new StringField('apellidos', true),
                    new StringField('carnet_identidad', true),
                    new StringField('email', true),
                    new StringField('password', true),
                    new IntegerField('id_estado', true),
                    new IntegerField('usuario_registro'),
                    new DateTimeField('fecha_registro'),
                    new DateTimeField('fecha_modificacion'),
                    new StringField('nombre_completo', true)
                )
            );
            $lookupDataset->setOrderByField('nombres', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Usuario Registro', 'usuario_registro', 'usuario_registro_nombres', 'edit_tipos_funcionario_funcionarios_usuario_registro_search', $editor, $this->dataset, $lookupDataset, 'id_usuario', 'nombres', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for fecha_registro field
            //
            $editor = new DateTimeEdit('fecha_registro_edit', false, 'Y-m-d H:i:s');
            $editColumn = new CustomEditColumn('Fecha Registro', 'fecha_registro', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for fecha_modificacion field
            //
            $editor = new DateTimeEdit('fecha_modificacion_edit', false, 'Y-m-d H:i:s');
            $editColumn = new CustomEditColumn('Fecha Modificacion', 'fecha_modificacion', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for id_estado field
            //
            $editor = new TextEdit('id_estado_edit');
            $editColumn = new CustomEditColumn('Id Estado', 'id_estado', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for nombre_completo field
            //
            $editor = new TextEdit('nombre_completo_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Nombre Completo', 'nombre_completo', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for id_usuario field
            //
            $editor = new DynamicCombobox('id_usuario_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`usuarios`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_usuario', true, true, true),
                    new StringField('nombres', true),
                    new StringField('apellidos', true),
                    new StringField('carnet_identidad', true),
                    new StringField('email', true),
                    new StringField('password', true),
                    new IntegerField('id_estado', true),
                    new IntegerField('usuario_registro'),
                    new DateTimeField('fecha_registro'),
                    new DateTimeField('fecha_modificacion'),
                    new StringField('nombre_completo', true)
                )
            );
            $lookupDataset->setOrderByField('nombres', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Usuario', 'id_usuario', 'id_usuario_nombres', 'multi_edit_tipos_funcionario_funcionarios_id_usuario_search', $editor, $this->dataset, $lookupDataset, 'id_usuario', 'nombres', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for id_tipo_funcionario field
            //
            $editor = new DynamicCombobox('id_tipo_funcionario_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tipos_funcionario`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_tipo_funcionario', true, true, true),
                    new StringField('nombre', true),
                    new StringField('descripcion'),
                    new IntegerField('usuario_registro', true),
                    new DateTimeField('fecha_registro'),
                    new DateTimeField('fecha_modificacion')
                )
            );
            $lookupDataset->setOrderByField('nombre', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Tipo Funcionario', 'id_tipo_funcionario', 'id_tipo_funcionario_nombre', 'multi_edit_tipos_funcionario_funcionarios_id_tipo_funcionario_search', $editor, $this->dataset, $lookupDataset, 'id_tipo_funcionario', 'nombre', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for fecha_ingreso field
            //
            $editor = new DateTimeEdit('fecha_ingreso_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Fecha Ingreso', 'fecha_ingreso', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for usuario_registro field
            //
            $editor = new DynamicCombobox('usuario_registro_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`usuarios`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_usuario', true, true, true),
                    new StringField('nombres', true),
                    new StringField('apellidos', true),
                    new StringField('carnet_identidad', true),
                    new StringField('email', true),
                    new StringField('password', true),
                    new IntegerField('id_estado', true),
                    new IntegerField('usuario_registro'),
                    new DateTimeField('fecha_registro'),
                    new DateTimeField('fecha_modificacion'),
                    new StringField('nombre_completo', true)
                )
            );
            $lookupDataset->setOrderByField('nombres', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Usuario Registro', 'usuario_registro', 'usuario_registro_nombres', 'multi_edit_tipos_funcionario_funcionarios_usuario_registro_search', $editor, $this->dataset, $lookupDataset, 'id_usuario', 'nombres', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for fecha_registro field
            //
            $editor = new DateTimeEdit('fecha_registro_edit', false, 'Y-m-d H:i:s');
            $editColumn = new CustomEditColumn('Fecha Registro', 'fecha_registro', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for fecha_modificacion field
            //
            $editor = new DateTimeEdit('fecha_modificacion_edit', false, 'Y-m-d H:i:s');
            $editColumn = new CustomEditColumn('Fecha Modificacion', 'fecha_modificacion', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for id_estado field
            //
            $editor = new TextEdit('id_estado_edit');
            $editColumn = new CustomEditColumn('Id Estado', 'id_estado', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for nombre_completo field
            //
            $editor = new TextEdit('nombre_completo_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Nombre Completo', 'nombre_completo', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
        }
    
        protected function AddToggleEditColumns(Grid $grid)
        {
    
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for id_usuario field
            //
            $editor = new DynamicCombobox('id_usuario_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`usuarios`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_usuario', true, true, true),
                    new StringField('nombres', true),
                    new StringField('apellidos', true),
                    new StringField('carnet_identidad', true),
                    new StringField('email', true),
                    new StringField('password', true),
                    new IntegerField('id_estado', true),
                    new IntegerField('usuario_registro'),
                    new DateTimeField('fecha_registro'),
                    new DateTimeField('fecha_modificacion'),
                    new StringField('nombre_completo', true)
                )
            );
            $lookupDataset->setOrderByField('nombres', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Usuario', 'id_usuario', 'id_usuario_nombres', 'insert_tipos_funcionario_funcionarios_id_usuario_search', $editor, $this->dataset, $lookupDataset, 'id_usuario', 'nombres', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for id_tipo_funcionario field
            //
            $editor = new DynamicCombobox('id_tipo_funcionario_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tipos_funcionario`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_tipo_funcionario', true, true, true),
                    new StringField('nombre', true),
                    new StringField('descripcion'),
                    new IntegerField('usuario_registro', true),
                    new DateTimeField('fecha_registro'),
                    new DateTimeField('fecha_modificacion')
                )
            );
            $lookupDataset->setOrderByField('nombre', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Tipo Funcionario', 'id_tipo_funcionario', 'id_tipo_funcionario_nombre', 'insert_tipos_funcionario_funcionarios_id_tipo_funcionario_search', $editor, $this->dataset, $lookupDataset, 'id_tipo_funcionario', 'nombre', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for fecha_ingreso field
            //
            $editor = new DateTimeEdit('fecha_ingreso_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Fecha Ingreso', 'fecha_ingreso', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for usuario_registro field
            //
            $editor = new DynamicCombobox('usuario_registro_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`usuarios`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_usuario', true, true, true),
                    new StringField('nombres', true),
                    new StringField('apellidos', true),
                    new StringField('carnet_identidad', true),
                    new StringField('email', true),
                    new StringField('password', true),
                    new IntegerField('id_estado', true),
                    new IntegerField('usuario_registro'),
                    new DateTimeField('fecha_registro'),
                    new DateTimeField('fecha_modificacion'),
                    new StringField('nombre_completo', true)
                )
            );
            $lookupDataset->setOrderByField('nombres', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Usuario Registro', 'usuario_registro', 'usuario_registro_nombres', 'insert_tipos_funcionario_funcionarios_usuario_registro_search', $editor, $this->dataset, $lookupDataset, 'id_usuario', 'nombres', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for fecha_registro field
            //
            $editor = new DateTimeEdit('fecha_registro_edit', false, 'Y-m-d H:i:s');
            $editColumn = new CustomEditColumn('Fecha Registro', 'fecha_registro', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for fecha_modificacion field
            //
            $editor = new DateTimeEdit('fecha_modificacion_edit', false, 'Y-m-d H:i:s');
            $editColumn = new CustomEditColumn('Fecha Modificacion', 'fecha_modificacion', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for id_estado field
            //
            $editor = new TextEdit('id_estado_edit');
            $editColumn = new CustomEditColumn('Id Estado', 'id_estado', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for nombre_completo field
            //
            $editor = new TextEdit('nombre_completo_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Nombre Completo', 'nombre_completo', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            $grid->SetShowAddButton(true && $this->GetSecurityInfo()->HasAddGrant());
        }
    
        private function AddMultiUploadColumn(Grid $grid)
        {
    
        }
    
        protected function AddPrintColumns(Grid $grid)
        {
            //
            // View column for id_funcionario field
            //
            $column = new NumberViewColumn('id_funcionario', 'id_funcionario', 'Id Funcionario', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for nombres field
            //
            $column = new TextViewColumn('id_usuario', 'id_usuario_nombres', 'Id Usuario', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for nombre field
            //
            $column = new TextViewColumn('id_tipo_funcionario', 'id_tipo_funcionario_nombre', 'Id Tipo Funcionario', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for fecha_ingreso field
            //
            $column = new DateTimeViewColumn('fecha_ingreso', 'fecha_ingreso', 'Fecha Ingreso', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddPrintColumn($column);
            
            //
            // View column for nombres field
            //
            $column = new TextViewColumn('usuario_registro', 'usuario_registro_nombres', 'Usuario Registro', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for fecha_registro field
            //
            $column = new DateTimeViewColumn('fecha_registro', 'fecha_registro', 'Fecha Registro', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d H:i:s');
            $grid->AddPrintColumn($column);
            
            //
            // View column for fecha_modificacion field
            //
            $column = new DateTimeViewColumn('fecha_modificacion', 'fecha_modificacion', 'Fecha Modificacion', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d H:i:s');
            $grid->AddPrintColumn($column);
            
            //
            // View column for id_estado field
            //
            $column = new TextViewColumn('id_estado', 'id_estado', 'Id Estado', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for nombre_completo field
            //
            $column = new TextViewColumn('nombre_completo', 'nombre_completo', 'Nombre Completo', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for id_funcionario field
            //
            $column = new NumberViewColumn('id_funcionario', 'id_funcionario', 'Id Funcionario', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for nombres field
            //
            $column = new TextViewColumn('id_usuario', 'id_usuario_nombres', 'Id Usuario', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for nombre field
            //
            $column = new TextViewColumn('id_tipo_funcionario', 'id_tipo_funcionario_nombre', 'Id Tipo Funcionario', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for fecha_ingreso field
            //
            $column = new DateTimeViewColumn('fecha_ingreso', 'fecha_ingreso', 'Fecha Ingreso', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddExportColumn($column);
            
            //
            // View column for nombres field
            //
            $column = new TextViewColumn('usuario_registro', 'usuario_registro_nombres', 'Usuario Registro', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for fecha_registro field
            //
            $column = new DateTimeViewColumn('fecha_registro', 'fecha_registro', 'Fecha Registro', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d H:i:s');
            $grid->AddExportColumn($column);
            
            //
            // View column for fecha_modificacion field
            //
            $column = new DateTimeViewColumn('fecha_modificacion', 'fecha_modificacion', 'Fecha Modificacion', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d H:i:s');
            $grid->AddExportColumn($column);
            
            //
            // View column for id_estado field
            //
            $column = new TextViewColumn('id_estado', 'id_estado', 'Id Estado', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for nombre_completo field
            //
            $column = new TextViewColumn('nombre_completo', 'nombre_completo', 'Nombre Completo', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for nombres field
            //
            $column = new TextViewColumn('id_usuario', 'id_usuario_nombres', 'Id Usuario', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for nombre field
            //
            $column = new TextViewColumn('id_tipo_funcionario', 'id_tipo_funcionario_nombre', 'Id Tipo Funcionario', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for fecha_ingreso field
            //
            $column = new DateTimeViewColumn('fecha_ingreso', 'fecha_ingreso', 'Fecha Ingreso', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddCompareColumn($column);
            
            //
            // View column for nombres field
            //
            $column = new TextViewColumn('usuario_registro', 'usuario_registro_nombres', 'Usuario Registro', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for fecha_registro field
            //
            $column = new DateTimeViewColumn('fecha_registro', 'fecha_registro', 'Fecha Registro', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d H:i:s');
            $grid->AddCompareColumn($column);
            
            //
            // View column for fecha_modificacion field
            //
            $column = new DateTimeViewColumn('fecha_modificacion', 'fecha_modificacion', 'Fecha Modificacion', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d H:i:s');
            $grid->AddCompareColumn($column);
            
            //
            // View column for id_estado field
            //
            $column = new TextViewColumn('id_estado', 'id_estado', 'Id Estado', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for nombre_completo field
            //
            $column = new TextViewColumn('nombre_completo', 'nombre_completo', 'Nombre Completo', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
        }
    
        private function AddCompareHeaderColumns(Grid $grid)
        {
    
        }
    
        public function GetPageDirection()
        {
            return null;
        }
    
        public function isFilterConditionRequired()
        {
            return false;
        }
    
        protected function ApplyCommonColumnEditProperties(CustomEditColumn $column)
        {
            $column->SetDisplaySetToNullCheckBox(false);
            $column->SetDisplaySetToDefaultCheckBox(false);
    		$column->SetVariableContainer($this->GetColumnVariableContainer());
        }
    
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
        
        public function GetEnableModalGridInsert() { return true; }
        public function GetEnableModalSingleRecordView() { return true; }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset);
            if ($this->GetSecurityInfo()->HasDeleteGrant())
               $result->SetAllowDeleteSelected(true);
            else
               $result->SetAllowDeleteSelected(false);   
            
            ApplyCommonPageSettings($this, $result);
            
            $result->SetUseImagesForActions(true);
            $result->SetUseFixedHeader(true);
            $result->SetShowLineNumbers(false);
            $result->SetShowKeyColumnsImagesInHeader(false);
            $result->SetViewMode(ViewMode::TABLE);
            $result->setEnableRuntimeCustomization(true);
            $result->setAllowCompare(true);
            $this->AddCompareHeaderColumns($result);
            $this->AddCompareColumns($result);
            $result->setMultiEditAllowed($this->GetSecurityInfo()->HasEditGrant() && true);
            $result->setTableBordered(false);
            $result->setTableCondensed(true);
            
            $result->SetHighlightRowAtHover(true);
            $result->SetWidth('');
            $this->AddOperationsColumns($result);
            $this->AddFieldColumns($result);
            $this->AddSingleRecordViewColumns($result);
            $this->AddEditColumns($result);
            $this->AddMultiEditColumns($result);
            $this->AddToggleEditColumns($result);
            $this->AddInsertColumns($result);
            $this->AddPrintColumns($result);
            $this->AddExportColumns($result);
            $this->AddMultiUploadColumn($result);
    
    
            $this->SetShowPageList(true);
            $this->SetShowTopPageNavigator(true);
            $this->SetShowBottomPageNavigator(true);
            $this->setAllowedActions(array('view', 'insert', 'copy', 'edit', 'multi-edit', 'delete', 'multi-delete'));
            $this->setPrintListAvailable(true);
            $this->setPrintListRecordAvailable(false);
            $this->setPrintOneRecordAvailable(true);
            $this->setAllowPrintSelectedRecords(true);
            $this->setExportListAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportSelectedRecordsAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportListRecordAvailable(array());
            $this->setExportOneRecordAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
    
            return $result;
        }
     
        protected function setClientSideEvents(Grid $grid) {
    
        }
    
        protected function doRegisterHandlers() {
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`usuarios`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_usuario', true, true, true),
                    new StringField('nombres', true),
                    new StringField('apellidos', true),
                    new StringField('carnet_identidad', true),
                    new StringField('email', true),
                    new StringField('password', true),
                    new IntegerField('id_estado', true),
                    new IntegerField('usuario_registro'),
                    new DateTimeField('fecha_registro'),
                    new DateTimeField('fecha_modificacion'),
                    new StringField('nombre_completo', true)
                )
            );
            $lookupDataset->setOrderByField('nombres', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'insert_tipos_funcionario_funcionarios_id_usuario_search', 'id_usuario', 'nombres', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tipos_funcionario`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_tipo_funcionario', true, true, true),
                    new StringField('nombre', true),
                    new StringField('descripcion'),
                    new IntegerField('usuario_registro', true),
                    new DateTimeField('fecha_registro'),
                    new DateTimeField('fecha_modificacion')
                )
            );
            $lookupDataset->setOrderByField('nombre', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'insert_tipos_funcionario_funcionarios_id_tipo_funcionario_search', 'id_tipo_funcionario', 'nombre', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`usuarios`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_usuario', true, true, true),
                    new StringField('nombres', true),
                    new StringField('apellidos', true),
                    new StringField('carnet_identidad', true),
                    new StringField('email', true),
                    new StringField('password', true),
                    new IntegerField('id_estado', true),
                    new IntegerField('usuario_registro'),
                    new DateTimeField('fecha_registro'),
                    new DateTimeField('fecha_modificacion'),
                    new StringField('nombre_completo', true)
                )
            );
            $lookupDataset->setOrderByField('nombres', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'insert_tipos_funcionario_funcionarios_usuario_registro_search', 'id_usuario', 'nombres', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`usuarios`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_usuario', true, true, true),
                    new StringField('nombres', true),
                    new StringField('apellidos', true),
                    new StringField('carnet_identidad', true),
                    new StringField('email', true),
                    new StringField('password', true),
                    new IntegerField('id_estado', true),
                    new IntegerField('usuario_registro'),
                    new DateTimeField('fecha_registro'),
                    new DateTimeField('fecha_modificacion'),
                    new StringField('nombre_completo', true)
                )
            );
            $lookupDataset->setOrderByField('nombres', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'filter_builder_tipos_funcionario_funcionarios_id_usuario_search', 'id_usuario', 'nombres', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tipos_funcionario`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_tipo_funcionario', true, true, true),
                    new StringField('nombre', true),
                    new StringField('descripcion'),
                    new IntegerField('usuario_registro', true),
                    new DateTimeField('fecha_registro'),
                    new DateTimeField('fecha_modificacion')
                )
            );
            $lookupDataset->setOrderByField('nombre', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'filter_builder_tipos_funcionario_funcionarios_id_tipo_funcionario_search', 'id_tipo_funcionario', 'nombre', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`usuarios`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_usuario', true, true, true),
                    new StringField('nombres', true),
                    new StringField('apellidos', true),
                    new StringField('carnet_identidad', true),
                    new StringField('email', true),
                    new StringField('password', true),
                    new IntegerField('id_estado', true),
                    new IntegerField('usuario_registro'),
                    new DateTimeField('fecha_registro'),
                    new DateTimeField('fecha_modificacion'),
                    new StringField('nombre_completo', true)
                )
            );
            $lookupDataset->setOrderByField('nombres', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'filter_builder_tipos_funcionario_funcionarios_usuario_registro_search', 'id_usuario', 'nombres', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`usuarios`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_usuario', true, true, true),
                    new StringField('nombres', true),
                    new StringField('apellidos', true),
                    new StringField('carnet_identidad', true),
                    new StringField('email', true),
                    new StringField('password', true),
                    new IntegerField('id_estado', true),
                    new IntegerField('usuario_registro'),
                    new DateTimeField('fecha_registro'),
                    new DateTimeField('fecha_modificacion'),
                    new StringField('nombre_completo', true)
                )
            );
            $lookupDataset->setOrderByField('nombres', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'edit_tipos_funcionario_funcionarios_id_usuario_search', 'id_usuario', 'nombres', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tipos_funcionario`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_tipo_funcionario', true, true, true),
                    new StringField('nombre', true),
                    new StringField('descripcion'),
                    new IntegerField('usuario_registro', true),
                    new DateTimeField('fecha_registro'),
                    new DateTimeField('fecha_modificacion')
                )
            );
            $lookupDataset->setOrderByField('nombre', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'edit_tipos_funcionario_funcionarios_id_tipo_funcionario_search', 'id_tipo_funcionario', 'nombre', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`usuarios`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_usuario', true, true, true),
                    new StringField('nombres', true),
                    new StringField('apellidos', true),
                    new StringField('carnet_identidad', true),
                    new StringField('email', true),
                    new StringField('password', true),
                    new IntegerField('id_estado', true),
                    new IntegerField('usuario_registro'),
                    new DateTimeField('fecha_registro'),
                    new DateTimeField('fecha_modificacion'),
                    new StringField('nombre_completo', true)
                )
            );
            $lookupDataset->setOrderByField('nombres', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'edit_tipos_funcionario_funcionarios_usuario_registro_search', 'id_usuario', 'nombres', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`usuarios`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_usuario', true, true, true),
                    new StringField('nombres', true),
                    new StringField('apellidos', true),
                    new StringField('carnet_identidad', true),
                    new StringField('email', true),
                    new StringField('password', true),
                    new IntegerField('id_estado', true),
                    new IntegerField('usuario_registro'),
                    new DateTimeField('fecha_registro'),
                    new DateTimeField('fecha_modificacion'),
                    new StringField('nombre_completo', true)
                )
            );
            $lookupDataset->setOrderByField('nombres', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'multi_edit_tipos_funcionario_funcionarios_id_usuario_search', 'id_usuario', 'nombres', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tipos_funcionario`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_tipo_funcionario', true, true, true),
                    new StringField('nombre', true),
                    new StringField('descripcion'),
                    new IntegerField('usuario_registro', true),
                    new DateTimeField('fecha_registro'),
                    new DateTimeField('fecha_modificacion')
                )
            );
            $lookupDataset->setOrderByField('nombre', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'multi_edit_tipos_funcionario_funcionarios_id_tipo_funcionario_search', 'id_tipo_funcionario', 'nombre', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`usuarios`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_usuario', true, true, true),
                    new StringField('nombres', true),
                    new StringField('apellidos', true),
                    new StringField('carnet_identidad', true),
                    new StringField('email', true),
                    new StringField('password', true),
                    new IntegerField('id_estado', true),
                    new IntegerField('usuario_registro'),
                    new DateTimeField('fecha_registro'),
                    new DateTimeField('fecha_modificacion'),
                    new StringField('nombre_completo', true)
                )
            );
            $lookupDataset->setOrderByField('nombres', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'multi_edit_tipos_funcionario_funcionarios_usuario_registro_search', 'id_usuario', 'nombres', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
        }
       
        protected function doCustomRenderColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderPrintColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderExportColumn($exportType, $fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomDrawRow($rowData, &$cellFontColor, &$cellFontSize, &$cellBgColor, &$cellItalicAttr, &$cellBoldAttr)
        {
    
        }
    
        protected function doExtendedCustomDrawRow($rowData, &$rowCellStyles, &$rowStyles, &$rowClasses, &$cellClasses)
        {
    
        }
    
        protected function doCustomRenderTotal($totalValue, $aggregate, $columnName, &$customText, &$handled)
        {
    
        }
    
        protected function doCustomDefaultValues(&$values, &$handled) 
        {
    
        }
    
        protected function doCustomCompareColumn($columnName, $valueA, $valueB, &$result)
        {
    
        }
    
        protected function doBeforeInsertRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doBeforeUpdateRecord($page, $oldRowData, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doBeforeDeleteRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterInsertRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterUpdateRecord($page, $oldRowData, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterDeleteRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doCustomHTMLHeader($page, &$customHtmlHeaderText)
        { 
    
        }
    
        protected function doGetCustomTemplate($type, $part, $mode, &$result, &$params)
        {
    
        }
    
        protected function doGetCustomExportOptions(Page $page, $exportType, $rowData, &$options)
        {
    
        }
    
        protected function doFileUpload($fieldName, $rowData, &$result, &$accept, $originalFileName, $originalFileExtension, $fileSize, $tempFileName)
        {
    
        }
    
        protected function doPrepareChart(Chart $chart)
        {
    
        }
    
        protected function doPrepareColumnFilter(ColumnFilter $columnFilter)
        {
    
        }
    
        protected function doPrepareFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
    
        }
    
        protected function doGetSelectionFilters(FixedKeysArray $columns, &$result)
        {
    
        }
    
        protected function doGetCustomFormLayout($mode, FixedKeysArray $columns, FormLayout $layout)
        {
    
        }
    
        protected function doGetCustomColumnGroup(FixedKeysArray $columns, ViewColumnGroup $columnGroup)
        {
    
        }
    
        protected function doPageLoaded()
        {
    
        }
    
        protected function doCalculateFields($rowData, $fieldName, &$value)
        {
    
        }
    
        protected function doGetCustomRecordPermissions(Page $page, &$usingCondition, $rowData, &$allowEdit, &$allowDelete, &$mergeWithDefault, &$handled)
        {
    
        }
    
        protected function doAddEnvironmentVariables(Page $page, &$variables)
        {
    
        }
    
    }
    
    // OnBeforePageExecute event handler
    
    
    
    class tipos_funcionarioPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Tipos de Funcionario');
            $this->SetMenuLabel('Tipos de Funcionario');
    
            $this->dataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tipos_funcionario`');
            $this->dataset->addFields(
                array(
                    new IntegerField('id_tipo_funcionario', true, true, true),
                    new StringField('nombre', true),
                    new StringField('descripcion'),
                    new IntegerField('usuario_registro', true),
                    new DateTimeField('fecha_registro'),
                    new DateTimeField('fecha_modificacion')
                )
            );
            $this->dataset->AddLookupField('usuario_registro', 'usuarios', new IntegerField('id_usuario'), new StringField('nombre_completo', false, false, false, false, 'usuario_registro_nombre_completo', 'usuario_registro_nombre_completo_usuarios'), 'usuario_registro_nombre_completo_usuarios');
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function CreatePageNavigator()
        {
            $result = new CompositePageNavigator($this);
            
            $partitionNavigator = new PageNavigator('pnav', $this, $this->dataset);
            $partitionNavigator->SetRowsPerPage(50);
            $result->AddPageNavigator($partitionNavigator);
            
            return $result;
        }
    
        protected function CreateRssGenerator()
        {
            return null;
        }
    
        protected function setupCharts()
        {
    
        }
    
        protected function getFiltersColumns()
        {
            return array(
                new FilterColumn($this->dataset, 'id_tipo_funcionario', 'id_tipo_funcionario', 'Id'),
                new FilterColumn($this->dataset, 'nombre', 'nombre', 'Nombre de Funcion'),
                new FilterColumn($this->dataset, 'descripcion', 'descripcion', 'Descripcion'),
                new FilterColumn($this->dataset, 'usuario_registro', 'usuario_registro_nombre_completo', 'Registrado por:'),
                new FilterColumn($this->dataset, 'fecha_registro', 'fecha_registro', 'Fecha de Registro'),
                new FilterColumn($this->dataset, 'fecha_modificacion', 'fecha_modificacion', 'Fecha de Modificacion')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['id_tipo_funcionario'])
                ->addColumn($columns['nombre'])
                ->addColumn($columns['descripcion'])
                ->addColumn($columns['usuario_registro'])
                ->addColumn($columns['fecha_registro'])
                ->addColumn($columns['fecha_modificacion']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('usuario_registro')
                ->setOptionsFor('fecha_registro')
                ->setOptionsFor('fecha_modificacion');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new TextEdit('id_tipo_funcionario_edit');
            
            $filterBuilder->addColumn(
                $columns['id_tipo_funcionario'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('nombre_edit');
            $main_editor->SetMaxLength(50);
            
            $filterBuilder->addColumn(
                $columns['nombre'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('descripcion');
            
            $filterBuilder->addColumn(
                $columns['descripcion'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('usuario_registro_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_tipos_funcionario_usuario_registro_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('usuario_registro', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_tipos_funcionario_usuario_registro_search');
            
            $text_editor = new TextEdit('usuario_registro');
            
            $filterBuilder->addColumn(
                $columns['usuario_registro'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DateTimeEdit('fecha_registro_edit', false, 'Y-m-d H:i:s');
            
            $filterBuilder->addColumn(
                $columns['fecha_registro'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::DATE_EQUALS => $main_editor,
                    FilterConditionOperator::DATE_DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::TODAY => null,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DateTimeEdit('fecha_modificacion_edit', false, 'Y-m-d H:i:s');
            
            $filterBuilder->addColumn(
                $columns['fecha_modificacion'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::DATE_EQUALS => $main_editor,
                    FilterConditionOperator::DATE_DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::TODAY => null,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
        }
    
        protected function AddOperationsColumns(Grid $grid)
        {
            $actions = $grid->getActions();
            $actions->setCaption($this->GetLocalizerCaptions()->GetMessageString('Actions'));
            $actions->setPosition(ActionList::POSITION_LEFT);
            
            if ($this->GetSecurityInfo()->HasViewGrant()) {
            
                $operation = new AjaxOperation(OPERATION_VIEW,
                    $this->GetLocalizerCaptions()->GetMessageString('View'),
                    $this->GetLocalizerCaptions()->GetMessageString('View'), $this->dataset,
                    $this->GetModalGridViewHandler(), $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
            
            if ($this->GetSecurityInfo()->HasEditGrant())
            {
                $operation = new AjaxOperation(OPERATION_EDIT,
                    $this->GetLocalizerCaptions()->GetMessageString('Edit'),
                    $this->GetLocalizerCaptions()->GetMessageString('Edit'), $this->dataset,
                    $this->GetGridEditHandler(), $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowEditButtonHandler', $this);
            }
            
            if ($this->deleteOperationIsAllowed()) {
                $operation = new AjaxOperation(OPERATION_DELETE,
                    $this->GetLocalizerCaptions()->GetMessageString('Delete'),
                    $this->GetLocalizerCaptions()->GetMessageString('Delete'), $this->dataset,
                    $this->GetModalGridDeleteHandler(), $grid
                );
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowDeleteButtonHandler', $this);
            }
            
            
            if ($this->GetSecurityInfo()->HasAddGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Copy'), OPERATION_COPY, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
        }
    
        protected function AddFieldColumns(Grid $grid, $withDetails = true)
        {
            if (GetCurrentUserPermissionsForPage('tipos_funcionario.funcionarios')->HasViewGrant() && $withDetails)
            {
            //
            // View column for tipos_funcionario_funcionarios detail
            //
            $column = new DetailColumn(array('id_tipo_funcionario'), 'tipos_funcionario.funcionarios', 'tipos_funcionario_funcionarios_handler', $this->dataset, 'Funcionarios');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            }
            
            //
            // View column for id_tipo_funcionario field
            //
            $column = new NumberViewColumn('id_tipo_funcionario', 'id_tipo_funcionario', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for nombre field
            //
            $column = new TextViewColumn('nombre', 'nombre', 'Nombre de Funcion', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for descripcion field
            //
            $column = new TextViewColumn('descripcion', 'descripcion', 'Descripcion', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for nombre_completo field
            //
            $column = new TextViewColumn('usuario_registro', 'usuario_registro_nombre_completo', 'Registrado por:', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for fecha_registro field
            //
            $column = new DateTimeViewColumn('fecha_registro', 'fecha_registro', 'Fecha de Registro', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d H:i:s');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for fecha_modificacion field
            //
            $column = new DateTimeViewColumn('fecha_modificacion', 'fecha_modificacion', 'Fecha de Modificacion', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d H:i:s');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for id_tipo_funcionario field
            //
            $column = new NumberViewColumn('id_tipo_funcionario', 'id_tipo_funcionario', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for nombre field
            //
            $column = new TextViewColumn('nombre', 'nombre', 'Nombre de Funcion', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for descripcion field
            //
            $column = new TextViewColumn('descripcion', 'descripcion', 'Descripcion', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for nombre_completo field
            //
            $column = new TextViewColumn('usuario_registro', 'usuario_registro_nombre_completo', 'Registrado por:', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for fecha_registro field
            //
            $column = new DateTimeViewColumn('fecha_registro', 'fecha_registro', 'Fecha de Registro', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d H:i:s');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for fecha_modificacion field
            //
            $column = new DateTimeViewColumn('fecha_modificacion', 'fecha_modificacion', 'Fecha de Modificacion', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d H:i:s');
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for nombre field
            //
            $editor = new TextEdit('nombre_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Nombre de Funcion', 'nombre', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for descripcion field
            //
            $editor = new TextAreaEdit('descripcion_edit', 50, 8);
            $editColumn = new CustomEditColumn('Descripcion', 'descripcion', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for nombre field
            //
            $editor = new TextEdit('nombre_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Nombre de Funcion', 'nombre', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for descripcion field
            //
            $editor = new TextAreaEdit('descripcion_edit', 50, 8);
            $editColumn = new CustomEditColumn('Descripcion', 'descripcion', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for usuario_registro field
            //
            $editor = new DynamicCombobox('usuario_registro_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`usuarios`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_usuario', true, true, true),
                    new StringField('nombres', true),
                    new StringField('apellidos', true),
                    new StringField('carnet_identidad', true),
                    new StringField('email', true),
                    new StringField('password', true),
                    new IntegerField('id_estado', true),
                    new IntegerField('usuario_registro'),
                    new DateTimeField('fecha_registro'),
                    new DateTimeField('fecha_modificacion'),
                    new StringField('nombre_completo', true)
                )
            );
            $lookupDataset->setOrderByField('nombre_completo', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Registrado por:', 'usuario_registro', 'usuario_registro_nombre_completo', 'multi_edit_tipos_funcionario_usuario_registro_search', $editor, $this->dataset, $lookupDataset, 'id_usuario', 'nombre_completo', '');
            $editColumn->setVisible(false);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for fecha_registro field
            //
            $editor = new DateTimeEdit('fecha_registro_edit', false, 'Y-m-d H:i:s');
            $editColumn = new CustomEditColumn('Fecha de Registro', 'fecha_registro', $editor, $this->dataset);
            $editColumn->setVisible(false);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for fecha_modificacion field
            //
            $editor = new DateTimeEdit('fecha_modificacion_edit', false, 'Y-m-d H:i:s');
            $editColumn = new CustomEditColumn('Fecha de Modificacion', 'fecha_modificacion', $editor, $this->dataset);
            $editColumn->setVisible(false);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
        }
    
        protected function AddToggleEditColumns(Grid $grid)
        {
    
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for nombre field
            //
            $editor = new TextEdit('nombre_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Nombre de Funcion', 'nombre', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for descripcion field
            //
            $editor = new TextAreaEdit('descripcion_edit', 50, 8);
            $editColumn = new CustomEditColumn('Descripcion', 'descripcion', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for usuario_registro field
            //
            $editor = new DynamicCombobox('usuario_registro_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`usuarios`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_usuario', true, true, true),
                    new StringField('nombres', true),
                    new StringField('apellidos', true),
                    new StringField('carnet_identidad', true),
                    new StringField('email', true),
                    new StringField('password', true),
                    new IntegerField('id_estado', true),
                    new IntegerField('usuario_registro'),
                    new DateTimeField('fecha_registro'),
                    new DateTimeField('fecha_modificacion'),
                    new StringField('nombre_completo', true)
                )
            );
            $lookupDataset->setOrderByField('nombre_completo', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Registrado por:', 'usuario_registro', 'usuario_registro_nombre_completo', 'insert_tipos_funcionario_usuario_registro_search', $editor, $this->dataset, $lookupDataset, 'id_usuario', 'nombre_completo', '');
            $editColumn->setVisible(false);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetInsertDefaultValue('%CURRENT_USER_ID%');
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for fecha_registro field
            //
            $editor = new DateTimeEdit('fecha_registro_edit', false, 'Y-m-d H:i:s');
            $editColumn = new CustomEditColumn('Fecha de Registro', 'fecha_registro', $editor, $this->dataset);
            $editColumn->setVisible(false);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetInsertDefaultValue('%CURRENT_DATE%');
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for fecha_modificacion field
            //
            $editor = new DateTimeEdit('fecha_modificacion_edit', false, 'Y-m-d H:i:s');
            $editColumn = new CustomEditColumn('Fecha de Modificacion', 'fecha_modificacion', $editor, $this->dataset);
            $editColumn->setVisible(false);
            $editColumn->SetAllowSetToNull(true);
            $editColumn->SetInsertDefaultValue('%CURRENT_DATE%');
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            $grid->SetShowAddButton(true && $this->GetSecurityInfo()->HasAddGrant());
        }
    
        private function AddMultiUploadColumn(Grid $grid)
        {
    
        }
    
        protected function AddPrintColumns(Grid $grid)
        {
            //
            // View column for id_tipo_funcionario field
            //
            $column = new NumberViewColumn('id_tipo_funcionario', 'id_tipo_funcionario', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for nombre field
            //
            $column = new TextViewColumn('nombre', 'nombre', 'Nombre de Funcion', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for descripcion field
            //
            $column = new TextViewColumn('descripcion', 'descripcion', 'Descripcion', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for nombre_completo field
            //
            $column = new TextViewColumn('usuario_registro', 'usuario_registro_nombre_completo', 'Registrado por:', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for fecha_registro field
            //
            $column = new DateTimeViewColumn('fecha_registro', 'fecha_registro', 'Fecha de Registro', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d H:i:s');
            $grid->AddPrintColumn($column);
            
            //
            // View column for fecha_modificacion field
            //
            $column = new DateTimeViewColumn('fecha_modificacion', 'fecha_modificacion', 'Fecha de Modificacion', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d H:i:s');
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for id_tipo_funcionario field
            //
            $column = new NumberViewColumn('id_tipo_funcionario', 'id_tipo_funcionario', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for nombre field
            //
            $column = new TextViewColumn('nombre', 'nombre', 'Nombre de Funcion', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for descripcion field
            //
            $column = new TextViewColumn('descripcion', 'descripcion', 'Descripcion', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for nombre_completo field
            //
            $column = new TextViewColumn('usuario_registro', 'usuario_registro_nombre_completo', 'Registrado por:', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for fecha_registro field
            //
            $column = new DateTimeViewColumn('fecha_registro', 'fecha_registro', 'Fecha de Registro', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d H:i:s');
            $grid->AddExportColumn($column);
            
            //
            // View column for fecha_modificacion field
            //
            $column = new DateTimeViewColumn('fecha_modificacion', 'fecha_modificacion', 'Fecha de Modificacion', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d H:i:s');
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for nombre field
            //
            $column = new TextViewColumn('nombre', 'nombre', 'Nombre de Funcion', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for descripcion field
            //
            $column = new TextViewColumn('descripcion', 'descripcion', 'Descripcion', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for nombre_completo field
            //
            $column = new TextViewColumn('usuario_registro', 'usuario_registro_nombre_completo', 'Registrado por:', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for fecha_registro field
            //
            $column = new DateTimeViewColumn('fecha_registro', 'fecha_registro', 'Fecha de Registro', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d H:i:s');
            $grid->AddCompareColumn($column);
            
            //
            // View column for fecha_modificacion field
            //
            $column = new DateTimeViewColumn('fecha_modificacion', 'fecha_modificacion', 'Fecha de Modificacion', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d H:i:s');
            $grid->AddCompareColumn($column);
        }
    
        private function AddCompareHeaderColumns(Grid $grid)
        {
    
        }
    
        public function GetPageDirection()
        {
            return null;
        }
    
        public function isFilterConditionRequired()
        {
            return false;
        }
    
        protected function ApplyCommonColumnEditProperties(CustomEditColumn $column)
        {
            $column->SetDisplaySetToNullCheckBox(false);
            $column->SetDisplaySetToDefaultCheckBox(false);
    		$column->SetVariableContainer($this->GetColumnVariableContainer());
        }
    
        function CreateMasterDetailRecordGrid()
        {
            $result = new Grid($this, $this->dataset);
            
            $this->AddFieldColumns($result, false);
            $this->AddPrintColumns($result);
            $this->AddExportColumns($result);
            
            $result->SetAllowDeleteSelected(false);
            $result->SetShowUpdateLink(false);
            $result->SetShowKeyColumnsImagesInHeader(false);
            $result->SetViewMode(ViewMode::TABLE);
            $result->setEnableRuntimeCustomization(false);
            $result->setTableBordered(false);
            $result->setTableCondensed(true);
            
            $this->setupGridColumnGroup($result);
            $this->attachGridEventHandlers($result);
            
            return $result;
        }
        
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
        
        public function GetEnableModalGridInsert() { return true; }
        public function GetEnableModalSingleRecordView() { return true; }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset);
            if ($this->GetSecurityInfo()->HasDeleteGrant())
               $result->SetAllowDeleteSelected(true);
            else
               $result->SetAllowDeleteSelected(false);   
            
            ApplyCommonPageSettings($this, $result);
            
            $result->SetUseImagesForActions(true);
            $result->SetUseFixedHeader(true);
            $result->SetShowLineNumbers(false);
            $result->SetShowKeyColumnsImagesInHeader(false);
            $result->SetViewMode(ViewMode::TABLE);
            $result->setEnableRuntimeCustomization(true);
            $result->setAllowCompare(true);
            $this->AddCompareHeaderColumns($result);
            $this->AddCompareColumns($result);
            $result->setMultiEditAllowed($this->GetSecurityInfo()->HasEditGrant() && true);
            $result->setTableBordered(false);
            $result->setTableCondensed(true);
            
            $result->SetHighlightRowAtHover(true);
            $result->SetWidth('');
            $this->AddOperationsColumns($result);
            $this->AddFieldColumns($result);
            $this->AddSingleRecordViewColumns($result);
            $this->AddEditColumns($result);
            $this->AddMultiEditColumns($result);
            $this->AddToggleEditColumns($result);
            $this->AddInsertColumns($result);
            $this->AddPrintColumns($result);
            $this->AddExportColumns($result);
            $this->AddMultiUploadColumn($result);
    
    
            $this->SetShowPageList(true);
            $this->SetShowTopPageNavigator(true);
            $this->SetShowBottomPageNavigator(true);
            $this->setAllowedActions(array('view', 'insert', 'copy', 'edit', 'multi-edit', 'delete', 'multi-delete'));
            $this->setPrintListAvailable(true);
            $this->setPrintListRecordAvailable(false);
            $this->setPrintOneRecordAvailable(true);
            $this->setAllowPrintSelectedRecords(true);
            $this->setExportListAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportSelectedRecordsAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportListRecordAvailable(array());
            $this->setExportOneRecordAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
    
            return $result;
        }
     
        protected function setClientSideEvents(Grid $grid) {
    
        }
    
        protected function doRegisterHandlers() {
            $detailPage = new tipos_funcionario_funcionariosPage('tipos_funcionario_funcionarios', $this, array('id_tipo_funcionario'), array('id_tipo_funcionario'), $this->GetForeignKeyFields(), $this->CreateMasterDetailRecordGrid(), $this->dataset, GetCurrentUserPermissionsForPage('tipos_funcionario.funcionarios'), 'UTF-8');
            $detailPage->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('tipos_funcionario.funcionarios'));
            $detailPage->SetHttpHandlerName('tipos_funcionario_funcionarios_handler');
            $handler = new PageHTTPHandler('tipos_funcionario_funcionarios_handler', $detailPage);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`usuarios`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_usuario', true, true, true),
                    new StringField('nombres', true),
                    new StringField('apellidos', true),
                    new StringField('carnet_identidad', true),
                    new StringField('email', true),
                    new StringField('password', true),
                    new IntegerField('id_estado', true),
                    new IntegerField('usuario_registro'),
                    new DateTimeField('fecha_registro'),
                    new DateTimeField('fecha_modificacion'),
                    new StringField('nombre_completo', true)
                )
            );
            $lookupDataset->setOrderByField('nombre_completo', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'insert_tipos_funcionario_usuario_registro_search', 'id_usuario', 'nombre_completo', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`usuarios`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_usuario', true, true, true),
                    new StringField('nombres', true),
                    new StringField('apellidos', true),
                    new StringField('carnet_identidad', true),
                    new StringField('email', true),
                    new StringField('password', true),
                    new IntegerField('id_estado', true),
                    new IntegerField('usuario_registro'),
                    new DateTimeField('fecha_registro'),
                    new DateTimeField('fecha_modificacion'),
                    new StringField('nombre_completo', true)
                )
            );
            $lookupDataset->setOrderByField('nombre_completo', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'filter_builder_tipos_funcionario_usuario_registro_search', 'id_usuario', 'nombre_completo', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`usuarios`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_usuario', true, true, true),
                    new StringField('nombres', true),
                    new StringField('apellidos', true),
                    new StringField('carnet_identidad', true),
                    new StringField('email', true),
                    new StringField('password', true),
                    new IntegerField('id_estado', true),
                    new IntegerField('usuario_registro'),
                    new DateTimeField('fecha_registro'),
                    new DateTimeField('fecha_modificacion'),
                    new StringField('nombre_completo', true)
                )
            );
            $lookupDataset->setOrderByField('nombre_completo', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'multi_edit_tipos_funcionario_usuario_registro_search', 'id_usuario', 'nombre_completo', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
        }
       
        protected function doCustomRenderColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderPrintColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderExportColumn($exportType, $fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomDrawRow($rowData, &$cellFontColor, &$cellFontSize, &$cellBgColor, &$cellItalicAttr, &$cellBoldAttr)
        {
    
        }
    
        protected function doExtendedCustomDrawRow($rowData, &$rowCellStyles, &$rowStyles, &$rowClasses, &$cellClasses)
        {
    
        }
    
        protected function doCustomRenderTotal($totalValue, $aggregate, $columnName, &$customText, &$handled)
        {
    
        }
    
        protected function doCustomDefaultValues(&$values, &$handled) 
        {
    
        }
    
        protected function doCustomCompareColumn($columnName, $valueA, $valueB, &$result)
        {
    
        }
    
        protected function doBeforeInsertRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doBeforeUpdateRecord($page, $oldRowData, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doBeforeDeleteRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterInsertRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterUpdateRecord($page, $oldRowData, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterDeleteRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doCustomHTMLHeader($page, &$customHtmlHeaderText)
        { 
    
        }
    
        protected function doGetCustomTemplate($type, $part, $mode, &$result, &$params)
        {
    
        }
    
        protected function doGetCustomExportOptions(Page $page, $exportType, $rowData, &$options)
        {
    
        }
    
        protected function doFileUpload($fieldName, $rowData, &$result, &$accept, $originalFileName, $originalFileExtension, $fileSize, $tempFileName)
        {
    
        }
    
        protected function doPrepareChart(Chart $chart)
        {
    
        }
    
        protected function doPrepareColumnFilter(ColumnFilter $columnFilter)
        {
    
        }
    
        protected function doPrepareFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
    
        }
    
        protected function doGetSelectionFilters(FixedKeysArray $columns, &$result)
        {
    
        }
    
        protected function doGetCustomFormLayout($mode, FixedKeysArray $columns, FormLayout $layout)
        {
    
        }
    
        protected function doGetCustomColumnGroup(FixedKeysArray $columns, ViewColumnGroup $columnGroup)
        {
    
        }
    
        protected function doPageLoaded()
        {
    
        }
    
        protected function doCalculateFields($rowData, $fieldName, &$value)
        {
    
        }
    
        protected function doGetCustomRecordPermissions(Page $page, &$usingCondition, $rowData, &$allowEdit, &$allowDelete, &$mergeWithDefault, &$handled)
        {
    
        }
    
        protected function doAddEnvironmentVariables(Page $page, &$variables)
        {
    
        }
    
    }

    SetUpUserAuthorization();

    try
    {
        $Page = new tipos_funcionarioPage("tipos_funcionario", "tipos_funcionario.php", GetCurrentUserPermissionsForPage("tipos_funcionario"), 'UTF-8');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("tipos_funcionario"));
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e);
    }
	
