<?php
/**
 * Created by PhpStorm.
 * User: fernandobritofl
 * Date: 4/22/15
 * Time: 10:34 PM
 */

namespace Laraviet\L5scaffold\Makes;


use Illuminate\Filesystem\Filesystem;
use Laraviet\L5scaffold\Commands\ScaffoldMakeCommand;
use Laraviet\L5scaffold\Migrations\SchemaParser;

class MakeModel {
    use MakerTrait;

    public function __construct(ScaffoldMakeCommand $scaffoldCommand, Filesystem $files)
    {
        $this->files = $files;
        $this->scaffoldCommandObj = $scaffoldCommand;

        $this->start();
    }


    protected function start()
    {

        $name = $this->scaffoldCommandObj->getObjName('Name');
        $modelPath = $this->getPath($name, 'model');

        //Make Request
        $this->makeRequest($name);

        if (! $this->files->exists($modelPath)) {
            $this->scaffoldCommandObj->call('make:model', [
                'name' => $name
            ]);
        }

    }

    protected function getRequestResource($name)
    {

        return './app/Http/Requests/' . $name . 'Request.php';
    }

    protected function makeRequest($name) {
        if (! $this->files->exists($this->getRequestResource($name))) {

            $stub = $this->files->get(__DIR__ . '/../stubs/Requests/request.stub');
            $stub = str_replace('{{Class}}', $name, $stub);

            //Build default required validation rules
            if ($schema = $this->scaffoldCommandObj->option('schema')) {
                $schema = (new SchemaParser)->parse($schema);
            }
            $rules = "";
            if ($schema) {
                foreach ($schema as $field) {
                    $rules .= "\n" . str_repeat(' ', 12). "\"" . $field["name"] . "\" => " . "\"required\",";
                }
            }
            $stub = str_replace('{{rules}}', $rules, $stub);

            $this->files->put($this->getRequestResource($name), $stub);
        }
    }

}