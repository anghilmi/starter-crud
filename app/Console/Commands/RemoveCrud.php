<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class RemoveCrud extends Command
{
    protected $signature = 'rm:crud {name}';
    protected $description = 'Menghapus controller, model, views, dan route dari sebuah model CRUD';

    public function handle()
    {
        $name = $this->argument('name');
        $model = ucfirst($name);
        $controller = "{$model}Controller";
        $viewsFolder = strtolower(\Str::plural($name));
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

        // Hapus Folder Views
        if (File::exists($viewsPath)) {
            File::deleteDirectory($viewsPath);
            $this->info("Folder view {$viewsFolder} dihapus.");
        } else {
            $this->warn("Folder view tidak ditemukan.");
        }

        // Hapus Route dari web.php
        $routesPath = base_path('routes/web.php');
        $routeResource = "Route::resource('" . strtolower(\Str::plural($name)) . "',";
        $routeLine = collect(file($routesPath))->filter(fn($line) => str_contains($line, $routeResource));
        if ($routeLine->isNotEmpty()) {
            $content = file_get_contents($routesPath);
            foreach ($routeLine as $line) {
                $content = str_replace($line, '', $content);
            }
            file_put_contents($routesPath, $content);
            $this->info("Route resource untuk {$name} dihapus dari web.php.");
        } else {
            $this->warn("Route tidak ditemukan di web.php.");
        }

        $this->info("CRUD {$name} berhasil dihapus!");
    }
}
