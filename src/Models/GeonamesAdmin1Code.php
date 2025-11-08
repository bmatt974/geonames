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
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Yurtesen\Geonames\Models\GeonamesAdmin1Code
 *
 * @property string $code
 * @property string $name
 * @property string $name_ascii
 * @property int $geoname_id
 * @property-read \Yurtesen\Geonames\Models\GeonamesGeoname $geoname
 * @property-read \Illuminate\Database\Eloquent\Collection|\Yurtesen\Geonames\Models\GeonamesHierarchy[] $hierarchies
 *
 * @method static \Illuminate\Database\Query\Builder|\Yurtesen\Geonames\Models\GeonamesAdmin1Code whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\Yurtesen\Geonames\Models\GeonamesAdmin1Code whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Yurtesen\Geonames\Models\GeonamesAdmin1Code whereNameAscii($value)
 * @method static \Illuminate\Database\Query\Builder|\Yurtesen\Geonames\Models\GeonamesAdmin1Code whereGeonameId($value)
 *
 * @mixin \Eloquent
 */
class GeonamesAdmin1Code extends Model
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
    protected $primaryKey = 'geoname_id';

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

    /**
     * Get the geoname for this admin1 code
     */
    public function geoname(): HasOne
    {
        return $this->hasOne(GeonamesGeoname::class, 'geoname_id', 'geoname_id');
    }

    /**
     * Get hierarchies where this is the parent
     */
    public function hierarchies(): HasMany
    {
        return $this->hasMany(GeonamesHierarchy::class, 'parent_id', 'geoname_id');
    }
}
