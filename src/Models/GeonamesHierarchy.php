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
 * Date: 06-Jul-16
 * Time: 11:30 AM
 */

namespace Yurtesen\Geonames\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Yurtesen\Geonames\Models\GeonamesHierarchy
 *
 * @property int $parent_id
 * @property int $child_id
 * @property string $type
 *
 * @method static \Illuminate\Database\Query\Builder|\Yurtesen\Geonames\Models\GeonamesHierarchy whereParentId($value)
 * @method static \Illuminate\Database\Query\Builder|\Yurtesen\Geonames\Models\GeonamesHierarchy whereChildId($value)
 * @method static \Illuminate\Database\Query\Builder|\Yurtesen\Geonames\Models\GeonamesHierarchy whereType($value)
 *
 * @mixin \Eloquent
 */
class GeonamesHierarchy extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = [];

    /**
     * The primary key for the model.
     */
    protected $primaryKey = 'parent_id';

    /**
     * Indicates if the IDs are auto-incrementing.
     */
    public $incrementing = false;

    /**
     * Indicates if the model should be timestamped.
     */
    public $timestamps = false;

    /**
     * Get the database connection for the model.
     */
    public function getConnectionName(): ?string
    {
        return config('geonames.connection');
    }
}
