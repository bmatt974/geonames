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
use Illuminate\Support\Facades\Schema;
use RuntimeException;

class Seed extends Command
{
    use CommandTrait;

    protected $signature = 'geonames:seed
                            {--refresh : Truncate tables and re-insert data from scratch}
                            {--update-files : Update geonames files before inserting data to database}
                            {--table= : Only import the given database table}';

    protected $description = 'Seed the database from geonames files';

    public function handle(): void
    {
        $updateFiles = $this->option('update-files');
        $refresh = $this->option('refresh');
        $table = $this->option('table');

        if (isset($table)) {
            foreach ($this->files as $name => $file) {
                if ($file['table'] == $table) {
                    $this->downloadFile($name, $updateFiles);
                    $this->parseGeonamesText($name, $refresh);

                    return;
                }
            }
            $this->line('<error>Table Not Found: </error> Table '.$table.'not found in configuration');

            return;
        } else {
            $this->downloadAllFiles($updateFiles);
            // Check if we have all the tables
            foreach ($this->getFilesArray() as $name => $file) {
                if (Schema::hasTable($file['table'])) {
                    $this->parseGeonamesText($name, $refresh);
                } else {
                    throw new RuntimeException($file['table'].' table not found. Did you run geoname:install then run migrate ?');
                }
            }
        }
        $this->line('<info>Finished : </info> Requested actions has been completed!');
    }
}
