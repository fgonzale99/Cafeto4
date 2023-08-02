@extends('adminlte::page')

@section('content')
<div class="card">
              <div class="card-header">
                <h3 class="card-title">Búsqueda de Pares</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form">
                <div class="card-body">

                  <div class="input-group mb-3">
                    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Criterio de Búsqueda">
                    <div class="input-group-append">
                      <button type="submit" class="btn btn-primary">Buscar</button>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3">
                      <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Colciencias Hoja de Vida General</label>
                      </div>
                    </div>

                    <div class="col-lg-3">
                      <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Colciencias Artículos</label>
                      </div>
                    </div>

                    <div class="col-lg-3">
                      <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Colciencias Proyectos</label>
                      </div>
                    </div>

                    <div class="col-lg-3">
                      <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Colciencias Libros</label>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
              </form>
            </div>
<!-- /.card -->

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lista de Evaluadores Existentes en Cafeto</h3>
              <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
            <i class="fas fa-minus"></i></button>
          <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
            <i class="fas fa-times"></i></button>
          </div>
      </div>
      <div class="card-body">
        <table class="table table-hover">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Nombre Investigador</th>
                    <th>Asociado</th>
                    <th>Par reconocido</th>
                    <th>Correo</th>
                    <th>Acción</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>183</td>
                    <td><a href="">Juan Carlos Moreno Piraján</a></td>
                    <td>✓</td>
                    <td><span class="tag tag-success">✓</span></td>
                    <td>par@correo.com</td>
                    <td><button type="button" class="btn btn-block bg-gradient-success btn-sm">Asignar</button></td>
                  </tr>
                  <tr>
                    <td>183</td>
                    <td><a href="">Juan Carlos Moreno Piraján</a></td>
                    <td>✓</td>
                    <td><span class="tag tag-success">✓</span></td>
                    <td>par@correo.com</td>
                    <td><button type="button" class="btn btn-block bg-gradient-success btn-sm">Asignar</button></td>
                  </tr>
                  <tr>
                    <td>183</td>
                    <td><a href="">Juan Carlos Moreno Piraján</a></td>
                    <td>✓</td>
                    <td><span class="tag tag-success">✓</span></td>
                    <td>par@correo.com</td>
                    <td><button type="button" class="btn btn-block bg-gradient-success btn-sm">Asignar</button></td>
                  </tr>
                </tbody>
              </table>
      </div>
      <!-- /.card-body -->
      <div class="card-footer">
          Footer
      </div>
    <!-- /.card-footer-->
</div>
<!-- /.card -->

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Resultados Colciencias Hoja de Vida General</h3>
              <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
            <i class="fas fa-minus"></i></button>
          <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
            <i class="fas fa-times"></i></button>
          </div>
      </div>
      <div class="card-body">
        <table class="table table-hover">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Nombre Investigador</th>
                    <th>Asociado</th>
                    <th>Par reconocido</th>
                    <th>Artículo</th>
                    <th>Acción</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>183</td>
                    <td><a href="">Juan Carlos Moreno Piraján</a></td>
                    <td>✓</td>
                    <td><span class="tag tag-success">✓</span></td>
                    <td>Lorem Impsu ..........</td>
                    <td><button type="button" class="btn btn-block bg-gradient-primary btn-xs">Agregar</button>
                      <button type="button" class="btn btn-block bg-gradient-success btn-xs">Asignar</button></td>
                  </tr>
                  <tr>
                    <td>183</td>
                    <td><a href="">Juan Carlos Moreno Piraján</a></td>
                    <td>✓</td>
                    <td><span class="tag tag-success">✓</span></td>
                    <td>Lorem Impsu ..........</td>
                    <td><button type="button" class="btn btn-block bg-gradient-primary btn-xs">Agregar</button>
                      <button type="button" class="btn btn-block bg-gradient-success btn-xs">Asignar</button></td>
                  </tr>
                                  </tbody>
              </table>
      </div>
      <!-- /.card-body -->
      <div class="card-footer">
          Footer
      </div>
    <!-- /.card-footer-->
