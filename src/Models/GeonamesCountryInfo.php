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
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Yurtesen\Geonames\Models\GeonamesCountryInfo
 *
 * @property string $iso
 * @property string $iso3
 * @property string $iso_numeric
 * @property string $fips
 * @property string $country
 * @property string $capital
 * @property int $area
 * @property int $population
 * @property string $continent_code
 * @property int $continent_id
 * @property string $tld
 * @property string $currency_code
 * @property string $currency_name
 * @property string $phone
 * @property string $postal_code_format
 * @property string $postal_code_regex
 * @property string $languages
 * @property int $geoname_id
 * @property string $neighbors
 * @property string $equivalent_fips_code
 * @property-read \Yurtesen\Geonames\Models\GeonamesTimezone $timezone
 * @property-read \Yurtesen\Geonames\Models\GeonamesGeoname $continent
 *
 * @method static \Illuminate\Database\Query\Builder|\Yurtesen\Geonames\Models\GeonamesCountryInfo whereIso($value)
 * @method static \Illuminate\Database\Query\Builder|\Yurtesen\Geonames\Models\GeonamesCountryInfo whereIso3($value)
 * @method static \Illuminate\Database\Query\Builder|\Yurtesen\Geonames\Models\GeonamesCountryInfo whereIsoNumeric($value)
 * @method static \Illuminate\Database\Query\Builder|\Yurtesen\Geonames\Models\GeonamesCountryInfo whereFips($value)
 * @method static \Illuminate\Database\Query\Builder|\Yurtesen\Geonames\Models\GeonamesCountryInfo whereCountry($value)
 * @method static \Illuminate\Database\Query\Builder|\Yurtesen\Geonames\Models\GeonamesCountryInfo whereCapital($value)
 * @method static \Illuminate\Database\Query\Builder|\Yurtesen\Geonames\Models\GeonamesCountryInfo whereArea($value)
 * @method static \Illuminate\Database\Query\Builder|\Yurtesen\Geonames\Models\GeonamesCountryInfo wherePopulation($value)
 * @method static \Illuminate\Database\Query\Builder|\Yurtesen\Geonames\Models\GeonamesCountryInfo whereContinentCode($value)
 * @method static \Illuminate\Database\Query\Builder|\Yurtesen\Geonames\Models\GeonamesCountryInfo whereContinentId($value)
 * @method static \Illuminate\Database\Query\Builder|\Yurtesen\Geonames\Models\GeonamesCountryInfo whereTld($value)
 * @method static \Illuminate\Database\Query\Builder|\Yurtesen\Geonames\Models\GeonamesCountryInfo whereCurrencyCode($value)
 * @method static \Illuminate\Database\Query\Builder|\Yurtesen\Geonames\Models\GeonamesCountryInfo whereCurrencyName($value)
 * @method static \Illuminate\Database\Query\Builder|\Yurtesen\Geonames\Models\GeonamesCountryInfo wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\Yurtesen\Geonames\Models\GeonamesCountryInfo wherePostalCodeFormat($value)
 * @method static \Illuminate\Database\Query\Builder|\Yurtesen\Geonames\Models\GeonamesCountryInfo wherePostalCodeRegex($value)
 * @method static \Illuminate\Database\Query\Builder|\Yurtesen\Geonames\Models\GeonamesCountryInfo whereLanguages($value)
 * @method static \Illuminate\Database\Query\Builder|\Yurtesen\Geonames\Models\GeonamesCountryInfo whereGeonameId($value)
 * @method static \Illuminate\Database\Query\Builder|\Yurtesen\Geonames\Models\GeonamesCountryInfo whereNeighbors($value)
 * @method static \Illuminate\Database\Query\Builder|\Yurtesen\Geonames\Models\GeonamesCountryInfo whereEquivalentFipsCode($value)
 *
 * @mixin \Eloquent
 */
class GeonamesCountryInfo extends Model
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
    protected $primaryKey = 'iso';

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
     * Get the timezone for this country
     */
    public function timezone(): HasOne
    {
        return $this->hasOne(GeonamesTimezone::class, 'country_code');
    }

    /**
     * Get the continent for this country
     */
    public function continent(): HasOne
    {
        return $this->hasOne(GeonamesGeoname::class, 'geoname_id', 'continent_id');
    }
}
