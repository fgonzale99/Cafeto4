@extends('adminlte::page')

@section('content')
<!-- Timelime example  -->
      <div class="row">
        <div class="col-md-8 offset-md-2">
          <!-- The time line -->
          <div class="timeline">
            @foreach($actividad as $keyActivad => $valueActiviad)
            <!-- timeline time label -->
            <div class="time-label">
              <span class="bg-primary">{{ date('j M, Y', strtotime($valueActiviad->created_at)) }}</span>
            </div>
            <!-- /.timeline-label -->
            <!-- timeline item -->
            <div>
              <i class="fas fa-user bg-green"></i>
              <div class="timeline-item">
                <h3 class="timeline-header">{{ $valueActiviad->justificacion }}</h3>
              </div>
            </div>
            <!-- END timeline item -->
            @endforeach
            <div>
              <i class="fas fa-clock bg-gray"></i>
            </div>
          </div>
        </div>
        <!-- /.col -->
      </div>
    </div>
    <!-- /.timeline -->

@endsection

@section('js')

@endsection
