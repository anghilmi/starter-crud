<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
// use DB;
// use Doctrine\DBAL\Schema\Schema as SchemaSchema;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\Schema as FacadesSchema;
// use Schema;

class CrudGenerator extends Command
{
    protected $signature = 'make:crud {name}';
    protected $description = 'Generate CRUD operations for a given model';

    public function handle()
    {
        $name = $this->argument('name');
        $this->generateModel($name);
        $this->generateController($name);
        $this->generateViews($name);
        $this->generateRoutes($name);
        $this->generateFormFieldsCreate($name);
        $this->generateFormFieldsEdit($name);
    }

    protected function generateFormFieldsCreate($name)
{
    $table = Str::plural(strtolower($name));
    $columns = FacadesSchema::getColumnListing($table);
    $fields = array_diff($columns, ['id', 'created_at', 'updated_at', 'deleted_at']);

    $formFields = "";
    foreach ($fields as $field) {
        $formFields .= "
                <div class=\"form-group\">
                    <label for=\"$field\">" . ucfirst(str_replace('_', ' ', $field)) . "</label>
                    <input type=\"text\" name=\"$field\" class=\"form-control\" >
                    @error('$field')
                    <div class=\"text-danger\">{{ \$message }}</div>
                    @enderror
                </div>";
    }

    return $formFields;
}

protected function generateFormFieldsEdit($name)
{
    $table = Str::plural(strtolower($name));
    $columns = FacadesSchema::getColumnListing($table);
    $fields = array_diff($columns, ['id', 'created_at', 'updated_at', 'deleted_at']);

    $formFields = "";
    foreach ($fields as $field) {
        $formFields .= "
                <div class=\"form-group\">
                    <label for=\"$field\">" . ucfirst(str_replace('_', ' ', $field)) . "</label>
                    <input type=\"text\" name=\"$field\" class=\"form-control\" value=\"{{ \$$name->$field }}\">
                    @error('$field')
                    <div class=\"text-danger\">{{ \$message }}</div>
                    @enderror
                </div>";
    }

    return $formFields;
}


    protected function generateModel($name) //ok
    {
        $table = Str::plural(strtolower($name));
        $columns = FacadesSchema::getColumnListing($table);

        // Remove id, created_at, updated_at, and deleted_at from fillable fields
        $fillable = array_diff($columns, ['id', 'created_at', 'updated_at', 'deleted_at']);
        $fillableFields = "['" . implode("', '", $fillable) . "']";

        $modelTemplate = str_replace(
            ['{{modelName}}', '{{fillable}}'],
            [$name, $fillableFields],
            $this->getStub('Model')
        );

        if (!file_exists($path = app_path('/Models'))) {
            mkdir($path, 0777, true);
        }

        file_put_contents(app_path("/Models/{$name}.php"), $modelTemplate);
    }

    protected function generateController($name)
{ //ok
        $table = Str::plural(strtolower($name));
        $columns = FacadesSchema::getColumnListing($table);

        // Remove id, created_at, updated_at, and deleted_at from fillable fields
        $fillable = array_diff($columns, ['id', 'created_at', 'updated_at', 'deleted_at']);
        //$fillableFields = "['" . implode("', '", $fillable) . "']";

        $searchableColumnsString = '';
        $dataToDB= '';
        $validationRules = "['" . implode("' => 'required',\n '", $fillable) . "' => 'required']";
        // $dataToDB = "\$data['" .$fillable."'] = \$request->".$fillable.";"; 
        
 
    foreach ($fillable as $column) {
        $column = trim($column, " \t\n\r\0\x0B'\"");
        $searchableColumnsString .= "->orWhere('$column', 'like', '%' . \$search . '%')\n                ";
        $dataToDB .= "\$data['" .$column."'] = \$request->".$column.";\n"; 
    }
    $searchableColumnsString .= ";";

    $controllerTemplate = str_replace(
        ['{{modelName}}', '{{modelNamePluralLowerCase}}', '@SEARCHABLE_COLUMNS@','{{validationRules}}', '@dataToDB@'],
        [$name, strtolower(\Illuminate\Support\Str::plural($name)), $searchableColumnsString, $validationRules, $dataToDB],
        $this->getStub('Controller')
    );

    file_put_contents(app_path("/Http/Controllers/{$name}Controller.php"), $controllerTemplate);
}

    protected function generateViews($name)
    {
        $views = ['index', 'create', 'edit', 'show'];
        $path = resource_path("views/" . strtolower(Str::plural($name)));

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        foreach ($views as $view) {
            $viewTemplate = str_replace(
                ['{{modelName}}', '{{modelNamePluralLowerCase}}', '{{tableHeaders}}', '{{tableData}}', '{{searchableColumns}}','{{formFieldsCreate}}', '{{formFieldsEdit}}'],
                [$name, strtolower(Str::plural($name)), $this->generateTableHeaders($name), $this->generateTableData($name), $this->generateSearchableColumns($name),$this->generateFormFieldsCreate($name),$this->generateFormFieldsEdit($name)],
                $this->getStub("views/$view")
            );

            file_put_contents("$path/$view.blade.php", $viewTemplate);
        }
    }

