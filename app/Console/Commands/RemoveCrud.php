<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class RemoveCrud extends Command
{
    protected $signature = 'rm:crud {name}';
    protected $description = 'Menghapus controller, model, views, dan routes dari sebuah CRUD.';

    public function handle()
    {
        $name = $this->argument('name');
        $model = ucfirst($name);
        $controller = "{$model}Controller";
        $viewsFolder = strtolower(\Illuminate\Support\Str::plural($name));
        $controllerPath = app_path("Http/Controllers/{$controller}.php");
        $modelPath = app_path("Models/{$model}.php");
        $viewsPath = resource_path("views/{$viewsFolder}");

        // Hapus Controller
        if (File::exists($controllerPath)) {
            File::delete($controllerPath);
            $this->info("Controller {$controller}.php dihapus.");
        } else {
            $this->warn("Controller tidak ditemukan.");
        }

        // Hapus Model
        if (File::exists($modelPath)) {
            File::delete($modelPath);
            $this->info("Model {$model}.php dihapus.");
        } else {
            $this->warn("Model tidak ditemukan.");
        }

        // Hapus Folder View
        if (File::exists($viewsPath)) {
            File::deleteDirectory($viewsPath);
            $this->info("Folder view {$viewsFolder} dihapus.");
        } else {
            $this->warn("Folder view tidak ditemukan.");
        }

        // Hapus Route Manual dari web.php
        $this->removeRoutes($name);

        $this->info("CRUD {$name} berhasil dihapus!");
    }

    protected function removeRoutes($name)
    {
        $controllerName = "{$name}Controller";
        $routesPath = base_path('routes/web.php');
        $routesContent = file_get_contents($routesPath);

        $pattern = "/\/\/ Start {$controllerName} Routes(.*?)\/\/ End {$controllerName} Routes/s";

        if (preg_match($pattern, $routesContent)) {
            $routesContent = preg_replace($pattern, '', $routesContent);
            file_put_contents($routesPath, $routesContent);
            $this->info("Routes untuk {$controllerName} dihapus dari web.php.");
        } else {
            $this->warn("Routes untuk {$controllerName} tidak ditemukan di web.php.");
        }
    }
}
