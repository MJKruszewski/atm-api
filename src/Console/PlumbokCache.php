<?php

namespace App\Console;

use App\Kernel;
use Plumbok\Command\CompileCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class PlumbokCache
 * @package App\Console
 */
final class PlumbokCache
{

    const PLUMBOK_NAMESPACES = [
        'App\Entity',
        'App\Controller\Dto'
    ];

    private const PLUMBOK_SOURCES = [
        'src/Entity',
        'src/Controller/Dto'
    ];

    public static function refreshCache()
    {
        $application = new Application();
        $application->setAutoExit(false);
        $application->add(new CompileCommand());
        $kernel = new Kernel('dev', false);
        if (is_dir($kernel->getPlumbokCacheDir())) {
            $files = glob($kernel->getPlumbokCacheDir() . '/*');
            foreach ($files as $file) {
                unlink($file);
            }
        }
        if (!is_dir($kernel->getCacheDir())) {
            mkdir($kernel->getCacheDir());
        }
        if (!is_dir($kernel->getPlumbokCacheDir())) {
            mkdir($kernel->getPlumbokCacheDir());
        }
        foreach (self::PLUMBOK_SOURCES as $source) {
            $srcPath = $kernel->getProjectDir() . '/' . $source;
            $application->run(new StringInput("compile {$srcPath} {$kernel->getPlumbokCacheDir()}"), new ConsoleOutput());
        }
    }

}