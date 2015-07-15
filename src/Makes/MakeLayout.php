<?php
/**
 * Created by PhpStorm.
 * User: fernandobritofl
 * Date: 4/22/15
 * Time: 11:49 PM
 */

namespace Laraviet\L5scaffold\Makes;


use Illuminate\Filesystem\Filesystem;
use Laraviet\L5scaffold\Commands\ScaffoldMakeCommand;

class MakeLayout {
    use MakerTrait;

    public function __construct(ScaffoldMakeCommand $scaffoldCommand, Filesystem $files)
    {
        $this->files = $files;
        $this->scaffoldCommandObj = $scaffoldCommand;

        $this->start();
    }


    protected function start()
    {
        //Check Layout folder
        $this->makeDirectory($this->getLayoutFolder());

        //Check Libs folder
        $this->makeDirectory($this->getErrorDisplayResource());

        // Preparing html_assets
        if (! $this->files->exists($this->getAssetResource())) {
            $this->files->copyDirectory(__DIR__ . '/../stubs/html_assets/admins', $this->getAssetResource());
        }

        //Preparing Config
        if (! $this->files->exists($this->getConfigResource())) {
            $this->files->copy(__DIR__ . '/../stubs/Config/error_display.php', $this->getConfigResource());
        }

        //Prepare Libs
        if (! $this->files->exists($this->getErrorDisplayResource())) {
            $this->files->copy(__DIR__ . '/../stubs/Libs/ErrorDisplay.php', $this->getErrorDisplayResource());
        }
        //Prepare Libs
        if (! $this->files->exists($this->getValueHelperResource())) {
            $this->files->copy(__DIR__ . '/../stubs/Libs/ValueHelper.php', $this->getValueHelperResource());
        }

        // Preparing Error Display element views
        if (! $this->files->exists($this->getErrorDisplayViewResource())) {
            $this->files->copyDirectory(__DIR__ . '/../stubs/error_display', $this->getErrorDisplayViewResource());
        }

        if ($this->files->exists($path_resource = $this->getPathResource('layout'))) {
            if ($this->scaffoldCommandObj->confirm($path_resource . ' already exists! Do you wish to overwrite? [yes|no]')) {
                $this->putViewLayout($path_resource);

                $this->scaffoldCommandObj->info('Layout created successfully.');
            } else {
                $this->scaffoldCommandObj->comment('Skip Layout, because already exists.');
            }
        } else {
            $this->putViewLayout($path_resource);
        }


    }


    /**
     * @param $path_resource
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function putViewLayout($path_resource)
    {
        // Copy layout blade bootstrap 3 to resoures
        $layout_html = $this->files->get(__DIR__ . '/../stubs/html_assets/layout.stub');
        $this->files->put($path_resource, $layout_html);
    }



    /**
     * Get the path to where we should store the view.
     *
     * @return string
     */
    protected function getPathResource()
    {

            return './resources/views/layout/admin.blade.php';

    }

    protected function getLayoutFolder()
    {

        return './resources/views/layout';
    }

    protected function getAssetResource()
    {

        return './public/admins';
    }

    protected function getErrorDisplayResource() {
        return './app/Libs/ErrorDisplay.php';
    }

    protected function getValueHelperResource() {
        return './app/Libs/ValueHelper.php';
    }

    protected function getErrorDisplayViewResource() {
        return './resources/views/layout/error_display';
    }

    protected function getConfigResource() {
        return './config/error_display.php';
    }
}