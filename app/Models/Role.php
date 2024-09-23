<?php

namespace App\Models;

// use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\DB;
use App\Models\RoleAbility;

class Role extends Model
{
    use HasFactory;
     
    protected $fillable=['name'];

    public function abilities()
    {
        return $this->hasMany(RoleAbility::class);
    }

    protected  function createWithAbilites(HttpRequest $request)
    {
        DB::beginTransaction();
        try{
        $role=Role::create([
            'name'=>$request->post('name'),
        ]);

        foreach($request->post('abilities') as $ability =>$value)
        {
            RoleAbility::create([
                'role_id'=>$role->id,
                'ability'=>$ability,
                'type'=>$value,
            ]);
        }
        DB::commit();
    }catch(\Exception $e){
        DB::rollBack();
        throw $e;
    }
        return $role;

    }
// Make sure the method name is spelled correctly.
public function updateWithAbilities(HttpRequest $request)
{
    DB::beginTransaction();
    try {
        // Update the role name
        $this->update([
            'name' => $request->post('name'),
        ]);

        // Loop through abilities and update or create records
        foreach ($request->post('abilities') as $ability => $value) {
            RoleAbility::updateOrCreate([
                'role_id' => $this->id,
                'ability' => $ability, // Fixed to match the field name in your RoleAbility model
            ], [
                'type' => $value,
            ]);
        }

        DB::commit();
    } catch (\Exception $e) {
        DB::rollBack();
        throw $e;
    }

    return $this;
}


}
