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

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;

/**
 * Yurtesen\Geonames\Models\GeonamesGeoname
 *
 * @property int $geoname_id
 * @property string $name
 * @property string $ascii_name
 * @property string $alternate_names
 * @property float $latitude
 * @property float $longitude
 * @property string $feature_class
 * @property string $feature_code
 * @property string $country_code
 * @property string $cc2
 * @property string $admin1_code
 * @property string $admin2_code
 * @property string $admin3_code
 * @property string $admin4_code
 * @property int $population
 * @property int $elevation
 * @property int $dem
 * @property string $timezone_id
 * @property string $modified_at
 * @property-read \Yurtesen\Geonames\Models\GeonamesAlternateName $alternateName
 * @property-read \Yurtesen\Geonames\Models\GeonamesTimezone $timeZone
 * @property-read \Yurtesen\Geonames\Models\GeonamesCountryInfo $countryInfo
 *
 * @method static \Illuminate\Database\Query\Builder|\Yurtesen\Geonames\Models\GeonamesGeoname whereGeonameId($value)
 * @method static \Illuminate\Database\Query\Builder|\Yurtesen\Geonames\Models\GeonamesGeoname whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Yurtesen\Geonames\Models\GeonamesGeoname whereAsciiName($value)
 * @method static \Illuminate\Database\Query\Builder|\Yurtesen\Geonames\Models\GeonamesGeoname whereAlternateNames($value)
 * @method static \Illuminate\Database\Query\Builder|\Yurtesen\Geonames\Models\GeonamesGeoname whereLatitude($value)
 * @method static \Illuminate\Database\Query\Builder|\Yurtesen\Geonames\Models\GeonamesGeoname whereLongitude($value)
 * @method static \Illuminate\Database\Query\Builder|\Yurtesen\Geonames\Models\GeonamesGeoname whereFeatureClass($value)
 * @method static \Illuminate\Database\Query\Builder|\Yurtesen\Geonames\Models\GeonamesGeoname whereFeatureCode($value)
 * @method static \Illuminate\Database\Query\Builder|\Yurtesen\Geonames\Models\GeonamesGeoname whereCountryCode($value)
 * @method static \Illuminate\Database\Query\Builder|\Yurtesen\Geonames\Models\GeonamesGeoname whereCc2($value)
 * @method static \Illuminate\Database\Query\Builder|\Yurtesen\Geonames\Models\GeonamesGeoname whereAdmin1Code($value)
 * @method static \Illuminate\Database\Query\Builder|\Yurtesen\Geonames\Models\GeonamesGeoname whereAdmin2Code($value)
 * @method static \Illuminate\Database\Query\Builder|\Yurtesen\Geonames\Models\GeonamesGeoname whereAdmin3Code($value)
 * @method static \Illuminate\Database\Query\Builder|\Yurtesen\Geonames\Models\GeonamesGeoname whereAdmin4Code($value)
 * @method static \Illuminate\Database\Query\Builder|\Yurtesen\Geonames\Models\GeonamesGeoname wherePopulation($value)
 * @method static \Illuminate\Database\Query\Builder|\Yurtesen\Geonames\Models\GeonamesGeoname whereElevation($value)
 * @method static \Illuminate\Database\Query\Builder|\Yurtesen\Geonames\Models\GeonamesGeoname whereDem($value)
 * @method static \Illuminate\Database\Query\Builder|\Yurtesen\Geonames\Models\GeonamesGeoname whereTimezoneId($value)
 * @method static \Illuminate\Database\Query\Builder|\Yurtesen\Geonames\Models\GeonamesGeoname whereModifiedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Yurtesen\Geonames\Models\GeonamesGeoname admin1()
 * @method static \Illuminate\Database\Query\Builder|\Yurtesen\Geonames\Models\GeonamesGeoname addCountryInfo()
 * @method static \Illuminate\Database\Query\Builder|\Yurtesen\Geonames\Models\GeonamesGeoname city($name = null, $featureCodes = array())
 * @method static \Illuminate\Database\Query\Builder|\Yurtesen\Geonames\Models\GeonamesGeoname country($name = null, $featureCodes = array())
 * @method static \Illuminate\Database\Query\Builder|\Yurtesen\Geonames\Models\GeonamesGeoname searchByFeature($name = null, $feature_class = null, $featureCodes = null)
 *
 * @mixin \Eloquent
 */
