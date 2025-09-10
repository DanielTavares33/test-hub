<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $project_id
 * @property int $test_run_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\ProjectTestRunFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectTestRun newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectTestRun newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectTestRun query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectTestRun whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectTestRun whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectTestRun whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectTestRun whereTestRunId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectTestRun whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProjectTestRun extends Model
{
    use HasFactory;
}
