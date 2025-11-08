<?php

/**
 *     This is free software: you can redistribute it and/or modify
 *     it under the terms of the GNU General Public License as published by
 *     the Free Software Foundation, either version 3 of the License, or
 *     (at your option) any later version.
 *
 *     This is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *     GNU General Public License for more details.
 *
 *     You should have received a copy of the GNU General Public License
 *     along with this.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * User: Evren Yurtesen
 * Date: 05-Jul-16
 * Time: 3:26 PM
 */

namespace Yurtesen\Geonames\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;

class Install extends Command
{
    protected $signature = 'geonames:install {--force : Overwrite any existing files.}';

    protected $description = 'Publish the migrations and config';

    public function __construct(protected Filesystem $files)
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $paths = ServiceProvider::pathsToPublish(
            'Yurtesen\Geonames\GeonamesServiceProvider'
        );

        foreach ($paths as $from => $to) {
            if ($this->files->isFile($from)) {
                $this->publishFile($from, $to);
            } elseif ($this->files->isDirectory($from)) {
                $this->publishDirectory($from, $to);
            }
        }

        $this->info('Installation complete!');
    }

    protected function publishFile(string $from, string $to): void
    {
        if (! $this->files->exists($to) || $this->option('force')) {
            $this->createParentDirectory(dirname($to));

            $this->files->copy($from, $to);

            $this->status($from, $to, 'File');
        }
    }

    protected function publishDirectory(string $from, string $to): void
    {
        $toContents = $this->files->files($to);
        $fromContents = $this->files->files($from);

        foreach ($fromContents as $file) {
            $newFile = $to.DIRECTORY_SEPARATOR.$this->files->name($file).'.'.$this->files->extension($file);
            if ($this->files->isFile($file) && (! in_array($newFile, $toContents) || $this->option('force'))) {
                $this->files->copy($file, $newFile);
            }
        }

        $this->status($from, $to, 'Directory');
    }

    protected function createParentDirectory(string $directory): void
    {
        if (! $this->files->isDirectory($directory)) {
            $this->files->makeDirectory($directory, 0755, true);
        }
    }

    protected function status(string $from, string $to, string $type): void
    {
        $from = str_replace(base_path(), '', realpath($from));

        $to = str_replace(base_path(), '', realpath($to));

        $this->line('<info>Copied '.$type.'</info> <comment>['.$from.']</comment> <info>To</info> <comment>['.$to.']</comment>');
    }
}
