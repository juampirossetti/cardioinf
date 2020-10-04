<div class="row">
        <div class="col-lg-12">
          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">1. Seleccione tipo de consulta y obra social</h3>
            </div>
              <!-- /.box-header -->
              <div class="box-body">

                <div class="col-md-12">
                  <!-- Study Type Field -->
                  <div class="form-group">
                    {!! Form::label('medical_study_id', 'Tipo de consulta:') !!}
                    {!! Form::select('medical_study_id', ['null' => 'Seleccionar'] + $medicalStudies->pluck('name','id')->all(), 
                        null,
                        ['class' => 'form-control select2 select2-hidden-accessible medical-study-select',
                         'tabindex' => '-1',
                         'aria-hidden' => 'true',
                         'style' => 'width:100%;']) !!}
                  </div>
                  <!-- /.form-group -->
                </div>
                <div class="col-md-12">
                  <!-- Insurance Id Field -->
                  <div class="form-group">
                    {!! Form::label('insurance_id', 'Obra Social:') !!}
                    {!! Form::select('insurance_id', ['null' => 'Seleccionar'] + $insurances, 
                        null,
                        ['class' => 'form-control select2 select2-hidden-accessible insurance-select',
                         'tabindex' => '-1',
                         'aria-hidden' => 'true',
                         'style' => 'width:100%;']) !!}
                  </div>
                <!-- /.form-group -->
                </div>
                <div class="col-md-12">
                   {!! Form::label('patient_owner', 'Destinatario del turno:') !!}
                   
                    <label class="radio-inline">
                      {!! Form::input('radio', 'appointment_owner', 'other', ['checked' => 'true', 'class' => 'hidden']) !!}
                    </label>
                    <div class="patient-radio row">
                    <!-- <label class="radio-inline">
                      {!! Form::input('radio', 'appointment_owner', 'me', ['checked' => 'true']) !!} Turno para mi
                    </label>
                    -->
                      <div class="form-group patient-information  col-md-6">
                        <label for="patient_surname">Apellido:</label>
                        {!! Form::text('patient_surname', null, ['class' => 'form-control patient-input', 'id' => 'patient_surname']) !!}
                      </div>
                    
                      <div class="form-group patient-information col-md-6">
                        <label for="patient_name">Nombre:</label>
                        {!! Form::text('patient_name', null, ['class' => 'form-control patient-input', 'id' => 'patient_name']) !!}
                      </div>

                      <div class="form-group patient-information col-md-6">
                        <label for="patient_dni">DNI:</label>
                        {!! Form::text('patient_dni', null, ['class' => 'form-control patient-input', 'id' => 'patient_dni']) !!}
                      </div>
                      
                      <div class="form-group patient-information col-md-6">
                        <label for="patient_primary_phone">Teléfono:</label>
                        {!! Form::text('patient_primary_phone', null, ['class' => 'form-control patient-input', 'id' => 'patient_primary_phone']) !!}
                      </div>                    
                  </div>
                </div>
                  
                <div class="col-md-12 callout callout-info" id="insurance-message" style="display:none;">
                  <h4></h4>
                </div>
              </div>
              
              <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>

  </div>