<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Http\Requests\ModuleRequest;

class ModuleCrudController extends CrudController {

  use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
  use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
  use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
  use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
  use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

  public function setup()
  {
      $this->crud->setModel("App\Models\Module");
      $this->crud->setRoute("admin/module");
      $this->crud->setEntityNameStrings('module', 'module');
  }

  protected function setupListOperation()
  {
      // TODO: remove setFromDb() and manually define Columns, maybe Filters
      $this->crud->setFromDb();
  }

  protected function setupCreateOperation()
  {
      $this->crud->setValidation(ModuleRequest::class);

      // TODO: remove setFromDb() and manually define Fields
      $this->crud->setFromDb();
  }

  protected function setupUpdateOperation()
  {
      $this->setupCreateOperation();
  }
}
