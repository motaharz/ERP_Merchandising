<?php


namespace App\Models\Order;


use App\Buyer;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';
    protected $primaryKey = 'id';

    public function elements()
    {
        return $this->hasMany(OrderElement::class,'order_id');
    }

    public function sizeQuantity()
    {
        return $this->hasMany(OrderSizeQuantity::class,'order_id');
    }

    public function buyer(){
        return $this->hasOne(Buyer::class, 'buyer_id');
    }
}
