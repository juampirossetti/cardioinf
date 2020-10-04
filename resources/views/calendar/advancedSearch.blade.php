<div class="panel panel-primary advanced-search-panel" style="display:none;">
  <div class="panel-body form-horizontal">
    <!-- Dni Field -->
    <div class="form-group">
        {!! Form::label('advanced_dni', 'Dni:', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
          {!! Form::text('advanced_dni', null, ['class' => 'form-control col-sm-10 advanced-dni']) !!}
        </div>
    </div>
    <!-- Surname Field -->
    <div class="form-group">
        {!! Form::label('advanced_surname', 'Apellido:', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('advanced_surname',null, ['class' => 'form-control col-sm-10 advanced-surname']) !!}
        </div>
    </div>
    <!-- Name Field -->
    <div class="form-group">
        {!! Form::label('advanced_name', 'Nombre:', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('advanced_name',null, ['class' => 'form-control col-sm-10 advanced-name']) !!}
        </div>
    </div>

    <button type="button" class="btn btn-default pull-right btn-sm advanced-search-submit" id="advancedSearchSubmit">
      Buscar
    </button>
    <div class="clearfix"></div>
  <div class="form-group">
    @include('calendar.tableResultSearch')
  </div>
  </div>

  <div class="panel-footer">
      <button type="button" class="btn btn-xs btn-primary advanced-confirm" id="advanced_confirm">Aceptar</button>
      <button type="button" class="btn btn-xs btn-default advanced-cancel" id="advanced_cancel">Cancelar</button>
      <button type="button" class="btn btn-xs btn-primary pull-right advanced-new" id="advanced_new">Nuevo</button>
  </div>
</div>