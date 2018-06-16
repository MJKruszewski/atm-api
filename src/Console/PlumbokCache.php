<?php

namespace App\Console;

use App\Kernel;
use Plumbok\Command\CompileCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\ConsoleOutput;

/**
 * Class PlumbokCache
 * @package App\Console
 */
final class PlumbokCache
{

    const PLUMBOK_NAMESPACES = [
        'App\Entity',
        'App\Exceptions',
        'App\Controller\Dto'
    ];

    private const PLUMBOK_SOURCES = [
        'src/Entity',
        'src/Exceptions',
        'src/Controller/Dto'
    ];

    /**
     * @throws \Exception
     */
    public static function refreshCache(): void
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