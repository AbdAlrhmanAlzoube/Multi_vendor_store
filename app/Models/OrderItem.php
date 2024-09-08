<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderItem extends Pivot //extends Model //لما اعملو Pivot لارفيل لحالها بتفتؤض اسم الجدول نفس اسم المودل بس بالمفرد لهيك بدي اعالج الموصوع
{                              //من ميزاته كمان انو ما بحيط ال fillable لانو لحالو حاكطت guarded[]
    use HasFactory;
    
    public $timestamps=false; 

    protected $table='order_items';

    // protected $fillable=['order_id',''];


    public $incrementing = true; //ليش هيك عملنا لانو لما حطيتو Pivot لارفيل بتفتؤص البايمؤي كي هنن الفورن كي تبع جدولين الكسر لهيك برجع بقفل البرايمري  لارفيل لهلق ما بتاخد برايمري كي مصفوفة

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class)->withDefault(['name'=>$this->product_name]);
    }
}