    protected function generateRoutes($name)
    {
        $controllerName = $name . 'Controller';
        $modelNamePlural = \Illuminate\Support\Str::plural(strtolower($name));
        $modelNameSingularLower = strtolower($name);
    
        $routeTemplate = <<<EOT
    
    // Start {$controllerName} Routes
    Route::get('/{$modelNamePlural}', [App\Http\Controllers\\{$controllerName}::class, 'index'])->name('{$modelNamePlural}.index');
    Route::get('/{$modelNamePlural}/create', [App\Http\Controllers\\{$controllerName}::class, 'create'])->name('{$modelNamePlural}.create');
    Route::post('/{$modelNamePlural}', [App\Http\Controllers\\{$controllerName}::class, 'store'])->name('{$modelNamePlural}.store');
    Route::get('/{$modelNamePlural}/{{$modelNameSingularLower}}', [App\Http\Controllers\\{$controllerName}::class, 'show'])->name('{$modelNamePlural}.show');
    Route::get('/{$modelNamePlural}/{{$modelNameSingularLower}}/edit', [App\Http\Controllers\\{$controllerName}::class, 'edit'])->name('{$modelNamePlural}.edit');
    Route::put('/{$modelNamePlural}/{{$modelNameSingularLower}}', [App\Http\Controllers\\{$controllerName}::class, 'update'])->name('{$modelNamePlural}.update');
    Route::delete('/{$modelNamePlural}/{{$modelNameSingularLower}}', [App\Http\Controllers\\{$controllerName}::class, 'destroy'])->name('{$modelNamePlural}.destroy');
    // End {$controllerName} Routes
    
    EOT;
    
        $routesPath = base_path('routes/web.php');
        $routesContent = file_get_contents($routesPath);
    
        // Cek apakah sudah ada
        if (!str_contains($routesContent, "Start {$controllerName} Routes")) {
            File::append($routesPath, $routeTemplate);
        } else {
            // $this->info("Routes for {$controllerName} already exist!");
        }
    }
    


    protected function updateSidebar($name)
    {
        $tables = DB::select('SHOW TABLES');
        $tableNames = array_map(function($table) {
            return $table->$name;
        }, $tables);

        $sidebarTemplate = view('partials.sidebar', compact('tableNames'))->render();

        file_put_contents(resource_path('views/partials/sidebar.blade.php'), $sidebarTemplate);
    }

    protected function generateTableHeaders($name)
    {
        $table = Str::plural(strtolower($name));
        $columns = FacadesSchema::getColumnListing($table);
        $headers = array_diff($columns, ['id', 'created_at', 'updated_at', 'deleted_at']);
        
        $headerTemplate = "";
        foreach ($headers as $header) {
            $headerTemplate .= "<th>{{ str_replace('_', ' ', ucfirst('$header')) }}</th>";
        }
        $headerTemplate .= "<th>Aksi</th>";

        return $headerTemplate;
    }

    protected function generateTableData($name)
    {
        $table = Str::plural(strtolower($name));
        $columns = FacadesSchema::getColumnListing($table);
        $fields = array_diff($columns, ['id', 'created_at', 'updated_at', 'deleted_at']);
        
        $dataTemplate = "";
        foreach ($fields as $field) {
            $dataTemplate .= "<td>{{ \$$name->$field }}</td>";
        }
        $dataTemplate .= "<td>
            <a href=\"{{ route('{{modelNamePluralLowerCase}}.edit', \${{modelName}}->id) }}\" class=\"btn btn-warning\">Edit</a>
            <button type=\"button\" class=\"btn btn-danger\" data-toggle=\"modal\" data-target=\"#deleteModal{{ \${{modelName}}->id }}\" >Delete</button>

            <!-- resources/views/partials/delete-modal.blade.php -->

<!-- Delete Confirmation Modal -->
<div class=\"modal fade\" id=\"deleteModal{{\${{modelName}}->id}}\" tabindex=\"-1\" aria-labelledby=\"deleteModalLabel\" aria-hidden=\"true\">
    <div class=\"modal-dialog\">
        <div class=\"modal-content\">
            <div class=\"modal-header\">
                <h5 class=\"modal-title\" id=\"deleteModalLabel\">Confirm Delete</h5>
                <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
          <span aria-hidden=\"true\">&times;</span>
        </button>
            </div>
            <div class=\"modal-body\">
                Are you sure you want to delete this item: <strong>{{\${{modelName}}->id}}</strong> ?
            </div>
            <div class=\"modal-footer\">
                        <button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Close</button>

                <form id=\"deleteForm\" method=\"POST\" action=\"{{ route('{{modelNamePluralLowerCase}}.destroy', \${{modelName}}->id) }}\">
                    @csrf
                    @method('DELETE')
                    <button type=\"submit\" class=\"btn btn-danger\">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Script to set the action of the delete form dynamically
    function setDeleteAction(actionUrl) {
        document.getElementById('deleteForm').action = actionUrl;
    }
</script>

            
        </td>";

        $dataTemplate = str_replace(
            ['{{modelName}}', '{{modelNamePluralLowerCase}}'],
            [$name, strtolower(Str::plural($name))], $dataTemplate
        );

        return $dataTemplate;
    }

    protected function generateSearchableColumns($name)
    {
        $table = Str::plural(strtolower($name));
        $columns = FacadesSchema::getColumnListing($table);
        $searchable = array_diff($columns, ['id', 'created_at', 'updated_at', 'deleted_at']);
        
        return implode(", ", $searchable);
    }

    protected function getStub($type)
    {
        return file_get_contents(resource_path("stubs/$type.stub"));
    }
}
