<?php

/**
 * THIS CLASS IS ONLY TESTED IN UBUNTU(LINUX) SYSTEMS.
 * THIS CLASS CREATE OBSERVERS VIA ARTISAN CONSOLE.
 * 
 * @author Ajay Kumar  
 */

namespace AjayExpert\ObserverMaker;

use Illuminate\Console\Command;
use Exception;

class MakeObserver extends Command
{
    /**
     * Parent directory
     *
     * @var string
     */
    private $rootDir = 'app/Observers';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:observer {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new observer';


    protected $subDir = '';
    protected $fileName = '';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info($this->save());
    }

    /**
     * Make root directory "observer" if not exists
     *
     * @return void
     */
    private function makeRootDir()
    {
        if (!file_exists($this->rootDir)) {
            mkdir($this->rootDir, 0755);
        }

        $this->checkOrMakeSubDir();
    }

    public function checkOrMakeSubDir()
    {
        $dirs = explode('/', $this->argument('name'));
        if (count($dirs) > 1) {
            array_pop($dirs);
            $path = implode('/', $dirs);
            $this->subDir = $path;
            if (!file_exists($this->rootDir.'/'.$path)) {
                mkdir($this->rootDir.'/'.$path, 0755, 1);
            }
        }
    }

    public function getModelName()
    {
        return str_replace('Observer', '', $this->checkName());
    }

    /**
     * Create new observer
     *
     * @return mixed
     */
    private function save()
    {
        // generate root directory if not exists
        $this->makeRootDir();

        // generate observer path
        $observer = $this->generateName();

        // check if the new observer already exists
        if (file_exists($observer)) {
            throw new Exception('The observer "' . $observer . '" already exists.');
        }

        // create observer 
        file_put_contents($observer, $this->makeObserver());

        // check if observer was created
        if (!file_exists($observer)) {
            throw new Exception('The observer "' . $observer . '" already exists.');
        } else {
            return 'observer "' . $this->argument('name') . '" was created sucefully!';
        }
    }

    /**
     * Generate observer path
     *
     * @return string
     */
    private function generateName()
    {
        $name = strripos($this->argument('name'), DIRECTORY_SEPARATOR) != false ?: false;

        if ($name) {

            $path = '';
            $tree = explode('\\', $this->argument('name'));

            foreach ($tree as $index => $dir) {
                if ($index == count($tree) -1) {
                    continue;
                } else {
                    if (is_dir($this->rootDir . '/' . $path . ucfirst($dir))) {
                        throw new Exception('The directory "' . $dir . '" already exists.');
                    }
                    $path .= ucfirst($dir) . '/';
                }
            }

            $path = '';

            foreach ($tree as $index => $dir) {
                if ($index == count($tree) -1) {
                    $newName = ucfirst($dir);
                    continue;
                } else {
                    mkdir($this->rootDir . '/' . $path . ucfirst($dir), 0755);
                    $path .= ucfirst($dir) . '/';
                }
            }
            return $this->rootDir . '/' . $path . $newName . '.php';
        }
        return $this->rootDir . '/' . $this->argument('name') . '.php';
    }

    /**
     * Extract the correct name
     *
     * @return string
     */
    private function checkName()
    {
        $name = strripos($this->argument('name'), DIRECTORY_SEPARATOR) != false ?: false;

        if ($name) {
            $name = explode('\\', str_replace('/', '\\', $this->argument('name')));
            $name = $name[count($name) - 1];
        } else {
            $name = $this->argument('name');
        }
        return ucfirst($name);
    }



    /**
     * Return observer code
     *
     * @return string
     */
    private function makeObserver()
    {
        $namespace = 'App\Observers';
        if (strlen($this->subDir)) {
          $namespace .=  '\\'.str_replace('/', '\\', $this->subDir);
        }
        $useClass = $this->getModelName();
        return $code = sprintf(
'<?php 

namespace '.$namespace.';

use App\\'.$useClass.';

class %s 
{
    /**
     * Those are the names of the observable function  
     * 
     * @author Ajay Kumar
     */

    private $observableEventNames  = [
                "creating", "created", "updating", "updated",
                "deleting", "deleted", "saving", "saved",
                "restoring", "restored",
            ];



    /**
     * This is the example of creating observer function  
     *
     * You can use any function name which is listed in above array
     */

    public function creating('.$useClass.' $'.strtolower($useClass).' )
    {
        # code...
    }



}
', 
        $this->checkName());
    }



}
