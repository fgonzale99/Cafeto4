<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Mail;

class CrudController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function list()
  {
    return view('crud.main');
  }

  public function new()
  {
    return view('crud.main');
  }

  public function edit()
  {
    return view('crud.main');
  }

  public function show()
  {
    return view('crud.main');
  }

  public function board()
  {
    return view('crud.main');
  }

  public function getList(Request $request)
  {


    $model = ucwords($request->modelName);
    $className = "\App\Models\\$model";
    $module = $request->moduleName;
    $max = 20;
    $page = ($request->page) ? $request->page : 1;

    $arrayFilters = array();

    if ($request->filters) {
      $filters = json_decode($request->filters);
      foreach ($filters as $keyFilter => $valueFilter) {
        $arrayFilters[] = [$valueFilter[0], 'like', "$valueFilter[1]%"];
      }
    }

    if ($request->prefilter) {
      $prefilter = json_decode($request->prefilter);
      foreach ($prefilter as $keyFilter => $valueFilter) {
        $arrayFilters[] = [$keyFilter, '=', "$valueFilter"];
      }
    }

    try {
 
   

      //$data = ("{$className}::get")();
      //  $data = $className::where($arrayFilters)->skip(($page - 1)*$max)->take($max)->get();
      //filtrar inactivos

      //hack temporal para que no filtre unidades de evaluacion
      if($className=='\App\Models\ProjectReview'){
        $data = $className::where($arrayFilters)->skip(($page - 1)*$max)->take($max)->get();
      }
       else
       {
        $data = $className::where('state', '!=', 'Inactivo')->where($arrayFilters)->skip(($page - 1) * $max)->take($max)->get();

       }
      
      $dataTotal = $className::where($arrayFilters)->count();

      $pagesTotal = ceil($dataTotal / $max);

      $dataModule = \App\Models\Module::whereRaw("LOWER(moduleName) LIKE ?", $module)->first();
      foreach ($data as $key => $value) {
        foreach (json_decode($dataModule->fields) as $keyF => $valueF) {
          if ($valueF->type == "select" && $valueF->origin == "model") {
            $value->{$valueF->alias};
          }
        }
      }

      $response['data'] = $data;
      $response['total'] = $dataTotal;
      $response['pagesTotal'] = $pagesTotal;
      $response['success'] = true;
    } catch (\Exception $e) {
      $response['message'] = $e->getMessage();
      $response['success'] = false;
    }
    return $response;
  }

  public function getOptions(Request $request)
  {

    $model = ucwords($request->modelName);
    $className = "\App\Models\\$model";

    try {

      $data = ("{$className}::get")();

      $response['data'] = $data;
      $response['success'] = true;
    } catch (\Exception $e) {
      $response['message'] = $e->getMessage();
      $response['success'] = false;
    }
    return $response;
  }

  public function get(Request $request)
  {

    $model = ucwords($request->modelName);
    $module = $request->moduleName;
    $elementId = $request->id;
    $className = "\App\Models\\$model";

    try {

      $data = ("{$className}::find")($elementId);

      $dataModule = \App\Models\Module::whereRaw("LOWER(moduleName) LIKE ?", $module)->first();
      foreach (json_decode($dataModule->fields) as $keyF => $valueF) {
        if ($valueF->type == "select" && $valueF->origin == "model") {
          $data->{$valueF->alias};
        }
      }

      //traer archivos
      $dataFiles = \App\Models\File::where('model', 'like', $model)->where('elementId', $elementId)->orderBy('id', 'desc')->get();

      if ($data) {
        $response['data'] = $data;
        $response['data']['files'] = $dataFiles;
        $response['message'] = "Load successful";
        $response['success'] = true;
      } else {
        $response['message'] = "Not found data id => $elementId";
        $response['success'] = false;
      }
    } catch (\Exception $e) {
      $response['message'] = $e->getMessage();
      $response['success'] = false;
    }
    return $response;
  }


  public function getModule(Request $request)
  {
    $module = $request->moduleName;

    try {

      $data = \App\Models\Module::whereRaw("LOWER(moduleName) LIKE ?", $module)->first();

      if ($data) {
        $response['data']['model'] = $data->model;
        $response['data']['fields'] = json_decode($data->fields);
        $response['data']['actions'] = json_decode($data->actions);
        $response['data']['props'] = json_decode($data->props);

        $response['message'] = "Load successful";
        $response['success'] = true;
      } else {
        $response['message'] = "Not found data id => $module";
        $response['success'] = false;
      }
    } catch (\Exception $e) {
      $response['message'] = $e->getMessage();
      $response['success'] = false;
    }
    return $response;
  }


  public function create(Request $request)
  {

    try {

      foreach ($request->all() as $key => $value) {
        if ($key !== 'modelName') $insert[$key] = $value;
      };

      $model = ucwords($request->modelName);
      $className = "\App\Models\\$model";
      $element = ("{$className}::create")($insert);

      $response['message'] = "Form recorded.";
      $response['data'] = $element;
      $response['success'] = true;

      //save files
      if ($request->file()) {

        $files = $request->file();

        foreach ($files as $keyFile => $valueFile) {

          $data['file'] = $request->file($keyFile);
          $data['name'] = $request->file($keyFile);
          $data['field'] = $keyFile;
          $data['user'] = 1;
          $data['model'] = $model;
          $data['elementId'] = $element->id;

          $this->fileSave($data);
        }
      }
    } catch (\Exception $e) {
      $response['message'] = $e->getMessage();
      $response['success'] = false;
    }

    return $response;
  }

  public function delete(Request $request)
  {
    $model = ucwords($request->modelName);
    $idElement = $request->id;
    $className = "\App\Models\\$model";

    try {
      $data['state'] = 'Inactivo';
      $res = ("{$className}::where")("id", $idElement)->update($data);
      $response['res'] = $res;
      $response['message'] = "Inactivated successful";
      $response['success'] = true;
    } catch (\Exception $e) {
      $response['message'] = $e->getMessage();
      $response['success'] = false;
    }

    return $response;
  }



  public function duplicate(Request $request)
  {
    $model = ucwords($request->modelName);
    $idElement = $request->id;
    $className = "\App\Models\\$model";

    try {

      $dup = ("{$className}::find")($idElement)->replicate();

      $dup->created_at = \Carbon\Carbon::now();
      
      $res = $dup->save();



      $response['res'] = $res;
      $response['message'] = "Duplication successful";
      $response['success'] = true;
    } catch (\Exception $e) {
      $response['message'] = $e->getMessage();
      $response['success'] = false;
    }

    return $response;
  }


  public function getEnum(Request $request)
  {

    $table = $request->modelName;
    $column = $request->field;

    try {
      $type = DB::select(DB::raw("SHOW COLUMNS FROM $table WHERE Field = '{$column}'"))[0]->Type;

      preg_match('/^enum\((.*)\)$/', $type, $matches);

      $enum_values = array();
      foreach (explode(',', $matches[1]) as $value) {
        $v = trim($value, "'");
        $enum_values[]['value'] = $v;
      }

      $response['data'] = $enum_values;
      $response['message'] = "Load successful";
      $response['success'] = true;
    } catch (\Exception $e) {
      $response['message'] = $e->getMessage();
      $response['success'] = false;
    }

    return $response;
  }

  public function update(Request $request)
  {

    $model = ucwords($request->modelName);
    $idElement = $request->id;
    $className = "\App\Models\\$model";

    try {

      foreach ($request->all() as $key => $value) {
        if ($key !== 'model' && $key !== 'id' && $key !== 'password' && $key !== 'passwordConfirm') $update[$key] = $value;
      };

      if ($request->password && $request->passwordConfirm) {
        if ($request->password == $request->passwordConfirm) {
          $update['password'] = Hash::make($request->password);
        } else {
          $response['message'] = "Las contraseñas no coinciden.";
          $response['success'] = false;
          return $response;
        }
      }

      $element = ("{$className}::find")($idElement);

      $element->update($update);
      $element->save();

      //save files
      if ($request->file()) {

        $files = $request->file();

        foreach ($files as $keyFile => $valueFile) {

          $data['file'] = $request->file($keyFile);
          $data['name'] = $request->file($keyFile);
          $data['field'] = $keyFile;
          $data['user'] = 1;
          $data['model'] = $model;
          $data['elementId'] = $element->id;
          $this->fileSave($data);
        }
      }

      $response['message'] = "Form recorded.";
      $response['success'] = true;
    } catch (\Exception $e) {
      $response['message'] = $e->getMessage();
      $response['success'] = false;
    }

    return $response;
  }

  public function fileSave($data)
  {
    //Almacenar documentos

    $filename = time() . "_" . $data['file']->getClientOriginalName();
    Storage::disk('local')->putFileAs(
      'public/files/',
      $data['file'],
      $filename
    );

    $upload = new \App\Models\File;
    $upload->name = $filename;
    $upload->file = $filename;
    $upload->field = $data['field'];
    $upload->description = $data['field'];
    $upload->model = $data['model'];
    $upload->elementId = $data['elementId'];
    $upload->user = $data['user'];
    $upload->state = 'Activo';
    $upload->created_at = time();
    $upload->updated_at = time();

    $upload->save();
  }

  public function getFile(Request $request)
  {

    $fileModel = ucwords($request->fileModel);
    $fieldName = $request->fieldName;
    $elementId = $request->elementId;

    try {

      $data = \App\Models\File::where('model', 'like', $fileModel)->where('field', 'like', $fieldName)->where('elementId', $elementId)->first();

      if ($data) {
        $response['data'] = $data;
        $response['message'] = "Load successful";
        $response['success'] = true;
      } else {
        $response['message'] = "Not found data id => $elementId";
        $response['success'] = false;
      }
    } catch (\Exception $e) {
      $response['message'] = $e->getMessage();
      $response['success'] = false;
    }
    return $response;
  }


  public function getFiles(Request $request)
  {

    $model = strtolower($request->modelName);
    $module = $request->moduleName;
    $elementId = $request->id;
    $className = "\App\\$model";

    try {

      $data = \App\archivosModel::where('entidad', 'like', $model)->where('entidad_id', $elementId)->get();

      if ($data) {
        $response['data'] = $data;
        $response['message'] = "Load successful";
        $response['success'] = true;
      } else {
        $response['message'] = "Not found data id => $elementId";
        $response['success'] = false;
      }
    } catch (\Exception $e) {
      $response['message'] = $e->getMessage();
      $response['success'] = false;
    }
    return $response;
  }

  public function export(Request $request)
  {

    $module = $request->module;
    $moduleData = \App\Models\Module::whereRaw("LOWER(moduleName) LIKE ?", $module)->first();

    $model = ucwords($moduleData->model);
    $className = "\App\Models\\$model";

    $this->_documento = new Spreadsheet();
    $this->_documento
      ->getProperties()
      ->setCreator("Asociación Colombiana Para el Avance de la Ciencia")
      ->setTitle('Informe');

    $this->_activeSheet = $this->_documento->getActiveSheet();

    $this->_indexFila = 1;

    $moduleFields = json_decode($moduleData->fields, true);

    $indexColumn = 1;
    //Poner encabezados
    foreach ($moduleFields as $keyField => $valueField) {
      if ($valueField['show'] == "true" && $valueField['type'] != "file" && isset($valueField['name'])) {
        $this->_activeSheet->setCellValueByColumnAndRow($indexColumn, $this->_indexFila, $valueField['label']);
        $indexColumn++;
      }
    }

    $arrayFilters = array();

    if ($request->filters) {
      $filters = json_decode($request->filters);
      foreach ($filters as $keyFilter => $valueFilter) {
        $arrayFilters[] = [$valueFilter[0], 'like', "%$valueFilter[1]%"];
      }
    }

    if ($request->prefilter) {
      $prefilter = json_decode($request->prefilter);
      foreach ($prefilter as $keyFilter => $valueFilter) {
        $arrayFilters[] = [$keyFilter, '=', "$valueFilter"];
      }
    }

    $data = $className::where($arrayFilters)->get();
    $dataTotal = $className::where($arrayFilters)->count();

    //Poner Datos

    foreach ($data as $key => $value) {
      $this->_indexFila++;
      foreach (json_decode($moduleData->fields) as $keyF => $valueF) {
        if (isset($valueF->origin) && $valueF->origin == "model") {
          $value->{$valueF->alias};
        }
      }

      $indexColumn = 1;
      foreach ($moduleFields as $keyField => $valueField) {

        $valorCelda = "";
        if ($valueField['show'] == "true" && $valueField['type'] != "file" && isset($valueField['name'])) {

          switch ($valueField['type']) {
            case 'radio-group':
              if (isset($valueField['origin']) && $valueField['origin'] == "model") {
                $valorCelda = $value->{$valueField['alias']}->{$valueField['fieldOrigin']};
              } else {
                $valorCelda = $value->{$valueField['name']};
              }
              break;
            case 'checkbox-group':
              $valorCelda = $value->{$valueField['name']};
              break;
            case 'select':
              if (isset($valueField['origin']) && $valueField['origin'] == "model") {
                $valorCelda = $value->{$valueField['alias']}->{$valueField['fieldOrigin']};
              } else {
                $valorCelda = $value->{$valueField['name']};
              }
              break;
            default:
              $valorCelda = $value->{$valueField['name']};
              break;
          }

          $this->_activeSheet->setCellValueByColumnAndRow($indexColumn, $this->_indexFila, $valorCelda);
          $indexColumn++;
        }
      }
    }

    $nombreDelDocumento = "reporte_" . $module . "_" . date('Y-m-d H:i:s') . ".xlsx";

    $writer = new Xlsx($this->_documento);

    try {

      // Get the writer and export in memory.
      $response = new StreamedResponse(
        function () use ($writer) {
          $writer->save('php://output');
        }
      );
      $response->headers->set('Content-Type', 'application/vnd.ms-excel');
      $response->headers->set('Content-Disposition', 'attachment;filename="' . $nombreDelDocumento . '"');
      $response->headers->set('Cache-Control', 'max-age=0');
      return $response;
    } catch (\Exception $e) {
      print($e->getMessage());
    }
  }

  public function mailTest()
  {
    Mail::send('crud.mails.test', [], function ($mail) {
      $mail->to('manuelgb13@gmail.com')->subject('Test');
    });
  }
}
