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
    
    
    
    class tipos_tramite_etapas_tramitePage extends DetailPage
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Etapas Tramite');
            $this->SetMenuLabel('Etapas Tramite');
    
            $this->dataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`etapas_tramite`');
            $this->dataset->addFields(
                array(
                    new IntegerField('id_etapa', true, true, true),
                    new IntegerField('id_tipo_tramite', true),
                    new StringField('nombre', true),
                    new StringField('descripcion'),
                    new IntegerField('porcentaje', true),
                    new IntegerField('orden', true),
                    new IntegerField('usuario_registro', true),
                    new DateTimeField('fecha_registro'),
                    new DateTimeField('fecha_modificacion')
                )
            );
            $this->dataset->AddLookupField('id_tipo_tramite', 'tipos_tramite', new IntegerField('id_tipo_tramite'), new IntegerField('id_categoria', false, false, false, false, 'id_tipo_tramite_id_categoria', 'id_tipo_tramite_id_categoria_tipos_tramite'), 'id_tipo_tramite_id_categoria_tipos_tramite');
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
                new FilterColumn($this->dataset, 'id_etapa', 'id_etapa', 'Id Etapa'),
                new FilterColumn($this->dataset, 'id_tipo_tramite', 'id_tipo_tramite_id_categoria', 'Id Tipo Tramite'),
                new FilterColumn($this->dataset, 'nombre', 'nombre', 'Nombre'),
                new FilterColumn($this->dataset, 'descripcion', 'descripcion', 'Descripcion'),
                new FilterColumn($this->dataset, 'porcentaje', 'porcentaje', 'Porcentaje'),
                new FilterColumn($this->dataset, 'orden', 'orden', 'Orden'),
                new FilterColumn($this->dataset, 'usuario_registro', 'usuario_registro_nombres', 'Usuario Registro'),
                new FilterColumn($this->dataset, 'fecha_registro', 'fecha_registro', 'Fecha Registro'),
                new FilterColumn($this->dataset, 'fecha_modificacion', 'fecha_modificacion', 'Fecha Modificacion')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['id_etapa'])
                ->addColumn($columns['id_tipo_tramite'])
                ->addColumn($columns['nombre'])
                ->addColumn($columns['descripcion'])
                ->addColumn($columns['porcentaje'])
                ->addColumn($columns['orden'])
                ->addColumn($columns['usuario_registro'])
                ->addColumn($columns['fecha_registro'])
                ->addColumn($columns['fecha_modificacion']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('id_tipo_tramite')
                ->setOptionsFor('usuario_registro')
                ->setOptionsFor('fecha_registro')
                ->setOptionsFor('fecha_modificacion');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new TextEdit('id_etapa_edit');
            
            $filterBuilder->addColumn(
                $columns['id_etapa'],
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
            
            $main_editor = new DynamicCombobox('id_tipo_tramite_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_tipos_tramite_etapas_tramite_id_tipo_tramite_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('id_tipo_tramite', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_tipos_tramite_etapas_tramite_id_tipo_tramite_search');
            
            $filterBuilder->addColumn(
                $columns['id_tipo_tramite'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('nombre_edit');
            $main_editor->SetMaxLength(100);
            
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
            
            $main_editor = new TextEdit('porcentaje_edit');
            
            $filterBuilder->addColumn(
                $columns['porcentaje'],
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
            
            $main_editor = new TextEdit('orden_edit');
            
            $filterBuilder->addColumn(
                $columns['orden'],
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
            
            $main_editor = new DynamicCombobox('usuario_registro_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_tipos_tramite_etapas_tramite_usuario_registro_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('usuario_registro', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_tipos_tramite_etapas_tramite_usuario_registro_search');
            
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
            //
            // View column for id_etapa field
            //
            $column = new NumberViewColumn('id_etapa', 'id_etapa', 'Id Etapa', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for id_categoria field
            //
            $column = new NumberViewColumn('id_tipo_tramite', 'id_tipo_tramite_id_categoria', 'Id Tipo Tramite', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for nombre field
            //
            $column = new TextViewColumn('nombre', 'nombre', 'Nombre', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
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
            // View column for porcentaje field
            //
            $column = new NumberViewColumn('porcentaje', 'porcentaje', 'Porcentaje', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for orden field
            //
            $column = new NumberViewColumn('orden', 'orden', 'Orden', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
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
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for id_etapa field
            //
            $column = new NumberViewColumn('id_etapa', 'id_etapa', 'Id Etapa', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for id_categoria field
            //
            $column = new NumberViewColumn('id_tipo_tramite', 'id_tipo_tramite_id_categoria', 'Id Tipo Tramite', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for nombre field
            //
            $column = new TextViewColumn('nombre', 'nombre', 'Nombre', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for descripcion field
            //
            $column = new TextViewColumn('descripcion', 'descripcion', 'Descripcion', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for porcentaje field
            //
            $column = new NumberViewColumn('porcentaje', 'porcentaje', 'Porcentaje', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for orden field
            //
            $column = new NumberViewColumn('orden', 'orden', 'Orden', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
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
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for id_tipo_tramite field
            //
            $editor = new DynamicCombobox('id_tipo_tramite_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tipos_tramite`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_tipo_tramite', true, true, true),
                    new IntegerField('id_categoria', true),
                    new StringField('nombre', true),
                    new StringField('descripcion'),
                    new IntegerField('precio_base', true),
                    new IntegerField('usuario_registro', true),
                    new DateTimeField('fecha_registro'),
                    new DateTimeField('fecha_modificacion')
                )
            );
            $lookupDataset->setOrderByField('id_categoria', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Tipo Tramite', 'id_tipo_tramite', 'id_tipo_tramite_id_categoria', 'edit_tipos_tramite_etapas_tramite_id_tipo_tramite_search', $editor, $this->dataset, $lookupDataset, 'id_tipo_tramite', 'id_categoria', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for nombre field
            //
            $editor = new TextEdit('nombre_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Nombre', 'nombre', $editor, $this->dataset);
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
            
            //
            // Edit column for porcentaje field
            //
            $editor = new TextEdit('porcentaje_edit');
            $editColumn = new CustomEditColumn('Porcentaje', 'porcentaje', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for orden field
            //
            $editor = new TextEdit('orden_edit');
            $editColumn = new CustomEditColumn('Orden', 'orden', $editor, $this->dataset);
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
            $editColumn = new DynamicLookupEditColumn('Usuario Registro', 'usuario_registro', 'usuario_registro_nombres', 'edit_tipos_tramite_etapas_tramite_usuario_registro_search', $editor, $this->dataset, $lookupDataset, 'id_usuario', 'nombres', '');
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
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for id_tipo_tramite field
            //
            $editor = new DynamicCombobox('id_tipo_tramite_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tipos_tramite`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_tipo_tramite', true, true, true),
                    new IntegerField('id_categoria', true),
                    new StringField('nombre', true),
                    new StringField('descripcion'),
                    new IntegerField('precio_base', true),
                    new IntegerField('usuario_registro', true),
                    new DateTimeField('fecha_registro'),
                    new DateTimeField('fecha_modificacion')
                )
            );
            $lookupDataset->setOrderByField('id_categoria', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Tipo Tramite', 'id_tipo_tramite', 'id_tipo_tramite_id_categoria', 'multi_edit_tipos_tramite_etapas_tramite_id_tipo_tramite_search', $editor, $this->dataset, $lookupDataset, 'id_tipo_tramite', 'id_categoria', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for nombre field
            //
            $editor = new TextEdit('nombre_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Nombre', 'nombre', $editor, $this->dataset);
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
            // Edit column for porcentaje field
            //
            $editor = new TextEdit('porcentaje_edit');
            $editColumn = new CustomEditColumn('Porcentaje', 'porcentaje', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for orden field
            //
            $editor = new TextEdit('orden_edit');
            $editColumn = new CustomEditColumn('Orden', 'orden', $editor, $this->dataset);
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
            $editColumn = new DynamicLookupEditColumn('Usuario Registro', 'usuario_registro', 'usuario_registro_nombres', 'multi_edit_tipos_tramite_etapas_tramite_usuario_registro_search', $editor, $this->dataset, $lookupDataset, 'id_usuario', 'nombres', '');
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
        }
    
        protected function AddToggleEditColumns(Grid $grid)
        {
    
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for id_tipo_tramite field
            //
            $editor = new DynamicCombobox('id_tipo_tramite_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tipos_tramite`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_tipo_tramite', true, true, true),
                    new IntegerField('id_categoria', true),
                    new StringField('nombre', true),
                    new StringField('descripcion'),
                    new IntegerField('precio_base', true),
                    new IntegerField('usuario_registro', true),
                    new DateTimeField('fecha_registro'),
                    new DateTimeField('fecha_modificacion')
                )
            );
            $lookupDataset->setOrderByField('id_categoria', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Tipo Tramite', 'id_tipo_tramite', 'id_tipo_tramite_id_categoria', 'insert_tipos_tramite_etapas_tramite_id_tipo_tramite_search', $editor, $this->dataset, $lookupDataset, 'id_tipo_tramite', 'id_categoria', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for nombre field
            //
            $editor = new TextEdit('nombre_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Nombre', 'nombre', $editor, $this->dataset);
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
            // Edit column for porcentaje field
            //
            $editor = new TextEdit('porcentaje_edit');
            $editColumn = new CustomEditColumn('Porcentaje', 'porcentaje', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for orden field
            //
            $editor = new TextEdit('orden_edit');
            $editColumn = new CustomEditColumn('Orden', 'orden', $editor, $this->dataset);
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
            $editColumn = new DynamicLookupEditColumn('Usuario Registro', 'usuario_registro', 'usuario_registro_nombres', 'insert_tipos_tramite_etapas_tramite_usuario_registro_search', $editor, $this->dataset, $lookupDataset, 'id_usuario', 'nombres', '');
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
            $grid->SetShowAddButton(true && $this->GetSecurityInfo()->HasAddGrant());
        }
    
        private function AddMultiUploadColumn(Grid $grid)
        {
    
        }
    
        protected function AddPrintColumns(Grid $grid)
        {
            //
            // View column for id_etapa field
            //
            $column = new NumberViewColumn('id_etapa', 'id_etapa', 'Id Etapa', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for id_categoria field
            //
            $column = new NumberViewColumn('id_tipo_tramite', 'id_tipo_tramite_id_categoria', 'Id Tipo Tramite', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for nombre field
            //
            $column = new TextViewColumn('nombre', 'nombre', 'Nombre', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for descripcion field
            //
            $column = new TextViewColumn('descripcion', 'descripcion', 'Descripcion', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for porcentaje field
            //
            $column = new NumberViewColumn('porcentaje', 'porcentaje', 'Porcentaje', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddPrintColumn($column);
            
            //
            // View column for orden field
            //
            $column = new NumberViewColumn('orden', 'orden', 'Orden', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
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
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for id_etapa field
            //
            $column = new NumberViewColumn('id_etapa', 'id_etapa', 'Id Etapa', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for id_categoria field
            //
            $column = new NumberViewColumn('id_tipo_tramite', 'id_tipo_tramite_id_categoria', 'Id Tipo Tramite', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for nombre field
            //
            $column = new TextViewColumn('nombre', 'nombre', 'Nombre', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for descripcion field
            //
            $column = new TextViewColumn('descripcion', 'descripcion', 'Descripcion', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for porcentaje field
            //
            $column = new NumberViewColumn('porcentaje', 'porcentaje', 'Porcentaje', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddExportColumn($column);
            
            //
            // View column for orden field
            //
            $column = new NumberViewColumn('orden', 'orden', 'Orden', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
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
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for id_categoria field
            //
            $column = new NumberViewColumn('id_tipo_tramite', 'id_tipo_tramite_id_categoria', 'Id Tipo Tramite', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for nombre field
            //
            $column = new TextViewColumn('nombre', 'nombre', 'Nombre', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for descripcion field
            //
            $column = new TextViewColumn('descripcion', 'descripcion', 'Descripcion', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for porcentaje field
            //
            $column = new NumberViewColumn('porcentaje', 'porcentaje', 'Porcentaje', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddCompareColumn($column);
            
            //
            // View column for orden field
            //
            $column = new NumberViewColumn('orden', 'orden', 'Orden', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
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
                '`tipos_tramite`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_tipo_tramite', true, true, true),
                    new IntegerField('id_categoria', true),
                    new StringField('nombre', true),
                    new StringField('descripcion'),
                    new IntegerField('precio_base', true),
                    new IntegerField('usuario_registro', true),
                    new DateTimeField('fecha_registro'),
                    new DateTimeField('fecha_modificacion')
                )
            );
            $lookupDataset->setOrderByField('id_categoria', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'insert_tipos_tramite_etapas_tramite_id_tipo_tramite_search', 'id_tipo_tramite', 'id_categoria', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, 'insert_tipos_tramite_etapas_tramite_usuario_registro_search', 'id_usuario', 'nombres', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tipos_tramite`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_tipo_tramite', true, true, true),
                    new IntegerField('id_categoria', true),
                    new StringField('nombre', true),
                    new StringField('descripcion'),
                    new IntegerField('precio_base', true),
                    new IntegerField('usuario_registro', true),
                    new DateTimeField('fecha_registro'),
                    new DateTimeField('fecha_modificacion')
                )
            );
            $lookupDataset->setOrderByField('id_categoria', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'filter_builder_tipos_tramite_etapas_tramite_id_tipo_tramite_search', 'id_tipo_tramite', 'id_categoria', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, 'filter_builder_tipos_tramite_etapas_tramite_usuario_registro_search', 'id_usuario', 'nombres', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tipos_tramite`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_tipo_tramite', true, true, true),
                    new IntegerField('id_categoria', true),
                    new StringField('nombre', true),
                    new StringField('descripcion'),
                    new IntegerField('precio_base', true),
                    new IntegerField('usuario_registro', true),
                    new DateTimeField('fecha_registro'),
                    new DateTimeField('fecha_modificacion')
                )
            );
            $lookupDataset->setOrderByField('id_categoria', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'edit_tipos_tramite_etapas_tramite_id_tipo_tramite_search', 'id_tipo_tramite', 'id_categoria', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, 'edit_tipos_tramite_etapas_tramite_usuario_registro_search', 'id_usuario', 'nombres', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tipos_tramite`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_tipo_tramite', true, true, true),
                    new IntegerField('id_categoria', true),
                    new StringField('nombre', true),
                    new StringField('descripcion'),
                    new IntegerField('precio_base', true),
                    new IntegerField('usuario_registro', true),
                    new DateTimeField('fecha_registro'),
                    new DateTimeField('fecha_modificacion')
                )
            );
            $lookupDataset->setOrderByField('id_categoria', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'multi_edit_tipos_tramite_etapas_tramite_id_tipo_tramite_search', 'id_tipo_tramite', 'id_categoria', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, 'multi_edit_tipos_tramite_etapas_tramite_usuario_registro_search', 'id_usuario', 'nombres', null, 20);
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
    
    
    
    class tipos_tramite_tramitesPage extends DetailPage
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Tramites');
            $this->SetMenuLabel('Tramites');
    
            $this->dataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tramites`');
            $this->dataset->addFields(
                array(
                    new IntegerField('id_tramite', true, true, true),
                    new IntegerField('id_tipo_tramite', true),
                    new IntegerField('id_funcionario', true),
                    new IntegerField('id_cliente', true),
                    new DateField('fecha_inicio', true),
                    new DateField('fecha_fin'),
                    new IntegerField('porcentaje_avance'),
                    new IntegerField('id_estado', true),
                    new StringField('observaciones'),
                    new IntegerField('usuario_registro', true),
                    new DateTimeField('fecha_registro'),
                    new DateTimeField('fecha_modificacion')
                )
            );
            $this->dataset->AddLookupField('id_tipo_tramite', 'tipos_tramite', new IntegerField('id_tipo_tramite'), new IntegerField('id_categoria', false, false, false, false, 'id_tipo_tramite_id_categoria', 'id_tipo_tramite_id_categoria_tipos_tramite'), 'id_tipo_tramite_id_categoria_tipos_tramite');
            $this->dataset->AddLookupField('usuario_registro', 'usuarios', new IntegerField('id_usuario'), new StringField('nombres', false, false, false, false, 'usuario_registro_nombres', 'usuario_registro_nombres_usuarios'), 'usuario_registro_nombres_usuarios');
            $this->dataset->AddLookupField('id_estado', 'estados', new IntegerField('id_estado'), new StringField('nombre', false, false, false, false, 'id_estado_nombre', 'id_estado_nombre_estados'), 'id_estado_nombre_estados');
            $this->dataset->AddLookupField('id_funcionario', 'funcionarios', new IntegerField('id_funcionario'), new IntegerField('id_usuario', false, false, false, false, 'id_funcionario_id_usuario', 'id_funcionario_id_usuario_funcionarios'), 'id_funcionario_id_usuario_funcionarios');
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
                new FilterColumn($this->dataset, 'id_tramite', 'id_tramite', 'Id Tramite'),
                new FilterColumn($this->dataset, 'id_tipo_tramite', 'id_tipo_tramite_id_categoria', 'Id Tipo Tramite'),
                new FilterColumn($this->dataset, 'id_cliente', 'id_cliente', 'Id Cliente'),
                new FilterColumn($this->dataset, 'fecha_inicio', 'fecha_inicio', 'Fecha Inicio'),
                new FilterColumn($this->dataset, 'fecha_fin', 'fecha_fin', 'Fecha Fin'),
                new FilterColumn($this->dataset, 'porcentaje_avance', 'porcentaje_avance', 'Porcentaje Avance'),
                new FilterColumn($this->dataset, 'observaciones', 'observaciones', 'Observaciones'),
                new FilterColumn($this->dataset, 'usuario_registro', 'usuario_registro_nombres', 'Usuario Registro'),
                new FilterColumn($this->dataset, 'fecha_registro', 'fecha_registro', 'Fecha Registro'),
                new FilterColumn($this->dataset, 'fecha_modificacion', 'fecha_modificacion', 'Fecha Modificacion'),
                new FilterColumn($this->dataset, 'id_estado', 'id_estado_nombre', 'Id Estado'),
                new FilterColumn($this->dataset, 'id_funcionario', 'id_funcionario_id_usuario', 'Id Funcionario')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['id_tramite'])
                ->addColumn($columns['id_tipo_tramite'])
                ->addColumn($columns['id_cliente'])
                ->addColumn($columns['fecha_inicio'])
                ->addColumn($columns['fecha_fin'])
                ->addColumn($columns['porcentaje_avance'])
                ->addColumn($columns['observaciones'])
                ->addColumn($columns['usuario_registro'])
                ->addColumn($columns['fecha_registro'])
                ->addColumn($columns['fecha_modificacion'])
                ->addColumn($columns['id_estado'])
                ->addColumn($columns['id_funcionario']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('id_tipo_tramite')
                ->setOptionsFor('id_cliente')
                ->setOptionsFor('fecha_inicio')
                ->setOptionsFor('fecha_fin')
                ->setOptionsFor('usuario_registro')
                ->setOptionsFor('fecha_registro')
                ->setOptionsFor('fecha_modificacion')
                ->setOptionsFor('id_estado')
                ->setOptionsFor('id_funcionario');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new TextEdit('id_tramite_edit');
            
            $filterBuilder->addColumn(
                $columns['id_tramite'],
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
            
            $main_editor = new DynamicCombobox('id_tipo_tramite_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_tipos_tramite_tramites_id_tipo_tramite_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('id_tipo_tramite', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_tipos_tramite_tramites_id_tipo_tramite_search');
            
            $filterBuilder->addColumn(
                $columns['id_tipo_tramite'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('id_cliente_edit');
            
            $filterBuilder->addColumn(
                $columns['id_cliente'],
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
            
            $main_editor = new DateTimeEdit('fecha_inicio_edit', false, 'Y-m-d');
            
            $filterBuilder->addColumn(
                $columns['fecha_inicio'],
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
            
            $main_editor = new DateTimeEdit('fecha_fin_edit', false, 'Y-m-d');
            
            $filterBuilder->addColumn(
                $columns['fecha_fin'],
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
            
            $main_editor = new TextEdit('porcentaje_avance_edit');
            
            $filterBuilder->addColumn(
                $columns['porcentaje_avance'],
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
            
            $main_editor = new TextEdit('observaciones');
            
            $filterBuilder->addColumn(
                $columns['observaciones'],
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
            $main_editor->SetHandlerName('filter_builder_tipos_tramite_tramites_usuario_registro_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('usuario_registro', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_tipos_tramite_tramites_usuario_registro_search');
            
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
            
            $main_editor = new DynamicCombobox('id_estado_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_tipos_tramite_tramites_id_estado_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('id_estado', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_tipos_tramite_tramites_id_estado_search');
            
            $text_editor = new TextEdit('id_estado');
            
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
            
            $main_editor = new DynamicCombobox('id_funcionario_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_tipos_tramite_tramites_id_funcionario_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('id_funcionario', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_tipos_tramite_tramites_id_funcionario_search');
            
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
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
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
            // View column for id_tramite field
            //
            $column = new NumberViewColumn('id_tramite', 'id_tramite', 'Id Tramite', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for id_categoria field
            //
            $column = new NumberViewColumn('id_tipo_tramite', 'id_tipo_tramite_id_categoria', 'Id Tipo Tramite', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for id_cliente field
            //
            $column = new TextViewColumn('id_cliente', 'id_cliente', 'Id Cliente', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for fecha_inicio field
            //
            $column = new DateTimeViewColumn('fecha_inicio', 'fecha_inicio', 'Fecha Inicio', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for fecha_fin field
            //
            $column = new DateTimeViewColumn('fecha_fin', 'fecha_fin', 'Fecha Fin', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for porcentaje_avance field
            //
            $column = new NumberViewColumn('porcentaje_avance', 'porcentaje_avance', 'Porcentaje Avance', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for observaciones field
            //
            $column = new TextViewColumn('observaciones', 'observaciones', 'Observaciones', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
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
            // View column for nombre field
            //
            $column = new TextViewColumn('id_estado', 'id_estado_nombre', 'Id Estado', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for id_usuario field
            //
            $column = new NumberViewColumn('id_funcionario', 'id_funcionario_id_usuario', 'Id Funcionario', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for id_tramite field
            //
            $column = new NumberViewColumn('id_tramite', 'id_tramite', 'Id Tramite', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for id_categoria field
            //
            $column = new NumberViewColumn('id_tipo_tramite', 'id_tipo_tramite_id_categoria', 'Id Tipo Tramite', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for id_cliente field
            //
            $column = new TextViewColumn('id_cliente', 'id_cliente', 'Id Cliente', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for fecha_inicio field
            //
            $column = new DateTimeViewColumn('fecha_inicio', 'fecha_inicio', 'Fecha Inicio', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for fecha_fin field
            //
            $column = new DateTimeViewColumn('fecha_fin', 'fecha_fin', 'Fecha Fin', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for porcentaje_avance field
            //
            $column = new NumberViewColumn('porcentaje_avance', 'porcentaje_avance', 'Porcentaje Avance', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for observaciones field
            //
            $column = new TextViewColumn('observaciones', 'observaciones', 'Observaciones', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
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
            // View column for nombre field
            //
            $column = new TextViewColumn('id_estado', 'id_estado_nombre', 'Id Estado', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for id_usuario field
            //
            $column = new NumberViewColumn('id_funcionario', 'id_funcionario_id_usuario', 'Id Funcionario', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for id_tipo_tramite field
            //
            $editor = new DynamicCombobox('id_tipo_tramite_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tipos_tramite`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_tipo_tramite', true, true, true),
                    new IntegerField('id_categoria', true),
                    new StringField('nombre', true),
                    new StringField('descripcion'),
                    new IntegerField('precio_base', true),
                    new IntegerField('usuario_registro', true),
                    new DateTimeField('fecha_registro'),
                    new DateTimeField('fecha_modificacion')
                )
            );
            $lookupDataset->setOrderByField('id_categoria', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Tipo Tramite', 'id_tipo_tramite', 'id_tipo_tramite_id_categoria', 'edit_tipos_tramite_tramites_id_tipo_tramite_search', $editor, $this->dataset, $lookupDataset, 'id_tipo_tramite', 'id_categoria', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for id_cliente field
            //
            $editor = new TextEdit('id_cliente_edit');
            $editColumn = new CustomEditColumn('Id Cliente', 'id_cliente', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for fecha_inicio field
            //
            $editor = new DateTimeEdit('fecha_inicio_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Fecha Inicio', 'fecha_inicio', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for fecha_fin field
            //
            $editor = new DateTimeEdit('fecha_fin_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Fecha Fin', 'fecha_fin', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for porcentaje_avance field
            //
            $editor = new TextEdit('porcentaje_avance_edit');
            $editColumn = new CustomEditColumn('Porcentaje Avance', 'porcentaje_avance', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for observaciones field
            //
            $editor = new TextAreaEdit('observaciones_edit', 50, 8);
            $editColumn = new CustomEditColumn('Observaciones', 'observaciones', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
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
            $editColumn = new DynamicLookupEditColumn('Usuario Registro', 'usuario_registro', 'usuario_registro_nombres', 'edit_tipos_tramite_tramites_usuario_registro_search', $editor, $this->dataset, $lookupDataset, 'id_usuario', 'nombres', '');
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
            $editor = new DynamicCombobox('id_estado_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`estados`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_estado', true, true, true),
                    new StringField('nombre', true)
                )
            );
            $lookupDataset->setOrderByField('nombre', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Estado', 'id_estado', 'id_estado_nombre', 'edit_tipos_tramite_tramites_id_estado_search', $editor, $this->dataset, $lookupDataset, 'id_estado', 'nombre', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for id_funcionario field
            //
            $editor = new DynamicCombobox('id_funcionario_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`funcionarios`');
            $lookupDataset->addFields(
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
            $lookupDataset->setOrderByField('id_usuario', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Funcionario', 'id_funcionario', 'id_funcionario_id_usuario', 'edit_tipos_tramite_tramites_id_funcionario_search', $editor, $this->dataset, $lookupDataset, 'id_funcionario', 'id_usuario', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for id_tipo_tramite field
            //
            $editor = new DynamicCombobox('id_tipo_tramite_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tipos_tramite`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_tipo_tramite', true, true, true),
                    new IntegerField('id_categoria', true),
                    new StringField('nombre', true),
                    new StringField('descripcion'),
                    new IntegerField('precio_base', true),
                    new IntegerField('usuario_registro', true),
                    new DateTimeField('fecha_registro'),
                    new DateTimeField('fecha_modificacion')
                )
            );
            $lookupDataset->setOrderByField('id_categoria', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Tipo Tramite', 'id_tipo_tramite', 'id_tipo_tramite_id_categoria', 'multi_edit_tipos_tramite_tramites_id_tipo_tramite_search', $editor, $this->dataset, $lookupDataset, 'id_tipo_tramite', 'id_categoria', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for id_cliente field
            //
            $editor = new TextEdit('id_cliente_edit');
            $editColumn = new CustomEditColumn('Id Cliente', 'id_cliente', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for fecha_inicio field
            //
            $editor = new DateTimeEdit('fecha_inicio_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Fecha Inicio', 'fecha_inicio', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for fecha_fin field
            //
            $editor = new DateTimeEdit('fecha_fin_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Fecha Fin', 'fecha_fin', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for porcentaje_avance field
            //
            $editor = new TextEdit('porcentaje_avance_edit');
            $editColumn = new CustomEditColumn('Porcentaje Avance', 'porcentaje_avance', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for observaciones field
            //
            $editor = new TextAreaEdit('observaciones_edit', 50, 8);
            $editColumn = new CustomEditColumn('Observaciones', 'observaciones', $editor, $this->dataset);
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
            $lookupDataset->setOrderByField('nombres', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Usuario Registro', 'usuario_registro', 'usuario_registro_nombres', 'multi_edit_tipos_tramite_tramites_usuario_registro_search', $editor, $this->dataset, $lookupDataset, 'id_usuario', 'nombres', '');
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
            $editor = new DynamicCombobox('id_estado_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`estados`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_estado', true, true, true),
                    new StringField('nombre', true)
                )
            );
            $lookupDataset->setOrderByField('nombre', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Estado', 'id_estado', 'id_estado_nombre', 'multi_edit_tipos_tramite_tramites_id_estado_search', $editor, $this->dataset, $lookupDataset, 'id_estado', 'nombre', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for id_funcionario field
            //
            $editor = new DynamicCombobox('id_funcionario_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`funcionarios`');
            $lookupDataset->addFields(
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
            $lookupDataset->setOrderByField('id_usuario', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Funcionario', 'id_funcionario', 'id_funcionario_id_usuario', 'multi_edit_tipos_tramite_tramites_id_funcionario_search', $editor, $this->dataset, $lookupDataset, 'id_funcionario', 'id_usuario', '');
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
            // Edit column for id_tipo_tramite field
            //
            $editor = new DynamicCombobox('id_tipo_tramite_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tipos_tramite`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_tipo_tramite', true, true, true),
                    new IntegerField('id_categoria', true),
                    new StringField('nombre', true),
                    new StringField('descripcion'),
                    new IntegerField('precio_base', true),
                    new IntegerField('usuario_registro', true),
                    new DateTimeField('fecha_registro'),
                    new DateTimeField('fecha_modificacion')
                )
            );
            $lookupDataset->setOrderByField('id_categoria', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Tipo Tramite', 'id_tipo_tramite', 'id_tipo_tramite_id_categoria', 'insert_tipos_tramite_tramites_id_tipo_tramite_search', $editor, $this->dataset, $lookupDataset, 'id_tipo_tramite', 'id_categoria', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for id_cliente field
            //
            $editor = new TextEdit('id_cliente_edit');
            $editColumn = new CustomEditColumn('Id Cliente', 'id_cliente', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for fecha_inicio field
            //
            $editor = new DateTimeEdit('fecha_inicio_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Fecha Inicio', 'fecha_inicio', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for fecha_fin field
            //
            $editor = new DateTimeEdit('fecha_fin_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Fecha Fin', 'fecha_fin', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for porcentaje_avance field
            //
            $editor = new TextEdit('porcentaje_avance_edit');
            $editColumn = new CustomEditColumn('Porcentaje Avance', 'porcentaje_avance', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for observaciones field
            //
            $editor = new TextAreaEdit('observaciones_edit', 50, 8);
            $editColumn = new CustomEditColumn('Observaciones', 'observaciones', $editor, $this->dataset);
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
            $lookupDataset->setOrderByField('nombres', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Usuario Registro', 'usuario_registro', 'usuario_registro_nombres', 'insert_tipos_tramite_tramites_usuario_registro_search', $editor, $this->dataset, $lookupDataset, 'id_usuario', 'nombres', '');
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
            $editor = new DynamicCombobox('id_estado_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`estados`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_estado', true, true, true),
                    new StringField('nombre', true)
                )
            );
            $lookupDataset->setOrderByField('nombre', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Estado', 'id_estado', 'id_estado_nombre', 'insert_tipos_tramite_tramites_id_estado_search', $editor, $this->dataset, $lookupDataset, 'id_estado', 'nombre', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for id_funcionario field
            //
            $editor = new DynamicCombobox('id_funcionario_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`funcionarios`');
            $lookupDataset->addFields(
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
            $lookupDataset->setOrderByField('id_usuario', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Funcionario', 'id_funcionario', 'id_funcionario_id_usuario', 'insert_tipos_tramite_tramites_id_funcionario_search', $editor, $this->dataset, $lookupDataset, 'id_funcionario', 'id_usuario', '');
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
            // View column for id_tramite field
            //
            $column = new NumberViewColumn('id_tramite', 'id_tramite', 'Id Tramite', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for id_categoria field
            //
            $column = new NumberViewColumn('id_tipo_tramite', 'id_tipo_tramite_id_categoria', 'Id Tipo Tramite', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for id_cliente field
            //
            $column = new TextViewColumn('id_cliente', 'id_cliente', 'Id Cliente', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for fecha_inicio field
            //
            $column = new DateTimeViewColumn('fecha_inicio', 'fecha_inicio', 'Fecha Inicio', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddPrintColumn($column);
            
            //
            // View column for fecha_fin field
            //
            $column = new DateTimeViewColumn('fecha_fin', 'fecha_fin', 'Fecha Fin', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddPrintColumn($column);
            
            //
            // View column for porcentaje_avance field
            //
            $column = new NumberViewColumn('porcentaje_avance', 'porcentaje_avance', 'Porcentaje Avance', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddPrintColumn($column);
            
            //
            // View column for observaciones field
            //
            $column = new TextViewColumn('observaciones', 'observaciones', 'Observaciones', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
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
            // View column for nombre field
            //
            $column = new TextViewColumn('id_estado', 'id_estado_nombre', 'Id Estado', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for id_usuario field
            //
            $column = new NumberViewColumn('id_funcionario', 'id_funcionario_id_usuario', 'Id Funcionario', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for id_tramite field
            //
            $column = new NumberViewColumn('id_tramite', 'id_tramite', 'Id Tramite', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for id_categoria field
            //
            $column = new NumberViewColumn('id_tipo_tramite', 'id_tipo_tramite_id_categoria', 'Id Tipo Tramite', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for id_cliente field
            //
            $column = new TextViewColumn('id_cliente', 'id_cliente', 'Id Cliente', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for fecha_inicio field
            //
            $column = new DateTimeViewColumn('fecha_inicio', 'fecha_inicio', 'Fecha Inicio', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddExportColumn($column);
            
            //
            // View column for fecha_fin field
            //
            $column = new DateTimeViewColumn('fecha_fin', 'fecha_fin', 'Fecha Fin', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddExportColumn($column);
            
            //
            // View column for porcentaje_avance field
            //
            $column = new NumberViewColumn('porcentaje_avance', 'porcentaje_avance', 'Porcentaje Avance', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddExportColumn($column);
            
            //
            // View column for observaciones field
            //
            $column = new TextViewColumn('observaciones', 'observaciones', 'Observaciones', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
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
            // View column for nombre field
            //
            $column = new TextViewColumn('id_estado', 'id_estado_nombre', 'Id Estado', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for id_usuario field
            //
            $column = new NumberViewColumn('id_funcionario', 'id_funcionario_id_usuario', 'Id Funcionario', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for id_categoria field
            //
            $column = new NumberViewColumn('id_tipo_tramite', 'id_tipo_tramite_id_categoria', 'Id Tipo Tramite', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for id_cliente field
            //
            $column = new TextViewColumn('id_cliente', 'id_cliente', 'Id Cliente', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for fecha_inicio field
            //
            $column = new DateTimeViewColumn('fecha_inicio', 'fecha_inicio', 'Fecha Inicio', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddCompareColumn($column);
            
            //
            // View column for fecha_fin field
            //
            $column = new DateTimeViewColumn('fecha_fin', 'fecha_fin', 'Fecha Fin', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddCompareColumn($column);
            
            //
            // View column for porcentaje_avance field
            //
            $column = new NumberViewColumn('porcentaje_avance', 'porcentaje_avance', 'Porcentaje Avance', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddCompareColumn($column);
            
            //
            // View column for observaciones field
            //
            $column = new TextViewColumn('observaciones', 'observaciones', 'Observaciones', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
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
            // View column for nombre field
            //
            $column = new TextViewColumn('id_estado', 'id_estado_nombre', 'Id Estado', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for id_usuario field
            //
            $column = new NumberViewColumn('id_funcionario', 'id_funcionario_id_usuario', 'Id Funcionario', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
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
                '`tipos_tramite`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_tipo_tramite', true, true, true),
                    new IntegerField('id_categoria', true),
                    new StringField('nombre', true),
                    new StringField('descripcion'),
                    new IntegerField('precio_base', true),
                    new IntegerField('usuario_registro', true),
                    new DateTimeField('fecha_registro'),
                    new DateTimeField('fecha_modificacion')
                )
            );
            $lookupDataset->setOrderByField('id_categoria', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'insert_tipos_tramite_tramites_id_tipo_tramite_search', 'id_tipo_tramite', 'id_categoria', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, 'insert_tipos_tramite_tramites_usuario_registro_search', 'id_usuario', 'nombres', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`estados`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_estado', true, true, true),
                    new StringField('nombre', true)
                )
            );
            $lookupDataset->setOrderByField('nombre', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'insert_tipos_tramite_tramites_id_estado_search', 'id_estado', 'nombre', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`funcionarios`');
            $lookupDataset->addFields(
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
            $lookupDataset->setOrderByField('id_usuario', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'insert_tipos_tramite_tramites_id_funcionario_search', 'id_funcionario', 'id_usuario', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tipos_tramite`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_tipo_tramite', true, true, true),
                    new IntegerField('id_categoria', true),
                    new StringField('nombre', true),
                    new StringField('descripcion'),
                    new IntegerField('precio_base', true),
                    new IntegerField('usuario_registro', true),
                    new DateTimeField('fecha_registro'),
                    new DateTimeField('fecha_modificacion')
                )
            );
            $lookupDataset->setOrderByField('id_categoria', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'filter_builder_tipos_tramite_tramites_id_tipo_tramite_search', 'id_tipo_tramite', 'id_categoria', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, 'filter_builder_tipos_tramite_tramites_usuario_registro_search', 'id_usuario', 'nombres', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`estados`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_estado', true, true, true),
                    new StringField('nombre', true)
                )
            );
            $lookupDataset->setOrderByField('nombre', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'filter_builder_tipos_tramite_tramites_id_estado_search', 'id_estado', 'nombre', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`funcionarios`');
            $lookupDataset->addFields(
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
            $lookupDataset->setOrderByField('id_usuario', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'filter_builder_tipos_tramite_tramites_id_funcionario_search', 'id_funcionario', 'id_usuario', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tipos_tramite`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_tipo_tramite', true, true, true),
                    new IntegerField('id_categoria', true),
                    new StringField('nombre', true),
                    new StringField('descripcion'),
                    new IntegerField('precio_base', true),
                    new IntegerField('usuario_registro', true),
                    new DateTimeField('fecha_registro'),
                    new DateTimeField('fecha_modificacion')
                )
            );
            $lookupDataset->setOrderByField('id_categoria', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'edit_tipos_tramite_tramites_id_tipo_tramite_search', 'id_tipo_tramite', 'id_categoria', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, 'edit_tipos_tramite_tramites_usuario_registro_search', 'id_usuario', 'nombres', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`estados`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_estado', true, true, true),
                    new StringField('nombre', true)
                )
            );
            $lookupDataset->setOrderByField('nombre', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'edit_tipos_tramite_tramites_id_estado_search', 'id_estado', 'nombre', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`funcionarios`');
            $lookupDataset->addFields(
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
            $lookupDataset->setOrderByField('id_usuario', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'edit_tipos_tramite_tramites_id_funcionario_search', 'id_funcionario', 'id_usuario', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tipos_tramite`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_tipo_tramite', true, true, true),
                    new IntegerField('id_categoria', true),
                    new StringField('nombre', true),
                    new StringField('descripcion'),
                    new IntegerField('precio_base', true),
                    new IntegerField('usuario_registro', true),
                    new DateTimeField('fecha_registro'),
                    new DateTimeField('fecha_modificacion')
                )
            );
            $lookupDataset->setOrderByField('id_categoria', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'multi_edit_tipos_tramite_tramites_id_tipo_tramite_search', 'id_tipo_tramite', 'id_categoria', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, 'multi_edit_tipos_tramite_tramites_usuario_registro_search', 'id_usuario', 'nombres', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`estados`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_estado', true, true, true),
                    new StringField('nombre', true)
                )
            );
            $lookupDataset->setOrderByField('nombre', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'multi_edit_tipos_tramite_tramites_id_estado_search', 'id_estado', 'nombre', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`funcionarios`');
            $lookupDataset->addFields(
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
            $lookupDataset->setOrderByField('id_usuario', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'multi_edit_tipos_tramite_tramites_id_funcionario_search', 'id_funcionario', 'id_usuario', null, 20);
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
    
    
    
    class tipos_tramitePage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Tipos de Tramite');
            $this->SetMenuLabel('Tipos de Tramite');
    
            $this->dataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`tipos_tramite`');
            $this->dataset->addFields(
                array(
                    new IntegerField('id_tipo_tramite', true, true, true),
                    new IntegerField('id_categoria', true),
                    new StringField('nombre', true),
                    new StringField('descripcion'),
                    new IntegerField('precio_base', true),
                    new IntegerField('usuario_registro', true),
                    new DateTimeField('fecha_registro'),
                    new DateTimeField('fecha_modificacion')
                )
            );
            $this->dataset->AddLookupField('id_categoria', 'categorias_tramite', new IntegerField('id_categoria'), new StringField('nombre', false, false, false, false, 'id_categoria_nombre', 'id_categoria_nombre_categorias_tramite'), 'id_categoria_nombre_categorias_tramite');
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
                new FilterColumn($this->dataset, 'id_tipo_tramite', 'id_tipo_tramite', 'Id'),
                new FilterColumn($this->dataset, 'id_categoria', 'id_categoria_nombre', 'Categoria'),
                new FilterColumn($this->dataset, 'nombre', 'nombre', 'Nombre'),
                new FilterColumn($this->dataset, 'descripcion', 'descripcion', 'Descripcion'),
                new FilterColumn($this->dataset, 'precio_base', 'precio_base', 'Precio Base'),
                new FilterColumn($this->dataset, 'usuario_registro', 'usuario_registro_nombres', 'Registrado por:'),
                new FilterColumn($this->dataset, 'fecha_registro', 'fecha_registro', 'Fecha de Registro'),
                new FilterColumn($this->dataset, 'fecha_modificacion', 'fecha_modificacion', 'Fecha de Modificacion')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['id_tipo_tramite'])
                ->addColumn($columns['id_categoria'])
                ->addColumn($columns['nombre'])
                ->addColumn($columns['descripcion'])
                ->addColumn($columns['precio_base'])
                ->addColumn($columns['usuario_registro'])
                ->addColumn($columns['fecha_registro'])
                ->addColumn($columns['fecha_modificacion']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('id_categoria')
                ->setOptionsFor('usuario_registro')
                ->setOptionsFor('fecha_registro')
                ->setOptionsFor('fecha_modificacion');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new TextEdit('id_tipo_tramite_edit');
            
            $filterBuilder->addColumn(
                $columns['id_tipo_tramite'],
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
            
            $main_editor = new DynamicCombobox('id_categoria_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_tipos_tramite_id_categoria_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('id_categoria', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_tipos_tramite_id_categoria_search');
            
            $text_editor = new TextEdit('id_categoria');
            
            $filterBuilder->addColumn(
                $columns['id_categoria'],
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
            
            $main_editor = new TextEdit('nombre_edit');
            $main_editor->SetMaxLength(100);
            
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
            
            $main_editor = new TextEdit('precio_base_edit');
            
            $filterBuilder->addColumn(
                $columns['precio_base'],
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
            
            $main_editor = new DynamicCombobox('usuario_registro_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_tipos_tramite_usuario_registro_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('usuario_registro', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_tipos_tramite_usuario_registro_search');
            
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
            if (GetCurrentUserPermissionsForPage('tipos_tramite.etapas_tramite')->HasViewGrant() && $withDetails)
            {
            //
            // View column for tipos_tramite_etapas_tramite detail
            //
            $column = new DetailColumn(array('id_tipo_tramite'), 'tipos_tramite.etapas_tramite', 'tipos_tramite_etapas_tramite_handler', $this->dataset, 'Etapas Tramite');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            }
            
            if (GetCurrentUserPermissionsForPage('tipos_tramite.tramites')->HasViewGrant() && $withDetails)
            {
            //
            // View column for tipos_tramite_tramites detail
            //
            $column = new DetailColumn(array('id_tipo_tramite'), 'tipos_tramite.tramites', 'tipos_tramite_tramites_handler', $this->dataset, 'Tramites');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            }
            
            //
            // View column for id_tipo_tramite field
            //
            $column = new NumberViewColumn('id_tipo_tramite', 'id_tipo_tramite', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for nombre field
            //
            $column = new TextViewColumn('id_categoria', 'id_categoria_nombre', 'Categoria', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for nombre field
            //
            $column = new TextViewColumn('nombre', 'nombre', 'Nombre', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
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
            // View column for precio_base field
            //
            $column = new NumberViewColumn('precio_base', 'precio_base', 'Precio Base', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for nombres field
            //
            $column = new TextViewColumn('usuario_registro', 'usuario_registro_nombres', 'Registrado por:', $this->dataset);
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
            // View column for id_tipo_tramite field
            //
            $column = new NumberViewColumn('id_tipo_tramite', 'id_tipo_tramite', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for nombre field
            //
            $column = new TextViewColumn('id_categoria', 'id_categoria_nombre', 'Categoria', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for nombre field
            //
            $column = new TextViewColumn('nombre', 'nombre', 'Nombre', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for descripcion field
            //
            $column = new TextViewColumn('descripcion', 'descripcion', 'Descripcion', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for precio_base field
            //
            $column = new NumberViewColumn('precio_base', 'precio_base', 'Precio Base', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for nombres field
            //
            $column = new TextViewColumn('usuario_registro', 'usuario_registro_nombres', 'Registrado por:', $this->dataset);
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
            // Edit column for id_categoria field
            //
            $editor = new DynamicCombobox('id_categoria_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`categorias_tramite`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_categoria', true, true, true),
                    new StringField('nombre', true),
                    new StringField('descripcion'),
                    new IntegerField('usuario_registro', true),
                    new DateTimeField('fecha_registro'),
                    new DateTimeField('fecha_modificacion')
                )
            );
            $lookupDataset->setOrderByField('nombre', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Categoria', 'id_categoria', 'id_categoria_nombre', 'edit_tipos_tramite_id_categoria_search', $editor, $this->dataset, $lookupDataset, 'id_categoria', 'nombre', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for nombre field
            //
            $editor = new TextEdit('nombre_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Nombre', 'nombre', $editor, $this->dataset);
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
            
            //
            // Edit column for precio_base field
            //
            $editor = new TextEdit('precio_base_edit');
            $editColumn = new CustomEditColumn('Precio Base', 'precio_base', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for id_categoria field
            //
            $editor = new DynamicCombobox('id_categoria_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`categorias_tramite`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_categoria', true, true, true),
                    new StringField('nombre', true),
                    new StringField('descripcion'),
                    new IntegerField('usuario_registro', true),
                    new DateTimeField('fecha_registro'),
                    new DateTimeField('fecha_modificacion')
                )
            );
            $lookupDataset->setOrderByField('nombre', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Categoria', 'id_categoria', 'id_categoria_nombre', 'multi_edit_tipos_tramite_id_categoria_search', $editor, $this->dataset, $lookupDataset, 'id_categoria', 'nombre', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for nombre field
            //
            $editor = new TextEdit('nombre_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Nombre', 'nombre', $editor, $this->dataset);
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
            // Edit column for precio_base field
            //
            $editor = new TextEdit('precio_base_edit');
            $editColumn = new CustomEditColumn('Precio Base', 'precio_base', $editor, $this->dataset);
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
            // Edit column for id_categoria field
            //
            $editor = new DynamicCombobox('id_categoria_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`categorias_tramite`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_categoria', true, true, true),
                    new StringField('nombre', true),
                    new StringField('descripcion'),
                    new IntegerField('usuario_registro', true),
                    new DateTimeField('fecha_registro'),
                    new DateTimeField('fecha_modificacion')
                )
            );
            $lookupDataset->setOrderByField('nombre', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Categoria', 'id_categoria', 'id_categoria_nombre', 'insert_tipos_tramite_id_categoria_search', $editor, $this->dataset, $lookupDataset, 'id_categoria', 'nombre', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for nombre field
            //
            $editor = new TextEdit('nombre_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Nombre', 'nombre', $editor, $this->dataset);
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
            // Edit column for precio_base field
            //
            $editor = new TextEdit('precio_base_edit');
            $editColumn = new CustomEditColumn('Precio Base', 'precio_base', $editor, $this->dataset);
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
            $editColumn = new DynamicLookupEditColumn('Registrado por:', 'usuario_registro', 'usuario_registro_nombres', 'insert_tipos_tramite_usuario_registro_search', $editor, $this->dataset, $lookupDataset, 'id_usuario', 'nombres', '');
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
            // View column for id_tipo_tramite field
            //
            $column = new NumberViewColumn('id_tipo_tramite', 'id_tipo_tramite', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for nombre field
            //
            $column = new TextViewColumn('id_categoria', 'id_categoria_nombre', 'Categoria', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for nombre field
            //
            $column = new TextViewColumn('nombre', 'nombre', 'Nombre', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for descripcion field
            //
            $column = new TextViewColumn('descripcion', 'descripcion', 'Descripcion', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for precio_base field
            //
            $column = new NumberViewColumn('precio_base', 'precio_base', 'Precio Base', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddPrintColumn($column);
            
            //
            // View column for nombres field
            //
            $column = new TextViewColumn('usuario_registro', 'usuario_registro_nombres', 'Registrado por:', $this->dataset);
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
            // View column for id_tipo_tramite field
            //
            $column = new NumberViewColumn('id_tipo_tramite', 'id_tipo_tramite', 'Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for nombre field
            //
            $column = new TextViewColumn('id_categoria', 'id_categoria_nombre', 'Categoria', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for nombre field
            //
            $column = new TextViewColumn('nombre', 'nombre', 'Nombre', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for descripcion field
            //
            $column = new TextViewColumn('descripcion', 'descripcion', 'Descripcion', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for precio_base field
            //
            $column = new NumberViewColumn('precio_base', 'precio_base', 'Precio Base', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddExportColumn($column);
            
            //
            // View column for nombres field
            //
            $column = new TextViewColumn('usuario_registro', 'usuario_registro_nombres', 'Registrado por:', $this->dataset);
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
            $column = new TextViewColumn('id_categoria', 'id_categoria_nombre', 'Categoria', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for nombre field
            //
            $column = new TextViewColumn('nombre', 'nombre', 'Nombre', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for descripcion field
            //
            $column = new TextViewColumn('descripcion', 'descripcion', 'Descripcion', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for precio_base field
            //
            $column = new NumberViewColumn('precio_base', 'precio_base', 'Precio Base', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddCompareColumn($column);
            
            //
            // View column for nombres field
            //
            $column = new TextViewColumn('usuario_registro', 'usuario_registro_nombres', 'Registrado por:', $this->dataset);
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
            $detailPage = new tipos_tramite_etapas_tramitePage('tipos_tramite_etapas_tramite', $this, array('id_tipo_tramite'), array('id_tipo_tramite'), $this->GetForeignKeyFields(), $this->CreateMasterDetailRecordGrid(), $this->dataset, GetCurrentUserPermissionsForPage('tipos_tramite.etapas_tramite'), 'UTF-8');
            $detailPage->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('tipos_tramite.etapas_tramite'));
            $detailPage->SetHttpHandlerName('tipos_tramite_etapas_tramite_handler');
            $handler = new PageHTTPHandler('tipos_tramite_etapas_tramite_handler', $detailPage);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $detailPage = new tipos_tramite_tramitesPage('tipos_tramite_tramites', $this, array('id_tipo_tramite'), array('id_tipo_tramite'), $this->GetForeignKeyFields(), $this->CreateMasterDetailRecordGrid(), $this->dataset, GetCurrentUserPermissionsForPage('tipos_tramite.tramites'), 'UTF-8');
            $detailPage->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('tipos_tramite.tramites'));
            $detailPage->SetHttpHandlerName('tipos_tramite_tramites_handler');
            $handler = new PageHTTPHandler('tipos_tramite_tramites_handler', $detailPage);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`categorias_tramite`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_categoria', true, true, true),
                    new StringField('nombre', true),
                    new StringField('descripcion'),
                    new IntegerField('usuario_registro', true),
                    new DateTimeField('fecha_registro'),
                    new DateTimeField('fecha_modificacion')
                )
            );
            $lookupDataset->setOrderByField('nombre', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'insert_tipos_tramite_id_categoria_search', 'id_categoria', 'nombre', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, 'insert_tipos_tramite_usuario_registro_search', 'id_usuario', 'nombres', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`categorias_tramite`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_categoria', true, true, true),
                    new StringField('nombre', true),
                    new StringField('descripcion'),
                    new IntegerField('usuario_registro', true),
                    new DateTimeField('fecha_registro'),
                    new DateTimeField('fecha_modificacion')
                )
            );
            $lookupDataset->setOrderByField('nombre', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'filter_builder_tipos_tramite_id_categoria_search', 'id_categoria', 'nombre', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, 'filter_builder_tipos_tramite_usuario_registro_search', 'id_usuario', 'nombres', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`categorias_tramite`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_categoria', true, true, true),
                    new StringField('nombre', true),
                    new StringField('descripcion'),
                    new IntegerField('usuario_registro', true),
                    new DateTimeField('fecha_registro'),
                    new DateTimeField('fecha_modificacion')
                )
            );
            $lookupDataset->setOrderByField('nombre', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'edit_tipos_tramite_id_categoria_search', 'id_categoria', 'nombre', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MyPDOConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`categorias_tramite`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('id_categoria', true, true, true),
                    new StringField('nombre', true),
                    new StringField('descripcion'),
                    new IntegerField('usuario_registro', true),
                    new DateTimeField('fecha_registro'),
                    new DateTimeField('fecha_modificacion')
                )
            );
            $lookupDataset->setOrderByField('nombre', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'multi_edit_tipos_tramite_id_categoria_search', 'id_categoria', 'nombre', null, 20);
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
        $Page = new tipos_tramitePage("tipos_tramite", "tipos_tramite.php", GetCurrentUserPermissionsForPage("tipos_tramite"), 'UTF-8');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("tipos_tramite"));
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e);
    }
	
