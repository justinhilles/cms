<?php

namespace Justinhilles\Cms;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Filesystem\Filesystem;
use Config;

class CmsInstallCommand extends Command {

    const PACKAGE = 'justinhilles/cms';

    protected $name = 'cms:install';

    protected $description = 'Install CMS';

    public function __construct()
    {
        parent::__construct();
    }

    public function fire()
    {
        $this->call('asset:publish', array('--bench' => self::PACKAGE));
        $this->call('migrate', array('--bench' => self::PACKAGE));        
    }
}