</div>
<!-- /.card -->

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Resultados Colciencias Artículos</h3>
              <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
            <i class="fas fa-minus"></i></button>
          <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
            <i class="fas fa-times"></i></button>
          </div>
      </div>
      <div class="card-body">
        <table class="table table-hover">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Nombre Investigador</th>
                    <th>Asociado</th>
                    <th>Par reconocido</th>
                    <th>Artículo</th>
                    <th>Acción</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>183</td>
                    <td><a href="">Juan Carlos Moreno Piraján</a></td>
                    <td>✓</td>
                    <td><span class="tag tag-success">✓</span></td>
                    <td>Lorem Impsu ..........</td>
                    <td><button type="button" class="btn btn-block bg-gradient-primary btn-xs">Agregar</button>
                      <button type="button" class="btn btn-block bg-gradient-success btn-xs">Asignar</button></td>                  </tr>
                  <tr>
                    <td>183</td>
                    <td><a href="">Juan Carlos Moreno Piraján</a></td>
                    <td>✓</td>
                    <td><span class="tag tag-success">✓</span></td>
                    <td>Lorem Impsu ..........</td>
                    <td><button type="button" class="btn btn-block bg-gradient-primary btn-xs">Agregar</button>
                      <button type="button" class="btn btn-block bg-gradient-success btn-xs">Asignar</button></td>                  </tr>
                          </tbody>
              </table>
          </div>
      <!-- /.card-body -->
      <div class="card-footer">
          Footer
      </div>
    <!-- /.card-footer-->
</div>
<!-- /.card -->

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Resultados Colciencias Proyectos</h3>
              <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
            <i class="fas fa-minus"></i></button>
          <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
            <i class="fas fa-times"></i></button>
          </div>
      </div>
      <div class="card-body">
        <table class="table table-hover">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Nombre Investigador</th>
                    <th>Asociado</th>
                    <th>Par reconocido</th>
                    <th>Artículo</th>
                    <th>Acción</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>183</td>
                    <td><a href="">Juan Carlos Moreno Piraján</a></td>
                    <td>✓</td>
                    <td><span class="tag tag-success">✓</span></td>
                    <td>Lorem Impsu ..........</td>
                    <td><button type="button" class="btn btn-block bg-gradient-primary btn-xs">Agregar</button>
                      <button type="button" class="btn btn-block bg-gradient-success btn-xs">Asignar</button></td>                  </tr>
                  <tr>
                    <td>183</td>
                    <td><a href="">Juan Carlos Moreno Piraján</a></td>
                    <td>✓</td>
                    <td><span class="tag tag-success">✓</span></td>
                    <td>Lorem Impsu ..........</td>
                    <td><button type="button" class="btn btn-block bg-gradient-primary btn-xs">Agregar</button>
                      <button type="button" class="btn btn-block bg-gradient-success btn-xs">Asignar</button></td>                  </tr>
                  <tr>
                    <td>183</td>
                    <td><a href="">Juan Carlos Moreno Piraján</a></td>
                    <td>✓</td>
                    <td><span class="tag tag-success">✓</span></td>
                    <td>Lorem Impsu ..........</td>
                    <td><button type="button" class="btn btn-block bg-gradient-primary btn-xs">Agregar</button>
                      <button type="button" class="btn btn-block bg-gradient-success btn-xs">Asignar</button></td>                  </tr>
                                  </tbody>
              </table>
      </div>
      <!-- /.card-body -->
      <div class="card-footer">
          Footer
      </div>
    <!-- /.card-footer-->
</div>
<!-- /.card -->

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Resultados Colciencias Libros</h3>
              <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
            <i class="fas fa-minus"></i></button>
          <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
            <i class="fas fa-times"></i></button>
          </div>
      </div>
      <div class="card-body">
        <table class="table table-hover">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Nombre Investigador</th>
                    <th>Asociado</th>
                    <th>Par reconocido</th>
                    <th>Artículo</th>
                    <th>Acción</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>183</td>
                    <td><a href="">Juan Carlos Moreno Piraján</a></td>
                    <td>✓</td>
                    <td><span class="tag tag-success">✓</span></td>
                    <td>Lorem Impsu ..........</td>
                    <td><button type="button" class="btn btn-block bg-gradient-primary btn-xs">Agregar</button>
                      <button type="button" class="btn btn-block bg-gradient-success btn-xs">Asignar</button></td>                  </tr>
                  <tr>
                    <td>183</td>
                    <td><a href="">Juan Carlos Moreno Piraján</a></td>
                    <td>✓</td>
                    <td><span class="tag tag-success">✓</span></td>
                    <td>Lorem Impsu ..........</td>
                    <td><button type="button" class="btn btn-block bg-gradient-primary btn-xs">Agregar</button>
                      <button type="button" class="btn btn-block bg-gradient-success btn-xs">Asignar</button></td>                  </tr>
                                  </tbody>
              </table>
      </div>
      <!-- /.card-body -->
      <div class="card-footer">
          Footer
      </div>
    <!-- /.card-footer-->
</div>
<!-- /.card -->
@endsection
