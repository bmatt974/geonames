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

class Download extends Command
{
    use CommandTrait;

    protected $signature = 'geonames:download
                            {--update : Updates the downloaded files to latest versions}';

    protected $description = 'Download geonames database txt/zip files';

    public function handle(): void
    {
        $update = $this->option('update');
        $this->downloadAllFiles($update);
    }
}
