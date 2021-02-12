<?php

namespace Cerwyn\Laraser\Console;

use Cerwyn\Laraser\Laraser;
use Illuminate\Support\Facades\File;
use Illuminate\Console\Command;

class RemoveOldData extends Command
{
    protected $signature = 'laraser:remove';

    protected $description = 'Remove the Soft Deleted Data';

    public function handle()
    {
        if (!File::exists(config_path('laraser.php'))) {
            $this->error('Publish the configuration before running the command');
            return;
        }
        
        $this->info('Removing data...');

        $s = new Laraser();

        $s->handle();
        // $this->call('vendor:publish', [
        //     '--provider' => "JohnDoe\BlogPackage\BlogPackageServiceProvider",
        //     '--tag' => "config"
        // ]);
    }
}
