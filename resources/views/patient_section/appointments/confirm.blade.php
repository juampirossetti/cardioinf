<div class="row">
        {!! Form::open(['route' => 'patient.appointments.store']) !!}
            @include('patient_section.appointments.fields')
        <div class="col-lg-12">
          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">3. Confirme los datos</h3>
            </div>
              <!-- /.box-header -->
              <div class="box-body">
                <div class="col-md-12">
                  <!-- Professional Id Field -->
                  <div class="form-group">
                    {!! Form::label('professional', 'Médico:') !!}
                    <span id="professional-text">{{$professional->complete_name}}</span>
                  </div>
                  
                  <!-- Patient Id Field -->
                  <div class="form-group">
                    {!! Form::label('patient', 'Paciente:') !!}
                    <span id="patient-text">{!! Auth::user()->patient->getCompleteName() !!}</span>
                  </div>
                  
                  <!-- Date Field -->
                  <div class="form-group">
                    {!! Form::label('date', 'Fecha y hora:') !!}
                    <span id="date-text"></span>
                  </div>

                  <!-- Insurance Field -->
                  <div class="form-group">
                    {!! Form::label('insurance', 'Obra Social:') !!}
                    <span id="insurance-text"></span>
                  </div>



                  <!-- Study type Field -->
                  <div class="form-group">
                    {!! Form::label('medical_study', 'Tipo de consulta:') !!}
                    <span id="medical-study-text"></span>
                  </div>

                  <!-- Submit Field -->
                  <div class="form-group">
                    {!! Form::submit('Confirmar', ['class' => 'btn btn-primary confirm-submit']) !!}
                    <a href="{!! URL::previous() !!}" class="btn btn-default">Cancelar</a>
                  </div>
                 </div>
              </div>
              <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        {!! Form::close() !!}
  </div>