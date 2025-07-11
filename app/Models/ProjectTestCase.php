<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $project_id
 * @property int $test_case_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\ProjectTestCaseFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectTestCase newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectTestCase newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectTestCase query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectTestCase whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectTestCase whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectTestCase whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectTestCase whereTestCaseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectTestCase whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProjectTestCase extends Model
{
    use HasFactory;
}
