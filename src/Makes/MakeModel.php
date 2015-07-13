<?php
/**
 * Created by PhpStorm.
 * User: fernandobritofl
 * Date: 4/22/15
 * Time: 10:34 PM
 */

namespace Trthanhbk\L5scaffold\Makes;


use Illuminate\Filesystem\Filesystem;
use Trthanhbk\L5scaffold\Commands\ScaffoldMakeCommand;

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
        if (! $this->files->exists($this->getRequestResource($name))) {
            $stub = $this->files->get(__DIR__ . '/../stubs/Requests/request.stub');
            $stub = str_replace('{{Class}}', $name, $stub);
            $this->files->put($this->getRequestResource($name), $stub);
        }

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

}