class GeonamesGeoname extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = [];

    /**
     * The attributes that should be hidden for arrays.
     */
    protected array $hidden = [];

    /**
     * The primary key for the model.
     */
    protected string $primaryKey = 'geoname_id';

    /**
     * Indicates if the IDs are auto-incrementing.
     */
    public bool $incrementing = false;

    /**
     * Indicates if the model should be timestamped.
     */
    public bool $timestamps = false;

    /**
     * Useful columns to select in scopes
     */
    private array $usefulScopeColumns = [
        'geonames_geonames.geoname_id',
        'geonames_geonames.name',
        'geonames_geonames.country_code',
    ];

    /**
     * Get alternate names for this geoname
     */
    public function alternateName(): HasMany
    {
        return $this->hasMany(GeonamesAlternateName::class, 'geoname_id', 'geoname_id');
    }

    /**
     * Get timezone for this geoname
     */
    public function timeZone(): HasOne
    {
        return $this->hasOne(GeonamesTimezone::class, 'timezone_id', 'timezone_id');
    }

    /**
     * Get country info for this geoname
     */
    public function countryInfo(): BelongsTo
    {
        return $this->belongsTo(GeonamesCountryInfo::class, 'country_code', 'iso');
    }

    /**
     * Scope to add admin1 information
     */
    public function scopeAdmin1(Builder $query): Builder
    {
        $table = 'geonames_geonames';

        if (! isset($query->getQuery()->columns)) {
            $query = $query->addSelect($this->usefulScopeColumns);
        }

        $query = $query
            ->leftJoin('geonames_admin1_codes as admin1', 'admin1.code', '=',
                DB::raw('CONCAT_WS(\'.\','.
                    $table.'.country_code,'.
                    $table.'.admin1_code)')
            )
            ->addSelect(
                'admin1.geoname_id as admin1_geoname_id',
                'admin1.name as admin1_name'
            );

        return $query;
    }

    /**
     * Scope to add country information
     */
    public function scopeAddCountryInfo(Builder $query): Builder
    {
        $table = 'geonames_geonames';

        if (! isset($query->getQuery()->columns)) {
            $query = $query->addSelect($this->usefulScopeColumns);
        }

        $query = $query
            ->leftJoin('geonames_country_infos as country_info', $table.'.country_code', '=',
                'country_info.iso'
            )
            ->addSelect(
                'country_info.geoname_id as country_info_geoname_id',
                'country_info.country as country_info_country'
            );

        return $query;
    }

    /**
     * Scope to search cities
     */
    public function scopeCity(Builder $query, ?string $name = null, array $featureCodes = ['PPLC', 'PPLA', 'PPLA2', 'PPLA3']): Builder
    {
        return $this->scopeSearchByFeature($query, $name, 'P', $featureCodes);
    }

    /**
     * Scope to search countries
     */
    public function scopeCountry(Builder $query, ?string $name = null, array $featureCodes = ['PCLI']): Builder
    {
        return $this->scopeSearchByFeature($query, $name, 'A', $featureCodes);
    }

    /**
     * Scope to search by feature class and codes
     */
    public function scopeSearchByFeature(Builder $query, ?string $name = null, ?string $feature_class = null, ?array $featureCodes = null): Builder
    {
        $table = 'geonames_geonames';

        if (! isset($query->getQuery()->columns)) {
            $query = $query->addSelect($this->usefulScopeColumns);
        }

        if ($name !== null) {
            $query = $query->where($table.'.name', 'LIKE', $name);
        }

        $query = $query
            ->where($table.'.feature_class', $feature_class)
            ->whereIn($table.'.feature_code', $featureCodes);

        return $query;
    }
}
